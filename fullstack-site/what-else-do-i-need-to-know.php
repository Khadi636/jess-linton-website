<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('what-else-do-i-need-to-know');
$c   = get_page_content('what-else-do-i-need-to-know', [
    'intro_text' => 'Here is some practical information about what to expect when working with Jess.',
    'fees_text'  => "Sessions cost between £35 and £60 per hour, depending on your circumstances.\n\nJess operates a sliding scale and aims to make therapy accessible. Please get in touch to discuss fees.",
]);
$fee  = get_contact('session_fee', '£35–£60 per hour');
$page_title = $seo['title'] ?? 'What Else Do I Need to Know? — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Practical information about art therapy sessions with Jess Linton — fees, location, what to expect.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Art Therapy</span>
    <h1 class="reveal d1">What Else Do I Need to Know?</h1>
  </div></header>
  <section class="section--lg"><div class="container">
    <div class="media-text reveal">
      <div class="media-col"><img class="media-col__img" loading="lazy" src="https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1618146511818-407BTXZ6G4MEUUQNWWMP/IMG_6621.JPG" alt="The Plot Stanmer"></div>
      <div class="text-col">
        <div class="rich-text">
          <p><?= nl2br_h($c['intro_text']) ?></p>
        </div>
        <div class="info-block" style="margin-top:1.5rem;">
          <h2>Location</h2>
          <p>Sessions take place at The Plot Stanmer, an outdoor wellbeing space in Stanmer Park, Brighton, and at other locations in Sussex. Online sessions are also available.</p>
          <h2 style="margin-top:1rem;">Fees</h2>
          <?php foreach (explode("\n\n", $c['fees_text']) as $p): if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; endforeach; ?>
          <h2 style="margin-top:1rem;">Sessions</h2>
          <p>Sessions last 50 minutes. Frequency is discussed at an initial meeting and reviewed regularly. A free 20-minute phone consultation is available before committing.</p>
        </div>
      </div>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
