<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('SMARTOPS_DEMO_SESSION');
    session_start();
}
if (!defined('SMARTOPS_DEMO_RUNTIME')) define('SMARTOPS_DEMO_RUNTIME', true);
date_default_timezone_set('Asia/Kuala_Lumpur');

$DB_HOST = getenv('SMARTOPS_DB_HOST') ?: 'localhost';
$DB_USER = getenv('SMARTOPS_DB_USER') ?: 'root';
$DB_PASS = getenv('SMARTOPS_DB_PASSWORD');
$DB_PASS = $DB_PASS === false ? '' : $DB_PASS;
$DB_CHARSET = 'utf8mb4';

require_once __DIR__ . '/demo_bootstrap.php';
$DB_NAME = smartops_demo_database_name();
smartops_ensure_demo_database($DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_CHARSET);

function smartstay_pdo(): PDO {
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_CHARSET;
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $pdo->exec("SET time_zone = '+08:00'");
    return $pdo;
}
