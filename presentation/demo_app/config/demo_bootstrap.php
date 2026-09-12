<?php
/**
 * Isolated SmartOps product-demo database.
 *
 * Data policy:
 * - The demo never reads from or writes to the production database.
 * - Every browser session receives a separate MySQL database.
 * - The database is rebuilt from the bundled synthetic SQL seed.
 * - Operational dates are automatically rebased so the charts always show
 *   a populated rolling seven-day window.
 * - The guided Room 305 case is always placed on the current date.
 */

function smartops_demo_database_name(): string {
    $sessionId = session_id();
    if ($sessionId === '') {
        throw new RuntimeException('The SmartOps demo session is unavailable.');
    }
    return 'smartops_demo_' . substr(hash('sha256', $sessionId), 0, 12);
}

function smartops_expected_snapshot_version(): string {
    $versionFile = __DIR__ . '/snapshot_version.txt';
    $version = is_file($versionFile) ? trim((string) file_get_contents($versionFile)) : '';
    if ($version === '') {
        throw new RuntimeException('The embedded demo snapshot version is missing.');
    }
    return $version;
}

function smartops_demo_safe_database_name(string $database): string {
    $safe = preg_replace('/[^a-zA-Z0-9_]/', '', $database);
    if (!is_string($safe) || $safe === '' || $safe !== $database) {
        throw new RuntimeException('Invalid embedded demo database name.');
    }
    return $safe;
}

function smartops_demo_identifier(string $identifier): string {
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $identifier)) {
        throw new RuntimeException('Invalid SQL identifier in demo bootstrap.');
    }
    return '`' . $identifier . '`';
}

function smartops_demo_open_pdo(
    string $host,
    ?string $database,
    string $user,
    string $password,
    string $charset = 'utf8mb4'
): PDO {
    $dsn = "mysql:host={$host};charset={$charset}";
    if ($database !== null && $database !== '') {
        $database = smartops_demo_safe_database_name($database);
        $dsn .= ";dbname={$database}";
    }

    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 5,
    ]);
    $pdo->exec("SET time_zone = '+08:00'");
    return $pdo;
}

