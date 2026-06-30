# Jess Linton — Full-Stack Website

PHP + MySQL conversion of the static site. Preserves the complete v3 design while adding a database-driven CMS and secure admin dashboard.

## Structure

```
fullstack-site/
├── admin/                  Admin dashboard (login-protected)
│   ├── index.php           Dashboard overview
│   ├── login.php / logout.php
│   ├── pages.php           List/edit page content
│   ├── page-edit.php       Edit individual page sections
│   ├── blog.php            Blog post list
│   ├── blog-edit.php       Add/edit blog post
│   ├── gallery.php         Gallery image grid
│   ├── gallery-edit.php    Add/edit/upload gallery image
│   ├── contact.php         Edit contact details
│   └── seo.php             SEO title & meta description per page
│   └── includes/
│       └── admin-layout.php  Shared admin UI (sidebar, header, CSS)
├── includes/               Shared PHP components
│   ├── db.php              PDO singleton connection
│   ├── functions.php       All DB query functions + helpers
│   ├── csrf.php            CSRF token generation and verification
│   ├── auth.php            Session-based admin authentication
│   ├── header.php          Public site header (nav, fonts, CSS)
│   └── footer.php          Public site footer
├── public/
│   ├── css/style.css       Copied from static site (v3 design)
│   ├── js/main.js          Copied from static site
│   ├── favicon.svg
│   └── uploads/gallery/    Image upload destination
├── database/
│   ├── schema.sql          Database structure (5 tables)
│   └── seed.sql            Initial data migrated from static site
├── index.php               Homepage
├── about.php
├── art-therapy.php
├── what-is-art-therapy.php
├── what-can-jess-offer.php
├── what-else-do-i-need-to-know.php
├── artist.php
├── artwork.php             Gallery (DB-driven or static fallback)
├── community.php
├── overview.php
├── starling-project.php
├── the-plot-stanmer.php
├── blog.php                Blog listing
├── blog-post.php           Individual post
├── articles.php
├── contact.php
├── 404.php
├── config.php              DB credentials + constants
└── .htaccess               URL rewriting, security headers
```

## Quick start

See `INSTALL.md` for step-by-step setup.

## Security

- All database queries use PDO prepared statements
- Admin passwords stored with `password_hash(PASSWORD_BCRYPT)`
- CSRF tokens on all POST forms
- Session-based auth with 30-minute sliding expiry
- `includes/` and `database/` blocked via `.htaccess`
- HTML output escaped with `htmlspecialchars()` throughout
