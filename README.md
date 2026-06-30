# Jess Linton — Website

Personal website for **Jess Linton**, HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner based in Sussex, UK.

---

## What this repository contains

| Folder | Description |
|---|---|
| `site/` | Static HTML website (v3) — production-ready, no build step |
| `fullstack-site/` | Full-stack PHP + MySQL conversion with admin CMS |

The `site/` version is the live-ready deliverable. The `fullstack-site/` version extends it with a database-driven CMS for future use.

---

## The static site (`site/`)

### Technology

| Layer | Choice | Why |
|---|---|---|
| HTML | Plain HTML5 | No build step, no framework overhead, works anywhere |
| CSS | Vanilla CSS with custom properties | Modern, fast, readable — no preprocessor needed |
| JavaScript | Vanilla ES modules | Native browser support, no bundler needed |
| Fonts | Google Fonts (Fraunces + Inter) | Loaded via `preconnect` for performance |
| Images | Squarespace CDN | Zero re-upload work — can be replaced with self-hosted files |

### Folder structure

```
site/
├── css/
│   ├── style.css              ← @import hub (do not add rules here directly)
│   ├── base/
│   │   ├── tokens.css         ← ALL design tokens (colours, fonts, spacing)
│   │   ├── reset.css          ← box-sizing reset, html/body defaults, skip link
│   │   ├── typography.css     ← heading scale (h1–h5), .display, .eyebrow, .caption
│   │   ├── utilities.css      ← .container, .prose, .sr-only, .reveal animations
│   │   └── buttons.css        ← .btn and all modifier variants
│   ├── components/
│   │   ├── nav.css            ← site header, desktop nav, dropdowns, hamburger
│   │   ├── mobile-nav.css     ← full-screen overlay nav (mobile)
│   │   ├── bottom-nav.css     ← fixed 5-tab bottom bar (mobile ≤ 768px)
│   │   ├── hero.css           ← homepage hero split layout, slideshow, marquee
│   │   ├── layout.css         ← page-header, section spacing, grid systems
│   │   ├── cards.css          ← feature cards, section cards
│   │   ├── content.css        ← media-text, rich-text, blockquotes, services
│   │   ├── gallery.css        ← masonry gallery, lightbox, photo strip
│   │   ├── blog.css           ← blog post list, articles list
│   │   ├── contact.css        ← contact split, details, registration box
│   │   ├── slideshow.css      ← section slideshows, dark/green bands
│   │   └── footer.css         ← site footer
│   └── responsive.css         ← all media queries (tablet ≤ 1024px, mobile ≤ 768px)
│
├── js/
│   ├── main.js                ← ES module entry point — imports all modules
│   └── modules/
│       ├── scroll-header.js   ← frosted-glass header on scroll
│       ├── mobile-nav.js      ← overlay nav open/close/accessibility
│       ├── scroll-reveal.js   ← IntersectionObserver entrance animations
│       ├── slideshow.js       ← hero + section slideshow auto-advance
│       ├── lightbox.js        ← gallery fullscreen lightbox
│       └── bottom-nav.js      ← active tab detection for the mobile bottom bar
│
├── index.html                 ← Homepage
├── about.html
├── art-therapy.html
├── what-is-art-therapy.html
├── what-can-jess-offer.html
├── what-else-do-i-need-to-know.html
├── artist.html
├── artwork.html               ← Masonry gallery with lightbox
├── community.html
├── overview.html
├── starling-project.html
├── the-plot-stanmer.html
├── blog.html
├── articles.html
├── contact.html
├── 404.html
│
├── client-preview.html        ← Standalone design options preview (client review only)
├── favicon.svg
├── robots.txt
├── sitemap.xml
│
├── DESIGN.md                  ← Full design system documentation
├── TODO.md                    ← Pre-launch checklist
├── DEPLOYMENT.md              ← How to publish the site
├── CHANGELOG.md               ← Version history
└── CLIENT_OPTIONS.md          ← Design option explanations for the client
```

### Running locally

No build step required.

