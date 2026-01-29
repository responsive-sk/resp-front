<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->escapeHtml($title ?? 'Edit Article') ?></title>
</head>
<body>
    <div style="max-width: 800px; margin: 50px auto; padding: 20px;">
        <h1>Edit Article: <?= isset($article) ? $this->escapeHtml($article->title()->toString()) : '' ?></h1>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px; padding: 10px; background: #fee;">
                <?= $this->escapeHtml($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($article)): ?>
        <form method="post" action="<?= $this->url('article_update', ['id' => $article->id()->toInt()]) ?>">
            <div style="margin-bottom: 20px;">
                <label for="title"><strong>Title:</strong></label><br>
                <input type="text" id="title" name="title" 
                       value="<?= $this->escapeHtml($article->title()->toString()) ?>" 
                       required style="width: 100%; padding: 10px; font-size: 16px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label for="content"><strong>Content:</strong></label><br>
                <textarea id="content" name="content" rows="15" 
                          required style="width: 100%; padding: 10px; font-size: 14px; font-family: monospace;"><?= $this->escapeHtml($article->content()->toString()) ?></textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 10px 30px; background: #28a745; color: white; border: none; cursor: pointer;">
                    Update Article
                </button>
                <a href="<?= $this->url('blog_show', ['id' => $article->id()->toInt()]) ?>" 
                   style="padding: 10px 30px; background: #6c757d; color: white; text-decoration: none; display: inline-block;">
                    Cancel
                </a>
                <a href="<?= $this->url('article_delete', ['id' => $article->id()->toInt()]) ?>" 
                   onclick="return confirm('Are you sure you want to delete this article?')"
                   style="padding: 10px 30px; background: #dc3545; color: white; text-decoration: none; display: inline-block;">
                    Delete
                </a>
            </div>
        </form>
        <?php else: ?>
            <p>Article not found.</p>
            <a href="<?= $this->url('blog_index') ?>">← Back to blog</a>
        <?php endif; ?>
    </div>
</body>
</html>
