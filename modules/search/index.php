<?php
/**
 * @var string $version
 * @var string $query
 * @var array $results
 * @var string|null $error
 */

$this->layout('layout::master', [
    'title' => 'Search Documentation :: Boson',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => 'search.index',
    'blogCategories' => $blogCategories ?? [],
    'docsVersion' => $docsVersion ?? null,
    'docsCategories' => $docsCategories ?? [],
]);
?>

<?php $this->start('main') ?>

<boson-search-layout>
    <boson-page-title>
        <h1>Search Documentation</h1>
    </boson-page-title>

    <section slot="search">
        <form method="GET" action="/search">
            <div class="search-form">
                <input 
                    type="search" 
                    name="q" 
                    value="<?= $this->escapeHtml($query ?? '') ?>" 
                    placeholder="Search documentation..." 
                    required
                    autofocus
                />
                <input type="hidden" name="version" value="<?= $this->escapeHtml($version ?? 'latest') ?>" />
                <button type="submit">Search</button>
            </div>
        </form>
    </section>

    <section slot="content" class="documentation">
        <?php if (isset($error)): ?>
            <div class="error-message">
                <p><?= $this->escapeHtml($error) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($query)): ?>
            <div class="search-info">
                <p>Search results for: <strong><?= $this->escapeHtml($query) ?></strong></p>
                <p>Found <?= count($results) ?> result(s)</p>
            </div>
        <?php endif; ?>

        <?php if (!empty($results)): ?>
            <?php foreach ($results as $item): ?>
                <article class="search-result">
                    <hgroup>
                        <h2>
                            <a href="<?= $this->url('blog_show_slug', ['slug' => $item->getUri()]) ?>">
                                <?= $this->escapeHtml($item->getTitle()->toString()) ?>
                            </a>
                        </h2>
                    </hgroup>

                    <p class="content-preview">
                        <?php
                        // Show first 200 characters of content
                        $contentPreview = $item->getContent()->toString();
                        $contentPreview = strip_tags($contentPreview);
                        if (mb_strlen($contentPreview) > 200) {
                            $contentPreview = mb_substr($contentPreview, 0, 200) . '...';
                        }
                        echo $this->escapeHtml($contentPreview);
                        ?>
                    </p>
                </article>
            <?php endforeach; ?>
        <?php elseif (!empty($query)): ?>
            <hgroup class="no-results">
                <h2>No results found</h2>
                <p>Try making your query more generic or check the spelling!</p>
            </hgroup>
        <?php else: ?>
            <hgroup class="search-help">
                <h2>Search Documentation</h2>
                <p>Enter your search terms above to find relevant documentation.</p>
            </hgroup>
        <?php endif; ?>
    </section>

</boson-search-layout>

<style>
.search-form {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.search-form input[type="search"] {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.search-form button {
    padding: 0.75rem 1.5rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.search-form button:hover {
    background: #0056b3;
}

.search-info {
    margin-bottom: 2rem;
    padding: 1rem;
    border-radius: 4px;
}

.search-result {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.category {
    opacity: 0.6;
    font-size: 0.9em;
}

.content-preview {
    color: #666;
    line-height: 1.5;
}

.no-results, .search-help {
    text-align: center;
    padding: 3rem 0;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 2rem;
}
</style>

<?php $this->stop() ?>


