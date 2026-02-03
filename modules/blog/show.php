<?php $this->layout('layout::master', [
    'title' => $article->getTitle()->toString() . ' :: Boson',
    //'showHeader' => true,
    //'showFooter' => true,
    //'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    //'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => 'blog.show.slug',
    //'blogCategories' => $blogCategories ?? [],
    //'docsVersion' => $docsVersion ?? null,
    //'docsCategories' => $docsCategories ?? [],
]);
?>

<?php
// Prepare article data for the component
$articleData = [
    'id' => md5($article->getUri()),
    'title' => $article->getTitle()->toString(),
    'subtitle' => 'The complete guide to understanding this topic', // Placeholder
    'author' => [
        'name' => 'Boson Team',
        'role' => 'Core Contributors',
        'avatar' => 'https://i.pravatar.cc/150?u=' . md5($article->getUri()),
        'bio' => 'The team behind responsive.sk works hard to bring you the latest updates and best practices.',
        'social' => [
            'twitter' => '#',
            'github' => '#'
        ]
    ],
    'publishDate' => $article->createdAt() ? $article->createdAt()->format('M d, Y') : date('M d, Y'),
    'lastUpdated' => $article->updatedAt() ? $article->updatedAt()->format('M d, Y') : null,
    'readTime' => '5 min read',
    'category' => isset($category) ? $category->getTitle() : 'General',
    'tags' => ['Tech', 'Development', 'Boson'],
    'featuredImage' => $article->getImage() ? $article->getImage()->getUrl() : 'https://picsum.photos/seed/' . $article->getUri() . '/1200/600',
    'featuredImageAlt' => $article->getImage() ? $article->getImage()->getAlt() : $article->getTitle()->toString(),
    'featuredImageCaption' => 'Image for ' . $article->getTitle()->toString(),
    'content' => $article->getContent()->toString(),
    'excerpt' => mb_substr(strip_tags($article->getContent()->toString()), 0, 150) . '...',
    'slug' => $article->getUri(),
    'meta' => [
        'views' => 1250,
        'likes' => 42,
        'shares' => 15,
        'commentsCount' => 3
    ],
    'relatedArticles' => [] // Could be populated from controller
];
?>

<article-detail-section
    .article='<?= json_encode($articleData, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
    show-comments
    show-related
></article-detail-section>

<?php $this->stop() ?>
