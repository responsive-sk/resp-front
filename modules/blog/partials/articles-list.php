<?php foreach ($articles as $article): ?>
    <article class="search-result">
        <hgroup>
            <h2>
                <a href="<?= $this->url('blog.show.slug', ['slug' => $article->getUri()]) ?>">
                    <?= $this->escapeHtml($article->getTitle()->toString()) ?>
                </a>
            </h2>
        </hgroup>
        <p class="content-preview">
            <?php
            // Show first 200 characters of content
            $contentPreview = $article->getContent()->toString();
            $contentPreview = strip_tags($contentPreview);
            if (mb_strlen($contentPreview) > 200) {
                $contentPreview = mb_substr($contentPreview, 0, 200) . '...';
            }
            echo $this->escapeHtml($contentPreview);
            ?>
        </p>
    </article>
<?php endforeach; ?>

<?php if (empty($articles)): ?>
    <hgroup class="no-results">
        <h2>Nothing found</h2>
    </hgroup>
<?php endif; ?>