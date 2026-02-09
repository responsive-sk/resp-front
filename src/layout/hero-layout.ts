// src/layout/hero-layout.ts
import { html, css, LitElement } from 'lit';
import { customElement, property, state } from 'lit/decorators.js';

@customElement('hero-layout')
export class HeroLayout extends LitElement {
    static styles = css`
    :host {
      display: block;
      width: 100vw;
      height: 100vh;
      position: relative;
      overflow: hidden;
    }

    /* Fixed header */
    .hero-header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 24px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      background: linear-gradient(to bottom, rgba(13, 17, 25, 0.9), transparent);
      transition: all 0.3s ease;
    }

    .hero-header.scrolled {
      background: rgba(13, 17, 25, 0.95);
      backdrop-filter: blur(10px);
      padding: 16px 40px;
    }

    .logo {
      font-family: 'Roboto Condensed', sans-serif;
      font-size: 24px;
      font-weight: 700;
      color: white;
      text-decoration: none;
    }

    .nav-links {
      display: flex;
      gap: 32px;
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.8);
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      transition: color 0.3s ease;
    }

    .nav-link:hover {
      color: white;
    }

    /* Main content slot */
    .hero-main {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    @media (max-width: 768px) {
      .hero-header {
        padding: 16px 20px;
      }
      
      .hero-header.scrolled {
        padding: 12px 20px;
      }
      
      .nav-links {
        gap: 16px;
      }
    }
  `;

    @property({ type: String })
    logoText = 'LOGO';

    @property({ type: String })
    logoLink = '/';

    @property({ type: Array })
    navigation = [
        { label: 'Work', href: '/work' },
        { label: 'Services', href: '/services' },
        { label: 'About', href: '/about' },
        { label: 'Contact', href: '/contact' }
    ];

    @state()
    private _isScrolled = false;

    firstUpdated() {
        window.addEventListener('scroll', this._handleScroll);
    }

    disconnectedCallback() {
        window.removeEventListener('scroll', this._handleScroll);
        super.disconnectedCallback();
    }

    private _handleScroll = () => {
        this._isScrolled = window.scrollY > 50;
    };

    render() {
        return html`
      <!-- Fixed Header -->
      <header class="hero-header ${this._isScrolled ? 'scrolled' : ''}">
        <a href="${this.logoLink}" class="logo">${this.logoText}</a>
        
        <nav class="nav-links">
          ${this.navigation.map((link: any) => html`
            <a href="${link.href}" class="nav-link">${link.label}</a>
          `)}
        </nav>
      </header>

      <!-- Main Content Slot -->
      <main class="hero-main">
        <slot></slot>
      </main>
    `;
    }
}

declare global {
    interface HTMLElementTagNameMap {
        'hero-layout': HeroLayout;
    }
}
