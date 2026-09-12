<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/presentation_mode.php';

/**
 * Return the current Admin module name.
 * Each admin module owns one self-contained CSS and one JS file.
 */
function admin_page_asset_key(): string {
    $script = str_replace('\\', '/', (string)($_SERVER['PHP_SELF'] ?? ''));

    if (preg_match('#/admin_portal/(overview|smart|hitl|workforce|technicians)/#', $script, $match)) {
        return $match[1];
    }

    return str_replace('_', '-', pathinfo($script, PATHINFO_FILENAME));
}

function admin_asset_url(string $type): string {
    $key = admin_page_asset_key();
    $extension = $type === 'css' ? 'css' : 'js';
    return app_url('assets/' . $type . '/admin/' . $key . '.' . $extension);
}

/**
 * Cache-bust the active Admin module asset from its actual file contents.
 * This prevents a newer PHP page from accidentally running an older cached
 * JavaScript/CSS file after CRUD buttons or selectors are changed.
 */
function admin_asset_version(string $type): string {
    $key = admin_page_asset_key();
    $extension = $type === 'css' ? 'css' : 'js';
    $path = dirname(__DIR__) . '/assets/' . $type . '/admin/' . $key . '.' . $extension;

    if (is_file($path)) {
        $hash = @md5_file($path);
        if (is_string($hash) && $hash !== '') return substr($hash, 0, 12);
    }

    return '20260723-admin-fallback';
}

function admin_nav_link(string $label, string $path, string $activeKey, string $active): void {
    $class = $active === $activeKey ? 'active' : '';
    echo '<a class="' . e($class) . '" href="' . e(app_url($path)) . '">' . $label . '</a>';
}

function admin_profile_menu(string $active = ''): void {
    $scriptPath = str_replace('\\', '/', (string)($_SERVER['PHP_SELF'] ?? '/admin_portal/overview/dashboard.php'));
    $marker = '/admin_portal/';
    $position = strpos($scriptPath, $marker);
    $returnPage = $position === false ? 'overview/dashboard.php' : substr($scriptPath, $position + strlen($marker));
    ?>
    <div class="profile-container sidebar-admin-profile">
      <button class="profile-btn<?= $active === 'technicians' ? ' active' : '' ?>" type="button" data-profile-toggle aria-expanded="false" aria-controls="profileDropdown"<?= $active === 'technicians' ? ' aria-current="page"' : '' ?>>
        <span class="profile-avatar">A</span>
        <span>Admin</span>
      </button>
      <div class="profile-dropdown" id="profileDropdown">
        <a class="profile-management-link<?= $active === 'technicians' ? ' active' : '' ?>" href="<?= e(app_url('admin_portal/technicians/index.php')) ?>">Technician Management</a>
        <a href="<?= e(app_url('admin_portal/settings.php?return=' . rawurlencode($returnPage))) ?>">Settings</a>
        <a href="<?= e(app_url('admin_portal/logout.php')) ?>">Logout</a>
      </div>
    </div>
    <?php
}


function admin_notification_center(): void {
    $notifications = fetch_admin_notifications(8);
    $unreadCount = admin_unread_notification_count();
    ?>
    <div class="admin-notification-center" data-admin-notifications data-endpoint="<?= e(app_url('admin_portal/api/notifications.php')) ?>">
      <button class="admin-notification-button" type="button" data-notification-toggle aria-expanded="false" aria-controls="adminNotificationDropdown" aria-label="Admin notifications">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
          <path d="M10 21h4"></path>
        </svg>
        <span class="admin-notification-badge<?= $unreadCount > 0 ? '' : ' is-hidden' ?>" data-notification-count><?= e($unreadCount > 99 ? '99+' : $unreadCount) ?></span>
      </button>

      <div class="admin-notification-dropdown" id="adminNotificationDropdown" data-notification-dropdown>
        <div class="admin-notification-header">
          <div><strong>Notifications</strong><span>Technician completion updates</span></div>
          <span class="admin-notification-unread" data-notification-unread-label><?= e($unreadCount) ?> unread</span>
        </div>
        <div class="admin-notification-list" data-notification-list>
          <?php if (!$notifications): ?>
            <div class="admin-notification-empty">No completion notifications yet.</div>
          <?php else: ?>
            <?php foreach ($notifications as $notification):
                $notificationId = (int)($notification['id'] ?? 0);
                $isUnread = empty($notification['read_at']);
                $openUrl = app_url('admin_portal/notifications/open.php?id=' . $notificationId);
            ?>
              <a class="admin-notification-item<?= $isUnread ? ' is-unread' : '' ?>" href="<?= e($openUrl) ?>">
                <span class="admin-notification-icon" aria-hidden="true">✓</span>
                <span class="admin-notification-copy">
                  <strong><?= e($notification['title'] ?? 'Case completed') ?></strong>
                  <span><?= e($notification['message'] ?? '') ?></span>
                  <small><?= e($notification['created_at'] ?? '') ?></small>
                </span>
                <?php if ($isUnread): ?><span class="admin-notification-new">New</span><?php endif; ?>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="admin-notification-footer">Click a notification to open the completed case in Smart Maintenance.</div>
      </div>
    </div>
    <?php
}

