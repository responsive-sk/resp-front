<?php $this->layout('layout::master', [
    'title' => $article->getTitle()->toString() . ' :: Boson',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => 'blog.show.slug',
    'blogCategories' => $blogCategories ?? [],
    'docsVersion' => $docsVersion ?? null,
    'docsCategories' => $docsCategories ?? [],
]);
?>

<?php $this->start('main') ?>

<boson-page-title>
    <h1><?= $this->escapeHtml($article->getTitle()->toString()) ?></h1>
</boson-page-title>

<boson-breadcrumbs>
        <div class="breadcrumb-item">
            <boson-button type="ghost" href="<?= $this->url('home') ?>">
                Home
            </boson-button>
        </div>

        <div class="breadcrumb-item">
            <boson-button type="ghost" href="<?= $this->url('blog.index') ?>">
                Blog
            </boson-button>
        </div>

        <?php if ($category): ?>
        <div class="breadcrumb-item">
            <boson-button type="ghost" href="<?= $this->url('blog.category', ['category' => $category->getUri()]) ?>">
                <?= $this->escapeHtml($category->getTitle()) ?>
            </boson-button>
        </div>
        <?php endif; ?>

        <div class="breadcrumb-item">
            <boson-button type="ghost">
                <?= $this->escapeHtml($article->getTitle()->toString()) ?>
            </boson-button>
        </div>
    </boson-breadcrumbs>

<boson-blog-layout>
    <article class="blog-article">
                <!-- Article Image -->
                <?php if($article->getImage()): // Added null check ?>
                <div class="article-image">
                    <img src="<?= $this->escapeHtmlAttr($article->getImage()->getUrl()) ?>"
                         alt="<?= $this->escapeHtmlAttr($article->getImage()->getAlt()) ?>"
                         <?php if ($article->getImage()->getWidth()): ?>
                         width="<?= $article->getImage()->getWidth() ?>"
                         <?php endif; ?>
                         <?php if ($article->getImage()->getHeight()): ?>
                         height="<?= $article->getImage()->getHeight() ?>"
                         <?php endif; ?>
                         loading="lazy" />
                </div>
                <?php endif; ?>

                <!-- Article Content -->
                <div class="article-content">
                    <?= $article->getContent()->toString() ?>
                </div>
    </article>

    <div slot="sidebar">
        <?php $this->insert('blog::partials/categories-list', [
            'categories' => $categories ?? [],
            'currentRoute' => $currentRoute ?? 'blog.show.slug',
            'category' => $category ?? null
        ]) ?>
    </div>
</boson-blog-layout>

<style>
.blog-article {
    max-width: none;
}

.article-image {
    margin-bottom: 2rem;
}

.article-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.article-content {
    line-height: 1.7;
    font-size: 1.1rem;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #666;
}

.article-content code {
    background: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9em;
}

.article-content pre {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 2rem 0;
}

.article-content pre code {
    background: none;
    padding: 0;
}
</style>

<?php $this->stop() ?>
