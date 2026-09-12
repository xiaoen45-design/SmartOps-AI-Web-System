<?php
require_once __DIR__ . '/../includes/technician_layout.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $technicianId = trim((string)($_POST['technician_id'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $newPassword = trim((string)($_POST['new_password'] ?? ''));
    $confirmPassword = trim((string)($_POST['confirm_password'] ?? ''));

    if ($technicianId === '' || $email === '' || $newPassword === '' || $confirmPassword === '') {
        $error = 'Please fill in all fields.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New password and confirm password do not match.';
    } elseif (strlen($newPassword) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        try {
            $technician = fetch_one(
                'SELECT technician_id, email FROM technicians WHERE technician_id = ? AND email = ? AND is_active=1',
                [$technicianId, $email]
            );

            if (!$technician) {
                $error = 'Technician ID and email do not match.';
            } else {
                execute_sql('UPDATE technicians SET password = ? WHERE technician_id = ?', [password_hash($newPassword, PASSWORD_DEFAULT), $technicianId]);
                redirect_to('login.php?reset=1');
            }
        } catch (Throwable $exception) {
            $error = 'Database is unavailable. Start MySQL and import the SmartStay SQL file first.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="<?= e(technician_asset_url('css')) ?>?v=20260716-limit4-aligned">
</head>
<body class="tech-body">
  <div class="center-card card">
    <div class="brand">
      <span>Smart</span><strong>Ops</strong>
      <small>Technician Website</small>
    </div>

    <h1 class="mt">Reset Password</h1>

    <?php if ($error !== ''): ?><div class="error mt"><?= e($error) ?></div><?php endif; ?>

    <form class="tech-form mt" method="post">
      <label for="resetTechnicianId">Technician ID</label>
      <input class="form-control" id="resetTechnicianId" name="technician_id" placeholder="Technician ID" required>

      <label for="resetTechnicianEmail">Email</label>
      <input class="form-control" id="resetTechnicianEmail" name="email" type="email" placeholder="Email" required>

      <label for="newTechnicianPassword">New Password</label>
      <input class="form-control" id="newTechnicianPassword" name="new_password" type="password" placeholder="New password" required>

      <label for="confirmTechnicianPassword">Confirm New Password</label>
      <input class="form-control" id="confirmTechnicianPassword" name="confirm_password" type="password" placeholder="Confirm new password" required>

      <button class="btn" type="submit">Update Password</button>
      <a class="btn btn-outline" href="login.php">Back to Login</a>
    </form>
  </div>
  <script src="<?= e(technician_asset_url('js')) ?>?v=20260716-limit4-aligned"></script>
</body>
</html>
