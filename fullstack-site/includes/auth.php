<?php
/**
 * Redirect to admin login if the session has no authenticated admin.
 */
function require_admin(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
    // Sliding expiry: reset on activity
    if (!empty($_SESSION['last_activity'])
        && (time() - $_SESSION['last_activity']) > SESSION_LIFETIME) {
        session_unset();
        session_destroy();
        header('Location: /admin/login.php?timeout=1');
        exit;
    }
    $_SESSION['last_activity'] = time();
}

function is_admin_logged_in(): bool {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return !empty($_SESSION['admin_id']);
}

function current_admin_name(): string {
    return htmlspecialchars($_SESSION['admin_username'] ?? 'Admin', ENT_QUOTES, 'UTF-8');
}
