import { LitElement, html, css } from 'lit';
export class ArticleCard extends LitElement {
  static properties = { article: { type: Object } };
  static styles = css`:host { display:block; padding:1rem; border:1px solid #ccc; border-radius:8px; }`;
  _handleClick() { this.dispatchEvent(new CustomEvent('article-selected',{detail:{article:this.article},bubbles:true,composed:true})); }
  render() { if(!this.article)return html``; return html`<article @click=${this._handleClick}><h3>${this.article.title}</h3></article>`; }
}
customElements.define('article-card', ArticleCard);
