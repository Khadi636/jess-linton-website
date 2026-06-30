/**
 * js/modules/scroll-header.js
 *
 * Watches the window scroll position and toggles the .scrolled class
 * on the site header once the user has scrolled more than 40px.
 *
 * When .scrolled is active, the CSS transitions the header from
 * fully transparent (used on the full-viewport hero) to a
 * frosted-glass background (rgba + backdrop-filter: blur).
 *
 * The check is called once on init so the header state is correct
 * on pages where the user has already scrolled (e.g. browser back).
 */

const header = document.getElementById('site-header');

if (header) {
  /**
   * Toggle .scrolled when scrollY exceeds the 40px threshold.
   * classList.toggle(name, force) adds when force=true, removes when false.
   */
  const checkScroll = () => {
    header.classList.toggle('scrolled', window.scrollY > 40);
  };

  /* passive: true — tells the browser this listener won't call preventDefault,
     allowing scroll performance optimisations. */
  window.addEventListener('scroll', checkScroll, { passive: true });

  /* Run once immediately so the initial state is correct. */
  checkScroll();
}
