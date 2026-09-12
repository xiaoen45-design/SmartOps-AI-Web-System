<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

require_once __DIR__ . '/../includes/helpers.php';
$assetVersion = (string) round(microtime(true) * 1000);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f4f6f9">
  <title>SmartOps Room 305 Guided Demo</title>
  <link rel="stylesheet" href="assets/guided_demo.css?v=<?= e($assetVersion) ?>">
</head>
<body class="guided-demo-page">
  <header class="guided-demo-toolbar">
    <div class="guided-demo-roles" aria-label="Demo controls">
      <button class="guided-role-button active" type="button" id="guidedAdminButton" aria-pressed="true">
        <span>Admin View</span>
        <i class="guided-notification-badge" id="guidedAdminBadge" hidden>1</i>
      </button>
      <button class="guided-role-button locked" type="button" id="guidedTechnicianButton" aria-pressed="false" disabled>
        <span id="guidedTechnicianLabel">Technician View · Assign first</span>
        <i class="guided-ready-dot" aria-hidden="true"></i>
      </button>
      <a class="guided-continue-button" href="index.php#live-demo">Continue Presentation <span>→</span></a>
    </div>
  </header>

  <section class="guided-instruction-bar" aria-live="polite">
    <span class="guided-demo-label">GUIDED DEMO</span>
    <div class="guided-instruction-copy">
      <strong id="guidedInstruction">Click Review on the highlighted Room 305 case.</strong>
      <small id="guidedHint">The Room 305 case is pinned to the first row.</small>
    </div>
    <i id="guidedStep">Step 1 of 7</i>
  </section>

  <main class="guided-browser-shell">
    <div class="guided-browser-bar">
      <div class="guided-browser-dots" aria-hidden="true"><span></span><span></span><span></span></div>
      <div class="guided-browser-address">smartops demo / isolated visitor session / room 305</div>
      <div class="guided-fresh-status"><span></span>FRESH SESSION</div>
    </div>

    <iframe
      id="guidedDashboardFrame"
      title="SmartOps exact dashboard guided demo"
      data-demo-root="demo_app"
      loading="eager"
    ></iframe>
  </main>

  <div class="guided-toast" id="guidedToast" aria-live="polite">Preparing a fresh Room 305 demo session…</div>
  <script src="assets/guided_demo.js?v=<?= e($assetVersion) ?>"></script>
</body>
</html>
