/* Optional GA4: no Google tag request before affirmative consent. */
(() => {
  'use strict';
  const id = 'G-X8CMDXXHBT';
  const key = 'hs-analytics-consent-v1';
  const lifetime = 180 * 24 * 60 * 60 * 1000;
  const production = ['honoringstories.com', 'www.honoringstories.com'].includes(location.hostname);
  let loaded = false;
  let returnFocus = null;
  function readChoice() {
    try {
      const saved = JSON.parse(localStorage.getItem(key));
      return saved && Date.now() - saved.time < lifetime &&
        ['accepted', 'declined'].includes(saved.value) ? saved.value : null;
    } catch (_) { return null; }
  }
  let choice = readChoice();
  window['ga-disable-' + id] = choice !== 'accepted';
  function clearCookies() {
    const domains = ['', location.hostname, '.honoringstories.com'];
    document.cookie.split(';').forEach(cookie => {
      const name = cookie.split('=')[0].trim();
      if (name === '_ga' || name.startsWith('_ga_')) {
        domains.forEach(domain => {
          document.cookie = name + '=; Max-Age=0; path=/; SameSite=Lax' +
            (domain ? '; domain=' + domain : '');
        });
      }
    });
  }
  function start() {
    if (loaded || choice !== 'accepted' || !production) return;
    loaded = true;
    window['ga-disable-' + id] = false;
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    gtag('consent', 'default', {
      analytics_storage: 'denied', ad_storage: 'denied',
      ad_user_data: 'denied', ad_personalization: 'denied'
    });
    gtag('consent', 'update', { analytics_storage: 'granted' });
    gtag('js', new Date());
    let referrer = '';
    try { referrer = document.referrer ? new URL(document.referrer).origin + '/' : ''; } catch (_) {}
    gtag('config', id, {
      allow_google_signals: false,
      allow_ad_personalization_signals: false,
      send_page_view: true,
      page_location: location.origin + location.pathname,
      page_referrer: referrer,
      cookie_expires: 15552000,
      cookie_update: false
    });
    const script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + id;
    document.head.appendChild(script);
  }
  const panel = document.createElement('section');
  panel.className = 'hs-consent';
  panel.hidden = true;
  panel.setAttribute('role', 'region');
  panel.setAttribute('aria-labelledby', 'hs-consent-title');
  // Static interface only. No visitor-provided text is rendered as markup.
  panel.innerHTML = '<h2 id="hs-consent-title">Your analytics choice</h2>' +
    '<p>May I use Google Analytics to understand visits to this website? It uses cookies only if you accept. Your choice will not affect access to the site.</p>' +
    '<p><a href="privacy-policy.html#website-analytics">Read the Privacy Policy</a></p>' +
    '<div class="hs-consent-actions"><button type="button" data-choice="accepted">Accept</button>' +
    '<button type="button" data-choice="declined">Decline</button>' +
    '<button type="button" class="hs-consent-close" hidden>Close</button></div>';
  document.body.appendChild(panel);
  const close = panel.querySelector('.hs-consent-close');
  const trigger = document.querySelector('[data-analytics-preferences]');
  function show(focus) {
    panel.hidden = false;
    close.hidden = !choice;
    if (focus) {
      returnFocus = document.activeElement;
      panel.querySelector('button').focus();
    }
  }
  function hide() {
    panel.hidden = true;
    if (returnFocus) { returnFocus.focus(); returnFocus = null; }
  }
  if (trigger) {
    trigger.hidden = false;
    trigger.addEventListener('click', () => show(true));
  }
  close.addEventListener('click', hide);
  panel.addEventListener('keydown', event => {
    if (event.key === 'Escape' && choice) hide();
  });
  panel.querySelectorAll('[data-choice]').forEach(button => {
    button.addEventListener('click', () => {
      choice = button.dataset.choice;
      try { localStorage.setItem(key, JSON.stringify({ value: choice, time: Date.now() })); } catch (_) {}
      hide();
      if (choice === 'accepted') start();
      else {
        window['ga-disable-' + id] = true;
        clearCookies();
        // A fresh document removes Google's listeners and prevents later requests.
        if (loaded) location.reload();
      }
    });
  });
  window.addEventListener('storage', event => {
    if (event.key !== key && event.key !== null) return;
    choice = readChoice();
    if (choice !== 'accepted') {
      window['ga-disable-' + id] = true;
      clearCookies();
      if (loaded) { location.reload(); return; }
    }
    if (!choice) show(false); else { hide(); start(); }
  });
  if (choice === 'accepted') start();
  else { clearCookies(); if (!choice) show(false); }
})();
