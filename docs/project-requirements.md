# CST Portals — Project Requirements & PRITS Guidelines

> Source: Propuesta de Desarrollo Web — Custom Project LLC (Nov 2024)
> Client: Comisión para la Seguridad en el Tránsito de Puerto Rico (CST)

---

## 1. Project Scope

Two educational web portals for the CST:

| # | Portal | Theme Dir | Domain |
|---|--------|-----------|--------|
| 1 | Orientación en el Uso Responsable de Cannabis Medicinal y/o Derivados | `cst-cannabis-portal` | `cannabis.cst.pr.gov` |
| 2 | Uso Seguro y Responsable de Four Tracks en Puerto Rico | `cst-four-tracks-portal` | `fourtracks.cst.pr.gov` |

Both portals share the same tech base (`cst-core` plugin), visual style, and navigation structure. Only design tokens (colors, branding) and content differ per portal.

### What is NOT included
- Content creation (text, photos, videos, art) — provided by the client
- Hosting and domain management — handled by PRITS under `.pr.gov`
- Server administration

---

## 2. Site Structure (Per Portal)

Each portal has these sections:

| Section | Page Template | Slug | Description |
|---------|--------------|------|-------------|
| Inicio | `template-home.php` | `/` | Hero, program objectives, latest posts, events, stats |
| Blog y Noticias | WP default archive | `/blog/` | Articles, press releases, official publications |
| Eventos | The Events Calendar | `/eventos/` | Webinars, workshops, calendar, free registration |
| Recursos | `template-resources.php` | `/recursos/` | Downloadable guides, infographics, videos, educational materials |
| Chatbot Educativo | (widget, all pages) | — | Automated FAQ assistant |
| Estadísticas | `template-statistics.php` | `/estadisticas/` | Public metrics dashboard (participation, usage) |
| Contacto | `template-contact.php` | `/contacto/` | Contact form + quick channel (WhatsApp or email) |
| Avisos Legales | `template-legal.php` | `/politica-privacidad/`, `/terminos-uso/`, `/accesibilidad/` | Privacy, cookies, terms of use, disclaimers |

---

## 3. Technical Requirements

### 3.1 Platform
- **CMS**: WordPress 6.4+ with GeneratePress (free) as parent theme
- **PHP**: 8.1+
- **Database**: MySQL 5.7+ / MariaDB 10.4+
- **Architecture**: Shared plugin (`cst-core`) + portal-specific child themes

### 3.2 PWA (Progressive Web App)
- Offline access via service worker (Progressify plugin)
- Optimized loading speed
- Push notification support
- Installable on mobile devices

### 3.3 Chatbot Educativo (AI-powered)
- NLP integration (ChatGPT API or similar) based on site content
- Fallback to local FAQ search (`cst_faq` CPT) when no LLM configured
- Rate limiting: 10 requests/min per IP
- REST endpoint: `POST /wp-json/cst/v1/chat`

### 3.4 Public Metrics Dashboard
- Statistics via `cst_statistic` CPT with REST API
- Chart.js 4 visualizations (bar, line, doughnut)
- Categories, trends, source citations
- REST endpoint: `GET /wp-json/cst/v1/statistics`

### 3.5 Bilingual Support
- Spanish (default) and English via Polylang
- All pages, menus, and widget content translatable
- `lang="es"` attribute on `<html>` (respects Polylang language)

### 3.6 Security
- **HTTPS** required (SSL certificate mandatory)
- **HSTS**: `max-age=31536000; includeSubDomains; preload`
- **CSP**: Restrictive Content-Security-Policy (allow Google Fonts, Analytics, YouTube, WhatsApp API)
- **X-Frame-Options**: `SAMEORIGIN`
- **Referrer-Policy**: `strict-origin-when-cross-origin`
- **Permissions-Policy**: Deny camera, microphone, geolocation, payment, USB
- **X-Content-Type-Options**: `nosniff`
- **X-XSS-Protection**: `1; mode=block`
- **WAF**: Basic web application firewall
- **2FA**: Two-factor authentication for admin users
- **Backups**: Automated daily backups (30-day retention)

