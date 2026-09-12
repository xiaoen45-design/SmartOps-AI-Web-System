(() => {
  'use strict';

  const API = { smart: '../api/smart_maintenance_csv.php' };
  const COLORS = { blue: '#2563eb', red: '#ef4444', green: '#16a34a', orange: '#f59e0b' };

  document.addEventListener('DOMContentLoaded', () => {
    initProfileMenu();
    initSmartTrendModal();
    initSmartPage();
  });

  function clickedElements(chart, event, elements) {
    if (elements && elements.length) return elements;
    if (!chart || !event) return [];
    return chart.getElementsAtEventForMode(
      event,
      'nearest',
      { intersect: false, axis: 'xy' },
      false
    );
  }

  function initProfileMenu() {
    const button = document.querySelector('[data-profile-toggle]');
    const dropdown = document.getElementById('profileDropdown');
    if (!button || !dropdown) return;
    const setOpen = open => {
      dropdown.classList.toggle('is-open', open);
      button.setAttribute('aria-expanded', open ? 'true' : 'false');
    };
    button.addEventListener('click', event => {
      event.stopPropagation();
      setOpen(!dropdown.classList.contains('is-open'));
    });
    dropdown.addEventListener('click', event => event.stopPropagation());
    document.addEventListener('click', () => setOpen(false));
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape') setOpen(false);
    });
  }

  async function initSmartPage() {
    try {
      const rows = await loadCSV(API.smart);
      const tickets = rows.map(normalizeSmartTicket).filter(ticket => ticket.caseId);
      const page = document.querySelector('[data-smart-page]')?.dataset.smartPage || 'dashboard';

      if (page === 'trend-detail') renderTrendDetail(tickets);
      else if (page === 'asset-detail') renderAssetDetail(tickets);
      else if (page === 'aging-detail') renderAgingDetail(tickets);
      else if (page === 'component-cases') renderComponentCases(tickets);
      else renderDashboard(tickets);
    } catch (error) {
      console.error(error);
      alert('Unable to load Smart Maintenance data. Please check the database connection and API path.');
    }
  }

  async function loadCSV(path) {
    const response = await fetch(path, { cache: 'no-store' });
    if (!response.ok) throw new Error(`Request failed: ${response.status}`);
    const text = await response.text();
    if (!text.trim() || /^\s*</.test(text)) throw new Error('API returned no CSV data.');

    const lines = text.trim().split(/\r?\n/);
    const headers = splitCSVLine(lines.shift()).map(value => value.trim());
    return lines.filter(Boolean).map(line => {
      const values = splitCSVLine(line);
      const row = {};
      headers.forEach((header, index) => { row[header] = values[index] ? values[index].trim() : ''; });
      return row;
    });
  }

  function splitCSVLine(line) {
    const result = [];
    let current = '';
    let quoted = false;
    for (let index = 0; index < line.length; index += 1) {
      const character = line[index];
      const next = line[index + 1];
      if (character === '"' && quoted && next === '"') {
        current += '"';
        index += 1;
      } else if (character === '"') quoted = !quoted;
      else if (character === ',' && !quoted) { result.push(current); current = ''; }
      else current += character;
    }
    result.push(current);
    return result;
  }

  function normalizeSmartTicket(row) {
    return {
      caseId: row.case_id || '',
      room: row.room_id || row.room || '-',
      createdRaw: row.timestamp || row.created_at || row.created_date || row.date || '',
      createdDate: parseDate(row.timestamp || row.created_at || row.created_date || row.date || ''),
      completedDate: parseDate(row.completed_date || row.completed_at || ''),
      cleanedComment: row.cleaned_comment || row.issue || row.observed_symptoms || '-',
      assetRaw: row.hotel_asset || row.category || 'Unknown',
      asset: cleanAssetLabel(row.hotel_asset || row.category || 'Unknown'),
      component: cleanComponentLabel(row.component || '-'),
      failureMode: row.failure_mode || '-',
      observedSymptoms: row.observed_symptoms || '-',
      possibleRootCause: row.possible_root_cause || '-',
      correctiveAction: row.corrective_action || '-',
      preventiveMaintenance: row.preventive_maintenance || '-',
      severity: normalizeSeverity(row.severity_level || row.severity || ''),
      priority: normalizePriority(row.priority_level || row.priority || ''),
      safety: row.safety || row.safety_flag || '-',
      sla: row.sla || row.sla_target || '-',
      slaStatus: row.sla_status || '-',
      escalationRequired: normalizeBooleanText(row.escalation_required),
      humanApprovalRequired: normalizeBooleanText(row.human_approval_required),
      status: normalizeStatus(row.ticket_status || row.status || ''),
      technicianAssigned: row.technician_assigned || row.technician_name || '-',
      supportReason: row.support_reason || '-'
    };
  }

  function normalizeBooleanText(value) {
    const text = String(value || '').trim().toLowerCase();
    if (['yes', 'true', '1', 'required'].includes(text)) return 'yes';
    return 'no';
  }

  function normalizeSeverity(value) {
    const text = String(value || '').trim().toLowerCase();
    if (text.includes('critical')) return 'Critical';
    if (text.includes('high')) return 'High';
    if (text.includes('medium')) return 'Medium';
    if (text.includes('low')) return 'Low';
    return '-';
  }

  function normalizePriority(value) {
    const text = String(value || '').trim().toLowerCase().replace(/[_-]+/g, ' ');
    if (/\bp1\b/.test(text) || text.includes('immediate') || text.includes('critical')) return 'Immediate';
    if (/\bp2\b/.test(text) || text.includes('urgent') || text.includes('high')) return 'Urgent';
    if (/\bp3\b/.test(text) || text.includes('standard') || text.includes('medium')) return 'Standard';
    if (/\bp4\b/.test(text) || text.includes('low')) return 'Low';
    return '-';
  }

  function normalizeStatus(value) {
    const text = String(value || '').trim().toLowerCase();
    if (text.includes('complete') || text.includes('resolved')) return 'Completed';
    if (text.includes('progress') || text.includes('processing')) return 'In Progress';
    if (text.includes('assigned')) return 'Assigned';
    return 'Pending';
  }

  function cleanAssetLabel(value) {
    const raw = String(value || '').trim();
    const normalized = raw.toLowerCase();
    if (!raw || ['-', 'unknown', 'none', 'null', 'n/a', 'na', 'out_of_kb', 'out of kb', 'out of knowledge base'].includes(normalized)) {
      return 'Other';
    }

    const withoutCode = raw.replace(/^D\d+(?:\.\d+)?\s*/i, '').replace(/^[-–—:]\s*/, '').trim();
    const aliases = {
      hvac: 'HVAC',
      plumbing: 'Plumbing',
      electrical: 'Electrical',
      fire: 'Fire Protection',
      'fire protection': 'Fire Protection',
      'fire system': 'Fire Protection',
      elevator: 'Conveying',
      conveying: 'Conveying',
      'elevator & lifts': 'Conveying',
      lifts: 'Conveying',
      other: 'Other'
    };
    return aliases[withoutCode.toLowerCase()] || withoutCode || 'Other';
  }

  function cleanComponentLabel(value) {
    return String(value || '-').trim().replace(/^D\d+(?:\.\d+)?\s*/i, '').trim() || '-';
  }

  function parseDate(value) {
    if (!value) return null;
    const direct = new Date(value);
    if (!Number.isNaN(direct.getTime())) return direct;
    const fallback = Date.parse(String(value).replace(/-/g, '/'));
    return Number.isNaN(fallback) ? null : new Date(fallback);
  }

  function startOfDay(date) { return new Date(date.getFullYear(), date.getMonth(), date.getDate()); }
  function addDays(date, days) { const copy = new Date(date); copy.setDate(copy.getDate() + days); return copy; }
  function sameDay(first, second) {
    return Boolean(first && second)
      && first.getFullYear() === second.getFullYear()
      && first.getMonth() === second.getMonth()
      && first.getDate() === second.getDate();
  }
  function toISODate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
  function formatDate(date) {
    return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' });
  }
  function formatNumber(value) { return Number(value || 0).toLocaleString(); }
  function isCompleted(ticket) { return ticket.status === 'Completed'; }
  function isHitlRequired(ticket) {
    return ticket.humanApprovalRequired === 'yes'
      || ticket.escalationRequired === 'yes'
      || ticket.severity === 'High'
      || ticket.severity === 'Critical';
  }

  function getReferenceDate(tickets) {
    const values = tickets
      .flatMap(ticket => [ticket.createdDate, ticket.completedDate])
      .filter(Boolean)
      .map(date => date.getTime())
      .filter(Number.isFinite);
    return values.length ? startOfDay(new Date(Math.max(...values))) : startOfDay(new Date());
  }

  function completionEventDate(ticket) {
    if (ticket.completedDate) return startOfDay(ticket.completedDate);
    // Preserve legacy completed rows even when an older database has no
    // completed_date value. New completions use the actual completion date.
    if (isCompleted(ticket) && ticket.createdDate) return startOfDay(ticket.createdDate);
    return null;
  }

  function buildSevenDayCohorts(tickets) {
    const referenceDate = getReferenceDate(tickets);
    const days = Array.from({ length: 7 }, (_, index) => addDays(referenceDate, index - 6));
    const enriched = tickets.map(ticket => ({
      ...ticket,
      analysisDate: ticket.createdDate ? startOfDay(ticket.createdDate) : referenceDate
    }));
    return { referenceDate, days, enriched };
  }

  function valueLabelPlugin() {
    return {
      id: 'smartValueLabels',
      afterDatasetsDraw(chart) {
        const { ctx, chartArea } = chart;
        if (!chartArea) return;

        const isLine = chart.config.type === 'line';
        const isHorizontal = chart.config.type === 'bar' && chart.options.indexAxis === 'y';
        const clamp = (value, min, max) => Math.max(min, Math.min(max, value));

        ctx.save();
        ctx.font = '700 12px Arial';

        const drawLabel = (text, x, y, color, align = 'center', baseline = 'middle') => {
          const width = ctx.measureText(text).width;
          if (align === 'left') x = clamp(x, chartArea.left + 4, chartArea.right - width - 4);
          else if (align === 'right') x = clamp(x, chartArea.left + width + 4, chartArea.right - 4);
          else x = clamp(x, chartArea.left + width / 2 + 4, chartArea.right - width / 2 - 4);
          y = clamp(y, chartArea.top + 14, chartArea.bottom - 14);
          ctx.textAlign = align;
          ctx.textBaseline = baseline;
          ctx.fillStyle = color;
          ctx.fillText(text, x, y);
        };

        chart.data.datasets.forEach((dataset, datasetIndex) => {
          const meta = chart.getDatasetMeta(datasetIndex);
          if (meta.hidden) return;

          meta.data.forEach((element, index) => {
            const value = Number(dataset.data[index]);
            if (!Number.isFinite(value)) return;

            const point = element.getProps(['x', 'y'], true);
            const rawColor = dataset.borderColor || dataset.backgroundColor || '#111827';
            const color = Array.isArray(rawColor) ? rawColor[index % rawColor.length] : rawColor;
            const label = value.toLocaleString();

            if (isHorizontal) {
              drawLabel(label, point.x + 9, point.y, color, 'left', 'middle');
              return;
            }

            if (isLine) {
              const pointRadius = Number(dataset.pointRadius) || 4;
              drawLabel(label, point.x, point.y - pointRadius - 8, color, 'center', 'bottom');
              return;
            }

            drawLabel(label, point.x, point.y - 10, color, 'center', 'bottom');
          });
        });

        ctx.restore();
      }
    };
  }

  function initSmartTrendModal() {
    const modal = document.getElementById('smartTrendSummaryModal');
    if (!modal) return;

    const close = () => {
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('modal-open');
    };

    modal.querySelectorAll('[data-smart-trend-close]').forEach(button => button.addEventListener('click', close));
    modal.addEventListener('click', event => {
      if (event.target === modal) close();
    });
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && modal.classList.contains('is-open')) close();
    });
  }

  function openSmartTrendModal(dateLabel, received, completedOnDate, openFromIntake, sameDayCompleted, isoDate, series) {
    const modal = document.getElementById('smartTrendSummaryModal');
    if (!modal) return;

    setText('smartTrendModalDate', dateLabel);
    setText('smartTrendModalTotal', formatNumber(received));
    setText('smartTrendModalCompleted', formatNumber(completedOnDate));
    setText('smartTrendModalUnsolved', formatNumber(openFromIntake));
    setText('smartTrendModalCompletionRate', received ? `${((sameDayCompleted / received) * 100).toFixed(1)}%` : '0.0%');

    const note = document.getElementById('smartTrendModalNote');
    if (note) {
      note.textContent = `${formatNumber(received)} complaint(s) were received and ${formatNumber(completedOnDate)} case(s) were completed on this date. Completed volume may include cases opened earlier.`;
    }

    const viewCases = document.getElementById('smartTrendModalViewCases');
    if (viewCases) {
      viewCases.href = `trend_detail.php?date=${encodeURIComponent(isoDate)}&series=${encodeURIComponent(series)}`;
    }

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
  }


  function computeTrendAxisRange(seriesCollection) {
    const values = seriesCollection
      .flat()
      .map(value => Number(value))
      .filter(value => Number.isFinite(value));

    if (!values.length) {
      return { beginAtZero: true, ticks: { precision: 0 } };
    }

    const minValue = Math.min(...values);
    const maxValue = Math.max(...values);
    const spread = Math.max(1, maxValue - minValue);
    const padding = Math.max(2, Math.ceil(spread * 0.25));
    const roundedMin = Math.max(0, Math.floor((minValue - padding) / 5) * 5);
    const roundedMax = Math.ceil((maxValue + padding) / 5) * 5;

    return {
      min: roundedMin,
      max: roundedMax,
      ticks: { precision: 0 }
    };
  }

  function renderDashboard(tickets) {
    const { referenceDate, days, enriched } = buildSevenDayCohorts(tickets);
    const firstDay = days[0];
    const lastDay = days[days.length - 1];
    const sevenDayTickets = enriched.filter(ticket => ticket.analysisDate
      && ticket.analysisDate >= firstDay
      && ticket.analysisDate <= lastDay);
    const activeSevenDay = sevenDayTickets.filter(ticket => !isCompleted(ticket));
    const active = tickets.filter(ticket => !isCompleted(ticket));
    const todayCount = sevenDayTickets.filter(ticket => sameDay(ticket.analysisDate, referenceDate)).length;
    const hitl = tickets.filter(isHitlRequired).length;
    const noHitl = Math.max(0, tickets.length - hitl);

    setText('smTotalComplaint', formatNumber(sevenDayTickets.length));
    setText('smUnsolvedComplaint', formatNumber(activeSevenDay.length));
    setText('smNewComplaintToday', formatNumber(todayCount));
    setText('hitlRequiredCount', formatNumber(hitl));
    setText('noHitlCount', formatNumber(noHitl));
    setText('hitlRequiredPercent', `${percent(hitl, tickets.length)}% of total tickets`);
    setText('noHitlPercent', `${percent(noHitl, tickets.length)}% of total tickets`);

    // Pass all tickets so completions inside the seven-day window are counted
    // even when the complaint itself was received before the window began.
    renderTrendChart(enriched, days);
    renderAssetChart(active);
    renderAgingChart(active, referenceDate);
  }

  function renderTrendChart(tickets, days) {
    const canvas = document.getElementById('smTrendChart');
    if (!canvas || typeof Chart === 'undefined') return;

    // Use immutable event dates instead of the ticket's latest status. This
    // prevents a historical daily count from disappearing after completion.
    const totalByDay = days.map(day => tickets.filter(ticket => sameDay(ticket.analysisDate, day)).length);
    const completedByDay = days.map(day => tickets.filter(ticket => sameDay(completionEventDate(ticket), day)).length);
    const openFromIntakeByDay = days.map(day => tickets.filter(ticket => sameDay(ticket.analysisDate, day) && !isCompleted(ticket)).length);
    const sameDayCompletedByDay = days.map(day => tickets.filter(ticket => sameDay(ticket.analysisDate, day) && sameDay(completionEventDate(ticket), day)).length);
    const yScale = computeTrendAxisRange([totalByDay, completedByDay]);

    new Chart(canvas, {
      type: 'line',
      plugins: [valueLabelPlugin()],
      data: {
        labels: days.map(formatDate),
        datasets: [
          { label: 'Total Complaints', data: totalByDay, borderColor: COLORS.blue, backgroundColor: COLORS.blue, tension: .35, pointRadius: 6, pointHoverRadius: 9, pointHitRadius: 18, borderWidth: 3 },
          { label: 'Completed Cases', data: completedByDay, borderColor: COLORS.green, backgroundColor: COLORS.green, tension: .35, pointRadius: 6, pointHoverRadius: 9, pointHitRadius: 18, borderWidth: 3 }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false, axis: 'x' },
        onHover(event, elements, chart) {
          const points = chart.getElementsAtEventForMode(event, 'index', { intersect: false, axis: 'x' }, true);
          event.native.target.style.cursor = points.length ? 'pointer' : 'default';
        },
        onClick(event, elements, chart) {
          const points = chart.getElementsAtEventForMode(event, 'index', { intersect: false, axis: 'x' }, true);
          if (!points.length) return;
          const index = points[0].index;
          const nearestPoint = chart.getElementsAtEventForMode(event, 'nearest', { intersect: false, axis: 'xy' }, true)[0] || points[0];
          const series = nearestPoint.datasetIndex === 1 ? 'completed' : 'complaints';
          openSmartTrendModal(
            formatDate(days[index]),
            totalByDay[index],
            completedByDay[index],
            openFromIntakeByDay[index],
            sameDayCompletedByDay[index],
            toISODate(days[index]),
            series
          );
        },
        layout: { padding: { top: 18, right: 26, left: 10, bottom: 0 } },
        plugins: { legend: { position: 'bottom', labels: { padding: 6, boxWidth: 20, boxHeight: 3, usePointStyle: true, pointStyle: 'line' } }, tooltip: { enabled: false } },
        scales: { y: yScale, x: { offset: true, grid: { display: false } } }
      }
    });
  }

  function renderAssetChart(tickets) {
    const canvas = document.getElementById('smAssetChart');
    if (!canvas || typeof Chart === 'undefined') return;
    const counts = countBy(tickets, ticket => ticket.asset);
    const entries = Object.entries(counts).sort((a, b) => b[1] - a[1]);

    new Chart(canvas, {
      type: 'bar',
      plugins: [valueLabelPlugin()],
      data: { labels: entries.map(entry => entry[0]), datasets: [{ label: 'Open cases', data: entries.map(entry => entry[1]), backgroundColor: COLORS.blue, borderRadius: 8 }] },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        onHover(event, elements) { event.native.target.style.cursor = elements.length ? 'pointer' : 'default'; },
        onClick(event, elements, chart) {
          elements = clickedElements(chart, event, elements);
          if (!elements.length) return;
          const asset = entries[elements[0].index][0];
          window.location.href = `asset_detail.php?asset=${encodeURIComponent(asset)}`;
        },
        layout: { padding: { top: 22, right: 30, left: 8, bottom: 8 } },
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grace: '16%', ticks: { precision: 0 } }, x: { grid: { display: false }, ticks: { minRotation: 0, maxRotation: 0, autoSkip: false, font: { size: 9 }, padding: 4 } } }
      }
    });
  }

  function getWaitHours(ticket, referenceDate) {
    if (!ticket.createdDate) return 0;
    return Math.max(0, Math.round((referenceDate.getTime() - ticket.createdDate.getTime()) / 3600000));
  }

  function getAgingBucket(hours) {
    if (hours <= 4) return '0–4 hours';
    if (hours <= 24) return '4–24 hours';
    if (hours <= 72) return '1–3 days';
    return 'More than 3 days';
  }

  function renderAgingChart(tickets, referenceDate) {
    const canvas = document.getElementById('smAgingChart');
    if (!canvas || typeof Chart === 'undefined') return;
    const labels = ['0–4 hours', '4–24 hours', '1–3 days', 'More than 3 days'];
    const counts = Object.fromEntries(labels.map(label => [label, 0]));
    tickets.forEach(ticket => { counts[getAgingBucket(getWaitHours(ticket, referenceDate))] += 1; });

    new Chart(canvas, {
      type: 'bar',
      plugins: [valueLabelPlugin()],
      data: { labels, datasets: [{ label: 'Unresolved complaints', data: labels.map(label => counts[label]), backgroundColor: '#4f8fe8', borderRadius: 8 }] },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        onHover(event, elements) { event.native.target.style.cursor = elements.length ? 'pointer' : 'default'; },
        onClick(event, elements, chart) {
          elements = clickedElements(chart, event, elements);
          if (!elements.length) return;
          const bucket = labels[elements[0].index];
          window.location.href = `aging_detail.php?bucket=${encodeURIComponent(bucket)}`;
        },
        layout: { padding: { top: 22, right: 30, left: 8, bottom: 8 } },
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grace: '16%', ticks: { precision: 0 } }, x: { grid: { display: false } } }
      }
    });
  }

  function renderTrendDetail(tickets) {
    const params = new URLSearchParams(window.location.search);
    const dateValue = params.get('date');
    const selectedSeries = params.get('series') || 'complaints';
    const selectedDate = dateValue ? parseDate(`${dateValue}T00:00:00`) : getReferenceDate(tickets);
    const { enriched } = buildSevenDayCohorts(tickets);

    const received = enriched.filter(ticket => sameDay(ticket.analysisDate, selectedDate));
    const completedOnDate = enriched.filter(ticket => sameDay(completionEventDate(ticket), selectedDate));
    const currentlyOpenFromIntake = received.filter(ticket => !isCompleted(ticket));
    const displayedCases = selectedSeries === 'completed' ? completedOnDate : received;

    const selectedLabel = selectedSeries === 'completed'
      ? 'Completed point selected — showing all cases completed on this date, including earlier complaints.'
      : 'Complaint point selected — showing all complaints received on this date, regardless of current status.';
    setText('detailPageTitle', `${formatDate(selectedDate)} Daily Complaint Activity`);
    setText('detailPageSubtitle', selectedLabel);
    setText('detailTotalCases', formatNumber(received.length));
    setText('detailCompletedCases', formatNumber(completedOnDate.length));
    setText('detailUnsolvedCases', formatNumber(currentlyOpenFromIntake.length));
    setText('detailCaseListTitle', selectedSeries === 'completed' ? 'Cases Completed on Selected Date' : 'Complaints Received on Selected Date');
    initCaseTable(displayedCases, { showAsset: true, showWaiting: false });
  }

  function renderAssetDetail(tickets) {
    const params = new URLSearchParams(window.location.search);
    const asset = cleanAssetLabel(params.get('asset') || 'Unknown');
    const openCases = tickets.filter(ticket => !isCompleted(ticket) && ticket.asset.toLowerCase() === asset.toLowerCase());
    setText('detailPageTitle', `${asset} Open Case Summary`);
    setText('detailPageSubtitle', 'Unresolved cases grouped into component categories.');
    setText('assetTotal', formatNumber(openCases.length));
    setText('assetHigh', formatNumber(openCases.filter(ticket => ticket.severity === 'High').length));
    setText('assetMedium', formatNumber(openCases.filter(ticket => ticket.severity === 'Medium').length));
    setText('assetLow', formatNumber(openCases.filter(ticket => ticket.severity === 'Low').length));

    const body = document.getElementById('assetComponentBody');
    if (!body) return;
    const summary = {};
    openCases.forEach(ticket => {
      const key = ticket.component || 'Unknown';
      if (!summary[key]) summary[key] = { component: key, total: 0, high: 0, medium: 0, low: 0 };
      summary[key].total += 1;
      if (ticket.severity === 'High') summary[key].high += 1;
      else if (ticket.severity === 'Medium') summary[key].medium += 1;
      else summary[key].low += 1;
    });
    const rows = Object.values(summary).sort((a, b) => b.total - a.total);
    body.innerHTML = rows.length ? rows.map(row => `<tr><td><strong>${escapeHtml(row.component)}</strong></td><td>${formatNumber(row.total)}</td><td>${formatNumber(row.high)}</td><td>${formatNumber(row.medium)}</td><td>${formatNumber(row.low)}</td><td><a class="review-btn" href="component_cases.php?asset=${encodeURIComponent(asset)}&component=${encodeURIComponent(row.component)}">View Cases</a></td></tr>`).join('') : '<tr><td colspan="6" class="empty-table-message">No component records found.</td></tr>';
  }

  function renderComponentCases(tickets) {
    const params = new URLSearchParams(window.location.search);
    const asset = cleanAssetLabel(params.get('asset') || 'Unknown');
    const component = cleanComponentLabel(params.get('component') || 'Unknown');
    const selected = tickets.filter(ticket => !isCompleted(ticket) && ticket.asset.toLowerCase() === asset.toLowerCase() && ticket.component.toLowerCase() === component.toLowerCase());
    setText('detailPageTitle', `${component} Case Records`);
    setText('detailPageSubtitle', `${asset} cases filtered by the selected component.`);
    setText('componentTotal', formatNumber(selected.length));
    setText('componentHigh', formatNumber(selected.filter(ticket => ticket.severity === 'High').length));
    setText('componentMedium', formatNumber(selected.filter(ticket => ticket.severity === 'Medium').length));
    setText('componentLow', formatNumber(selected.filter(ticket => ticket.severity === 'Low').length));
    initCaseTable(selected, { showAsset: false, showWaiting: false });
  }

  function renderAgingDetail(tickets) {
    const params = new URLSearchParams(window.location.search);
    const bucket = params.get('bucket') || '0–4 hours';
    const active = tickets.filter(ticket => !isCompleted(ticket));
    const referenceDate = getReferenceDate(tickets);
    const selected = active.map(ticket => ({ ...ticket, waitingHours: getWaitHours(ticket, referenceDate) })).filter(ticket => getAgingBucket(ticket.waitingHours) === bucket);

    setText('detailPageTitle', `${bucket} Unresolved Complaint Summary`);
    setText('detailPageSubtitle', 'All unresolved cases within the selected waiting-time group.');
    setText('agingTotal', formatNumber(selected.length));
    setText('agingHigh', formatNumber(selected.filter(ticket => ticket.severity === 'High').length));
    setText('agingAverage', `${selected.length ? Math.round(selected.reduce((sum, ticket) => sum + ticket.waitingHours, 0) / selected.length) : 0}h`);
    setText('agingBreached', formatNumber(selected.filter(ticket => /breach/i.test(ticket.slaStatus) || ticket.waitingHours > 90).length));
    initCaseTable(selected, { showAsset: true, showWaiting: true });
  }

  function initCaseTable(sourceRows, options) {
    const body = document.getElementById('detailCaseBody');
    const search = document.getElementById('detailSearch');
    const reset = document.getElementById('detailReset');
    if (!body) return;
    let rows = [...sourceRows];

    const render = () => {
      const query = String(search?.value || '').trim().toLowerCase();
      const filtered = query ? rows.filter(ticket => [ticket.caseId, ticket.room, ticket.asset, ticket.component, ticket.cleanedComment, ticket.status].join(' ').toLowerCase().includes(query)) : rows;
      setText('detailRecordCount', `Showing ${formatNumber(filtered.length)} record(s)`);
      if (!filtered.length) {
        const columnCount = options.showAsset ? 8 : 7;
        body.innerHTML = `<tr><td colspan="${columnCount}" class="empty-table-message">No matching records found.</td></tr>`;
        return;
      }
      body.innerHTML = filtered.map(ticket => caseRow(ticket, options)).join('');
      body.querySelectorAll('[data-review-case]').forEach(button => button.addEventListener('click', () => {
        const ticket = rows.find(item => item.caseId === button.dataset.reviewCase);
        if (ticket) openCaseModal(ticket);
      }));
    };

    search?.addEventListener('input', render);
    reset?.addEventListener('click', () => { if (search) search.value = ''; render(); });
    render();
    initModalClose();
  }

  function caseRow(ticket, options) {
    const columns = [`<td>${escapeHtml(ticket.caseId || '-')}</td>`, `<td>${escapeHtml(ticket.room || '-')}</td>`];
    if (options.showAsset) columns.push(`<td>${escapeHtml(ticket.asset || '-')}</td>`);
    columns.push(`<td>${escapeHtml(ticket.component || '-')}</td>`);
    columns.push(`<td><span class="severity-badge severity-${ticket.severity.toLowerCase()}">${escapeHtml(ticket.severity)}</span></td>`);
    columns.push(`<td>${escapeHtml(ticket.priority || '-')}</td>`);
    if (options.showWaiting) columns.push(`<td>${formatWaiting(ticket.waitingHours)}</td>`);
    else columns.push(`<td><span class="status-badge ${statusClass(ticket.status)}">${escapeHtml(ticket.status)}</span></td>`);
    columns.push(`<td><button class="review-btn" type="button" data-review-case="${escapeHtml(ticket.caseId)}">Review</button></td>`);
    return `<tr>${columns.join('')}</tr>`;
  }

  function statusClass(status) {
    if (status === 'Completed') return 'status-completed';
    if (status === 'Assigned') return 'status-assigned';
    if (status === 'In Progress') return 'status-progress';
    return 'status-pending';
  }

  function formatWaiting(hours) {
    if (hours < 24) return `${hours}h`;
    const days = Math.floor(hours / 24);
    const remainder = hours % 24;
    return remainder ? `${days}d ${remainder}h` : `${days}d`;
  }

  function openCaseModal(ticket) {
    const modal = document.getElementById('caseModal');
    const content = document.getElementById('caseModalContent');
    if (!modal || !content) return;
    setText('caseModalTitle', `${ticket.caseId} Case Details`);
    const fields = [
      ['Room', ticket.room], ['Complaint Timestamp', ticket.createdRaw || '-'], ['Hotel Asset', ticket.asset], ['Component', ticket.component],
      ['Severity', ticket.severity], ['Priority', ticket.priority], ['Status', ticket.status], ['Safety', ticket.safety], ['SLA', ticket.sla],
      ['HITL Required', isHitlRequired(ticket) ? 'Yes' : 'No'], ['Failure Mode', ticket.failureMode],
      ['Complaint / Cleaned Comment', ticket.cleanedComment, true], ['Observed Symptom', ticket.observedSymptoms, true],
      ['Possible Root Cause', ticket.possibleRootCause, true], ['Corrective Action', ticket.correctiveAction, true],
      ['Preventive Maintenance', ticket.preventiveMaintenance, true]
    ];
    content.innerHTML = fields.map(([label, value, full]) => `<div class="case-detail-item${full ? ' full' : ''}"><span>${escapeHtml(label)}</span><strong>${escapeHtml(value || '-')}</strong></div>`).join('');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function initModalClose() {
    const modal = document.getElementById('caseModal');
    const close = document.getElementById('caseModalClose');
    if (!modal || modal.dataset.ready === '1') return;
    modal.dataset.ready = '1';
    const hide = () => { modal.classList.remove('is-open'); modal.setAttribute('aria-hidden', 'true'); document.body.style.overflow = ''; };
    close?.addEventListener('click', hide);
    modal.addEventListener('click', event => { if (event.target === modal) hide(); });
    document.addEventListener('keydown', event => { if (event.key === 'Escape') hide(); });
  }

  function countBy(items, keyFn) {
    return items.reduce((result, item) => {
      const key = keyFn(item) || 'Unknown';
      result[key] = (result[key] || 0) + 1;
      return result;
    }, {});
  }

  function percent(value, total) { return total ? ((value / total) * 100).toFixed(1) : '0.0'; }
  function setText(id, value) { const element = document.getElementById(id); if (element) element.textContent = value; }
  function escapeHtml(value) {
    return String(value ?? '')
      .replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;').replaceAll("'", '&#039;');
  }
})();
