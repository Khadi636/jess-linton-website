/**
 * js/main.js  —  Entry point
 * Jess Linton website — v3
 *
 * This file imports and initialises all UI modules.
 * Each module is self-contained and operates on the DOM
 * using querySelector — it silently does nothing if its
 * target elements are not present on the current page.
 *
 * Load order matters for the DOM: this script is loaded
 * with type="module" which defers automatically, so all
 * modules run after the HTML has been parsed.
 *
 * Module responsibilities:
 *   scroll-header  — frosted-glass header on scroll
 *   mobile-nav     — hamburger overlay nav (open/close/focus/escape)
 *   scroll-reveal  — IntersectionObserver entrance animations
 *   slideshow      — hero + section auto-advancing slideshows
 *   lightbox       — fullscreen image viewer for the gallery
 *   bottom-nav     — active tab on the mobile bottom navigation bar
 */

import './modules/scroll-header.js';
import './modules/mobile-nav.js';
import './modules/scroll-reveal.js';
import './modules/slideshow.js';
import './modules/lightbox.js';
import './modules/bottom-nav.js';
