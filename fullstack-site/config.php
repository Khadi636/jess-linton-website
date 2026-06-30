<?php
// ─── Database ────────────────────────────────────────────────────────────────
define('DB_HOST',    'localhost');
define('DB_NAME',    'jess_linton');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

// ─── Site ────────────────────────────────────────────────────────────────────
define('SITE_NAME', 'Jess Linton');
define('SITE_URL',  'http://localhost:8080');  // no trailing slash

// ─── Uploads ─────────────────────────────────────────────────────────────────
define('UPLOAD_PATH', __DIR__ . '/public/uploads/');
define('UPLOAD_URL',  SITE_URL . '/public/uploads/');
define('MAX_UPLOAD_BYTES',   5 * 1024 * 1024); // 5 MB
define('ALLOWED_MIME_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

// ─── Session ─────────────────────────────────────────────────────────────────
define('SESSION_LIFETIME', 1800); // 30 minutes

// ─── Environment — set to false in production ─────────────────────────────────
define('DEV_MODE', true);

if (DEV_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}
