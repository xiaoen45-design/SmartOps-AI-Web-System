(() => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    initProfileMenu();
    renderWorkforceCharts();
  });


  const valueLabelPlugin = {
      id: 'workforceValueLabels',
      afterDatasetsDraw(chart) {
        const { ctx, chartArea } = chart;
        if (!chartArea) return;
        const isLine = chart.config.type === 'line';
        const isHorizontal = chart.config.type === 'bar' && chart.options.indexAxis === 'y';
        const clamp = (v, min, max) => Math.max(min, Math.min(max, v));
        ctx.save();
        ctx.font = '700 12px Arial';
        ctx.textBaseline = 'middle';
        chart.data.datasets.forEach((dataset, datasetIndex) => {
          const meta = chart.getDatasetMeta(datasetIndex);
          if (meta.hidden) return;
          meta.data.forEach((element, index) => {
            const value = Number(dataset.data[index]);
            if (!Number.isFinite(value)) return;
            const point = element.getProps(['x','y'], true);
            const raw = dataset.borderColor || dataset.backgroundColor || '#111827';
            const color = Array.isArray(raw) ? raw[index % raw.length] : raw;
            const text = value.toLocaleString();
            const width = ctx.measureText(text).width;
            let x = point.x, y = point.y - 18, align = 'center';
            if (isHorizontal) { x = point.x + 9; y = point.y; align = 'left'; }
            else if (isLine) {
              if (chart.data.datasets.length === 2) {
                y = point.y - (datasetIndex === 0 ? 20 : 20);
              } else {
                if (datasetIndex === 0) y = point.y - 24;
                else if (datasetIndex === 1) y = point.y + 24;
                else { x = point.x + (index === chart.data.labels.length - 1 ? -22 : 22); y = point.y - 10; align = index === chart.data.labels.length - 1 ? 'right' : 'left'; }
              }
            }
            if (align === 'center') x = clamp(x, chartArea.left + width/2 + 4, chartArea.right - width/2 - 4);
            else if (align === 'left') x = clamp(x, chartArea.left + 4, chartArea.right - width - 4);
            else x = clamp(x, chartArea.left + width + 4, chartArea.right - 4);
            y = clamp(y, chartArea.top + 12, chartArea.bottom - 12);
            ctx.textAlign = align; ctx.fillStyle = color; ctx.fillText(text, x, y);
          });
        });
        ctx.restore();
      }
  };

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

  function openWithQuery(base, key, value) {
    if (!base || !value) return;
    window.location.href = `${base}?${key}=${encodeURIComponent(value)}`;
  }

  function renderWorkforceCharts() {
    const data = window.workforceDashboardData || {};
    const statusCanvas = document.getElementById('workOrderStatusChart');
    const capacityCanvas = document.getElementById('capacityWorkloadChart');
    const slaDepartmentCanvas = document.getElementById('slaDepartmentChart');
    if (!statusCanvas || typeof Chart === 'undefined') return;

    new Chart(statusCanvas, {
      plugins: [valueLabelPlugin],
      type: 'bar',
      data: {
        labels: data.statusLabels || [],
        datasets: [{
          label: 'Cases',
          data: data.statusValues || [],
          backgroundColor: '#2563eb',
          borderRadius: 8
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'nearest', intersect: false, axis: 'xy' },
        layout: { padding: { left: 8, right: 56, top: 18, bottom: 8 } },
        onHover: (event, elements) => {
          event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
        },
        onClick: (event, elements, chart) => {
          elements = clickedElements(chart, event, elements);
          if (!elements.length) return;
          const label = chart.data.labels[elements[0].index];
          openWithQuery(data.statusDetailUrl, 'status', label);
        },
        plugins: {
          legend: { display: false },
          tooltip: { callbacks: { afterLabel: () => 'Click to view hotel asset summary' } }
        },
        scales: {
          x: { beginAtZero: true, grace: '12%', ticks: { precision: 0 } },
          y: { grid: { display: false } }
        }
      }
    });

    if (capacityCanvas) {
      new Chart(capacityCanvas, {
        plugins: [valueLabelPlugin],
        type: 'bar',
        data: {
          labels: data.capacityLabels || [],
          datasets: [
            { label: 'Available Technicians', data: data.availableTech || [], backgroundColor: '#16a34a', borderRadius: 8 },
            { label: 'Assigned Workload', data: data.assignedTask || [], backgroundColor: '#2563eb', borderRadius: 8 }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'nearest', intersect: false, axis: 'xy' },
          layout: { padding: { left: 8, right: 28, top: 14, bottom: 0 } },
          onHover: (event, elements) => {
            event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
          },
          onClick: (event, elements, chart) => {
            elements = clickedElements(chart, event, elements);
            if (!elements.length) return;
            const label = chart.data.labels[elements[0].index];
            openWithQuery(data.capacityDetailUrl, 'group', label);
          },
          plugins: {
            legend: {
              position: 'bottom',
              align: 'center',
              labels: {
                boxWidth: 18,
                boxHeight: 8,
                padding: 10,
                font: { size: 11, weight: '600' }
              }
            },
            tooltip: { callbacks: { afterBody: () => 'Click to inspect related workload cases.' } }
          },
          scales: {
            y: { beginAtZero: true, grace: '14%', ticks: { precision: 0 } },
            x: {
              grid: { display: false },
              ticks: {
                autoSkip: false,
                maxRotation: 0,
                minRotation: 0,
                callback(value) {
                  const label = this.getLabelForValue(value);
                  return label === 'Technical Specialist' ? ['Technical', 'Specialist'] : label;
                }
              }
            }
          }
        }
      });
    }

    if (slaDepartmentCanvas) {
      new Chart(slaDepartmentCanvas, {
        plugins: [valueLabelPlugin],
        type: 'bar',
        data: {
          labels: data.slaDepartmentLabels || [],
          datasets: [{
            label: 'SLA Breaches',
            data: data.slaDepartmentValues || [],
            backgroundColor: '#2563eb',
            borderRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'nearest', intersect: false, axis: 'xy' },
          layout: { padding: { left: 8, right: 28, top: 28, bottom: 12 } },
          onHover: (event, elements) => {
            event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
          },
          onClick: (event, elements, chart) => {
            elements = clickedElements(chart, event, elements);
            if (!elements.length) return;
            const label = chart.data.labels[elements[0].index];
            if (!data.slaDepartmentDetailUrl) return;
            const url = new URL(data.slaDepartmentDetailUrl, window.location.origin);
            url.searchParams.set('department', label);
            url.searchParams.set('scope', data.slaDepartmentScope || 'current');
            window.location.href = url.toString();
          },
          plugins: {
            legend: { display: false },
            tooltip: { callbacks: { afterLabel: () => 'Click to analyse breached work orders' } }
          },
          scales: {
            y: { beginAtZero: true, grace: '14%', ticks: { precision: 0 } },
            x: {
              grid: { display: false },
              ticks: {
                autoSkip: false,
                maxRotation: 0,
                minRotation: 0,
                callback(value) {
                  const label = this.getLabelForValue(value);
                  return label === 'Out of Knowledge Base' ? ['Out of Knowledge', 'Base'] : label;
                }
              }
            }
          }
        }
      });
    }
  }
})();
