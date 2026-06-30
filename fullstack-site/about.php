<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('about');
$c   = get_page_content('about', [
    'page_heading'   => 'Jess Linton',
    'bio_text'       => "Jess Linton is an HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner. She has been working creatively in community, arts, social action, education and health settings with all ages for over 15 years.\n\nJess trained as an Art Therapist at Goldsmiths, University of London and has worked in a wide range of settings including schools, hospitals, refugee and asylum-seeker support services, community centres and outdoor wellbeing spaces.",
    'expertise_text' => "Jess works with individuals, groups and communities to explore difficult experiences, emotions and relationships through the creative process. She is particularly skilled in working with themes of displacement, loss, identity and belonging.",
]);
$page_title = $seo['title'] ?? 'About — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'About Jess Linton — HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner based in Sussex, UK.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header">
    <div class="container">
      <span class="eyebrow reveal">About</span>
      <h1 class="reveal d1"><?= h($c['page_heading']) ?></h1>
    </div>
  </header>
  <section class="section--lg">
    <div class="container">
      <div class="media-text reveal">
        <div class="media-col">
          <img class="media-col__img" loading="lazy"
               src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1430474262166-28FCTQZENUTSGN63FWZD/image-asset.jpeg"
               alt="Jess Linton">
        </div>
        <div class="text-col">
          <span class="eyebrow">Biography</span>
          <h2>HCPC Registered Art Psychotherapist</h2>
          <div class="rich-text">
            <?php foreach (explode("\n\n", $c['bio_text']) as $p): ?>
              <?php if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section band-dark section--lg reveal">
    <div class="container">
      <span class="eyebrow">Areas of Expertise</span>
      <h2>Therapeutic Portfolio</h2>
      <div class="rich-text">
        <?php foreach (explode("\n\n", $c['expertise_text']) as $p): ?>
          <?php if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
