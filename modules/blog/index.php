<?php
$this->layout('layout::master', [
    'title' => 'Blog :: Boson',
    //'showHeader' => true,
    //'showFooter' => true,
    //'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    //'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => $currentRoute ?? 'blog.index',
    //'blogCategories' => $blogCategories ?? [],
    // 'docsVersion' => $docsVersion ?? null,
    // 'docsCategories' => $docsCategories ?? [],
]);
?>

<?php $this->start('main') ?>

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
    // Basic defaults if methods don't exist
    $posts[] = [
        'id' => md5($article->getUri()),
        'title' => $article->getTitle()->toString(),
        'excerpt' => mb_substr(strip_tags($article->getContent()->toString()), 0, 150) . '...',
        'author' => 'Boson Team',
        'authorAvatar' => 'https://i.pravatar.cc/150?u=' . md5($article->getUri()),
        'date' => $article->createdAt() ? $article->createdAt()->format('M d, Y') : date('M d, Y'),
        'readTime' => '5 min read',
        'category' => 'Updates',
        'tags' => ['Tech', 'News'],
        'image' => 'https://picsum.photos/seed/' . $article->getUri() . '/800/600',
        'imageAlt' => $article->getTitle()->toString(),
        'slug' => $article->getUri()
    ];
}
?>

<blog-list-section
    title=""
    subtitle=""
    base-url="<?= $this->url('blog.index') ?>" show-filters
    posts='<?= json_encode($posts, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
</blog-list-section>

<?php $this->stop() ?>