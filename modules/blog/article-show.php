<?php
// modules/blog/article-show.php

/** @var \Blog\Domain\Blog\Entity\Article $article */
/** @var array $relatedArticles */

$this->layout('layout::master', [
    'title' => $article->title()->toString() . ' - ChubbyBlog',
    'description' => $article->content()->excerpt(160),
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'blog.show.slug',
]);

// Get related articles (you need to implement this in your repository)
$relatedArticles = $relatedArticles ?? []; // Replace with actual related articles query
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

<article-detail-section
    .article='<?= json_encode([
        'id' => $article->id() ? (string) $article->id()->toInt() : '',
        'title' => $article->title()->toString(),
        'content' => $article->content()->toString(),
        'excerpt' => $article->content()->excerpt(160),
        'slug' => $article->slug() ? $article->slug()->toString() : '',
        'status' => $article->status()->toString(),
        'createdAt' => $article->createdAt()->format('Y-m-d'),
        'updatedAt' => $article->updatedAt() ? $article->updatedAt()->format('Y-m-d') : null,
        'featuredImage' => 'https://picsum.photos/seed/' . ($article->id() ? $article->id()->toInt() : '1') . '/1200/600', // Placeholder
        'featuredImageAlt' => $article->title()->toString(),
        'author' => [
            'name' => 'Boson Team', // Placeholder
            'avatar' => 'https://i.pravatar.cc/150?u=' . ($article->id() ? $article->id()->toInt() : '1'), // Placeholder
            'role' => 'Core Contributors' // Placeholder
        ],
        'meta' => [
            'views' => 1234, // Placeholder
            'likes' => 42  // Placeholder
        ],
        'relatedArticles' => array_map(function($related) {
            return [
                'id' => (string) $related->id()->toInt(),
                'title' => $related->title()->toString(),
                'excerpt' => $related->content()->excerpt(100),
                'slug' => $related->slug()->toString(),
                'createdAt' => $related->createdAt()->format('Y-m-d')
            ];
        }, $relatedArticles)
    ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
    show-author
    show-related
    show-actions
></article-detail-section>

<?php $this->stop() ?>