<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('community');
$c   = get_page_content('community', ['intro_text' => 'Community arts practice and creative collaboration with schools, hospitals, refugee networks and community groups across Sussex and beyond.']);
$page_title   = $seo['title'] ?? 'Community — Jess Linton';
$meta_desc    = $seo['meta_description'] ?? 'Community arts practice by Jess Linton — creative collaboration with schools, hospitals, refugee networks and community groups.';
$header_class = 'header-hero';
require_once __DIR__ . '/includes/header.php';
?>
  <section class="slideshow" aria-label="Community Practice">
    <div class="hero-slides">
      <div class="hero-slide active"><img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568994581980-SDMGOTP7DTBPZPAIGWKG/IMG_4818.JPG" alt="Community arts"></div>
      <div class="hero-slide"><img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1430474262166-28FCTQZENUTSGN63FWZD/image-asset.jpeg" alt="Community practice"></div>
      <div class="hero-slide"><img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1618146511818-407BTXZ6G4MEUUQNWWMP/IMG_6621.JPG" alt="The Plot Stanmer"></div>
    </div>
    <div class="slideshow__content"><h1><em>Community</em></h1></div>
    <div class="hero-dots">
      <button class="hero-dot active" aria-label="Slide 1"></button>
      <button class="hero-dot" aria-label="Slide 2"></button>
      <button class="hero-dot" aria-label="Slide 3"></button>
    </div>
  </section>
  <section class="section"><div class="container"><div class="rich-text reveal" style="max-width:70ch;"><p><?= nl2br_h($c['intro_text']) ?></p></div></div></section>
  <section class="section"><div class="container">
    <div class="feature-grid">
      <a href="/overview.php" class="feature-card reveal d1"><span class="feature-card__num">01</span><h2>Overview</h2><p>Community practice settings: schools, SEN, hospitals, refugee networks and more.</p></a>
      <a href="/starling-project.php" class="feature-card reveal d2"><span class="feature-card__num">02</span><h2>The Starling Project</h2><p>Arts and wellbeing programmes supporting refugees and asylum seekers in Brighton.</p></a>
      <a href="/the-plot-stanmer.php" class="feature-card reveal d3"><span class="feature-card__num">03</span><h2>The Plot Stanmer</h2><p>An outdoor wellbeing space in Stanmer Park, Brighton.</p></a>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
