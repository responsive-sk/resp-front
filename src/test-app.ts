/**
 * Boson Frontend Application
 * Main entry point - connects infrastructure with UI
 */

import { ArticleApiClient } from './infrastructure/api/ArticleApiClient.ts';
import type { IArticle } from './types/index.ts';
import './components/sections/article-list-section.ts'; // Import to register custom element
import './components/ui/article-card.ts'; // Import to register custom element

console.log('🚀 Boson frontend initialized');

/**
 * Initialize application
 */
async function initApp(): Promise<void> {
  const app = document.getElementById('app');

  if (!app) {
    console.error('❌ #app element not found');
    return;
  }

  // Show loading state
  app.innerHTML = '<p>Loading articles...</p>';

  try {
    // Fetch real articles from backend
    const apiClient = new ArticleApiClient();
    const articles = await apiClient.fetchArticles();

    console.log(`✅ Loaded ${articles.length} articles from backend`);

    // Clear loading state
    app.innerHTML = '';

    if (articles.length === 0) {
      app.innerHTML = '<p>No articles found. Create one in the Mark dashboard!</p>';
      return;
    }

    // Render article list with real data
    // Lit components are custom elements, not regular DOM nodes
    const listSection = document.createElement('article-list-section') as any;
    listSection._articles = articles; // Set the property
    app.appendChild(listSection);

    // Log for debugging
    console.log(
      '📊 Article statuses:',
      articles.map((a: IArticle) => `${a.title}: ${(a as any).status}`).join(', ')
    );
  } catch (error) {
    console.error('❌ Failed to initialize app:', error);
    app.innerHTML = `
            <div style="padding: 2rem; background: #fee; border-radius: 8px;">
                <h2>⚠️ Failed to load articles</h2>
                <p>Make sure the backend is running on <code>http://localhost:8000</code></p>
                <p><strong>Error:</strong> ${error instanceof Error ? error.message : String(error)}</p>
                <p><a href="http://localhost:8000/api/articles" target="_blank">Test API endpoint</a></p>
            </div>
        `;
  }
}

// Initialize in development mode
if (import.meta.env.DEV) {
  console.log('🔧 Development Mode - Loading real data from API');
  initApp();
}

// Initialize in production mode
if (import.meta.env.PROD) {
  console.log('🚀 Production Mode');
  initApp();
}

// Hot Module Replacement (HMR) support
if (import.meta.hot) {
  import.meta.hot.accept(() => {
    console.log('🔥 HMR: Reloading...');
    location.reload();
  });
}

export { initApp };
