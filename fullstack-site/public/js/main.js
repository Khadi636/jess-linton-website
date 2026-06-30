/* ============================================================
   JESS LINTON — main.js v3
   ============================================================ */

/* ── Scrolled header ──────────────────────────────────────── */
const header = document.getElementById('site-header');
if (header) {
  const check = () => header.classList.toggle('scrolled', window.scrollY > 40);
  window.addEventListener('scroll', check, { passive: true });
  check();
}

/* ── Mobile nav overlay ───────────────────────────────────── */
const navToggle = document.querySelector('.nav-toggle');
const mobileNav = document.getElementById('mobile-nav');

if (navToggle && mobileNav) {
  function openNav() {
    mobileNav.classList.add('open');
    navToggle.setAttribute('aria-expanded', 'true');
    mobileNav.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    /* move focus into overlay for keyboard/AT users */
    const firstLink = mobileNav.querySelector('a, button');
    if (firstLink) firstLink.focus();
  }
  function closeNav() {
    mobileNav.classList.remove('open');
    navToggle.setAttribute('aria-expanded', 'false');
    mobileNav.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    navToggle.focus();
  }

  navToggle.addEventListener('click', () => {
    mobileNav.classList.contains('open') ? closeNav() : openNav();
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && mobileNav.classList.contains('open')) closeNav();
  });
}

/* ── Scroll reveal (IntersectionObserver) ─────────────────── */
if ('IntersectionObserver' in window) {
  const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -32px 0px' });

  document.querySelectorAll('.reveal, .reveal-x, .reveal-scale').forEach(el => {
    revealObserver.observe(el);
  });
} else {
  /* Fallback: show all reveal elements immediately */
  document.querySelectorAll('.reveal, .reveal-x, .reveal-scale').forEach(el => {
    el.classList.add('in-view');
  });
}

/* ── Slideshow ────────────────────────────────────────────── */
function initSlideshow(container) {
  const slides = container.querySelectorAll('.hero-slide, .slideshow__slide');
  const dots   = container.querySelectorAll('.hero-dot, .slideshow__dot');
  if (slides.length < 2) return;

  let current = 0;
  let timer;

  function goTo(n) {
    slides[current].classList.remove('active');
    if (dots[current]) dots[current].classList.remove('active');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    if (dots[current]) dots[current].classList.add('active');
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => { clearInterval(timer); goTo(i); start(); });
  });

  function start() { timer = setInterval(() => goTo(current + 1), 5000); }
  start();
}

document.querySelectorAll('.hero, .slideshow').forEach(initSlideshow);

/* Ken Burns trigger */
const hero = document.querySelector('.hero');
if (hero) requestAnimationFrame(() => hero.classList.add('loaded'));

/* ── Gallery lightbox ─────────────────────────────────────── */
const lightbox = document.querySelector('.lightbox');
if (lightbox) {
  const lbImg     = document.getElementById('lightbox-img');
  const lbCaption = document.getElementById('lightbox-caption');
  const lbClose   = lightbox.querySelector('.lightbox__close');
  const lbPrev    = lightbox.querySelector('.lightbox__prev');
  const lbNext    = lightbox.querySelector('.lightbox__next');
  const items     = Array.from(document.querySelectorAll('.gallery-item'));
  let current     = 0;

  /* Focusable elements inside lightbox for focus trap */
  const focusables = [lbClose, lbPrev, lbNext].filter(Boolean);

  function open(index) {
    current = index;
    const img = items[index]?.querySelector('img');
    if (!img?.src) return;
    if (lbImg) {
      lbImg.src = img.src;
      lbImg.alt = img.alt || '';
    }
    if (lbCaption) lbCaption.textContent = items[index].dataset.title || img.alt || '';
    lightbox.classList.add('open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    lbClose?.focus();
  }

  function close() {
    lightbox.classList.remove('open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (lbImg) { lbImg.src = ''; lbImg.alt = ''; }
    /* Return focus to the gallery item that opened it */
    items[current]?.focus();
  }

  items.forEach((item, i) => {
    item.setAttribute('role', 'button');
    item.setAttribute('tabindex', '0');
    item.addEventListener('click', () => open(i));
    item.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(i); }
    });
  });

  lightbox.addEventListener('click', e => { if (e.target === lightbox) close(); });
  lbClose?.addEventListener('click', close);
  lbPrev?.addEventListener('click', e => { e.stopPropagation(); open((current - 1 + items.length) % items.length); });
  lbNext?.addEventListener('click', e => { e.stopPropagation(); open((current + 1) % items.length); });

  document.addEventListener('keydown', e => {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape')     { close(); return; }
    if (e.key === 'ArrowLeft')  { open((current - 1 + items.length) % items.length); return; }
    if (e.key === 'ArrowRight') { open((current + 1) % items.length); return; }
    /* Focus trap: Tab / Shift+Tab cycles within lightbox controls */
    if (e.key === 'Tab' && focusables.length) {
      const first = focusables[0];
      const last  = focusables[focusables.length - 1];
      if (e.shiftKey) {
        if (document.activeElement === first) { e.preventDefault(); last.focus(); }
      } else {
        if (document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    }
  });
}
