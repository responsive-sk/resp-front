/**
 * API Client for Article endpoints
 * Infrastructure layer - communicates with backend
 */
export class ArticleApiClient {
    constructor(baseUrl = 'http://localhost:8000/api') {
        this.baseUrl = baseUrl;
    }

    /**
     * Fetch all articles
     * @returns {Promise<Array>}
     */
    async fetchArticles() {
        try {
            const response = await fetch(`${this.baseUrl}/articles`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('📚 Fetched articles:', data);
            return Array.isArray(data) ? data : [];
            
        } catch (error) {
            console.error('❌ Failed to fetch articles:', error);
            throw error;
        }
    }

    /**
     * Fetch single article by ID
     * @param {number} id
     * @returns {Promise<Object>}
     */
    async fetchArticle(id) {
        try {
            const response = await fetch(`${this.baseUrl}/articles/${id}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('📄 Fetched article:', data);
            return data;
            
        } catch (error) {
            console.error(`❌ Failed to fetch article ${id}:`, error);
            throw error;
        }
    }

    /**
     * Create new article (requires authentication)
     * @param {Object} articleData
     * @returns {Promise<Object>}
     */
    async createArticle(articleData) {
        try {
            const response = await fetch(`${this.baseUrl}/articles`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(articleData)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
            
        } catch (error) {
            console.error('❌ Failed to create article:', error);
            throw error;
        }
    }
}