function smartops_demo_import_sql(
    string $host,
    string $database,
    string $user,
    string $password,
    string $sqlFile
): void {
    if (!extension_loaded('mysqli')) {
        throw new RuntimeException('The mysqli PHP extension is required.');
    }
    if (!is_file($sqlFile) || !is_readable($sqlFile)) {
        throw new RuntimeException('The embedded demo SQL snapshot is missing.');
    }

    $database = smartops_demo_safe_database_name($database);
    mysqli_report(MYSQLI_REPORT_OFF);
    $mysqli = @new mysqli($host, $user, $password);
    if ($mysqli->connect_errno) {
        throw new RuntimeException('Unable to connect to local MySQL: ' . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4');

    $sql = (string) file_get_contents($sqlFile);
    if (trim($sql) === '') {
        $mysqli->close();
        throw new RuntimeException('The embedded demo SQL snapshot is empty.');
    }

    // The bundled seed uses smartstay_php only as a placeholder. Replace it
    // with the isolated database generated for this browser session.
    $sql = str_replace('`smartstay_php`', '`' . $database . '`', $sql);
    $sql = str_replace('smartstay_php', $database, $sql);

    if (!$mysqli->multi_query($sql)) {
        $message = $mysqli->error ?: 'Unknown MySQL import error';
        $mysqli->close();
        throw new RuntimeException('Embedded demo database import failed: ' . $message);
    }

    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
        if (!$mysqli->more_results()) {
            break;
        }
    } while ($mysqli->next_result());

    if ($mysqli->errno) {
        $message = $mysqli->error;
        $mysqli->close();
        throw new RuntimeException('Embedded demo database import failed: ' . $message);
    }
    $mysqli->close();
}

/**
 * Operational datetime fields that belong to the synthetic demo timeline.
 * Account creation timestamps are intentionally excluded.
 *
 * @return array<string, list<string>>
 */
function smartops_demo_operational_date_columns(): array {
    return [
        'smart_maintenance_tickets' => [
            'guest_start_notified_at',
            'created_at',
            'technician_assigned_timestamp',
            'completed_date',
        ],
        'hitl_cases' => [
            'created_at',
        ],
        'workforce_cases' => [
            'assigned_at',
            'accepted_at',
            'started_at',
            'completed_at',
            'case_created_at',
            'support_requested_at',
            'released_at',
            'transfer_requested_at',
            'parts_requested_at',
            'parts_ordered_at',
            'parts_ready_at',
            'outsourced_at',
        ],
        'technician_tasks' => [
            'assigned_time',
            'accepted_time',
            'started_time',
            'completed_time',
            'case_created_at',
            'support_requested_at',
            'released_at',
        ],
        'task_assignment_history' => [
            'assigned_at',
            'accepted_at',
            'started_at',
            'ended_at',
            'created_at',
        ],
        'admin_notifications' => [
            'created_at',
            'read_at',
        ],
    ];
}

function smartops_demo_table_has_column(PDO $pdo, string $database, string $table, string $column): bool {
    $statement = $pdo->prepare(
        'SELECT COUNT(*) FROM information_schema.COLUMNS '
        . 'WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_NAME=?'
    );
    $statement->execute([$database, $table, $column]);
    return (int) $statement->fetchColumn() > 0;
}

/**
 * Shift selected datetime columns by a whole number of days.
 *
 * @param list<string> $columns
 * @param list<mixed> $whereParams
 */
function smartops_demo_shift_dates(
    PDO $pdo,
    string $database,
    string $table,
    array $columns,
    int $days,
    string $whereSql = '',
    array $whereParams = []
): void {
    if ($days === 0 || $columns === []) {
        return;
    }

    $assignments = [];
    foreach ($columns as $column) {
        if (!smartops_demo_table_has_column($pdo, $database, $table, $column)) {
            continue;
        }
        $quoted = smartops_demo_identifier($column);
        $assignments[] = "{$quoted}=CASE "
            . "WHEN {$quoted} IS NULL OR CAST({$quoted} AS CHAR) LIKE '0000-00-00%' THEN NULL "
            . "ELSE DATE_ADD({$quoted}, INTERVAL {$days} DAY) END";
    }

    if ($assignments === []) {
        return;
    }

    $sql = 'UPDATE ' . smartops_demo_identifier($table)
        . ' SET ' . implode(', ', $assignments)
        . ($whereSql !== '' ? ' WHERE ' . $whereSql : '');
    $statement = $pdo->prepare($sql);
    $statement->execute($whereParams);
}

/**
 * Older MySQL/MariaDB configurations may convert an empty DATETIME string in
 * the bundled seed into 0000-00-00 00:00:00. Strict SQL mode then rejects
 * DATE_ADD() against that legacy zero date. Convert those placeholders to
 * proper NULL values before calculating the rolling demo timeline.
 */
function smartops_demo_normalize_invalid_dates(
    PDO $pdo,
    string $database
): void {
    foreach (smartops_demo_operational_date_columns() as $table => $columns) {
        foreach ($columns as $column) {
            if (!smartops_demo_table_has_column($pdo, $database, $table, $column)) {
                continue;
            }

            $quotedTable = smartops_demo_identifier($table);
            $quotedColumn = smartops_demo_identifier($column);
            $pdo->exec(
                "UPDATE {$quotedTable} SET {$quotedColumn}=NULL "
                . "WHERE {$quotedColumn} IS NOT NULL "
                . "AND CAST({$quotedColumn} AS CHAR) LIKE '0000-00-00%'"
            );
        }
    }
}

function smartops_demo_days_between(string $fromDate, string $toDate): int {
    $timezone = new DateTimeZone('Asia/Kuala_Lumpur');
    $from = new DateTimeImmutable($fromDate . ' 00:00:00', $timezone);
    $to = new DateTimeImmutable($toDate . ' 00:00:00', $timezone);
    return (int) $from->diff($to)->format('%r%a');
}

/**
 * Keep the date portion of synthetic SOAI case IDs aligned with the rebased
 * complaint date. Foreign keys use ON UPDATE CASCADE, so the shared case ID
 * remains consistent across HITL, workforce, technician, and ticket tables.
 */
function smartops_demo_refresh_dated_case_ids(PDO $pdo): void {
    $rows = $pdo->query(
        "SELECT c.case_id, DATE(s.created_at) AS case_date "
        . "FROM cases c "
        . "INNER JOIN smart_maintenance_tickets s ON s.case_id=c.case_id "
        . "WHERE c.case_id REGEXP '^SOAI-[0-9]{8}-[0-9]{3}$' "
        . "ORDER BY c.id"
    )->fetchAll();

    $collisionCheck = $pdo->prepare('SELECT COUNT(*) FROM cases WHERE case_id=? AND case_id<>?');
    $updateMaster = $pdo->prepare('UPDATE cases SET case_id=? WHERE case_id=?');
    $updateNotifications = $pdo->prepare('UPDATE admin_notifications SET case_id=? WHERE case_id=?');

    foreach ($rows as $row) {
        $oldCaseId = trim((string) ($row['case_id'] ?? ''));
        $caseDate = trim((string) ($row['case_date'] ?? ''));
        if ($oldCaseId === '' || $caseDate === '') {
            continue;
        }
        if (!preg_match('/^SOAI-[0-9]{8}(-[0-9]{3})$/', $oldCaseId, $matches)) {
            continue;
        }

        $newCaseId = 'SOAI-' . str_replace('-', '', $caseDate) . $matches[1];
        if ($newCaseId === $oldCaseId) {
            continue;
        }

        $collisionCheck->execute([$newCaseId, $oldCaseId]);
        if ((int) $collisionCheck->fetchColumn() > 0) {
            throw new RuntimeException('Dynamic demo case ID collision: ' . $newCaseId);
        }

        $updateMaster->execute([$newCaseId, $oldCaseId]);
        $updateNotifications->execute([$newCaseId, $oldCaseId]);
    }
}


function smartops_demo_day_slots(string $baseDate, array $counts): array {
    $timezone = new DateTimeZone('Asia/Kuala_Lumpur');
    $days = [];
    for ($index = 0; $index < 7; $index += 1) {
        $days[] = (new DateTimeImmutable($baseDate . ' 09:00:00', $timezone))->modify(($index - 6) . ' day');
    }

    $timeSlots = ['08:20:00','09:45:00','11:10:00','12:35:00','14:05:00','15:30:00','16:55:00','18:20:00'];
    $slots = [];
    foreach ($counts as $dayIndex => $count) {
        for ($i = 0; $i < $count; $i += 1) {
            $time = $timeSlots[$i % count($timeSlots)];
            $slots[] = $days[$dayIndex]->format('Y-m-d') . ' ' . $time;
        }
    }
    return $slots;
}

function smartops_demo_weighted_counts(int $total, array $weights): array {
    $weights = array_values($weights);
    $weightTotal = array_sum($weights) ?: 1;
    $counts = array_fill(0, count($weights), 0);
    $remainders = [];
    $allocated = 0;

    foreach ($weights as $index => $weight) {
        $exact = ($total * $weight) / $weightTotal;
        $count = (int) floor($exact);
        $counts[$index] = $count;
        $allocated += $count;
        $remainders[$index] = $exact - $count;
    }

    while ($allocated < $total) {
        arsort($remainders);
        foreach (array_keys($remainders) as $index) {
            if ($allocated >= $total) {
                break;
            }
            $counts[$index] += 1;
            $allocated += 1;
            $remainders[$index] = 0;
        }
    }

    return $counts;
}

function smartops_demo_rebalance_demo_timeline(PDO $pdo, string $today): void {
    $allTickets = $pdo->query(
        "SELECT id, case_id, room_id, ticket_status, human_approval_required, escalation_required "
        . "FROM smart_maintenance_tickets ORDER BY created_at ASC, id ASC"
    )->fetchAll();

    if (!$allTickets) {
        return;
    }

    $room305CaseId = null;
    $otherTickets = [];
    foreach ($allTickets as $ticket) {
        if (($ticket['room_id'] ?? '') === 'Room 305' && $room305CaseId === null) {
            $room305CaseId = (string) $ticket['case_id'];
            continue;
        }
        $otherTickets[] = $ticket;
    }

    $otherCount = count($otherTickets);
    if ($otherCount > 0) {
        $complaintCounts = smartops_demo_weighted_counts($otherCount, [0.08, 0.16, 0.12, 0.20, 0.10, 0.21, 0.13]);
        $complaintSlots = smartops_demo_day_slots($today, $complaintCounts);
        $updateCreated = $pdo->prepare(
            "UPDATE smart_maintenance_tickets SET created_at=? WHERE case_id=?"
        );
        foreach ($otherTickets as $index => $ticket) {
            $slot = $complaintSlots[$index] ?? end($complaintSlots);
            $updateCreated->execute([$slot, $ticket['case_id']]);
        }
    }

    if ($room305CaseId) {
        $room305Created = $today . ' 10:13:00';
        $pdo->prepare("UPDATE smart_maintenance_tickets SET created_at=?, ticket_status='Pending Review', completed_date=NULL WHERE case_id=?")
            ->execute([$room305Created, $room305CaseId]);
        $pdo->prepare("UPDATE hitl_cases SET created_at=?, review_status='Pending Review' WHERE case_id=?")
            ->execute([$room305Created, $room305CaseId]);
        $pdo->prepare("UPDATE workforce_cases SET case_created_at=?, completed_at=NULL, work_stage='Pending Review', task_status='Pending Review' WHERE case_id=?")
            ->execute([$room305Created, $room305CaseId]);
        $pdo->prepare("UPDATE technician_tasks SET case_created_at=?, completed_time=NULL, task_status='Pending Review' WHERE case_id=?")
            ->execute([$room305Created, $room305CaseId]);
    }

    $candidateRows = $pdo->query(
        "SELECT case_id FROM smart_maintenance_tickets "
        . "WHERE COALESCE(room_id,'')<>'Room 305' "
        . "AND (COALESCE(human_approval_required,'')<>'yes' AND COALESCE(escalation_required,'')<>'yes') "
        . "ORDER BY created_at ASC, id ASC"
    )->fetchAll();
    $candidateCaseIds = array_map(fn($row) => (string) $row['case_id'], $candidateRows);

    $desiredCompleted = min(max(7, count($candidateCaseIds) >= 8 ? 8 : count($candidateCaseIds)), max(1, count($candidateCaseIds)));
    if ($desiredCompleted > 0) {
        $completionCounts = smartops_demo_weighted_counts($desiredCompleted, [0.10, 0.12, 0.09, 0.22, 0.13, 0.20, 0.14]);
        foreach ($completionCounts as $index => $value) {
            if ($value < 1) $completionCounts[$index] = 1;
        }
        $overflow = array_sum($completionCounts) - $desiredCompleted;
        for ($i = 6; $overflow > 0 && $i >= 0; $i -= 1) {
            while ($overflow > 0 && $completionCounts[$i] > 1) {
                $completionCounts[$i] -= 1;
                $overflow -= 1;
            }
        }

        $ticketCreatedLookup = [];
        $rows = $pdo->query("SELECT case_id, created_at FROM smart_maintenance_tickets WHERE COALESCE(room_id,'')<>'Room 305' ORDER BY created_at ASC, id ASC")->fetchAll();
        foreach ($rows as $row) {
            $ticketCreatedLookup[(string) $row['case_id']] = (string) $row['created_at'];
        }

        $completionDays = [];
        $timezone = new DateTimeZone('Asia/Kuala_Lumpur');
        for ($index = 0; $index < 7; $index += 1) {
            $completionDays[] = (new DateTimeImmutable($today . ' 17:40:00', $timezone))->modify(($index - 6) . ' day');
        }

        $selected = [];
        $pointer = 0;
        foreach ($completionCounts as $dayIndex => $countNeeded) {
            for ($count = 0; $count < $countNeeded; $count += 1) {
                while ($pointer < count($candidateCaseIds) && isset($selected[$candidateCaseIds[$pointer]])) {
                    $pointer += 1;
                }
                if ($pointer >= count($candidateCaseIds)) {
                    break;
                }
                $caseId = $candidateCaseIds[$pointer];
                $selected[$caseId] = $completionDays[$dayIndex]->format('Y-m-d H:i:s');
                $pointer += 1;
            }
        }

        $updateSmartCompleted = $pdo->prepare(
            "UPDATE smart_maintenance_tickets SET ticket_status='Completed', completed_date=?, guest_start_notified_at=COALESCE(guest_start_notified_at, created_at) WHERE case_id=?"
        );
        $updateWorkforceCompleted = $pdo->prepare(
            "UPDATE workforce_cases SET completed_at=?, work_stage='Completed', task_status='Completed' WHERE case_id=?"
        );
        $updateTaskCompleted = $pdo->prepare(
            "UPDATE technician_tasks SET completed_time=?, task_status='Completed' WHERE case_id=?"
        );
        $updateHistoryCompleted = $pdo->prepare(
            "UPDATE task_assignment_history SET ended_at=COALESCE(ended_at, ? ) WHERE case_id=?"
        );

        foreach ($selected as $caseId => $completedAt) {
            $createdAt = $ticketCreatedLookup[$caseId] ?? ($today . ' 09:30:00');
            if ($createdAt > $completedAt) {
                $createdAt = date('Y-m-d H:i:s', strtotime($completedAt . ' -2 hours'));
                $pdo->prepare("UPDATE smart_maintenance_tickets SET created_at=? WHERE case_id=?")->execute([$createdAt, $caseId]);
            }
            $updateSmartCompleted->execute([$completedAt, $caseId]);
            $updateWorkforceCompleted->execute([$completedAt, $caseId]);
            $updateTaskCompleted->execute([$completedAt, $caseId]);
            $updateHistoryCompleted->execute([$completedAt, $caseId]);
        }
    }
}

function smartops_demo_set_meta(PDO $pdo, string $key, string $value): void {
    $statement = $pdo->prepare(
        "INSERT INTO demo_meta (meta_key, meta_value, updated_at) VALUES (?, ?, NOW()) "
        . "ON DUPLICATE KEY UPDATE meta_value=VALUES(meta_value), updated_at=VALUES(updated_at)"
    );
    $statement->execute([$key, $value]);
}

/**
 * Move the fixed synthetic timeline into the current rolling seven-day window.
 * The newest normal seed date becomes today, and the Room 305 guided case is
 * explicitly anchored to today even when its original seed date is earlier.
 */
function smartops_demo_rebase_dates(
    string $host,
    string $database,
    string $user,
    string $password,
    string $charset = 'utf8mb4'
): void {
    $database = smartops_demo_safe_database_name($database);
    $pdo = smartops_demo_open_pdo($host, $database, $user, $password, $charset);
    $timezone = new DateTimeZone('Asia/Kuala_Lumpur');
    $today = (new DateTimeImmutable('today', $timezone))->format('Y-m-d');

    // Keep this bootstrap session permissive only long enough to read and
    // clean legacy zero-date values produced by some local XAMPP versions.
    $pdo->exec("SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");

    $pdo->beginTransaction();
    try {
        smartops_demo_normalize_invalid_dates($pdo, $database);

        $anchorDate = (string) $pdo->query(
            'SELECT MAX(DATE(created_at)) FROM smart_maintenance_tickets WHERE created_at IS NOT NULL'
        )->fetchColumn();
        if ($anchorDate === '') {
            throw new RuntimeException('The demo seed does not contain an operational anchor date.');
        }

        $globalShiftDays = smartops_demo_days_between($anchorDate, $today);
        foreach (smartops_demo_operational_date_columns() as $table => $columns) {
            smartops_demo_shift_dates($pdo, $database, $table, $columns, $globalShiftDays);
        }

        $roomStatement = $pdo->prepare(
            "SELECT case_id, DATE(created_at) AS case_date "
            . "FROM smart_maintenance_tickets "
            . "WHERE room_id='Room 305' AND created_at IS NOT NULL "
            . "ORDER BY created_at DESC, id DESC LIMIT 1"
        );
        $roomStatement->execute();
        $room305 = $roomStatement->fetch();
        $room305CaseId = trim((string) ($room305['case_id'] ?? ''));
        $room305Date = trim((string) ($room305['case_date'] ?? ''));

        if ($room305CaseId === '' || $room305Date === '') {
            throw new RuntimeException('The fixed Room 305 guided case is missing from the demo seed.');
        }

        $roomShiftDays = smartops_demo_days_between($room305Date, $today);
        if ($roomShiftDays !== 0) {
            foreach (smartops_demo_operational_date_columns() as $table => $columns) {
                if ($table === 'smart_maintenance_tickets'
                    || $table === 'hitl_cases'
                    || $table === 'workforce_cases'
                    || $table === 'technician_tasks'
                    || $table === 'task_assignment_history'
                    || $table === 'admin_notifications') {
                    smartops_demo_shift_dates(
                        $pdo,
                        $database,
                        $table,
                        $columns,
                        $roomShiftDays,
                        smartops_demo_identifier('case_id') . '=?',
                        [$room305CaseId]
                    );
                }
            }
        }

        smartops_demo_rebalance_demo_timeline($pdo, $today);
        smartops_demo_refresh_dated_case_ids($pdo);

        $currentRoomStatement = $pdo->prepare(
            "SELECT case_id FROM smart_maintenance_tickets WHERE room_id='Room 305' ORDER BY created_at DESC, id DESC LIMIT 1"
        );
        $currentRoomStatement->execute();
        $room305CaseId = trim((string) $currentRoomStatement->fetchColumn());

        // Persist the active snapshot version after every rebuild. Without
        // this, a stale version value inside the bundled SQL seed causes the
        // next request to rebuild the demo again and erase a fresh assignment.
        smartops_demo_set_meta($pdo, 'dataset_version', smartops_expected_snapshot_version());
        smartops_demo_set_meta($pdo, 'rebased_for_date', $today);
        smartops_demo_set_meta($pdo, 'seed_anchor_date', $anchorDate);
        smartops_demo_set_meta($pdo, 'demo_case_id', $room305CaseId);
        smartops_demo_set_meta($pdo, 'dataset_mode', 'Fixed synthetic seed + dynamic rolling dates');
        smartops_demo_set_meta($pdo, 'data_policy', 'Isolated demo only; no production sync');

        $pdo->commit();
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $exception;
    }
}

/**
 * @return array{version:?string,rebased_for_date:?string}
 */
function smartops_demo_current_state(
    string $host,
    string $database,
    string $user,
    string $password,
    string $charset
): array {
    try {
        $database = smartops_demo_safe_database_name($database);
        $pdo = smartops_demo_open_pdo($host, $database, $user, $password, $charset);
        $statement = $pdo->query(
            "SELECT meta_key, meta_value FROM demo_meta "
            . "WHERE meta_key IN ('dataset_version','rebased_for_date')"
        );
        $state = ['version' => null, 'rebased_for_date' => null];
        foreach ($statement->fetchAll() as $row) {
            if (($row['meta_key'] ?? '') === 'dataset_version') {
                $state['version'] = (string) ($row['meta_value'] ?? '');
            }
            if (($row['meta_key'] ?? '') === 'rebased_for_date') {
                $state['rebased_for_date'] = (string) ($row['meta_value'] ?? '');
            }
        }
        return $state;
    } catch (Throwable $exception) {
        return ['version' => null, 'rebased_for_date' => null];
    }
}

function smartops_demo_drop_database(
    string $host,
    string $database,
    string $user,
    string $password
): void {
    $database = smartops_demo_safe_database_name($database);
    $pdo = smartops_demo_open_pdo($host, null, $user, $password);
    $pdo->exec('DROP DATABASE IF EXISTS ' . smartops_demo_identifier($database));
}

function smartops_demo_reset_database(
    string $host,
    string $database,
    string $user,
    string $password,
    string $charset = 'utf8mb4'
): void {
    smartops_demo_drop_database($host, $database, $user, $password);
    smartops_demo_import_sql(
        $host,
        $database,
        $user,
        $password,
        dirname(__DIR__) . '/phpmyadmin_database/smartstay_unified_database.sql'
    );
    smartops_demo_rebase_dates($host, $database, $user, $password, $charset);
}

function smartops_render_database_setup_error(Throwable $exception): never {
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/html; charset=utf-8');
    }
    $message = htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8');
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SmartOps Demo Setup</title><style>body{margin:0;background:#f4f6f9;font-family:Arial,sans-serif;color:#172033;display:grid;place-items:center;min-height:100vh}.card{width:min(680px,calc(100% - 32px));background:#fff;border:1px solid #dbe6f1;border-radius:18px;padding:28px;box-shadow:0 18px 50px rgba(22,55,92,.12)}h1{margin:0 0 10px}.error{background:#fff2f2;border:1px solid #ffcaca;border-radius:12px;padding:12px 14px;color:#9d1c1c}</style></head><body><main class="card"><h1>SmartOps demo could not initialise</h1><p class="error">' . $message . '</p><p>Start Apache and MySQL in XAMPP, then reload the demo.</p></main></body></html>';
    exit;
}

function smartops_ensure_demo_database(
    string $host,
    string $database,
    string $user,
    string $password,
    string $charset
): void {
    static $checked = false;
    if ($checked) {
        return;
    }
    $checked = true;

    try {
        $expectedVersion = smartops_expected_snapshot_version();
        $timezone = new DateTimeZone('Asia/Kuala_Lumpur');
        $today = (new DateTimeImmutable('today', $timezone))->format('Y-m-d');
        $state = smartops_demo_current_state($host, $database, $user, $password, $charset);

        if ($state['version'] !== $expectedVersion || $state['rebased_for_date'] !== $today) {
            smartops_demo_reset_database($host, $database, $user, $password, $charset);
        }
    } catch (Throwable $exception) {
        smartops_render_database_setup_error($exception);
    }
}
