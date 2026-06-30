<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = get_seo('overview');
$c   = get_page_content('overview', ['intro_text' => 'Jess has extensive experience working creatively with a wide range of communities and settings. She is committed to making creative practice accessible to all.']);
$page_title = $seo['title'] ?? 'Community Overview — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Community arts practice settings and experience of Jess Linton — schools, SEN, hospitals, refugee networks, and more.';
require_once __DIR__ . '/includes/header.php';
?>
  <header class="page-header"><div class="container">
    <span class="eyebrow reveal">Community</span>
    <h1 class="reveal d1">Community Practice</h1>
  </div></header>
  <section class="section"><div class="container"><p class="reveal" style="max-width:65ch;font-size:1.05rem;line-height:1.75;"><?= nl2br_h($c['intro_text']) ?></p></div></section>
  <section class="section"><div class="container">
    <h2 class="sr-only">Settings</h2>
    <div class="services-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
      <?php
      $settings = [
        ['title'=>'Schools & Colleges','desc'=>'Primary and secondary schools, SEN units, pupil referral units. Emotional literacy, resilience and wellbeing programmes.'],
        ['title'=>'Adult Mental Health','desc'=>'Community mental health teams, day centres, residential care. Recovery-oriented creative groups.'],
        ['title'=>'Refugee & Asylum Seeker Services','desc'=>'Supporting displaced people to process experiences of loss, trauma and transition through creative practice.'],
        ['title'=>'Hospitals & Health Settings','desc'=>'Paediatric wards, adult mental health inpatient units, hospices. Arts in health programmes.'],
        ['title'=>'Family & Youth Work','desc'=>'Family centres, children and family services, youth clubs. Intergenerational creative projects.'],
        ['title'=>'Outdoor & Environmental','desc'=>'Outdoor arts and wellbeing projects including The Plot Stanmer, an outdoor therapeutic space in Stanmer Park.'],
      ];
      foreach ($settings as $s): ?>
      <div class="feature-card reveal">
        <h3><?= h($s['title']) ?></h3>
        <p><?= h($s['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