**Option A — Python (built into macOS):**
```bash
cd site
python3 -m http.server 8080
# open http://localhost:8080
```

**Option B — Node:**
```bash
npx serve site
```

**Option C — PHP:**
```bash
cd site
php -S localhost:8080
```

---

## Design system

All design decisions are controlled by CSS custom properties in `css/base/tokens.css`. Edit values there to change the whole site.

### Colour palette

| Token | Value | Usage |
|---|---|---|
| `--bg` | `#F8F5F0` | Page background — warm off-white |
| `--surface` | `#F0EDE6` | Card/panel backgrounds |
| `--ink` | `#131310` | Primary text — near-black |
| `--ink-2` | `#3A3A35` | Body text |
| `--ink-3` | `#787870` | Muted/secondary text |
| `--ink-4` | `#BEBDB5` | Placeholder, disabled |
| `--green` | `#2C4A38` | Primary brand — forest green |
| `--green-dark` | `#1E3327` | Hero background, footer, admin sidebar |
| `--green-pale` | `#D4E4DB` | Active state highlights |
| `--sand` | `#C4915A` | Accent — warm terracotta |
| `--sand-lt` | `#F5EBE0` | Sand tint backgrounds |
| `--border` | `#E2DFDA` | Dividers, card borders |
| `--white` | `#FDFCF9` | True white with a warm tint |

### Typography

| Role | Font | Weight | CSS class |
|---|---|---|---|
| Hero / display | Fraunces (optical-size serif) | 200 italic | `.display` |
| Headings h1–h3 | Fraunces | 400 | `h1`, `h2`, `h3` |
| Headings h4–h5 | Inter | 600 | `h4`, `h5` |
| Body | Inter | 400 | — (default) |
| Eyebrow labels | Inter | 500, uppercase, tracked | `.eyebrow` |
| Captions | Inter | 400 italic | `.caption` |

Google Fonts loads only the weights that are actually used:
```
Fraunces: opsz 9..144, weights 200/400/600 (regular + italic)
Inter: weights 300/400/500/600
```

> **Important:** Fraunces weight 300 is **not** loaded. Use `font-weight: 200` instead — weight 300 causes browser synthesis which looks wrong.

### Spacing scale

All spacing tokens are multiples of 4 px, named `--s1` through `--s48`:

```
--s1:  0.25rem (4px)    --s2:  0.5rem (8px)    --s4:  1rem (16px)
--s6:  1.5rem (24px)    --s8:  2rem (32px)     --s10: 2.5rem (40px)
--s12: 3rem (48px)      --s16: 4rem (64px)     --s20: 5rem (80px)
--s24: 6rem (96px)      --s32: 8rem (128px)    --s48: 12rem (192px)
```

### Animation

Two easing curves used throughout:
- `--ease-out: cubic-bezier(0.22, 1, 0.36, 1)` — physical deceleration (default)
- `--ease-in-out: cubic-bezier(0.4, 0, 0.2, 1)` — smooth transitions

Default duration: `--dur: 260ms` | Slow (hero, reveals): `--dur-slow: 520ms`

---

## Pages

| Page | File | Notes |
|---|---|---|
| Homepage | `index.html` | Full-viewport hero, three pillars, about strip, pull quote |
| About | `about.html` | Biography, training, credentials |
| Art Therapy | `art-therapy.html` | Overview with section nav cards |
| What is Art Therapy? | `what-is-art-therapy.html` | Explanation, who it helps |
| What Can Jess Offer? | `what-can-jess-offer.html` | Individual, group, supervision, training |
| Practical Info | `what-else-do-i-need-to-know.html` | Fees, sessions, location |
| Artist | `artist.html` | Statement + gallery preview |
| Artwork | `artwork.html` | Full masonry gallery with lightbox |
| Community | `community.html` | Section overview with slideshow |
| Overview | `overview.html` | Community projects overview |
| Starling Project | `starling-project.html` | Refugee arts programme |
| The Plot Stanmer | `the-plot-stanmer.html` | Outdoor wellbeing space |
| Blog | `blog.html` | Writing and reflections |
| Articles | `articles.html` | Press and publications |
| Contact | `contact.html` | Contact details + HCPC registration info |
| 404 | `404.html` | Custom not-found page |

