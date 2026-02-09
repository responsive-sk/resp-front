<?php
$this->layout('layout::master', [
    'title' => 'Blog :: Boson',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => $currentRoute ?? 'blog.index',
    'isPjax' => isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true'
]);
?>

<?php $this->start('main') ?>

<div id="pjax-container" data-pjax-container>

<boson-page-title>
    <h1>Blog</h1>
</boson-page-title>

<boson-breadcrumbs>
    <div class="breadcrumb-item">
        <boson-button type="ghost" href="<?= $this->url('home') ?>">
            Home
        </boson-button>
    </div>

    <div class="breadcrumb-item">
        <boson-button type="ghost">
            Blog
        </boson-button>
    </div>
</boson-breadcrumbs>

<?php
$posts = [];
foreach ($articles ?? [] as $article) {
    // Handle array or object (backward compatibility if needed, but assuming array now)
    $isObject = is_object($article);

    $slug = $isObject ? $article->getUri() : ($article['slug'] ?? $article['id']);
    $title = $isObject ? $article->getTitle()->toString() : $article['title'];
    $content = $isObject ? $article->getContent()->toString() : $article['content'];
    $dateStr = $isObject
        ? ($article->createdAt() ? $article->createdAt()->format('M d, Y') : date('M d, Y'))
        : date('M d, Y', strtotime($article['created_at']));

    $posts[] = [
        'id' => md5($slug),
        'title' => $title,
        'excerpt' => mb_substr(strip_tags($content), 0, 150) . '...',
        'author' => 'Boson Team',
        'authorAvatar' => 'https://i.pravatar.cc/150?u=' . md5($slug),
        'date' => $dateStr,
        'readTime' => '5 min read',
        'category' => 'Updates',
        'tags' => ['Tech', 'News'],
        'image' => 'https://picsum.photos/seed/' . $slug . '/800/600',
        'imageAlt' => $title,
        'slug' => $slug
    ];
}
?>

<blog-list-section title="" subtitle="" base-url="<?= $this->url('blog.index') ?>" show-filters
    posts='<?= json_encode($posts, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
</blog-list-section>

</div> <!-- pjax-container -->

<?php $this->stop() ?>