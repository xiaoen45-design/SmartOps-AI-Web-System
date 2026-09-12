<?php
require_once __DIR__ . '/../admin_auth.php';
require_admin();

function csv_clean($value): string {
    return (string)($value ?? '');
}

function emit_csv(string $filename, array $headers, array $rows): void {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    $out = fopen('php://output', 'w');
    fputcsv($out, $headers);
    foreach ($rows as $row) {
        $line = [];
        foreach ($headers as $h) $line[] = csv_clean($row[$h] ?? '');
        fputcsv($out, $line);
    }
    fclose($out);
    exit;
}

function empty_csv(string $filename, array $headers): void {
    emit_csv($filename, $headers, []);
}
