<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$seo = get_seo('blog');
$page_title = $seo['title']            ?? 'Blog — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Writing and reflections from Jess Linton on art therapy, community practice, and creative life.';

$posts = get_blog_posts(20, 'published');

require_once __DIR__ . '/includes/header.php';
?>

  <header class="page-header">
    <div class="container">
      <span class="eyebrow reveal">Writing</span>
      <h1 class="reveal d1">Blog</h1>
    </div>
  </header>

  <section class="section">
    <div class="container">
      <?php if (empty($posts)): ?>
        <p class="text-muted">No posts published yet. Check back soon.</p>
      <?php else: ?>
      <div class="blog-list">
        <?php foreach ($posts as $post): ?>
        <article class="blog-post reveal">
          <div class="blog-post__date">
            <strong><?= h(fmt_date($post['published_at'] ?? '', 'M')) ?></strong>
            <?= h(fmt_date($post['published_at'] ?? '', 'Y')) ?>
          </div>
          <div class="blog-post__body">
            <h2 class="blog-post__title">
              <a href="/blog-post.php?slug=<?= urlencode($post['slug']) ?>"><?= h($post['title']) ?></a>
            </h2>
            <?php if (!empty($post['excerpt'])): ?>
              <p class="blog-post__excerpt"><?= h($post['excerpt']) ?></p>
            <?php endif; ?>
            <a href="/blog-post.php?slug=<?= urlencode($post['slug']) ?>" class="blog-post__link">
              Read more <span class="arrow">→</span>
            </a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
