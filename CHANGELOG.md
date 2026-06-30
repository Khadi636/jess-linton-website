# Changelog

All notable changes to the Jess Linton website.

---

## [1.1.0] — 2026-06-29

Full premium redesign (v3) — typography upgrade, colour system, animation polish, performance improvements, and accessibility fixes.

### Added — Design system

- **New colour tokens**: `--green-dark (#1E3327)`, `--green-mid (#3D6350)`, `--sand-light (#D9A87A)`, `--sand-lt (#F5EBE0)`, `--surface-2 (#E8E4DC)`, `--border-light (#EDEBE5)`, `--bg (#F8F5F0)` warm off-white
- **Gallery hover**: brand green overlay (`rgba(44,74,56,.75)`) + title slides up from `translateY(100%)` on hover
- **Gallery keyboard focus**: `:focus` states matching `:hover` for full keyboard accessibility
- **Marquee strip**: scrolling credential ticker added to `index.html` between hero and feature grid
- **Text selection**: `::selection { background: var(--green-pale) }` — brand appears on text selection
- **Thin scrollbar**: `scrollbar-width: thin; scrollbar-color: var(--ink-4) transparent`
- **Focus ring**: upgraded to `2.5px solid var(--sand)` — visible and on-brand

### Changed — Typography

- Hero h1: `clamp(3.5rem, 8.5vw, 7.5rem)` at `font-weight: 200` italic — full editorial scale
- Section h2: tighter letter-spacing (`-0.02em`) and optical-size tuning
- Eyebrow colour: changed from `--ink-3` to `--sand` — warm accent throughout
- Body line-height: upgraded from 1.65 to 1.78
- Fraunces `font-weight: 300` (not loaded in Google Fonts) → `font-weight: 200` in 4 places: `.mobile-nav-link`, `blockquote`, `.blog-post__date`, `.footer-wordmark`
- Prose max-width: tightened to 68ch (reading-optimal)

### Changed — Layout and spacing

- Media-text grid: changed from `5fr 7fr` to `7fr 5fr` (image-forward 58/42 split)
- Section xl padding: `clamp(var(--s24), 10vw, var(--s48))` — premium whitespace
- Band dark padding: `clamp(var(--s20), 9vw, var(--s40))`

### Changed — Components

- Footer and mobile nav background: `--green-dark` (was `--ink`)
- Gallery overlay: unified colour and animation into base `.gallery-overlay` rule (removed redundant `.gallery-preview__item .gallery-overlay` overrides)
- Button hover: added `translateY(-1px)` subtle lift
- Callout: left border upgraded to `var(--sand)`
- Registration box: top border upgraded to `var(--green)`

### Fixed — CSS bugs

- Lightbox prev/next hover: removed erroneous `translateY(-50%)` from hover transforms — was doubling the vertical offset already set by `translate: 0 -50%`
- Removed 3 redundant `.gallery-preview__item` overlay rules that duplicated the unified `.gallery-overlay` block
- Gallery focus states: added `:focus` selectors for overlay reveal (keyboard users now see overlay on focus)

### Fixed — Performance

- Added `loading="lazy"` to 9 below-fold images across `about.html`, `articles.html`, `starling-project.html`, `what-else-do-i-need-to-know.html`, `the-plot-stanmer.html`, `what-is-art-therapy.html`, `what-can-jess-offer.html`, `artist.html` (×7)
- Hero slideshow images (index.html, art-therapy.html, community.html) intentionally kept eager for LCP

### Added — Documentation

- `DESIGN.md` — 28-site competitive analysis, design system reference, typography table, colour palette, animation philosophy, key design decisions
- `TODO.md` — Outstanding pre-launch, performance, SEO, accessibility, and developer-experience items

---

## [1.0.0] — 2026-06-28

Initial production release. Full redesign from Squarespace export to hand-crafted static site.

### Added — Pages (15)

