<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

/* SmartStay shared PHP + MySQL configuration.
   Every admin and technician page uses this single database connection.
   XAMPP default: user=root, password empty. */
$DB_HOST = 'localhost';
$DB_NAME = 'smartstay_php';
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';

function smartstay_pdo(): PDO {
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_CHARSET;
    static $pdo = null;

    if ($pdo instanceof PDO) return $pdo;

    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    // Use Malaysia time consistently for real-time assignment and SLA timestamps.
    $pdo->exec("SET time_zone = '+08:00'");

    return $pdo;
}
