/**
 * js/modules/preview-panel.js
 * Client Design Preview Panel — reusable across projects.
 *
 * A floating "Design Options" trigger opens a slide-in drawer.
 * Desktop: slides from the right. Mobile: slides from the bottom.
 * The page content is always visible behind the panel.
 *
 * To enable:  import { initPreviewPanel } from './modules/preview-panel.js'
 *             in main.js (+ @import 'components/preview-panel.css' in style.css)
 * To disable: comment out both imports.
 *
 * Selections persist across page navigation via sessionStorage.
 * Zero modifications to any HTML pages.
 */

/* ── Configuration ───────────────────────────────────────── */

const PALETTES = [
  {
    id: 'current',
    name: 'Current Design',
    swatches: ['#F8F5F0', '#C4915A', '#2C4A38', '#131310'],
    vars: null,
  },
  {
    id: 'mint-amber',
    name: 'Mint & Amber',
    swatches: ['#FDFBD0', '#A8E0DA', '#E09038', '#3C1520'],
    vars: {
      '--bg': '#FDFBD0', '--white': '#FEFEF0',
      '--surface': '#F2EEB5', '--surface-2': '#E8E49E',
      '--border': '#D5D29A', '--border-light': '#E4E1B5',
      '--ink': '#3C1520', '--ink-2': '#5A2C2C',
      '--ink-3': '#7A5045', '--ink-4': '#C0A4A0',
      '--green': '#E09038', '--green-mid': '#C87828',
      '--green-dark': '#3C1520', '--green-pale': '#D8F5F2',
      '--sand': '#A8E0DA', '--sand-light': '#C0EAE5', '--sand-lt': '#DFF7F4',
    },
  },
  {
    id: 'crimson-cream',
    name: 'Crimson & Cream',
    swatches: ['#EDE0D0', '#D0A878', '#8B0E38', '#580C18'],
    vars: {
      '--bg': '#EDE0D0', '--white': '#F5ECE0',
      '--surface': '#E2CDB8', '--surface-2': '#D5BCA0',
      '--border': '#C4A880', '--border-light': '#D5BA95',
      '--ink': '#200810', '--ink-2': '#421020',
      '--ink-3': '#704048', '--ink-4': '#C09090',
      '--green': '#8B0E38', '--green-mid': '#7A0C30',
      '--green-dark': '#580C18', '--green-pale': '#F2DCE0',
      '--sand': '#D0A878', '--sand-light': '#DCBA90', '--sand-lt': '#F0D9C0',
    },
  },
  {
    id: 'forest-cream',
    name: 'Forest & Cream',
    swatches: ['#F5F5DC', '#CCCA80', '#387830', '#1E4018'],
    vars: {
      '--bg': '#F5F5DC', '--white': '#FAFAE8',
      '--surface': '#EAEAC8', '--surface-2': '#DEDED0',
      '--border': '#BEBF90', '--border-light': '#D2D2A8',
      '--ink': '#1A2810', '--ink-2': '#303820',
      '--ink-3': '#505E38', '--ink-4': '#A0B090',
      '--green': '#387830', '--green-mid': '#2C6028',
      '--green-dark': '#1E4018', '--green-pale': '#D8ECC8',
      '--sand': '#CCCA80', '--sand-light': '#D8D698', '--sand-lt': '#ECEBB5',
    },
  },
  {
    id: 'burgundy-teal',
    name: 'Burgundy & Teal',
    swatches: ['#F0EDD0', '#5A8868', '#1A4440', '#581020'],
    vars: {
      '--bg': '#F0EDD0', '--white': '#F8F6E0',
      '--surface': '#E5E2C0', '--surface-2': '#D8D5A8',
      '--border': '#BEC09A', '--border-light': '#D0CDB0',
      '--ink': '#1E0A10', '--ink-2': '#381828',
      '--ink-3': '#5C3848', '--ink-4': '#B890A0',
      '--green': '#1A4440', '--green-mid': '#2C5E58',
      '--green-dark': '#581020', '--green-pale': '#C8E0D0',
      '--sand': '#5A8868', '--sand-light': '#70A080', '--sand-lt': '#D0E5D8',
    },
  },
];

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
    name: 'Rounded geometric',
    sample: 'The quick brown fox',
    sampleFamily: "'Nunito', system-ui, sans-serif",
    bodyFont: "'Nunito', system-ui, sans-serif",
    displayFont: "'Cormorant Garamond', Georgia, serif",
    googleUrl: 'https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,200;1,400&display=swap',
  },
  {
    id: 'intro',
    label: 'Intro',
    name: 'Clean geometric',
    sample: 'The quick brown fox',
    sampleFamily: "'DM Sans', system-ui, sans-serif",
    bodyFont: "'DM Sans', system-ui, sans-serif",
    displayFont: "'Playfair Display', Georgia, serif",
    googleUrl: 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap',
  },
  {
    id: 'fabric',
    label: 'Fabric Grotesk',
    name: 'Modern grotesque',
    sample: 'The quick brown fox',
    sampleFamily: "'Manrope', system-ui, sans-serif",
    bodyFont: "'Manrope', system-ui, sans-serif",
    displayFont: "'Libre Baskerville', Georgia, serif",
    googleUrl: 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap',
  },
];

