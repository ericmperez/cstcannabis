# CST Cannabis Portal — Primary Navigation Redesign

**Goal:** Restyle the GeneratePress primary navigation menu into a modern government-style (usa.gov) horizontal nav bar with styled links, dropdowns, and mobile drawer. WCAG 2.1 AA compliant, zero build tools.

---

## Files Modified (3, no new files)

| File | Changes |
|------|---------|
| `themes/cst-cannabis-portal/assets/css/custom.css` | Replace GP override + add desktop nav, dropdowns, mobile nav (~170 new lines) |
| `themes/cst-cannabis-portal/assets/css/accessibility.css` | Nav focus indicators, high-contrast + forced-colors overrides (~25 new lines) |
| `themes/cst-cannabis-portal/assets/js/main.js` | Arrow-key keyboard navigation for dropdown menus (~55 new lines) |

---

## Current Structure (top → bottom)

1. Gov Banner (`.cst-gov-banner`) — dark strip
2. Institutional Header (`.cst-institutional-header`) — sticky, glass, z-index 1000
3. GP Primary Nav (`.site-header > .main-navigation > .main-nav > ul.sf-menu`) — currently default GP, unstyled
4. Breadcrumbs (non-home only)

GP nav HTML classes: `.site-header`, `.inside-header`, `.main-navigation`, `.inside-navigation`, `.main-nav`, `.menu.sf-menu`, `.menu-item`, `.current-menu-item`, `.current-menu-ancestor`, `.menu-item-has-children`, `.sub-menu`, `.menu-toggle`, `.sfHover`, `.toggled`

---

## Phase 1: Desktop Nav Bar (`custom.css` — GP Overrides section)

- `.site-header`: white bg, bottom border + subtle shadow, z-index 999, relative
- `.site-header .inside-header`: max-width 1200px, centered, inline padding
- Top-level links: Montserrat 14px/600, gray-700, 16px 24px padding, 52px min-height
- Hover: bottom-border slide-in (3px teal, scaleX 0→1), gray-100 bg
- Active page: coral bottom-border, bold; ancestor: teal bottom-border

## Phase 2: Dropdown Submenus (`custom.css`)

- Panel: white bg, gray-300 border, 3px teal top border, rounded bottom, shadow
- Animation: fade + slide down (opacity + translateY)
- Submenu links: 14px/500, left-border indicator (transparent→teal on hover)
- Active submenu: coral left border, teal bg tint

## Phase 3: Mobile Navigation (`custom.css` — 768px media query)

- Hamburger: teal bg, white text, 44×44 min touch target
- Drawer: white bg, teal top border, scrollable
- Stacked links with bottom borders, 52px min-height
- Active page: coral left border
- Submenus: static, gray bg, indented

## Phase 4: Keyboard Navigation (`main.js`)

- ArrowRight/Left: move between top-level items
- ArrowDown: open dropdown, focus first submenu link
- ArrowUp/Down: navigate within submenu
- Escape: close dropdown, return focus to parent

## Phase 5: Accessibility Hardening (`accessibility.css`)

- Focus: 3px blue outline on links, 3px white outline on hamburger
- High contrast: solid black borders, no shadows
- Forced colors: system colors throughout
- Reduced motion: already handled by existing global rule

---

## Verification Checklist

- [ ] Desktop: horizontal nav bar, white bg, subtle shadow, 14px semibold links
- [ ] Hover: teal bottom-border slides in, gray bg highlight
- [ ] Current page: coral bottom-border, bold text
- [ ] Dropdowns: white panel with teal top accent, left-border hover
- [ ] Keyboard: Tab through links, Arrow keys navigate, Escape closes
- [ ] Mobile (≤768px): teal hamburger, full-width drawer, stacked links
- [ ] Active page on mobile: coral left border
- [ ] Focus: blue outline on links, white outline on hamburger
- [ ] `prefers-reduced-motion: reduce`: no transitions
- [ ] `prefers-contrast: high`: solid black borders, no shadows
- [ ] `forced-colors: active`: system colors throughout
- [ ] Print: nav hidden by existing print rule
