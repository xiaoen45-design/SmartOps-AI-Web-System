<?php
require_once __DIR__ . '/../includes/helpers.php';

function current_admin_email(): string {
    return (string)($_SESSION['admin_email'] ?? 'admin@smartstay.com');
}

function current_admin_name(): string {
    return (string)($_SESSION['admin_name'] ?? 'SmartOps Admin');
}

function require_admin(): void {
    if (defined('SMARTOPS_DEMO_RUNTIME') && SMARTOPS_DEMO_RUNTIME) {
        $_SESSION['admin_email'] = 'demo.admin@smartops.local';
        $_SESSION['admin_name'] = 'SmartOps Demo Admin';
    } elseif (empty($_SESSION['admin_email'])) {
        redirect_to(app_url('admin_portal/login.php'));
    }
    smartops_sync_pending_ai_cases();
}

function admin_access_code(): string {
    $configuredCode = trim((string)(getenv('SMARTOPS_ADMIN_ACCESS_CODE') ?: ''));
    // Public-repository safe default: when no code is configured, signup/reset
    // access remains unavailable instead of exposing a reusable secret.
    return $configuredCode !== '' ? $configuredCode : bin2hex(random_bytes(32));
}
