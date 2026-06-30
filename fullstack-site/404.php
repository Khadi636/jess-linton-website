<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
http_response_code(404);
$page_title = 'Page Not Found — Jess Linton';
$meta_desc  = '';
require_once __DIR__ . '/includes/header.php';
?>
  <section class="section--xl" style="text-align:center;">
    <div class="container">
      <span class="eyebrow">404</span>
      <h1 style="font-size:clamp(4rem,10vw,8rem);line-height:.95;margin:.5rem 0 1rem;">Page not<br>found</h1>
      <hr style="width:3rem;border:none;border-top:2px solid var(--sand);margin:0 auto 1.5rem;">
      <p style="color:var(--ink-3);max-width:40ch;margin:0 auto 2.5rem;">The page you're looking for doesn't exist or may have moved.</p>
      <div class="btn-row" style="justify-content:center;">
        <a href="/" class="btn">Go to Homepage</a>
        <a href="/contact.php" class="btn btn--ghost">Get in Touch</a>
      </div>
    </div>
  </section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
