# CST Cannabis Course — Spanish Content Review (Puerto Rico)

**Scope:** Tutor LMS course "Curso de Cannabis y Conducción Segura" (post 576, slug `curso-cannabis`) imported from `curso-cannabis.willai.info` into the local wp-env.

**Read-only review.** No content was modified. Findings are organized by category and by post so an editor (or a scripted pass) can apply fixes safely.

---

## Summary

- **Posts inspected:** 67 total
  - 43 `lesson` (all reviewed)
  - 12 `topics` (modules; `post_content` is empty for all of them — only titles reviewed)
  - 12 `tutor_quiz` (`post_content` empty; `wp_tutor_quiz_questions` table contains **0 rows** — quizzes have no question content yet, so nothing to grammar-check there)
- **Total distinct issues flagged:** ~95 across the 43 lessons (some appear in multiple posts).
- **Severity counts (estimate):**
  - **High** (factual / legal / orthographic errors): ~15
  - **Medium** (consistency, typography, register): ~55
  - **Low** (style polish, anglicism flags, optional rewrites): ~25

### Top 5 most common issue types

1. **Inconsistent dash glyph in law citations and acronyms.** Some posts write `Ley 22‑2000` / `DSM‑5` with a non-breaking hyphen (U+2011), others write `Ley 22-2000` / `DSM-5` with a regular hyphen. Both occur in the same course. (lessons 84, 85, 91, 286, 287, 309, 605 vs. 299, 308, 542, 546, 554)
2. **Straight ASCII double quotes** (`"…"`) used for emphasis where Spanish convention is **«…»** or curly **""**. Heavy use in lessons 87, 296, 543, 545, 546, 548, 550, 555.
3. **Title-case ("Spanish in English-style capitalization")** in module/lesson titles ("Tu Salud es la Prioridad", "Marco Legal: Prohibiciones y Sanciones", "Empleos Sensitivos y Marco Legal Laboral"). Spanish only capitalizes the first word and proper nouns.
4. **Untranslated anglicisms without italics:** *ride‑hailing*, *ridesharing*, *'ride'*, *checklist*, *apps*, *Screening, Brief Intervention, and Referral to Treatment*. None are wrapped in `<em>` / italics, which Spanish style guides (RAE/Fundéu) require for foreign words.
5. **Run-on / over-padded sentences** in the AI-generated "Cierre de Módulo" lessons and module 8/9/10 expansions — content is grammatically correct but violates the CST register (slightly formal, concise).

### Notably good posts

- `lesson_605` (Lección 1.2: Definiciones), `lesson_606` (2.1), `lesson_88` (7.1), `lesson_91` (10.1) — clean, concise, register-appropriate.
- `lesson_543` (Cierre Módulo 2), `lesson_546` (Cierre Módulo 4), `lesson_551` (Cierre Módulo 8) — well-written summaries; only typography fixes needed.

### Notably problematic posts

- **`lesson_285` (Lección 1.1)** — only post that *opens* with a question without `¿` because the structure is `<strong>¿Por qué este curso?</strong>` followed by a phrase with no period before "Marco legal de PR…"; the second paragraph has a semicolon then a capitalized fragment ("; Estas normativas…") which should be a period or a colon.
- **`lesson_300` (Lección 8.4)** — wrapped in stray Gemini/AI output markup (`<div id="model-response-message-contentr_d8993c7eb496de82" class="markdown markdown-main-panel stronger enable-updated-hr-color" dir="ltr" aria-live="polite">…</div>`). This is leaked tooling chrome and must be stripped.
- **`lesson_297` (Lección 7.2)** — uses curly single quotes for an English borrow `'ride'` mid-sentence, plus a comma splice ("Ejemplo práctico: cena con una copa de vino y dosis oral horas antes: bloquea conducir y coordina 'ride' o transportación").
- **`topics` post 618** — title literally ends in a stray `4`: *"Módulo 1 — ¿Por qué este curso? (Introducción y objetivos) 4"*.

---

## Per-post findings

> Text in quotes is the exact offending phrase. `→` shows the suggested replacement. Quote characters in the markdown are normalized for readability.

### `topics` (modules — only titles)

- **618** *Módulo 1 — ¿Por qué este curso? (Introducción y objetivos) 4*
  - `"...(Introducción y objetivos) 4"` → `"...(Introducción y objetivos)"` — stray trailing `4`, almost certainly an editor artifact. **High.**
