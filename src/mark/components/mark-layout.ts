import { LitElement, html, css } from 'lit'
import { customElement, property } from 'lit/decorators.js'

@customElement('mark-layout')
export class MarkLayout extends LitElement {
  @property({ type: String }) title = 'Mark Dashboard'
  @property({ type: String }) activeMenu = 'dashboard'

  static styles = css`
    :host {
      display: block;
      --sl-color-primary-50: #f0f9ff;
      --sl-color-primary-100: #e0f2fe;
      --sl-color-primary-200: #bae6fd;
      --sl-color-primary-300: #7dd3fc;
      --sl-color-primary-400: #38bdf8;
      --sl-color-primary-500: #0ea5e9;
      --sl-color-primary-600: #0284c7;
      --sl-color-primary-700: #0369a1;
      --sl-color-primary-800: #075985;
      --sl-color-primary-900: #0c4a6e;

      /* Dark theme as default */
      --sl-color-neutral-0: #0f172a;
      --sl-color-neutral-50: #1e293b;
      --sl-color-neutral-100: #334155;
      --sl-color-neutral-200: #475569;
      --sl-color-neutral-300: #64748b;
      --sl-color-neutral-400: #94a3b8;
      --sl-color-neutral-500: #cbd5e1;
      --sl-color-neutral-600: #e2e8f0;
      --sl-color-neutral-700: #f1f5f9;
      --sl-color-neutral-800: #f8fafc;
      --sl-color-neutral-900: #ffffff;

      color-scheme: dark;
    }

    .layout {
      min-height: 100vh;
      background: var(--sl-color-neutral-0);
      color: var(--sl-color-neutral-900);
      transition:
        background-color 0.3s ease,
        color 0.3s ease;
    }
  `

  connectedCallback() {
    super.connectedCallback()
    // Set dark theme by default
    document.documentElement.setAttribute('data-theme', 'dark')
  }

  render() {
    return html`
      <div class="layout">
        <slot></slot>
      </div>
    `
  }
}
