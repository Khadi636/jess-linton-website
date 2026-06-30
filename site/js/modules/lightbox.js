/**
 * js/modules/lightbox.js
 *
 * Fullscreen image lightbox for the artwork gallery (artwork.html).
 *
 * Behaviour:
 * - Clicking (or pressing Enter/Space on) any .gallery-item opens
 *   the lightbox and displays its image at full size.
 * - Arrow buttons and keyboard arrow keys navigate between images.
 * - Close button, Escape key, or clicking the backdrop closes it.
 * - body scroll is locked while the lightbox is open.
 * - Focus is moved to the close button on open, and returned to
 *   the triggering gallery item on close (WCAG 2.1 §2.4.3).
 * - A focus trap keeps Tab cycling within the three lightbox
 *   controls (close, prev, next) while it is open.
 *
 * Markup required in HTML:
 *   <div class="lightbox" aria-hidden="true" role="dialog" ...>
 *     <div class="lightbox__img-wrap">
 *       <img id="lightbox-img" alt="">
 *     </div>
 *     <button class="lightbox__close">×</button>
 *     <button class="lightbox__prev">‹</button>
 *     <button class="lightbox__next">›</button>
 *     <p id="lightbox-caption" class="lightbox__caption"></p>
 *   </div>
 *
 *   <div class="gallery-item" data-title="Artwork title">
 *     <img src="..." alt="...">
 *   </div>
 */

const lightbox = document.querySelector('.lightbox');

if (lightbox) {
  const lbImg     = document.getElementById('lightbox-img');
  const lbCaption = document.getElementById('lightbox-caption');
  const lbClose   = lightbox.querySelector('.lightbox__close');
  const lbPrev    = lightbox.querySelector('.lightbox__prev');
  const lbNext    = lightbox.querySelector('.lightbox__next');

  /* Collect all gallery items for index-based navigation. */
  const items = Array.from(document.querySelectorAll('.gallery-item'));
  let current = 0;

  /* Focusable controls inside lightbox — used for focus trap. */
  const focusables = [lbClose, lbPrev, lbNext].filter(Boolean);

  /**
   * Open the lightbox at the given index.
   * @param {number} index - index within the items array
   */
  function open(index) {
    current = index;
    const img = items[index]?.querySelector('img');
    if (!img?.src) return;

    /* Set image and caption. */
    if (lbImg) {
      lbImg.src = img.src;
      lbImg.alt = img.alt || '';
    }
    if (lbCaption) {
      lbCaption.textContent = items[index].dataset.title || img.alt || '';
    }

    lightbox.classList.add('open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    /* Move focus to close button. */
    lbClose?.focus();
  }

  /** Close the lightbox and return focus to the gallery item. */
  function close() {
    lightbox.classList.remove('open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    /* Clear src to free memory and stop any partially-loaded images. */
    if (lbImg) { lbImg.src = ''; lbImg.alt = ''; }

    /* Return focus to the item that was clicked. */
    items[current]?.focus();
  }

  /* Make each gallery item keyboard-accessible and click-openable. */
  items.forEach((item, i) => {
    item.setAttribute('role', 'button');
    item.setAttribute('tabindex', '0');
    item.addEventListener('click', () => open(i));
    item.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        open(i);
      }
    });
  });

  /* Close when clicking the dark backdrop (not the image itself). */
  lightbox.addEventListener('click', e => {
    if (e.target === lightbox) close();
  });

  lbClose?.addEventListener('click', close);

  /* Previous/next with wrap-around. */
  lbPrev?.addEventListener('click', e => {
    e.stopPropagation();
    open((current - 1 + items.length) % items.length);
  });
  lbNext?.addEventListener('click', e => {
    e.stopPropagation();
    open((current + 1) % items.length);
  });

  document.addEventListener('keydown', e => {
    if (!lightbox.classList.contains('open')) return;

    if (e.key === 'Escape')     { close(); return; }
    if (e.key === 'ArrowLeft')  { open((current - 1 + items.length) % items.length); return; }
    if (e.key === 'ArrowRight') { open((current + 1) % items.length); return; }

    /*
     * Focus trap: while lightbox is open, Tab/Shift+Tab must cycle
     * only within the three lightbox controls.
     */
    if (e.key === 'Tab' && focusables.length) {
      const first = focusables[0];
      const last  = focusables[focusables.length - 1];
      if (e.shiftKey) {
        if (document.activeElement === first) { e.preventDefault(); last.focus(); }
      } else {
        if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
      }
    }
  });
}
