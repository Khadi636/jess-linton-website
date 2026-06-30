<?php
/**
 * Generate (or retrieve) a per-session CSRF token.
 */
function csrf_token(): string {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF input field.
 */
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Verify the submitted token. Returns false on mismatch.
 */
function csrf_check(): bool {
    $submitted = $_POST['csrf_token'] ?? '';
    $expected  = $_SESSION['csrf_token'] ?? '';
    return $expected !== '' && hash_equals($expected, $submitted);
}

/**
 * Abort with 403 if CSRF token invalid.
 */
function csrf_verify(): void {
    if (!csrf_check()) {
        http_response_code(403);
        die('Invalid security token. Please go back and try again.');
    }
}
