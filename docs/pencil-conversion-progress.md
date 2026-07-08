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

- [ ] Home — Section "Lo que aprenderás" — `template-parts/section-objectives.php`.
      Nodo Pencil: `GycwK` (hijo de Home `XCdjO`).
- [ ] Home — Section "Por qué importa" (sección navy oscura con stat + callouts) —
      verificar si ya coincide con `section-course-impact.php` (que ya es navy);
      si coincide, marcar hecho sin cambios.
- [ ] Home — Section "Enrollment CTA" (gradiente verde) —
      `template-parts/section-enrollment-cta.php`.
- [ ] Home — Section "Últimas publicaciones" —
      `template-parts/section-latest-posts.php` + `card-blog.php`.
- [ ] Footer institucional (componente global, todas las páginas) —
      `template-parts/footer-institutional.php` — comparar estructura de columnas
      exacta contra Pencil (Portal / Institución / Legal).
- [ ] Curso — Section "Intro Curso".
- [ ] Curso — Section "Módulos" — `template-parts/section-course-features.php`.
- [ ] Curso — Section "FAQ" — `template-parts/section-course-faq.php`.
- [ ] Curso — Section "Enrollment CTA" — verificar si comparte patrón con la de
      Home (si ya se resolvió arriba, este ítem puede ser trivial).
- [ ] Recursos — Section "Recursos" (grid de tarjetas + filtro) —
      `page-templates/template-resources.php` + `card-resource.php`.
- [ ] Estadísticas — Section "KPIs" — `page-templates/template-statistics.php`.
- [ ] Estadísticas — Section "Chart" (Chart.js).
- [ ] Sobre nosotros — Section "Misión".
- [ ] Sobre nosotros — Section "Valores".
- [ ] Contacto — Section "Contacto" (tarjetas info + formulario CF7).
- [ ] Accesibilidad — Section "A11y" (contenido hardcodeado, revisar solo estilo
      de contenedor/tipografía, NO el contenido legal en sí).
- [ ] Aviso legal — Section "Legal" — aplica a `/terminos-uso/` y
      `/politica-privacidad/` (`page-templates/template-legal.php`), solo estilo
      del contenedor/TOC, no el contenido legal.
- [ ] Certificado — Section "Cert" — comparar contra `template-certificate.php`
      (ya construido y verificado en sesión previa; probablemente solo necesita
      ajustes menores de token, si acaso).
- [ ] Blog — Section "Posts" — `home.php` (archivo de posts) + `card-blog.php`.
- [ ] Artículo — Section "Artículo" + "Relacionadas" — el tema NO tiene `single.php`
      propio (usa el del padre GeneratePress). Este ítem probablemente necesita
      MÁS de una iteración: primero crear `single.php` básico con el layout, luego
      afinar estilo. Está bien partirlo en sub-iteraciones.
- [ ] Búsqueda — Section "Resultados" — `search.php`.
- [ ] 404 — Section "404" — `404.php`.

## Cuándo parar

Si al leer este archivo **todos** los ítems de "Elementos pendientes" ya están
marcados `[x]`: no hagas ningún cambio de código. En vez de eso:
1. Anota en "Bitácora" que el proceso terminó, con fecha/hora.
2. Haz commit de este archivo.
3. Llama a `CronDelete` sobre el job recurrente que disparó esta iteración (usa
   `TaskList`/contexto de la sesión para encontrar su ID si no lo tienes a mano)
   para que deje de dispararse cada 4 minutos.
4. Manda un `PushNotification` breve avisando que la conversión Pencil→código
   está completa y lista para revisión/push del usuario.

## Bloqueos abiertos

- **2026-07-07** — Hay un workflow paralelo en curso (16 agentes, sin worktree,
  cada uno sobre archivos PHP exclusivos, reportando CSS como texto para que el
  orquestador lo aplique) que cubre TODOS los ítems de "Elementos pendientes"
  de una sola vez. Mientras esté corriendo: **NO tomes ningún ítem de la lista
  ni edites los archivos PHP de las páginas** (riesgo real de condición de
  carrera — dos procesos editando el mismo archivo al mismo tiempo). Si te
  disparas mientras esto sigue activo, no hagas cambios de código — anota en
  Bitácora que saltaste esta iteración por el bloqueo y para ahí. Una vez el
  workflow termine y sus cambios se mergeen/verifiquen (lo hará el usuario o
  el orquestador principal, no un disparo suelto del cron), esta nota se
  borra y el proceso normal de 1-ítem-por-iteración se reanuda.

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
  resto del checklist en vez de seguir estrictamente 1 ítem/4min.
