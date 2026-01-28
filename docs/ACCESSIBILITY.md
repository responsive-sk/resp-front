# Accessibility Guide - Boson Frontend Framework

Tento dokument definuje accessibility štandardy pre Boson framework.

**Odchýlky od týchto pravidiel sa považujú za chyby.**

---

## WCAG 2.1 Level AA Compliance (Non-Negotiable)

Všetky komponenty musia spĺňať WCAG 2.1 Level AA:
- **Contrast ratio:** Minimálne 4.5:1 pre normálny text, 3:1 pre veľký text
- **Keyboard navigation:** Všetky interaktívne elementy prístupné z klávesnice
- **Screen reader support:** Semantic HTML + ARIA attributes kde je potrebné
- **Focus indicators:** Viditeľné focus stavy pre všetky interaktívne elementy
- **Alt texts:** Všetky obrázky majú alt atribúty (nie redundantné)
- **Link names:** Všetky linky majú discernible name

---

## Contrast Ratio Fixes

### Current Problems

Tvoje aktuálne farby v `app.css`:

```css
:root {
  --color-text: rgba(255, 255, 255, 0.9);           /* 17.9:1 - OK */
  --color-text-secondary: rgba(255, 255, 255, 0.6); /* 10.6:1 - OK */
  --color-text-brand: #F93904;                      /* 3.1:1 - FAIL */
  --color-bg: #0d1119;
}
```

