/**
 * js/modules/slideshow.js
 *
 * Auto-playing image slideshow with dot navigation.
 * Works for both the homepage hero (.hero) and any full-width
 * section slideshows (.slideshow) on interior pages.
 *
 * Markup structure expected:
 *   <div class="hero">  OR  <div class="slideshow">
 *     <div class="hero-slides">  OR  <div class="slideshow__slides">
 *       <div class="hero-slide active">  /  <div class="slideshow__slide active">
 *       ...
 *     </div>
 *     <div class="hero-dots">  /  <div class="slideshow__dots">
 *       <button class="hero-dot active">  /  <button class="slideshow__dot">
 *       ...
 *     </div>
 *   </div>
 *
 * Auto-advances every 5 seconds. Clicking a dot jumps to
 * that slide and restarts the timer.
 *
 * Requires at least 2 slides to initialise (single-image
 * containers are left static).
 */

/**
 * Initialise a single slideshow container.
 * @param {Element} container - the .hero or .slideshow element
 */
function initSlideshow(container) {
  /* Support both hero and section slideshow class names. */
  const slides = container.querySelectorAll('.hero-slide, .slideshow__slide');
  const dots   = container.querySelectorAll('.hero-dot, .slideshow__dot');

  /* Skip containers with only one image — nothing to cycle. */
  if (slides.length < 2) return;

  let current = 0;
  let timer;

  /**
   * Transition to slide at index n, wrapping around both ends.
   * @param {number} n - target slide index
   */
  function goTo(n) {
    /* Deactivate current slide and its dot. */
    slides[current].classList.remove('active');
    if (dots[current]) dots[current].classList.remove('active');

    /* Wrap index to valid range. */
    current = (n + slides.length) % slides.length;

    /* Activate new slide and its dot. */
    slides[current].classList.add('active');
    if (dots[current]) dots[current].classList.add('active');
  }

  /* Wire dot buttons to jump to their corresponding slide. */
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      clearInterval(timer);   /* reset timer so click doesn't feel janky */
      goTo(i);
      start();
    });
  });

  /** Start (or restart) the auto-advance interval. */
  function start() {
    timer = setInterval(() => goTo(current + 1), 5000);
  }

  start();
}

/* Init every hero and section slideshow on the page. */
document.querySelectorAll('.hero, .slideshow, .hero-home').forEach(initSlideshow);

/*
 * Ken Burns trigger: adds .loaded to .hero after the first paint,
 * which starts the slow CSS scale transition on the hero image.
 * requestAnimationFrame defers until after the browser has rendered,
 * giving the CSS transition something to animate from.
 */
const hero = document.querySelector('.hero');
if (hero) requestAnimationFrame(() => hero.classList.add('loaded'));
