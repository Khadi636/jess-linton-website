<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('what-can-jess-offer');
$c   = get_page_content('what-can-jess-offer', ['intro_text' => 'Jess offers a range of services tailored to individuals, groups, organisations and professionals.']);
$page_title = $seo['title'] ?? 'What Can Jess Offer? — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Art therapy services offered by Jess Linton including individual therapy, group work, consultation, supervision and training.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Art Therapy</span>
    <h1 class="reveal d1">What Can Jess Offer?</h1>
  </div></header>
  <section class="section"><div class="container">
    <p class="reveal" style="max-width:60ch;font-size:1.1rem;line-height:1.7;"><?= nl2br_h($c['intro_text']) ?></p>
  </div></section>
  <section class="section"><div class="container">
    <h2 class="sr-only">Services</h2>
    <div class="services-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
      <?php
      $services = [
        ['num'=>'01','title'=>'Individual Art Therapy','desc'=>'One-to-one therapeutic work using art-making as the primary mode of communication. Sessions last 50 minutes and can be short- or long-term.'],
        ['num'=>'02','title'=>'Group Art Therapy','desc'=>'Therapeutic groups for adults or young people, exploring shared themes through art-making in a safe, boundaried space.'],
        ['num'=>'03','title'=>'Consultation','desc'=>'Support for organisations, teams and individuals working with vulnerable populations where art therapy or creative approaches may be helpful.'],
        ['num'=>'04','title'=>'Supervision','desc'=>'Clinical supervision for art therapists and other creative practitioners, offered individually or in small groups.'],
        ['num'=>'05','title'=>'Training & Workshops','desc'=>'Tailored training days and workshops for schools, charities, health services and other organisations on art therapy and creative approaches.'],
      ];
      foreach ($services as $s): ?>
      <div class="feature-card reveal">
        <span class="feature-card__num"><?= h($s['num']) ?></span>
        <h3><?= h($s['title']) ?></h3>
        <p><?= h($s['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
