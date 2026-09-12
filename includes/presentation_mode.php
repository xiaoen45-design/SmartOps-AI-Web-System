<?php
/**
 * Presentation/demo mode helpers.
 *
 * These helpers are intentionally isolated from the normal SmartOps workflow.
 * The normal Admin and Technician portals behave exactly as before unless
 * presentation mode is explicitly started from /presentation/.
 */

function presentation_mode_is_active(): bool {
    return !empty($_SESSION['presentation_mode']);
}

function presentation_mode_start(int $resumeSlide): void {
    $_SESSION['presentation_mode'] = true;
    $_SESSION['presentation_resume_slide'] = max(1, $resumeSlide);
    unset($_SESSION['presentation_case_id'], $_SESSION['presentation_technician_id']);
}

function presentation_mode_stop(): int {
    $resumeSlide = max(1, (int)($_SESSION['presentation_resume_slide'] ?? 1));
    unset(
        $_SESSION['presentation_mode'],
        $_SESSION['presentation_resume_slide'],
        $_SESSION['presentation_case_id'],
        $_SESSION['presentation_technician_id']
    );
    return $resumeSlide;
}

function presentation_mode_set_assignment(string $caseId, string $technicianId): void {
    if (!presentation_mode_is_active()) return;

    $_SESSION['presentation_case_id'] = trim($caseId);
    $_SESSION['presentation_technician_id'] = trim($technicianId);
}

function presentation_mode_case_id(): string {
    return trim((string)($_SESSION['presentation_case_id'] ?? ''));
}

function presentation_mode_technician_id(): string {
    return trim((string)($_SESSION['presentation_technician_id'] ?? ''));
}

/**
 * Render a small navigation strip ONLY while presentation mode is active.
 * It sits in normal document flow and the presentation CSS reduces the
 * dashboard viewport height, so it does not cover/overlap the normal UI.
 */
function presentation_mode_bar(string $context): void {
    if (!presentation_mode_is_active()) return;

    $caseId = presentation_mode_case_id();
    $technicianId = presentation_mode_technician_id();
    $isAdmin = $context === 'admin';
    $isTechnician = $context === 'technician';

    $adminUrl = app_url('admin_portal/overview/dashboard.php');
    $switchTechUrl = app_url('presentation/switch_to_technician.php');
    $continueUrl = app_url('presentation/continue.php');
    ?>
    <div class="presentation-demo-bar" role="navigation" aria-label="Presentation demo navigation">
      <div class="presentation-demo-brand">
        <strong>Presentation Mode</strong>
        <?php if ($caseId !== ''): ?>
          <span class="presentation-demo-case">Case: <?= e($caseId) ?></span>
        <?php else: ?>
          <span class="presentation-demo-case">Live system demo</span>
        <?php endif; ?>
      </div>

      <div class="presentation-demo-actions">
        <a class="presentation-demo-link<?= $isAdmin ? ' active' : '' ?>" href="<?= e($adminUrl) ?>">Admin View</a>

        <?php if ($technicianId !== ''): ?>
          <a class="presentation-demo-link<?= $isTechnician ? ' active' : '' ?>" href="<?= e($switchTechUrl) ?>">
            Technician View<?= $technicianId !== '' ? ' · ' . e($technicianId) : '' ?>
          </a>
        <?php else: ?>
          <span class="presentation-demo-link disabled" title="Assign a technician from HITL first">Technician View · Assign first</span>
        <?php endif; ?>

        <a class="presentation-demo-link primary" href="<?= e($continueUrl) ?>">Return to Product Website →</a>
      </div>
    </div>
    <?php
}