const BTN_STYLES = [
  { id: 'sharp', label: 'Sharp', radius: '0px' },
  { id: 'soft',  label: 'Soft',  radius: '6px' },
  { id: 'pill',  label: 'Pill',  radius: '100px' },
];

const STORAGE_KEY = 'jl-preview-v2';

/* ── State helpers ────────────────────────────────────────── */

function loadState() {
  try { return JSON.parse(sessionStorage.getItem(STORAGE_KEY)) || {}; }
  catch { return {}; }
}

function saveState(patch) {
  try {
    sessionStorage.setItem(STORAGE_KEY, JSON.stringify({ ...loadState(), ...patch }));
  } catch {}
}

/* ── CSS application helpers ──────────────────────────────── */

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
  tag.textContent = style.id === 'sharp'
    ? ''
    : `.btn { border-radius: ${style.radius} !important; }`;
}

/* ── DOM builders ─────────────────────────────────────────── */

const PALETTE_ICON = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c.926 0 1.648-.746 1.648-1.688
    0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125
    a1.64 1.64 0 0 1 1.668-1.668h1.996C19.462 16.394 22 13.89 22 10.84
    22 5.99 17.52 2 12 2z" stroke="currentColor" stroke-width="1.6" fill="none"/>
  <circle cx="8"  cy="9"  r="1.5" fill="currentColor"/>
  <circle cx="12" cy="6"  r="1.5" fill="currentColor"/>
  <circle cx="16" cy="9"  r="1.5" fill="currentColor"/>
  <circle cx="17" cy="13" r="1.5" fill="currentColor"/>
