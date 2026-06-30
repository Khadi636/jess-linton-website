# Design Reference — Jess Linton Website

This document records the research findings, design decisions, and rationale behind the v3 redesign. It serves as a source of truth for future design changes.

---

## Research: 28 Sites Analysed

### Category 1 — Art Therapist / Therapy Portfolios
| Site | Standout decision |
|------|-------------------|
| Alexandria Art Therapy | Client artwork as the primary trust signal — immediately shows what therapy looks like |
| Minaa B | Magazine aesthetic repositions therapist as cultural authority; single-column editorial layout |
| Cindy Shu Therapy | Typographic restraint mirrors the therapeutic offering — slow, spacious, contemplative |
| Ever Be Therapy | Illustrative brand language (hand-drawn motifs) breaks the clinical visual convention |
| Brent LoCaste-Wilken | Dark green background creates warmth without clinical coldness |
| Rebecca Newton | Colour palette communicates specialism before a word is read |
| Cristeta Rillera | Ocean/landscape imagery and colour unified with therapist's approach (nature as healing) |
| Laura Carrier Arts | Demonstrates artist + art therapist identities can coexist without confusion |

### Category 2 — Artist Portfolios
| Site | Standout decision |
|------|-------------------|
| Julia Ulrich | Dark atmospheric background serves the artwork, not convention |
| Gayle Saunders | Professional credentials given primary real estate — authority first |
| Darren Cranmer | Tight image grid gives fast high-impact portfolio overview in 3 seconds |
| Kristina Rolander | Full-bleed chosen to match subject matter (installation/sculpture) |
| Evelyn Tan | Navigation organised for buyers, not chronologically |
| Stella Schwake | Radical restraint — almost no design, pure service to the work |
| Lotta Nieminen | The site itself is the first piece in the portfolio |
| Morcos Key | Every project tagged by discipline and year — metadata as design |
| Paul Booth | Writing treated as a visual element equal to the image |
| A Practice for Everyday Life | Restraint as the highest-order design decision |

### Category 3 — Creative Studios
| Site | Standout decision |
|------|-------------------|
| Porto Rocha | Work-first — home page is immediately the project grid, no traditional hero |
| Koto | Geographic distribution narrated through local creative culture |
| Hey Studio | Studio identity expressed through letterform animation |
| Alright Studio | Elegant restraint — absence of unnecessary animation signals maturity |
| Kind Studio | Ecological credentials in footer — values-led without being a distraction |
| RoAndCo Studio | Grid rhythm creates viewing pleasure independent of individual project quality |
| DixonBaxi | Systematic design quirk (15-degree tilt) applied across the entire system |

### Category 4 — Editorial Portfolios
| Site | Font pairing | Standout |
|------|-------------|---------|
| Thibaud Allie | Roslindale + Graphik | Optical-size display serif + neutral grotesque |
| Aristide Benoist | Schnyder + Founders Grotesk | Condensed display creates density and elegance |
| Jennifer Heintz | Editorial New + Neue Haas Grotesk | Three-font system showing confidence |
| ByChudy | Custom | Range communicated through disciplined categorisation |

---

## Pattern Synthesis

### What separates premium from average

**Layout:** Asymmetric splits (58/42), varied section rhythm, negative space as structural element, work/images primary.

**Typography:** Display serif at editorial scale (5-8rem desktop), slight negative letter-spacing (-0.02 to -0.03em), clean sans for body at generous line-height (1.7-1.8). Fraunces weight-200 italic at large scale is exceptional.

**Spacing:** Section vertical padding 6-10rem. Prose constrained to 60-70ch. Consistent spacing scale.

**Navigation:** Minimal horizontal, generous letter-spacing, flat or near-flat IA. Mobile: full-screen overlay.

**Animations:** Restraint. Fade + subtle Y-translate (15-20px), 0.35-0.55s ease-out-quint, 80ms stagger. Nothing decorative.

**Accessibility:** Skip links, visible focus styles (the best sites use brand-colour focus rings), semantic headings, ARIA. Still an industry-wide weakness.

**Mobile UX:** Full-screen overlay for nav. Type hierarchy maintained at small screens. Touch targets 44×44px+.

**Colour:** Premium splits into ultra-minimal (black + white + 1 accent) or warm editorial (cream + dark ink + 1-2 accents). Accent colours used sparingly — each appearance is intentional.

**Image presentation:** Work-first. Consistent aspect ratios in grids. Hover: brand-colour overlay + title reveals from bottom.

---

## Design System: Jess Linton v3

### Positioning

**Warm editorial with botanical depth.** The palette and typography signal an independent creative practitioner — not a corporate clinic, not a gallery white cube. The site feels like handmade paper, botanical ink, and careful thought.

### Typography

| Role | Family | Weight | Style | Size | Tracking | Leading |
|------|--------|--------|-------|------|----------|---------|
| Hero h1 | Fraunces | 200 | italic | `clamp(3rem, 7.5vw, 8rem)` | -0.03em | 0.98 |
| Section h2 | Fraunces | 400 | normal | `clamp(2rem, 4.5vw, 3.75rem)` | -0.02em | 1.07 |
| Sub h3 | Fraunces | 400 | normal | `clamp(1.4rem, 2.2vw, 2rem)` | -0.015em | 1.07 |
| Pull quote | Fraunces | 200 | italic | `clamp(1.4rem, 2.8vw, 2rem)` | 0 | 1.35 |
| Eyebrow | Inter | 500 | normal | 0.72rem | 0.16em | 1 |
| Body | Inter | 400 | normal | 1rem | 0 | 1.78 |
| Caption | Inter | 400 | italic | 0.78rem | 0 | 1.55 |
| Nav | Inter | 500 | normal | 0.76rem | 0.1em | 1 |
| Button | Inter | 500 | normal | 0.76rem | 0.12em | 1 |