---

## JavaScript modules

Each module is a self-contained ES module using `querySelector` to find its targets. If the target element is absent on a given page, the module does nothing — so all six are safely imported on every page.

### `modules/scroll-header.js`
Adds `.scrolled` to `#site-header` when `window.scrollY > 40px`. CSS transitions the header from fully transparent (over the hero) to a frosted-glass `rgba` background. Uses `{ passive: true }` for scroll performance.

### `modules/mobile-nav.js`
Controls the hamburger overlay. Manages `aria-expanded`, `aria-hidden`, `body.overflow`, and keyboard focus for full accessibility. Closes on Escape.

### `modules/scroll-reveal.js`
`IntersectionObserver` adds `.in-view` to `.reveal` / `.reveal-x` / `.reveal-scale` elements as they enter the viewport. Stagger delay classes (`.d1`–`.d6`) create cascade effects on card groups. Falls back to immediate reveal on old browsers.

### `modules/slideshow.js`
Auto-advances image slideshows every 5 seconds. Handles both the homepage hero (`.hero`) and section slideshows (`.slideshow`). Dot buttons allow manual navigation. Also triggers the Ken Burns scale effect on the hero image via `requestAnimationFrame`.

### `modules/lightbox.js`
Opens a fullscreen lightbox for gallery items. Keyboard navigation (arrow keys, Escape), focus trapping inside the lightbox, and focus return to the triggering item on close. Makes gallery items keyboard-accessible with `role="button"` and `tabindex="0"`.

### `modules/bottom-nav.js`
Detects the current page by filename and adds `.active` to the matching tab in the mobile bottom nav. Maps all 15 pages to five tabs: Home, Therapy, Artwork, Community, Contact.

---

## CSS architecture

### Why modular CSS without a preprocessor?

CSS custom properties replace the need for Sass/Less variables. Native `@import` in `css/style.css` assembles the partials — no build step, no `node_modules`, no configuration needed.

### Import order

The cascade is intentional and order matters:

1. `tokens.css` — defines custom properties; everything else uses them
2. `reset.css` — establishes a clean baseline before any rules
3. `typography.css` — type scale used by every component
4. `utilities.css` — layout primitives components build on
5. `buttons.css` — reused inside multiple components
6. Component files — in page-structure order (nav → hero → content → footer)
7. `responsive.css` — overrides components at breakpoints
8. `bottom-nav.css` — last because it overrides `site-footer` padding

### Finding where to edit

| What you want to change | Where to look |
|---|---|
| Colours, fonts, spacing | `css/base/tokens.css` |
| Heading sizes or weights | `css/base/typography.css` |
| The header or nav | `css/components/nav.css` |
| The hamburger overlay nav | `css/components/mobile-nav.css` |
| The homepage hero | `css/components/hero.css` |
| Gallery or lightbox | `css/components/gallery.css` |
| Blog post list | `css/components/blog.css` |
| Footer | `css/components/footer.css` |
| Mobile bottom nav bar | `css/components/bottom-nav.css` |
| Tablet / mobile breakpoints | `css/responsive.css` |

---

## Mobile navigation

Two systems work together on mobile (≤ 768px):

### Hamburger overlay
Full-screen dark green panel with all 15 page links. Large Fraunces italic type with numbered indices. Triggered by the three-line hamburger button in the header. Controlled by `js/modules/mobile-nav.js`.

### Bottom navigation bar
Fixed 5-tab bar at the bottom of every page. Styled after contemporary mobile app conventions:
- Pill highlight behind the active tab icon
- Raised circular green button for the Artwork centre tab
- `env(safe-area-inset-bottom)` padding for iPhones with home indicators
- Active tab automatically detected from the page filename

The two systems are complementary — the bottom bar provides quick thumb access to the five main sections; the overlay gives full access to all sub-pages.

