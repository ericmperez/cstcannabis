# CST Portals — Claude Code Instructions

## Project Overview
Two educational web portals for the Comisión para la Seguridad en el Tránsito de Puerto Rico (CST):
1. **Cannabis Medicinal Portal** — `themes/cst-cannabis-portal/`
2. **Four Tracks Portal** — `themes/cst-four-tracks-portal/` (not yet created)

Both share the `plugins/cst-core/` plugin. Full requirements in `docs/project-requirements.md`.

## Architecture
- **CMS**: WordPress 6.4+ with GeneratePress (free) parent theme
- **Pattern**: Shared plugin (`cst-core`) + portal-specific child themes
- **No build tools** — vanilla CSS/JS only, no bundlers, no npm in the project

```
cst-portals/
├── plugins/cst-core/          # Shared CPTs, security, chatbot, WhatsApp, statistics
│   ├── cst-core.php           # Plugin bootstrap + autoloader
│   ├── includes/              # PHP classes (CST_Core, CST_Post_Types, etc.)
│   ├── cli/                   # WP-CLI commands
│   └── assets/                # Plugin CSS/JS (chatbot, statistics, whatsapp)
├── themes/cst-cannabis-portal/ # GeneratePress child theme
│   ├── style.css              # Design tokens (CSS custom properties)
│   ├── functions.php          # Theme setup, enqueues
│   ├── inc/                   # GP hooks, widgets, customizer, helpers
│   ├── page-templates/        # Full page templates
│   ├── template-parts/        # Reusable partials
│   └── assets/                # Theme CSS/JS/images
└── docs/                      # Project documentation
```

## Coding Standards

### PHP
- WordPress Coding Standards (WPCS)
- PHP 8.1+ features allowed
- Classes use `CST_` prefix and singleton pattern where appropriate
- Autoloader in `cst-core.php` maps `CST_ClassName` → `class-cst-classname.php`
- All strings in Spanish by default (translatable via Polylang)
- Escape output: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- Sanitize input: `sanitize_text_field()`, `absint()`, `wp_kses()`

### CSS
- Use CSS custom properties defined in `style.css` (design tokens)
- Follow the token naming convention: `--cst-color-*`, `--cst-font-*`, `--cst-space-*`, `--cst-shadow-*`
- Mobile-first responsive design
- Accessibility styles in separate `accessibility.css` file
- No `!important` unless overriding GeneratePress defaults that can't be targeted otherwise

### JavaScript
- Vanilla JS (ES5+ for compatibility, no modules/bundlers)
- Wrap in IIFE: `(function() { ... })();`
- Namespace events and DOM queries
- Always check `prefers-reduced-motion` before animations
- Use `aria-*` attributes for interactive components

### Accessibility (MANDATORY)
- Every interactive element must be keyboard-accessible
- Focus indicators: 3px solid, 2px offset
- Touch targets: 44x44px minimum
- Color contrast: 4.5:1 normal text, 3:1 large text/UI
- Use ARIA landmarks, roles, and live regions
- Support high contrast mode, forced colors, reduced motion
- Comply with WCAG 2.1 AA, Ley 229-2003, Section 508

## Design Tokens — Guía de Marca CST (Cannabis Portal)

| Token | Value | Usage |
|-------|-------|-------|
| `--cst-color-green` | `#7FA35B` | Primary — verde institucional (headers, nav) |
| `--cst-color-navy` | `#1F2E54` | Secondary — azul autoridad (CTAs, active) |
| `--cst-color-blue` | `#3B82C4` | Focus indicators, info, links |
| `--cst-color-red` | `#EE0000` | Danger, alerts |
| `--cst-color-green-light` | `#A9C58E` | Verde claro (accents) |
| `--cst-color-green-dark` | `#5E7C3A` | Verde oscuro (buttons, normal-text links) |
| Body font | Open Sans | Google Fonts |
| Heading font | Montserrat | Google Fonts |

**Contrast note:** `#7FA35B` on white = 3.6:1 (large text/UI only). For normal-sized text, use `#5E7C3A` (5.5:1) or `#1F2E54` (12.2:1).

## Key Conventions
- Page templates go in `page-templates/template-*.php`
- Reusable partials go in `template-parts/*.php`
- Plugin module classes go in `includes/class-cst-*.php`
- REST endpoints registered in their respective class files
- WP-CLI commands go in `cli/`
- All REST routes use namespace `cst/v1`

## Local Development
- Uses `wp-env` — config in `.wp-env.json`
- Start: `wp-env start` (requires Docker)
- The WordPress instance mounts `plugins/cst-core` and `themes/cst-cannabis-portal`

## Important Notes
- Content (text, photos, videos) is provided by the client — do NOT generate placeholder content
- Hosting is managed by PRITS under `.pr.gov` — deployment is file transfer only
- The Four Tracks portal reuses the same plugin but will have its own child theme with different design tokens
- Government banner at top of every page is REQUIRED by PRITS
- All security headers are set via `CST_Security` class — do not add headers elsewhere
