<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->escapeHtml($title ?? 'Manage Articles') ?></title>
</head>
<body>
    <div style="max-width: 1200px; margin: 20px auto; padding: 20px;">
        <h1>Manage Articles (Mark Panel)</h1>
        
        <p><a href="<?= $this->url('mark_dashboard') ?>">← Back to Dashboard</a></p>
        
        <?php if (isset($articles) && count($articles) > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= $article->id()->toInt() ?></td>
                        <td><?= $this->escapeHtml($article->title()->toString()) ?></td>
                        <td>User #<?= $article->authorId()->toInt() ?></td>
                        <td>-</td>
                        <td>
                            <a href="<?= $this->url('mark_articles_show', ['id' => $article->id()->toInt()]) ?>">View</a> |
                            <a href="<?= $this->url('article_edit_form', ['id' => $article->id()->toInt()]) ?>">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
        
        <p style="margin-top: 20px;">
            <a href="<?= $this->url('article_create_form') ?>" style="padding: 10px 20px; background: #007bff; color: white; text-decoration: none;">
                + Create New Article
            </a>
        </p>
    </div>
</body>
</html>
