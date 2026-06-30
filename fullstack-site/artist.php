<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('artist');
$c   = get_page_content('artist', [
    'statement' => "My practice is concerned with displacement, identity, belonging and the politics of place. I work with natural materials, found objects, photography, printmaking, installation and collaborative processes.\n\nMuch of my work is made in response to specific communities or environments — exploring what it means to belong somewhere, and what happens when that sense of belonging is disrupted or denied.",
]);
$page_title = $seo['title'] ?? 'Artist Statement — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Artist statement and visual art practice of Jess Linton — socially engaged art exploring displacement, identity and belonging.';
$preview_images = [
    ['src'=>'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414254594-1MLJTUUY4GI8JIV34SBJ/97F96999-11C6-4F11-AF3F-D323D7BD748E+%281%29.jpg','alt'=>'Frequent Crossings to England','title'=>'Frequent Crossings to England'],
    ['src'=>'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1455539179425-CUVAN0HFW5OOHRJJFQOA/IMG_4607.JPG','alt'=>'Bread Freedom and Social Justice','title'=>'Bread Freedom and Social Justice'],
    ['src'=>'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568473002893-PPUAKE888FD6ET6YRYU7/IMG_5248.JPG','alt'=>'Shadow Play + Solace','title'=>'Shadow Play + Solace'],
    ['src'=>'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412777500187-5WNGOLS77IEGGJ6HBYTF/You%26MeWeCollide.jpg','alt'=>'You and Me We Collide','title'=>'You and Me We Collide'],
    ['src'=>'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524085233846-ZEZB62GGY1PJ8WIZEJPL/performance+and+protest.jpg','alt'=>'Performance and Protest','title'=>'Performance and Protest'],
    ['src'=>'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412777392466-UZ1TXSGPVVOUAC2I2AMR/Rising+sun+jpeg.jpg','alt'=>'Rising Sun','title'=>'Rising Sun'],
];
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Visual Art</span>
    <h1 class="reveal d1">Artist Statement</h1>
  </div></header>
  <section class="section--lg"><div class="container">
    <div class="media-text reveal">
      <div class="media-col"><img class="media-col__img" loading="lazy" src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414254594-1MLJTUUY4GI8JIV34SBJ/97F96999-11C6-4F11-AF3F-D323D7BD748E+%281%29.jpg" alt="Jess Linton artwork"></div>
      <div class="text-col">
        <div class="rich-text">
          <?php foreach (explode("\n\n", $c['statement']) as $p): if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; endforeach; ?>
        </div>
        <a href="/artwork.php" class="btn" style="margin-top:1.5rem;">View Artwork <span class="arrow">→</span></a>
      </div>
    </div>
  </div></section>
  <section class="section"><div class="container">
    <span class="eyebrow">Gallery Preview</span>
    <h2 class="reveal">Selected Works</h2>
    <div class="gallery-preview">
      <?php foreach ($preview_images as $img): ?>
      <a href="/artwork.php" class="gallery-preview__item reveal">
        <img src="<?= h($img['src']) ?>" alt="<?= h($img['alt']) ?>" loading="lazy">
        <div class="gallery-overlay"><span><?= h($img['title']) ?></span></div>
      </a>
      <?php endforeach; ?>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
