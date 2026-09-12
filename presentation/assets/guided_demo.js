(() => {
  'use strict';

  const frame = document.getElementById('guidedDashboardFrame');
  const adminButton = document.getElementById('guidedAdminButton');
  const technicianButton = document.getElementById('guidedTechnicianButton');
  const technicianLabel = document.getElementById('guidedTechnicianLabel');
  const adminBadge = document.getElementById('guidedAdminBadge');
  const instruction = document.getElementById('guidedInstruction');
  const hint = document.getElementById('guidedHint');
  const step = document.getElementById('guidedStep');
  const toast = document.getElementById('guidedToast');
  if (!frame || !adminButton || !technicianButton) return;

  const demoRoot = frame.dataset.demoRoot || 'demo_app';
  let activeRole = 'admin';
  let assigned = false;
  let accepted = false;
  let started = false;
  let completed = false;
  let reviewOpened = false;
  let toastTimer = null;

  const setInstruction = (title, helper, stepText) => {
    if (instruction) instruction.textContent = title;
    if (hint) hint.textContent = helper;
    if (step) step.textContent = stepText;
  };



  const ensureEmbeddedDashboardStyle = (doc, fitWholeDashboard) => {
    const styleId = 'smartops-guided-embedded-style';
    let style = doc.getElementById(styleId);
    if (!style) {
      style = doc.createElement('style');
      style.id = styleId;
      doc.head.appendChild(style);
    }

    style.textContent = fitWholeDashboard ? `
      /* Guided demo stability override.
         Keep the embedded dashboard in normal document flow and allow the
         iframe itself to scroll. No fixed row heights, no forced viewport
         fitting, and no JavaScript zoom. */
      html,
      body {
        width: 100% !important;
        height: auto !important;
        min-height: 100% !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
        scroll-behavior: smooth !important;
      }

      body .layout.dashboard,
      body .layout,
      body .dashboard,
      body .sidebar {
        height: auto !important;
        min-height: 100vh !important;
        max-height: none !important;
        overflow: visible !important;
      }

      body .main.dashboard-page {
        box-sizing: border-box !important;
        height: auto !important;
        min-height: 100vh !important;
        max-height: none !important;
        overflow: visible !important;
        display: flex !important;
        flex-direction: column !important;
        align-content: normal !important;
        gap: 14px !important;
        padding: 14px 18px 24px !important;
        grid-template-rows: none !important;
      }

      body .topbar,
      body .admin-topbar-actions,
      body .live-clock,
      body .shared-dashboard-kpis,
      body .shared-dashboard-kpi,
      body .overview-alerts-card,
      body .overview-analytics-layout,
      body .overview-primary-chart,
      body .overview-side-charts,
      body .compact-chart-card,
      body .smart-analytics-grid,
      body .hitl-dashboard-grid,
      body .workforce-two-col-grid {
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        overflow: visible !important;
      }

      body .shared-dashboard-kpis {
        flex: 0 0 auto !important;
      }

      body.overview-dashboard-body .overview-alerts-card {
        flex: 0 0 auto !important;
        margin: 0 !important;
        padding: 14px 16px !important;
        display: block !important;
      }

      body.overview-dashboard-body .overview-alerts-card .table-header.compact-header {
        margin: 0 0 12px !important;
      }

      body.overview-dashboard-body .alert-grid.four-alerts {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        gap: 12px !important;
        height: auto !important;
        min-height: 0 !important;
      }

      body.overview-dashboard-body .alert-box {
        height: auto !important;
        min-height: 104px !important;
        max-height: none !important;
        padding: 14px 16px !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
      }

      body.overview-dashboard-body .alert-box strong {
        margin: 4px 0 !important;
        align-self: auto !important;
      }

      body.overview-dashboard-body .overview-analytics-layout {
        display: grid !important;
        grid-template-columns: minmax(0, 1.7fr) minmax(340px, 1fr) !important;
        gap: 14px !important;
        align-items: start !important;
        flex: 0 0 auto !important;
      }

      body.overview-dashboard-body .overview-primary-chart {
        min-height: 520px !important;
      }

      body.overview-dashboard-body .overview-side-charts {
        display: grid !important;
        grid-template-rows: auto auto !important;
        gap: 14px !important;
        min-width: 0 !important;
      }

      body.overview-dashboard-body .overview-side-charts .compact-chart-card {
        min-height: 250px !important;
      }

      body canvas {
        max-width: 100% !important;
      }

      @media (max-width: 1180px) {
        body.overview-dashboard-body .alert-grid.four-alerts {
          grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        body.overview-dashboard-body .overview-analytics-layout {
          grid-template-columns: 1fr !important;
        }
      }

      @media (max-width: 760px) {
        body.overview-dashboard-body .alert-grid.four-alerts {
          grid-template-columns: 1fr !important;
        }
      }
    ` : `
      html, body {
        min-height: 100% !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
      }
    `;
  };

  const getAvailableFrameHeight = () => {
    const rect = frame.getBoundingClientRect();
    return Math.max(620, window.innerHeight - rect.top - 16);
  };

  const applyFrameScale = () => {
    try {
      const doc = frame.contentDocument;
      const win = frame.contentWindow;
      if (!doc || !doc.documentElement || !doc.body || !win) return;

      // The dashboard owns its own one-viewport layout through
      // dashboard_stable.css. Guided Demo must not zoom, transform, measure,
      // or rewrite the dashboard because those operations previously caused
      // delayed overlap and chart clipping.
      doc.documentElement.style.zoom = '1';
      doc.documentElement.style.transform = 'none';
      doc.documentElement.style.overflow = 'hidden';
      doc.body.style.zoom = '1';
      doc.body.style.transform = 'none';
      doc.body.style.transformOrigin = 'initial';
      doc.body.style.width = '100%';
      doc.body.style.height = '100%';
      doc.body.style.margin = '0';
      doc.body.style.overflow = 'hidden';

      frame.style.height = `${getAvailableFrameHeight()}px`;

      // Charts receive the final iframe dimensions once, after the browser
      // has completed layout. No ResizeObserver loop is used.
      window.requestAnimationFrame(() => win.dispatchEvent(new Event('resize')));
      window.setTimeout(() => win.dispatchEvent(new Event('resize')), 180);
    } catch (error) {
      console.warn('SmartOps guided demo layout unavailable', error);
    }
  };

  const syncFrameHeight = () => {
    frame.style.height = `${getAvailableFrameHeight()}px`;
  };

  const observeFrameHeight = () => {
    // Intentionally disabled. The embedded dashboard is fixed to one viewport;
    // observing body mutations caused repeated resize/scale feedback loops.
  };

  const scheduleFrameScale = () => {
    window.requestAnimationFrame(() => {
      syncFrameHeight();
      applyFrameScale();
    });
  };

  const showToast = message => {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(() => toast.classList.remove('show'), 2400);
  };

  const setActiveRole = role => {
    activeRole = role;
    const technicianActive = role === 'technician';
    adminButton.classList.toggle('active', !technicianActive);
    adminButton.setAttribute('aria-pressed', String(!technicianActive));
    technicianButton.classList.toggle('active', technicianActive);
    technicianButton.setAttribute('aria-pressed', String(technicianActive));
  };

  const loadFrame = (role, view, reset = false) => {
    const params = new URLSearchParams({ role, view, t: String(Date.now()) });
    if (reset) params.set('reset', '1');
    frame.src = `${demoRoot}/demo_entry.php?${params.toString()}`;
    setActiveRole(role);
  };

  const refreshGuide = status => {
    assigned = Boolean(status.assigned);
    accepted = Boolean(status.accepted);
    started = Boolean(status.started);
    completed = Boolean(status.completed);

    if (assigned) {
      technicianButton.disabled = false;
      technicianButton.classList.remove('locked');
      technicianButton.classList.add('ready');
      if (technicianLabel) {
        const technicianId = String(status.technician_id || '').trim();
        technicianLabel.textContent = technicianId
          ? `Technician View · ${technicianId}`
          : 'Technician View';
      }
    } else {
      technicianButton.disabled = true;
      technicianButton.classList.add('locked');
      technicianButton.classList.remove('ready');
      if (technicianLabel) technicianLabel.textContent = 'Technician View · Assign first';
    }

    if (!assigned) {
      if (reviewOpened) {
        setInstruction(
          'Select an available technician, then click Approve & Assign.',
          'The highlighted action inside the review window dispatches Room 305.',
          'Step 2 of 7'
        );
      } else {
        setInstruction(
          'Click Review on the highlighted Room 305 case.',
          'The Room 305 HVAC leakage case is pinned to the first row.',
          'Step 1 of 7'
        );
      }
      return;
    }

    if (assigned && activeRole === 'admin' && !completed) {
      setInstruction(
        'Technician View is unlocked — click it to receive the Room 305 task.',
        'The green Technician View button is now available.',
        'Step 3 of 7'
      );
      return;
    }

    if (activeRole === 'technician' && !accepted) {
      setInstruction('Click Accept Task.', 'Accept the assigned Room 305 HVAC task.', 'Step 4 of 7');
      return;
    }

    if (activeRole === 'technician' && accepted && !started) {
      setInstruction('Click Start Work.', 'Move the Room 305 task into active maintenance.', 'Step 5 of 7');
      return;
    }

    if (activeRole === 'technician' && started && !completed) {
      setInstruction('Click Complete Task.', 'Finish the repair to send an update to Admin View.', 'Step 6 of 7');
      return;
    }

    if (completed) {
      technicianButton.classList.remove('ready');
      adminButton.classList.add('has-notification');
      if (adminBadge) {
        adminBadge.hidden = false;
        adminBadge.textContent = String(Math.max(1, Number(status.notification_count || 1)));
      }
      setInstruction(
        'Return to Admin View and review the completion notification.',
        'The red badge shows the Room 305 technician update.',
        'Step 7 of 7'
      );
    }
  };

  const pollStatus = async () => {
    try {
      const response = await fetch(`${demoRoot}/demo_status.php?t=${Date.now()}`, {
        cache: 'no-store',
        credentials: 'same-origin'
      });
      if (!response.ok) return;
      refreshGuide(await response.json());
      scheduleFrameScale();
    } catch (error) {
      console.warn('SmartOps guided demo status unavailable', error);
    }
  };

  adminButton.addEventListener('click', () => {
    loadFrame('admin', completed ? 'notifications' : (assigned ? 'overview' : 'pending'));
    if (completed) {
      adminBadge.hidden = true;
      adminButton.classList.remove('has-notification');
      setInstruction(
        'Open the notification bell to review the Room 305 completion update.',
        'The technician completion is recorded in the real Admin Dashboard design.',
        'Completed'
      );
    }
  });

  technicianButton.addEventListener('click', () => {
    if (!assigned) {
      showToast('Assign the highlighted Room 305 case first.');
      return;
    }
    loadFrame('technician', 'assigned');
    showToast('Technician View opened for Room 305.');
    window.setTimeout(pollStatus, 350);
  });

  window.addEventListener('message', event => {
    if (event.origin !== window.location.origin) return;
    if (event.data?.type === 'SMARTOPS_DEMO_REVIEW_OPENED') {
      reviewOpened = true;
      setInstruction(
        'Select an available technician, then click Approve & Assign.',
        'The selected technician will receive the Room 305 case.',
        'Step 2 of 7'
      );
      return;
    }

    if (event.data?.type === 'SMARTOPS_DEMO_ASSIGNED') {
      const technicianId = String(event.data.technicianId || '').trim();
      assigned = true;
      technicianButton.disabled = false;
      technicianButton.classList.remove('locked');
      technicianButton.classList.add('ready');
      if (technicianLabel) {
        technicianLabel.textContent = technicianId
          ? `Technician View · ${technicianId}`
          : 'Technician View';
      }
      setInstruction(
        'Technician View is unlocked — click it to receive the Room 305 task.',
        technicianId
          ? `${technicianId} has been assigned to the Room 305 case.`
          : 'The selected technician has been assigned to Room 305.',
        'Step 3 of 7'
      );
      showToast(technicianId ? `${technicianId} assigned successfully.` : 'Technician assigned successfully.');
      window.setTimeout(pollStatus, 120);
    }
  });

  frame.addEventListener('load', () => {
    window.setTimeout(pollStatus, 300);
    scheduleFrameScale();
    window.setTimeout(observeFrameHeight, 80);
    window.setTimeout(syncFrameHeight, 500);
  });

  window.addEventListener('resize', () => { scheduleFrameScale(); syncFrameHeight(); });

  loadFrame('admin', 'pending', true);
  showToast('Fresh isolated Room 305 demo session started.');
  window.setInterval(pollStatus, 800);
  window.setTimeout(pollStatus, 700);
  window.setTimeout(scheduleFrameScale, 900);
})();
