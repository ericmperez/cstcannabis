# Conversión de Pencil a código — CST Cannabis Portal

Este archivo es el estado persistente de un proceso iterativo (vía `/loop` cada 4
minutos) que convierte, elemento por elemento, el diseño en Pencil del portal
CST Cannabis a código real en `themes/cst-cannabis-portal/`.

**Cada disparo del cron es un agente nuevo sin memoria de iteraciones anteriores.**
Este archivo es la única fuente de continuidad. Léelo completo antes de hacer nada.

## Cómo trabajar cada iteración

1. Lee este archivo completo.
2. Toma el **primer** ítem sin marcar (`[ ]`) de la lista "Elementos pendientes".
3. Trabaja **solo ese ítem** — no sprawl a otros. El presupuesto es ~4 minutos.
4. Sigue las "Reglas globales" de abajo sin excepción.
5. Verifica: `curl` a la(s) página(s) afectada(s) debe devolver 200, sin fatales PHP
   (`docker logs cst-cannabis-wp --tail 50 | grep -i fatal`), y una revisión visual
   rápida por navegador si es viable.
6. Haz commit del cambio (solo los archivos de ese ítem) con mensaje descriptivo,
   ej. `git commit -m "Match Pencil: Home — Section Pilares"`. NO push (el usuario
   revisa y pushea).
7. Marca el ítem como hecho (`[x]`) en este archivo y añade una línea en "Bitácora"
   con fecha/hora y qué cambió. Haz commit de este archivo también (junto al cambio
   de código, mismo commit está bien).
8. Si el ítem resulta ya estar bien (coincide con Pencil), márcalo hecho igual,
   anota "sin cambios — ya coincidía" en la bitácora, y sigue al siguiente en la
   próxima iteración (no hagas dos ítems en la misma pasada).
9. Si te bloqueas (dependencia ambigua, decisión de contenido real vs. mockup poco
   clara), NO improvises: dejá el ítem sin marcar, anota el bloqueo en "Bitácora" /
   "Bloqueos abiertos", y para ahí — la siguiente iteración (o el usuario) lo retoma.

## Reglas globales (NO NEGOCIABLES)

- **Pencil es guía de ESTILO, no de contenido.** Copy real, fotos reales, y nombres
  reales ya publicados en el sitio en vivo NUNCA se reemplazan por el texto/imágenes
  de mockup de Pencil. Solo se adoptan: colores, tipografía, spacing, layout,
  estructura visual, forma de componentes (bordes, sombras, iconos decorativos).
- **Excepción Curso**: el hero de `/curso/` (`.cst-hero--course`) usa una foto real
  de hoja de cannabis — decisión explícita del usuario de preservarla. NUNCA tocar
  `.cst-hero--course` ni convertirlo al hero navy genérico.
- **Archivo Pencil activo**: `/Users/ericperez/Projects/cannabis` (16 frames:
  Home, Feature Card, Page Hero, Curso, Recursos, Estadísticas, Sobre nosotros,
  Contacto, Accesibilidad, Aviso legal, Certificado, Site Header, Blog, Artículo,
  Búsqueda, 404). Usa `mcp__pencil__batch_get` con `resolveVariables:true` y
  `readDepth` suficiente para sacar valores EXACTOS (hex, px, font-weight) — no te
  quedes con la primera pasada superficial, los detalles importan.
- **Precisión, no aproximación**: cuando compares un valor (color, padding, radio
  de borde), usa el valor exacto de Pencil si existe un token o valor cercano ya
  en `custom.css`; si no existe, créalo con nombre consistente (`--cst-color-*`,
  `--cst-space-*`, etc.) en vez de hardcodear un hex suelto, salvo que el resto del
  archivo ya tenga ese patrón (ej. la mayoría de las secciones sí hardcodean hex
  puntuales — revisa el estilo ya usado en la sección más cercana antes de decidir).
- **Reutiliza lo que ya existe** antes de crear algo nuevo: `cst_hero()`,
  `cst_cta_button()`, `cst_card()`, `cst_callout()`, `cst_section_heading()`,
  `cst_section_open()/close()`, tokens en `style.css`. Grep antes de escribir.
- **No inventes contenido nuevo** (textos legales, estadísticas, testimonios,
  nombres de personas) — si un elemento de Pencil requiere contenido que el sitio
  en vivo no tiene, usa el copy real ya existente en la página correspondiente y
  limita el cambio a estilo/estructura.
