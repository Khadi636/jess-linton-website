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
$image   = $id > 0 ? get_gallery_image($id) : null;
$is_new  = ($image === null);
$success = false;
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $title         = trim($_POST['title']          ?? '');
    $description   = trim($_POST['description']    ?? '');
    $image_url_in  = trim($_POST['image_url']      ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    $upload_err    = '';
    $new_filename  = null;

    // Handle file upload (takes precedence over URL)
    if (!empty($_FILES['image_file']['name'])) {
        $new_filename = handle_gallery_upload($_FILES['image_file'], $upload_err);
        if (!$new_filename) {
            $errors[] = $upload_err;
        }
    }

    if ($is_new && !$new_filename && !$image_url_in) {
        $errors[] = 'Please upload an image file or provide an image URL.';
    }

    if (empty($errors)) {
        try {
            $db = get_db();
            if ($is_new) {
                $stmt = $db->prepare(
                    'INSERT INTO gallery_images (title, description, image_path, image_url, display_order, created_at)
                     VALUES (?, ?, ?, ?, ?, NOW())'
                );
                $stmt->execute([$title, $description, $new_filename, $image_url_in, $display_order]);
                $id    = (int)$db->lastInsertId();
                $image = get_gallery_image($id);
            } else {
                // Only update image if a new one was uploaded
                if ($new_filename) {
                    // Delete old local file
                    if (!empty($image['image_path'])) {
                        $old = UPLOAD_PATH . 'gallery/' . basename($image['image_path']);
                        if (file_exists($old)) unlink($old);
                    }
                    $db->prepare(
                        'UPDATE gallery_images SET title=?, description=?, image_path=?, image_url=?, display_order=? WHERE id=?'
                    )->execute([$title, $description, $new_filename, $image_url_in, $display_order, $id]);
                } else {
                    $db->prepare(
                        'UPDATE gallery_images SET title=?, description=?, image_url=?, display_order=? WHERE id=?'
                    )->execute([$title, $description, $image_url_in, $display_order, $id]);
                }
                $image = get_gallery_image($id);
            }
            $success = true;
        } catch (PDOException $e) {
            error_log('gallery-edit: ' . $e->getMessage());
            $errors[] = 'Database error. Please try again.';
        }
    }
}

$title         = $image['title']         ?? ($_POST['title'] ?? '');
$description   = $image['description']   ?? ($_POST['description'] ?? '');
$image_url     = $image['image_url']     ?? ($_POST['image_url'] ?? '');
$display_order = $image['display_order'] ?? ($_POST['display_order'] ?? 0);
$current_url   = gallery_img_url($image ?? []);

admin_header($is_new ? 'Add Gallery Image' : 'Edit Gallery Image', 'gallery');
admin_sidebar('gallery');
?>
<div class="admin-main">
  <div class="topbar">
    <h1><?= $is_new ? 'Add Gallery Image' : 'Edit Gallery Image' ?></h1>
    <div class="topbar-actions">
      <a href="/admin/gallery.php" class="btn btn-secondary btn-sm">← Back to Gallery</a>
    </div>
  </div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success">Image saved.</div><?php endif; ?>
    <?php foreach ($errors as $e): ?><div class="alert alert-error"><?= h($e) ?></div><?php endforeach; ?>

    <div class="card">
      <form method="POST" action="/admin/gallery-edit.php<?= $id ? '?id=' . $id : '' ?>"
            enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-row">
          <div class="form-group">
            <label for="title">Title / Alt Text</label>
            <input type="text" id="title" name="title" value="<?= h($title) ?>">
          </div>
          <div class="form-group">
            <label for="display_order">Display Order</label>
            <input type="number" id="display_order" name="display_order" value="<?= (int)$display_order ?>" min="0">
            <div class="form-hint">Lower numbers appear first.</div>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" style="min-height:80px;"><?= h($description) ?></textarea>
        </div>

        <div class="form-group">
          <label for="image_file">Upload Image File</label>
          <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
          <div class="form-hint">JPEG, PNG, WebP, GIF. Max 5 MB. Overrides the URL below if provided.</div>
        </div>

        <div class="form-group">
          <label for="image_url">Or: External Image URL</label>
          <input type="url" id="image_url" name="image_url" value="<?= h($image_url) ?>"
                 placeholder="https://images.squarespace-cdn.com/...">
          <div class="form-hint">For existing Squarespace CDN images. Leave empty when uploading a file.</div>
        </div>

        <?php if ($current_url): ?>
        <div class="form-group">
          <label>Current Image</label>
          <img src="<?= h($current_url) ?>" class="img-preview" alt="Current">
        </div>
        <?php endif; ?>

        <div style="display:flex;gap:.75rem;margin-top:.5rem;">
          <button type="submit" class="btn btn-primary">Save Image</button>
          <a href="/admin/gallery.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php admin_footer(); ?>