**Font loading:** Google Fonts, Fraunces opsz/wght 9..144 at 200/400 normal + 200/400 italic. Inter 300/400/500/600. `display=swap` for FOUT resilience.

### Colour Palette

| Token | Hex | Role |
|-------|-----|------|
| `--bg` | `#F8F5F0` | Page background — warm handmade-paper |
| `--surface` | `#F0EDE6` | Card and section surface |
| `--surface-2` | `#E8E4DC` | Nested surfaces |
| `--ink` | `#131310` | Primary text |
| `--ink-2` | `#3A3A35` | Body text |
| `--ink-3` | `#787870` | Muted text, captions |
| `--ink-4` | `#BEBDB5` | Labels, light dividers |
| `--border` | `#E2DFDA` | Standard borders |
| `--border-light` | `#EDEBE5` | Subtle dividers |
| `--green` | `#2C4A38` | Brand anchor — botanical green |
| `--green-mid` | `#3D6350` | Green hover state |
| `--green-dark` | `#1E3327` | Footer, mobile nav — deepest green |
| `--green-pale` | `#D4E4DB` | Text selection, tinted surfaces |
| `--sand` | `#C4915A` | Warm accent — used sparingly |
| `--sand-light` | `#D9A87A` | Sand hover |
| `--sand-lt` | `#F5EBE0` | Pale sand backgrounds |
| `--white` | `#FDFCF9` | Warm white — lightbox, buttons |

### Layout

- Max container width: 1280px
- Container padding: `clamp(1.5rem, 4.5vw, 5rem)`
- Prose max-width: 68ch (reading-optimal)
- Primary media-text split: **58/42** (image gets 58%)
- Section padding scale:

| Class | Value |
|-------|-------|
| `.section--sm` | `clamp(2rem, 4vw, 3rem)` |
| `.section` | `clamp(3rem, 6vw, 6rem)` |
| `.section--lg` | `clamp(5rem, 8vw, 8rem)` |
| `.section--xl` | `clamp(6rem, 10vw, 12rem)` |

### Animation Philosophy

- Easing: `cubic-bezier(0.22, 1, 0.36, 1)` — ease-out-quint, physical and premium
- Scroll reveal: `opacity: 0 → 1` + `translateY(18px → 0)`, 0.65s
- Hover transitions: 0.26s
- Gallery hover: brand green overlay (`rgba(44,74,56,.75)`) + title slides up from `translateY(100%)`
- Button hover: background + `translateY(-1px)` — subtle lift
- **No:** parallax, scroll-jacking, loading screens, cursor followers

### Key Design Decisions

1. **Editorial type scale.** Fraunces weight-200 italic at `clamp(3rem, 7.5vw, 8rem)` on the homepage hero. This is what the optical-size font was designed for.

2. **Gallery hover: brand green overlay.** `rgba(44,74,56,.75)` fade in + title slides up from below. Transforms a static grid into an active, exploratory experience.

3. **58/42 media-text asymmetry.** Images get 58% of the column — more confident and photo-forward than the 50/50 split. Enforces the principle that images are the primary content.

4. **Sand eyebrows.** `.eyebrow` colour changed from muted grey to `var(--sand)`. Every section label now carries brand warmth. Used at 0.72rem / letter-spacing 0.16em — tiny but intentional.

5. **Focus ring as brand element.** `:focus-visible { outline: 2.5px solid var(--sand); outline-offset: 4px; }`. Accessibility as a design decision, not an afterthought.

6. **Deep green footer and mobile nav.** `--green-dark: #1E3327` grounds both the footer and the mobile overlay in the brand's botanical identity.

7. **Text selection colour.** `::selection { background: var(--green-pale); }`. The brand appears every time a user selects text.

8. **Section spacing upgrade.** Primary sections use `clamp(6rem, 10vw, 12rem)` padding. Premium editorial sites use whitespace aggressively — this is the single biggest perceived quality upgrade.

### Accessibility Decisions

- `:focus-visible` with sand outline — visible and branded
- `::selection` with green-pale — readable and on-brand
- Skip link on every page (`.skip-link`)
- `aria-hidden="true"` on marquee strip (decorative)
- `role="dialog"`, `aria-modal`, `aria-hidden` toggling on lightbox
- Focus trap in lightbox + mobile nav
- `.sr-only` class for visually-hidden headings
- All interactive gallery items: `role="button"`, `tabindex="0"`, keyboard Enter/Space
- Gallery overlay visible on `:focus` as well as `:hover`

---

## Files

```
site/css/style.css    — Complete design system (v3)
site/js/main.js       — Interactions (v3)
site/favicon.svg      — SVG favicon (dark bg, italic J)
DESIGN.md             — This file
```

*Last updated: 2026-06-29*
