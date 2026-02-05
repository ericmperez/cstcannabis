# Technical Architecture — CST Educational Portals

## Overview

The CST portals follow a **shared plugin + themed child themes** architecture, built on WordPress + GeneratePress.

```
cst-portals/
├── plugins/
│   └── cst-core/              # Shared functionality
│       ├── cst-core.php        # Plugin bootstrap & autoloader
│       ├── includes/
│       │   ├── class-cst-core.php            # Singleton orchestrator
│       │   ├── class-cst-post-types.php      # CPTs & taxonomies
│       │   ├── class-cst-security.php        # HTTP security headers
│       │   ├── class-cst-accessibility.php   # WCAG enhancements
│       │   ├── class-cst-settings.php        # Admin settings page
│       │   ├── class-cst-whatsapp.php        # Floating WhatsApp button
│       │   ├── class-cst-statistics.php      # Shortcode + REST API
│       │   ├── class-cst-chatbot.php         # Chat widget + REST API
│       │   └── class-cst-chatbot-context.php # FAQ knowledge base
│       └── assets/
│           ├── css/  (whatsapp, statistics, chatbot)
│           └── js/   (whatsapp, statistics, chatbot)
├── themes/
│   └── cst-cannabis-portal/    # GeneratePress child theme
│       ├── style.css           # Design tokens (CSS custom properties)
│       ├── functions.php       # Theme setup & enqueues
│       ├── inc/
│       │   ├── gp-hooks.php           # GP hook callbacks
│       │   ├── widgets.php            # Widget areas
│       │   ├── template-functions.php # Helper functions
│       │   └── customizer.php         # Customizer settings
│       ├── template-parts/     # Reusable partials
│       ├── page-templates/     # Page templates
│       └── assets/
│           ├── css/  (custom, accessibility)
│           ├── js/   (main)
│           └── images/
└── docs/
```

## Custom Post Types

### cst_resource (Educational Resources)
- **Public**: Yes, with archive
- **Slug**: `/recursos/`
- **Supports**: title, editor, thumbnail, excerpt, revisions
- **Taxonomy**: `cst_resource_type` (hierarchical)

### cst_statistic (Metrics)
- **Public**: No (admin UI only)
- **Custom meta fields**:
  - `_cst_stat_value` (numeric value)
  - `_cst_stat_unit` (suffix: %, pacientes, etc.)
  - `_cst_stat_icon` (dashicons class)
  - `_cst_stat_order` (display order)
  - `_cst_stat_source` (citation)

### cst_faq (Chatbot Knowledge Base)
- **Public**: No (admin UI only)
- **Title**: Question
- **Content**: Answer
- Cached via transients (1 hour, auto-invalidated on save)

## REST API Endpoints

### GET /wp-json/cst/v1/statistics
Returns all published statistics ordered by `_cst_stat_order`.

**Query params**: `?limit=4`

**Response**:
```json
[
  {
    "id": 1,
    "title": "Pacientes registrados",
    "value": "120000",
    "unit": "pacientes",
    "icon": "dashicons-groups",
    "source": "Departamento de Salud, 2024",
    "order": "1"
  }
]
```

### POST /wp-json/cst/v1/chat
Sends a message to the chatbot and receives a reply.

**Request body**:
```json
{
  "message": "¿Qué es el cannabis medicinal?"
}
```

**Response**:
```json
{
  "reply": "El cannabis medicinal es...",
  "source": "faq"  // "faq", "llm", "default", or "rate_limit"
}
```

**Rate limiting**: 10 requests/minute per IP (transient-based).

**Flow**:
1. If LLM API configured → proxy to external endpoint
2. If no LLM → search `cst_faq` posts (keyword scoring)
3. If no match → return default message with optional WhatsApp link

## Security Headers

Sent on all front-end responses via `send_headers` action:

| Header | Value |
|--------|-------|
| Strict-Transport-Security | max-age=31536000; includeSubDomains; preload |
| Content-Security-Policy | Restrictive policy allowing Google Fonts, Analytics, YouTube embeds |
| X-Frame-Options | SAMEORIGIN |
| Referrer-Policy | strict-origin-when-cross-origin |
| Permissions-Policy | camera=(), microphone=(), geolocation=(), etc. |
| X-Content-Type-Options | nosniff |
| X-XSS-Protection | 1; mode=block |

## Design System

Based on **PRITS-004 / GUIDI** standards:

### Typography
- **Body**: Montserrat (Google Fonts)
- **Headings**: Cormorant Garamond (Google Fonts)

### Color Palette
| Token | Hex | Usage |
|-------|-----|-------|
| `--cst-color-red` | #EE0000 | PR flag red, danger |
| `--cst-color-blue` | #0050F0 | PR flag blue, focus indicators |
| `--cst-color-teal` | #115E67 | Primary (PANTONE 5473 C) |
| `--cst-color-coral` | #E56A54 | Secondary/CTA (PANTONE 7416 C) |
| `--cst-color-white` | #FFFFFF | Backgrounds |

### Theming
All colors, fonts, and spacing are defined as CSS custom properties in `style.css`. The Four Tracks portal will override these tokens with its own branding.

## Accessibility (WCAG 2.1 AA / Ley 229)

- Skip-to-content link
- ARIA landmarks on all structural elements
- `lang="es"` attribute on `<html>`
- `aria-current="page"` on active nav links
- Focus-visible indicators (3px solid, offset 2px)
- Touch targets minimum 44x44px
- High contrast mode support
- Forced colors (Windows) support
- Reduced motion respected
- CF7 form accessibility fixes (labels, aria-required, error announcements)
- Screen reader announcements for filter results and chat messages

## Chatbot Architecture

```
User Input
    │
    ▼
POST /cst/v1/chat
    │
    ├─ Rate limit check (10/min/IP)
    │
    ├─ LLM API configured?
    │   ├─ Yes → Proxy to external API → Return reply
    │   └─ No ─┐
    │          ▼
    ├─ Search cst_faq CPT (CST_Chatbot_Context)
    │   ├─ Match found → Return FAQ answer
    │   └─ No match → Return default + WhatsApp link
    │
    ▼
JSON Response { reply, source }
```

The FAQ matching algorithm:
1. Normalizes text (lowercase, remove accents, strip punctuation)
2. Extracts words (3+ characters)
3. Scores matches: 3 points per word in question title, 1 point per word in answer
4. Returns best match if score >= 2
