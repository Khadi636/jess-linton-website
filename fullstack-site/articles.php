<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('articles');
$c   = get_page_content('articles', ['intro_text' => 'Press, publications and media featuring Jess Linton and her work.']);
$page_title = $seo['title'] ?? 'Articles — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Press, publications, interviews and media featuring Jess Linton and her work in art therapy, community arts and visual art.';
$articles = [
    ['source'=>'The Guardian','title'=>'Art therapy: a guide to a growing treatment','url'=>'#','year'=>'2019'],
    ['source'=>'Brighton & Hove Independent','title'=>'Local therapist brings creative healing to refugee communities','url'=>'#','year'=>'2018'],
    ['source'=>'BAAT','title'=>'Community art therapy in practice: a case study','url'=>'#','year'=>'2017'],
    ['source'=>'Arts in Health Journal','title'=>'Outdoor art therapy: the evidence base','url'=>'#','year'=>'2020'],
];
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Press &amp; Publications</span>
    <h1 class="reveal d1">Articles</h1>
  </div></header>
  <section class="section--lg"><div class="container">
    <div class="media-text reveal">
      <div class="media-col"><img class="media-col__img" loading="lazy" src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568994581980-SDMGOTP7DTBPZPAIGWKG/IMG_4818.JPG" alt="Articles and press"></div>
      <div class="text-col">
        <p style="font-size:1.05rem;line-height:1.75;margin-bottom:2rem;"><?= nl2br_h($c['intro_text']) ?></p>
        <div class="article-list">
          <?php foreach ($articles as $a): ?>
          <div class="article-item">
            <span class="article-source"><?= h($a['source']) ?> &middot; <?= h($a['year']) ?></span>
            <a href="<?= h($a['url']) ?>" class="article-title"><?= h($a['title']) ?> <span class="arrow">→</span></a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
