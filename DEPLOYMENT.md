# Deployment Guide

The site is a folder of static files (`site/`). No server-side code, no database, no build step. Any static host will work. The options below are ordered from simplest to most control.

---

## Option 1 — Netlify (recommended for simplicity)

Netlify is free for personal sites, deploys in under a minute, and handles the 404 page automatically.

**Steps:**

1. Go to [netlify.com](https://www.netlify.com) and sign up / log in.
2. From your dashboard, click **Add new site → Deploy manually**.
3. Drag and drop the `site/` folder onto the upload area.
4. Netlify assigns a random URL (e.g. `https://quirky-name-123.netlify.app`). The site is live.

**Custom domain:**

1. In the Netlify dashboard, go to **Domain management → Add a domain**.
2. Enter `jesslinton.co.uk` (or whatever domain you own).
3. Follow Netlify's instructions to update your DNS records with your domain registrar (e.g. 123-reg, GoDaddy, Namecheap).
4. Netlify provisions a free HTTPS certificate automatically once DNS propagates (usually within an hour).

**404 page:**

Netlify serves `404.html` automatically for unmatched routes — no extra configuration needed.

**Re-deploying after changes:**

Repeat the drag-and-drop with the updated `site/` folder, or connect a GitHub repository for automatic deploys on every push (see **Option 2**).

---

## Option 2 — Netlify via GitHub (recommended for ongoing updates)

Best if you want changes to publish automatically every time you save.

**One-time setup:**

1. Create a GitHub account if you don't have one.
2. Create a new repository (e.g. `jess-linton-website`) and upload the entire project folder.
3. In Netlify, click **Add new site → Import an existing project → GitHub**.
4. Select the repository.
5. Set **Publish directory** to `site` (without a trailing slash).
6. Click **Deploy site**.

From this point, every push to the `main` branch re-deploys the site automatically.

---

## Option 3 — GitHub Pages

Free, no account other than GitHub required.

**Steps:**

1. Create a GitHub repository named `jesslinton.github.io` (replace `jesslinton` with your GitHub username) — this makes it a user-pages site served at `https://jesslinton.github.io`.
2. Upload the contents of `site/` (not the folder itself, just its contents) to the repository root.
3. Go to **Settings → Pages → Source** and select the `main` branch, root folder.
4. GitHub publishes the site within a minute.

**Custom domain:**

1. Go to **Settings → Pages → Custom domain** and enter `jesslinton.co.uk`.
2. Create a `CNAME` file in the repository root containing just `jesslinton.co.uk`.
3. Add these DNS records at your registrar:
   ```
   A     @     185.199.108.153
   A     @     185.199.109.153
   A     @     185.199.110.153
   A     @     185.199.111.153
   CNAME www   jesslinton.github.io.
   ```
4. Tick **Enforce HTTPS** once GitHub confirms the domain is configured.

**404 page:**

GitHub Pages serves `404.html` automatically for unmatched routes.

---

## Option 4 — Traditional web hosting (cPanel / FTP)

If the domain is already registered with a host like 123-reg, Heart Internet, or GoDaddy that includes web hosting:

1. Log into your hosting control panel.
2. Open **File Manager** (or connect via FTP using FileZilla).
3. Navigate to the `public_html` folder (sometimes called `www` or `htdocs`).
4. Upload the entire contents of `site/` into `public_html` — not inside a subfolder.
5. The site is live at the domain already pointed to this host.

**FTP credentials** are in your hosting provider's control panel under **FTP Accounts**.

---

## Pre-launch checklist

Before pointing the real domain at the new site:

- [ ] Open every page in a browser and check the layout
- [ ] Test on a phone (Chrome DevTools → Toggle device toolbar, or your actual phone)
- [ ] Click every nav link and confirm it reaches the right page
- [ ] Check the contact email link opens a mail client
- [ ] Check the phone number link dials on mobile
- [ ] Test the artwork lightbox (open image, close, keyboard Escape)
- [ ] Test the mobile nav (hamburger button, tap a link, close)
- [ ] Confirm the 404 page appears for a made-up URL (e.g. `/nonexistent`)
- [ ] Update `sitemap.xml` — replace `https://www.jesslinton.co.uk/` with the real domain if different

---

## After launch

**Submit sitemap to Google Search Console:**

1. Go to [search.google.com/search-console](https://search.google.com/search-console) and add the property for the domain.
2. Under **Sitemaps**, submit `https://www.jesslinton.co.uk/sitemap.xml`.
3. Google will index the site within a few days.

**Submit to Bing Webmaster Tools** (optional, same process):

1. Go to [bing.com/webmasters](https://www.bing.com/webmasters) and add the site.
2. Submit the same sitemap URL.

---

## Updating content after launch

The site has no CMS. To change content:

1. Open the relevant `.html` file in a text editor (TextEdit on Mac, or free editors like VS Code or BBEdit).
2. Find the text you want to change and edit it.
3. Save the file.
4. Re-upload the changed file(s) to the same location on the host (overwriting the old version).

For Netlify/GitHub deployments, save and push — the site re-deploys automatically.

---

## Domain registrar notes

If the domain is not yet registered, `.co.uk` domains can be registered at:

- [123-reg.co.uk](https://www.123-reg.co.uk) — popular UK registrar
- [namecheap.com](https://www.namecheap.com) — competitive pricing
- [gandi.net](https://www.gandi.net) — privacy-respecting, no upsells

A `.co.uk` domain costs approximately £7–12/year.
