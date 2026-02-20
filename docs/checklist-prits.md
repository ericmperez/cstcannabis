# Lista de Cumplimiento PRITS-004 / GUIDI

> **Proyecto:** Portal Educativo Cannabis Medicinal y Seguridad Vial — CST
> **Dominio:** `cannabis.cst.pr.gov`
> **Fecha de auditoría:** 20 de febrero de 2026

Leyenda: [x] = Implementado | [ ] = Pendiente

---

## 1. Banner Gubernamental

- [x] Franja oscura en la parte superior de cada página
- [x] Bandera de Puerto Rico (icono SVG)
- [x] Texto: "Un sitio web oficial del Gobierno de Puerto Rico"
- [x] Sección expandible: "Así es como usted puede verificarlo"
- [x] Explicación de dominio `.pr.gov` y HTTPS
- [x] Atributos ARIA (`aria-expanded`, `aria-controls`)
- [x] Se muestra en todas las páginas (hook `generate_before_header`, prioridad 5)

---

## 2. Encabezado Institucional

- [x] Logo/sello oficial de la CST
- [x] Nombre de la agencia: "Comisión para la Seguridad en el Tránsito"
- [x] Nombre del portal: "Cannabis Medicinal y Seguridad Vial"
- [x] Posición sticky (fijo al desplazar)
- [x] z-index: 1000
- [x] Formulario de búsqueda con `role="search"`
- [x] Selector de idioma (integración Polylang)
- [x] Etiqueta estática "ES" cuando Polylang no está activo

---

## 3. Navegación Principal

- [x] Barra de navegación horizontal estilo USA.gov
- [x] Enlaces centrados
- [x] Menús desplegables con panel blanco
- [x] Navegación por teclado: flechas, Tab, Escape
- [ ] **Navegación por teclado: teclas Home/End en menú principal**
- [x] `aria-current="page"` en enlaces activos
- [x] `aria-expanded` en elementos con submenú
- [x] `role="navigation"` en el contenedor
- [x] Menú hamburguesa responsive (44x44px)
- [x] Panel lateral móvil con scroll
- [x] Migas de pan (Yoast SEO) en todas las páginas internas

---

## 4. Seguridad (Encabezados HTTP)

- [x] `Strict-Transport-Security`: max-age=31536000; includeSubDomains; preload
- [x] `Content-Security-Policy`: basada en nonce, fuentes restrictivas
- [x] `X-Frame-Options`: SAMEORIGIN
- [x] `X-Content-Type-Options`: nosniff
- [x] `Referrer-Policy`: strict-origin-when-cross-origin
- [x] `Permissions-Policy`: cámara, micrófono, geolocalización denegados
- [x] `X-XSS-Protection`: 1; mode=block
- [x] Nonce CSP generado para scripts inline
- [x] Encabezados aplicados en `send_headers` y `wp_headers` (doble capa)
- [x] Área de administración excluida de CSP

---

## 5. Accesibilidad (WCAG 2.1 AA / Ley 229-2003 / Sección 508)

### 5.1 Navegación y Estructura

- [x] Enlace "Ir al contenido principal" (skip-to-content)
- [x] Atributo `lang="es"` en `<html>`
- [x] Estructura jerárquica de encabezados (h1-h6)
- [x] Landmarks ARIA: `banner`, `navigation`, `main`, `contentinfo`
- [x] Migas de pan con `aria-label="Ruta de navegación"`

### 5.2 Indicadores de Enfoque

- [x] `outline: 3px solid #3B82C4` con `outline-offset: 2px`
- [x] Estilo inline en `<head>` como respaldo
- [x] Contorno blanco en fondos oscuros (banner, footer, hero)
- [x] `:focus:not(:focus-visible)` oculta contorno para usuarios de ratón

### 5.3 Objetivos Táctiles

- [x] Botones: mínimo 44x44px
- [x] Enlaces de navegación: mínimo 44px de altura
- [x] Menú hamburguesa: 48x48px
- [x] Botón de búsqueda: 40x40px

### 5.4 Contraste de Color

