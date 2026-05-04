# Cannabis Portal — Site Audit

Date: 2026-05-04
Reviewer: automated walkthrough of public routes + WP admin + theme/plugin code on `localhost:8888` (mirrors prod content after WXR import).

Issues are tagged:

- **P0** — broken or blocks core flow
- **P1** — quality / polish that visibly affects users
- **P2** — nice-to-have / future

---

## P0 — Broken or production-blocking

### P0-1 — `cst-logo.svg` is **1.1 MB**
The institutional shield in the header weighs 1.1 MB. SVGs that large almost always contain raster bitmaps embedded as base64 (likely a scanned/exported PNG). Every page on the site loads this. Estimated yearly bandwidth on a `.pr.gov` portal at this size = significant.

**Fix**: open in Inkscape / SVGOMG, replace the embedded raster with vector paths, target ≤30 KB. If the design genuinely needs a photo of the seal, switch to a PNG @ 80 KB max + `<picture>` source.

### P0-2 — `users_can_register=0` on production will silently break registration
The `[tutor_student_registration_form]` shortcode renders an "Acceso denegado" panel when WP's master "Anyone can register" toggle is off. We hit this on local. **Production must have this set or the entire enrollment funnel is dead** with no visible error.

**Fix**: in the deploy doc, mandate `wp option update users_can_register 1` and `wp option update default_role subscriber`. Better still, make `cst-core` enforce both on plugin activation.

### P0-3 — Tutor LMS settings (page IDs) won't carry over from local
`tutor_option[tutor_dashboard_page_id|student_register_page|instructor_register_page]` are stored in `wp_options`. After a WXR import on prod the page IDs will differ; if these aren't repointed, the dashboard/registration redirects 404.

**Fix**: include this in the deploy checklist OR write a one-time admin notice in `cst-core` that detects missing/stale IDs.

### P0-4 — Course landing has only one H1
Every page has exactly one H1 ✓ (verified on `/`, `/curso/`, `/estadisticas/`, `/tutor-login/`). **Not an issue currently** — flagged here only to confirm.

---

## P1 — Polish & quality

### P1-1 — Homepage missing `<meta name="description">`
SEO basics. `wp_head` emits everything except a description meta tag. Yoast or RankMath would normally fill this; we have neither.

**Fix**: either install RankMath (free, ~5 min) OR add a 4-line theme function that emits `<meta name="description" content="...">` per-page from `get_the_excerpt()`/customizer. Recommend RankMath since it'll also handle Open Graph cards and a sitemap properly.

### P1-2 — `/sitemap.xml` returns 301
WP doesn't generate one by default and the redirect is cosmetic. Search engines won't crawl this efficiently.

**Fix**: same as P1-1 — RankMath or Yoast handles it. Otherwise enable WP core sitemap (`yoast_seo` or `wpseo_xml_sitemap_index`).

### P1-3 — Homepage loads **35 stylesheets/scripts**
Counting `<link rel=stylesheet>` + `<script>` on `/`. Heavy contributors: GeneratePress + child theme + Tutor LMS + Elementor + Premium Addons + Polylang + CF7 + Chart.js + chatbot + statistics + dashicons + Google Fonts. Total page weight 115 KB markup; with assets it's likely 1.5–2 MB on first load.

**Fix prioritized**:
1. Don't load Elementor frontend assets on pages that don't use Elementor (Elementor Settings → Advanced → "Optimized DOM Output" + "Improved CSS Loading"). Saves ~300 KB.
2. Defer Chart.js — only `/estadisticas/` needs it. Currently it may be enqueued globally; gate behind `is_page_template('template-statistics.php')`.
3. Lazy-load the chatbot iframe — it's bottom-fixed and not visible until clicked.

### P1-4 — Hero video (2 MB) downloaded eagerly
`<video preload="metadata">` is correct, but on slow connections the LCP image (poster `hero-bg.jpg`, 275 KB) competes for bandwidth.

**Fix**: serve a smaller WebP poster (~50 KB) and gate the video load with `loading="lazy"`-equivalent (`preload="none"` + IntersectionObserver to start playback when visible).

### P1-5 — `/curso/` H1 is too long for semantic clarity
Current: *"Recurso Educativo Gratuito de la Comisión para la Seguridad en el Tránsito"* (74 chars). Search engines prefer ≤60 char H1s.

**Fix**: shorten to *"Curso de Cannabis Medicinal y Seguridad Vial"* and put the longer descriptive sentence as a smaller subtitle/lede underneath.

### P1-6 — Mock certificate visible on `/curso/`
`section-course-footer-cta.php` renders a fake certificate card with placeholder name "Juan del Pueblo" and "Fecha: DD/MM/AAAA". Without context that looks like a system bug.

