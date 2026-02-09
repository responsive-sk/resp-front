<?php
// modules/blog/article-show.php

/** @var \Blog\Domain\Blog\Entity\Article $article */
/** @var array $relatedArticles */

// Compatibility layer
$isObject = is_object($article);

if ($isObject) {
    // Use new DDD structure with toArray() method
    $articleData = $article->toArray();
    $title = $articleData['title'];
    $content = $articleData['content'];
    $excerpt = $articleData['excerpt'];
    $slug = $articleData['slug'];
    $id = $articleData['id'];
    $status = $articleData['status'];
    $createdAt = $articleData['created_at'];
    $updatedAt = $articleData['updated_at'];
} else {
    // Fallback for old array structure
    $title = $article['title'];
    $content = $article['content'];
    $excerpt = mb_substr(strip_tags($content), 0, 160) . '...';
    $slug = $article['slug'] ?? '';
    $id = (string) ($article['id'] ?? '');
    $status = $article['status'] ?? 'draft';
    $createdAt = date('Y-m-d', strtotime($article['created_at']));
    $updatedAt = $article['updated_at'] ? date('Y-m-d', strtotime($article['updated_at'])) : null;
}


$this->layout('layout::master', [
    'title' => $title,
    'description' => $excerpt,
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'blog.show.slug',
    'isPjax' => isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true'
]);

// Get related articles (you need to implement this in your repository)
$relatedArticles = $relatedArticles ?? []; // Replace with actual related articles query
?>

<?php $this->start('main') ?>

<div id="pjax-container" data-pjax-container>

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
    'updatedAt' => $updatedAt
], JSON_HEX_APOS | JSON_HEX_QUOT) ?>' show-author show-related show-actions></article-detail-section>

</div> <!-- pjax-container -->

<?php $this->stop() ?>