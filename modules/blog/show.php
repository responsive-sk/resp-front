<?php $this->layout('layout::master', [
    'title' => $article->getTitle()->toString() . ' :: Boson',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => 'blog.show.slug',
    'blogCategories' => $blogCategories ?? [],
    //'docsVersion' => $docsVersion ?? null,
    //'docsCategories' => $docsCategories ?? [],
]);
?>

<?php
// Prepare article data for the component
$isObject = is_object($article);

$slug = $isObject ? $article->getUri() : ($article['slug'] ?? $article['id']);
$title = $isObject ? $article->getTitle()->toString() : $article['title'];
$content = $isObject ? $article->getContent()->toString() : $article['content'];
$createdAt = $isObject
    ? ($article->createdAt() ? $article->createdAt()->format('M d, Y') : date('M d, Y'))
    : date('M d, Y', strtotime($article['created_at']));
$updatedAt = $isObject
    ? ($article->updatedAt() ? $article->updatedAt()->format('M d, Y') : null)
    : ($article['updated_at'] ? date('M d, Y', strtotime($article['updated_at'])) : null);

// Image handling needs care depending on DTO structure
$imageUrl = 'https://picsum.photos/seed/' . $slug . '/1200/600';
$imageAlt = $title;
// if array has image field... $article['image'] ...

$articleData = [
    'id' => md5($slug),
    'title' => $title,
    'subtitle' => 'The complete guide to understanding this topic', // Placeholder
    'author' => [
        'name' => 'Boson Team',
        'role' => 'Core Contributors',
        'avatar' => 'https://i.pravatar.cc/150?u=' . md5($slug),
        'bio' => 'The team behind responsive.sk works hard to bring you the latest updates and best practices.',
        'social' => [
            'twitter' => '#',
            'github' => '#'
        ]
    ],
    'publishDate' => $createdAt,
    'lastUpdated' => $updatedAt,
    'readTime' => '5 min read',
    'category' => isset($category) ? ($isObject ? $category->getTitle() : ($category['title'] ?? 'General')) : 'General',
    'tags' => ['Tech', 'Development', 'Boson'],
    'featuredImage' => $imageUrl,
    'featuredImageAlt' => $imageAlt,
    'featuredImageCaption' => 'Image for ' . $title,
    'content' => $content,
    'excerpt' => mb_substr(strip_tags($content), 0, 150) . '...',
    'slug' => $slug,
    'meta' => [
        'views' => 1250,
        'likes' => 42,
        'shares' => 15,
        'commentsCount' => 3
    ],
    'relatedArticles' => [] // Could be populated from controller
];
?>

<article-detail-section .article='<?= json_encode($articleData, JSON_HEX_APOS | JSON_HEX_QUOT) ?>' show-comments
    show-related></article-detail-section>

<?php $this->stop() ?>