- **619** *Módulo 2 — Efectos del cannabis en la conducción (neuropsico‑funcionales)*
  - `"neuropsico‑funcionales"` → `"neuropsicofuncionales"` (single closed compound; the prefix `neuropsico-` doesn't take a hyphen in Spanish). **Medium.**
- **620** *Módulo 3 — Tiempos de espera y plan de movilidad segura* — OK.
- **621** *Módulo 4 — Marco legal en Puerto Rico (Ley 22‑2000 + Ley 42‑2017 / reglamento)*
  - Inconsistent dash: uses U+2011 here while other posts use plain `-`. Pick one (recommend plain `-` for searchability). **Low.**
  - `"reglamento"` → `"Reglamento 9038"` (be specific; matches `lesson_285`). **Medium.**
- **622** *Módulo 6 — Señales de afectación y pruebas de campo (SFST)* — OK (acronym is defined elsewhere).
- **623** *Módulo 7 — Policonsumo y situaciones de riesgo* — OK.
- **624** *Módulo 8 — Empleos sensitivos y políticas laborales* — Note: in PR the standard term is *empleos sensitivos*; OK.
- **625** *Módulo 9 — Protección de menores y almacenamiento seguro* — OK.
- **626** *Módulo 10 — Detección temprana y apoyo (SBIRT / DSM‑5)*
  - `"DSM‑5"` → `"DSM-5"` for consistency with the rest of the course. **Low.**
- **627** *Módulo 11 — Corresponsabilidad ciudadana y rol de la CST* — OK (CST is the entity, no period on Spanish acronym).
- **628** *Examen final*
  - Capitalization: `"Examen final"` is correct in running text, but as a standalone module title style guides also accept `"Examen Final"`. The choice matters because module 1–11 use sentence case ("Módulo 1 — …"). Keep sentence case → leave as is. **Low.**
- **74** *Módulo 5 — Derechos y responsabilidades del paciente* — OK.

### `tutor_quiz` (titles only — `post_content` empty, table empty)

- **93** *¿Por qué este curso?* — OK (correct opening `¿`).
- **634** *Efectos del cannabis en la conducción* — OK.
- **635** *Tiempos de espera y plan de movilidad segura* — OK.
- **636** *Marco legal en Puerto Rico (Ley 22-2000 / Ley 42-2017)* — OK; mixes plain hyphen — see global recommendation.
- **637** *Derechos y responsabilidades del paciente* — OK.
- **638** *Señales de afectación y SFST* — OK.
- **639** *Policonsumo y situaciones de riesgo* — OK.
- **640** *Empleos sensitivos y políticas laborales* — OK.
- **641** *Protección de menores y almacenamiento seguro* — OK.
- **642** *Detección temprana y apoyo (SBIRT / DSM-5)* — OK.
- **643** *Corresponsabilidad ciudadana y rol de la CST* — OK.
- **644** *Resumen: 11 preguntas, una por módulo* — OK.

> **CRITICAL DATA NOTE:** `wp_tutor_quiz_questions` is empty. The 12 quizzes have *no questions configured*. This is either a migration gap or an intentional placeholder; confirm with the source site before launch.

### `lesson` posts

#### Module 1 — Introduction

- **285** *Lección 1.1: Contenido*
  - `"...marco legal de PR (Ley 42-2017; Reglamento 9038; Ley 22-2000); Estas normativas..."` → replace the second `;` with `.` (or `:`); `Estas` is correctly capitalized only after a full stop. **High.**
  - `"marco legal de PR"` — using "PR" as an abbreviation in formal CST text reads casual. → `"marco legal de Puerto Rico"` for the first mention, then PR is acceptable. **Medium.**
  - Title `"Contenido"` is uninformative. Consider `"Introducción al curso"`. **Low (manual review).**
- **605** *Lección 1.2: Definiciones*
  - `"El cannabis aunque sea medicinal puede alterar..."` → `"El cannabis, aunque sea medicinal, puede alterar..."` (parenthetical commas missing). **Medium.**
  - `"ride‑hailing"` — anglicism. Either italicize `<em>ride-hailing</em>` or replace with `"servicios de transporte por aplicación"`. **Medium (manual review).**
  - Uses `‑` (U+2011) in `ride‑hailing`; should be regular hyphen. **Low.**
- **542** *Cierre del Módulo 1: Marco Legal y Conceptos Clave*
  - Title capitalization: `"Marco Legal y Conceptos Clave"` → `"Marco legal y conceptos clave"`. **Medium.**
  - `"Ley 22-2000"` (here plain hyphen). Other posts use `Ley 22‑2000`. Pick one. **Low.**

#### Module 2 — Effects on driving

- **606** *Lección 2.1*
  - `""se siente bien""` (straight quotes around inner phrase). Replace with `«se siente bien»` or curly `"se siente bien"`. **Medium.**
- **543** *Cierre del Módulo 2: La Realidad vs. La Percepción*
  - Title: `"La Realidad vs. La Percepción"` → `"La realidad vs. la percepción"` (sentence case). **Medium.**
  - `""sensación subjetiva""` (straight quotes) → `«sensación subjetiva»`. **Medium.**
  - `"vs."` is acceptable in informal PR Spanish but Fundéu recommends `frente a` in formal register. **Low.**

#### Module 3 — Wait times & mobility plan

- **84** *Lección 3.1*
  - `"co‑medicación"` → `"comedicación"` (no hyphen needed; or in plainer Spanish `"medicación concomitante"`). **Medium.**
  - `""Plan B""` (straight quotes) → `«Plan B"`. **Low.**
  - `"app de ridesharing"` → `"aplicación de transporte compartido"` (or italicize). **Medium.**
  - `"apps"` (twice, no italics) → `"aplicaciones"`. **Medium.**
- **545** *Cierre del Módulo 3: Tu Estrategia de Movilidad Segura*
  - Title: `"Tu Estrategia de Movilidad Segura"` → `"Tu estrategia de movilidad segura"`. **Medium.**
  - `""Plan B""`, `""Regla de Oro""` (straight quotes everywhere). → `«Plan B»`, `«Regla de Oro»` (or curly). **Medium.**
  - The closing paragraph has a stray period after the closing exclamation: `"...antes de consumir!</span>...</span>."` — there is a `.` outside the `</span>` after `!`. → remove that final period; an exclamation already ends the sentence. **High.**

#### Module 4 — Legal framework

- **85** *Lección 4.1* — OK (uses `Ley 22‑2000`; harmonize). **Low.**
- **286** *Lección 4.2: Prohibiciones y Sanciones*
  - Bold heading title-case: `"Marco Legal: Prohibiciones y Sanciones"` → `"Marco legal: prohibiciones y sanciones"`. **Medium.**
- **287** *Lección 4.3: Validez de la Licencia Médica al Volante*
  - Title capitalization `"Licencia Médica al Volante"` → `"licencia médica al volante"` in title. **Medium.**
  - Content reads OK.
- **288** *Lección 4.4: Protocolos de Evaluación en la Vía (SFST)*
  - `"Las pruebas SFST (Standardized Field Sobriety Tests, en inglés)"` — the parenthetical is clear, but `Standardized Field Sobriety Tests` should be italicized as foreign-language: `<em>Standardized Field Sobriety Tests</em>`. **Medium.**
- **289** *Lección 4.5* — OK.
- **290** *Lección 4.6*
  - `"sigue aplicando la Ley 22"` → `"sigue aplicando la Ley 22-2000"` (the law's full short title is `Ley 22-2000`; bare `Ley 22` is colloquial). **Medium.**
- **546** *Cierre del Módulo 4: La Ley y tu Responsabilidad*
  - Title: `"La Ley y tu Responsabilidad"` → `"La ley y tu responsabilidad"`. **Medium.**

#### Module 5 — Patient rights

- **291** *Lección 5.1* — OK.
- **86** *Lección 5.2: Consecuencias y Continuidad del Tratamiento*
  - Title: `"Consecuencias y Continuidad del Tratamiento"` → `"Consecuencias y continuidad del tratamiento"`. **Medium.**
- **293** *Lección 5.3: Consejo Práctico para la Renovación*
  - Title: `"Consejo Práctico para la Renovación"` → `"Consejo práctico para la renovación"`. **Medium.**
  - `"récord médico"` is fine in PR Spanish (anglicized but standard); `"historial médico"` would be more neutral. **Low (manual review).**
- **547** *Cierre del Módulo 5: Tus Derechos como Paciente*
  - Title: `"Tus Derechos como Paciente"` → `"Tus derechos como paciente"`. **Medium.**

#### Module 6 — SFST

- **87** *Lección 6.1: Señales de afectación y pruebas de campo (SFST)*
  - `"(seguimiento ocular horizontal, caminar y girar, pararse en un pie)"` — the standard PR/legal name for the first test is *Nistagmo Horizontal en Mirada Lateral* (HGN). Consider clarifying. **Low.**
- **294** *Lección 6.2: ¿Qué es el Nistagmo y por qué es relevante?*
  - Title: `"¿Qué es el Nistagmo y por qué es relevante?"` → `"¿Qué es el nistagmo y por qué es relevante?"` (`nistagmo` is a common noun, not capitalized). **Medium.**
- **295** *Lección 6.3: Límite de la Protección Legal*
  - Title: `"Límite de la Protección Legal"` → `"Límite de la protección legal"`. **Medium.**
- **296** *Lección 6.4: Implementación de un Plan de Movilidad Segura*
  - Title: → `"Implementación de un plan de movilidad segura"`. **Medium.**
- **548** *Cierre del Módulo 6: Lo que tu cuerpo revela*
  - `""compensar""` (straight quotes) → `«compensar»`. **Low.**
  - Body OK.

#### Module 7 — Polyconsumption

- **88** *Lección 7.1* — OK, concise.
- **297** *Lección 7.2: Riesgos de la Combinación de Sustancias*
  - Title: → `"Riesgos de la combinación de sustancias"`. **Medium.**
  - `"coordina 'ride' o transportación"` — `'ride'` is anglicism in single curly quotes. → `"coordina un servicio de transporte ('ride') o transportación"` (italicized) or just remove `'ride'`. **Medium.**
  - `"transportación"` is the PR norm (vs. peninsular `transporte`); keep, but inconsistent with use of `transporte` elsewhere. Decide one. **Low.**
- **550** *Cierre del Módulo 7: El Peligro del Policonsumo*
  - Title: → `"El peligro del policonsumo"`. **Medium.**
  - `""letalmente lentas""` (straight quotes) → `«letalmente lentas»`. **Low.**

#### Module 8 — Sensitive employment

- **89** *Lección 8.1* — OK; `"cero tolerancia"` is calque from English; PR-acceptable.
- **298** *Lección 8.2: Marco Legal Laboral en EE. UU. y Puerto Rico*
  - Title: → `"Marco legal laboral en EE. UU. y Puerto Rico"`. **Medium.**
  - `"EE. UU."` — note: RAE prescribes a non-breaking space (`EE.<NBSP>UU.`) between the doubled abbreviation. Currently a regular space. **Low.**
- **299** *Lección 8.3: Derechos de la Empresa bajo la Ley 42-2017*
  - Title: → `"Derechos de la empresa bajo la Ley 42-2017"`. **Medium.**
  - `"Ley 42-2017"` here plain hyphen — see global note.
- **300** *Lección 8.4: Sanciones y Medidas Preventivas*
  - **Critical**: post body is wrapped in leftover Gemini/AI markup: `<div id="model-response-message-contentr_d8993c7eb496de82" class="markdown markdown-main-panel stronger enable-updated-hr-color" dir="ltr" aria-live="polite">…</div>`. → strip the wrapping `<div>`, leaving just the inner `<p>`. **High.**
  - Title: → `"Sanciones y medidas preventivas"`. **Medium.**
- **551** *Cierre del Módulo 8: Seguridad en el Entorno Laboral*
  - Title: → `"Seguridad en el entorno laboral"`. **Medium.**
  - `""empleo sensitivo""` (straight quotes) → `«empleo sensitivo»`. **Low.**

#### Module 9 — Protecting minors

- **90** *Lección 9.1* — OK.
- **301** *Lección 9.2: Prevención en el Hogar y Responsabilidad Compartida*
  - Title: → `"Prevención en el hogar y responsabilidad compartida"`. **Medium.**
  - Body has a soft logical glitch: `"Implica involucrar a todos los miembros del hogar..."` — verb without an explicit subject; the previous sentence's subject was *revisiones*, so the `Implica` doesn't agree cleanly. → `"Esto implica involucrar..."`. **Medium.**
- **552** *Cierre del Módulo 9: Tu Compromiso con la Seguridad en el Hogar*
  - Title: → `"Tu compromiso con la seguridad en el hogar"`. **Medium.**
  - Body content has `<span class="">…</span>` chrome left over from import (empty class attributes). Cosmetic but should be stripped. **Low.**

#### Module 10 — Early detection

- **91** *Lección 10.1* — OK; uses `DSM‑5` (U+2011) — harmonize.
- **307** *Lección 10.2: Definición del Modelo SBIRT*
  - Title: → `"Definición del modelo SBIRT"`. **Medium.**
  - `""Screening, Brief Intervention, and Referral to Treatment""` — straight quotes around English; should be `«…»` and italicized as foreign language. **Medium.**
- **308** *Lección 10.3: Estándar de Diagnóstico: DSM-5*
  - Title: → `"Estándar de diagnóstico: DSM-5"`. **Medium.**
  - `""Manual Diagnóstico y Estadístico de los Trastornos Mentales, quinta edición""` — straight quotes; should be `«…»` (it's a book title, italics also acceptable). **Medium.**
  - `"Asociación Americana de Psiquiatría"` is a calque; the official Spanish name used by APA itself is *Asociación Estadounidense de Psiquiatría*. Fundéu also accepts *Americana*; keep but flag. **Low.**
- **309** *Lección 10.4: Beneficios de la Intervención Temprana y Método de Auto-Evaluación*
  - Title: → `"Beneficios de la intervención temprana y método de autoevaluación"` (`autoevaluación` is one word, no hyphen). **Medium/High.**
  - Body: `"auto‑chequeo"` → `"autochequeo"` (single word, no hyphen; alternatively `"autoevaluación"` for a more formal register). **Medium.**
- **554** *Cierre del Módulo 10: Tu Salud es la Prioridad*
  - Title: → `"Tu salud es la prioridad"`. **Medium.**
  - `"DSM-5"` here plain hyphen — pick one across course.

#### Module 11 — Civic responsibility

- **92** *Lección 11.1: Corresponsabilidad ciudadana y rol de la CST*
  - `""No conduzco si consumo""` (straight quotes) → `«No conduzco si consumo»`. **Medium.**
  - `"Tu certificación (aunque sea opcional) significa..."` — italicizing only "aunque sea opcional" is odd; either italicize none or italicize the entire parenthetical. **Low.**
  - `"Además, tu orientación y conocimiento, representa..."` — subject is plural ("orientación y conocimiento"), verb should be `"representan"`. **High (grammar).**
- **305** *Lección 11.2: Compromiso Personal y Liderazgo en Seguridad Vial*
  - Title: → `"Compromiso personal y liderazgo en seguridad vial"`. **Medium.**
  - Same `"orientación y conocimiento, representa"` agreement error — duplicated copy from 92. → `"representan"`. **High.**
  - `""No conduzco si consumo""` straight quotes — same fix.
- **306** *Lección 11.3: Modelaje de Conducta Social*
  - Title: → `"Modelaje de conducta social"`. **Medium.**
  - `""No conduzco si consumo""` straight quotes — same fix.
  - Body is a single sentence (15 words). Consider expanding for the closing lesson. **Low (manual).**
- **555** *Lección 11 / Módulo 11: De la Información a la Acción Ciudadana*
  - Title: → `"De la información a la acción ciudadana"`. **Medium.**
  - `""No conduzco si consumo""` straight quotes — same fix.

---

## Quick auto-fix candidates (safe global find/replace)

These can be applied as a SQL/`wp post update` script without human judgment, after a backup. Run **per-post** (don't trust regex against `wp_posts` blindly).

| # | Find | Replace | Notes |
|---|---|---|---|
| 1 | `‑` (U+2011 non-breaking hyphen) | `-` (U+002D) | Use plain hyphen everywhere: `Ley 22-2000`, `DSM-5`, `co-medicación`, etc. |
| 2 | `co‑medicación` / `co-medicación` | `comedicación` | Closed compound. |
| 3 | `auto‑chequeo` / `auto-chequeo` | `autochequeo` | Closed. |
| 4 | `auto‑evaluación` / `Auto-Evaluación` | `autoevaluación` / `Autoevaluación` | Closed. |
| 5 | `neuropsico‑funcionales` | `neuropsicofuncionales` | Closed. |
| 6 | `EE. UU.` (regular space) | `EE.<NBSP>UU.` | RAE: non-breaking space between the abbrev. parts. |
| 7 | Two consecutive spaces `  ` | One space ` ` | Found in `wp-image-558`, `wp-image-561`, etc. (in `class="alignnone  wp-image-XXX"` — cosmetic only, don't touch alt attrs). |
| 8 | `<p> </p>` (paragraph holding a single NBSP/space) | (delete) | Empty paragraphs inserted by editor; appear in lessons 87, 93/etc. |
| 9 | `<h3> </h3>` (empty heading) | (delete) | In lessons 298, 299. |
| 10 | `<span class=""></span>` and `<span class="">…</span>` | unwrap | Empty class spans from Google Docs paste, lesson 552, 542, 545 etc. |
| 11 | `<div id="model-response-message-content…" …>` …`</div>` | unwrap | **Lesson 300 only.** Strip the AI-tooling div wrapper. |

> Caution: do **not** auto-replace `"…"` (straight quotes) → `«…»` globally. HTML attributes (`class="…"`, `src="…"`, `alt="…"`) use straight quotes legitimately. The replacement must only target text inside `<p>`, `<li>`, `<span>` content — best done by a script that parses HTML or by a human editor in the block editor.

---

## Manual-review-only (need editor judgment)

1. **Module/lesson title casing.** All ~20 titles using English-style title case ("Tu Estrategia de Movilidad Segura"). Decide once: sentence case (recommended for Spanish formal register) or keep stylized title case. Apply consistently.
2. **Anglicisms** (italicize OR translate; don't auto-replace):
   - `ride-hailing` (lesson 605)
   - `ridesharing` / `app de ridesharing` (lesson 84)
   - `'ride'` (lesson 297)
   - `apps` / `app` (lessons 84, 605)
   - `checklist` (lesson 301)
   - English titles in quotes — `Screening, Brief Intervention, and Referral to Treatment` (307), `Standardized Field Sobriety Tests` (288), `Manual Diagnóstico y Estadístico…` (308) — wrap in `<em>` or `«…»`.
3. **Straight quotes → Spanish quotes.** Across at least lessons 84, 87, 92, 296, 297, 305, 306, 543, 545, 546, 548, 550, 551, 555. Recommend `«…»` for formal register or curly `"…"` for friendlier tone — pick one.
4. **Subject-verb agreement** (true grammatical errors):
   - `lesson_92` and `lesson_305`: `"tu orientación y conocimiento, representa"` → `representan`. **HIGH.**
   - `lesson_285`: semicolon-then-capital `"; Estas normativas…"` → `". Estas normativas…"`. **HIGH.**
   - `lesson_545`: stray period after closing `!` outside `</span>`. **HIGH.**
5. **Stray `4` in topic 618 title.** **HIGH.**
6. **Tooling chrome in lesson 300** (`<div id="model-response-message-content…">`). **HIGH.**
7. **Quiz content gap.** `wp_tutor_quiz_questions` is empty — there are 12 quiz CPTs with no questions. Out of scope for grammar review but blocks course completion. **CRITICAL — flag to project lead.**
8. **`Ley 22` shorthand** in lesson 290 — decide whether to expand to `Ley 22-2000` for legal precision.
9. **`PR` vs `Puerto Rico`** mixing (lessons 92, 285) — establish style: full name on first mention per page.
10. **Closing CTA tone** (`¡Descárgalo ahora…!`) — appears in 11/12 cierre lessons; consistent voice but a CST-formal editor may prefer `Te invitamos a descargarlo` once and avoid the exclamation.
11. **Run-on sentences in module 8 / 10 expansions** (lessons 298, 299, 308) — content is correct but each paragraph runs 3–4 ideas. Optional editorial pass.

---

## Recommendation

**Use a hybrid approach.**

1. **Scripted pass** (15 min, safe): apply auto-fix items 1–11 from the table above via a small WP-CLI/PHP script that loads each `post_content`, runs targeted `str_replace` (NOT regex against the whole table), and saves. Generate a diff first so the editor can review before commit. Items 1, 2, 3, 4, 5, 7, 8, 9, 10, 11 are mechanical and low-risk. Item 6 (NBSP) needs care.
2. **Manual editor pass** (~2 hours in WP Block Editor): a Spanish-fluent editor takes the 43 lessons one at a time and resolves the title-casing, straight-quote, anglicism italics, and 3 grammatical-agreement fixes. Use this report as the checklist.
3. **Project-lead decision** before launch: populate `wp_tutor_quiz_questions` from the source site (the 12 quizzes are currently empty) and confirm the registered Reglamento number (lesson 285 cites `9038` — verify this is current).

A pure scripted pass is **not** safe because most issues require judgment (Spanish guillemets vs curly quotes, anglicism italicize vs translate, title-casing convention). A pure manual pass wastes editor time on the dozens of identical hyphen / closed-compound fixes that a script can knock out in one go.
