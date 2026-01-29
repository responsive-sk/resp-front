// Import critical CSS first
import './app.css'

// Core components that are used on every page
import './components/ui/button.js';
import './components/ui/header.js';
import './components/ui/footer.js';
import './components/ui/logos/logo.js';
import './components/ui/search-input.js';

// Critical above-the-fold components (prevent layout shift)
import './components/sections/hero-section.js';
import './components/sections/segment-section.js';

// Layout components
import './layout/landing.js';
import './layout/default.js';
// import './layout/docs.js';
import './layout/blog.js';
import './layout/search.js';

// Lazy load Mermaid only when needed
let mermaidLoaded = false;
async function loadMermaid() {
    if (!mermaidLoaded) {
        const mermaid = await import('mermaid');
        mermaid.default.initialize({
            startOnLoad: true,
            theme: 'dark',
            themeVariables: {
                primaryColor: '#F93904',
                primaryTextColor: '#ffffff',
                primaryBorderColor: '#F93904',
                lineColor: '#ffffff',
                secondaryColor: '#0d1119',
                tertiaryColor: '#1a1f2e'
            }
        });
        mermaidLoaded = true;
        return mermaid.default;
    }
}

// Lazy load sections only when they appear in DOM (excluding critical above-the-fold)
const lazyLoadSections = {
    'call-to-action-section': () => import('./components/sections/call-to-action-section.js'),
    'how-it-works-section': () => import('./components/sections/how-it-works-section.js'),
    'mobile-development-section': () => import('./components/sections/mobile-development-section.js'),
    // 'nativeness-section': () => import('./components/sections/nativeness-section.js'),
    'right-choice-section': () => import('./components/sections/right-choice-section.js'),
    // 'solves-section': () => import('./components/sections/solves-section.js'),
    // 'testimonials-section': () => import('./components/sections/testimonials-section.js'),
    // 'docs-toc': () => import('./components/sections/docs-toc.js')
};

// Lazy load UI components only when needed
const lazyLoadUI = {
    'boson-dropdown': () => import('./components/ui/dropdown.js'),
    'boson-breadcrumbs': () => import('./components/ui/breadcrumbs.js'),
    'mobile-header-menu': () => import('./components/ui/mobile-header-menu.js'),
    'dots-container': () => import('./components/ui/dots-container.js'),
    'horizontal-accordion': () => import('./components/ui/horizontal-accordion.js'),
    // 'boson-slider': () => import('./components/ui/slider.js'),
    'boson-subtitle': () => import('./components/ui/subtitle.js'),
    'boson-page-title': () => import('./components/ui/page-title.js')
};

// Intersection Observer for lazy loading components
const componentObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const tagName = entry.target.tagName.toLowerCase();

            // Load section components
            if (lazyLoadSections[tagName]) {
                lazyLoadSections[tagName]().then(() => {
                    console.log(`Lazy loaded: ${tagName}`);
                });
                componentObserver.unobserve(entry.target);
            }

            // Load UI components
            if (lazyLoadUI[tagName]) {
                lazyLoadUI[tagName]().then(() => {
                    console.log(`Lazy loaded: ${tagName}`);
                });
                componentObserver.unobserve(entry.target);
            }

            // Load Mermaid when mermaid diagrams are found
            if (entry.target.classList.contains('mermaid') || entry.target.querySelector('.mermaid') || entry.target.hasAttribute('data-lang')) {
                loadMermaid();
                componentObserver.unobserve(entry.target);
            }
        }
    });
}, {
    rootMargin: '10px' // Load just before element comes into view
});

// Observe all custom elements and mermaid containers
function observeComponents() {
    // Observe section components
    Object.keys(lazyLoadSections).forEach(tagName => {
        document.querySelectorAll(tagName).forEach(el => {
            componentObserver.observe(el);
        });
    });

    // Observe UI components
    Object.keys(lazyLoadUI).forEach(tagName => {
        document.querySelectorAll(tagName).forEach(el => {
            componentObserver.observe(el);
        });
    });

    // Observe mermaid containers
    document.querySelectorAll('.mermaid, [data-lang="mermaid"]').forEach(el => {
        componentObserver.observe(el);
    });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', observeComponents);
} else {
    observeComponents();
}
