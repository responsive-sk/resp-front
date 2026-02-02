//import mermaid from 'mermaid';
console.log('=== APP START ===');
// Import core components only
import './components/ui/header';
import './components/ui/footer';
import './components/ui/button';

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
//import './components/sections/docs-toc';

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

import { initPJAX } from './lib/pjax';
import './app.css';

// Debug global state
console.log('PJAX_LOADED before:', window.PJAX_LOADED);

function startApp() {
    console.log('Starting app...');

    try {
        initPJAX();
        console.log('PJAX initialized');
        console.log('PJAX_LOADED after:', window.PJAX_LOADED);
    } catch (error) {
        console.error('App failed:', error);
        console.trace(); // Stack trace
    }
}

// Type declaration
declare global {
    interface Window {
        PJAX_LOADED?: boolean;
    }
}

// Start
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM loaded, starting app');
        startApp();
    });
} else {
    console.log('DOM already ready, starting app');
    startApp();
}