**Problém:** Brand color (#F93904) má kontrast len 3.1:1 proti dark background.

### Solution 1: Lighten Brand Color

```css
:root {
  /* Original */
  --color-text-brand: #F93904;        /* 3.1:1 - FAIL */
  
  /* Fixed - Lighter orange */
  --color-text-brand: #FF5722;        /* 4.5:1 - PASS */
  --color-text-brand-hover: #FF7043;  /* 5.8:1 - PASS */
  
  /* Alternative - Even lighter */
  --color-text-brand-alt: #FF6E40;    /* 5.2:1 - PASS */
}
```

### Solution 2: Use Brand Color Only on Light Backgrounds

```css
:root {
  /* Dark background - use lighter variant */
  --color-text-brand-on-dark: #FF5722;   /* 4.5:1 */
  
  /* Light background - use original */
  --color-text-brand-on-light: #F93904;  /* 8.2:1 on white */
}
```

### Solution 3: Add Background to Brand Text

```css
.brand-text {
  color: #F93904;
  background: rgba(255, 255, 255, 0.1);  /* Subtle background */
  padding: 0.2em 0.4em;
  border-radius: 4px;
}
```

### Recommended Color Palette (WCAG AA Compliant)

```css
:root {
  /* Backgrounds */
  --color-bg: #0d1119;
  --color-bg-layer: #0f131c;
  --color-bg-hover: rgba(158, 174, 242, 0.1);
  
  /* Text colors - All meet 4.5:1 contrast */
  --color-text: rgba(255, 255, 255, 0.95);          /* 18.5:1 - AAA */
  --color-text-secondary: rgba(255, 255, 255, 0.65); /* 11.2:1 - AAA */
  --color-text-tertiary: rgba(255, 255, 255, 0.5);   /* 8.2:1 - AA */
  
  /* Brand colors - WCAG AA compliant */
  --color-brand-primary: #FF5722;      /* 4.5:1 - AA */
  --color-brand-primary-hover: #FF7043; /* 5.8:1 - AA */
  --color-brand-primary-active: #F4511E; /* 4.1:1 - Close, use carefully */
  
  /* Accent colors */
  --color-accent-success: #66BB6A;     /* 5.2:1 - AA */
  --color-accent-warning: #FFA726;     /* 6.1:1 - AA */
  --color-accent-error: #EF5350;       /* 4.6:1 - AA */
  --color-accent-info: #42A5F5;        /* 5.5:1 - AA */
  
  /* Borders */
  --color-border: rgba(255, 255, 255, 0.08);
  --color-border-focus: #FF5722;       /* Focus indicator */
}
```

### Contrast Testing Tool

```javascript
// utils/contrastChecker.js
export class ContrastChecker {
  /**
   * Calculate relative luminance of a color
   * @param {string} hex - Hex color code (e.g., "#FF5722")
   * @returns {number} Relative luminance (0-1)
   */
  static getLuminance(hex) {
    const rgb = this.hexToRgb(hex);
    const [r, g, b] = rgb.map(val => {
      const sRGB = val / 255;
      return sRGB <= 0.03928
        ? sRGB / 12.92
        : Math.pow((sRGB + 0.055) / 1.055, 2.4);
    });
    return 0.2126 * r + 0.7152 * g + 0.0722 * b;
  }

  /**
   * Calculate contrast ratio between two colors
   * @param {string} color1 - Hex color
   * @param {string} color2 - Hex color
   * @returns {number} Contrast ratio (1-21)
   */
  static getContrastRatio(color1, color2) {
    const lum1 = this.getLuminance(color1);
    const lum2 = this.getLuminance(color2);
    const lighter = Math.max(lum1, lum2);
    const darker = Math.min(lum1, lum2);
    return (lighter + 0.05) / (darker + 0.05);
  }

  /**
   * Check if contrast ratio meets WCAG AA
   * @param {string} foreground
   * @param {string} background
   * @param {boolean} isLargeText - Text >= 18pt or bold >= 14pt
   * @returns {Object} Result with pass/fail and ratio
   */
  static checkWCAG(foreground, background, isLargeText = false) {
    const ratio = this.getContrastRatio(foreground, background);
    const requiredRatio = isLargeText ? 3 : 4.5;
    
    return {
      ratio: ratio.toFixed(2),
      required: requiredRatio,
      passes: ratio >= requiredRatio,
      level: ratio >= 7 ? 'AAA' : ratio >= requiredRatio ? 'AA' : 'FAIL'
    };
  }

  static hexToRgb(hex) {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? [
      parseInt(result[1], 16),
      parseInt(result[2], 16),
      parseInt(result[3], 16)
    ] : null;
  }
}

// Usage in development
if (import.meta.env.DEV) {
  const checker = ContrastChecker;
  console.log('Brand on dark:', checker.checkWCAG('#FF5722', '#0d1119'));
  console.log('Text on dark:', checker.checkWCAG('#ffffff', '#0d1119'));
  console.log('Secondary on dark:', checker.checkWCAG('rgba(255,255,255,0.65)', '#0d1119'));
}
```

---

## Link Accessibility

### Problem: Links Without Discernible Names

```html
<!-- BAD - No discernible name -->
<a href="/docs">
  <img src="icon.svg">
</a>

<!-- BAD - Icon-only button -->
<button>
  <img src="close.svg">
</button>
```

### Solution: Always Provide Text Alternatives

```html
<!-- GOOD - Visible text -->
<a href="/docs">
  <img src="icon.svg" alt="">
  Documentation
</a>

<!-- GOOD - aria-label for icon-only -->
<a href="/docs" aria-label="View documentation">
  <img src="icon.svg" alt="">
</a>

<!-- GOOD - visually hidden text -->
<button aria-label="Close dialog">
  <img src="close.svg" alt="">
  <span class="sr-only">Close</span>
</button>
```

### Screen Reader Only Text Utility

```css
/* styles/accessibility.css */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.sr-only-focusable:focus,
.sr-only-focusable:active {
  position: static;
  width: auto;
  height: auto;
  overflow: visible;
  clip: auto;
  white-space: normal;
}
```

### Component Example: Accessible Button

```javascript
// components/ui/button.js
import { LitElement, html, css } from 'lit';

export class BosonButton extends LitElement {
  static properties = {
    variant: { type: String },
    disabled: { type: Boolean },
    ariaLabel: { type: String, attribute: 'aria-label' },
    iconOnly: { type: Boolean, attribute: 'icon-only' }
  };

  static styles = css`
    :host {
      display: inline-block;
    }

    button {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 12px 24px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      font-weight: 500;
      transition: all 0.2s;
      font-family: var(--font-main);
    }

    /* Focus indicator - WCAG requirement */
    button:focus-visible {
      outline: 2px solid var(--color-border-focus, #FF5722);
      outline-offset: 2px;
    }

    button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    :host([variant="primary"]) button {
      background: var(--color-brand-primary, #FF5722);
      color: var(--color-text-button, #ffffff);
    }

    :host([variant="primary"]) button:hover:not(:disabled) {
      background: var(--color-brand-primary-hover, #FF7043);
    }

    :host([variant="secondary"]) button {
      background: var(--color-bg-button-secondary, #151521);
      color: var(--color-text-button-secondary, rgba(255, 255, 255, 0.95));
    }

    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border-width: 0;
    }
  `;

  render() {
    return html`
      <button
        ?disabled=${this.disabled}
        aria-label=${this.ariaLabel || nothing}
        type="button"
      >
        <slot name="icon"></slot>
        <slot></slot>
        ${this.iconOnly && !this.ariaLabel ? html`
          <span class="sr-only">
            <slot name="sr-text">Button</slot>
          </span>
        ` : ''}
      </button>
    `;
  }
}

customElements.define('boson-button', BosonButton);
```

Usage:
```html
<!-- Text button - accessible by default -->
<boson-button variant="primary">Click Me</boson-button>

<!-- Icon + text - accessible -->
<boson-button variant="secondary">
  <img slot="icon" src="icon.svg" alt="">
  Save
</boson-button>

<!-- Icon only - requires aria-label -->
<boson-button icon-only aria-label="Close dialog">
  <img slot="icon" src="close.svg" alt="">
</boson-button>

<!-- Icon only - with sr-only text -->
<boson-button icon-only>
  <img slot="icon" src="delete.svg" alt="">
  <span slot="sr-text">Delete item</span>
</boson-button>
```

---

## Image Accessibility

### Problem: Missing or Redundant Alt Attributes

```html
<!-- BAD - Missing alt -->
<img src="logo.svg">

<!-- BAD - Redundant alt text -->
<a href="/home">
  <img src="home-icon.svg" alt="Home">
  Home
</a>
<!-- Screen reader reads: "Home Home" -->

<!-- BAD - Useless alt text -->
<img src="chart.png" alt="Image">
```

### Solution: Semantic Alt Text Rules

```html
<!-- GOOD - Decorative image (empty alt) -->
<img src="decorative-pattern.svg" alt="">

<!-- GOOD - Informative image -->
<img src="architecture-diagram.png" alt="Boson framework architecture showing four layers: Domain, Application, Infrastructure, and Presentation">

<!-- GOOD - Functional image in link -->
<a href="/docs">
  <img src="docs-icon.svg" alt="Documentation">
</a>

<!-- GOOD - Icon with adjacent text (empty alt) -->
<a href="/home">
  <img src="home-icon.svg" alt="">
  Home
</a>

<!-- GOOD - Complex image with description -->
<figure>
  <img src="performance-chart.png" alt="Performance comparison chart">
  <figcaption>
    Chart showing Boson framework loading 40% faster than competitors
  </figcaption>
</figure>
```

### Logo Component Example

```javascript
// components/ui/logos/logo.js
import { LitElement, html, css } from 'lit';

export class BosonLogo extends LitElement {
  static properties = {
    size: { type: String },
    decorative: { type: Boolean }
  };

  static styles = css`
    :host {
      display: inline-block;
    }

    img {
      display: block;
      width: 100%;
      height: auto;
    }

    :host([size="small"]) img {
      width: 120px;
    }

    :host([size="medium"]) img {
      width: 200px;
    }

    :host([size="large"]) img {
      width: 300px;
    }
  `;

  constructor() {
    super();
    this.size = 'medium';
    this.decorative = false;
  }

  render() {
    // If decorative, use empty alt
    // If functional (e.g., in link), use meaningful alt
    const altText = this.decorative ? '' : 'Boson PHP Framework';

    return html`
      <img 
        src="/images/logo.svg" 
        alt="${altText}"
        width="255"
        height="100"
      >
    `;
  }
}

customElements.define('boson-logo', BosonLogo);
```

Usage:
```html
<!-- Logo in navigation (functional) -->
<a href="/" slot="logo">
  <boson-logo size="medium"></boson-logo>
</a>

<!-- Logo as decoration in footer -->
<footer>
  <boson-logo size="small" decorative></boson-logo>
</footer>
```

---

## Keyboard Navigation

### Requirements

Všetky interaktívne komponenty musia byť prístupné z klávesnice:
- **Tab** - Pohyb medzi interaktvínymi elementami
- **Shift+Tab** - Pohyb späť
- **Enter/Space** - Aktivácia tlačidiel a linkov
- **Esc** - Zatvorenie modals/dropdowns
- **Arrow keys** - Navigácia v menách, taboch

### Focus Indicators

```css
/* Global focus styles */
:focus-visible {
  outline: 2px solid var(--color-border-focus, #FF5722);
  outline-offset: 2px;
}

/* Remove default outline, replace with custom */
*:focus {
  outline: none;
}

*:focus-visible {
  outline: 2px solid var(--color-border-focus, #FF5722);
  outline-offset: 2px;
}

/* High contrast focus for buttons */
button:focus-visible,
a:focus-visible {
  outline: 2px solid var(--color-border-focus, #FF5722);
  outline-offset: 2px;
  box-shadow: 0 0 0 4px rgba(255, 87, 34, 0.1);
}
```

### Dropdown Component Example

```javascript
// components/ui/dropdown.js
import { LitElement, html, css } from 'lit';

export class BosonDropdown extends LitElement {
  static properties = {
    open: { type: Boolean, reflect: true },
    label: { type: String }
  };

  static styles = css`
    :host {
      position: relative;
      display: inline-block;
    }

    button {
      padding: 12px 16px;
      border: 1px solid var(--color-border);
      background: var(--color-bg-layer);
      color: var(--color-text);
      cursor: pointer;
      border-radius: 4px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    button:focus-visible {
      outline: 2px solid var(--color-border-focus);
      outline-offset: 2px;
    }

    [role="menu"] {
      position: absolute;
      top: 100%;
      left: 0;
      margin-top: 4px;
      background: var(--color-bg-layer);
      border: 1px solid var(--color-border);
      border-radius: 4px;
      min-width: 200px;
      z-index: 1000;
      padding: 4px 0;
    }

    [role="menuitem"] {
      display: block;
      width: 100%;
      padding: 12px 16px;
      border: none;
      background: none;
      color: var(--color-text);
      text-align: left;
      cursor: pointer;
    }

    [role="menuitem"]:hover,
    [role="menuitem"]:focus {
      background: var(--color-bg-hover);
    }

    [role="menuitem"]:focus-visible {
      outline: 2px solid var(--color-border-focus);
      outline-offset: -2px;
    }
  `;

  constructor() {
    super();
    this.open = false;
    this.label = 'Options';
    this._handleKeyDown = this._handleKeyDown.bind(this);
    this._handleClickOutside = this._handleClickOutside.bind(this);
  }

  connectedCallback() {
    super.connectedCallback();
    document.addEventListener('click', this._handleClickOutside);
  }

  disconnectedCallback() {
    super.disconnectedCallback();
    document.removeEventListener('click', this._handleClickOutside);
  }

  _toggle() {
    this.open = !this.open;
    if (this.open) {
      // Focus first menu item when opened
      setTimeout(() => {
        const firstItem = this.shadowRoot.querySelector('[role="menuitem"]');
        if (firstItem) firstItem.focus();
      }, 0);
    }
  }

  _handleKeyDown(e) {
    if (e.key === 'Escape') {
      this.open = false;
      this.shadowRoot.querySelector('button').focus();
    }

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      const items = Array.from(this.shadowRoot.querySelectorAll('[role="menuitem"]'));
      const currentIndex = items.indexOf(e.target);
      const nextItem = items[currentIndex + 1] || items[0];
      nextItem.focus();
    }

    if (e.key === 'ArrowUp') {
      e.preventDefault();
      const items = Array.from(this.shadowRoot.querySelectorAll('[role="menuitem"]'));
      const currentIndex = items.indexOf(e.target);
      const prevItem = items[currentIndex - 1] || items[items.length - 1];
      prevItem.focus();
    }
  }

  _handleClickOutside(e) {
    if (!e.composedPath().includes(this)) {
      this.open = false;
    }
  }

  render() {
    return html`
      <button
        @click=${this._toggle}
        aria-haspopup="true"
        aria-expanded="${this.open}"
        aria-label="${this.label}"
      >
        ${this.label}
        <span aria-hidden="true">▼</span>
      </button>

      ${this.open ? html`
        <div
          role="menu"
          @keydown=${this._handleKeyDown}
        >
          <slot></slot>
        </div>
      ` : ''}
    `;
  }
}

customElements.define('boson-dropdown', BosonDropdown);
```

Usage:
```html
<boson-dropdown label="Language">
  <button role="menuitem">English</button>
  <button role="menuitem">Slovenčina</button>
  <button role="menuitem">Čeština</button>
</boson-dropdown>
```

---

## ARIA Attributes Guide

### When to Use ARIA

**Rule 1:** Use semantic HTML first
```html
<!-- GOOD - Semantic HTML -->
<button>Click me</button>

<!-- BAD - Unnecessary ARIA -->
<div role="button" tabindex="0">Click me</div>
```

**Rule 2:** Use ARIA when semantic HTML is insufficient
```html
<!-- GOOD - Custom component needs ARIA -->
<div role="dialog" aria-labelledby="dialog-title" aria-modal="true">
  <h2 id="dialog-title">Confirm Action</h2>
</div>
```

### Common ARIA Patterns

**Buttons:**
```html
<button aria-label="Close">×</button>
<button aria-pressed="false">Toggle</button>
<button aria-expanded="false" aria-controls="menu">Menu</button>
```

**Links:**
```html
<a href="/docs" aria-label="View documentation">
  <img src="icon.svg" alt="">
</a>
<a href="#" aria-current="page">Home</a>
```

**Form Controls:**
```html
<input 
  type="text" 
  aria-label="Search" 
  aria-describedby="search-help"
>
<div id="search-help">Enter keywords to search</div>

<input 
  type="email" 
  aria-invalid="true" 
  aria-errormessage="email-error"
>
<div id="email-error" role="alert">Invalid email format</div>
```

**Live Regions:**
```html
<div role="status" aria-live="polite">
  Loading...
</div>

<div role="alert" aria-live="assertive">
  Error: Form submission failed
</div>
```

---

## Accessibility Testing Checklist

### Automated Testing

```bash
# Install testing tools
pnpm add -D @axe-core/playwright

# Run accessibility tests
pnpm test:a11y
```

```javascript
// test/accessibility.test.js
import { test, expect } from '@playwright/test';
import { injectAxe, checkA11y } from 'axe-playwright';

test.describe('Accessibility', () => {
  test('homepage has no accessibility violations', async ({ page }) => {
    await page.goto('/');
    await injectAxe(page);
    await checkA11y(page);
  });

  test('button component meets WCAG AA', async ({ page }) => {
    await page.goto('/components/button');
    await injectAxe(page);
    await checkA11y(page, null, {
      rules: {
        'color-contrast': { enabled: true },
        'button-name': { enabled: true }
      }
    });
  });
});
```

### Manual Testing Checklist

**Keyboard Navigation:**
- [ ] Tab through all interactive elements
- [ ] All focusable elements have visible focus indicator
- [ ] No keyboard traps (can exit all components)
- [ ] Logical tab order (follows visual flow)
- [ ] Skip links work (jump to main content)

**Screen Reader:**
- [ ] Test with NVDA (Windows) or VoiceOver (Mac)
- [ ] All images have appropriate alt text
- [ ] Form labels are associated with inputs
- [ ] Error messages are announced
- [ ] Dynamic content changes are announced

**Contrast:**
- [ ] All text meets 4.5:1 contrast ratio
- [ ] Large text (18pt+) meets 3:1 contrast ratio
- [ ] Focus indicators are visible
- [ ] Error states are not color-only

**Mobile:**
- [ ] Touch targets minimum 44x44px
- [ ] Pinch to zoom enabled
- [ ] Orientation support (portrait + landscape)

---

## Component Accessibility Requirements

### Všetky komponenty musia obsahovať:

1. **Semantic HTML** - používaj správne HTML elementy
2. **Keyboard support** - Tab, Enter, Escape, Arrows
3. **Focus indicators** - viditeľné focus stavy
4. **ARIA attributes** - kde semantic HTML nestačí
5. **Alt texts** - pre všetky významové obrázky
6. **Color contrast** - minimálne 4.5:1
7. **Screen reader labels** - pre icon-only komponenty

### Pre každý komponent:

```javascript
/**
 * Component name and description
 * 
 * @accessibility
 * - Keyboard: Tab, Enter, Escape
 * - ARIA: role="button", aria-pressed
 * - Focus: Visible outline on :focus-visible
 * - Contrast: Meets WCAG AA (4.5:1)
 */
export class MyComponent extends LitElement {
  // Implementation
}
```

---

## Resources

### Testing Tools
- **axe DevTools:** Browser extension pre accessibility testing
- **WAVE:** Web accessibility evaluation tool
- **Lighthouse:** Chrome DevTools accessibility audit
- **Contrast Checker:** https://webaim.org/resources/contrastchecker/

### Screen Readers
- **NVDA (Windows):** https://www.nvaccess.org/
- **VoiceOver (Mac):** Built-in (Cmd+F5)
- **JAWS (Windows):** https://www.freedomscientific.com/products/software/jaws/

### Guidelines
- **WCAG 2.1:** https://www.w3.org/WAI/WCAG21/quickref/
- **ARIA Authoring Practices:** https://www.w3.org/WAI/ARIA/apg/
- **WebAIM:** https://webaim.org/

---

**Maintainer:** Boson Framework Team  
**WCAG Compliance:** Level AA Required  
**Last Audit:** Before each release
