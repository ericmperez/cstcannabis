# WordPress Setup Guide — CST Cannabis Portal

## Prerequisites

- WordPress 6.4+, PHP 8.1+
- GeneratePress theme (free or premium)
- SSL certificate (required for HSTS headers)

## Required Plugins

| Plugin | Purpose | Free/Paid |
|--------|---------|-----------|
| CST Core | Custom post types, security, chatbot, WhatsApp | Custom |
| Polylang | Bilingual ES/EN support | Free |
| Yoast SEO | Breadcrumbs, SEO | Free |
| Contact Form 7 | Contact page form | Free |
| The Events Calendar | Events management | Free |
| Download Manager | Resource file downloads | Free |
| Progressify | PWA manifest & service worker | Free |

## Installation Steps

### 1. Install Theme

1. Install and activate **GeneratePress** from wp-admin > Themes.
2. Upload `cst-cannabis-portal` folder to `wp-content/themes/`.
3. Activate **CST Cannabis Medicinal Portal** child theme.

### 2. Install CST Core Plugin

1. Upload `cst-core` folder to `wp-content/plugins/`.
2. Activate **CST Core** from Plugins menu.

### 3. Create Pages

Create the following pages with the specified page templates:

| Page Title | Page Template | Slug |
|-----------|---------------|------|
| Inicio | Página de inicio | / (set as static front page) |
| Recursos | Recursos educativos | /recursos/ |
| Estadísticas | Estadísticas | /estadisticas/ |
| Contacto | Contacto | /contacto/ |
| Política de privacidad | Página legal | /politica-privacidad/ |
| Términos de uso | Página legal | /terminos-uso/ |
| Accesibilidad | Página legal | /accesibilidad/ |
| Blog | (default) | /blog/ |

### 4. Configure Settings

#### Reading Settings
- **Your homepage displays**: A static page
- **Homepage**: Inicio
- **Posts page**: Blog

#### Permalinks
- **Structure**: Post name (`/%postname%/`)

#### CST Portal Settings (Settings > CST Portal)
- **WhatsApp**: Enable, enter phone number with country code
- **Chatbot**: Enable, optionally configure LLM API
- **Greeting message**: Customize welcome text

#### Customizer (Appearance > Customize)
- **Portal CST**: Upload hero image, set title/subtitle overrides
- **Contact Info**: Enter phone, email, physical address
- **Social Links**: Enter URLs for Facebook, Twitter, Instagram, YouTube
- **Site Identity**: Upload CST seal as site logo

### 5. Navigation Menus

Create and assign these menus (Appearance > Menus):

#### Primary Menu (Menú principal)
- Inicio
- Sobre nosotros
- Recursos
- Estadísticas
- Blog
- Contacto

#### Footer Menu (Menú del pie de página)
- Recursos
- Estadísticas
- Blog
- Contacto

#### Legal Links (Enlaces legales)
- Política de privacidad
- Términos de uso
- Accesibilidad

### 6. Resource Types Taxonomy

Create categories under Resources > Tipos de recurso:

- Guías
- Infografías
- Videos
- Documentos legales
- Investigaciones

### 7. Plugin Configurations

#### Yoast SEO
- Enable breadcrumbs: SEO > Search Appearance > Breadcrumbs > Enable

#### Polylang
- Add languages: Español (es), English (en)
- Set Español as default
- Translate all pages and menu items

#### Contact Form 7
- Create a contact form and paste its shortcode in the Contacto page content

#### Progressify
- Set app name, short name, and icons in Progressify settings
- Enable offline caching

### 8. Add Content

#### Statistics (cst_statistic CPT)
Create statistic entries with:
- Title (label shown on card)
- Numeric value
- Unit/suffix (%, pacientes, etc.)
- Icon (dashicons class)
- Sort order
- Source citation

#### FAQ / Chatbot Knowledge Base (cst_faq CPT)
Create FAQ entries:
- Title = the question
- Content = the answer

The chatbot will search these FAQs when responding to user messages.

#### Resources (cst_resource CPT)
Create educational resources:
- Title, excerpt, featured image
- Assign resource type taxonomy
- Add download files via content editor

## Testing Checklist

- [ ] Home page loads with hero, objectives, posts, events, stats
- [ ] Government banner displays and toggles correctly
- [ ] All page templates selectable and rendering properly
- [ ] Resources filter tabs work
- [ ] Statistics counters animate on scroll
- [ ] Chatbot opens, sends messages, receives responses
- [ ] WhatsApp button appears after scrolling
- [ ] Breadcrumbs show on all pages except home
- [ ] Language switcher works (with Polylang)
- [ ] Site works at 320px, 768px, 1024px, 1440px
- [ ] Keyboard navigation works throughout
- [ ] Skip link visible on focus
