import { LitElement, html } from 'lit';
import '../ui/article-card.js';

export class ArticleListSection extends LitElement {
  static properties = {
    articles: { type: Array }
  };

  constructor() {
    super();
    this.articles = [];
  }

  render() {
    return html`
      <div class="articles">
        ${this.articles.map(a =>
          html`<article-card .article=${a}></article-card>`
        )}
      </div>
    `;
  }
}

customElements.define('article-list-section', ArticleListSection);
