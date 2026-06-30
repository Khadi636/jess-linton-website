<?php
// Expected variables set by calling page:
// $page_title  (string) — <title> content
// $meta_desc   (string) — <meta description>
// $body_class  (string, optional) — extra class on <body>
// $header_class (string, optional) — 'header-hero' for full-bleed pages
$body_class   = $body_class   ?? '';
$header_class = $header_class ?? '';
$page_title   = isset($page_title)  ? h($page_title)  : h(SITE_NAME);
$meta_desc    = isset($meta_desc)   ? h($meta_desc)   : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?></title>
  <?php if ($meta_desc): ?><meta name="description" content="<?= $meta_desc ?>"><?php endif; ?>
  <link rel="icon" href="/public/favicon.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,200;0,9..144,400;1,9..144,200;1,9..144,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/public/css/style.css">
</head>
<body class="<?= h($body_class) ?>">

<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header <?= h($header_class) ?>" id="site-header">
  <div class="container">
    <nav class="nav" aria-label="Main navigation">
      <a href="/" class="nav-logo">Jess Linton</a>
      <ul class="nav-list" role="list">
        <li><a href="/about.php" class="nav-link">About</a></li>
        <li class="nav-item--has-dropdown">
          <button class="nav-link nav-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
            Art Therapy <span class="nav-chevron">&#8964;</span>
          </button>
          <ul class="nav-dropdown" role="list">
            <li><a href="/what-is-art-therapy.php" class="nav-dropdown-link">What is Art Therapy?</a></li>
            <li><a href="/what-can-jess-offer.php" class="nav-dropdown-link">What Can Jess Offer?</a></li>
            <li><a href="/what-else-do-i-need-to-know.php" class="nav-dropdown-link">What Else Do I Need to Know?</a></li>
          </ul>
        </li>
        <li class="nav-item--has-dropdown">
          <button class="nav-link nav-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
            Art <span class="nav-chevron">&#8964;</span>
          </button>
          <ul class="nav-dropdown" role="list">
            <li><a href="/artist.php" class="nav-dropdown-link">Artist Statement</a></li>
            <li><a href="/artwork.php" class="nav-dropdown-link">Artwork</a></li>
          </ul>
        </li>
        <li class="nav-item--has-dropdown">
          <button class="nav-link nav-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
            Community <span class="nav-chevron">&#8964;</span>
          </button>
          <ul class="nav-dropdown" role="list">
            <li><a href="/overview.php" class="nav-dropdown-link">Overview</a></li>
            <li><a href="/starling-project.php" class="nav-dropdown-link">The Starling Project</a></li>
            <li><a href="/the-plot-stanmer.php" class="nav-dropdown-link">The Plot Stanmer</a></li>
          </ul>
        </li>
        <li><a href="/blog.php" class="nav-link">Blog</a></li>
        <li><a href="/articles.php" class="nav-link">Articles</a></li>
        <li><a href="/contact.php" class="nav-link">Contact</a></li>
      </ul>
      <div class="nav-social" aria-label="Social media links">
        <a href="https://www.flickr.com/people/132257489@N03/" target="_blank" rel="noopener" aria-label="Flickr">FL</a>
        <a href="https://www.pinterest.com/JessLint0n/" target="_blank" rel="noopener" aria-label="Pinterest">PI</a>
        <a href="https://www.linkedin.com/in/jess-linton-9a38ab78" target="_blank" rel="noopener" aria-label="LinkedIn">LI</a>
        <a href="https://www.instagram.com/jess.a.linton" target="_blank" rel="noopener" aria-label="Instagram">IG</a>
      </div>
      <button class="nav-toggle" id="nav-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-nav">
        <span></span><span></span><span></span>
      </button>
    </nav>
  </div>
</header>

<nav class="mobile-nav" id="mobile-nav" role="dialog" aria-label="Mobile navigation" aria-hidden="true">
  <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">&times;</button>
  <ul class="mobile-nav-links" role="list">
    <li><a href="/" class="mobile-nav-link">Home <span>→</span></a></li>
    <li><a href="/about.php" class="mobile-nav-link">About <span>→</span></a></li>
    <li><a href="/art-therapy.php" class="mobile-nav-link">Art Therapy <span>→</span></a></li>
    <li><a href="/artist.php" class="mobile-nav-link">Art <span>→</span></a></li>
    <li><a href="/overview.php" class="mobile-nav-link">Community <span>→</span></a></li>
    <li><a href="/blog.php" class="mobile-nav-link">Blog <span>→</span></a></li>
    <li><a href="/articles.php" class="mobile-nav-link">Articles <span>→</span></a></li>
    <li><a href="/contact.php" class="mobile-nav-link">Contact <span>→</span></a></li>
  </ul>
  <div class="mobile-nav-footer">
    <a href="https://www.flickr.com/people/132257489@N03/" target="_blank" rel="noopener">Flickr</a>
    <a href="https://www.pinterest.com/JessLint0n/" target="_blank" rel="noopener">Pinterest</a>
    <a href="https://www.linkedin.com/in/jess-linton-9a38ab78" target="_blank" rel="noopener">LinkedIn</a>
    <a href="https://www.instagram.com/jess.a.linton" target="_blank" rel="noopener">Instagram</a>
  </div>
</nav>

<main id="main">
