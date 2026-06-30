# Admin Guide

## Accessing the Admin Panel

Navigate to: `http://your-site.com/admin/login.php`

Log in with the username and password set during installation.

**Session timeout:** 30 minutes of inactivity. You will be redirected to the login page with a timeout notice.

---

## Dashboard

The dashboard shows:
- Counts of CMS pages, blog posts, and gallery images
- The 5 most recent blog posts with status badges
- Quick links to each admin section

---

## Pages

**Path:** Admin → Pages

All 15 site pages are listed. Each page has two action buttons:

- **Edit Content** — modify the page's CMS-editable text sections
- **SEO** — set the `<title>` and meta description for that page

### Editing a page

Click **Edit Content** next to any page. You will see text fields and textareas for each editable section of that page.

- **Text fields** are for short single-line content (headings, titles)
- **Textareas** are for longer content (body text, multiple paragraphs)

To create paragraph breaks in textareas, leave a blank line between paragraphs.

Click **Save Changes**. The change takes effect immediately.

> **Note:** Not all page elements are CMS-editable. Structural HTML (navigation, service card structure, feature grid layout) is in the PHP template files. The CMS controls the *text content* of key sections.

---

## Blog Posts

**Path:** Admin → Blog Posts

### Creating a post

1. Click **+ New Post**
2. Fill in:
   - **Title** (required)
   - **Slug** — URL identifier. Auto-generated from the title if left blank. E.g. `my-post-title` → `/blog-post.php?slug=my-post-title`
   - **Status** — `Draft` (not visible on site) or `Published` (visible)
   - **Publish Date** — the date shown on the post
   - **Featured Image URL** — optional header image
   - **Excerpt** — short summary shown in the blog listing
   - **Content** — full post content. HTML is supported.
3. Click **Save Post**

### Editing a post

Click **Edit** next to any post in the list.

### Deleting a post

Click **Delete** next to any post. You will be asked to confirm. **This cannot be undone.**

---

## Gallery

**Path:** Admin → Gallery

Gallery images are shown as a grid. They appear in **display order** (lowest number first).

### Adding an image

1. Click **+ Add Image**
2. Choose one of:
   - **Upload Image File** — upload a JPEG, PNG, WebP or GIF (max 5 MB). The file is stored in `public/uploads/gallery/`
   - **External Image URL** — paste a URL from any CDN or hosting service
3. Set:
   - **Title / Alt Text** — describes the image (important for accessibility and SEO)
   - **Description** — optional longer caption
   - **Display Order** — integer; lower appears first. Leave at 0 to append at end.
4. Click **Save Image**

### Editing an image

Click **Edit** on any gallery item to change its title, description, order, or replace the image.

### Deleting an image

Click **✕** on any gallery item. Locally uploaded files are also deleted from disk.

> **Migrated images:** The original Squarespace CDN images are stored as external URLs. They will display as long as the Squarespace CDN remains accessible. To migrate them to self-hosting, re-upload via the Edit form.

---

## Contact Settings

**Path:** Admin → Contact

Manage the contact details that appear in the site footer and contact page:

| Field | Used in |
|-------|---------|
| Email | Footer, contact page |
| Phone | Footer, contact page |
| Address | Contact page |
| Location Description | Contact page |
| HCPC Registration Number | Footer, contact page |
| DBS Certificate Number | Footer |
| Session Fee | Contact page |
| Copyright Year | Footer |

Click **Save Settings** after making changes.

---

## SEO Settings

**Path:** Admin → SEO

Each page has its own SEO title and meta description. These control what appears in Google search results and browser tab titles.

**Best practice:**
- Title: 50–70 characters. Format: `Page Name — Jess Linton`
- Meta description: 120–160 characters. Clear summary of the page.

Click the page row to expand it, edit the fields, and click **Save**.

Pages left blank use the built-in default values from the PHP templates.

---

## Security notes

- **Never share your admin password.** There is only one admin account.
- **Change the default seed password immediately** after first login.
- The admin panel is only accessible at `/admin/`. All pages in `/admin/` redirect to the login page if you are not authenticated.
- Sessions expire after 30 minutes of inactivity.
- All forms use CSRF tokens. Do not use the browser Back button to re-submit forms.

---

## Changing the admin password

Option 1 — Direct SQL:

```sql
UPDATE users
SET password_hash = '$2y$12$NewHashHere'
WHERE username = 'admin';
```

Generate the hash with:
```bash
php -r "echo password_hash('your_new_password', PASSWORD_BCRYPT) . PHP_EOL;"
```

Option 2 — Add a change-password page to the admin (not included in this version; see TODO.md).