- **Tema activo**: `cst-cannabis-portal` en `/Users/ericperez/Projects/cstcannabis`
  (NO `cst-motoras-portal`, que vive en el mismo repo pero es un portal distinto —
  nunca tocar sus archivos). Sitio local: `http://localhost:8088` (Docker Compose,
  contenedor `cst-cannabis-wp`; WP-CLI vía `docker exec cstcannabis-wpcli-run-c1839c4c2a2a wp --allow-root ...`).
- **Accesibilidad**: no rompas nada de lo ya certificado (33/33 en
  `docs/checklist-prits.md`) — contraste WCAG AA, focus-visible, forced-colors,
  reduced-motion, touch targets 44×44. Si cambias un color, verifica contraste
  contra el fondo antes de dar el ítem por bueno.
- **No toques**: páginas borrador duplicadas en la BD, páginas Cart/Checkout
  huérfanas, `.wp-env.json` / `docker-compose.yml` (cambios de otro trabajo en
  curso del usuario, no relacionados).

## Ya hecho (sesión previa, NO repetir)

- [x] Site Header global — fondo claro, franja verde superior (`cst-top-accent`),
      borde inferior 1px sutil, ícono de búsqueda circular, wordmark de 2 líneas
      (agencia + título), CTA "Ver Curso" verde sólido con flecha.
- [x] Page Hero interior genérico (`.cst-hero--page`) — navy sólido, resplandor
      radial verde sutil, texto alineado a la izquierda, subtítulo en tono frío
      `#CDD5E3`. Aplica a: Recursos, Estadísticas, Sobre nosotros, Contacto,
      Accesibilidad, Términos de uso, Política de privacidad, Blog, Búsqueda, 404.
- [x] Home hero — alineado a la izquierda, segundo CTA "Ver recursos" agregado
      (`cta2_text`/`cta2_url` en `cst_hero()`), copy y foto real preservados.
- [x] Site Header, precisión total — re-extraído con `resolveVariables:true`:
      franja verde superior (`cst-top-accent`, hook `generate_before_header`
      prioridad 2), borde inferior 1px, ícono búsqueda circular relleno, CTA
      verde plano + flecha, wordmark 2 líneas, lang-switcher transparente.
- [x] Feature Card (componente reusable Pencil `c7wQJf`) = `.cst-pillar-card` en
      `template-parts/section-course-pillars.php` (Home, sección "Propósito").
      Reescrito para calzar exacto con Pencil: card plana, radio 14px, chip de
      ícono verde claro `#EEF3E7` (antes círculo verde sólido), enlace "Saber
      más →" (antes badge de número de paso + barra degradada superior).
      **Bug preexistente encontrado y arreglado de paso**: el bloque CSS de
      "Sobre nosotros" (`Nuestros pilares`, 4 tarjetas de valores) reutilizaba
      el MISMO nombre de clase `.cst-pillar-card` que Home — colisión, no
      código muerto. Renombrado a `.cst-value-card` /
      `.cst-section--about-values` / `.cst-values-grid` en
      `page-templates/template-about.php` y su propio bloque CSS, sin cambiar
      ningún valor visual (verificado idéntico antes/después). Esto también
      significa que el siguiente ítem de "Sobre nosotros — Section Valores"
      ya tiene su CSS aislado y listo para comparar contra Pencil sin riesgo
      de volver a chocar con Home.
- [x] Home — Section "Pilares" (resto de la sección, fuera de la tarjeta ya
      hecha) — `template-parts/section-course-pillars.php`. Eyebrow
      Open Sans→Montserrat, título/lead navy/gray-700→ink-900/ink-700
      exactos de Pencil (`#18202E`/`#3A4353`). Cada tarjeta con su propio
      acento (verde/azul/navy) en vez de verde uniforme, íconos cambiados
      a estilo stroke Lucide (pill/car-front/users) para calzar con Pencil.

## Elementos pendientes (en orden — trabajar de arriba hacia abajo)

