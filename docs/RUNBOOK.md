# CST Cannabis Portal — Operations Runbook

Audience: whoever owns this site after handoff (PRITS, internal CST staff, or a
contractor). Read top-to-bottom on day one; bookmark the **Incident Response**
and **Rollback** sections.

---

## 1. What this repo deploys

| Path | Lives on Bluehost as | Notes |
|------|----------------------|-------|
| `themes/cst-cannabis-portal/` | `/wp-content/themes/cst-cannabis-portal/` | GeneratePress child theme |
| `plugins/cst-core/` | `/wp-content/plugins/cst-core/` | Bootstraps every `CST_*` module |
| `migration/` | n/a | One-time migration scripts. Never re-run blindly |

WordPress core, `wp-config.php`, the database, and uploads live on Bluehost and
are **not** in this repo. Do not check `wp-config.php` into git.

## 2. Deploying

Two paths exist; pick one and stick to it.

### a) Continuous (`./watch.sh`)
1. From `~/projects/cst-portals/`, run `./watch.sh` once — it stays running and
   re-uploads any saved file via lftp/FTPS.
2. Credentials are read from `~/projects/cst-portals/.bluehost.env` (chmod 600,
   gitignored). Rotate the FTPS password through Bluehost cPanel ➔ FTP Accounts
   if it's ever shared.
3. To stop watching: Ctrl-C. The script never writes to the DB.

### b) Manual (`./deploy.sh`)
- One-shot rsync over the same FTPS channel. Use when you've made a batch of
  changes locally and want a single deploy boundary.
- Run after a fresh `git pull` so a teammate's work isn't lost.

> **Do not** edit files directly in Bluehost File Manager — the next `watch.sh`
> sync will overwrite them.

## 3. Required `wp-config.php` constants (production)

SSH into Bluehost, edit `~/public_html/wp-config.php`, ensure these are set
above the `That's all, stop editing!` line:

```php
// Hardening.
define( 'DISALLOW_FILE_EDIT',  true );  // No theme/plugin editor in /wp-admin.
define( 'DISALLOW_FILE_MODS',  true );  // No plugin install/update from UI.
define( 'FORCE_SSL_ADMIN',     true );  // Cookies only over HTTPS.

// Error visibility — log but never display.
define( 'WP_DEBUG',         true );
define( 'WP_DEBUG_LOG',     '/home/<USER>/logs/wp-debug.log' );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Cron — rely on a real cron job (see §5) instead of pageviews.
define( 'DISABLE_WP_CRON', true );

// Auto-updates — security only.
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
```

Replace `<USER>` with the cPanel username. Confirm the log path is **outside**
`public_html/`. Tail with `ssh ... 'tail -f ~/logs/wp-debug.log'`.

## 4. Backups

| Layer | Tool | Cadence | Verified by |
|-------|------|---------|-------------|
| Database | Bluehost JetBackup ➔ Daily DB snapshot | Daily, 14-day retention | Manual restore test every 90 days |
| Files | Bluehost JetBackup ➔ Daily account snapshot | Daily, 14-day retention | Cross-check size in cPanel |
| Code | This git repo | Per-commit on `main` | `git log --oneline` |

**Restore drill** — pick a non-production day, restore a snapshot to the
Bluehost staging subdomain, run `wp core verify-checksums` and the smoke
checklist in §6. Note any drift in `docs/restore-drills.md`.

## 5. Cron

Replace WP-Cron with a real one. cPanel ➔ Cron Jobs ➔ Add Cron Job:

```
*/15 * * * *  curl -s https://bis.eyh.mybluehost.me/wp-cron.php?doing_wp_cron > /dev/null 2>&1
```

If `DISABLE_WP_CRON` (§3) is set, this is the only thing keeping Polylang
translations, Tutor LMS notifications, and our chatbot transient cleanups from
piling up.

## 6. Smoke test after every deploy

Run in order — should take 90 seconds:

1. Load `/` → hero renders, no console errors, language switcher visible.
2. Switch to EN → URL changes to `/en/`, hero text is English, footer links work.
3. Load `/curso/` (or `/en/course/`) → CTA reaches the Tutor LMS course page.
4. Submit the contact form with a test message → CF7 success state, message
   arrives at `cst_email`.
5. Open the chatbot widget → toggle, send a known FAQ question, get a reply.
6. View `/?s=cannabis` → branded search results page renders.
7. Visit `/nope-this-page-doesnt-exist` → branded 404 with CTA buttons.
8. DevTools ➔ Network: confirm Content-Security-Policy and Strict-Transport-
   Security headers are present on a doc response.

## 7. Rollback

Code-level (most likely):

```bash
cd ~/projects/cst-portals
git log --oneline -n 20                 # find the last good commit
git checkout <sha> -- themes/cst-cannabis-portal/ plugins/cst-core/
./deploy.sh
```

Database-level (rare — only after a destructive migration):

1. Bluehost cPanel ➔ JetBackup ➔ Database Backups ➔ pick the timestamp ➔
   *Restore*.
2. Run the smoke test (§6) immediately afterwards.
3. If users registered during the window between snapshot and now, manually
   re-create them from email notifications (or accept the data loss — document
   the call).

## 8. Secret rotation

Every 180 days, or after staff departure:

- Bluehost cPanel password
- FTPS account password (then update `.bluehost.env`)
- WP admin password
- LLM API key in CST Settings (when wired)
- WP salts via `wp config shuffle-salts`

Log each rotation in `docs/secret-rotation.md` with date and rotator initials.

## 9. Incident response

| Symptom | First check | Likely fix |
|---------|-------------|-----------|
| Site returns 500 | `~/logs/wp-debug.log` last 200 lines | Roll back last deploy via §7 |
| White screen | Same | Same |
| Login locked out | Wait 30 min OR `wp transient delete --all` | CST_Login_Throttle threshold |
| Chatbot stops responding | Browser console + `wp_remote_post` log | Check API key, endpoint URL allow-list |
| CSP violations in console | DevTools console | Add origin to `class-cst-security.php` |

## 10. Escalation contacts

- **CST Comunicaciones** — `comunicaciones@cst.pr.gov`
- **OIG hotline** — 787-679-7979
- **PRITS** — `info@prits.pr.gov` for `.pr.gov` migration questions
- **Bluehost support** — cPanel ➔ Help ➔ Chat

---

*Last reviewed: 2026-05-14. Bump this date on every material change.*
