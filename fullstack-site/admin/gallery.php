<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

$success = '';
$error   = '';

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    csrf_verify();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            $db   = get_db();
            $row  = get_gallery_image($id);
            $db->prepare('DELETE FROM gallery_images WHERE id = ?')->execute([$id]);
            // Remove local file if it exists
            if ($row && !empty($row['image_path'])) {
                $file = UPLOAD_PATH . 'gallery/' . basename($row['image_path']);
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $success = 'Image deleted.';
        } catch (PDOException $e) {
            $error = 'Delete failed.';
        }
    }
}

$images = get_gallery_images(200);

admin_header('Gallery', 'gallery');
admin_sidebar('gallery');
?>
<div class="admin-main">
  <div class="topbar">
    <h1>Gallery Images</h1>
    <div class="topbar-actions">
      <a href="/admin/gallery-edit.php" class="btn btn-primary btn-sm">+ Add Image</a>
    </div>
  </div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

    <?php if (empty($images)): ?>
      <div class="card"><p style="color:#787870;">No gallery images yet. <a href="/admin/gallery-edit.php">Add one.</a></p></div>
    <?php else: ?>
    <div class="gallery-admin-grid">
      <?php foreach ($images as $img): ?>
      <div class="gallery-admin-item">
        <?php $url = gallery_img_url($img); ?>
        <?php if ($url): ?>
          <img src="<?= h($url) ?>" alt="<?= h($img['title'] ?? '') ?>" loading="lazy">
        <?php else: ?>
          <div style="height:120px;background:#eee;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:.8rem;">No image</div>
        <?php endif; ?>
        <div class="gallery-admin-item-actions">
          <a href="/admin/gallery-edit.php?id=<?= (int)$img['id'] ?>" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center;">Edit</a>
          <form method="POST" onsubmit="return confirm('Delete this image?')">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)$img['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">✕</button>
          </form>
        </div>
        <?php if (!empty($img['title'])): ?>
          <div style="padding:.35rem .5rem;font-size:.72rem;color:#787870;background:#fafaf8;"><?= h($img['title']) ?></div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php admin_footer(); ?>
