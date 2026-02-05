<?php $this->layout('layout::master', [
    'title' => $category->name()->toString() . ' - Články',
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'blog.category',
]) ?>

<?php $this->start('main') ?>

<div class="page-header mb-4">
    <div class="text-center">
        <h1 class="h2 mb-3"><?= $this->escapeHtml($category->name()->toString()) ?></h1>
        <?php if ($category->description()): ?>
            <p class="lead text-muted"><?= $this->escapeHtml($category->description()) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <?php if (empty($articles)): ?>
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Žiadne články v tejto kategórii</h4>
            <p class="text-muted">V kategórii "<?= $this->escapeHtml($category->name()->toString()) ?>" zatiaľ nie sú žiadne články.</p>
            <a href="<?= $this->url('blog.index') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Späť na všetky články
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-lg-8 mx-auto">
                    <article class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0">
                                    <a href="<?= $this->url('blog.show.slug', ['slug' => $article->getUri()]) ?>" 
                                       class="text-decoration-none">
                                        <?= $this->escapeHtml($article->title()->toString()) ?>
                                    </a>
                                </h5>
                                <?php if ($article->category()): ?>
                                    <span class="badge bg-primary text-white">
                                        <?= $this->escapeHtml($article->category()->name()->toString()) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="card-text text-muted">
                                <?= $this->escapeHtml(substr(strip_tags($article->content()->toString()), 0, 200)) ?>
                                <?= strlen(strip_tags($article->content()->toString())) > 200 ? '...' : '' ?>
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?= $article->createdAt()->format('d.m.Y') ?>
                                </small>
                                <a href="<?= $this->url('blog.show.slug', ['slug' => $article->getUri()]) ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    Čítať viac
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= $this->url('blog.index') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Späť na všetky články
            </a>
        </div>
    <?php endif; ?>
</div>

<?php $this->stop() ?>
