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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    csrf_verify();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            get_db()->prepare('DELETE FROM blog_posts WHERE id = ?')->execute([$id]);
            $success = 'Post deleted.';
        } catch (PDOException $e) {
            $error = 'Delete failed.';
        }
    }
}

$posts = get_all_blog_posts_admin();

admin_header('Blog Posts', 'blog');
admin_sidebar('blog');
?>
<div class="admin-main">
  <div class="topbar">
    <h1>Blog Posts</h1>
    <div class="topbar-actions">
      <a href="/admin/blog-edit.php" class="btn btn-primary btn-sm">+ New Post</a>
    </div>
  </div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>
    <div class="card">
      <?php if (empty($posts)): ?>
        <p style="color:#787870;font-size:.85rem;">No blog posts yet. <a href="/admin/blog-edit.php">Create one.</a></p>
      <?php else: ?>
      <table>
        <thead><tr><th>Title</th><th>Slug</th><th>Status</th><th>Published</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($posts as $p): ?>
          <tr>
            <td><?= h($p['title']) ?></td>
            <td><code style="font-size:.75rem;background:#f5f5f3;padding:.1rem .35rem;border-radius:3px;"><?= h($p['slug']) ?></code></td>
            <td><span class="badge <?= $p['status'] === 'published' ? 'badge-green' : 'badge-grey' ?>"><?= h($p['status']) ?></span></td>
            <td><?= h($p['published_at'] ? fmt_date($p['published_at']) : '—') ?></td>
            <td style="display:flex;gap:.4rem;align-items:center;">
              <a href="/admin/blog-edit.php?id=<?= (int)$p['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
              <form method="POST" action="/admin/blog.php" onsubmit="return confirm('Delete this post?')" style="display:inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php admin_footer(); ?>
