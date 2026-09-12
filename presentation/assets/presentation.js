(() => {
  const header = document.getElementById('siteHeader');
  const progress = document.getElementById('siteProgress');
  const navToggle = document.getElementById('navToggle');
  const nav = document.getElementById('siteNav');
  const navLinks = Array.from(document.querySelectorAll('.site-nav a'));
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const updateScrollUi = () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollable = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
    if (progress) progress.style.width = `${Math.min(100, (scrollTop / scrollable) * 100)}%`;
    if (header) header.classList.toggle('scrolled', scrollTop > 18);
  };

  updateScrollUi();
  window.addEventListener('scroll', updateScrollUi, { passive: true });
  window.addEventListener('resize', updateScrollUi);

  if (navToggle && nav) {
    navToggle.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    navLinks.forEach((link) => {
      link.addEventListener('click', () => {
        nav.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
      });
    });

    document.addEventListener('click', (event) => {
      if (!nav.classList.contains('open')) return;
      if (nav.contains(event.target) || navToggle.contains(event.target)) return;
      nav.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
    });
  }

  const revealItems = Array.from(document.querySelectorAll('.reveal'));
  if (reducedMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach((item) => item.classList.add('visible'));
  } else {
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -5% 0px' });
    revealItems.forEach((item) => revealObserver.observe(item));
  }

  // Keep the highlighted navigation item aligned with the section that is
  // currently displayed. The previous IntersectionObserver compared section
  // intersection ratios, which could leave Lifecycle highlighted after the
  // page had already reached Platform. This position-based scroll spy is more
  // reliable for sections with very different heights.
  const navTargets = navLinks
    .map((link) => {
      const href = link.getAttribute('href') || '';
      if (!href.startsWith('#')) return null;
      const id = decodeURIComponent(href.slice(1));
      const section = document.getElementById(id);
      return section ? { id, link, section } : null;
    })
    .filter(Boolean);

  let requestedNavId = null;
  let requestedNavExpiresAt = 0;

  const setActiveNav = (activeId) => {
    navLinks.forEach((link) => {
      const isActive = link.getAttribute('href') === `#${activeId}`;
      link.classList.toggle('active', isActive);
      if (isActive) link.setAttribute('aria-current', 'page');
      else link.removeAttribute('aria-current');
    });
  };

  const updateActiveNav = () => {
    if (!navTargets.length) return;

    const headerHeight = header ? header.getBoundingClientRect().height : 0;

    // After a navigation click, keep the selected item highlighted while the
    // browser performs the smooth scroll. Release the lock once the target is
    // under the fixed header or after a short safety timeout.
    if (requestedNavId) {
      const requestedTarget = navTargets.find((item) => item.id === requestedNavId);
      const reachedTarget = requestedTarget
        ? Math.abs(requestedTarget.section.getBoundingClientRect().top - headerHeight) < 120
        : true;

      if (!reachedTarget && Date.now() < requestedNavExpiresAt) {
        setActiveNav(requestedNavId);
        return;
      }

      requestedNavId = null;
      requestedNavExpiresAt = 0;
    }

    // Read the section slightly below the fixed header. Whichever linked
    // section has most recently crossed this marker becomes active.
    const marker = window.scrollY + headerHeight + Math.min(180, window.innerHeight * 0.22);
    let activeTarget = navTargets[0];

    navTargets.forEach((target) => {
      if (target.section.offsetTop <= marker) activeTarget = target;
    });

    // At the absolute bottom of the page, ensure the final linked section is
    // selected even when it is shorter than the viewport.
    const nearPageBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 4;
    if (nearPageBottom) activeTarget = navTargets[navTargets.length - 1];

    setActiveNav(activeTarget.id);
  };

  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      const href = link.getAttribute('href') || '';
      if (!href.startsWith('#')) return;
      requestedNavId = decodeURIComponent(href.slice(1));
      requestedNavExpiresAt = Date.now() + 1800;
      setActiveNav(requestedNavId);
    });
  });

  window.addEventListener('scroll', updateActiveNav, { passive: true });
  window.addEventListener('resize', updateActiveNav);
  window.addEventListener('hashchange', () => {
    const id = decodeURIComponent(window.location.hash.replace(/^#/, ''));
    if (navTargets.some((target) => target.id === id)) {
      requestedNavId = id;
      requestedNavExpiresAt = Date.now() + 1800;
      setActiveNav(id);
    }
  });

  updateActiveNav();



  const problemVideo = document.getElementById('problemVideo');
  const problemVideoStart = document.getElementById('problemVideoStart');

  if (problemVideo && problemVideoStart) {
    problemVideo.autoplay = false;
    problemVideo.loop = false;
    problemVideo.controls = false;
    problemVideo.playsInline = true;
    problemVideo.preload = 'metadata';
    problemVideo.removeAttribute('autoplay');
    problemVideo.removeAttribute('loop');
    problemVideo.removeAttribute('controls');
    problemVideo.pause();

    const showProblemVideoStart = () => {
      problemVideoStart.disabled = false;
      problemVideoStart.classList.remove('is-hidden');
    };

    problemVideoStart.addEventListener('click', () => {
      problemVideoStart.classList.add('is-hidden');
      problemVideoStart.disabled = true;
      problemVideo.pause();
      problemVideo.currentTime = 0;
      problemVideo.muted = false;
      problemVideo.volume = 1;

      const playAttempt = problemVideo.play();
      if (playAttempt && typeof playAttempt.catch === 'function') {
        playAttempt.catch(() => {
          problemVideo.pause();
          problemVideo.currentTime = 0;
          showProblemVideoStart();
        });
      }
    });

    problemVideo.addEventListener('ended', () => {
      problemVideo.pause();
      problemVideo.currentTime = 0;
      problemVideo.removeAttribute('controls');
      showProblemVideoStart();
    });

    problemVideo.addEventListener('error', showProblemVideoStart);
  }

  const solutionVideo = document.getElementById('solutionVideo');
  const caseSteps = Array.from(document.querySelectorAll('.case-step'));
  const caseDetails = Array.from(document.querySelectorAll('.case-detail'));
  let solutionAutoPlayed = false;

  const activateCaseStep = (index) => {
    caseSteps.forEach((step, stepIndex) => step.classList.toggle('active', stepIndex === index));
    caseDetails.forEach((detail, detailIndex) => detail.classList.toggle('active', detailIndex === index));
  };

  if (solutionVideo) {
    caseSteps.forEach((step, index) => {
      step.addEventListener('click', () => {
        const seek = Number(step.dataset.seek || 0);
        solutionVideo.currentTime = seek;
        activateCaseStep(index);
        solutionVideo.play().catch(() => {});
      });
    });

    solutionVideo.addEventListener('timeupdate', () => {
      const time = solutionVideo.currentTime;
      const index = time >= 10 ? 2 : time >= 6 ? 1 : 0;
      activateCaseStep(index);
    });

    solutionVideo.addEventListener('ended', () => activateCaseStep(2));

    if ('IntersectionObserver' in window) {
      const solutionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting || solutionAutoPlayed) return;
          solutionAutoPlayed = true;
          solutionVideo.currentTime = 0;
          solutionVideo.play().catch(() => {});
          observer.unobserve(entry.target);
        });
      }, { threshold: 0.55 });
      solutionObserver.observe(solutionVideo);
    }
  }

  const lifeInsight = document.getElementById('lifeInsight');
  const lifeButtons = Array.from(document.querySelectorAll('[data-life]'));
  lifeButtons.forEach((button) => {
    button.addEventListener('click', () => {
      lifeButtons.forEach((item) => item.classList.remove('active'));
      button.classList.add('active');
      if (lifeInsight) {
        const label = button.textContent.replace(/\s+/g, ' ').trim();
        lifeInsight.innerHTML = `<span>${escapeHtml(label)}</span><p>${escapeHtml(button.dataset.life || '')}</p>`;
      }
    });
  });

  const techTabs = Array.from(document.querySelectorAll('.tech-tab'));
  const techPanels = Array.from(document.querySelectorAll('.tech-panel'));

  const setTechTab = (tabName) => {
    techTabs.forEach((tab) => {
      const active = tab.dataset.tab === tabName;
      tab.classList.toggle('active', active);
      tab.setAttribute('aria-selected', String(active));
    });
    techPanels.forEach((panel) => panel.classList.toggle('active', panel.dataset.panel === tabName));
  };

  techTabs.forEach((tab) => tab.addEventListener('click', () => setTechTab(tab.dataset.tab)));

  const chapterButtons = Array.from(document.querySelectorAll('.chapter-button'));
  const chapterNodes = Array.from(document.querySelectorAll('.tech-node'));
  const chapterContents = Array.from(document.querySelectorAll('[data-chapter-content]'));
  const chapterGroups = Array.from(document.querySelectorAll('[data-chapter-group]'));
  const chapterSubButtons = Array.from(document.querySelectorAll('.chapter-subbutton'));

  const setChapterGroupExpanded = (group, expanded) => {
    if (!group) return;
    group.classList.toggle('expanded', expanded);
    const parent = group.querySelector('.chapter-parent');
    if (parent) parent.setAttribute('aria-expanded', String(expanded));
  };

  const getChapterContent = (chapterIndex) => chapterContents.find(
    (content) => content.dataset.chapterContent === String(chapterIndex)
  );

  const getChapterSubButtons = (chapterIndex) => chapterSubButtons.filter(
    (button) => (button.dataset.parentChapter || '0') === String(chapterIndex)
  );

  const getChapterSubsections = (chapterIndex) => getChapterSubButtons(chapterIndex)
    .map((button) => document.getElementById(button.dataset.subsection || ''))
    .filter(Boolean);

  const setActiveChapterSubbutton = (chapterIndex, sectionId = '') => {
    const buttons = getChapterSubButtons(chapterIndex);
    buttons.forEach((button, index) => {
      const active = sectionId
        ? button.dataset.subsection === sectionId
        : index === 0;
      button.classList.toggle('active', active);
    });
  };

  const pageScrollOffset = () => {
    const fixedHeader = header ? header.getBoundingClientRect().height : 0;
    return fixedHeader + 24;
  };

  const scrollToChapterElement = (element) => {
    if (!element) return;
    const top = window.scrollY + element.getBoundingClientRect().top - pageScrollOffset();
    window.scrollTo({
      top: Math.max(0, top),
      behavior: reducedMotion ? 'auto' : 'smooth'
    });
  };

  const setChapter = (
    chapterIndex,
    { scrollToPanel = false, scrollToChapter = false, activateFirstSubstage = true } = {}
  ) => {
    const index = String(chapterIndex);
    const activeGroup = chapterGroups.find((group) => group.dataset.chapterGroup === index);
    const activeChapter = getChapterContent(index);

    setTechTab('framework');
    chapterButtons.forEach((button) => button.classList.toggle('active', button.dataset.chapter === index));
    chapterNodes.forEach((node) => node.classList.toggle('active', node.dataset.chapter === index));
    chapterContents.forEach((content) => {
      const active = content.dataset.chapterContent === index;
      content.classList.toggle('active', active);
      content.hidden = !active;
      content.setAttribute('aria-hidden', String(!active));
    });

    chapterGroups.forEach((group) => {
      const active = group.dataset.chapterGroup === index;
      group.classList.toggle('active', active);
      setChapterGroupExpanded(group, active);
    });

    if (activateFirstSubstage && getChapterSubButtons(index).length) {
      setActiveChapterSubbutton(index);
    }

    if (scrollToPanel || scrollToChapter) {
      window.requestAnimationFrame(() => {
        if (scrollToPanel) {
          const panel = document.getElementById('frameworkPanel');
          scrollToChapterElement(panel);
          return;
        }

        const firstSubsection = getChapterSubsections(index)[0];
        scrollToChapterElement(firstSubsection || activeChapter);
      });
    }
  };

  chapterButtons.forEach((button) => button.addEventListener('click', () => {
    const index = button.dataset.chapter || '0';
    // Clicking a main stage opens its complete chapter. Stage 01 shows 1A then
    // 1B below it; Stage 02 shows 2A, 2B and 2C in the same vertical flow.
    setChapter(index, { scrollToChapter: true, activateFirstSubstage: true });
  }));

  chapterSubButtons.forEach((button) => button.addEventListener('click', () => {
    const parentChapter = button.dataset.parentChapter || '0';
    const sectionId = button.dataset.subsection || '';
    setChapter(parentChapter, { activateFirstSubstage: false });
    setActiveChapterSubbutton(parentChapter, sectionId);

    window.requestAnimationFrame(() => {
      scrollToChapterElement(document.getElementById(sectionId));
    });
  }));

  chapterNodes.forEach((node) => node.addEventListener('click', () => {
    const index = node.dataset.chapter || '0';
    setChapter(index, { scrollToPanel: true, activateFirstSubstage: true });
  }));

  // Retrieval output checkpoint: open Stage 03 / Gate 1.
  const gateLinks = Array.from(document.querySelectorAll('[data-go-to-chapter]'));
  gateLinks.forEach((button) => button.addEventListener('click', () => {
    const targetChapter = button.dataset.goToChapter || '2';
    setChapter(targetChapter, {
      scrollToChapter: true,
      activateFirstSubstage: true
    });
  }));

  // While the user scrolls from 1A → 1B or 2A → 2B → 2C, keep the matching
  // sub-stage highlighted in the left navigation without hiding the others.
  let chapterScrollFrame = 0;
  const updateChapterSubnavOnScroll = () => {
    chapterScrollFrame = 0;
    const activeChapter = chapterContents.find((content) => content.classList.contains('active'));
    if (!activeChapter) return;

    const index = activeChapter.dataset.chapterContent || '0';
    const subsections = getChapterSubsections(index);
    if (!subsections.length) return;

    const marker = pageScrollOffset() + Math.min(150, window.innerHeight * 0.2);
    let activeSection = subsections[0];

    subsections.forEach((section) => {
      if (section.getBoundingClientRect().top <= marker) activeSection = section;
    });

    setActiveChapterSubbutton(index, activeSection.id);
  };

  const queueChapterSubnavUpdate = () => {
    if (chapterScrollFrame) return;
    chapterScrollFrame = window.requestAnimationFrame(updateChapterSubnavOnScroll);
  };

  window.addEventListener('scroll', queueChapterSubnavUpdate, { passive: true });
  window.addEventListener('resize', queueChapterSubnavUpdate);

  // Start Stage 01 directly at 1A, with 1B immediately below for normal scrolling.
  setChapter('0', { activateFirstSubstage: true });
  queueChapterSubnavUpdate();

  const kbExplorers = Array.from(document.querySelectorAll('.kb-compact-explorer'));
  kbExplorers.forEach((explorer) => {
    const stageButtons = Array.from(explorer.querySelectorAll('[data-kb-stage]'));
    const stagePanels = Array.from(explorer.querySelectorAll('[data-kb-panel]'));

    const activateKbStage = (stageName, focusCard = false) => {
      stageButtons.forEach((button) => {
        const active = button.dataset.kbStage === stageName;
        button.classList.toggle('active', active);
        button.setAttribute('aria-selected', String(active));
        if (active && focusCard) button.focus({ preventScroll: true });
      });

      stagePanels.forEach((panel) => {
        const active = panel.dataset.kbPanel === stageName;
        panel.classList.toggle('active', active);
        panel.hidden = !active;
      });
    };

    stagePanels.forEach((panel, index) => {
      if (index >= stagePanels.length - 1 || panel.querySelector('.kb-next-stage')) return;
      const nextButton = stageButtons[index + 1];
      if (!nextButton) return;

      panel.classList.add('has-kb-next');
      const nextStage = nextButton.dataset.kbStage || '';
      const nextNumber = nextButton.querySelector('.kb-compact-number')?.textContent?.trim() || '';
      const nextTitle = nextButton.querySelector('strong')?.textContent?.trim() || 'Next stage';
      const control = document.createElement('button');
      control.type = 'button';
      control.className = 'kb-next-stage';
      control.dataset.kbNext = nextStage;
      control.innerHTML = `<span>NEXT STAGE</span><strong>${escapeHtml(nextNumber)} · ${escapeHtml(nextTitle)}</strong><i>→</i>`;
      panel.appendChild(control);
    });

    stageButtons.forEach((button) => {
      button.addEventListener('click', () => activateKbStage(button.dataset.kbStage || 'sources'));
    });

    explorer.querySelectorAll('[data-kb-next]').forEach((button) => {
      button.addEventListener('click', () => activateKbStage(button.dataset.kbNext || 'sources', true));
    });

    if (stageButtons[0]) activateKbStage(stageButtons[0].dataset.kbStage || 'sources');
  });

  const modal = document.getElementById('diagramModal');
  const modalImage = document.getElementById('diagramImage');
  const modalTitle = document.getElementById('diagramTitle');
  const modalClose = document.getElementById('diagramClose');
  const diagramButtons = Array.from(document.querySelectorAll('[data-diagram]'));

  const closeModal = () => {
    if (modal && modal.open) modal.close();
  };

  diagramButtons.forEach((button) => {
    button.addEventListener('click', () => {
      if (!modal || !modalImage || !modalTitle) return;
      const src = button.dataset.diagram || '';
      const title = button.dataset.title || 'Detailed diagram';
      modalImage.src = src;
      modalImage.alt = title;
      modalTitle.textContent = title;
      if (typeof modal.showModal === 'function') modal.showModal();
    });
  });

  if (modalClose) modalClose.addEventListener('click', closeModal);
  if (modal) {
    modal.addEventListener('click', (event) => {
      if (event.target === modal) closeModal();
    });
  }

  function escapeHtml(value) {
    return String(value)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#39;');
  }
})();