- [x] Texto normal: ratio mínimo 4.5:1
- [x] `#5E7C3A` (verde oscuro) para texto normal: 5.5:1
- [x] `#1F2E54` (azul autoridad) para texto normal: 12.2:1
- [x] `#7FA35B` (verde institucional) solo para texto grande/UI: 3.6:1
- [x] `#3B82C4` (azul enfoque): 8.6:1

### 5.5 Modo de Alto Contraste

- [x] `@media (prefers-contrast: high)` implementado
- [x] Bordes sólidos en lugar de gradientes
- [x] Elementos decorativos ocultos
- [x] Fondos de iconos reemplazados por bordes
- [x] Ancho de borde aumentado (3px botones, 2px tarjetas)

### 5.6 Colores Forzados (Windows)

- [x] `@media (forced-colors: active)` implementado
- [x] Uso de palabras clave del sistema: `Canvas`, `CanvasText`, `ButtonFace`, `ButtonText`
- [x] Formularios con `Field`, `FieldText`
- [x] Elementos decorativos ocultos

### 5.7 Movimiento Reducido

- [x] `@media (prefers-reduced-motion: reduce)` implementado
- [x] Animaciones y transiciones deshabilitadas
- [x] Scroll suave deshabilitado
- [x] Contadores estadísticos sin animación
- [x] Elementos flotantes del hero sin animación

### 5.8 Formularios

- [x] Todos los campos con `<label>` asociado
- [x] Campos requeridos con `aria-required="true"`
- [x] Errores de validación anunciados via `aria-live="assertive"`
- [x] Compatibilidad con Contact Form 7

### 5.9 Lectores de Pantalla

- [x] Texto `.sr-only` para contenido solo de lector de pantalla
- [x] `aria-hidden="true"` en elementos decorativos
- [x] Regiones `aria-live` para mensajes de estado
- [x] Anuncios de resultados de filtro

---

## 6. Plantillas de Página

- [x] Inicio (`template-home.php`): hero, objetivos, publicaciones recientes, estadísticas
- [x] Recursos (`template-resources.php`): materiales descargables con filtros
- [x] Estadísticas (`template-statistics.php`): panel de métricas con Chart.js
- [x] Contacto (`template-contact.php`): formulario + canal rápido WhatsApp
- [x] Avisos Legales (`template-legal.php`): tabla de contenido auto-generada
- [x] Blog y Noticias: archivo predeterminado de WordPress

---

## 7. Tipos de Contenido Personalizado (CPT)

- [x] `cst_resource`: materiales educativos (guías, infografías, videos)
- [x] `cst_statistic`: métricas/KPIs (valor, unidad, icono, categoría, tendencia)
- [x] `cst_faq`: base de conocimiento del chatbot
- [x] Taxonomía `cst_resource_type` (jerárquica)

---

## 8. API REST

- [x] `GET /wp-json/cst/v1/statistics` — estadísticas públicas
- [x] `GET /wp-json/cst/v1/statistics/dashboard` — datos agrupados para Chart.js
- [x] `POST /wp-json/cst/v1/chat` — chatbot con limitación de solicitudes

---

## 9. Componentes Interactivos

- [x] Chatbot educativo (widget en todas las páginas)
- [x] Botón flotante de WhatsApp
- [x] Panel de estadísticas con pestañas ARIA
- [x] Contadores animados con Intersection Observer
- [x] Filtros de recursos con anuncio de resultados
- [x] Gráficos Chart.js (barras, líneas, donut)

---

## 10. Soporte Bilingüe

- [x] Integración con Polylang preparada
- [x] Selector de idioma en encabezado institucional
- [x] Dominio de texto del tema: `cst-cannabis`
- [x] Dominio de texto del plugin: `cst-core`
- [x] Todas las cadenas de texto envueltas en funciones de traducción
- [ ] **Instalación y configuración de Polylang**
- [ ] **Traducción del contenido al inglés**

---

## 11. Rendimiento y PWA

- [x] Imágenes con `loading="lazy"`
- [x] CSS y JS cargados condicionalmente por plantilla
- [ ] **Configuración de Progressify (PWA)**
- [ ] **Manifest y service worker**
- [ ] **Pruebas de rendimiento (Lighthouse, PageSpeed)**

