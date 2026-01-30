<?php
$this->layout('layout::master', [
    'title' => 'Blog :: Boson',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => $currentRoute ?? 'blog_index',
    'blogCategories' => $blogCategories ?? [],
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

<boson-blog-layout>
    <?php $currentRoute = $currentRoute ?? 'blog_index'; ?>
    <?php $categories = $categories ?? []; ?>

    <?php if ($currentRoute === 'blog_index'): ?>
        <strong slot="sidebar">All Blog Articles</strong>
    <?php else: ?>
        <a slot="sidebar" href="<?= $this->url('blog_index') ?>">All Blog Articles</a>
    <?php endif; ?>

    <?php foreach ($categories as $availableCategory): ?>
        <?php $availableCategory = (string) $availableCategory; ?>
        <?php if (isset($category) && $category === $availableCategory): ?>
            <strong slot="sidebar"><?= $this->escapeHtml(ucfirst($availableCategory)) ?></strong>
        <?php else: ?>
            <a slot="sidebar" href="<?= $this->url('blog.category', ['category' => $availableCategory]) ?>">
                <?= $this->escapeHtml(ucfirst($availableCategory)) ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php $articles = $articles ?? []; ?>
    <?php $page = $page ?? 1; ?>

    <?php $this->insert('boson::modules/blog/partials/articles-list', ['articles' => $articles]) ?>

    <footer style="display: grid; grid-template-columns: 1fr 1fr 1fr; margin-top: 2em;">
        <span>
            <?php if ($page > 1): ?>
                <a style="float: left" href="<?= $this->url('blog_index', ['page' => 1]) ?>">&lt;&lt; first page</a>
                <a style="float: left; margin-left: 16px;" href="<?= $this->url('blog_index', ['page' => $page - 1]) ?>">&lt; newer articles</a>
            <?php endif; ?>
        </span>

        <span style="text-align: center"><?= $page ?> of 1</span>

        <span>
            <?php if ($page < 1): ?>
                <a style="float: right" href="<?= $this->url('blog_index', ['page' => 1]) ?>">last page &gt;&gt;</a>
                <a style="float: right; margin-right: 16px;" href="<?= $this->url('blog_index', ['page' => $page + 1]) ?>">older articles &gt;</a>
            <?php endif; ?>
        </span>
    </footer>
</boson-blog-layout>

<?php $this->stop() ?>