---

## Accessibility

- All images have descriptive `alt` attributes
- Landmark regions: `<header>`, `<nav>`, `<main>`, `<footer>`
- `<nav aria-label>` used to distinguish multiple nav elements
- Mobile nav: `aria-hidden`, `aria-expanded`, focus managed on open/close
- Lightbox: focus trap, keyboard navigation, focus returned on close
- Gallery items: `role="button"`, `tabindex="0"`, Enter/Space to open
- Skip-to-content link (`.skip-link`) at top of every page
- Focus ring uses `--sand` colour, `outline-offset: 4px`
- Text selection uses `--green-pale` background
- Colour contrast meets WCAG 2.1 AA throughout

---

## Performance

- No JavaScript framework or library — zero bundle overhead
- Google Fonts loaded with `<link rel="preconnect">` and `display=swap`
- Below-fold images use `loading="lazy"`
- Scroll listener uses `{ passive: true }`
- `IntersectionObserver` for animations instead of scroll events
- `type="module"` provides automatic `defer` semantics
- CSS `@import` resolves at parse time — no runtime overhead

---

## The full-stack PHP version (`fullstack-site/`)

A complete PHP + MySQL CMS conversion for when the client needs to edit content without touching code. See:
- `fullstack-site/INSTALL.md` — step-by-step local and production setup
- `fullstack-site/DATABASE.md` — schema, field reference, useful queries
- `fullstack-site/ADMIN_GUIDE.md` — how to use each admin section

### Architecture summary

```
fullstack-site/
├── config.php                 ← DB credentials + site constants
├── includes/
│   ├── db.php                 ← PDO singleton with prepared statements
│   ├── functions.php          ← all DB query helpers + h() output escaping
│   ├── csrf.php               ← CSRF token generation and verification
│   ├── auth.php               ← session-based admin authentication
│   ├── header.php             ← shared HTML head + public nav
│   └── footer.php             ← shared footer + JS
├── admin/
│   ├── login.php / logout.php
│   ├── index.php              ← dashboard
│   ├── pages.php + page-edit.php
│   ├── blog.php + blog-edit.php
│   ├── gallery.php + gallery-edit.php
│   ├── contact.php
│   └── seo.php
│   └── includes/admin-layout.php  ← admin UI shell + embedded CSS
├── public/
│   ├── css/style.css          ← copy of static site CSS
│   ├── js/main.js             ← copy of static site JS
│   └── uploads/gallery/       ← image upload target
├── database/
│   ├── schema.sql             ← 6 tables (utf8mb4)
│   └── seed.sql               ← all static site content pre-loaded
└── [17 public .php pages]     ← same design, DB-driven content
```

### Database tables

| Table | Purpose |
|---|---|
| `users` | Admin accounts (bcrypt hashed passwords) |
| `pages` | JSON content blobs — each page's editable text sections |
| `blog_posts` | Post title, slug, excerpt, content, status, date |
| `gallery_images` | Title, description, local path or external URL, display order |
| `contact_settings` | Key-value store for email, phone, HCPC number, fees, etc. |
| `seo_settings` | Per-page `<title>` and `<meta description>` |

### Security measures

- PDO prepared statements — no raw SQL with user input anywhere
- `password_hash(PASSWORD_BCRYPT)` for admin passwords
- `password_verify()` with 1-second delay on failed login
- `session_regenerate_id(true)` on successful login (session fixation prevention)
- CSRF tokens on every POST form, verified with `hash_equals()` (timing-safe)
- All output escaped via `h()` → `htmlspecialchars(ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8')`
- `.htaccess` blocks direct access to `includes/`, `database/`, `config.php`, `*.sql`, `*.md`
- Session expiry: 30 minutes of inactivity (sliding window)

---

## How the site was built

### 1 — Research and positioning

Analysed 28+ websites across four reference categories: art therapist portfolios, independent artist sites, creative studio sites, and editorial publications. Identified the gap: most art therapist sites look clinical and generic; this one should feel like a premium independent publication.

