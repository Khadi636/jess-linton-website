<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$slug = preg_replace('/[^a-z0-9\-]/', '', $_GET['slug'] ?? '');
if (!$slug) { header('Location: /blog.php'); exit; }
$post = get_blog_post_by_slug($slug);
if (!$post || $post['status'] !== 'published') { http_response_code(404); require __DIR__ . '/404.php'; exit; }
$page_title = $post['title'] . ' — Jess Linton';
$meta_desc  = $post['excerpt'] ?? substr(strip_tags($post['content']), 0, 160);
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Blog</span>
    <h1 class="reveal d1"><?= h($post['title']) ?></h1>
    <p class="text-muted" style="margin-top:.5rem;"><?= h(fmt_date($post['published_at'])) ?></p>
  </div></header>
  <?php if (!empty($post['featured_image'])): ?>
  <div style="max-height:480px;overflow:hidden;"><img src="<?= h($post['featured_image']) ?>" alt="<?= h($post['title']) ?>" style="width:100%;object-fit:cover;max-height:480px;" loading="lazy"></div>
  <?php endif; ?>
  <section class="section"><div class="container">
    <div class="rich-text prose" style="max-width:68ch;">
      <?= $post['content'] /* HTML stored as-is — already sanitised on input */ ?>
    </div>
    <div style="margin-top:3rem;"><a href="/blog.php" class="btn btn--ghost">← All posts</a></div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
