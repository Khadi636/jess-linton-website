<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

// All known page slugs with friendly labels
$known_pages = [
    'home'                        => 'Home',
    'about'                       => 'About',
    'art-therapy'                 => 'Art Therapy',
    'what-is-art-therapy'         => 'What is Art Therapy?',
    'what-can-jess-offer'         => 'What Can Jess Offer?',
    'what-else-do-i-need-to-know' => 'What Else Do I Need to Know?',
    'artist'                      => 'Artist Statement',
    'artwork'                     => 'Artwork',
    'community'                   => 'Community',
    'overview'                    => 'Community Overview',
    'starling-project'            => 'The Starling Project',
    'the-plot-stanmer'            => 'The Plot Stanmer',
    'blog'                        => 'Blog',
    'articles'                    => 'Articles',
    'contact'                     => 'Contact',
];

// Pages that already have DB entries
$db_pages = [];
foreach (get_all_pages() as $p) {
    $db_pages[$p['slug']] = $p['updated_at'];
}

admin_header('Pages', 'pages');
admin_sidebar('pages');
?>
<div class="admin-main">
  <div class="topbar"><h1>Pages</h1></div>
  <div class="page-body">
    <div class="card">
      <div class="card-header">
        <span class="card-title">All Pages</span>
        <span style="font-size:.8rem;color:#787870;">Click Edit to modify a page's editable content sections.</span>
      </div>
      <table>
        <thead><tr><th>Page</th><th>Slug</th><th>Last Updated</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($known_pages as $slug => $label): ?>
          <tr>
            <td><?= h($label) ?></td>
            <td><code style="font-size:.78rem;background:#f5f5f3;padding:.15rem .4rem;border-radius:4px;"><?= h($slug) ?></code></td>
            <td><?= isset($db_pages[$slug]) ? h(fmt_date($db_pages[$slug], 'd M Y H:i')) : '<span style="color:#aaa">Not edited</span>' ?></td>
            <td>
              <a href="/admin/page-edit.php?slug=<?= urlencode($slug) ?>" class="btn btn-primary btn-sm">Edit Content</a>
              <a href="/admin/seo.php?slug=<?= urlencode($slug) ?>" class="btn btn-secondary btn-sm">SEO</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php admin_footer(); ?>
