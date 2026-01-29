<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->escapeHtml($title ?? 'Create Article') ?></title>
</head>
<body>
    <div style="max-width: 800px; margin: 50px auto; padding: 20px;">
        <h1>Create New Article</h1>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px; padding: 10px; background: #fee;">
                <?= $this->escapeHtml($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?= $this->url('article_create') ?>">
            <div style="margin-bottom: 20px;">
                <label for="title"><strong>Title:</strong></label><br>
                <input type="text" id="title" name="title" value="<?= $this->escapeHtml($title ?? '') ?>" 
                       required style="width: 100%; padding: 10px; font-size: 16px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label for="content"><strong>Content:</strong></label><br>
                <textarea id="content" name="content" rows="15" 
                          required style="width: 100%; padding: 10px; font-size: 14px; font-family: monospace;"><?= $this->escapeHtml($content ?? '') ?></textarea>
            </div>
            
            <input type="hidden" name="author_id" value="1"> <!-- TODO: Get from session -->
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 10px 30px; background: #007bff; color: white; border: none; cursor: pointer;">
                    Create Article
                </button>
                <a href="<?= $this->url('blog_index') ?>" style="padding: 10px 30px; background: #6c757d; color: white; text-decoration: none; display: inline-block;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>
