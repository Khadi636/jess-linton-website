<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

$success = '';
$error   = '';

// Handle inline save of a single row via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $slug = preg_replace('/[^a-z0-9\-]/', '', $_POST['page_slug'] ?? '');
    $title = trim($_POST['seo_title'] ?? '');
    $desc  = trim($_POST['meta_description'] ?? '');
    if ($slug) {
        if (save_seo($slug, $title, $desc)) {
            $success = 'SEO settings saved for: ' . $slug;
        } else {
            $error = 'Failed to save.';
        }
    }
}

// Focused edit mode: ?slug=about
$edit_slug = preg_replace('/[^a-z0-9\-]/', '', $_GET['slug'] ?? '');

$all_pages = [
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

// Load existing DB seo rows
$existing = [];
foreach (get_all_seo() as $row) {
    $existing[$row['page_slug']] = $row;
}

admin_header('SEO Settings', 'seo');
admin_sidebar('seo');
?>
<div class="admin-main">
  <div class="topbar"><h1>SEO Settings</h1></div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

    <p style="font-size:.83rem;color:#787870;margin-bottom:1.25rem;">
      Set the &lt;title&gt; and meta description for each page. Leave blank to use the built-in defaults.
    </p>

    <?php foreach ($all_pages as $slug => $label): ?>
    <?php
      $row = $existing[$slug] ?? [];
      $open = ($edit_slug === $slug);
    ?>
    <div class="card" style="margin-bottom:1rem;">
      <div class="card-header" style="cursor:pointer;" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'block':'none'">
        <span class="card-title"><?= h($label) ?></span>
        <div style="display:flex;align-items:center;gap:.75rem;">
          <?php if (!empty($row['title'])): ?>
            <span class="badge badge-green">Configured</span>
          <?php else: ?>
            <span class="badge badge-grey">Default</span>
          <?php endif; ?>
          <span style="font-size:.8rem;color:#787870;">↕ toggle</span>
        </div>
      </div>
      <div style="<?= $open ? '' : 'display:none;' ?>padding-top:.5rem;">
        <form method="POST" action="/admin/seo.php">
          <?= csrf_field() ?>
          <input type="hidden" name="page_slug" value="<?= h($slug) ?>">
          <div class="form-group">
            <label>Page Title &lt;title&gt;</label>
            <input type="text" name="seo_title" value="<?= h($row['title'] ?? '') ?>"
                   placeholder="e.g. About — Jess Linton" maxlength="70">
            <div class="form-hint">Recommended: 50–70 characters.</div>
          </div>
          <div class="form-group">
            <label>Meta Description</label>
            <textarea name="meta_description" style="min-height:70px;" maxlength="160"
                      placeholder="Shown in Google search results..."><?= h($row['meta_description'] ?? '') ?></textarea>
            <div class="form-hint">Recommended: 120–160 characters.</div>
          </div>
          <button type="submit" class="btn btn-primary btn-sm">Save</button>
        </form>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php admin_footer(); ?>
