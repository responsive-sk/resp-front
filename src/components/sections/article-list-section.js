import { LitElement, html } from 'lit';
export class ArticleListSection extends LitElement {
  static properties = { _articles: { state:true } };
  constructor() { super(); this._articles = []; }
  connectedCallback() { super.connectedCallback(); }
  render() { return html`<div class="articles">${this._articles.map(a=>html`<article-card .article=${a}></article-card>`)}</div>`; }
}
customElements.define('article-list-section', ArticleListSection);
