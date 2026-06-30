# Database Reference

## Tables

### `users`

Admin accounts. Only one user is needed for a personal site.

| Column | Type | Notes |
|--------|------|-------|
| id | INT UNSIGNED PK | Auto-increment |
| username | VARCHAR(80) UNIQUE | Login identifier |
| email | VARCHAR(255) UNIQUE | Contact email |
| password_hash | VARCHAR(255) | bcrypt via `password_hash()` |
| created_at | DATETIME | |
| last_login | DATETIME | Updated on each successful login |

### `pages`

CMS-editable content sections for each PHP page.

| Column | Type | Notes |
|--------|------|-------|
| id | INT UNSIGNED PK | |
| slug | VARCHAR(120) UNIQUE | Matches the PHP filename, e.g. `about`, `home` |
| content | LONGTEXT | JSON object of key→value content pairs |
| updated_at | DATETIME | Auto-updated |
| updated_by | INT FK → users.id | NULL if no FK set |

**Content JSON structure per slug:**

| Slug | Keys |
|------|------|
| `home` | `hero_title`, `hero_subtitle`, `about_heading`, `about_text` |
| `about` | `page_heading`, `bio_text`, `expertise_text` |
| `art-therapy` | `intro_text` |
| `what-is-art-therapy` | `page_heading`, `intro_text`, `body_content` |
| `what-can-jess-offer` | `intro_text` |
| `what-else-do-i-need-to-know` | `intro_text`, `fees_text` |
| `artist` | `statement` |
| `community` | `intro_text` |
| `overview` | `intro_text` |
| `starling-project` | `intro_text`, `body_content` |
| `the-plot-stanmer` | `intro_text`, `body_content` |
| `articles` | `intro_text` |
| `contact` | `intro_text`, `referral_text` |

### `blog_posts`

| Column | Type | Notes |
|--------|------|-------|
| id | INT UNSIGNED PK | |
| title | VARCHAR(255) | |
| slug | VARCHAR(255) UNIQUE | URL identifier, e.g. `what-is-art-therapy-and-who-is-it-for` |
| excerpt | TEXT | Short summary shown in listings |
| content | LONGTEXT | HTML content |
| featured_image | VARCHAR(500) | URL to image |
| status | ENUM('draft','published') | Only `published` posts appear on site |
| published_at | DATETIME | Display date |
| created_at / updated_at | DATETIME | Auto-managed |

### `gallery_images`

| Column | Type | Notes |
|--------|------|-------|
| id | INT UNSIGNED PK | |
| title | VARCHAR(255) | Also used as alt text |
| description | TEXT | Optional caption |
| image_path | VARCHAR(500) | Relative path under `public/uploads/gallery/` |
| image_url | VARCHAR(500) | External URL (Squarespace CDN for migrated images) |
| display_order | SMALLINT | Lower = shown first |
| created_at | DATETIME | |

The gallery PHP (`artwork.php`) prefers `image_url` over `image_path`. If DB has no rows, it falls back to the hardcoded Squarespace CDN URLs.

### `contact_settings`

Key–value table. Known keys:

| Key | Example value |
|-----|---------------|
| `email` | jess.a.linton@gmail.com |
| `phone` | +44 (0) 7834 686838 |
| `address` | Sussex, UK |
| `hcpc_number` | AS14954 |
| `dbs_number` | 004178606999 |
| `copyright_year` | 2025 |
| `session_fee` | £35–£60 per hour |
| `location_text` | Longer description... |

### `seo_settings`

| Column | Type | Notes |
|--------|------|-------|
| id | INT UNSIGNED PK | |
| page_slug | VARCHAR(120) UNIQUE | Matches pages.slug |
| title | VARCHAR(70) | `<title>` tag content |
| meta_description | VARCHAR(160) | `<meta name="description">` |
| og_image | VARCHAR(500) | Optional Open Graph image URL |
| updated_at | DATETIME | |

---

## Useful queries

```sql
-- All published blog posts
SELECT title, published_at FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC;

-- Gallery images in display order
SELECT title, image_url FROM gallery_images ORDER BY display_order, id;

-- All contact settings
SELECT `key`, value FROM contact_settings;

-- SEO for the homepage
SELECT title, meta_description FROM seo_settings WHERE page_slug = 'home';

-- Update admin password
UPDATE users
SET password_hash = '$2y$12$NewHashHere'
WHERE username = 'admin';
```

---

## Backups

```bash
# Export full database
mysqldump -u root -p jess_linton > backup_$(date +%Y%m%d).sql

# Restore
mysql -u root -p jess_linton < backup_20250101.sql
```
