export class ArticleTitle {
  constructor(value) {
    if (!value || value.trim().length === 0) {
      throw new Error('Title cannot be empty')
    }
    if (value.length > 200) {
      throw new Error('Title too long')
    }
    this.value = value.trim()
    Object.freeze(this)
  }
}
