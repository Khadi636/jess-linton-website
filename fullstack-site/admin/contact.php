<?php
session_start();
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once __DIR__ . '/includes/admin-layout.php';
require_admin();

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $data = [
        'email'          => trim($_POST['email']          ?? ''),
        'phone'          => trim($_POST['phone']          ?? ''),
        'address'        => trim($_POST['address']        ?? ''),
        'hcpc_number'    => trim($_POST['hcpc_number']    ?? ''),
        'dbs_number'     => trim($_POST['dbs_number']     ?? ''),
        'copyright_year' => trim($_POST['copyright_year'] ?? (string)date('Y')),
        'session_fee'    => trim($_POST['session_fee']    ?? ''),
        'location_text'  => trim($_POST['location_text']  ?? ''),
    ];
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $success = save_contact_settings($data);
        if (!$success) $error = 'Failed to save settings.';
    }
}

$s = get_contact_settings();

admin_header('Contact Settings', 'contact');
admin_sidebar('contact');
?>
<div class="admin-main">
  <div class="topbar"><h1>Contact Settings</h1></div>
  <div class="page-body">
    <?php if ($success): ?><div class="alert alert-success">Settings saved.</div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>
    <div class="card">
      <form method="POST" action="/admin/contact.php">
        <?= csrf_field() ?>

        <div class="form-row">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= h($s['email'] ?? 'jess.a.linton@gmail.com') ?>" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?= h($s['phone'] ?? '+44 (0) 7834 686838') ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="address">Address / Location</label>
          <input type="text" id="address" name="address" value="<?= h($s['address'] ?? 'Sussex, UK') ?>">
        </div>

        <div class="form-group">
          <label for="location_text">Location Description</label>
          <textarea id="location_text" name="location_text" style="min-height:80px;"><?= h($s['location_text'] ?? '') ?></textarea>
          <div class="form-hint">Longer description of where sessions take place.</div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="hcpc_number">HCPC Registration Number</label>
            <input type="text" id="hcpc_number" name="hcpc_number" value="<?= h($s['hcpc_number'] ?? 'AS14954') ?>">
          </div>
          <div class="form-group">
            <label for="dbs_number">DBS Certificate Number</label>
            <input type="text" id="dbs_number" name="dbs_number" value="<?= h($s['dbs_number'] ?? '004178606999') ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="session_fee">Session Fee</label>
            <input type="text" id="session_fee" name="session_fee" value="<?= h($s['session_fee'] ?? '£35–£60 per hour') ?>">
          </div>
          <div class="form-group">
            <label for="copyright_year">Copyright Year</label>
            <input type="text" id="copyright_year" name="copyright_year" value="<?= h($s['copyright_year'] ?? date('Y')) ?>">
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
      </form>
    </div>
  </div>
</div>
<?php admin_footer(); ?>
