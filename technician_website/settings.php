<?php
require_once __DIR__ . '/auth.php';
$techId = require_technician();
$tech = current_technician();

$contactSuccess = '';
$passwordSuccess = '';
$contactError = '';
$passwordError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'contact') {
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($phone === '' || $email === '') {
            $contactError = 'Please enter both phone number and email address.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $contactError = 'Please enter a valid email address.';
        } else {
            execute_sql(
                "UPDATE technicians SET phone=?, email=? WHERE technician_id=?",
                [$phone, $email, $techId]
            );
            $contactSuccess = 'Contact information updated successfully.';
            $tech = current_technician();
        }
    }

    if ($formType === 'password') {
        $current = trim($_POST['current_password'] ?? '');
        $new = trim($_POST['new_password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');
        $stored = (string)($tech['password'] ?? '');

        if ($current === '' || $new === '' || $confirm === '') {
            $passwordError = 'Please complete all password fields.';
        } elseif (!(password_get_info($stored)['algoName'] !== 'unknown' ? password_verify($current, $stored) : hash_equals($stored, $current))) {
            $passwordError = 'Current password is incorrect.';
        } elseif (strlen($new) < 6) {
            $passwordError = 'New password must be at least 6 characters.';
        } elseif ($new !== $confirm) {
            $passwordError = 'New password and confirmation do not match.';
        } else {
            execute_sql(
                "UPDATE technicians SET password=? WHERE technician_id=?",
                [password_hash($new, PASSWORD_DEFAULT), $techId]
            );
            $passwordSuccess = 'Password updated successfully.';
            $tech = current_technician();
        }
    }
}

tech_header('Settings', 'settings');
?>
<div class="settings-page-stack">
  <section class="card tech-settings-card settings-combined-card">
    <div class="settings-subsection" id="contactInformation">
      <h2 class="section-title">Contact Information</h2>

      <?php if ($contactSuccess): ?>
        <div class="success mt"><?= e($contactSuccess) ?></div>
      <?php endif; ?>
      <?php if ($contactError): ?>
        <div class="error mt"><?= e($contactError) ?></div>
      <?php endif; ?>

      <form method="post" class="tech-form settings-form">
        <input type="hidden" name="form_type" value="contact">
        <label>
          <span>Phone Number</span>
          <input class="form-control" type="text" name="phone" value="<?= e($tech['phone'] ?? '') ?>" placeholder="Enter phone number" required>
        </label>
        <label>
          <span>Email Address</span>
          <input class="form-control" type="email" name="email" value="<?= e($tech['email'] ?? '') ?>" placeholder="Enter email address" required>
        </label>
        <div class="form-action-row">
          <button type="submit" class="btn">Save Changes</button>
          <button type="reset" class="btn btn-outline">Cancel</button>
        </div>
      </form>
    </div>

    <div class="settings-section-divider" aria-hidden="true"></div>

    <div class="settings-subsection" id="changePassword">
      <h2 class="section-title">Change Password</h2>

      <?php if ($passwordSuccess): ?>
        <div class="success mt"><?= e($passwordSuccess) ?></div>
      <?php endif; ?>
      <?php if ($passwordError): ?>
        <div class="error mt"><?= e($passwordError) ?></div>
      <?php endif; ?>

      <form method="post" class="tech-form settings-form">
        <input type="hidden" name="form_type" value="password">
        <label>
          <span>Current Password</span>
          <input class="form-control" type="password" name="current_password" placeholder="Enter current password" required>
        </label>
        <label>
          <span>New Password</span>
          <input class="form-control" type="password" name="new_password" placeholder="Enter new password" minlength="6" required>
        </label>
        <label>
          <span>Confirm New Password</span>
          <input class="form-control" type="password" name="confirm_password" placeholder="Re-enter new password" minlength="6" required>
        </label>
        <div class="form-action-row">
          <button type="submit" class="btn">Update Password</button>
          <button type="reset" class="btn btn-outline">Cancel</button>
        </div>
      </form>
    </div>
  </section>

  <div class="settings-page-actions">
    <a class="btn btn-outline" href="home.php?filter=assigned">Back to My Work</a>
    <a class="btn btn-danger-outline" href="logout.php">Logout</a>
  </div>
</div>
<?php tech_footer(); ?>