### 3.7 Required Plugins
| Plugin | Purpose | Free/Paid |
|--------|---------|-----------|
| CST Core | CPTs, security, chatbot, WhatsApp, statistics | Custom |
| Polylang | Bilingual ES/EN | Free |
| Yoast SEO | Breadcrumbs, SEO | Free |
| Contact Form 7 | Contact forms | Free |
| The Events Calendar | Events management | Free |
| Download Manager | Resource file downloads | Free |
| Progressify | PWA manifest & service worker | Free |

---

## 4. PRITS-004 / GUIDI Design Guidelines

All government portals under `.pr.gov` must comply with PRITS-004 standards and the Puerto Rico Government Brand Style Book (GUIDI).

### 4.1 Color Palette

| Token | Hex | PANTONE | Usage |
|-------|-----|---------|-------|
| `--cst-color-teal` | `#115E67` | 5473 C | Primary — headers, nav, accents |
| `--cst-color-coral` | `#E56A54` | 7416 C | Secondary — CTAs, active states |
| `--cst-color-blue` | `#0050F0` | — | PR flag blue — focus indicators, links |
| `--cst-color-red` | `#EE0000` | — | PR flag red — danger, alerts |
| `--cst-color-white` | `#FFFFFF` | — | Backgrounds |
| Neutrals | `#212529` → `#F8F9FA` | — | Text and surface scale |

The Four Tracks portal will override these tokens with its own branding while keeping the same CSS custom property names.

### 4.2 Typography

| Role | Font | Source |
|------|------|--------|
| Body | Montserrat | Google Fonts |
| Headings | Cormorant Garamond | Google Fonts |

Size scale: 14px (sm) → 16px (base) → 18px (lg) → 24px (xl) → 32px (2xl) → 40px (3xl) → 48px (4xl)

### 4.3 Government Banner
- Dark strip at very top of every page
- Contains government seal and identifier text
- Required by PRITS for all `.pr.gov` sites

### 4.4 Institutional Header
- Sticky glass-effect header below gov banner
- Contains CST seal/logo, site title, and primary navigation
- z-index: 1000

### 4.5 Navigation (Government Style)
- USA.gov-inspired horizontal nav bar
- Desktop: white bg, shadow, semibold links, teal hover underline, coral active state
- Dropdowns: white panel, teal top accent, left-border hover indicator
- Mobile (<=768px): teal hamburger (44x44px), full-width drawer, stacked links
- Keyboard: Arrow keys, Tab, Escape — full keyboard navigation
- ARIA attributes: `aria-current="page"`, `aria-expanded`, `role="navigation"`

### 4.6 Component Patterns
- Glass morphism on header (rgba 0.85 + backdrop-filter blur 12px)
- Gradient accents (teal → coral)
- Card borders with gradient (teal → coral)
- Shadow palette: sm, md, xl, glow variants
- Transitions: 0.2s default, 0.4s slow, 0.5s spring

### 4.7 Layout
- Max content width: 1200px, centered
- Responsive breakpoints: 320px, 768px, 1024px, 1440px
- Mobile-first approach

---

## 5. Accessibility Requirements (WCAG 2.1 AA / Ley 229-2003)

Compliance with:
- **WCAG 2.1 Level AA** (W3C)
- **Ley 229-2003** (Puerto Rico — Ley de Derechos de las Personas con Impedimentos)
- **Section 508** (US Rehabilitation Act)

### 5.1 Navigation
- Skip-to-content link ("Ir al contenido principal")
- Hierarchical, semantic heading structure
- Breadcrumbs on all internal pages (Yoast SEO)
- Navigation menus with ARIA roles and landmarks

### 5.2 Content
- Alt text on all informational images
- Minimum contrast ratio: 4.5:1 (normal text), 3:1 (large text, UI components)
- `lang="es"` attribute on `<html>`

