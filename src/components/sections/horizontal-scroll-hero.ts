// src/components/sections/horizontal-scroll-hero.ts
import { html, css, LitElement } from 'lit';
import { customElement, property, state } from 'lit/decorators.js';
import { styleMap } from 'lit/directives/style-map.js';

export interface HorizontalSlide {
    id: string;
    titleLine1: string;
    titleLine2?: string;
    subtitle?: string;
    tag?: string;
    link: string;
    backgroundImage: string;
    backgroundImageMobile?: string;
    themeColor: string;
    textColor?: string;
    buttonText?: string;
}

@customElement('horizontal-scroll-hero')
export class HorizontalScrollHero extends LitElement {
    static styles = css`
    :host {
      display: block;
      width: 100vw;
      height: 100vh;
      min-height: 700px;
      position: relative;
      overflow: hidden;
      background: #0d1119;
    }

    * {
      box-sizing: border-box;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Main container for horizontal scroll */
    .horizontal-scroll-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    /* Slides wrapper - moves horizontally */
    .slides-wrapper {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      will-change: transform;
    }

    /* Individual slide */
    .slide {
      flex: 0 0 100vw;
      width: 100vw;
      height: 100vh;
      position: relative;
      overflow: hidden;
    }

    /* Slide background */
    .slide-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      transition: transform 1.5s cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .slide-bg::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        90deg,
        rgba(0, 0, 0, 0.8) 0%,
        rgba(0, 0, 0, 0.6) 30%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.2) 70%,
        transparent 100%
      );
    }

    /* Slide content */
    .slide-content {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      padding: 0 10%;
      z-index: 2;
    }

    .text-content {
      max-width: 600px;
      position: relative;
      z-index: 3;
    }

    /* Tag */
    .slide-tag {
      display: inline-block;
      font-family: 'Roboto Condensed', sans-serif;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: #FF5722;
      margin-bottom: 20px;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.8s cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .slide.active .slide-tag {
      opacity: 1;
      transform: translateY(0);
      transition-delay: 0.2s;
    }

    /* Title */
    .title-line {
      display: block;
      overflow: hidden;
      margin-bottom: 8px;
    }

    .title-text {
      display: block;
      font-family: 'Roboto Condensed', sans-serif;
      font-weight: 700;
      font-size: clamp(3rem, 8vw, 5.5rem);
      line-height: 1.1;
      color: #FFFFFF;
      transform: translateY(100%);
      transition: transform 0.9s cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .slide.active .title-text {
      transform: translateY(0);
    }

    .title-line:nth-child(1) .title-text {
      transition-delay: 0.3s;
    }

    .title-line:nth-child(2) .title-text {
      transition-delay: 0.5s;
    }

    /* Subtitle */
    .subtitle {
      font-family: 'Inter', sans-serif;
      font-size: clamp(1.125rem, 2.5vw, 1.5rem);
      line-height: 1.6;
      color: rgba(255, 255, 255, 0.8);
      margin-top: 24px;
      max-width: 500px;
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .slide.active .subtitle {
      opacity: 1;
      transform: translateY(0);
      transition-delay: 0.7s;
    }

    /* Action Button */
    .action-button {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      margin-top: 40px;
      padding: 16px 32px;
      background: rgba(255, 87, 34, 0.1);
      border: 1px solid rgba(255, 87, 34, 0.3);
      border-radius: 50px;
      color: #FFFFFF;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 500;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      opacity: 0;
      transform: translateY(20px);
    }

    .slide.active .action-button {
      opacity: 1;
      transform: translateY(0);
      transition: all 0.8s cubic-bezier(0.215, 0.61, 0.355, 1) 0.9s;
    }

    .action-button:hover {
      background: rgba(255, 87, 34, 0.2);
      border-color: rgba(255, 87, 34, 0.5);
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(255, 87, 34, 0.3);
    }

    .button-icon {
      font-size: 20px;
      transition: transform 0.3s ease;
    }

    .action-button:hover .button-icon {
      transform: translateX(4px);
    }

    /* Scroll hint */
    .scroll-hint {
      position: absolute;
      bottom: 40px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, 0.6);
      font-family: 'Inter', sans-serif;
      font-size: 12px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      z-index: 10;
      opacity: 0;
      animation: fadeIn 1s ease 2s forwards;
    }

    @keyframes fadeIn {
      to { opacity: 1; }
    }

    .mouse-wheel {
      width: 24px;
      height: 40px;
      border: 2px solid rgba(255, 255, 255, 0.6);
      border-radius: 12px;
      position: relative;
    }

    .mouse-wheel::after {
      content: '';
      position: absolute;
      top: 8px;
      left: 50%;
      width: 4px;
      height: 4px;
      background: rgba(255, 255, 255, 0.8);
      border-radius: 50%;
      transform: translateX(-50%);
      animation: scrollHint 2s infinite;
    }

    @keyframes scrollHint {
      0%, 100% { transform: translateX(-50%) translateY(0); opacity: 0.8; }
      50% { transform: translateX(-50%) translateY(8px); opacity: 1; }
    }

    /* Progress bar */
    .progress-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: rgba(255, 255, 255, 0.1);
      z-index: 1000;
    }

    .progress-bar {
      height: 100%;
      background: linear-gradient(90deg, #FF5722, #FF7043);
      width: 0%;
      transition: width 0.3s ease;
    }

    /* Slide counter */
    .slide-counter {
      position: fixed;
      bottom: 40px;
      right: 40px;
      font-family: 'Roboto Condensed', sans-serif;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.6);
      z-index: 100;
    }

    .counter-current {
      color: white;
      font-size: 24px;
      font-weight: 700;
    }

    .counter-total {
      font-size: 14px;
    }

    /* Mobile styles */
    @media (max-width: 768px) {
      .slide-content {
        padding: 0 5%;
      }

      .slide-counter {
        bottom: 20px;
        right: 20px;
      }

      .action-button {
        padding: 14px 28px;
      }
    }
  `;

