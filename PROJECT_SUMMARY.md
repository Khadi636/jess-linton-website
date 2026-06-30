# Project Summary

## Overview

A complete redesign of the Jess Linton website — replacing a legacy Squarespace export with a hand-crafted static site. The new site is faster, fully accessible, and under direct editorial control.

**Client:** Jess Linton  
**Role:** HCPC Registered Art Psychotherapist, Visual Artist and Creative Practitioner  
**Location:** Sussex, UK  
**Contact:** jess.a.linton@gmail.com / +44 (0) 7834 686838  
**HCPC Registration:** AS14954 / DBS: 004178606999

---

## Pages (15 total)

| Page | File | Purpose |
|------|------|---------|
| Home | `index.html` | Landing — hero, three-area feature cards, about strip, art therapy CTA |
| About | `about.html` | Biography, therapeutic portfolio, areas of expertise |
| Art Therapy | `art-therapy.html` | Section landing — slideshow hero |
| What is Art Therapy? | `what-is-art-therapy.html` | Definition, benefits, specialist refugee work |
| What Can Jess Offer? | `what-can-jess-offer.html` | Services: individual therapy, consultation, supervision, skill sharing |
| What else do I need to know? | `what-else-do-i-need-to-know.html` | Location, sessions, fees (£35–60/hr), HCPC registration |
| Artist | `artist.html` | Artist statement, gallery preview strip linking to artwork |
| Artwork | `artwork.html` | Full masonry gallery with accessible lightbox |
| Community | `community.html` | Section landing — slideshow hero |
| Overview | `overview.html` | Community settings: schools, SEN, youth groups, hospitals, refugees |
| The Starling Project | `starling-project.html` | Creative collaboration project with displaced communities (est. 2016) |
| The Plot Stanmer | `the-plot-stanmer.html` | Outdoor wellbeing space in Stanmer Park (est. 2019) |
| Blog | `blog.html` | Writing on art therapy and community practice |
| Articles | `articles.html` | 18 press, publication and media references |
| Contact | `contact.html` | Contact details and therapy referral information |

---

## Technical Stack

| Layer | Technology |
|-------|-----------|
| Markup | Semantic HTML5 |
| Styling | Vanilla CSS (custom properties, flexbox, CSS grid, `columns` masonry) |
| Scripting | Vanilla JavaScript (ES6+, no dependencies) |
| Fonts | Google Fonts — Fraunces (display) + Inter (body) |
| Images | Squarespace CDN (external, no local copies) |
| Build | None — static files, no bundler or preprocessor |

---

## Design System

**Typography**
- Display: Fraunces (italic optical size, weights 200/400/600)
- Body: Inter (weights 300/400/500/600)
- Scale: fluid clamp-based sizing throughout

**Colour palette**
- Background: `#FAFAF7` (warm off-white)
- Ink: `#0F0F0D` → `#3A3A36` → `#6B6B64` (three text levels)
- Green: `#2C4A38` (band-green sections, brand accent)
- Sand: `#C4915A` (hover / highlight)
- Surface: `#F2F1EC` (alternate section background)

**Components**
- Frosted-glass header (blur + opacity on scroll)
- Full-bleed slideshow hero (`.header-hero` pages)
- Masonry gallery (`css columns: 3`)
- Accessible lightbox with focus trap
- Mobile navigation overlay with focus management
- IntersectionObserver scroll-reveal animations
- `.media-text` two-column layout (image + text)
- `.band-green` / `.band-dark` full-width colour bands
- `.callout` highlighted info blocks
- `.gallery-preview` linked artwork strip

---

## Accessibility (WCAG 2.1 AA)

- Single `<h1>` on every page; no heading level skips across all 15 pages
- Visually-hidden `.sr-only` headings where structural headings have no visual equivalent
- `aria-label` on all abbreviation nav links (Fl, Pi, Li, Ig)
- Skip-to-content link on every page
- Lightbox: `role="dialog"`, `aria-modal`, `aria-hidden` toggling, full keyboard focus trap
- Mobile nav: `aria-expanded`, `aria-controls`, focus moves to first link on open / back to toggle on close
- Gallery tiles: `role="button"`, keyboard Enter/Space support, descriptive `aria-label`
- IntersectionObserver with `if ('IntersectionObserver' in window)` guard + immediate fallback

---

## SEO

- Unique `<title>` tag on every page
- Unique `<meta name="description">` on every page
- `sitemap.xml` covering all 15 pages
- `robots.txt` allowing all crawlers
- All external links use `https://`
- `favicon.svg` linked on all pages

---

## Files Delivered

```
site/
  *.html (15 pages + 404.html)
  favicon.svg
  sitemap.xml
  robots.txt
  css/style.css
  js/main.js

README.md
PROJECT_SUMMARY.md
CHANGELOG.md
DEPLOYMENT.md
LICENSE
```
