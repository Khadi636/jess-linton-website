<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('what-is-art-therapy');
$c   = get_page_content('what-is-art-therapy', [
    'page_heading' => 'What is Art Therapy?',
    'intro_text'   => 'Art therapy is a form of psychotherapy that uses art-making as its primary mode of communication rather than talking. It is not a recreational activity or an art class.',
    'body_content' => "Art therapy can help people:\n\n- Express feelings that are difficult to put into words\n- Explore and process difficult or painful experiences\n- Develop insight and self-awareness\n- Manage anxiety, depression and emotional distress\n- Build resilience and coping strategies\n\nNo previous experience or ability in art is needed. The focus is on the process of art-making rather than the quality of the finished product.",
]);
$page_title = $seo['title'] ?? 'What is Art Therapy? — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Understand what art therapy is, how it works, and who it can help. HCPC registered Art Psychotherapist Jess Linton explains.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Art Therapy</span>
    <h1 class="reveal d1"><?= h($c['page_heading']) ?></h1>
  </div></header>
  <section class="section--lg"><div class="container">
    <div class="media-text reveal">
      <div class="media-col"><img class="media-col__img" loading="lazy" src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524085233846-ZEZB62GGY1PJ8WIZEJPL/performance+and+protest.jpg" alt="Art therapy"></div>
      <div class="text-col">
        <div class="rich-text">
          <p><?= nl2br_h($c['intro_text']) ?></p>
          <?php foreach (explode("\n\n", $c['body_content']) as $p): ?>
            <?php $p = trim($p); if ($p): ?>
              <?php if (strpos($p, "\n-") !== false || substr($p, 0, 1) === '-'): ?>
                <ul><?php foreach (explode("\n", $p) as $li): $li = trim(ltrim($li, '-')); if ($li): ?><li><?= h($li) ?></li><?php endif; endforeach; ?></ul>
              <?php else: ?><p><?= nl2br_h($p) ?></p><?php endif; ?>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <a href="/contact.php" class="btn" style="margin-top:1.5rem;">Get in touch <span class="arrow">→</span></a>
      </div>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
