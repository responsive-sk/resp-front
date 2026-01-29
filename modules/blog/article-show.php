<?php
/**
 * @var \Blog\Domain\Blog\Entity\Article $article
 */
$this->layout('layout::master', [
    'title' => $article->title()->toString() . ' - ChubbyBlog',
    'description' => $article->content()->excerpt(160),
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'blog_show_slug',
]);
?>

<?php $this->start('main') ?>

<boson-page-title>
    <h1><?= $this->escapeHtml($article->title()->toString()) ?></h1>
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

    <div class="breadcrumb-item">
        <boson-button type="ghost">
            <?= $this->escapeHtml($article->title()->toString()) ?>
        </boson-button>
    </div>
</boson-breadcrumbs>

<boson-blog-layout>
    <article class="blog-article">
        <!-- Article Featured Image -->
        <div class="article-image">
            <img src="/images/hero.svg"
                 alt="<?= $this->escapeHtml($article->title()->toString()) ?>"
                 width="1200"
                 height="630"
                 loading="eager" />
        </div>

        <!-- Article Meta -->
        <div class="article-meta">
            <p>
                <strong>Published:</strong> <?= $article->createdAt()->format('F j, Y') ?>
                <?php if ($article->updatedAt() > $article->createdAt()): ?>
                    <span style="margin-left: 1em;">
                        <strong>Updated:</strong> <?= $article->updatedAt()->format('F j, Y') ?>
                    </span>
                <?php endif; ?>
            </p>
            <p>
                <strong>Status:</strong> 
                <span class="status-badge status-<?= $this->escapeHtml($article->status()->toString()) ?>">
                    <?= $this->escapeHtml(ucfirst($article->status()->toString())) ?>
                </span>
            </p>
        </div>

        <!-- Article Content -->
        <div class="article-content">
            <?= $article->content()->toString() ?>
        </div>
    </article>

    <div slot="sidebar">
        <div class="sidebar-section">
            <h3>About this article</h3>
            <p>
                This article was published on <?= $article->createdAt()->format('F j, Y') ?>.
            </p>
            <?php if ($article->slug()): ?>
                <p>
                    <strong>Slug:</strong> <?= $this->escapeHtml($article->slug()->toString()) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="sidebar-section">
            <h3>More Articles</h3>
            <p><a href="<?= $this->url('blog_index') ?>">← Back to all articles</a></p>
        </div>
    </div>
</boson-blog-layout>

<style>
.blog-article {
    max-width: none;
}

.article-image {
    width: 100%;
    margin-bottom: 2rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.article-image img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
}

.article-meta {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e0e0e0;
    color: #666;
    font-size: 0.95rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-published {
    background: #d4edda;
    color: #155724;
}

.status-draft {
    background: #fff3cd;
    color: #856404;
}

.status-archived {
    background: #f8d7da;
    color: #721c24;
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

.sidebar-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.sidebar-section h3 {
    margin-top: 0;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.sidebar-section p {
    margin-bottom: 0.5rem;
}

.sidebar-section a {
    color: #007bff;
    text-decoration: none;
}

.sidebar-section a:hover {
    text-decoration: underline;
}
</style>

<?php $this->stop() ?>
