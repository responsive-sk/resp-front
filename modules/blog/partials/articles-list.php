<?php foreach ($articles as $article): ?>
    <article>
        <hgroup>
            <h2>
                <a href="<?= $this->url('blog_show_slug', ['slug' => $article->getUri()]) ?>">
                    <?= $this->escapeHtml($article->getTitle()->toString()) ?>
                </a>
            </h2>
            <p style="padding-top: 20px;"><?= $this->escapeHtml(substr(strip_tags($article->getContent()->toString()), 0, 200)) ?>...</p>
        </hgroup>
    </article>
<?php endforeach; ?>

<?php if (empty($articles)): ?>
    <h2>Nothing found</h2>
<?php endif; ?>
