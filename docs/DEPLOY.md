# Cannabis Portal — Production Cutover Runbook

This runbook covers the **migration cutover** from local wp-env (with the willai-imported course) to production at `cannabis.cst.pr.gov`. It is intentionally narrower than `deployment.md`, which covers generic theme/plugin deploys.

> **Audience**: the engineer doing the cutover, with shell + WP-CLI access to prod.
> **Pre-req**: read `AUDIT.md` (P0 items) before starting.

---

## 0. Cutover prerequisites

- [ ] Maintenance window scheduled (≥ 60 min, off-peak)
- [ ] Full prod DB + uploads backup taken (`wp db export` + `tar` of `wp-content/uploads/`)
- [ ] Rollback plan written: which backup to restore, who runs it, ETA
- [ ] DNS TTL lowered to 300s ≥ 24h before cutover (if domain is changing)
- [ ] SSL cert valid for `cannabis.cst.pr.gov`
- [ ] WP-CLI works on prod (`wp core version`)
- [ ] Stakeholders notified (CST comms, content team)

---

## 1. Server prep

```bash
# Confirm versions
wp core version          # ≥ 6.4
php -v                   # ≥ 8.1
wp db check
```

Required PHP extensions: `gd`, `mbstring`, `intl`, `curl`, `dom`, `xml`, `zip`, `mysqli`, `sodium` (for `CST_Settings` encrypted API keys).

`wp-config.php` must contain:
```php
define( 'WP_DEBUG', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'AUTOMATIC_UPDATER_DISABLED', false );
```

---

## 2. Code deploy (theme + plugin)

```bash
# From your workstation
rsync -avz --delete \
  themes/cst-cannabis-portal/ \
  user@prod:/var/www/html/wp-content/themes/cst-cannabis-portal/

rsync -avz --delete \
  plugins/cst-core/ \
  user@prod:/var/www/html/wp-content/plugins/cst-core/
```

Then on prod:
```bash
wp theme activate cst-cannabis-portal
wp plugin activate cst-core
wp plugin install --activate \
  tutor \
  classic-editor \
  contact-form-7 \
  polylang \
  download-manager \
  elementor \
  premium-addons-for-elementor \
  wordpress-importer
```

> **Note**: pin specific versions where possible — list current local versions with `wp plugin list --format=csv` and reproduce exactly on prod.

---

## 3. Course content import (willai WXR)

The course (1 course post + 12 topics + 43 lessons + 12 quizzes + 131 attachments) ships via WXR.

```bash
# Copy the WXR file to the prod server
scp willai-export.xml user@prod:/tmp/

# Import (creates authors as needed, skips image resize)
wp import /tmp/willai-export.xml --authors=create --skip=image_resize
```

Verify counts:
```bash
wp post list --post_type=courses    --format=count   # expect 1
wp post list --post_type=topics     --format=count   # expect 12
wp post list --post_type=lesson     --format=count   # expect 43
wp post list --post_type=tutor_quiz --format=count   # expect 12
```

> **Known launch blocker** (per `CONTENT-REVIEW.md`): all 12 quizzes have empty `wp_tutor_quiz_questions` rows and all 12 topic bodies are empty. Coordinate with the willai team to either re-export with question data or rebuild manually before launch.

---

## 4. Tutor LMS configuration (P0-3 from audit)

Page IDs in `tutor_option` will not match between local and prod. Repoint them:

```bash
# Find the prod page IDs
DASH_ID=$(wp post list --post_type=page --name=dashboard --field=ID)
REG_ID=$(wp post list --post_type=page --name=student-registration --field=ID)
INST_ID=$(wp post list --post_type=page --name=instructor-registration --field=ID)

# Update Tutor options
wp option patch update tutor_option tutor_dashboard_page_id    "$DASH_ID"
wp option patch update tutor_option student_register_page      "$REG_ID"
wp option patch update tutor_option instructor_register_page   "$INST_ID"
```

Tutor monetization: free tier (no MonetizePro / WooCommerce hookup). Confirm:
```bash
wp option get tutor_option | grep -E 'monetize|enable_course_marketplace'
```

---

## 5. WordPress registration toggle (P0-2)

**Without this, the entire enrollment funnel silently fails.**

```bash
wp option update users_can_register 1
wp option update default_role subscriber
```

Verify by visiting `/student-registration/` in an incognito window — the form should render, not the "Acceso denegado" panel.

---

## 6. Permalinks + rewrite rules

```bash
wp rewrite structure '/%postname%/' --hard
wp rewrite flush --hard
```

---

## 7. URL search-replace

