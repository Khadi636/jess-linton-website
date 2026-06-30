<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('the-plot-stanmer');
$c   = get_page_content('the-plot-stanmer', [
    'intro_text'   => 'The Plot Stanmer is an outdoor wellbeing space in Stanmer Park, Brighton — a place to slow down, connect with nature, and explore creative practice outdoors.',
    'body_content' => "The Plot offers individual art therapy sessions, small-group creative workshops and therapeutic programmes for a range of organisations and communities.\n\nThe space draws on the restorative qualities of the natural environment alongside art-making to support wellbeing and mental health.",
]);
$page_title = $seo['title'] ?? 'The Plot Stanmer — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'The Plot Stanmer — an outdoor wellbeing and creative arts space in Stanmer Park, Brighton.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Community</span>
    <h1 class="reveal d1">The Plot Stanmer</h1>
  </div></header>
  <section class="section--lg"><div class="container">
    <div class="media-text reveal">
      <div class="media-col"><img class="media-col__img" loading="lazy" src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1618146511818-407BTXZ6G4MEUUQNWWMP/IMG_6621.JPG" alt="The Plot Stanmer"></div>
      <div class="text-col">
        <div class="rich-text">
          <p><?= nl2br_h($c['intro_text']) ?></p>
          <?php foreach (explode("\n\n", $c['body_content']) as $p): if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; endforeach; ?>
        </div>
        <a href="https://www.theplotstanmer.org.uk/" target="_blank" rel="noopener" class="btn" style="margin-top:1.5rem;">Visit The Plot website <span class="arrow">↗</span></a>
      </div>
    </div>
  </div></section>
  <section class="band band-green section reveal"><div class="container"><div class="band-inner">
    <div><span class="eyebrow">Sessions at The Plot</span><h2>Book an outdoor art therapy session</h2></div>
    <a href="/contact.php" class="btn btn--white">Get in touch <span class="arrow">→</span></a>
  </div></div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
