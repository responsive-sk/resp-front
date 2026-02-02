// resp-front/src/lib/pjax.ts
export function initPJAX() {
    // Set global flag
    window.PJAX_LOADED = true;

    const container = document.querySelector('[data-container]');

    if (!container) {
        return;
    }

    // Event listener for clicks
    document.addEventListener('click', async (e) => {
        // Look for any element with href attribute
        const linkElement = (e.target as HTMLElement).closest('a, [href]');

        if (!linkElement) {
            return;
        }

        // Get href from the element
        const href = linkElement.getAttribute('href');
        if (!href) {
            return;
        }

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