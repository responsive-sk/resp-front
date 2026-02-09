// Type declaration
export {}; // Toto spraví súbor modulom

import './types/htmx.d.ts';

declare global {
    interface Window {
        PJAX_LOADED?: boolean;
        SIMPLE_AJAX_LOADED?: boolean;
        HTMX_LOADED?: boolean;
        reinitializeComponents?: () => void;
        initPJAX?: () => void;
    }
}

console.log('=== APP START ===');

console.log('HTMX loaded:', !!window.htmx);

if (window.htmx) {
  // Konfigurace
  window.htmx.config.includeIndicatorStyles = false;
  window.htmx.config.indicatorClass = 'htmx-indicator';
  window.htmx.config.requestClass = 'htmx-request';
  
  // Event listeners
  document.addEventListener('htmx:afterSwap', (event: any) => {
    console.log('HTMX swapped content:', event.detail.pathInfo?.requestPath);
    
    // Reinitialize any custom components after swap
    if (window.reinitializeComponents) {
      window.reinitializeComponents();
    }
  });
  
  document.addEventListener('htmx:beforeRequest', (event: any) => {
    console.log('HTMX: Request to', event.detail.pathInfo?.requestPath);
  });
  
  document.addEventListener('htmx:afterRequest', (event: any) => {
    console.log('HTMX: Request completed', event.detail.successful);
  });
  
  // Automaticky boost všechny odkazy a formuláře
  document.body.setAttribute('hx-boost', 'true');
  
  console.log('HTMX initialized successfully');
} else {
  console.warn('HTMX not found!');
}

// Import layouts
import './layout/landing';
import './layout/default';
//import './layout/docs';

import './components/sections/segment-section';
import './components/sections/call-to-action-section';
import './components/sections/hero-section';
import './components/sections/how-it-works-section';
import './components/sections/mobile-development-section';
import './components/sections/nativeness-section';
import './components/sections/right-choice-section';
import './components/sections/solves-section';
import './components/sections/testimonials-section';
import './components/sections/gallery-section';
import './components/sections/hero-slider-section';

// import './components/ui/dropdown';
import './components/ui/breadcrumbs';
import './components/ui/mobile-header-menu';
import './components/ui/button';
// import './components/ui/dots-container';
import './components/ui/footer';
import './components/ui/header';
import './components/ui/horizontal-accordion';
import './components/ui/slider';
import './components/ui/search-input';
import './components/ui/subtitle';
import './components/ui/page-title';
// import './components/ui/logos/logo';

import './layout/landing';
import './layout/default';
// import './layout/docs';
import './layout/search';
import './components/sections/horizontal-scroll-hero';
import './layout/hero-layout';
import './components/fullscreen-hero';
import './components/sections/blog-list-section';
import './components/sections/article-detail-section';

// Import AG components
import './components/ag/Card/core/Card';

// Rest of your imports...
import './app.css';

// PJAX integrace pokud existuje
if (window.initPJAX) {
  window.initPJAX();
}

console.log('App fully loaded');
