/**
 * js/modules/preview-panel.js
 * Client design preview panel.
 *
 * Injects a fixed panel into every page that lets the client
 * preview colour palettes, typography pairings, and button styles.
 * Choices are applied as CSS custom property overrides on :root
 * and persist across page loads via sessionStorage.
 *
 * No HTML pages are modified. Zero impact on the final design.
 * Remove this module import from main.js when approved.
 */

/* ── Configuration ───────────────────────────────────────── */

const PALETTES = [
  {
    id: 'current',
    name: 'Current Design',
    swatches: ['#F8F5F0', '#C4915A', '#2C4A38', '#1E3327'],
    vars: null, // null = remove all overrides (reset to stylesheet)
  },
  {
    id: 'mint-amber',
    name: 'Mint & Amber',
    swatches: ['#FDFBD0', '#A8E0DA', '#E09038', '#3C1520'],
    vars: {
      '--bg':           '#FDFBD0',
      '--white':        '#FEFEF0',
      '--surface':      '#F2EEB5',
      '--surface-2':    '#E8E49E',
      '--border':       '#D5D29A',
      '--border-light': '#E4E1B5',
      '--ink':          '#3C1520',
      '--ink-2':        '#5A2C2C',
      '--ink-3':        '#7A5045',
      '--ink-4':        '#C0A4A0',
      '--green':        '#E09038',
      '--green-mid':    '#C87828',
      '--green-dark':   '#3C1520',
      '--green-pale':   '#D8F5F2',
      '--sand':         '#A8E0DA',
      '--sand-light':   '#C0EAE5',
      '--sand-lt':      '#DFF7F4',
    },
  },
  {
    id: 'crimson-cream',
    name: 'Crimson & Cream',
    swatches: ['#EDE0D0', '#D0A878', '#8B0E38', '#580C18'],
    vars: {
      '--bg':           '#EDE0D0',
      '--white':        '#F5ECE0',
      '--surface':      '#E2CDB8',
      '--surface-2':    '#D5BCA0',
      '--border':       '#C4A880',
      '--border-light': '#D5BA95',
      '--ink':          '#200810',
      '--ink-2':        '#421020',
      '--ink-3':        '#704048',
      '--ink-4':        '#C09090',
      '--green':        '#8B0E38',
      '--green-mid':    '#7A0C30',
      '--green-dark':   '#580C18',
      '--green-pale':   '#F2DCE0',
      '--sand':         '#D0A878',
      '--sand-light':   '#DCBA90',
      '--sand-lt':      '#F0D9C0',
    },
  },
  {
    id: 'forest-cream',
    name: 'Forest & Cream',
    swatches: ['#F5F5DC', '#CCCA80', '#387830', '#1E4018'],
    vars: {
      '--bg':           '#F5F5DC',
      '--white':        '#FAFAE8',
      '--surface':      '#EAEAC8',
      '--surface-2':    '#DEDED0',
      '--border':       '#BEBF90',
      '--border-light': '#D2D2A8',
      '--ink':          '#1A2810',
      '--ink-2':        '#303820',
      '--ink-3':        '#505E38',
      '--ink-4':        '#A0B090',
      '--green':        '#387830',
      '--green-mid':    '#2C6028',
      '--green-dark':   '#1E4018',
      '--green-pale':   '#D8ECC8',
      '--sand':         '#CCCA80',
      '--sand-light':   '#D8D698',
      '--sand-lt':      '#ECEBB5',
    },
  },
  {
    id: 'burgundy-teal',
    name: 'Burgundy & Teal',
    swatches: ['#F0EDD0', '#5A8868', '#1A4440', '#581020'],
    vars: {
      '--bg':           '#F0EDD0',
      '--white':        '#F8F6E0',
      '--surface':      '#E5E2C0',
      '--surface-2':    '#D8D5A8',
      '--border':       '#BEC09A',
      '--border-light': '#D0CDB0',
      '--ink':          '#1E0A10',
      '--ink-2':        '#381828',
      '--ink-3':        '#5C3848',
      '--ink-4':        '#B890A0',
      '--green':        '#1A4440',
      '--green-mid':    '#2C5E58',
      '--green-dark':   '#581020',
      '--green-pale':   '#C8E0D0',
      '--sand':         '#5A8868',
      '--sand-light':   '#70A080',
      '--sand-lt':      '#D0E5D8',
    },
  },
];

