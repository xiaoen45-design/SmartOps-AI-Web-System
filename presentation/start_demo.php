<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/presentation_mode.php';

$settings = require __DIR__ . '/settings.php';
$slideCount = max(1, (int)($settings['slide_count'] ?? 1));
$defaultResume = max(1, min($slideCount, (int)($settings['resume_slide'] ?? 1)));
$resumeSlide = (int)($_GET['resume'] ?? $defaultResume);
$resumeSlide = max(1, min($slideCount, $resumeSlide));

presentation_mode_start($resumeSlide);

// Keep the existing Admin login/authentication rules. If already signed in,
// this opens the dashboard directly; otherwise the normal login page appears.
if (!empty($_SESSION['admin_email'])) {
    redirect_to(app_url('admin_portal/overview/dashboard.php'));
}

redirect_to(app_url('admin_portal/login.php'));