    @property({ type: Array })
    slides: HorizontalSlide[] = [];

    @property({ type: Number })
    autoplayInterval = 4000; // 4 seconds

    @property({ type: Boolean })
    showNavigation = true;

    @property({ type: Boolean })
    showScrollHint = true;

    @state()
    private _currentSlide = 0;

    @state()
    private _isAnimating = false;

    @state()
    private _autoplayTimer: any = null;

    @state()
    private _wheelTimeout: any = null;

    @state()
    private _scrollProgress = 0;

    @state()
    private _touchStartX = 0;
    @state()
    private _touchStartY = 0;

    private _container!: HTMLElement;
    private _wheelBlocked = false;

    firstUpdated() {
        this._container = this.shadowRoot?.querySelector('.slides-wrapper') as HTMLElement;
        this._setupEventListeners();
        this._startAutoplay();
        this._updateSlidePosition();
    }

    connectedCallback() {
        super.connectedCallback();
        // Prevent body scroll
        if (this._container) {
            this._container.style.overflow = 'hidden';
        }
        // document.body.style.overflow = 'hidden'; // ODSTRÁNIŤ - neblokovať vertikálny scroll
    }

    disconnectedCallback() {
        this._stopAutoplay();
        this._cleanupEventListeners();
        // Restore body scroll
        if (this._container) {
            this._container.style.overflow = '';
        }
        // document.body.style.overflow = ''; // ODSTRÁNIŤ - neblokovať vertikálny scroll
        super.disconnectedCallback();
    }

    private _setupEventListeners() {
        // Mouse wheel
        this.addEventListener('wheel', this._handleWheel, { passive: false });

        // Keyboard navigation
        document.addEventListener('keydown', this._handleKeyDown);

        // Touch for mobile
        this.addEventListener('touchstart', this._handleTouchStart, { passive: true });
        this.addEventListener('touchend', this._handleTouchEnd, { passive: true });

        // Resize
        window.addEventListener('resize', this._handleResize);
    }

    private _cleanupEventListeners() {
        this.removeEventListener('wheel', this._handleWheel);
        document.removeEventListener('keydown', this._handleKeyDown);
        this.removeEventListener('touchstart', this._handleTouchStart);
        this.removeEventListener('touchend', this._handleTouchEnd);
        window.removeEventListener('resize', this._handleResize);
    }

    private _handleResize = () => {
        this._updateSlidePosition();
    };

    private _handleTouchStart = (e: TouchEvent) => {
        this._touchStartX = e.touches[0].clientX;
        this._touchStartY = e.touches[0].clientY;
    };

