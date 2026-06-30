<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

$slug = preg_replace('/[^a-z0-9\-]/', '', $_GET['slug'] ?? '');
if (!$slug) {
    header('Location: /admin/pages.php');
    exit;
}

// Define editable fields per page
$field_config = [
    'home' => [
        ['key' => 'hero_title',     'label' => 'Hero Title',       'type' => 'text'],
        ['key' => 'hero_subtitle',  'label' => 'Hero Subtitle',    'type' => 'textarea'],
        ['key' => 'about_heading',  'label' => 'About Heading',    'type' => 'text'],
        ['key' => 'about_text',     'label' => 'About Body Text',  'type' => 'textarea'],
    ],
    'about' => [
        ['key' => 'page_heading',   'label' => 'Page Heading',     'type' => 'text'],
        ['key' => 'bio_text',       'label' => 'Biography Text',   'type' => 'textarea'],
        ['key' => 'expertise_text', 'label' => 'Expertise Section','type' => 'textarea'],
    ],
    'art-therapy' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
    ],
    'what-is-art-therapy' => [
        ['key' => 'page_heading',   'label' => 'Page Heading',     'type' => 'text'],
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
        ['key' => 'body_content',   'label' => 'Body Content',     'type' => 'textarea'],
    ],
    'what-can-jess-offer' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
    ],
    'what-else-do-i-need-to-know' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
        ['key' => 'fees_text',      'label' => 'Fees & Sessions',  'type' => 'textarea'],
    ],
    'artist' => [
        ['key' => 'statement',      'label' => 'Artist Statement', 'type' => 'textarea'],
    ],
    'community' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
    ],
    'overview' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
    ],
    'starling-project' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
        ['key' => 'body_content',   'label' => 'Body Content',     'type' => 'textarea'],
    ],
    'the-plot-stanmer' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
        ['key' => 'body_content',   'label' => 'Body Content',     'type' => 'textarea'],
    ],
    'articles' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
    ],
    'contact' => [
        ['key' => 'intro_text',     'label' => 'Introduction',     'type' => 'textarea'],
        ['key' => 'referral_text',  'label' => 'Referral Text',    'type' => 'textarea'],
    ],
];

$fields  = $field_config[$slug] ?? [];
$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $content = [];
    foreach ($fields as $f) {
        $content[$f['key']] = trim($_POST[$f['key']] ?? '');
    }
    if (save_page_content($slug, $content)) {
        $success = true;
    } else {
        $error = 'Failed to save. Please try again.';
    }
}

$current = get_page_content($slug);
$page_labels = [
    'home' => 'Home', 'about' => 'About', 'art-therapy' => 'Art Therapy',
    'what-is-art-therapy' => 'What is Art Therapy?',
    'what-can-jess-offer' => 'What Can Jess Offer?',
    'what-else-do-i-need-to-know' => 'What Else Do I Need to Know?',
    'artist' => 'Artist Statement', 'artwork' => 'Artwork',
    'community' => 'Community', 'overview' => 'Community Overview',
    'starling-project' => 'The Starling Project',
    'the-plot-stanmer' => 'The Plot Stanmer',
    'blog' => 'Blog', 'articles' => 'Articles', 'contact' => 'Contact',
];
$page_label = $page_labels[$slug] ?? $slug;

admin_header('Edit: ' . $page_label, 'pages');
admin_sidebar('pages');
?>
<div class="admin-main">
  <div class="topbar">
    <h1>Edit Page: <?= h($page_label) ?></h1>
    <div class="topbar-actions">
      <a href="/admin/pages.php" class="btn btn-secondary btn-sm">← Back to Pages</a>
    </div>
  </div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success">Page content saved successfully.</div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

    <?php if (empty($fields)): ?>
      <div class="card">
        <p style="color:#787870;">This page does not have configurable content fields yet. The structural HTML is managed directly in the PHP template.</p>
      </div>
    <?php else: ?>
    <div class="card">
      <form method="POST" action="/admin/page-edit.php?slug=<?= urlencode($slug) ?>">
        <?= csrf_field() ?>
        <?php foreach ($fields as $f): ?>
        <div class="form-group">
          <label for="<?= h($f['key']) ?>"><?= h($f['label']) ?></label>
          <?php if ($f['type'] === 'textarea'): ?>
            <textarea id="<?= h($f['key']) ?>" name="<?= h($f['key']) ?>"><?= h($current[$f['key']] ?? '') ?></textarea>
          <?php else: ?>
            <input type="text" id="<?= h($f['key']) ?>" name="<?= h($f['key']) ?>"
                   value="<?= h($current[$f['key']] ?? '') ?>">
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="/admin/pages.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php admin_footer(); ?>