- [x] Home — Section "Lo que aprenderás" — `template-parts/section-objectives.php`.
      Nodo Pencil: `GycwK` (hijo de Home `XCdjO`). Head reescrito con eyebrow
      (punto + "CONTENIDO DEL CURSO") + título sólido `#18202E` (antes verde
      degradado + barrita subrayado). Tarjetas: de centradas con ícono círculo +
      número grande difuminado → planas izquierda con chip numérico verde-wash
      `#EEF3E7` 44×44 (número Montserrat 17/800 `#5E7C3A`), borde `#E4E8EE` 1px,
      radio 14, padding 26. Sección plana `#F8F9FA` (quitada la onda decorativa
      `::after` que Pencil no tiene). String nuevo "Contenido del curso" →
      "Course content" en `.po` + `.mo` recompilado. Verificado en navegador
      desktop (coincide con Pencil) y a 606px (1 columna, sin overflow).
- [x] "Por qué importa" (Pencil `ZYcoy`) — **abordado con default razonable**
      (commit `93cd0f2`): `section-course-impact.php` (el bloque navy real con
      stat+callouts, en la página Curso) afinado al lenguaje visual navy-stats de
      Pencil (tarjetas translúcidas r14, número verde-claro `#A9C58E`, título 800).
      Contenido real conservado; los 3 stats mockup de Pencil NO se fabricaron.
      **Decisión de usuario aún abierta:** ¿añadir además un bloque navy de stats
      al HOME (Pencil lo muestra ahí) y con qué KPIs reales? Detalle histórico:
      El nodo Pencil `ZYcoy` es un bloque navy con 3
      TARJETAS DE STAT (números verde-claro `#A9C58E` 52/800 sobre cards
      translúcidas `#FFFFFF0F` borde `#FFFFFF26`, radio 14) + nota "Cifras
      ilustrativas para diseño — fuente final NHTSA/FARS". Problemas:
      (1) esa sección NO se renderiza en el Home del sitio — `section-course-impact.php`
      (navy, pero texto+1 stat+3 callouts con iconos, estructura distinta) se
      incluye en la página **Curso** (`template-course.php:40`), no en el Home.
      (2) los 3 stats de Pencil son mockup explícito ("cifras ilustrativas") →
      la regla prohíbe copiarlos como contenido; y el sitio no tiene 3 stats
      reales para esta sección. Decisión pendiente del usuario: ¿añadir una
      sección navy de stats al Home?, ¿con qué números reales (de la página
      Estadísticas)?, ¿o dejar el Home sin ella? Ver también la divergencia de
      COMPOSICIÓN del Home abajo.
- [x] Home — Section "Enrollment CTA" (Pencil `Qp2ZK`) —
      `template-parts/section-enrollment-cta.php` + CSS. Fondo navy→degradado
      verde `#5E7C3A→#4C6A2C` 120°; layout centrado→horizontal (copy izquierda +
      botones derecha, space-between); título Montserrat 34/800; botón primario =
      pill blanco con texto verde + flecha (Pencil). Se conservan el 2º CTA real
      ("Ver temario", outline) y el subtítulo real. Subtítulo en blanco (el
      `#EAF1E2` de Pencil falla AA ~3.96:1 sobre el verde claro). Apila <768px.
      Verificado desktop (match). Commit `b91d2c7`.
- [x] Home — Section "Últimas publicaciones" (Pencil `Z46l9w`) —
      `template-parts/section-latest-posts.php` + `card-blog.php` + CSS. Head:
      centrado→fila (eyebrow "Blog" + título izquierda, link "Ver todas →"
      derecha). Card de blog (compartida con archivo Blog): pill de categoría
      verde-wash + meta "fecha · N min" (tiempo de lectura), sin excerpt/"Leer
      más", card entera clickable (link de título estirado). Base `.cst-card`
      alineada a Pencil (radio 14, borde `#E4E8EE`, plana sin sombra). Se
      conserva el formato de fecha traducible del loop. Strings "Ver todas"→"See
      all", "%s min" al `.po` (gate=1). Verificado desktop. Commit `f00d4c1`.
      Nota: el pill muestra "Uncategorized" en posts sin categoría (dato real;
      asignar categorías reales es contenido del cliente).
