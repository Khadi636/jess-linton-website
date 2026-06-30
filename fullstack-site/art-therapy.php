<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('art-therapy');
$c   = get_page_content('art-therapy', ['intro_text' => 'Art therapy is a form of psychotherapy that uses art-making as its primary mode of communication. It is offered to people of all ages as a means of addressing emotional, developmental and mental health needs.']);
$page_title   = $seo['title'] ?? 'Art Therapy — Jess Linton';
$meta_desc    = $seo['meta_description'] ?? 'Art therapy services by Jess Linton — HCPC registered Art Psychotherapist in Sussex, UK.';
$header_class = 'header-hero';
require_once __DIR__ . '/includes/header.php';
?>
  <section class="slideshow" aria-label="Art Therapy">
    <div class="hero-slides">
      <div class="hero-slide active"><img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524085233846-ZEZB62GGY1PJ8WIZEJPL/performance+and+protest.jpg" alt="Art Therapy"></div>
      <div class="hero-slide"><img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568994581980-SDMGOTP7DTBPZPAIGWKG/IMG_4818.JPG" alt="Art Therapy session"></div>
      <div class="hero-slide"><img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1430474262166-28FCTQZENUTSGN63FWZD/image-asset.jpeg" alt="Creative practice"></div>
    </div>
    <div class="slideshow__content">
      <h1><em>Art Therapy</em></h1>
    </div>
    <div class="hero-dots">
      <button class="hero-dot active" aria-label="Slide 1"></button>
      <button class="hero-dot" aria-label="Slide 2"></button>
      <button class="hero-dot" aria-label="Slide 3"></button>
    </div>
  </section>
  <section class="section">
    <div class="container">
      <div class="rich-text reveal" style="max-width:70ch;">
        <p><?= nl2br_h($c['intro_text']) ?></p>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="container">
      <div class="feature-grid">
        <a href="/what-is-art-therapy.php" class="feature-card reveal d1"><span class="feature-card__num">01</span><h2>What is Art Therapy?</h2><p>Understanding what art therapy is and how it works.</p></a>
        <a href="/what-can-jess-offer.php" class="feature-card reveal d2"><span class="feature-card__num">02</span><h2>What Can Jess Offer?</h2><p>Individual therapy, consultation, supervision and more.</p></a>
        <a href="/what-else-do-i-need-to-know.php" class="feature-card reveal d3"><span class="feature-card__num">03</span><h2>What Else Do I Need to Know?</h2><p>Fees, location, sessions and practical information.</p></a>
      </div>
    </div>
  </section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
