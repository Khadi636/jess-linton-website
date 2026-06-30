<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$seo = get_seo('artwork');
$page_title = $seo['title']            ?? 'Artwork — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Gallery of artwork by Jess Linton — socially engaged visual art exploring displacement, identity, natural materials and the politics of belonging.';

// Load gallery images from DB; fall back to the original Squarespace CDN images
$db_images = get_gallery_images(100);

// Static fallback images (original site content)
$fallback_images = [
    ['title' => 'Frequent Crossings to England',                  'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414254594-1MLJTUUY4GI8JIV34SBJ/97F96999-11C6-4F11-AF3F-D323D7BD748E+%281%29.jpg'],
    ['title' => 'Bread Freedom and Social Justice',               'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1455539179425-CUVAN0HFW5OOHRJJFQOA/IMG_4607.JPG'],
    ['title' => 'Shadow Play + Solace II',                        'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568473002893-PPUAKE888FD6ET6YRYU7/IMG_5248.JPG'],
    ['title' => 'Shadow Play + Solace I',                         'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414523807-3KUJ7KOMH0VWX5H5P3BD/6B1D60F4-0A47-407E-B3C3-99D790E34F09.jpg'],
    ['title' => 'The Sun Has Just Come Up',                       'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414724755-A0ZBCHYBSYNW4GR4OQ8M/CE51624E-D7BA-4BC1-8D92-7F95A361DD13.jpg'],
    ['title' => "What's Mine? What's Yours?",                     'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1455538487903-0QF75I16ECO4OZWSA6X8/JessLintonartist02.jpg'],
    ['title' => 'Artwork by Jess Linton',                         'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1455536933004-LXQI6R3BDA7K8Y95YXK7/Untitled+%282%29.jpg'],
    ['title' => 'Rising Sun',                                     'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412777392466-UZ1TXSGPVVOUAC2I2AMR/Rising+sun+jpeg.jpg'],
    ['title' => 'You and Me We Collide',                          'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412777500187-5WNGOLS77IEGGJ6HBYTF/You%26MeWeCollide.jpg'],
    ['title' => 'What Makes a Safe Space?',                       'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524093262059-BAOZCYW0HTPRDO6NCVE4/CJAT+JL+01+What+makes+a+safe+space.JPG'],
    ['title' => 'Akademi',                                        'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524091722258-K78K0G5006D9XOB1V79C/akademi+7FINAL.jpg'],
    ['title' => 'ARU + UNHCR Nepal',                              'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524092168842-TZZMO9YK3O001G6J59EJ/ARU+and+UNHCR+Nepal+04.JPG'],
    ['title' => 'Castlehaven Project',                            'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524092294763-2KE1JZBHW287RE9PIKU0/Castlehaven+Project+01.JPG'],
    ['title' => 'Akademi Lambeth',                                'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524092272903-GL4IXOVGFO0OZ1GIKPS1/Akademi+Lambeth+12.jpg'],
    ['title' => 'A Collaboration',                                'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524093194399-1SP706R5TENKSAQMK6KZ/CJAT+JL+15+A+Collaboration.JPG'],
    ['title' => 'Performance and Protest',                        'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524085233846-ZEZB62GGY1PJ8WIZEJPL/performance+and+protest.jpg'],
    ['title' => 'The Plot Stanmer',                               'image_url' => 'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1618146511818-407BTXZ6G4MEUUQNWWMP/IMG_6621.JPG'],
];

$images = !empty($db_images) ? $db_images : $fallback_images;

require_once __DIR__ . '/includes/header.php';
?>

  <header class="page-header">
    <div class="container">
      <span class="eyebrow reveal">Visual Art</span>
      <h1 class="reveal d1">Artwork</h1>
    </div>
  </header>

  <section class="section--gallery">
    <div class="container">
      <div class="gallery" id="gallery">
        <?php foreach ($images as $img): ?>
          <?php
          $url   = !empty($img['image_url']) ? $img['image_url'] : (UPLOAD_URL . 'gallery/' . ($img['image_path'] ?? ''));
          $title = $img['title'] ?? '';
          ?>
          <?php if ($url): ?>
          <div class="gallery-item" <?= $title ? 'data-title="' . h($title) . '"' : '' ?>>
            <img src="<?= h($url) ?>" alt="<?= h($title ?: 'Artwork by Jess Linton') ?>" loading="lazy">
            <?php if ($title): ?><div class="gallery-overlay"><span><?= h($title) ?></span></div><?php endif; ?>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Lightbox -->
  <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image viewer" aria-hidden="true">
    <button class="lightbox__close" aria-label="Close">&times;</button>
    <button class="lightbox__prev" aria-label="Previous image">&#8592;</button>
    <button class="lightbox__next" aria-label="Next image">&#8594;</button>
    <div class="lightbox__img-wrap">
      <img id="lightbox-img" src="" alt="">
    </div>
    <p class="lightbox__caption" id="lightbox-caption"></p>
  </div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