### 5.3 Interactivity
- All interactive elements keyboard-accessible
- Focus-visible indicators: 3px solid, 2px offset
- Touch targets: minimum 44x44px
- `aria-live` regions for status messages (chat, filter results)
- Focus trap in dialogs
- Escape key closes menus and dialogs

### 5.4 Compatibility
- High contrast mode support (solid borders, no shadows, darker colors)
- Windows forced-colors support (system colors)
- `prefers-reduced-motion: reduce` respected (no transitions/animations)
- Screen reader compatible (NVDA, JAWS, VoiceOver)
- Keyboard-only navigation tested
- Responsive from 320px width

### 5.5 Forms
- All fields have associated `<label>` elements
- Required fields marked with `aria-required`
- Validation errors announced automatically via `aria-live`

---

## 6. Custom Post Types

| CPT | Slug | Public | Purpose |
|-----|------|--------|---------|
| `cst_resource` | `/recursos/` | Yes (archive) | Educational materials — guides, infographics, videos |
| `cst_statistic` | — | No (admin only) | Metrics/KPIs — value, unit, icon, order, source, trend, category |
| `cst_faq` | — | No (admin only) | Chatbot knowledge base — question (title), answer (content) |

### Taxonomy
- `cst_resource_type` (hierarchical): Guías, Infografías, Videos, Documentos legales, Investigaciones

---

## 7. REST API Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/wp-json/cst/v1/statistics` | Public | All statistics, ordered by meta_order. `?limit=N` |
| `GET` | `/wp-json/cst/v1/statistics/dashboard` | Public | Statistics grouped by category with Chart.js configs |
| `POST` | `/wp-json/cst/v1/chat` | Public (rate-limited) | Chatbot — `{ message }` → `{ reply, source }` |

---

## 8. Project Phases & Deliverables

| Phase | Description | Deliverables | Duration |
|-------|-------------|--------------|----------|
| 1. Analysis & Functional Design | Architecture, wireframes, visual guide for both sites | Navigable prototype + base structure | 1 week |
| 2. Development & Integration | Technical implementation of both sites, PWA, chatbot | Functional sites in test environment | 3 weeks |
| 3. PRITS Validation & Testing | Accessibility, SEO, performance, security review | Technical compliance report | 1 week |
| 4. Publication & Training | Delivery to PRITS for `.pr.gov` publication + editor training | Production-ready sites + documentation | 1 week |

**Total estimated duration**: 6 weeks (both portals in parallel)

---

## 9. Deployment

- Hosting and `.pr.gov` domain provided and managed by **PRITS**
- Delivery as theme + plugin files (rsync or zip)
- Database migration via WP-CLI (`wp search-replace`)
- Post-deploy: flush rewrites, verify activation, clear cache
- SSL required (HSTS enforced by plugin)

---

## 10. Current Implementation Status

### Completed
- [x] Project architecture (shared plugin + child theme pattern)
- [x] `cst-core` plugin: CPTs, security headers, accessibility, settings, WhatsApp, chatbot, statistics
- [x] `cst-cannabis-portal` theme: design tokens, page templates, template parts, GP hooks
- [x] Documentation: technical architecture, setup guide, deployment guide, accessibility statement
- [x] Primary navigation redesign (gov-style, Phase 1-5)

### In Progress
- [ ] Home page template refinements (hero, sections)
- [ ] Statistics dashboard enhancements (charts, categories, trends)
- [ ] Hero images and illustrations (untracked assets)

### Not Started
- [ ] Four Tracks portal child theme (`cst-four-tracks-portal`)
- [ ] PRITS validation and compliance report
- [ ] PWA configuration and testing
- [ ] LLM API integration for chatbot
- [ ] Editor training documentation
- [ ] Bilingual content translation setup
- [ ] Events calendar configuration
- [ ] Production deployment to `.pr.gov`
