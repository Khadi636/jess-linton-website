<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

// Dashboard stats
try {
    $db            = get_db();
    $page_count    = $db->query('SELECT COUNT(*) FROM pages')->fetchColumn();
    $post_count    = $db->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
    $pub_count     = $db->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'")->fetchColumn();
    $gallery_count = $db->query('SELECT COUNT(*) FROM gallery_images')->fetchColumn();
    $recent_posts  = $db->query('SELECT title, status, published_at FROM blog_posts ORDER BY created_at DESC LIMIT 5')->fetchAll();
} catch (PDOException $e) {
    $page_count = $post_count = $pub_count = $gallery_count = 0;
    $recent_posts = [];
}

admin_header('Dashboard', 'dashboard');
admin_sidebar('dashboard');
?>
<div class="admin-main">
  <div class="topbar">
    <h1>Dashboard</h1>
    <div class="topbar-actions">
      <a href="/" target="_blank">↗ View site</a>
    </div>
  </div>
  <div class="page-body">

    <div class="stats-grid">
      <div class="stat-card">
        <div class="label">CMS Pages</div>
        <div class="value"><?= (int)$page_count ?></div>
      </div>
      <div class="stat-card">
        <div class="label">Blog Posts</div>
        <div class="value"><?= (int)$post_count ?></div>
      </div>
      <div class="stat-card">
        <div class="label">Published</div>
        <div class="value"><?= (int)$pub_count ?></div>
      </div>
      <div class="stat-card">
        <div class="label">Gallery Images</div>
        <div class="value"><?= (int)$gallery_count ?></div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <span class="card-title">Recent Blog Posts</span>
        <a href="/admin/blog-edit.php" class="btn btn-primary btn-sm">+ New Post</a>
      </div>
      <?php if (empty($recent_posts)): ?>
        <p style="color:#787870;font-size:.85rem;">No blog posts yet.</p>
      <?php else: ?>
      <table>
        <thead><tr><th>Title</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($recent_posts as $p): ?>
          <tr>
            <td><?= h($p['title']) ?></td>
            <td><span class="badge <?= $p['status'] === 'published' ? 'badge-green' : 'badge-grey' ?>"><?= h($p['status']) ?></span></td>
            <td><?= h($p['published_at'] ? fmt_date($p['published_at']) : '—') ?></td>
            <td><a href="/admin/blog-edit.php?slug=<?= urlencode($p['slug'] ?? '') ?>" class="btn btn-secondary btn-sm">Edit</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>

    <div class="card" style="margin-top:1.5rem;">
      <div class="card-header"><span class="card-title">Quick Links</span></div>
      <div style="display:flex;flex-wrap:wrap;gap:.75rem;">
        <a href="/admin/pages.php"   class="btn btn-secondary">Edit Pages</a>
        <a href="/admin/gallery.php" class="btn btn-secondary">Manage Gallery</a>
        <a href="/admin/contact.php" class="btn btn-secondary">Contact Settings</a>
        <a href="/admin/seo.php"     class="btn btn-secondary">SEO Settings</a>
      </div>
    </div>

  </div>
</div>
<?php admin_footer(); ?>
