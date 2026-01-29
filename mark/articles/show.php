<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($article) ? sprintf($title ?? '%s', $this->escapeHtml($article->title()->toString())) : 'Article' ?></title>
</head>
<body>
    <div style="max-width: 1200px; margin: 20px auto; padding: 20px;">
        <h1>Article Details (Mark Panel)</h1>
        
        <p>
            <a href="<?= $this->url('mark_articles_index') ?>">← Back to Articles</a> |
            <a href="<?= $this->url('mark_dashboard') ?>">Dashboard</a>
        </p>
        
        <?php if (isset($article)): ?>
            <div style="background: #f8f9fa; padding: 20px; margin: 20px 0;">
                <h2><?= $this->escapeHtml($article->title()->toString()) ?></h2>
                <p><strong>ID:</strong> <?= $article->id()->toInt() ?></p>
                <p><strong>Author ID:</strong> <?= $article->authorId()->toInt() ?></p>
                <p><strong>Slug:</strong> <?= $this->escapeHtml($article->slug()->toString()) ?></p>
                
                <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 20px;">
                    <h3>Content:</h3>
                    <div style="white-space: pre-wrap; background: white; padding: 15px; border: 1px solid #ddd;">
                        <?= $this->escapeHtml($article->content()->toString()) ?>
                    </div>
                </div>
                
                <div style="margin-top: 30px; display: flex; gap: 10px;">
                    <a href="<?= $this->url('article_edit_form', ['id' => $article->id()->toInt()]) ?>" 
                       style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none;">
                        Edit Article
                    </a>
                    <a href="<?= $this->url('blog_show', ['id' => $article->id()->toInt()]) ?>" 
                       style="padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none;">
                        View Public Page
                    </a>
                </div>
            </div>
        <?php else: ?>
            <p>Article not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