- `index.html` — Home: hero slideshow, feature cards, about strip, art therapy CTA, pull quote, community preview
- `about.html` — Biography, therapeutic portfolio, areas of expertise
- `art-therapy.html` — Art Therapy section landing with slideshow hero
- `what-is-art-therapy.html` — Definition, client quotes, benefits list, specialist refugee practice
- `what-can-jess-offer.html` — Five service cards: individual therapy, consultation, supervision, referral support, skill sharing
- `what-else-do-i-need-to-know.html` — Location (Sussex UK / The Plot Stanmer), sessions, fees (£35–60/hr), HCPC/DBS registration
- `artist.html` — Artist statement, linked gallery preview strip
- `artwork.html` — Full masonry gallery with accessible lightbox
- `community.html` — Community section landing with slideshow hero
- `overview.html` — Community practice settings: schools, SEN, youth groups, adult mental health, families, hospitals, refugee networks
- `starling-project.html` — The Starling Project: Threads of Life, Thursday Art Group, Hummingbird Project callout
- `the-plot-stanmer.html` — Outdoor wellbeing space in Stanmer Park; green band CTA
- `blog.html` — Blog post cards
- `articles.html` — 18 press/publication/media items in media-text layout
- `contact.html` — Two-column contact / therapy referral layout with HCPC/DBS registration box
- `404.html` — Custom not-found page matching site design

### Added — Assets

- `favicon.svg` — SVG favicon (dark background, italic "J", Fraunces-style)
- `sitemap.xml` — XML sitemap covering all 15 pages
- `robots.txt` — Allows all crawlers, references sitemap

### Added — CSS (`css/style.css`)

- Complete design system: tokens, reset, typography, layout, components, utilities
- Utility classes: `.mt-4` through `.mt-12`, `.btn-row--center`, `.prose--center`, `.rule--center`, `.callout`, `.section--gallery`, `.sr-only`
- Component: `.gallery-preview` / `.gallery-preview__item` — masonry anchor-link strip
- Component: `.contact-split` / `.contact-col` / `.registration-box` / `.article-list` / `.article-item`
- `.band-green h2, .band-green h3 { color: var(--white) }` — white headings on green backgrounds
- `.band-dark .text-muted { color: rgba(255,255,255,.5) }` — readable muted text on dark backgrounds
- `.rich-text h2, .rich-text h3` — consistent rich-text heading sizing
- `.info-block h2, .info-block h3, .info-block h4` — expanded info-block heading selector
- `.feature-card h2, .feature-card h3` — expanded feature-card heading selector

### Added — JavaScript (`js/main.js` v3)

- IntersectionObserver wrapped in `if ('IntersectionObserver' in window)` guard with immediate `.in-view` fallback
- Lightbox sets `lbImg.alt = img.alt || ''` on open
- Lightbox toggles `aria-hidden="true"/"false"` on open/close
- Lightbox focus trap: Tab/Shift+Tab cycles between close, prev, next buttons
- `close()` returns focus to the gallery item that triggered the open
- Mobile nav `openNav()` focuses first nav link; `closeNav()` returns focus to toggle button

### Fixed — Accessibility

- `art-therapy.html`, `community.html`: removed `role="img"` from `.slideshow` divs; promoted `<h2>` slideshow title to `<h1>`
- `about.html`: promoted "Therapeutic Portfolio" and "Areas of Expertise" from `<h3>` to `<h2>`
- `overview.html`: added `.sr-only` `<h2>` before services list; promoted service headings `<h4>` → `<h3>`
- `what-can-jess-offer.html`: added `.sr-only` `<h2 class="sr-only">Services</h2>`; promoted service headings `<h4>` → `<h3>`
- `what-else-do-i-need-to-know.html`: promoted info-block headings `<h4>` → `<h2>`
- `the-plot-stanmer.html`: promoted band-green heading `<h3>` → `<h2>`
- `index.html`: promoted feature-card headings `<h3>` → `<h2>` (h1→h3 skip eliminated)
- `what-is-art-therapy.html`: promoted "Art therapy supports individuals to:" `<h3>` → `<h2>`
- `artwork.html`: added `aria-hidden="true"` to lightbox div in HTML (correct initial ARIA state)
- All 15 pages: `aria-label` added to nav social abbreviation links (Fl, Pi, Li, Ig)
- All 15 pages: `<link rel="icon" href="favicon.svg">` added
- All 15 pages: `<meta name="description">` added
- All 15 pages: `http://instagram.com` and `http://theplotstanmer.org.uk` → `https://`
- `artist.html`: non-interactive `.gallery-item` divs replaced with `<a href="artwork.html">` links

### Removed — CSS

- `@import url('https://fonts.googleapis.com/...')` — was double-loading fonts (fonts already loaded via HTML `<link>`)
- Dead `.page-hero__*` rules (legacy component no longer used)
- Dead `.contact-main`, `.contact-link`, `.contact-aside` rules (replaced by `.contact-split`)
- Orphaned mobile breakpoint rules for removed components

### Removed — HTML

- All inline `style=""` attributes across all pages (replaced with utility classes)
