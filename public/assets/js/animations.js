/* ============================================================
   Nepal News Australia — Animation Controller
   Pure Vanilla JS, zero dependencies.
   Runs after DOM is ready. Progressive enhancement:
   all animations are additive — the page looks fine without JS.
   ============================================================ */

(function () {
  'use strict';

  /* ─── helpers ─────────────────────────────────────────── */
  const qs  = (s, ctx = document) => ctx.querySelector(s);
  const qsa = (s, ctx = document) => [...ctx.querySelectorAll(s)];
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ================================================================
     1. SCROLL PROGRESS BAR
  ================================================================ */
  function initScrollProgress() {
    const bar = qs('#scroll-progress');
    if (!bar) return;
    const update = () => {
      const h = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.width = h > 0 ? (window.scrollY / h * 100) + '%' : '0%';
    };
    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  /* ================================================================
     2. SCROLL REVEAL (IntersectionObserver)
     Adds .anim-el + direction class via JS only (progressive enhancement).
     Elements already in viewport on load get .in-view immediately.
  ================================================================ */
  function initScrollReveal() {
    if (prefersReduced) return;

    const rules = [
      { sel: '.news-card',      dir: 'anim-up',    stagger: true  },
      { sel: '.list-card',      dir: 'anim-left',  stagger: true  },
      { sel: '.event-card',     dir: 'anim-up',    stagger: true  },
      { sel: '.opinion-card',   dir: 'anim-up',    stagger: true  },
      { sel: '.ev-full-card',   dir: 'anim-up',    stagger: true  },
      { sel: '.widget',         dir: 'anim-right', stagger: false },
      { sel: '.section-header', dir: 'anim-left',  stagger: false },
      { sel: '.stat-box',       dir: 'anim-up',    stagger: true  },
      { sel: '.related-item',   dir: 'anim-left',  stagger: true  },
      { sel: '.footer-brand',   dir: 'anim-up',    stagger: false },
      { sel: '.footer-col',     dir: 'anim-up',    stagger: true  },
      { sel: '.page-header',    dir: 'anim-up',    stagger: false },
      { sel: '.table-card',     dir: 'anim-up',    stagger: true  },
      { sel: '.event-submit-form', dir: 'anim-up', stagger: false },
      { sel: '.nepali-date-widget', dir: 'anim-scale', stagger: false },
    ];

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          // Small timeout so CSS transition has time to apply initial state
          requestAnimationFrame(() => entry.target.classList.add('in-view'));
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

    rules.forEach(({ sel, dir, stagger }) => {
      let idx = 0;
      qsa(sel).forEach(el => {
        if (el.classList.contains('anim-el')) return; // already processed
        el.classList.add('anim-el', dir);
        if (stagger && idx < 6) el.dataset.delay = idx + 1;
        idx++;

        // If already in viewport on load, reveal with a small entrance delay
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.98 && rect.bottom > 0) {
          setTimeout(() => {
            requestAnimationFrame(() => el.classList.add('in-view'));
          }, stagger ? idx * 60 : 0);
        } else {
          observer.observe(el);
        }
      });
    });
  }

  /* ================================================================
     3. PAGE TRANSITION
  ================================================================ */
  function initPageTransition() {
    const overlay = qs('#page-transition');
    if (!overlay || prefersReduced) return;

    qsa('a[href]').forEach(link => {
      const href = link.getAttribute('href');
      if (!href) return;
      if (href.startsWith('#'))        return;
      if (href.startsWith('http'))     return;
      if (href.startsWith('mailto'))   return;
      if (href.startsWith('tel'))      return;
      if (link.target === '_blank')    return;
      if (link.closest('form'))        return;
      if (link.hasAttribute('data-no-transition')) return;

      link.addEventListener('click', e => {
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        const url = link.href;
        if (url === window.location.href) return;
        e.preventDefault();
        overlay.classList.add('active');
        setTimeout(() => { window.location.href = url; }, 210);
      });
    });
  }

  /* ================================================================
     4. BUTTON RIPPLE EFFECT
  ================================================================ */
  function initRipple() {
    const sel = '.btn-primary, .btn-secondary, .btn-success, .btn-danger, .widget-btn, .share-btn, .cat-tab, .cat-pill';
    document.addEventListener('click', e => {
      const btn = e.target.closest(sel);
      if (!btn) return;
      const rect = btn.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const r = document.createElement('span');
      r.className = 'ripple';
      r.style.cssText = `width:${size}px;height:${size}px;top:${e.clientY - rect.top - size / 2}px;left:${e.clientX - rect.left - size / 2}px`;
      btn.appendChild(r);
      setTimeout(() => r.remove(), 600);
    });
  }

  /* ================================================================
     5. HEADER SHADOW ON SCROLL
  ================================================================ */
  function initHeaderScroll() {
    const header = qs('.site-header');
    if (!header) return;
    const update = () => header.classList.toggle('scrolled', window.scrollY > 50);
    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  /* ================================================================
     6. HERO PARALLAX (subtle scroll shift on hero section)
  ================================================================ */
  function initHeroParallax() {
    const hero = qs('.hero-section');
    if (!hero || prefersReduced) return;
    const overlays = qsa('.hero-overlay', hero);
    window.addEventListener('scroll', () => {
      const scrolled = window.scrollY;
      if (scrolled > window.innerHeight) return; // only while hero visible
      const shift = scrolled * 0.18;
      overlays.forEach(ov => {
        ov.style.transform = `translateY(${shift}px)`;
      });
    }, { passive: true });
  }

  /* ================================================================
     7. IMAGE LAZY FADE-IN
  ================================================================ */
  function initImageFade() {
    qsa('img').forEach(img => {
      if (img.classList.contains('img-processed')) return;
      img.classList.add('img-processed');
      const reveal = () => img.classList.add('img-loaded');
      if (img.complete && img.naturalWidth > 0) {
        reveal();
      } else {
        img.addEventListener('load', reveal);
        img.addEventListener('error', reveal); // show even if broken
      }
    });
  }

  /* ================================================================
     8. SMOOTH CATEGORY FILTER (overrides main.js version)
  ================================================================ */
  function initCategoryFilter() {
    const tabs  = qsa('.cat-tab');
    const grid  = qs('#latestGrid');
    if (!tabs.length || !grid) return;

    // Remove old listeners by cloning each tab
    tabs.forEach(tab => {
      const clone = tab.cloneNode(true);
      tab.parentNode.replaceChild(clone, tab);
    });

    const freshTabs  = qsa('.cat-tab');
    const cards      = qsa('#latestGrid .news-card');

    freshTabs.forEach(tab => {
      tab.addEventListener('click', function () {
        freshTabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        const cat = this.dataset.cat;

        cards.forEach((card, i) => {
          const matches = cat === 'all' || card.dataset.cat === cat;
          if (!matches) {
            card.classList.add('cat-hiding');
            setTimeout(() => {
              card.style.display = 'none';
              card.classList.remove('cat-hiding');
            }, 260);
          } else {
            card.style.display = 'flex';
            card.classList.remove('cat-hiding');
            // Re-trigger entrance for visible cards
            card.classList.remove('in-view');
            setTimeout(() => {
              requestAnimationFrame(() => card.classList.add('in-view'));
            }, i * 45);
          }
        });
      });
    });
  }

  /* ================================================================
     9. NUMBER COUNTER ANIMATION
  ================================================================ */
  function countUp(el, target, duration) {
    const start = performance.now();
    const step = ts => {
      const p = Math.min((ts - start) / duration, 1);
      const ease = 1 - Math.pow(1 - p, 3); // cubic-out
      const val = Math.floor(target * ease);
      el.textContent = val.toLocaleString();
      if (p < 1) requestAnimationFrame(step);
      else el.textContent = target.toLocaleString();
    };
    requestAnimationFrame(step);
  }

  function initCounters() {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const raw = el.textContent.replace(/,/g, '').replace(/[^\d]/g, '');
        const num = parseInt(raw, 10);
        if (!isNaN(num) && num > 1) countUp(el, num, 1200);
        observer.unobserve(el);
      });
    }, { threshold: 0.6 });

    qsa('.stat-val').forEach(el => observer.observe(el));
  }

  /* ================================================================
     10. GURU CHAT — SPRING OPEN/CLOSE ANIMATION
  ================================================================ */
  function initGuruAnimation() {
    const win    = qs('#guru-window');
    const toggle = qs('#guru-toggle');
    if (!win) return;

    // Start in closed state (hidden with CSS class)
    win.classList.add('guru-closed');

    // Override the toggleGuru function defined in the blade template
    const origToggle = window.toggleGuru;
    window.toggleGuru = function () {
      const isOpen = !win.classList.contains('guru-closed');
      if (isOpen) {
        // Close
        win.classList.remove('guru-open');
        win.classList.add('guru-closed');
        toggle && toggle.classList.remove('guru-open-state');
        window.guruOpen = false;
      } else {
        // Open
        win.classList.remove('guru-closed');
        win.classList.add('guru-open');
        toggle && toggle.classList.add('guru-open-state');
        window.guruOpen = true;
        // Show welcome message if first open
        const msgs = qs('#guru-messages');
        if (msgs && msgs.children.length === 0 && typeof addMsg === 'function') {
          addMsg('नमस्ते! I\'m Guru 🙏 Your AI assistant for Nepal News Australia.<br><br>Ask me to <b>summarise an article</b>, <b>translate</b> something, or anything about <b>Nepal & Australia</b>!', 'bot');
        }
        const input = qs('#guru-input');
        if (input) setTimeout(() => input.focus(), 350);
      }
    };
  }

  /* ================================================================
     11. TICKER SEAMLESS LOOP (duplicate content)
  ================================================================ */
  function initTicker() {
    const ticker = qs('.ticker-text');
    if (!ticker) return;
    // Duplicate the inner HTML for a seamless loop
    ticker.innerHTML += ticker.innerHTML;
    // Adjust animation duration based on content width
    const w = ticker.scrollWidth / 2;
    const dur = Math.max(20, w / 80); // px/s
    ticker.style.animationDuration = dur + 's';
  }

  /* ================================================================
     12. STAGGER TRENDING ITEMS (on load)
  ================================================================ */
  function initTrendingStagger() {
    qsa('.trending-list li').forEach((li, i) => {
      li.style.transitionDelay = (i * 0.04) + 's';
    });
  }

  /* ================================================================
     13. SMOOTH SAME-PAGE SCROLL (#anchor links)
  ================================================================ */
  function initAnchorScroll() {
    qsa('a[href^="#"]').forEach(a => {
      a.addEventListener('click', e => {
        const target = qs(a.getAttribute('href'));
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  /* ================================================================
     14. MOBILE MENU — animated overlay
  ================================================================ */
  function initMobileMenuAnim() {
    const overlay = qs('#mobileOverlay');
    const menu    = qs('#mobileMenu');
    if (!overlay || !menu) return;
    // Patch visibility — ensure overlay fades in/out properly
    const observer = new MutationObserver(() => {
      if (overlay.classList.contains('open')) {
        overlay.style.display = 'block';
      } else {
        // Let CSS transition finish before display:none
        setTimeout(() => { if (!overlay.classList.contains('open')) overlay.style.display = ''; }, 300);
      }
    });
    observer.observe(overlay, { attributes: true, attributeFilter: ['class'] });
  }

  /* ================================================================
     15. ACTIVE NAV LINK HIGHLIGHT (immediate visual feedback)
  ================================================================ */
  function initNavHighlight() {
    qsa('.nav-inner a, .mobile-menu-item').forEach(a => {
      a.addEventListener('mousedown', function () {
        this.style.opacity = '0.7';
        setTimeout(() => this.style.opacity = '', 200);
      });
    });
  }

  /* ================================================================
     16. BREAKING NEWS PULSE DOT
  ================================================================ */
  function initBreakingPulse() {
    const label = qs('.breaking-label');
    if (!label) return;
    const dot = document.createElement('span');
    dot.className = 'pulse-dot';
    label.prepend(dot);
  }

  /* ================================================================
     17. ARTICLE READING PROGRESS (inner bar for article page)
  ================================================================ */
  function initArticleProgress() {
    const article = qs('.article-content');
    if (!article) return;
    const bar = qs('#scroll-progress');
    if (!bar) return;
    // Already handled by global scroll progress, no extra work needed
  }

  /* ================================================================
     INIT ALL
  ================================================================ */
  function init() {
    initScrollProgress();
    initScrollReveal();
    initPageTransition();
    initRipple();
    initHeaderScroll();
    initHeroParallax();
    initImageFade();
    initCategoryFilter();
    initCounters();
    initGuruAnimation();
    initTicker();
    initTrendingStagger();
    initAnchorScroll();
    initMobileMenuAnim();
    initNavHighlight();
    initBreakingPulse();
    initArticleProgress();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