function admin_ui_header(string $title, string $active = '', string $subtitle = '', bool $detailMode = false): void {
    if ($active === 'hitl') {
        ensure_hitl_dataset_consistency();
        ensure_technician_task_trigger_column();
    }

    $sharedShellClass = (!$detailMode && in_array($active, ['overview', 'smart', 'hitl', 'workforce'], true)) ? 'shared-dashboard-shell ' : '';
    $bodyClass = trim('admin-dashboard-page ' . $sharedShellClass . (presentation_mode_is_active() ? 'presentation-demo-active ' : '') . ($detailMode ? 'admin-detail-page ' : '') . ($active !== '' ? $active . '-dashboard-body ' : '') . ($active === 'hitl' ? 'hitl-dashboard-page' : '') . ' ' . ($active === 'workforce' ? 'workforce-dashboard-body' : '') . ' ' . ($active === 'technicians' ? 'technician-management-body' : ''));
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-store">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title><?= e($title) ?> - SmartOps</title>
  <link rel="stylesheet" href="<?= e(admin_asset_url('css')) ?>?v=<?= e(admin_asset_version('css')) ?>">
  <link rel="stylesheet" href="<?= e(app_url('assets/css/admin/live_clock.css')) ?>?v=20260723-live-clock-v8">
  <link rel="stylesheet" href="<?= e(app_url('assets/css/admin/responsive.css')) ?>?v=20260723-responsive-v14">
  <link rel="stylesheet" href="<?= e(app_url('assets/css/admin/notifications.css')) ?>?v=20260724-notifications-v1">
  <?php if (presentation_mode_is_active()): ?><link rel="stylesheet" href="<?= e(app_url('presentation/assets/presentation_mode.css')) ?>?v=20260727-presentation-update-v2"><?php endif; ?>
  <?php if (!$detailMode && in_array($active, ['overview', 'smart', 'hitl', 'workforce'], true)): ?><link rel="stylesheet" href="<?= e(app_url('assets/css/admin/dashboard_stable.css')) ?>?v=<?= e(substr((string)@md5_file(dirname(__DIR__) . '/assets/css/admin/dashboard_stable.css'), 0, 12)) ?>"><?php endif; ?>
</head>
<body class="<?= e($bodyClass) ?>">
  <?php presentation_mode_bar('admin'); ?>
  <div class="layout dashboard">
    <aside class="sidebar">
      <div class="brand logo">
        <h2><span class="smart">Smart</span><span class="stay">Ops</span></h2>
        <p>Admin Portal</p>
      </div>
      <nav class="nav">
        <?php if ($detailMode): ?>
          <a class="detail-back-link" href="<?= e(app_url($active === 'overview' ? 'admin_portal/overview/dashboard.php' : ($active === 'hitl' ? 'admin_portal/hitl/dashboard.php' : ($active === 'workforce' ? 'admin_portal/workforce/dashboard.php' : 'admin_portal/smart/dashboard.php')))) ?>">← Back to Dashboard</a>
        <?php else: ?>
          <?php admin_nav_link('Executive Overview', 'admin_portal/overview/dashboard.php', 'overview', $active); ?>
          <?php admin_nav_link('Smart Maintenance<br>Intelligence', 'admin_portal/smart/dashboard.php', 'smart', $active); ?>
          <?php admin_nav_link('Human-In-The-Loop<br>(HITL) Escalation', 'admin_portal/hitl/dashboard.php', 'hitl', $active); ?>
          <?php admin_nav_link('Workforce &amp; Task<br>Monitoring', 'admin_portal/workforce/dashboard.php', 'workforce', $active); ?>
        <?php endif; ?>
      </nav>
      <?php if (!$detailMode): ?><?php admin_profile_menu($active); ?><?php endif; ?>
    </aside>
    <main class="main main-content dashboard-page <?= $active === 'workforce' ? 'workforce-dashboard-page' : '' ?>">
      <header class="topbar">
        <div class="topbar-heading">
          <h1<?= $detailMode ? ' id="detailPageTitle"' : '' ?>><?= e($title) ?></h1>
          <?php if ($subtitle !== ''): ?><p<?= $detailMode ? ' id="detailPageSubtitle"' : '' ?>><?= e($subtitle) ?></p><?php endif; ?>
        </div>
        <div class="admin-topbar-actions">
          <?php admin_notification_center(); ?>
          <?php if (!$detailMode && in_array($active, ['overview', 'smart', 'hitl', 'workforce'], true)): ?>
            <div class="live-clock" data-live-clock data-timezone="Asia/Kuala_Lumpur" role="timer" aria-live="off" aria-label="Live Kuala Lumpur time">
              <div class="live-clock-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" focusable="false">
                  <circle cx="12" cy="12" r="8.25"></circle>
                  <path d="M12 7.75v4.65l3.15 1.85"></path>
                </svg>
              </div>
              <div class="live-clock-content">
                <div class="live-clock-topline">
                  <span class="live-clock-location">Kuala Lumpur</span>
                  <span class="live-clock-status"><span class="live-clock-dot" aria-hidden="true"></span>Live</span>
                </div>
                <div class="live-clock-time-row">
                  <time class="live-clock-time" data-clock-time>--:--:--</time>
                  <span class="live-clock-period" data-clock-period>--</span>
                </div>
                <time class="live-clock-date" data-clock-date>Loading date…</time>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </header>
<?php
}

function admin_ui_footer(array $vendorScripts = []): void {
    ?>
    </main>
  </div>
  <?php foreach ($vendorScripts as $vendorScript): ?>
    <script src="<?= e($vendorScript) ?>"></script>
  <?php endforeach; ?>
  <script src="<?= e(app_url('assets/js/admin/live_clock.js')) ?>?v=20260723-live-clock-v8"></script>
  <script src="<?= e(app_url('assets/js/admin/notifications.js')) ?>?v=20260724-notifications-v1"></script>
  <script src="<?= e(admin_asset_url('js')) ?>?v=<?= e(admin_asset_version('js')) ?>"></script>
</body>
</html>
<?php
}