If the WXR export contains `https://curso-cannabis.willai.info` URLs in post content/meta:
```bash
wp search-replace \
  'https://curso-cannabis.willai.info' \
  'https://cannabis.cst.pr.gov' \
  --all-tables --skip-columns=guid --report-changed-only
```

---

## 8. CST plugin settings

```bash
# Director name + title for certificates
wp option update cst_director_name "<DIRECTOR_FULL_NAME>"
wp option update cst_director_title "<DIRECTOR_TITLE>"
# Signature + course seal: upload via wp-admin → Settings → CST Cannabis,
# the media uploader stores attachment IDs in cst_director_signature_id
# and cst_course_seal_id.

# Set theme mods if not carried over
wp theme mod set cst_email   'comunicaciones@cst.pr.gov'
wp theme mod set cst_phone   '787-721-4142'
```

The OpenAI / WhatsApp API keys, if used, are stored sodium-encrypted in `cst_settings`. Re-enter them via the admin UI on prod (do not copy ciphertext between environments — encryption nonce won't survive).

---

## 9. Polylang language setup

```bash
wp plugin activate polylang
# Add the two languages if not auto-detected
wp pll lang create --name=Español --slug=es --locale=es_PR --rtl=0 --term_group=0 --flag=pr --order=0
wp pll lang create --name=English --slug=en --locale=en_US --rtl=0 --term_group=0 --flag=us --order=1
```

---

## 10. Caching, security headers, performance

- [ ] `CST_Security` headers verified via `curl -I https://cannabis.cst.pr.gov/` — expect `Strict-Transport-Security`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, CSP
- [ ] Object cache (Redis/Memcached) connected if available
- [ ] Page cache (Cloudflare / WP Super Cache) configured to bypass `/wp-admin/`, `/student-registration/`, `/dashboard/`, logged-in cookies
- [ ] Compress `cst-logo.svg` to ≤ 30 KB (P0-1 from audit) before launch

---

## 11. Smoke tests (post-deploy)

Run these against prod before announcing launch:

| # | Path | Expected |
|---|------|----------|
| 1 | `/` | Hero video plays; pillar cards render |
| 2 | `/curso/` | "Regístrate" CTA → `/student-registration/` (logged out); "Ir al curso" (logged in) |
| 3 | `/student-registration/` | Tutor form renders, NOT "Acceso denegado" |
| 4 | `/courses/curso-cannabis/` | Course detail loads, 11 modules visible |
| 5 | `/dashboard/` (logged-in) | Dashboard tabs work |
| 6 | `/estadisticas/` | Charts render with real data + source links |
| 7 | `/recursos/` | Resource grid + filter tabs |
| 8 | `/contacto/` | Form submits; WhatsApp link works |
| 9 | `/accesibilidad/` | Statement renders, TOC populated |
| 10 | `/wp-json/cst/v1/statistics` | Returns 200 JSON |
| 11 | `?lang=en` switch | English variants render |
| 12 | Lighthouse | Performance ≥ 70, A11y ≥ 95, SEO ≥ 90 |
| 13 | Mobile (real device) | Hero video, sticky chat button, language pills |

Register a test student end-to-end and complete one lesson — confirms the Tutor flow works on prod.

---

## 12. DNS cutover

When all of the above passes:

1. Lower TTL (already done in §0 prereq)
2. Update DNS A/AAAA record at PRITS to the prod server
3. Watch error log + first few real users for 30 min
4. After 24h of clean traffic, raise TTL back to normal (3600s)

---

## 13. Rollback

If a smoke test fails post-DNS:

```bash
# Restore DB
wp db import /backups/cannabis-pre-cutover.sql

# Revert DNS to old target
# (via PRITS DNS console)

# Disable Tutor LMS to stop registrations
wp plugin deactivate tutor
```

Document **what failed** and **why** before re-attempting.

---

## 14. Post-launch hardening (within 7 days)

- [ ] Enable RankMath (P1-1, P1-2)
- [ ] Run grammar pass: `wp cst grammar-pass`
- [ ] Manual content review of lessons (per `CONTENT-REVIEW.md`)
- [ ] Build certificate generator (Task #11) — `tutor_course_complete_after` hook + dompdf
- [ ] Add 301 redirects for `/register/`, `/inscripcion/`, `/registro/` → `/student-registration/`
- [ ] Submit sitemap to Google Search Console + Bing
- [ ] Configure uptime monitoring (UptimeRobot / Pingdom)

---

## Appendix — Files this runbook references

- `docs/AUDIT.md` — P0/P1/P2 issues
- `docs/CONTENT-REVIEW.md` — content-side launch blockers
- `docs/deployment.md` — generic deployment guide (server, SSL, etc.)
- `docs/checklist-prits.md` — PRITS hosting requirements