</svg>`;

function buildTrigger() {
  const btn = document.createElement('button');
  btn.className = 'cp-trigger';
  btn.setAttribute('type', 'button');
  btn.setAttribute('aria-label', 'Open design options panel');
  btn.setAttribute('aria-expanded', 'false');
  btn.innerHTML = `${PALETTE_ICON}<span>Design Options</span>`;
  return btn;
}

function buildBackdrop() {
  const el = document.createElement('div');
  el.className = 'cp-backdrop';
  el.setAttribute('aria-hidden', 'true');
  return el;
}

function buildPanel(activePaletteId, activeFontId, activeBtnId) {
  const paletteHTML = PALETTES.map(p => `
    <button class="cp__palette${p.id === activePaletteId ? ' active' : ''}"
            data-palette="${p.id}" type="button">
      <span class="cp__swatches" aria-hidden="true">
        ${p.swatches.map(s => `<span class="cp__swatch" style="background:${s}"></span>`).join('')}
      </span>
      <span class="cp__palette-name">${p.name}</span>
    </button>`).join('');

  const fontHTML = FONTS.map(f => `
    <button class="cp__font${f.id === activeFontId ? ' active' : ''}"
            data-font="${f.id}" type="button">
      <span class="cp__font-label">${f.label}</span>
      <span class="cp__font-sample" style="font-family:${f.sampleFamily}">${f.sample}</span>
    </button>`).join('');

  const btnHTML = BTN_STYLES.map(b => `
    <button class="cp__btn-opt${b.id === activeBtnId ? ' active' : ''}"
            data-btn="${b.id}" type="button"
            style="border-radius:${b.radius}">${b.label}</button>`).join('');

  const panel = document.createElement('div');
  panel.className = 'cp';
  panel.setAttribute('role', 'dialog');
  panel.setAttribute('aria-modal', 'true');
  panel.setAttribute('aria-label', 'Design options');
  panel.innerHTML = `
    <div class="cp__header">
      <span class="cp__title">Design Options</span>
      <button class="cp__close" type="button" aria-label="Close design options">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
          <path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="1.75"
                stroke-linecap="round"/>
        </svg>
      </button>
    </div>
    <div class="cp__body">
      <section class="cp__section">
        <span class="cp__label">Colour Palette</span>
        <div class="cp__palettes">${paletteHTML}</div>
      </section>
      <div class="cp__divider"></div>
      <section class="cp__section">
        <span class="cp__label">Typography</span>
        <div class="cp__fonts">${fontHTML}</div>
      </section>
      <div class="cp__divider"></div>
      <section class="cp__section">
        <span class="cp__label">Button Style</span>
        <div class="cp__btn-opts">${btnHTML}</div>
      </section>
      <button class="cp__reset" type="button">↺ Reset to current design</button>
      <p class="cp__note">Preview only — final selection will be applied after client approval.</p>
    </div>`;
  return panel;
}

/* ── Main export ──────────────────────────────────────────── */

export function initPreviewPanel() {
  const state = loadState();

  const activePalette = PALETTES.find(p => p.id === state.palette) || PALETTES[0];
  const activeFont    = FONTS.find(f => f.id === state.font)       || FONTS[0];
  const activeBtn     = BTN_STYLES.find(b => b.id === state.btn)   || BTN_STYLES[0];

  // Restore saved appearance immediately (no external requests)
  applyPalette(activePalette);
  applyBtnStyle(activeBtn);
  if (activeFont.id !== 'current') {
    document.documentElement.style.setProperty('--f-body',    activeFont.bodyFont);
    document.documentElement.style.setProperty('--f-display', activeFont.displayFont);
  }

  // Load all Google Fonts after page settles — never blocks load
  setTimeout(() => {
    FONTS.forEach(f => { if (f.googleUrl) loadGoogleFont(f.googleUrl, `cp-gf-${f.id}`); });
  }, 800);

  // Build DOM
  const trigger  = buildTrigger();
  const backdrop = buildBackdrop();
  const panel    = buildPanel(activePalette.id, activeFont.id, activeBtn.id);

  document.body.appendChild(backdrop);
  document.body.appendChild(trigger);
  document.body.appendChild(panel);

  // ── Open / close ──────────────────────────────────────────

  function openPanel() {
    panel.classList.add('open');
    backdrop.classList.add('visible');
    trigger.classList.add('cp-trigger--hidden');
    trigger.setAttribute('aria-expanded', 'true');
    document.body.classList.add('cp-open');
    // Shift focus to close button after transition
    setTimeout(() => panel.querySelector('.cp__close').focus(), 360);
  }

  function closePanel() {
    panel.classList.remove('open');
    backdrop.classList.remove('visible');
    trigger.classList.remove('cp-trigger--hidden');
    trigger.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('cp-open');
    trigger.focus();
  }

  trigger.addEventListener('click', openPanel);
  backdrop.addEventListener('click', closePanel);
  panel.querySelector('.cp__close').addEventListener('click', closePanel);
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && panel.classList.contains('open')) closePanel();
  });

  // ── Palette ───────────────────────────────────────────────

  panel.querySelectorAll('[data-palette]').forEach(btn => {
    btn.addEventListener('click', () => {
      const palette = PALETTES.find(p => p.id === btn.dataset.palette);
      applyPalette(palette);
      panel.querySelectorAll('[data-palette]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      saveState({ palette: btn.dataset.palette });
    });
  });

  // ── Fonts ─────────────────────────────────────────────────

  panel.querySelectorAll('[data-font]').forEach(btn => {
    btn.addEventListener('click', () => {
      const font = FONTS.find(f => f.id === btn.dataset.font);
      applyFont(font);
      panel.querySelectorAll('[data-font]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      saveState({ font: btn.dataset.font });
    });
  });

  // ── Button styles ─────────────────────────────────────────

  panel.querySelectorAll('[data-btn]').forEach(btn => {
    btn.addEventListener('click', () => {
      const style = BTN_STYLES.find(b => b.id === btn.dataset.btn);
      applyBtnStyle(style);
      panel.querySelectorAll('[data-btn]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      saveState({ btn: btn.dataset.btn });
    });
  });

  // ── Reset ─────────────────────────────────────────────────

  panel.querySelector('.cp__reset').addEventListener('click', () => {
    applyPalette(PALETTES[0]);
    applyFont(FONTS[0]);
    applyBtnStyle(BTN_STYLES[0]);
    panel.querySelectorAll('[data-palette]').forEach(b =>
      b.classList.toggle('active', b.dataset.palette === 'current'));
    panel.querySelectorAll('[data-font]').forEach(b =>
      b.classList.toggle('active', b.dataset.font === 'current'));
    panel.querySelectorAll('[data-btn]').forEach(b =>
      b.classList.toggle('active', b.dataset.btn === 'sharp'));
    saveState({ palette: 'current', font: 'current', btn: 'sharp' });
  });
}
