export class Article {
  constructor(id, title, content, author, publishedAt) {
    if (!id) throw new Error('Article must have an ID');
    if (!title || title.trim().length === 0) throw new Error('Article must have a title');
    this.id = id; this.title = title; this.content = content; this.author = author; this.publishedAt = publishedAt;
  }
  isPublished() { return this.publishedAt !== null; }
  canBeEditedBy(userId) { return this.author.id === userId; }
}