**Fix**: either remove it OR make it clearly a "vista previa" example with explicit *Ejemplo* watermark. Once the real PDF generator is built (Task #11) this becomes a thumbnail of the actual generated cert.

### P1-7 — Footer CTA section title duplicates page H1
`section-course-footer-cta.php` has `<h2>Curso de Cannabis Medicinal y Seguridad Vial</h2>` and the hero already covers that. Redundant.

**Fix**: change the H2 to something more action-oriented like *"Inscríbete y obtén tu certificado"* (already used inside the enroll block), or drop the heading and let the enroll-block's own H3 carry it.

### P1-8 — `404` on non-existent registration paths
`/register/`, `/inscripcion/`, `/registro/` all 404. Users may guess these. Search results may also still index old paths from willai.

**Fix**: add 301 redirects to `/student-registration/` via `template_redirect` action OR a small `cst-core` redirect map.

### P1-9 — Sabías Que widget pulls a hardcoded fact list
`sidebar.php` has 7 facts hardcoded. To update copy, an editor needs a developer.

**Fix**: convert to a `cst_did_you_know` CPT or a single options-page list so non-devs can curate.

### P1-10 — No clear way for non-CST staff to update statistics
Statistics are CPT-driven (good), but the source URL field was just added — admins won't know the new field exists. Also `_cst_stat_chart_data` is a raw JSON textarea, easy to corrupt.

**Fix**: replace the JSON field with a repeatable label/value field group via ACF Free OR a simple in-admin chart builder. Add an inline help paragraph at the top of the metabox with an example.

### P1-11 — English (`/en/`) translations are partial
Polylang is active but the homepage hero, pillar cards, footer, FAQ, and many strings only exist in Spanish. `/en/home/` 301s but the content is the same as ES on most pages.

**Fix**: produce a translation pass via Polylang strings interface OR `.po`/`.mo` files for the cannabis theme + cst-core. Estimate: 200–250 strings, 2 hours of focused work.

### P1-12 — Hero video repeats the entire 10-second clip
Short loop is fine, but the cut at the loop point may feel jarring depending on the source. Consider crossfading or picking a clip with seamless loop.

**Fix**: ffmpeg pass that produces a "loop boundary" (concat last second back to start with a 0.5s xfade) — I can do this anytime.

### P1-13 — Mobile audit not yet done
We've only verified desktop layouts. The hero video, the institutional header (especially with the "Portal Cannabis y Seguridad en el Tránsito" title shifted right), the pillar cards, and the language switcher all need a phone-resolution check.

**Fix**: open Chrome DevTools mobile emulator at 375px and 768px on `/`, `/curso/`, `/estadisticas/`, `/tutor-login/`. Probably 4–5 small CSS fixes.

---

## P2 — Future / nice-to-have

### P2-1 — No certificate PDF generator yet
Settings UI shipped (director name, signature image, course seal). The actual `tutor_course_complete_after` hook → dompdf → public verification page is not built. *Tracked separately as Task #11.*

### P2-2 — No dispensary map
Asked for, blocked on JRCM data source. *Tracked separately.*

### P2-3 — Production deploy checklist missing
We've discussed it inline but there's no `docs/DEPLOY.md`. *Tracked as Phase E in original plan.*

### P2-4 — Three "trust strip" + "course features" sections may be redundant with new pillar cards
`section-trust-strip.php`, `section-objectives.php`, `section-course-features.php`, and the new `section-course-pillars.php` all live on the homepage. There's content overlap.

**Fix**: pick two of the four and remove the others. Or A/B test.

### P2-5 — Chatbot is enabled by default but the LLM endpoint isn't configured
`cst_chatbot_enabled` defaults to `true` but `cst_chatbot_api_endpoint` is empty. Clicking the bottom-left bubble probably shows a useless empty state.

**Fix**: default `cst_chatbot_enabled` to `false`, OR show an "instructor configuration pending" message instead of a broken UI.

### P2-6 — Statistics dashboard "PR fatalities" series shows zeroes
We seeded the slot with `value: 0` because CST internal numbers should come from your team. Currently the chart renders empty — confusing for visitors.

**Fix**: hide series whose values are all 0, OR display "Datos próximamente — fuente: cst.pr.gov/estadisticas".

### P2-7 — Admin notice on activation
`cst-core` activates silently. A first-run admin notice walking the admin through: settings page → director signature → seed-statistics command → site icon would reduce setup errors.

### P2-8 — REST API has no rate limiting
`/wp-json/cst/v1/statistics` is open to the world (`permission_callback: __return_true`). Fine for public stats but worth a 60-req-per-minute cap to prevent scrape abuse.

### P2-9 — Backup .bak files in repo history
Already cleaned from working tree. Worth scrubbing from git history with `git filter-repo` if any sensitive data ever lands. Not urgent.

---

## Quick wins (≤30 min each)

| # | Win | Effort |
|---|---|---|
| P0-1 | Optimize `cst-logo.svg` (1.1 MB → ≤30 KB) | 15 min |
| P1-1 | Install RankMath, configure | 10 min |
| P1-3.1 | Toggle Elementor "Optimized DOM Output" | 2 min |
| P1-7 | Change footer-cta H2 wording | 2 min |
| P1-8 | Add `/register/` → `/student-registration/` redirect | 10 min |
| P2-5 | Default `cst_chatbot_enabled` to `false` | 1 min |

---

## Things working well

- Single H1 per page, semantic heading hierarchy is clean.
- Zero images without `alt` on the homepage (audited 2 visible imgs).
- Polylang correctly emits `hreflang` and the language switcher works.
- Chart.js loads with CSP nonce — solid security posture.
- Sodium-encrypted API key storage in `CST_Settings` is best-practice.
- WP-CLI seeders + WXR import are well-structured for repeat dev environments.
- All sourced statistics now have clickable provenance links to JRCM/NHTSA/AAA.
- Government banner from PRITS is correctly present at the top of every page.

---

## Recommended fix order

1. **P0-2** + **P0-3** — bake the `users_can_register` + Tutor page-ID requirements into `cst-core` activation OR a deploy doc, before going to production.
2. **P0-1** — strip the 1.1 MB SVG.
3. **P1-1** + **P1-2** — install RankMath. One install solves SEO, sitemap, and OG cards.
4. **P1-3.1** + **P1-4** — Elementor optimize toggle + WebP poster + `preload="none"`.
5. **P1-6** + **P1-7** — clean up the mock certificate / duplicate H2.
6. **P1-11** — English translation pass.
7. **P2-1** — certificate generator (Task #11 in queue).
