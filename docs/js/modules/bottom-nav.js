/**
 * js/modules/bottom-nav.js
 *
 * Sets the active tab on the mobile bottom navigation bar.
 *
 * The bottom nav is a fixed 5-tab bar shown only on mobile (≤ 768px),
 * defined in css/components/bottom-nav.css.
 *
 * Because this is a static HTML site (no routing), the active tab
 * is determined by matching window.location.pathname against a
 * lookup table that maps each filename to one of the five tabs:
 *   home | therapy | artwork | community | contact
 *
 * The matching tab receives the .active class, which triggers:
 * - The pill highlight behind the icon (css ::before pseudo-element)
 * - The green icon colour
 * - For the centre Artwork tab: a darker raised circle + scale effect
 */

const bottomNav = document.querySelector('.bottom-nav');

if (bottomNav) {
  /*
   * Extract the filename from the URL path.
   * pathname.split('/').pop() handles both:
   *   /index.html  → 'index.html'
   *   /            → '' (root, treated as index.html)
   */
  const filename = window.location.pathname.split('/').pop() || 'index.html';

  /*
   * Map every page filename to its corresponding bottom-nav tab.
   * Sub-pages (e.g. art therapy sub-pages) map to their parent tab.
   */
  const pageToTab = {
    'index.html':                       'home',
    'about.html':                       'home',
    'blog.html':                        'home',
    'blog-post.html':                   'home',
    'articles.html':                    'home',
    'art-therapy.html':                 'therapy',
    'what-is-art-therapy.html':         'therapy',
    'what-can-jess-offer.html':         'therapy',
    'what-else-do-i-need-to-know.html': 'therapy',
    'artist.html':                      'artwork',
    'artwork.html':                     'artwork',
    'community.html':                   'community',
    'overview.html':                    'community',
    'starling-project.html':            'community',
    'the-plot-stanmer.html':            'community',
    'contact.html':                     'contact',
  };

  const activeTab = pageToTab[filename] || 'home';

  /* Find the nav item with the matching data-bnav attribute and activate it. */
  const activeItem = bottomNav.querySelector(`[data-bnav="${activeTab}"]`);
  if (activeItem) activeItem.classList.add('active');
}
