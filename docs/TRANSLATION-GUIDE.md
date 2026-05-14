# Translating the CST Cannabis Portal

The portal ships in Spanish (source) and English (translated). Two layers
of content need translation, and each follows a different process.

## 1. UI strings — `themes/cst-cannabis-portal/languages/`

Every button, menu label, form field, and snippet of body copy that the
theme or plugin emits via `__()` / `_e()` / `esc_html__()` lives here.

- **Source:** `cst-cannabis-en_US.po` (theme) and
  `plugins/cst-core/languages/cst-core-en_US.po` (plugin).
- **Workflow:** edit the `.po` file directly or in a tool like Poedit.
  Each entry's `msgstr ""` is what English visitors see.
- **Compile:** `msgfmt cst-cannabis-en_US.po -o cst-cannabis-en_US.mo`.
  WordPress reads the `.mo` at runtime; the `.po` is the editable source.
- **Status:** currently complete. Run
  `grep -c 'msgstr ""' cst-cannabis-en_US.po` and confirm `0` (header
  entry excluded) before any release.

## 2. Course + page content — Polylang post duplicates

Polylang stores each translatable post once per language with its own
ID. The original (Spanish) and the translation (English) are linked
together so the language switcher hops between them, but their bodies
must be authored separately.

| Post type | Status | What's missing |
|-----------|--------|----------------|
| `page` | Mostly translated | None for the existing pages. The four legal pages added by `CST_Content_Seeder` (privacy / terms / cookies / accessibility) are Spanish drafts only — English copies still need to be created and linked via Polylang once the Spanish legal review is signed off. |
| `post` (blog) | Per-author | Whoever publishes a Spanish article needs to create the EN translation post and link it via the Polylang sidebar. |
| `cst_resource` | Per-author | Same as blog. |
| `cst_faq` | ✓ Both languages | Keep parity when adding new FAQs. |
| `cst_statistic` | Single language | Numeric KPIs are language-neutral; only the title + source attribution may need an EN duplicate. |
| `courses` (Tutor LMS) | **Spanish only** | See §3. |
| `lesson` (Tutor LMS) | **Spanish only** | See §3. |

### Authoring an English translation

1. Edit the Spanish post.
2. In the right-hand Polylang sidebar, click **Add new** next to "English".
3. Author the English title + body.
4. Publish. Polylang auto-links the two posts.
5. The chatbot knowledge base reflects the new translation on the next
   transient flush (any save_post on `cst_faq`, `courses`, or `lesson`
   clears it automatically).

## 3. Tutor LMS course — the hard one

Tutor LMS free does **not** natively translate course/lesson content.
The chatbot context module already includes the fallback that resolves
each lesson's translation via `pll_get_post()` (see
`CST_Chatbot_Context::get_course_content()`), so if you create
English-language duplicate `lesson` posts and link them via Polylang's
sidebar, they show up to EN visitors.

What's blocking actually shipping the EN course:

- A professional translator pass on the seven Spanish lessons.
- Replacement video voice-over (or English subtitles on the existing
  Spanish video).
- A separate English-named "courses" post linked to the Spanish original.

Track that work in your project board as a single epic. Until it's done,
the EN site should either (a) display a "course content is being
translated" notice on the English `/curso/` page or (b) redirect EN
visitors to the Spanish course with a banner. The seeder's accessibility
statement template already cites translation work as a known limitation.

## 4. Polylang gotchas

- **String translations** (theme-mod values like `cst_email`, social
  URLs, site tagline) live under *Languages → String translations* in
  WP admin, not in the `.po` file. Translate them there.
- **URL slug:** the EN duplicate of `/curso/` should have slug `/course/`,
  not `/curso/`, so screen readers pick up the language change.
- **`pll_get_post_translations`** returns `[]` for posts created before
  Polylang was registered for that post type. If a CPT looks
  un-translated after enabling translation on it, edit each existing
  post and re-save to populate Polylang's internal mapping.

## 5. Verification before release

1. Switch the language toggle to English on every page in
   `docs/checklist-prits.md`.
2. Compare against the Spanish version — any mixed-language string is a
   bug to file against the i18n category.
3. Confirm the `<html lang>` attribute matches the visible content
   (`document.documentElement.lang === 'en-US'` in EN mode).
4. Smoke-test the chatbot in both languages with a course-specific
   question.

---

*Maintained alongside `docs/RUNBOOK.md`. Bump on every translation pass.*
