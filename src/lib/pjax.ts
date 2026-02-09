// resp-front/src/lib/pjax.ts
export function initPJAX() {
    // Set global flag
    window.PJAX_LOADED = true;

    // Find container - skúsiť viacero možností
    let container = document.querySelector('[data-container]');
    if (!container) {
        container = document.querySelector('main[data-container]');
    }
    if (!container) {
        container = document.querySelector('main');
    }
    if (!container) {
        container = document.querySelector('[data-pjax-container]');
    }

    if (!container) {
        console.warn('PJAX: No container found');
        return;
    }

    console.log('PJAX: Container found:', container);
    console.log('PJAX: Container selector:', container.tagName + (container.id ? '#' + container.id : '') + (container.className ? '.' + container.className.split(' ').join('.') : ''));

    // Event listener for clicks
    document.addEventListener('click', async (e) => {
        console.log('PJAX: Click detected on:', e.target);
        
        // Look for any element with href attribute
        const linkElement = (e.target as HTMLElement).closest('a, [href]');

        if (!linkElement) {
            console.log('PJAX: No link element found');
            return;
        }

        // Get href from the element
        const href = linkElement.getAttribute('href');
        if (!href) {
            console.log('PJAX: No href found');
            return;
        }

        console.log('PJAX: Link found with href:', href);

        // Check if it's a PJAX link
        const isPjaxLink = linkElement.hasAttribute('data-pjax');
        
        console.log('PJAX: Has data-pjax:', isPjaxLink);
        
        if (!isPjaxLink) {
            console.log('PJAX: Not a PJAX link, skipping');
            return;
        }

        console.log('PJAX: Link clicked:', (linkElement as HTMLAnchorElement).href);
        console.log('PJAX: Link element:', linkElement);

        // Check conditions
        const target = linkElement.getAttribute('target');

        if (target) {
            return;
        }
        if (href.includes('#')) {
            return;
        }

        // Build full URL for origin check
        const fullUrl = new URL(href, window.location.href);

        if (fullUrl.origin !== window.location.origin) {
            return;
        }

        // Prevent default
        e.preventDefault();

        // Show loading
        document.body.classList.add('pjax-loading');

        try {
            const response = await fetch(fullUrl.href, {
                headers: {
                    'X-PJAX': 'true',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const pjaxHeader = response.headers.get('X-PJAX');
            const contentType = response.headers.get('content-type');

            if (pjaxHeader === 'true' && contentType?.includes('application/json')) {
                const data = await response.json();

                // Update page
                if (data.title) {
                    document.title = data.title;
                }

                if (data.content) {
                    // Check if layout changed by looking for specific elements
                    const newContent = document.createElement('div');
                    newContent.innerHTML = data.content;
                    
                    // If hero layout detected, refresh page
                    if (newContent.querySelector('boson-hero-layout') || 
                        newContent.querySelector('horizontal-scroll-hero')) {
                        console.log('PJAX: Layout change detected, refreshing...');
                        window.location.href = fullUrl.href;
                        return;
                    }
                    
                    container.innerHTML = data.content;
                }

                if (data.url) {
                    history.pushState({}, '', data.url);
                }

                // Dispatch custom event for components to re-initialize
                window.dispatchEvent(new CustomEvent('pjax:complete'));

            } else {
                window.location.href = fullUrl.href;
            }

        } catch (error) {
            window.location.href = fullUrl.href;

        } finally {
            document.body.classList.remove('pjax-loading');
        }
    });

    // Handle browser back/forward
    window.addEventListener('popstate', () => {
        // For now, just reload the page
        window.location.reload();
    });
}

// Global declaration
declare global {
    interface Window {
        PJAX_LOADED?: boolean;
    }
}