export function initCookieConsent() {
  const KEY = 'jl_cookie_consent';
  if (localStorage.getItem(KEY)) return;

  const banner = document.createElement('div');
  banner.id = 'cookie-banner';
  banner.className = 'cookie-banner';
  banner.setAttribute('role', 'region');
  banner.setAttribute('aria-label', 'Cookie consent');
  banner.innerHTML = `
    <div class="cookie-banner__inner">
      <p class="cookie-banner__text">
        This website uses cookies and similar technologies to ensure it works correctly.
        We do not use advertising or tracking cookies.
        <a href="cookie-policy.html">Cookie Policy</a> &nbsp;&middot;&nbsp;
        <a href="privacy-policy.html">Privacy Policy</a>
      </p>
      <div class="cookie-banner__actions">
        <button id="cookie-decline" class="cookie-banner__btn cookie-banner__btn--secondary">Essential only</button>
        <button id="cookie-accept" class="cookie-banner__btn cookie-banner__btn--primary">Accept all</button>
      </div>
    </div>
  `;
  document.body.appendChild(banner);

  document.getElementById('cookie-accept').addEventListener('click', () => {
    localStorage.setItem(KEY, 'all');
    banner.classList.add('cookie-banner--hide');
    setTimeout(() => banner.remove(), 400);
  });

  document.getElementById('cookie-decline').addEventListener('click', () => {
    localStorage.setItem(KEY, 'essential');
    banner.classList.add('cookie-banner--hide');
    setTimeout(() => banner.remove(), 400);
  });
}