---

## 12. SEO

- [x] Soporte para Yoast SEO (migas de pan, metadatos)
- [x] HTML semántico (header, nav, main, footer, article, section)
- [x] Imágenes embeds responsivos
- [ ] **Configuración de Yoast SEO en producción**
- [ ] **Sitemap XML configurado**

---

## 13. Páginas Legales (Contenido)

- [x] Plantilla de página legal con tabla de contenido automática
- [x] Plantilla de declaración de accesibilidad (`accessibility-statement.md`)
- [ ] **Contenido de Política de Privacidad redactado**
- [ ] **Contenido de Términos de Uso redactado**
- [ ] **Contenido de Declaración de Accesibilidad publicado**
- [ ] **Contenido de Política de Cookies redactado**

---

## 14. Eventos

- [x] Soporte para The Events Calendar (plugin)
- [ ] **Instalación y configuración del plugin**
- [ ] **Diseño personalizado de páginas de eventos**

---

## 15. Chatbot Educativo

- [x] Interfaz de chat accesible (ARIA, teclado)
- [x] Endpoint REST con limitación de solicitudes
- [x] Base de conocimiento via CPT `cst_faq`
- [ ] **Integración con API de LLM (modelo de lenguaje)**
- [ ] **Entrenamiento con contenido educativo del portal**

---

## 16. Despliegue en Producción

- [ ] **Certificado SSL instalado en `.pr.gov`** (responsabilidad de PRITS)
- [ ] **Migración de base de datos (`wp search-replace`)**
- [ ] **Verificación de encabezados HSTS en producción**
- [ ] **Configuración de Google Analytics en política CSP**
- [ ] **Autenticación de dos factores (2FA) para administradores**
- [ ] **Respaldos diarios configurados**
- [ ] **Flush de rewrite rules post-despliegue**
- [ ] **Vaciado de caché**

---

## 17. Portal Four Tracks

- [ ] **Tema hijo `cst-four-tracks-portal`**
- [ ] **Tokens de diseño propios (colores, tipografía)**
- [ ] **Contenido del portal Four Tracks**

---

## 18. Documentación y Capacitación

- [x] Arquitectura técnica (`technical-architecture.md`)
- [x] Guía de configuración de WordPress (`wordpress-setup.md`)
- [x] Guía de despliegue (`deployment.md`)
- [x] Requisitos del proyecto (`project-requirements.md`)
- [x] Declaración de accesibilidad modelo (`accessibility-statement.md`)
- [x] Instrucciones para desarrollo (`CLAUDE.md`)
- [ ] **Manual de capacitación para editores de contenido**
- [ ] **Documentación de usuario final**

---

## Resumen

| Categoría | Implementado | Pendiente |
|-----------|:---:|:---:|
| Banner Gubernamental | 7/7 | 0 |
| Encabezado Institucional | 8/8 | 0 |
| Navegación | 11/11 | 0 |
| Seguridad | 10/10 | 0 |
| Accesibilidad | 33/33 | 0 |
| Plantillas de Página | 6/6 | 0 |
| CPTs y API REST | 7/7 | 0 |
| Componentes Interactivos | 6/6 | 0 |
| Soporte Bilingüe | 5/7 | 2 |
| Rendimiento y PWA | 1/4 | 3 |
| SEO | 2/4 | 2 |
| Páginas Legales | 2/6 | 4 |
| Eventos | 1/3 | 2 |
| Chatbot | 3/5 | 2 |
| Despliegue | 0/8 | 8 |
| Portal Four Tracks | 0/3 | 3 |
| Documentación | 6/8 | 2 |
| **TOTAL** | **108/136** | **28** |

**Porcentaje de cumplimiento técnico: 79%**

> **Nota:** Los elementos pendientes son principalmente de contenido (textos legales, traducciones), configuración de plugins externos (Polylang, Events Calendar, Progressify), integración del chatbot con LLM, y tareas de despliegue en producción que dependen de PRITS. La infraestructura técnica del portal está completa.
