<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';

// Already logged in — go straight to dashboard
if (is_admin_logged_in()) {
    header('Location: /admin/index.php');
    exit;
}

$error   = '';
$timeout = !empty($_GET['timeout']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter your username and password.';
    } else {
        try {
            $db   = get_db();
            $stmt = $db->prepare('SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Regenerate session ID on login (session fixation protection)
                session_regenerate_id(true);
                $_SESSION['admin_id']       = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['last_activity']  = time();

                // Update last_login
                $db->prepare('UPDATE users SET last_login = NOW() WHERE id = ?')
                   ->execute([$user['id']]);

                header('Location: /admin/index.php');
                exit;
            } else {
                // Artificial delay to slow brute force
                sleep(1);
                $error = 'Incorrect username or password.';
            }
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            $error = 'A database error occurred. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Jess Linton</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Fraunces:ital,opsz,wght@1,9..144,200&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Inter, sans-serif; background: #1E3327; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .card { background: #fff; border-radius: 12px; padding: 2.5rem; width: 100%; max-width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,.35); }
    .brand { font-family: Fraunces, Georgia, serif; font-style: italic; font-weight: 200; font-size: 1.9rem; color: #2C4A38; margin-bottom: .2rem; }
    .brand-sub { font-size: .7rem; font-weight: 600; letter-spacing: .13em; text-transform: uppercase; color: #787870; margin-bottom: 2rem; }
    label { display: block; font-size: .78rem; font-weight: 600; margin-bottom: .35rem; }
    input { width: 100%; padding: .65rem .85rem; border: 1px solid #E2DFDA; border-radius: 7px; font-family: inherit; font-size: .88rem; margin-bottom: 1rem; transition: border-color .15s; }
    input:focus { outline: none; border-color: #2C4A38; box-shadow: 0 0 0 3px rgba(44,74,56,.1); }
    button { width: 100%; padding: .75rem; background: #2C4A38; color: #fff; border: none; border-radius: 7px; font-family: inherit; font-size: .88rem; font-weight: 600; cursor: pointer; letter-spacing: .03em; transition: background .15s; }
    button:hover { background: #3D6350; }
    .alert { padding: .7rem .9rem; border-radius: 7px; font-size: .82rem; margin-bottom: 1rem; }
    .alert-error   { background: #fee2e2; color: #b91c1c; }
    .alert-warning { background: #fef3c7; color: #92400e; }
  </style>
</head>
<body>
  <div class="card">
    <div class="brand">Jess Linton</div>
    <div class="brand-sub">Admin Panel</div>

    <?php if ($timeout): ?>
      <div class="alert alert-warning">Session expired. Please log in again.</div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" action="/admin/login.php" novalidate>
      <?= csrf_field() ?>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" autocomplete="username"
             value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password" required>
      <button type="submit">Log In</button>
    </form>
  </div>
</body>
</html>
