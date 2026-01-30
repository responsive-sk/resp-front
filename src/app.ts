// Import critical CSS first
import './app.css';

// Core components that are used on every page
import './components/ui/button.ts';
import './components/ui/header.ts';
import './components/ui/footer.ts';
import './components/ui/logos/logo.ts';
import './components/ui/search-input.ts';

// Critical above-the-fold components (prevent layout shift)
import './components/sections/hero-section.ts';
import './components/sections/segment-section.ts';

// Layout components
import './layout/landing.ts';
import './layout/default.ts';
// import './layout/docs.ts';
import './layout/blog.ts';
import './layout/search.ts';

// Lazy load Mermaid only when needed
let mermaidLoaded = false;
async function loadMermaid(): Promise<any> {
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
        tertiaryColor: '#1a1f2e',
      },
    });
    mermaidLoaded = true;
    return mermaid.default;
  }
}

// Lazy load sections only when they appear in DOM (excluding critical above-the-fold)
type LazyLoadMap = {
  [key: string]: () => Promise<any>;
};

const lazyLoadSections: LazyLoadMap = {
  'article-list-section': () => import('./components/sections/article-list-section.ts'),
  'call-to-action-section': () => import('./components/sections/call-to-action-section.ts'),
  'how-it-works-section': () => import('./components/sections/how-it-works-section.ts'),
  'mobile-development-section': () => import('./components/sections/mobile-development-section.ts'),
  // 'nativeness-section': () => import('./components/sections/nativeness-section.ts'),
  'right-choice-section': () => import('./components/sections/right-choice-section.ts'),
  // 'solves-section': () => import('./components/sections/solves-section.ts'),
  // 'testimonials-section': () => import('./components/sections/testimonials-section.ts'),
  // 'docs-toc': () => import('./components/sections/docs-toc.ts')
};

// Lazy load UI components only when needed
const lazyLoadUI: LazyLoadMap = {
  'boson-dropdown': () => import('./components/ui/dropdown.ts'),
  'boson-breadcrumbs': () => import('./components/ui/breadcrumbs.ts'),
  'mobile-header-menu': () => import('./components/ui/mobile-header-menu.ts'),
  'dots-container': () => import('./components/ui/dots-container.ts'),
  'horizontal-accordion': () => import('./components/ui/horizontal-accordion.ts'),
  // 'boson-slider': () => import('./components/ui/slider.ts'),
  'boson-subtitle': () => import('./components/ui/subtitle.ts'),
  'boson-page-title': () => import('./components/ui/page-title.ts'),
};

// Intersection Observer for lazy loading components
const componentObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
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
        if (
          entry.target.classList.contains('mermaid') ||
          entry.target.querySelector('.mermaid') ||
          entry.target.hasAttribute('data-lang')
        ) {
          loadMermaid();
          componentObserver.unobserve(entry.target);
        }
      }
    });
  },
  {
    rootMargin: '10px', // Load just before element comes into view
  }
);

// Observe all custom elements and mermaid containers
function observeComponents(): void {
  // Observe section components
  Object.keys(lazyLoadSections).forEach((tagName) => {
    document.querySelectorAll(tagName).forEach((el) => {
      componentObserver.observe(el);
    });
  });

  // Observe UI components
  Object.keys(lazyLoadUI).forEach((tagName) => {
    document.querySelectorAll(tagName).forEach((el) => {
      componentObserver.observe(el);
    });
  });

  // Observe mermaid containers
  document.querySelectorAll('.mermaid, [data-lang="mermaid"]').forEach((el) => {
    componentObserver.observe(el);
  });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', observeComponents);
} else {
  observeComponents();
}
