/**
 * js/modules/scroll-reveal.js
 *
 * Reveals elements as they enter the viewport by adding .in-view,
 * which triggers CSS transitions defined in css/base/utilities.css:
 *   .reveal         — fade in + slide up from below
 *   .reveal-x       — fade in + slide in from the left
 *   .reveal-scale   — fade in + subtle scale from 98%
 *
 * Stagger delays (.d1–.d6) are applied in HTML for cascade effects.
 */

const SEL = '.reveal, .reveal-x, .reveal-scale';

function checkInView() {
  const vH = window.innerHeight;
  document.querySelectorAll(SEL + ':not(.in-view)').forEach(el => {
    const { top, bottom } = el.getBoundingClientRect();
    if (top < vH - 32 && bottom > 0) {
      el.classList.add('in-view');
    }
  });
}

/* Reveal elements already in the viewport after first paint. */
requestAnimationFrame(checkInView);

/* Reveal elements as they scroll into view. */
window.addEventListener('scroll', checkInView, { passive: true });
