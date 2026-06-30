<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('starling-project');
$c   = get_page_content('starling-project', [
    'intro_text'   => 'The Starling Project is an arts and wellbeing programme supporting refugees and asylum seekers in Brighton and Hove.',
    'body_content' => "The project brings together a range of creative activities including the Thursday Art Group, Threads of Life textile project, and the Hummingbird Project.\n\nThe Starling Project provides a safe, welcoming space for people from refugee and asylum-seeking communities to explore creative practice, build connections and develop wellbeing.",
]);
$page_title = $seo['title'] ?? 'The Starling Project — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'The Starling Project — arts and wellbeing programmes supporting refugees and asylum seekers in Brighton and Hove.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Community</span>
    <h1 class="reveal d1">The Starling Project</h1>
  </div></header>
  <section class="section--lg"><div class="container">
    <div class="media-text reveal">
      <div class="media-col"><img class="media-col__img" loading="lazy" src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568994581980-SDMGOTP7DTBPZPAIGWKG/IMG_4818.JPG" alt="The Starling Project"></div>
      <div class="text-col">
        <div class="rich-text">
          <p><?= nl2br_h($c['intro_text']) ?></p>
          <?php foreach (explode("\n\n", $c['body_content']) as $p): if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; endforeach; ?>
        </div>
        <a href="/contact.php" class="btn" style="margin-top:1.5rem;">Get involved <span class="arrow">→</span></a>
      </div>
    </div>
  </div></section>
  <section class="band band-green section reveal"><div class="container"><div class="band-inner">
    <div><span class="eyebrow">Hummingbird Project</span><h2>Supporting unaccompanied asylum-seeking children</h2></div>
    <a href="/contact.php" class="btn btn--white">Find out more <span class="arrow">→</span></a>
  </div></div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
