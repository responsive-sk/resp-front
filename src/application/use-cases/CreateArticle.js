import { Article } from '../../domain/entities/Article.js';
import { ArticleTitle } from '../../domain/value-objects/ArticleTitle.js';

export class CreateArticle {
  constructor(articleRepository, currentUser) { this.articleRepository = articleRepository; this.currentUser = currentUser; }
  async execute(title, content) {
    const articleTitle = new ArticleTitle(title);
    const article = new Article(crypto.randomUUID(), articleTitle.value, content, this.currentUser, null);
    await this.articleRepository.save(article);
    return article;
  }
}
