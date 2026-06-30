<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

$id      = (int)($_GET['id'] ?? 0);
$post    = $id > 0 ? get_blog_post_by_id($id) : null;
$success = false;
$errors  = [];
$is_new  = ($post === null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $title    = trim($_POST['title']    ?? '');
    $slug_in  = trim($_POST['slug']     ?? '');
    $excerpt  = trim($_POST['excerpt']  ?? '');
    $content  = trim($_POST['content']  ?? '');
    $status   = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'draft';
    $pub_date = trim($_POST['published_at'] ?? '') ?: null;
    $feat_img = trim($_POST['featured_image'] ?? '');

    if ($title === '')   $errors[] = 'Title is required.';
    if ($content === '') $errors[] = 'Content is required.';

    $final_slug = $slug_in !== '' ? slugify($slug_in) : slugify($title);

    if (empty($errors)) {
        try {
            $db = get_db();
            if ($is_new) {
                $stmt = $db->prepare(
                    'INSERT INTO blog_posts (title, slug, excerpt, content, featured_image, status, published_at, created_at, updated_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())'
                );
                $stmt->execute([$title, $final_slug, $excerpt, $content, $feat_img, $status, $pub_date]);
                $id   = (int)$db->lastInsertId();
                $post = get_blog_post_by_id($id);
            } else {
                $stmt = $db->prepare(
                    'UPDATE blog_posts SET title=?, slug=?, excerpt=?, content=?, featured_image=?, status=?, published_at=?, updated_at=NOW()
                     WHERE id=?'
                );
                $stmt->execute([$title, $final_slug, $excerpt, $content, $feat_img, $status, $pub_date, $id]);
                $post = get_blog_post_by_id($id);
            }
            $success = true;
        } catch (PDOException $e) {
            error_log('blog-edit: ' . $e->getMessage());
            $errors[] = 'Database error. Check if slug is unique.';
        }
    }
}

$title    = $post['title']           ?? ($_POST['title']    ?? '');
$slug_val = $post['slug']            ?? ($_POST['slug']     ?? '');
$excerpt  = $post['excerpt']         ?? ($_POST['excerpt']  ?? '');
$content  = $post['content']         ?? ($_POST['content']  ?? '');
$status   = $post['status']          ?? ($_POST['status']   ?? 'draft');
$pub_date = $post['published_at']    ?? ($_POST['published_at'] ?? '');
$feat_img = $post['featured_image']  ?? ($_POST['featured_image'] ?? '');

admin_header($is_new ? 'New Blog Post' : 'Edit Post', 'blog');
admin_sidebar('blog');
?>
<div class="admin-main">
  <div class="topbar">
    <h1><?= $is_new ? 'New Blog Post' : 'Edit: ' . h($title) ?></h1>
    <div class="topbar-actions">
      <a href="/admin/blog.php" class="btn btn-secondary btn-sm">← All Posts</a>
    </div>
  </div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success">Post saved successfully.</div><?php endif; ?>
    <?php foreach ($errors as $e): ?><div class="alert alert-error"><?= h($e) ?></div><?php endforeach; ?>

    <div class="card">
      <form method="POST" action="/admin/blog-edit.php<?= $id ? '?id=' . $id : '' ?>">
        <?= csrf_field() ?>

        <div class="form-group">
          <label for="title">Title *</label>
          <input type="text" id="title" name="title" value="<?= h($title) ?>" required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="<?= h($slug_val) ?>" placeholder="auto-generated from title">
            <div class="form-hint">URL-safe identifier. Leave blank to auto-generate.</div>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
              <option value="draft"     <?= $status === 'draft'     ? 'selected' : '' ?>>Draft</option>
              <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Published</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="published_at">Publish Date</label>
            <input type="date" id="published_at" name="published_at"
                   value="<?= h($pub_date ? date('Y-m-d', strtotime($pub_date)) : '') ?>">
          </div>
          <div class="form-group">
            <label for="featured_image">Featured Image URL</label>
            <input type="url" id="featured_image" name="featured_image" value="<?= h($feat_img) ?>"
                   placeholder="https://...">
            <?php if ($feat_img): ?>
              <img src="<?= h($feat_img) ?>" class="img-preview" alt="Preview">
            <?php endif; ?>
          </div>
        </div>

        <div class="form-group">
          <label for="excerpt">Excerpt</label>
          <textarea id="excerpt" name="excerpt" style="min-height:80px;"><?= h($excerpt) ?></textarea>
          <div class="form-hint">Short summary shown in blog listings.</div>
        </div>

        <div class="form-group">
          <label for="content">Content * <span style="font-weight:400;color:#787870;">(HTML allowed)</span></label>
          <textarea id="content" name="content" style="min-height:320px;font-family:monospace;"><?= h($content) ?></textarea>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:.5rem;">
          <button type="submit" class="btn btn-primary">Save Post</button>
          <a href="/admin/blog.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php admin_footer(); ?>
