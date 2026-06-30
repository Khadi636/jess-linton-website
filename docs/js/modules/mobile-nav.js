/**
 * js/modules/mobile-nav.js
 *
 * Controls the full-screen mobile navigation overlay.
 *
 * Behaviour:
 * - The hamburger button (.nav-toggle) opens/closes the overlay.
 * - Opening moves focus into the overlay (the first link) for
 *   keyboard and screen-reader accessibility.
 * - body.overflow is set to 'hidden' while open to prevent
 *   the page behind the overlay from scrolling.
 * - Pressing Escape closes the overlay and returns focus to
 *   the hamburger button.
 * - aria-expanded and aria-hidden are kept in sync so assistive
 *   technologies report the correct state.
 */

const navToggle = document.querySelector('.nav-toggle');
const mobileNav = document.getElementById('mobile-nav');

if (navToggle && mobileNav) {

  /** Open the overlay, lock scroll, move focus inside. */
  function openNav() {
    mobileNav.classList.add('open');
    navToggle.setAttribute('aria-expanded', 'true');
    mobileNav.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    /* Move keyboard focus into the overlay so Tab navigates inside it. */
    const firstLink = mobileNav.querySelector('a, button');
    if (firstLink) firstLink.focus();
  }

  /** Close the overlay, restore scroll, return focus to toggle. */
  function closeNav() {
    mobileNav.classList.remove('open');
    navToggle.setAttribute('aria-expanded', 'false');
    mobileNav.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    /* Return focus to the button that opened the overlay. */
    navToggle.focus();
  }

  /* Toggle on hamburger click. */
  navToggle.addEventListener('click', () => {
    mobileNav.classList.contains('open') ? closeNav() : openNav();
  });

  /* Close on Escape key anywhere on the page. */
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && mobileNav.classList.contains('open')) {
      closeNav();
    }
  });
}
