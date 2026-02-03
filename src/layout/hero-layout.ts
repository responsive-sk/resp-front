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

    /* Footer */
    .hero-footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      color: rgba(255, 255, 255, 0.6);
      font-family: 'Inter', sans-serif;
      font-size: 12px;
    }

    .social-links {
      display: flex;
      gap: 16px;
    }

    .social-link {
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .social-link:hover {
      color: white;
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
      
      .hero-footer {
        padding: 16px 20px;
        flex-direction: column;
        gap: 8px;
        text-align: center;
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

    @property({ type: Array })
    socialLinks = [
        { label: 'Facebook', href: 'https://facebook.com' },
        { label: 'Instagram', href: 'https://instagram.com' },
        { label: 'LinkedIn', href: 'https://linkedin.com' }
    ];

    @property({ type: String })
    copyright = '© 2024 Your Company. All rights reserved.';

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

      <!-- Fixed Footer -->
      <footer class="hero-footer">
        <div class="copyright">${this.copyright}</div>
        
        <div class="social-links">
          ${this.socialLinks.map((social: any) => html`
            <a href="${social.href}" class="social-link" target="_blank" rel="noopener">
              ${social.label}
            </a>
          `)}
        </div>
      </footer>
    `;
    }
}

declare global {
    interface HTMLElementTagNameMap {
        'hero-layout': HeroLayout;
    }
}