// Font pairings — Google Fonts approximations of the requested commercial fonts.
// Labels show the target font name; previews use the closest freely-available match.
const FONTS = [
  {
    id: 'current',
    label: 'Current',
    name: 'Fraunces + Inter',
    sample: 'The quick brown fox',
    sampleFamily: "'Inter', system-ui, sans-serif",
    bodyFont: "'Inter', system-ui, sans-serif",
    displayFont: "'Fraunces', Georgia, serif",
    googleUrl: null,
  },
  {
    id: 'mont',
    label: 'Mont',
    name: 'Rounded geometric sans',
    sample: 'The quick brown fox',
    sampleFamily: "'Nunito', system-ui, sans-serif",
    bodyFont: "'Nunito', system-ui, sans-serif",
    displayFont: "'Cormorant Garamond', Georgia, serif",
    googleUrl: 'https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,200;1,400&display=swap',
  },
  {
    id: 'intro',
    label: 'Intro',
    name: 'Clean geometric sans',
    sample: 'The quick brown fox',
    sampleFamily: "'DM Sans', system-ui, sans-serif",
    bodyFont: "'DM Sans', system-ui, sans-serif",
    displayFont: "'Playfair Display', Georgia, serif",
    googleUrl: 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap',
  },
  {
    id: 'fabric',
    label: 'Fabric Grotesk',
    name: 'Modern grotesque sans',
    sample: 'The quick brown fox',
    sampleFamily: "'Manrope', system-ui, sans-serif",
    bodyFont: "'Manrope', system-ui, sans-serif",
    displayFont: "'Libre Baskerville', Georgia, serif",
    googleUrl: 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap',
  },
];

const BTN_STYLES = [
  { id: 'sharp',   label: 'Sharp',   radius: '0px' },
  { id: 'soft',    label: 'Soft',    radius: '6px' },
  { id: 'pill',    label: 'Pill',    radius: '100px' },
];

const STORAGE_KEY = 'jl-preview-v2';

/* ── State helpers ────────────────────────────────────────── */

function loadState() {
  try { return JSON.parse(sessionStorage.getItem(STORAGE_KEY)) || {}; }
  catch { return {}; }
}

function saveState(patch) {
  sessionStorage.setItem(STORAGE_KEY, JSON.stringify({ ...loadState(), ...patch }));
}

/* ── CSS variable application ─────────────────────────────── */

// Collect every variable key used across all non-null palettes
const ALL_PALETTE_KEYS = [...new Set(
  PALETTES.filter(p => p.vars).flatMap(p => Object.keys(p.vars))
)];

function applyPalette(palette) {
  const root = document.documentElement;
  if (!palette.vars) {
    ALL_PALETTE_KEYS.forEach(k => root.style.removeProperty(k));
  } else {
    Object.entries(palette.vars).forEach(([k, v]) => root.style.setProperty(k, v));
  }
}

function loadGoogleFont(url, id) {
  if (!url || document.getElementById(id)) return;
  const link = document.createElement('link');
  link.id   = id;
  link.rel  = 'stylesheet';
  link.href = url;
  document.head.appendChild(link);
}

function applyFont(font) {
  loadGoogleFont(font.googleUrl, `cp-gf-${font.id}`);
  const root = document.documentElement;
  if (font.id === 'current') {
    root.style.removeProperty('--f-body');
    root.style.removeProperty('--f-display');
  } else {
    root.style.setProperty('--f-body',    font.bodyFont);
    root.style.setProperty('--f-display', font.displayFont);
  }
}

function applyBtnStyle(style) {
  let tag = document.getElementById('cp-btn-style');
  if (!tag) {
    tag = document.createElement('style');
    tag.id = 'cp-btn-style';
    document.head.appendChild(tag);
  }
  if (style.id === 'sharp') {
    tag.textContent = ''; // buttons are already square/sharp by default
  } else {
    tag.textContent = `.btn { border-radius: ${style.radius} !important; }`;
  }
}

/* ── Panel rendering ──────────────────────────────────────── */