    private _handleTouchEnd = (e: TouchEvent) => {
        const touchEndX = e.changedTouches[0].clientX;
        const touchEndY = e.changedTouches[0].clientY;

        const deltaX = touchEndX - this._touchStartX;
        const deltaY = touchEndY - this._touchStartY;

        // Only handle horizontal swipes with minimal vertical movement
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
            e.preventDefault();
            if (deltaX > 0) {
                this._prevSlide();
            } else {
                this._nextSlide();
            }
        }
    };

    private _handleWheel = (e: WheelEvent) => {
        if (this._isAnimating || this._wheelBlocked) return;

        // Block vertical scroll
        if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
            e.preventDefault();

            // Block rapid wheel scrolling
            this._wheelBlocked = true;
            clearTimeout(this._wheelTimeout);
            this._wheelTimeout = setTimeout(() => {
                this._wheelBlocked = false;
            }, 800);

            if (e.deltaY > 0) {
                this._nextSlide();
            } else {
                this._prevSlide();
            }
        }
    };

    private _handleKeyDown = (e: KeyboardEvent) => {
        if (this._isAnimating) return;

        switch (e.key) {
            case 'ArrowLeft':
            case 'ArrowUp':
                e.preventDefault();
                this._prevSlide();
                break;
            case 'ArrowRight':
            case 'ArrowDown':
            case ' ':
                e.preventDefault();
                this._nextSlide();
                break;
            case 'Home':
                e.preventDefault();
                this._goToSlide(0);
                break;
            case 'End':
                e.preventDefault();
                this._goToSlide(this.slides.length - 1);
                break;
        }
    };

    private _startAutoplay() {
        if (this.autoplayInterval > 0 && this.slides.length > 1) {
            this._autoplayTimer = setInterval(() => {
                this._nextSlide();
            }, this.autoplayInterval);
        }
    }

    private _stopAutoplay() {
        if (this._autoplayTimer) {
            clearInterval(this._autoplayTimer);
            this._autoplayTimer = null;
        }
    }

    private _goToSlide(index: number) {
        if (this._isAnimating || index < 0 || index >= this.slides.length || index === this._currentSlide) {
            return;
        }

        this._isAnimating = true;
        this._currentSlide = index;

        // Update progress
        this._scrollProgress = (index / (this.slides.length - 1)) * 100;

        // Restart autoplay timer
        this._stopAutoplay();
        this._startAutoplay();

        // Update slide position
        this._updateSlidePosition();

        // Reset animation flag
        setTimeout(() => {
            this._isAnimating = false;
        }, 1200);
    }

    private _nextSlide() {
        const nextIndex = (this._currentSlide + 1) % this.slides.length;
        this._goToSlide(nextIndex);
    }

    private _prevSlide() {
        const prevIndex = this._currentSlide === 0
            ? this.slides.length - 1
            : this._currentSlide - 1;
        this._goToSlide(prevIndex);
    }

    private _updateSlidePosition() {
        if (this._container) {
            const translateX = -this._currentSlide * 100;
            this._container.style.transform = `translateX(${translateX}vw)`;
        }
    }

    private _onMouseEnter() {
        this._stopAutoplay();
    }

    private _onMouseLeave() {
        this._startAutoplay();
    }

    renderSlide(slide: HorizontalSlide, index: number) {
        const isActive = index === this._currentSlide;
        const bgImage = window.innerWidth < 768 && slide.backgroundImageMobile
            ? slide.backgroundImageMobile
            : slide.backgroundImage;

        return html`
      <div class="slide ${isActive ? 'active' : ''}" data-id="${slide.id}">
        <div 
          class="slide-bg"
          style=${styleMap({
            backgroundImage: `url('${bgImage}')`,
            transform: isActive ? 'scale(1.05)' : 'scale(1)'
        })}
        ></div>
        
        <div class="slide-content">
          <div class="text-content">
            ${slide.tag ? html`
              <div class="slide-tag">${slide.tag}</div>
            ` : ''}
            
            <div class="title-line">
              <span class="title-text">${slide.titleLine1}</span>
            </div>
            
            ${slide.titleLine2 ? html`
              <div class="title-line">
                <span class="title-text">${slide.titleLine2}</span>
              </div>
            ` : ''}
            
            ${slide.subtitle ? html`
              <div class="subtitle">${slide.subtitle}</div>
            ` : ''}
            
            <a 
              href="${slide.link}" 
              class="action-button"
              @click=${(e: Event) => {
                if (slide.link.startsWith('#')) {
                    e.preventDefault();
                    // Handle internal navigation
                    window.dispatchEvent(new CustomEvent('pjax:navigate', {
                        detail: { url: slide.link }
                    }));
                }
            }}
            >
              ${slide.buttonText || 'Read More'}
              <span class="button-icon">→</span>
            </a>
          </div>
        </div>
      </div>
    `;
    }

    render() {
        if (!this.slides.length) return html``;

        return html`
      <div 
        class="horizontal-scroll-container"
        @mouseenter=${this._onMouseEnter}
        @mouseleave=${this._onMouseLeave}
      >
        <!-- Progress bar -->
        <div class="progress-container">
          <div class="progress-bar" style="width: ${this._scrollProgress}%"></div>
        </div>
        
        <!-- Slides -->
        <div class="slides-wrapper">
          ${this.slides.map((slide, index) =>
            this.renderSlide(slide, index)
        )}
        </div>
        
        <!-- Scroll hint -->
        ${this.showScrollHint && this.slides.length > 1 ? html`
          <div class="scroll-hint">
            <div class="mouse-wheel"></div>
            <span>Scroll to navigate</span>
          </div>
        ` : ''}
        
        <!-- Slide counter -->
        ${this.slides.length > 1 ? html`
          <div class="slide-counter">
            <span class="counter-current">${this._currentSlide + 1}</span>
            <span class="counter-total">/${this.slides.length}</span>
          </div>
        ` : ''}
      </div>
    `;
    }
}

declare global {
    interface HTMLElementTagNameMap {
        'horizontal-scroll-hero': HorizontalScrollHero;
    }
}
