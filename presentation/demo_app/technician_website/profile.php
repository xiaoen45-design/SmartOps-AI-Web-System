<?php
require_once __DIR__ . '/auth.php';
require_technician();
header('Location: ' . app_url('technician_website/settings.php#technicianProfile'));
exit;
