// resp-front/src/lib/simple-ajax.ts
// Jednoduché HTMX-like riešenie bez externých závislostí

export function initSimpleAjax() {
    console.log('SimpleAJAX: Initializing...');
    
    // Set global flag
    window.SIMPLE_AJAX_LOADED = true;
    
    // Nájsť kontajner
    let container = document.querySelector('[data-pjax-container]') || 
                   document.querySelector('main[data-container]') || 
                   document.querySelector('main');
    
    if (!container) {
        console.warn('SimpleAJAX: No container found');
        return;
    }
    
    console.log('SimpleAJAX: Container found:', container);
    
    // Event listener pre všetky linky s data-ajax atribútom
    document.addEventListener('click', async (e) => {
        const target = e.target as HTMLElement;
        const link = target.closest('a[href]');
        
        if (!link) return;
        
        // Skontrolovať, či je to AJAX link
        const isAjaxLink = link.hasAttribute('data-ajax') || 
                          link.hasAttribute('data-pjax');
        
        if (!isAjaxLink) {
            console.log('SimpleAJAX: Not an AJAX link');
            return;
        }
        
        e.preventDefault();
        
        const url = link.getAttribute('href');
        if (!url) return;
        
        console.log('SimpleAJAX: Loading:', url);
        
        try {
            // Show loading
            document.body.classList.add('ajax-loading');
            
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const html = await response.text();
            
            // Update kontajner
            container.innerHTML = html;
            
            // Update URL
            history.pushState({}, '', url);
            
            // Update title
            const titleMatch = html.match(/<title>(.*?)<\/title>/);
            if (titleMatch) {
                document.title = titleMatch[1];
            }
            
            console.log('SimpleAJAX: Loaded successfully');
            
        } catch (error) {
            console.error('SimpleAJAX: Error:', error);
            // Fallback na normálnu navigáciu
            window.location.href = url;
        } finally {
            document.body.classList.remove('ajax-loading');
        }
    });
}

// Auto-inicializácia
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSimpleAjax);
} else {
    initSimpleAjax();
}