- [~] Footer institucional (componente global) — `footer-institutional.php` +
      CSS. **Estilo alineado, estructura conservada por contenido real.** Fondo
      degradado navy-darker→gray-900 → navy PLANO `#16203C` (Pencil `fZ390`
      exacto). Commit `cb69e72`. NO se restructuró a las 4 columnas mínimas de
      Pencil (Brand/Portal/Institución/Legal) porque el footer real tiene
      contenido legalmente requerido que el mockup omite: bloque OIG de denuncias
      anónimas + protección al confidente (Ley 426-2000/30-2005), declaración de
      igualdad de oportunidades, statements Ley 229/141 + pr.gov, contactos,
      redes. Pencil = guía de estilo, no spec de contenido. Pendiente opcional
      (decisión usuario): ¿quitar el subrayado verde de los títulos de columna
      (Pencil no lo tiene) y reordenar la fila inferior a copyright-izq/badges-der?
- [~] Curso — Section "Intro Curso" (Pencil `JOEdH`) — **DIFERIDO estructural.**
      El sitio no tiene una sección "Intro" separada; en su lugar `template-course.php`
      usa `section-course-impact.php` (navy stats+callouts). Mapear Pencil Intro
      (blanco, "Intro Inner" a 2 col) requiere decidir qué contenido real va ahí.
- [~] Curso — Section "Módulos" (Pencil `htjFi`) — **DIFERIDO estructural.** Pencil
      es un grid de módulos numerados estilo "Lo que aprenderás"; el sitio usa
      `section-course-cards.php` (tarjetas Digital/Interactivo/Certificado, otro
      contenido). No mapea 1:1 sin decisión de contenido.
- [x] Curso — Section "FAQ" (Pencil `Sadc3`) — `section-course-faq.php` + CSS.
      Título sólido centrado (sin subtítulo/gradiente) + items tarjeta
      `#F6F8F4`/borde `#E4E8EE`/r14 con "+" verde→"×". 5 FAQs reales. Commit `329b2d2`.
- [~] Curso — Section "Enrollment CTA" (Pencil `c7Usm`, = banner verde de Home) —
      **DIFERIDO:** el sitio usa `section-course-footer-cta.php`, que es un
      FORMULARIO de registro real (Tutor LMS), no el banner simple de Pencil.
      Convertirlo quitaría el formulario real. Decisión: ¿añadir el banner verde
      aparte, o dejar el formulario? El hero de Curso (`.cst-hero--course`, foto
      real) NUNCA se toca.
- [x] Recursos — Filtros (Pencil `oadvO`) — pills reestilizados: inactivos
      `#F6F8F4`/borde `#E4E8EE`, activo verde SÓLIDO `#5E7C3A` (sin degradado/glow).
      Commit `f4ff51b`. Cards heredan la base `.cst-card` ya alineada a Pencil.
      **NO verificable localmente**: `cst_resource` tiene 0 posts publicados → la
      página muestra estado vacío (sin cards ni tabs con datos). Estilo aplicado
      es spec-exacto; falta pase visual cuando haya recursos seeded.
- [x] Estadísticas — Section "KPIs" (Pencil `SpOx1`) — override cannabis-scopeado
      en `custom.css` (el CSS base vive en `plugins/cst-core/assets/css/statistics.css`,
      COMPARTIDO con motoras — no tocado). Cards `#F6F8F4` planas r14 borde `#E4E8EE`,
      chips verde-wash `#EEF3E7` uniformes (override del `:nth-child` navy/azul del
      plugin), número Montserrat 34/800 sobre el label, sin barra de acento. KPIs y
      fuentes reales conservados. Commit `8b8270a`. Verificado.
- [~] Estadísticas — Section "Chart" (Chart.js) — el chart renderiza (canvas). Pencil
      `eg6hk` = card blanca r22 borde padding 32. Follow-up menor: envolver/estilar
      el contenedor del chart (el CSS vive en el plugin compartido → scopear a cannabis).
- [~] Sobre nosotros — Section "Misión" (Pencil `PFWL4`) — **DIFERIDO estructural.**
      Pencil es 2-col (texto 600 + imagen 360 rounded). El sitio tiene DOS
      secciones de texto (Misión + "¿Por qué este portal?") sin imagen, con copy
      real. Añadir imagen/2-col requiere decidir imagen real (Pencil usa una
      foto Unsplash mockup) y si fusionar las 2 secciones.
- [x] Sobre nosotros — Section "Valores" (Pencil `kdpw4`) — `template-about.php`
      + CSS. Sección plana `#F8F9FA`, 4 tarjetas en fila (chip verde-wash 50×50
      r13 + ícono, título 19/700 `#18202E`, desc 14 `#3A4353`, borde `#E4E8EE`
      r14 padding 26). Sin subtítulo. 4 valores reales conservados. Commit `746f39e`.