Direction set as: **Editorial × Therapeutic** — the visual authority of an art book, the approachability of a trusted practitioner.

### 2 — Design system

Built before any HTML was written. Established:
- A warm paper-toned background that references physical making
- Forest green as the primary brand colour (grounding, natural, not clinical)
- Terracotta/sand as a considered accent — used only on interactive elements and decorative rules
- Fraunces: chosen for its optical-size variability and organic personality; italics at weight 200 create the display type
- Inter: chosen for neutrality and exceptional legibility at body sizes
- A 4px-base spacing scale with semantic names that communicate hierarchy, not pixel values

### 3 — Content and HTML

All content migrated from the client's existing Squarespace site. 15 pages written from scratch in HTML with careful attention to:
- Correct heading hierarchy (no skipped levels)
- Meaningful `alt` text for every image
- Semantic landmark regions on every page
- Logical tab order

### 4 — CSS

~1 700 lines split across 19 files. Key decisions:
- No CSS framework — the design is precise enough that framework overrides would cost more than they save
- `clamp()` for all heading sizes — fluid between minimum and maximum without breakpoints
- `cubic-bezier(0.22, 1, 0.36, 1)` — a physically natural deceleration that makes movements feel intentional rather than mechanical
- Ken Burns (slow image scale) on the hero — the only CSS animation that adds genuine feeling without distraction

### 5 — JavaScript

Six ES modules, ~450 lines total, zero dependencies:
- `IntersectionObserver` for scroll reveals — no layout thrashing
- Focus management in every interactive overlay (mobile nav, lightbox)
- `type="module"` for automatic defer and clean imports

### 6 — Mobile bottom navigation

Research showed that bottom navigation bars significantly improve one-handed mobile usability. Added a fixed 5-tab bar matching contemporary mobile app conventions (pill active state, raised centre button), fully integrated with the existing overlay nav rather than replacing it.

### 7 — Full-stack PHP + MySQL

The client wanted a CMS for the future. Built a complete PHP conversion:
- Same visual design — zero compromise on appearance
- JSON content blobs in the `pages` table — flexible without schema migrations for text changes
- Gallery supports both local file uploads and external CDN URLs — preserving the existing Squarespace images
- Admin CSS is embedded in `admin/includes/admin-layout.php` using the same green design tokens

### 8 — Refactoring and documentation

- CSS split into modular partials with descriptive header comments
- JS split into named modules with JSDoc-style comments on every function
- 8 documentation files covering design decisions, deployment, database, and admin usage

---

## Making changes

### Change a colour
Edit the token in `css/base/tokens.css`. Every component that references that variable updates automatically.

### Change the font
1. Update `--f-display` or `--f-body` in `css/base/tokens.css`
2. Update the Google Fonts URL in the `<head>` of all HTML pages

### Edit page content
- **Static site:** edit the relevant HTML file directly
- **PHP site:** log in to `/admin/` → Pages → Edit Content

### Add a new page
1. Copy a structurally similar existing HTML page
2. Update `<title>`, `<meta name="description">`, the `<h1>`, and the page content
3. Add a `<link>` in the header nav and the mobile nav overlay on every page
4. Add the URL to `sitemap.xml`
5. If using the PHP site: add the page slug to `admin/pages.php` and `js/modules/bottom-nav.js`

### Add a gallery image
- **Static site:** add an `<img>` inside a new `.gallery-item` div in `artwork.html`
- **PHP site:** Admin → Gallery → Add Image

---

## Browser support

| Browser | Support |
|---|---|
| Chrome / Edge (latest) | Full |
| Firefox (latest) | Full |
| Safari (latest) | Full (`-webkit-backdrop-filter` included) |
| iOS Safari | Full (`env(safe-area-inset-bottom)` for bottom nav) |
| IE 11 | Not supported — uses CSS custom properties and ES modules |

---

## Licence

All code is proprietary to the client, Jess Linton.
Photography and artwork © Jess Linton. All rights reserved.
The code and design may not be reused without permission.
