<?php
// modules/blog/article-show.php

/** @var \Blog\Domain\Blog\Entity\Article $article */
/** @var array $relatedArticles */

// Compatibility layer
$isObject = is_object($article);

$title = $isObject ? $article->title()->toString() : $article['title'];
$content = $isObject ? $article->content()->toString() : $article['content'];
// Extract excerpt from content for string access if method doesn't exist
$excerpt = $isObject
    ? $article->content()->excerpt(160)
    : mb_substr(strip_tags($content), 0, 160) . '...';

$slug = $isObject
    ? ($article->slug() ? $article->slug()->toString() : '')
    : ($article['slug'] ?? '');

$id = $isObject
    ? ($article->id() ? (string) $article->id()->toInt() : '')
    : (string) ($article['id'] ?? '');

$status = $isObject ? $article->status()->toString() : ($article['status'] ?? 'draft');

$createdAt = $isObject
    ? $article->createdAt()->format('Y-m-d')
    : date('Y-m-d', strtotime($article['created_at']));

$updatedAt = $isObject
    ? ($article->updatedAt() ? $article->updatedAt()->format('Y-m-d') : null)
    : ($article['updated_at'] ? date('Y-m-d', strtotime($article['updated_at'])) : null);


$this->layout('layout::master', [
    'title' => $title . ' - ChubbyBlog',
    'description' => $excerpt,
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
    <h1><?= $this->escapeHtml($title) ?></h1>
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
            <?= $this->escapeHtml($title) ?>
        </boson-button>
    </div>
</boson-breadcrumbs>

<article-detail-section article='<?= json_encode([
    'id' => $id,
    'title' => $title,
    'content' => $content,
    'excerpt' => $excerpt,
    'slug' => $slug,
    'status' => $status,
    'createdAt' => $createdAt,
    'updatedAt' => $updatedAt,
    'featuredImage' => 'https://picsum.photos/seed/' . ($id ?: '1') . '/1200/600', // Placeholder
    'featuredImageAlt' => $title,
    'author' => [
        'name' => 'Boson Team', // Placeholder
        'avatar' => 'https://i.pravatar.cc/150?u=' . ($id ?: '1'), // Placeholder
        'role' => 'Core Contributors' // Placeholder
    ],
    'meta' => [
        'views' => 1234, // Placeholder
        'likes' => 42  // Placeholder
    ],
    'relatedArticles' => array_map(function ($related) {
        // Assume related might still be object for now or array? Leaving as object assumption or simple fallback
        $rIsObj = is_object($related);
        return [
            'id' => $rIsObj ? (string) $related->id()->toInt() : ($related['id'] ?? ''),
            'title' => $rIsObj ? $related->title()->toString() : ($related['title'] ?? ''),
            'excerpt' => $rIsObj ? $related->content()->excerpt(100) : mb_substr(strip_tags($related['content'] ?? ''), 0, 100),
            'slug' => $rIsObj ? $related->slug()->toString() : ($related['slug'] ?? ''),
            'createdAt' => $rIsObj ? $related->createdAt()->format('Y-m-d') : date('Y-m-d', strtotime($related['created_at'] ?? 'now'))
        ];
    }, $relatedArticles)
], JSON_HEX_APOS | JSON_HEX_QUOT) ?>' show-author show-related show-actions></article-detail-section>

<?php $this->stop() ?>