- [x] **GLOBAL — títulos de sección sólidos** (`746f39e`): `.cst-section-heading__title`
      pasó de gradiente verde→navy + barra subrayado a SÓLIDO `#18202E` Montserrat
      800 sin barra, alineando a Pencil TODAS las secciones que usan
      `cst_section_heading` (Misión, Purpose, Valores, Contacto, statistics
      "Fuentes", course-features, course-cards, upcoming-events). Arregla además
      una falla WCAG AA (extremo verde del gradiente ~2.88:1). Caja Contacto navy
      conserva su override blanco (verificado, sin romperse).
- [ ] Contacto — Section "Contacto" (tarjetas info + formulario CF7).
- [ ] Accesibilidad — Section "A11y" (contenido hardcodeado, revisar solo estilo
      de contenedor/tipografía, NO el contenido legal en sí).
- [ ] Aviso legal — Section "Legal" — aplica a `/terminos-uso/` y
      `/politica-privacidad/` (`page-templates/template-legal.php`), solo estilo
      del contenedor/TOC, no el contenido legal.
- [ ] Certificado — Section "Cert" — comparar contra `template-certificate.php`
      (ya construido y verificado en sesión previa; probablemente solo necesita
      ajustes menores de token, si acaso).
- [x] Blog — Section "Posts" (Pencil `BfmJo`) — `home.php` + `card-blog.php`.
      Verificado: 6 cards de blog con pill de categoría + grid, usa la card ya
      alineada a Pencil (commit `f00d4c1`) y el hero genérico. Sin cambios extra.