function buildPanel(activePaletteId, activeFontId, activeBtnId, open) {
  const paletteButtons = PALETTES.map(p => `
    <button class="cp__palette${p.id === activePaletteId ? ' active' : ''}" data-palette="${p.id}" type="button">
      <span class="cp__swatches" aria-hidden="true">
        ${p.swatches.map(s => `<span class="cp__swatch" style="background:${s}"></span>`).join('')}
      </span>
      ${p.name}
    </button>
  `).join('');

  const fontButtons = FONTS.map(f => `
    <button class="cp__font${f.id === activeFontId ? ' active' : ''}" data-font="${f.id}" type="button">
      <span class="cp__font-name">${f.label}</span>
      <span class="cp__font-sample" style="font-family:${f.sampleFamily}">${f.sample}</span>
    </button>
  `).join('');

  const btnOptButtons = BTN_STYLES.map(b => `
    <button
      class="cp__btn-opt${b.id === activeBtnId ? ' active' : ''}"
      data-btn="${b.id}"
      type="button"
      style="border-radius:${b.radius}"
    >${b.label}</button>
  `).join('');

  return `
    <button class="cp__tab" type="button" aria-expanded="${open}" aria-controls="cp-body">
      ✦ Preview Design
    </button>
    <div class="cp__body" id="cp-body" role="region" aria-label="Design preview controls">
      <p class="cp__heading">Design Preview</p>

      <section class="cp__section">
        <span class="cp__label">Colour Palette</span>
        <div class="cp__palettes">${paletteButtons}</div>
      </section>

      <div class="cp__divider"></div>

      <section class="cp__section">
        <span class="cp__label">Typography</span>
        <div class="cp__fonts">${fontButtons}</div>
      </section>

      <div class="cp__divider"></div>

      <section class="cp__section">
        <span class="cp__label">Button Style</span>
        <div class="cp__btn-opts">${btnOptButtons}</div>
      </section>

      <button class="cp__reset" type="button">↺ Reset to current design</button>

      <p class="cp__note">Preview only — final selection will be applied after client approval.</p>
    </div>
  `;
}

/* ── Main export ──────────────────────────────────────────── */

export function initPreviewPanel() {
  const state = loadState();

  // Resolve active selections (with fallbacks)
  const activePalette = PALETTES.find(p => p.id === state.palette) || PALETTES[0];
  const activeFont    = FONTS.find(f => f.id === state.font)       || FONTS[0];
  const activeBtn     = BTN_STYLES.find(b => b.id === state.btn)   || BTN_STYLES[0];
  const isOpen        = state.open !== false; // default open

  // Apply palette and button styles immediately (no external requests)
  applyPalette(activePalette);
  applyBtnStyle(activeBtn);

  // Apply active font vars immediately, but defer the font file fetch
  // so it does not block document_idle and slow down page load
  if (activeFont.id !== 'current') {
    const root = document.documentElement;
    root.style.setProperty('--f-body',    activeFont.bodyFont);
    root.style.setProperty('--f-display', activeFont.displayFont);
  }
  // Load all Google Font files after the page has settled
  setTimeout(() => {
    FONTS.forEach(f => { if (f.googleUrl) loadGoogleFont(f.googleUrl, `cp-gf-${f.id}`); });
  }, 800);

  // Build and insert panel
  const wrap = document.createElement('div');
  wrap.className = 'cp' + (isOpen ? '' : ' collapsed');
  wrap.setAttribute('role', 'complementary');
  wrap.setAttribute('aria-label', 'Design preview panel');
  wrap.innerHTML = buildPanel(activePalette.id, activeFont.id, activeBtn.id, isOpen);
  document.body.appendChild(wrap);

  // ── Toggle ──────────────────────────────────────────────
  const tab = wrap.querySelector('.cp__tab');
  tab.addEventListener('click', () => {
    const nowOpen = wrap.classList.toggle('collapsed') === false;
    tab.setAttribute('aria-expanded', String(nowOpen));
    saveState({ open: nowOpen });
  });

  // ── Palette buttons ──────────────────────────────────────
  wrap.querySelectorAll('[data-palette]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id      = btn.dataset.palette;
      const palette = PALETTES.find(p => p.id === id);
      applyPalette(palette);
      wrap.querySelectorAll('[data-palette]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      saveState({ palette: id });
    });
  });

  // ── Font buttons ─────────────────────────────────────────
  wrap.querySelectorAll('[data-font]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id   = btn.dataset.font;
      const font = FONTS.find(f => f.id === id);
      applyFont(font);
      wrap.querySelectorAll('[data-font]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      saveState({ font: id });
    });
  });

  // ── Button style buttons ─────────────────────────────────
  wrap.querySelectorAll('[data-btn]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id    = btn.dataset.btn;
      const style = BTN_STYLES.find(b => b.id === id);
      applyBtnStyle(style);
      wrap.querySelectorAll('[data-btn]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      saveState({ btn: id });
    });
  });

  // ── Reset ────────────────────────────────────────────────
  wrap.querySelector('.cp__reset').addEventListener('click', () => {
    applyPalette(PALETTES[0]);
    applyFont(FONTS[0]);
    applyBtnStyle(BTN_STYLES[0]);
    wrap.querySelectorAll('[data-palette]').forEach(b =>
      b.classList.toggle('active', b.dataset.palette === 'current'));
    wrap.querySelectorAll('[data-font]').forEach(b =>
      b.classList.toggle('active', b.dataset.font === 'current'));
    wrap.querySelectorAll('[data-btn]').forEach(b =>
      b.classList.toggle('active', b.dataset.btn === 'sharp'));
    saveState({ palette: 'current', font: 'current', btn: 'sharp' });
  });
}
