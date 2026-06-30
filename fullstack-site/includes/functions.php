<?php
require_once __DIR__ . '/db.php';

// ─── Output helpers ───────────────────────────────────────────────────────────

/** Safe HTML output. */
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Convert newlines to <br> then escape. */
function nl2br_h(string $s): string {
    return nl2br(h($s));
}

/** Generate a URL-safe slug from any string. */
function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/** Format a date string for display. */
function fmt_date(string $date, string $format = 'j F Y'): string {
    try {
        return (new DateTime($date))->format($format);
    } catch (Exception $e) {
        return $date;
    }
}

// ─── Pages ────────────────────────────────────────────────────────────────────

/**
 * Load a page's editable content from the DB.
 * Merges DB values over $defaults so new keys are always populated.
 */
function get_page_content(string $slug, array $defaults = []): array {
    try {
        $db   = get_db();
        $stmt = $db->prepare('SELECT content FROM pages WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        if ($row && !empty($row['content'])) {
            $db_content = json_decode($row['content'], true);
            if (is_array($db_content)) {
                return array_merge($defaults, $db_content);
            }
        }
    } catch (PDOException $e) {
        error_log('get_page_content: ' . $e->getMessage());
    }
    return $defaults;
}

function save_page_content(string $slug, array $content): bool {
    try {
        $db   = get_db();
        $json = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $stmt = $db->prepare(
            'INSERT INTO pages (slug, content, updated_at)
             VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE content = VALUES(content), updated_at = NOW()'
        );
        return $stmt->execute([$slug, $json]);
    } catch (PDOException $e) {
        error_log('save_page_content: ' . $e->getMessage());
        return false;
    }
}

function get_all_pages(): array {
    try {
        return get_db()->query('SELECT slug, updated_at FROM pages ORDER BY slug')->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

// ─── Blog ─────────────────────────────────────────────────────────────────────

function get_blog_posts(int $limit = 20, string $status = 'published'): array {
    try {
        $db   = get_db();
        $stmt = $db->prepare(
            'SELECT * FROM blog_posts WHERE status = ? ORDER BY published_at DESC LIMIT ?'
        );
        $stmt->execute([$status, $limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function get_blog_post_by_slug(string $slug): ?array {
    try {
        $db   = get_db();
        $stmt = $db->prepare('SELECT * FROM blog_posts WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (PDOException $e) {
        return null;
    }
}

function get_blog_post_by_id(int $id): ?array {
    try {
        $db   = get_db();
        $stmt = $db->prepare('SELECT * FROM blog_posts WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (PDOException $e) {
        return null;
    }
}

function get_all_blog_posts_admin(): array {
    try {
        return get_db()
            ->query('SELECT id, title, slug, status, published_at FROM blog_posts ORDER BY created_at DESC')
            ->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

// ─── Gallery ──────────────────────────────────────────────────────────────────

function get_gallery_images(int $limit = 100): array {
    try {
        $db   = get_db();
        $stmt = $db->prepare(
            'SELECT * FROM gallery_images ORDER BY display_order ASC, id ASC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function get_gallery_image(int $id): ?array {
    try {
        $db   = get_db();
        $stmt = $db->prepare('SELECT * FROM gallery_images WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (PDOException $e) {
        return null;
    }
}

/** Return the public URL for a gallery image (local upload or external CDN URL). */
function gallery_img_url(array $image): string {
    if (!empty($image['image_url'])) {
        return $image['image_url'];
    }
    if (!empty($image['image_path'])) {
        return UPLOAD_URL . 'gallery/' . h($image['image_path']);
    }
    return '';
}

// ─── Contact settings ────────────────────────────────────────────────────────

function get_contact_settings(): array {
    try {
        $rows = get_db()->query('SELECT `key`, `value` FROM contact_settings')->fetchAll();
        $out  = [];
        foreach ($rows as $row) {
            $out[$row['key']] = $row['value'];
        }
        return $out;
    } catch (PDOException $e) {
        return [];
    }
}

function get_contact(string $key, string $default = ''): string {
    static $cache = null;
    if ($cache === null) {
        $cache = get_contact_settings();
    }
    return $cache[$key] ?? $default;
}

function save_contact_settings(array $data): bool {
    try {
        $db   = get_db();
        $stmt = $db->prepare(
            'INSERT INTO contact_settings (`key`, `value`)
             VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)'
        );
        foreach ($data as $key => $value) {
            $stmt->execute([preg_replace('/[^a-z0-9_]/', '', $key), $value]);
        }
        return true;
    } catch (PDOException $e) {
        error_log('save_contact_settings: ' . $e->getMessage());
        return false;
    }
}

// ─── SEO settings ─────────────────────────────────────────────────────────────

function get_seo(string $slug): array {
    try {
        $db   = get_db();
        $stmt = $db->prepare('SELECT * FROM seo_settings WHERE page_slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: [];
    } catch (PDOException $e) {
        return [];
    }
}

function save_seo(string $slug, string $title, string $description): bool {
    try {
        $db   = get_db();
        $stmt = $db->prepare(
            'INSERT INTO seo_settings (page_slug, title, meta_description, updated_at)
             VALUES (?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE
               title = VALUES(title),
               meta_description = VALUES(meta_description),
               updated_at = NOW()'
        );
        return $stmt->execute([$slug, $title, $description]);
    } catch (PDOException $e) {
        error_log('save_seo: ' . $e->getMessage());
        return false;
    }
}

function get_all_seo(): array {
    try {
        return get_db()
            ->query('SELECT page_slug, title, meta_description, updated_at FROM seo_settings ORDER BY page_slug')
            ->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

// ─── File upload helper ───────────────────────────────────────────────────────

/**
 * Validate and move an uploaded file to public/uploads/gallery/.
 * Returns the filename on success, null on failure.
 * Populates $error with a human-readable message on failure.
 */
function handle_gallery_upload(array $file, string &$error): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Upload error code: ' . $file['error'];
        return null;
    }
    if ($file['size'] > MAX_UPLOAD_BYTES) {
        $error = 'File exceeds 5 MB limit.';
        return null;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ALLOWED_MIME_TYPES, true)) {
        $error = 'Invalid file type. Allowed: JPEG, PNG, WebP, GIF.';
        return null;
    }
    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(8)) . '.' . strtolower($ext);
    $dest     = UPLOAD_PATH . 'gallery/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        $error = 'Could not save the file. Check server permissions.';
        return null;
    }
    return $filename;
}
