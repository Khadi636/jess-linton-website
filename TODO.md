# TODO

Outstanding items for the Jess Linton website. Grouped by priority.

---

## Before Launch

- [ ] **Domain** — Update `sitemap.xml` and `robots.txt` with the real production domain (currently placeholder `www.jesslinton.co.uk`).
- [ ] **Email** — Verify `jess.a.linton@gmail.com` is the correct contact email throughout the site.
- [ ] **Copyright year** — Footer shows `© 2024 Jess Linton`. Update to current year or use JavaScript: `new Date().getFullYear()`.
- [ ] **Contact form** — The contact page uses `mailto:` links only. A real form (Netlify Forms, Formspree, or Basin) would reduce friction for referrals and general enquiries.
- [ ] **Blog content** — `blog.html` contains placeholder blog posts. Replace with real writing before launch.
- [ ] **Image alt text** — Some gallery items use generic "Artwork by Jess Linton". Replace with specific titles where known.

## Performance

- [ ] **Self-host images** — All images are loaded from `images.squarespace-cdn.com`. If that CDN becomes unavailable, all images break. Migrate to a self-hosted or dedicated CDN (Cloudflare Images, Bunny CDN, or direct hosting).
- [ ] **Font subsetting** — The Google Fonts load includes Fraunces weight 600 which is barely used. Removing it would reduce the font download by ~20KB.
- [ ] **Image dimensions** — Images from the Squarespace CDN have no explicit `width`/`height` attributes. Adding these prevents layout shift (CLS).
- [ ] **WebP images** — Squarespace CDN serves JPEG/PNG. If images are self-hosted, serve WebP with JPEG fallback.
- [ ] **Preload hero image** — Add `<link rel="preload" as="image">` for the first hero slide to improve LCP.

## SEO

- [ ] **Open Graph tags** — Add `og:title`, `og:description`, `og:image`, `og:url` to every page for social sharing previews.
- [ ] **Twitter/X card tags** — Add `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`.
- [ ] **Canonical URLs** — Add `<link rel="canonical">` to every page to prevent duplicate content issues.
- [ ] **JSON-LD schema** — Add structured data for Person (Jess Linton), LocalBusiness (therapy practice), and ArtGallery (artwork section).
- [ ] **Sitemap lastmod** — Add `<lastmod>` dates to `sitemap.xml` entries to help search engines prioritise crawling.
- [ ] **Google Search Console** — Submit the sitemap at launch: `https://search.google.com/search-console`.

## Accessibility

- [ ] **Colour contrast audit** — Run all text/background colour combinations through WCAG AA contrast checker. Known borderline: `.text-muted` on `--bg`, eyebrow sand on `--bg`.
- [ ] **Keyboard nav order** — Test full keyboard navigation sequence on every page in a real browser.
- [ ] **Screen reader test** — Test with VoiceOver (Mac) or NVDA (Windows) to verify landmark navigation, form labels, and image alt text.
- [ ] **Reduced motion** — Add `@media (prefers-reduced-motion: reduce)` to disable/reduce scroll-reveal and marquee animations.

## Developer Experience

- [ ] **HTML templating** — The nav and footer are duplicated across all 15 HTML files. Any change requires updating all files. Consider a minimal build step (e.g. Eleventy, Astro, or simple Node.js `include` script) to template common components.
- [ ] **Analytics** — Add privacy-respecting analytics (Plausible, Fathom, or Cloudflare Web Analytics) to understand which pages get traffic.
- [ ] **Error monitoring** — Not currently applicable for a static site, but useful if a contact form or dynamic feature is added.

## Nice to Have

- [ ] **`prefers-color-scheme`** — Dark mode variant. The site's botanical green palette could work beautifully in dark mode.
- [ ] **Print stylesheet** — A `@media print` CSS for clean printing of the contact and practice information pages.
- [ ] **`manifest.json`** — PWA web app manifest for "Add to Home Screen" on mobile.
- [ ] **Breadcrumb nav** — On deep-linked pages (e.g. `what-is-art-therapy.html`), a breadcrumb trail would help orientation.
- [ ] **Testimonials page** — Client quotes currently appear inline across multiple pages. A dedicated testimonials or case studies section could build trust.