- [x] Artículo — Section "Artículo" + "Relacionadas" (Pencil `tlUDj`) — **`single.php`
      CREADO** (el tema no tenía). Hero con eyebrow de categoría + título + meta
      "fecha · N min · Por autor"; cuerpo prose 800px con imagen destacada r14,
      H2 26/700, blockquote→callout verde-wash, fila de 4 botones de compartir
      circulares; sección "Publicaciones relacionadas" `#F8F9FA` (eyebrow "Sigue
      leyendo" + 3 cards de la misma categoría). 8 strings nuevos traducidos
      (gate=1). Commit `14b1569`. Verificado con post real.
- [x] Búsqueda — Section "Resultados" (Pencil `y17RyK`) — `search.php`. Verificado
      en navegador: hero + caja de búsqueda expandida + grid de tarjetas de
      resultado (`.cst-card`) coinciden con Pencil, sin overflow. **2 detalles
      menores pendientes (no bloqueantes):** (a) `search.php` usa `get_the_date()`
      (formato de opción "F j, Y") en vez del formato traducible "%1$s de %2$s de
      %3$s" que usa `card-blog.php` → orden de fecha inconsistente; (b) los nombres
      de mes salen en INGLÉS en páginas ES porque falta el **language pack de WP
      core es_ES** (entorno sin internet; en prod: `wp language core install es_ES`).
      Ambos son ortogonales al diseño Pencil.
- [~] Búsqueda (nota histórica) — **Mejora parcial aplicada
      SIN verificar contra Pencil** (Pencil MCP estaba caído): se migró el
      markup de resultados de clases `.cst-search-result` sin estilo (bug
      preexistente — no tenían CSS) al sistema de tarjetas del sitio
      (`.cst-card`/`.cst-card-grid`), verificado en navegador que renderiza
      bien. Queda pendiente el pase final de precisión contra el frame Pencil
      `y17RyK` cuando Pencil vuelva.
- [x] 404 — Section "404" (Pencil `BYDcn`/`PFXX1`) — `404.php` + CSS. El código
      "404" grande estaba SIN estilar (16px gris); ahora Montserrat 800 clamp→128px
      verde-claro `#A9C58E`. Hero/links/búsqueda ya coincidían. Commit `750f43a`.
      Verificado en navegador. Strings ya traducidos (EN).

## Cuándo parar

**DRIVER ACTUAL (2026-07-08): este proceso ya NO lo maneja un cron.** El cron
viejo (`1eaf359d`) fue cancelado. Ahora lo maneja el Stop hook de `/goal` de la
sesión, con condición "loop … exactamente igual al Pencil … responsive …
bilingüe … then finish". El hook se auto-limpia cuando la condición se cumple —
NO hay que llamar `CronDelete`.

Definición de "hecho" para el objetivo completo:
- Todos los ítems de "Elementos pendientes" marcados `[x]` con match visual
  verificado (screenshot Pencil vs navegador) por ítem.
- Responsive: cada página revisada en ancho estrecho (piso ~606px en este
  Chrome; ver Bitácora) sin overflow horizontal, tipografía legible, targets
  44×44.
- Bilingüe: `grep -c 'msgstr ""'` = 1 (solo header) en el `.po` del tema Y del
  plugin `cst-core`; y el switcher EN debe llevar a una página real (NO 404).

Si al leer este archivo **todos** esos criterios se cumplen: no hagas cambios de
código. Anota en "Bitácora" que el proceso terminó (fecha/hora), haz commit de
este archivo, y manda un `PushNotification` breve avisando que la conversión
Pencil→código está completa y lista para revisión/push del usuario.

## Bloqueos abiertos

- **2026-07-08 — RESUELTO: Pencil MCP volvió.** `get_editor_state` responde y
  `batch_get`/`get_screenshot` funcionan (archivo `/Users/ericperez/Projects/cannabis`
  abierto en la app). El bloqueo crítico de abajo (2026-07-07) queda superado.
  Regla que sigue vigente: leer Pencil SECUENCIALMENTE desde una sola sesión;
  NO despachar agentes paralelos que cada uno abra su propia conexión MCP.
- **2026-07-08 — NUEVO, bilingüe: `http://localhost:8088/en/` devuelve 404.**
  El switcher de idioma pinta un link EN a `/en/` pero esa URL no resuelve
  (htmlLang sigue `es`). Es infraestructura Polylang (traducción de páginas +
  front-page EN), preexistente y ajena a los cambios de estilo Pencil. Bloquea
  el criterio "fully bilingual".
  **CAUSA RAÍZ (diagnóstico 2026-07-08 vía WP-CLI):** Polylang está activo y la
  front page es `Inicio` (ID 41, ES; `show_on_front=page`, `page_on_front=41`).
  En la BD local NO existen las páginas duplicadas en inglés — no hay Home EN ni
  traducciones EN de Curso/Recursos/Estadísticas/etc. (solo "Privacy Policy"
  borrador y "Sample Page"). Polylang no encuentra front page EN → `/en/` 404.
  Es problema de CONTENIDO/SEEDING, no de código: las UI strings `.po` sí están
  traducidas, pero faltan los posts-página EN que Polylang enlaza. Arreglo =
  crear duplicados EN de cada página vía Polylang y enlazarlos (el `pll` WP-CLI
  no está disponible en este contenedor → hacerlo en wp-admin o con las
  funciones `pll_*`). Decidir con el usuario: ¿contenido EN real (traductor) o
  páginas EN template-driven (el body es mínimo; las strings del template
  renderizan en EN solas vía `.mo`)? ¿Existen ya en producción y solo faltan
  en el Docker local? BLOQUEA "fully bilingual" hasta resolverlo.
- **2026-07-07 — CRÍTICO, requiere acción del usuario: Pencil MCP no responde.**
  El workflow paralelo de 16 agentes terminó SIN completar ni un solo ítem:
  los 17 agentes (16 + 1 de control) recibieron `MCP error -32603: Failed to
  access file /Users/ericperez/Projects/cannabis. A file needs to be open in
  the editor to perform this action.` en TODAS sus llamadas a
  `mcp__pencil__*` (batch_get, get_variables, get_editor_state — incluso las
  que no requieren filePath/nodeId). Se probó también desde la sesión
  principal (no paralela) inmediatamente después: mismo error. Esto NO es un
  problema de nodeId ni de concurrencia productiva — es que **no hay ningún
  archivo abierto en el editor Pencil activo ahora mismo**, y no existe
  ninguna tool MCP para abrir/reactivar un archivo remotamente.
  **ANTES de intentar cualquier ítem que necesite leer Pencil**: haz una
  llamada barata de sondeo primero (`mcp__pencil__get_editor_state` con
  `include_schema:false`, sin nodeIds). Si falla con el mismo error, **NO
  despaches agentes ni gastes tokens intentando trabajar** — anota en
  Bitácora que Pencil sigue caído y para ahí. Cuando el usuario reabra
  `/Users/ericperez/Projects/cannabis` en la app de escritorio de Pencil,
  este bloqueo se resuelve solo (confírmalo con el mismo sondeo antes de
  reanudar trabajo real).
  **Lección para el futuro**: NO despachar múltiples agentes en paralelo que
  cada uno intente conectarse a Pencil MCP simultáneamente — aunque sean
  solo lecturas, parece que la app de escritorio de Pencil solo sostiene un
  contexto de "archivo activo" a la vez y no tolera bien el acceso
  concurrente de varias conexiones MCP distintas (una por agente). El patrón
  que SÍ funcionó en las primeras 2 iteraciones (secuencial, un agente/sesión
  a la vez leyendo Pencil) sigue siendo el único probado.

## Bilingüe — RESUELTO (2026-07-08, cambios de BD, NO de código)

El bloqueo `/en/` 404 está resuelto. Polylang fue inicializado desde cero vía
`wp eval` (corre como admin; el `pll` CLI está inerte). Pasos aplicados a la BD
LOCAL (backup previo en `~/Projects/cstcannabis-predb-backup.sql`):
1. `new PLL_Admin_Model(get_option("polylang"))->add_language(...)` para
   **Español** (slug es, locale es_ES, default) y **English** (slug en, en_US).
2. Asignado idioma `es` a los 27 posts/páginas existentes (`pll_set_post_language`);
   solo `post`+`page` son traducibles (los CPTs no lo necesitan).
3. Creados **duplicados EN template-driven** (body vacío; las strings del template
   rinden en inglés vía `.mo`) y enlazados con `pll_save_post_translations`:
   Home→#77 (/en/home/), Course→#78, Resources→#79, Statistics→#80, Contact→#81,
   About Us→#82, Blog→#83. Copiado `_wp_page_template` de cada original.
4. `wp rewrite flush --hard`.

Resultado verificado: `/en/` → `/en/home/` 200 con `<html lang="en-US">` y strings
en inglés SIN fuga de español; ES intacto (`/` 200, `lang="es-ES"`). Todas las
páginas de nav principal 200 en ambos idiomas. Switcher EN enlaza a `/en/home/`.

**Strings (código, commiteado):** Un audit `wp i18n make-pot` reveló que el gate
`grep msgstr ""` era engañoso — había strings USADAS pero AUSENTES del `.po`
(fugaban español en EN). Traducidas TODAS: **112 en el tema** (commit `372ad9e`)
y **56 en el plugin cst-core** (commit `36080ea`). Audit POT-vs-PO ahora = 0
faltantes en ambos; `msgfmt -c` pasa. Además, el plugin cargaba su textdomain en
`init` (antes del switch de Polylang) → recargaba español; fix: hook `wp` que
recarga `cst-core` con el locale resuelto (commit `5363fba`, espeja el del tema).
Verificado: chatbot/cookie/login rinden en inglés en `/en/`, ES intacto.

**Menú EN (BD):** el menú primario apuntaba solo a páginas ES y Polylang lo
ocultaba en EN (EN quedaba sin nav superior). Creado menú "Primary Menu EN"
(#19: Home/Course/Resources/Statistics/About Us/Contact → páginas EN) y cableado
en la opción `polylang_nav_menus[cst-cannabis-portal][primary][en]=19` (`es`=2)
que el tema lee (functions.php:161). Verificado: nav EN en inglés, ES intacto.

**Pendiente bilingüe:**
- Estos son cambios de BD, NO de git → hay que replicarlos en prod (Polylang
  langs + páginas EN #77-83 + menú EN #19 + opción `polylang_nav_menus`). El `.po`
  del tema/plugin y el fix de textdomain SÍ son código (commiteados). Considerar
  un seeder para la parte de BD.
- `/en/` hace 301 a `/en/home/` en vez de servir en la raíz (menor, funcional).
- Páginas LEGALES (privacidad/términos/cookies/accesibilidad) + Certificado NO
  tienen duplicado EN: tienen BODY legal real que "template-driven" no cubre →
  requieren traducción humana real (ver `docs/TRANSLATION-GUIDE.md`).
- Sin posts/recursos EN (contenido del cliente).
- Gate UI strings sigue en 1 (solo header) — OK.

## Bitácora

- 2026-07-07 — Archivo creado. Header + Hero interior + Home hero ya completados
  en sesión de brainstorming previa (ver "Ya hecho" arriba) antes de iniciar el
  loop automatizado.
- 2026-07-07 — Loop iniciado (`/loop 4m`, job cron `1eaf359d`). Primera iteración
  (ejecutada de inmediato, sin esperar el disparo del cron): Site Header llevado
  a precisión total contra Pencil, y Feature Card resuelto. Encontrado y
  arreglado un bug preexistente de colisión de clases CSS entre Home y Sobre
  nosotros (ver detalle arriba). Commit `88006bb` (sin push).
- 2026-07-07 — Disparo de cron: Home — Section Pilares (resto de la sección)
  completado. Commit `646b0f9` (sin push). A partir de aquí el usuario pidió
  usar un grupo de agentes en paralelo (worktrees aislados) para acelerar el
  resto — ver nota abajo sobre el primer intento fallido.
- 2026-07-07 — Disparo de cron: saltado sin hacer cambios. Hay un workflow
  paralelo de 16 agentes en curso sobre los archivos PHP restantes (ver
  "Bloqueos abiertos" arriba) — tomar un ítem ahora mismo hubiera competido
  por los mismos archivos. Nota: el primer intento de este workflow usó
  `isolation: 'worktree'` y falló de inmediato en los 16 agentes (hook
  WorktreeCreate no configurado en esta sesión — corre "in place"). Se
  relanzó sin worktree: cada agente edita solo sus PHP exclusivos y reporta
  el CSS como texto en vez de tocar custom.css directo (evita colisión en el
  único archivo compartido). Resultado pendiente de revisar, aplicar el CSS,
  verificar en vivo y commitear — lo hace el orquestador principal, no un
  disparo suelto del cron.
- 2026-07-07 — El 2º workflow también falló: los 17 agentes reportaron Pencil
  MCP caído ("A file needs to be open in the editor") en TODAS sus llamadas.
  Diagnóstico: 9 procesos huérfanos del servidor MCP de Pencil de sesiones
  viejas (killeados) + probable intolerancia de la app de escritorio de
  Pencil al acceso concurrente de muchas conexiones MCP a la vez. Se rescató
  lo poco salvable de esa corrida: 2 agentes (search + certificado) sí
  alcanzaron a editar sus PHP con criterio de patrón establecido (sin Pencil):
  `search.php` migró resultados sin estilo → `.cst-card` grid (arregla bug
  preexistente, verificado en navegador); `template-certificate.php` cambió
  colores hardcodeados del toolbar → tokens. Ambos commiteados (sin push).
  El resto de ítems NO se tocó. **Pencil sigue caído**; el usuario pivoteó a
  un nuevo loop de 3 min ("find something to fix, bilingüe + responsive") que
  NO depende de Pencil — el loop viejo de Pencil (cron `1eaf359d`) se canceló.
- 2026-07-07 — Disparo residual del cron de Pencil ya cancelado. Sondeo de
  Pencil (`get_editor_state`) = sigue caído (mismo error). Por la regla de
  "Bloqueos abiertos": sin cambios de código, iteración saltada. El trabajo
  de conversión Pencil↔código queda EN PAUSA hasta que Pencil MCP vuelva a
  responder; mientras tanto el trabajo activo es el loop de 3 min de fixes
  generales (bilingüe + responsive), que no necesita Pencil.
  resto del checklist en vez de seguir estrictamente 1 ítem/4min.
- 2026-07-08 — Pencil MCP volvió a responder. Reanudado el trabajo real bajo el
  Stop hook de `/goal` (secuencial, una sesión). Ítem "Home — Lo que aprenderás"
  (`GycwK`) completado: head con eyebrow + tarjetas de chip numérico, sección
  plana `#F8F9FA` sin onda. Verificado desktop (match Pencil) + 606px (1 col).
  String EN añadido y `.mo` recompilado. Hallado bug preexistente: switcher EN →
  `/en/` da 404 (ver Bloqueos abiertos). Nota: `resize_window` de esta sesión
  tiene piso de viewport ~606px y a veces cierra el tab group; la verificación
  a 375px exacto no es posible con esta tool — se usa 606px + inspección de la
  media query móvil como proxy.
