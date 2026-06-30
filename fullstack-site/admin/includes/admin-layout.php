<?php
// Shared admin layout helper.
// Call admin_header($title) and admin_footer() in admin pages.

function admin_header(string $title, string $active = ''): void {
    global $_admin_active;
    $_admin_active = $active;
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?> — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Fraunces:ital,opsz,wght@1,9..144,200&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --green:      #2C4A38;
      --green-dark: #1E3327;
      --green-mid:  #3D6350;
      --sand:       #C4915A;
      --bg:         #F8F5F0;
      --surface:    #fff;
      --ink:        #131310;
      --ink-3:      #787870;
      --border:     #E2DFDA;
      --radius:     8px;
      --shadow:     0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
    }
    body { font-family: Inter, sans-serif; font-size: .9rem; background: var(--bg); color: var(--ink); display: flex; min-height: 100vh; }
    a { color: var(--green); text-decoration: none; }
    a:hover { color: var(--green-mid); }

    /* Sidebar */
    .sidebar {
      width: 220px; flex-shrink: 0;
      background: var(--green-dark); color: rgba(255,255,255,.8);
      display: flex; flex-direction: column;
      position: fixed; top: 0; left: 0; height: 100vh;
      overflow-y: auto;
    }
    .sidebar-brand {
      padding: 1.5rem 1.25rem 1rem;
      font-family: Fraunces, Georgia, serif;
      font-size: 1.2rem; font-style: italic; font-weight: 200;
      color: #fff;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .sidebar-brand span { display: block; font-family: Inter, sans-serif; font-size: .68rem; font-style: normal; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.4); margin-top: .15rem; }
    .sidebar-nav { padding: 1rem 0; flex: 1; }
    .sidebar-nav a {
      display: flex; align-items: center; gap: .6rem;
      padding: .65rem 1.25rem; font-size: .82rem; font-weight: 500;
      color: rgba(255,255,255,.7); transition: background .15s, color .15s;
    }
    .sidebar-nav a:hover, .sidebar-nav a.active {
      background: rgba(255,255,255,.08); color: #fff;
    }
    .sidebar-nav a.active { border-left: 3px solid var(--sand); }
    .sidebar-nav .icon { font-size: 1rem; opacity: .7; }
    .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,.08); font-size: .75rem; color: rgba(255,255,255,.4); }
    .sidebar-footer a { color: rgba(255,255,255,.5); }

    /* Main */
    .admin-main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    .topbar {
      background: var(--surface); border-bottom: 1px solid var(--border);
      padding: .85rem 2rem; display: flex; align-items: center;
      justify-content: space-between; position: sticky; top: 0; z-index: 10;
    }
    .topbar h1 { font-size: 1rem; font-weight: 600; }
    .topbar-actions { display: flex; align-items: center; gap: 1rem; }
    .topbar-actions a { font-size: .8rem; color: var(--ink-3); }

    .page-body { padding: 2rem; flex: 1; }

    /* Cards */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; box-shadow: var(--shadow); }
    .card + .card { margin-top: 1.5rem; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
    .card-title { font-size: .95rem; font-weight: 600; }

    /* Stats grid */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; box-shadow: var(--shadow); }
    .stat-card .label { font-size: .75rem; text-transform: uppercase; letter-spacing: .08em; color: var(--ink-3); margin-bottom: .4rem; }
    .stat-card .value { font-size: 2rem; font-weight: 600; color: var(--green); }

    /* Table */
    table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    thead th { text-align: left; padding: .6rem .75rem; font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--ink-3); border-bottom: 2px solid var(--border); }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    tbody tr:hover { background: #faf9f7; }
    tbody td { padding: .7rem .75rem; vertical-align: middle; }
    .badge { display: inline-block; padding: .2rem .55rem; border-radius: 99px; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
    .badge-green { background: #d4e4db; color: var(--green); }
    .badge-sand  { background: #f5ebe0; color: #a07040; }
    .badge-grey  { background: #eee; color: #666; }

    /* Forms */
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: .8rem; font-weight: 600; margin-bottom: .35rem; color: var(--ink); }
    .form-group input[type=text],
    .form-group input[type=email],
    .form-group input[type=password],
    .form-group input[type=url],
    .form-group select,
    .form-group textarea {
      width: 100%; padding: .6rem .8rem;
      border: 1px solid var(--border); border-radius: var(--radius);
      font-family: Inter, sans-serif; font-size: .88rem;
      background: var(--surface); color: var(--ink);
      transition: border-color .15s;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none; border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(44,74,56,.1);
    }
    .form-group textarea { min-height: 180px; resize: vertical; line-height: 1.6; }
    .form-hint { font-size: .75rem; color: var(--ink-3); margin-top: .3rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    /* Buttons */
    .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.1rem; border-radius: var(--radius); font-size: .82rem; font-weight: 600; cursor: pointer; border: none; transition: background .15s, transform .1s; text-decoration: none; }
    .btn:active { transform: translateY(1px); }
    .btn-primary { background: var(--green); color: #fff; }
    .btn-primary:hover { background: var(--green-mid); color: #fff; }
    .btn-secondary { background: transparent; color: var(--ink); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--bg); }
    .btn-danger { background: #fee2e2; color: #b91c1c; }
    .btn-danger:hover { background: #fecaca; }
    .btn-sm { padding: .3rem .7rem; font-size: .75rem; }

    /* Alert */
    .alert { padding: .75rem 1rem; border-radius: var(--radius); font-size: .85rem; margin-bottom: 1rem; }
    .alert-success { background: #d4e4db; color: var(--green); }
    .alert-error   { background: #fee2e2; color: #b91c1c; }

    /* Image preview */
    .img-preview { max-width: 200px; max-height: 150px; border-radius: var(--radius); border: 1px solid var(--border); object-fit: cover; margin-top: .5rem; }

    /* Gallery grid in admin */
    .gallery-admin-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
    .gallery-admin-item { position: relative; border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); }
    .gallery-admin-item img { width: 100%; height: 120px; object-fit: cover; display: block; }
    .gallery-admin-item-actions { padding: .5rem; display: flex; gap: .4rem; background: var(--surface); }

    /* Login page */
    .login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--green-dark); }
    .login-card { background: var(--surface); border-radius: 12px; padding: 2.5rem; width: 100%; max-width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,.3); }
    .login-brand { font-family: Fraunces, Georgia, serif; font-style: italic; font-weight: 200; font-size: 1.8rem; color: var(--green); margin-bottom: .25rem; }
    .login-brand span { display: block; font-family: Inter, sans-serif; font-size: .72rem; font-style: normal; font-weight: 500; letter-spacing: .12em; text-transform: uppercase; color: var(--ink-3); }
  </style>
</head>
<body>
<?php
}

function admin_sidebar(string $active): void {
    $links = [
        ['href' => '/admin/index.php',       'label' => 'Dashboard',   'icon' => '⊞', 'key' => 'dashboard'],
        ['href' => '/admin/pages.php',        'label' => 'Pages',       'icon' => '☰', 'key' => 'pages'],
        ['href' => '/admin/blog.php',         'label' => 'Blog Posts',  'icon' => '✏', 'key' => 'blog'],
        ['href' => '/admin/gallery.php',      'label' => 'Gallery',     'icon' => '◫', 'key' => 'gallery'],
        ['href' => '/admin/contact.php',      'label' => 'Contact',     'icon' => '✉', 'key' => 'contact'],
        ['href' => '/admin/seo.php',          'label' => 'SEO',         'icon' => '◎', 'key' => 'seo'],
    ];
    ?>
<div class="sidebar">
  <div class="sidebar-brand">Jess Linton <span>Admin Panel</span></div>
  <nav class="sidebar-nav">
    <?php foreach ($links as $l): ?>
    <a href="<?= $l['href'] ?>" class="<?= $active === $l['key'] ? 'active' : '' ?>">
      <span class="icon"><?= $l['icon'] ?></span> <?= $l['label'] ?>
    </a>
    <?php endforeach; ?>
    <a href="/" target="_blank"><span class="icon">↗</span> View Site</a>
  </nav>
  <div class="sidebar-footer">
    Logged in as <?= current_admin_name() ?><br>
    <a href="/admin/logout.php">Log out</a>
  </div>
</div>
<?php
}

function admin_footer(): void {
    ?>
</body>
</html>
<?php
}
