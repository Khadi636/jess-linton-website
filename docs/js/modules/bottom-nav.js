/**
 * js/modules/bottom-nav.js
 *
 * Sets the active tab on the mobile bottom navigation bar.
 * Tabs: about | therapy | exhibitions | publications | blog | contact
 */

const bottomNav = document.querySelector('.bottom-nav');

if (bottomNav) {
  const filename = window.location.pathname.split('/').pop() || 'index.html';

  const pageToTab = {
    'index.html':                       'about',
    'about.html':                       'about',
    'art-therapy.html':                 'therapy',
    'what-is-art-therapy.html':         'therapy',
    'what-can-jess-offer.html':         'therapy',
    'what-else-do-i-need-to-know.html': 'therapy',
    'clinical-supervision.html':        'therapy',
    'workshops-lectures.html':          'therapy',
    'art-refuge.html':                  'therapy',
    'the-alex.html':                    'therapy',
    'starling-project.html':            'therapy',
    'the-plot-stanmer.html':            'therapy',
    'exhibitions.html':                 'exhibitions',
    'artwork.html':                     'exhibitions',
    'artist.html':                      'exhibitions',
    'art-ceramics.html':                'exhibitions',
    'art-photographic.html':            'exhibitions',
    'art-mixed-media.html':             'exhibitions',
    'art-site-specific.html':           'exhibitions',
    'art-creative-action.html':         'exhibitions',
    'studio-enquiries.html':            'exhibitions',
    'publications.html':                'publications',
    'blog.html':                        'blog',
    'articles.html':                    'blog',
    'overview.html':                    'blog',
    'community.html':                   'blog',
    'contact.html':                     'contact',
  };

  const activeTab = pageToTab[filename] || 'about';

  const activeItem = bottomNav.querySelector(`[data-bnav="${activeTab}"]`);
  if (activeItem) activeItem.classList.add('active');
}
