<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$seo = get_seo('home');
$c   = get_page_content('home', [
    'hero_title'    => "Art that heals,\nconnects &amp; bears witness.",
    'hero_subtitle' => 'HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner. Over 15 years working in community, education and health settings.',
    'about_heading' => 'Fifteen years in arts, health &amp; community',
    'about_text'    => "Jess Linton is an HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner. She has been working creatively in community, arts, social action, education and health settings with all ages for over 15 years.\n\nShe is an advocate for play and curiosity as a basic human right — for helping us to explore and make sense of ourselves, our relationships and the world around us.",
]);

$page_title   = $seo['title']            ?? 'Jess Linton — Art Psychotherapist, Visual Artist &amp; Creative Practitioner';
$meta_desc    = $seo['meta_description'] ?? 'HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner based in Sussex, UK. Over 15 years in community, education and health settings.';
$header_class = 'header-hero';

require_once __DIR__ . '/includes/header.php';
?>

  <!-- Full-viewport split hero -->
  <section class="hero" aria-label="Introduction">
    <div class="hero__media">
      <div class="hero-slides">
        <div class="hero-slide active">
          <img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412776034395-UX0D32WOQ8JZE6H02OFP/Jess+Linton+2014++04.jpg" alt="Jess Linton artwork">
        </div>
        <div class="hero-slide">
          <img src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1618168947769-01UC9S8LN32LQ6JS17UB/PHOTO-2021-04-10-10-13-19.jpg" alt="Jess Linton creative work">
        </div>
      </div>
      <div class="hero-dots">
        <button class="hero-dot active" aria-label="Slide 1"></button>
        <button class="hero-dot" aria-label="Slide 2"></button>
      </div>
    </div>
    <div class="hero__content">
      <p class="hero__eyebrow">Sussex, UK</p>
      <h1 class="hero__title">
        <em>Art that heals,</em>
        <strong><?= nl2br_h($c['hero_title']) ?></strong>
      </h1>
      <p class="hero__desc"><?= h($c['hero_subtitle']) ?></p>
      <div class="btn-row">
        <a href="/about.php" class="btn btn--ghost">About Jess</a>
        <a href="/what-is-art-therapy.php" class="btn btn--ghost">Art Therapy</a>
      </div>
      <p class="hero__scroll"><span class="hero__scroll-line"></span> Scroll to explore</p>
    </div>
  </section>

  <!-- Marquee strip -->
  <div class="marquee-strip" aria-hidden="true">
    <div class="marquee-inner">
      <span>Art Therapy</span><span>·</span>
      <span>Visual Art</span><span>·</span>
      <span>Community Practice</span><span>·</span>
      <span>Sussex, UK</span><span>·</span>
      <span>HCPC Registered</span><span>·</span>
      <span>Est. 2009</span><span>·</span>
      <span>Art Therapy</span><span>·</span>
      <span>Visual Art</span><span>·</span>
      <span>Community Practice</span><span>·</span>
      <span>Sussex, UK</span><span>·</span>
      <span>HCPC Registered</span><span>·</span>
      <span>Est. 2009</span><span>·</span>
    </div>
  </div>

  <!-- Feature cards -->
  <section aria-label="Three areas of practice">
    <div class="feature-grid">
      <a href="/what-is-art-therapy.php" class="feature-card reveal d1">
        <span class="feature-card__num">01</span>
        <h2>Art Therapy</h2>
        <p>HCPC registered art psychotherapy for individuals, groups, and communities in need of emotional and psychological support.</p>
      </a>
      <a href="/artist.php" class="feature-card reveal d2">
        <span class="feature-card__num">02</span>
        <h2>Visual Art</h2>
        <p>Socially engaged art practice exploring displacement, identity, natural materials, and the politics of belonging.</p>
      </a>
      <a href="/overview.php" class="feature-card reveal d3">
        <span class="feature-card__num">03</span>
        <h2>Community</h2>
        <p>Creative collaborations with schools, hospitals, refugee networks, and community groups across Sussex and beyond.</p>
      </a>
    </div>
  </section>

  <!-- About intro strip -->
  <section class="section--lg">
    <div class="container">
      <div class="media-text reveal">
        <div class="media-col">
          <img class="media-col__img" loading="lazy"
               src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1430474262166-28FCTQZENUTSGN63FWZD/image-asset.jpeg"
               alt="Jess Linton — Working with Trauma training session, Nepal">
          <p class="media-col__caption">Working with Trauma training session, Nepal Children's Art Museum, March 2015</p>
        </div>
        <div class="text-col">
          <span class="eyebrow">About Jess</span>
          <h2><?= h($c['about_heading']) ?></h2>
          <div class="rich-text">
            <?php foreach (explode("\n\n", $c['about_text']) as $para): ?>
              <?php if (trim($para)): ?><p><?= nl2br_h(trim($para)) ?></p><?php endif; ?>
            <?php endforeach; ?>
          </div>
          <a href="/about.php" class="btn">Read more <span class="arrow">→</span></a>
        </div>
      </div>
    </div>
  </section>

  <!-- Art therapy CTA band -->
  <section class="band band-green section reveal">
    <div class="container">
      <div class="band-inner">
        <div>
          <span class="eyebrow">Art Therapy</span>
          <h2>Could art therapy help you or someone you know?</h2>
        </div>
        <a href="/what-is-art-therapy.php" class="btn btn--white">Find out more <span class="arrow">→</span></a>
      </div>
    </div>
  </section>

  <!-- Pull quote -->
  <section class="section">
    <div class="container">
      <blockquote class="reveal">
        <p>"Art therapy can help us to process things that cannot yet be put into words."</p>
        <cite>— Jess Linton</cite>
      </blockquote>
    </div>
  </section>

  <!-- Community preview -->
  <section class="section--lg">
    <div class="container">
      <div class="media-text media-text--reverse reveal">
        <div class="media-col">
          <img class="media-col__img" loading="lazy"
               src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568994581980-SDMGOTP7DTBPZPAIGWKG/IMG_4818.JPG"
               alt="Community arts practice">
        </div>
        <div class="text-col">
          <span class="eyebrow">Community</span>
          <h2>Working creatively with communities</h2>
          <div class="rich-text">
            <p>Over 15 years of creative collaboration with schools, hospitals, refugee networks, and community groups. From The Starling Project to The Plot Stanmer.</p>
          </div>
          <a href="/overview.php" class="btn">Explore community work <span class="arrow">→</span></a>
        </div>
      </div>
    </div>
  </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
