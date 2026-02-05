<?php $this->layout('layout::master', [
    'title' => $title ?? 'Tagy',
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/mark.js',
    'currentRoute' => 'mark.tags.index',
]) ?>

<?php $this->start('main') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Tagy</h1>
        <p class="text-muted mb-0">Správa tagov článkov</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= $this->escapeHtml($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= $this->url('mark.tags.create') ?>" class="mb-4">
            <?= $this->csrfField() ?>
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" 
                           class="form-control" 
                           name="name" 
                           value="<?= $this->escapeHtml($name ?? '') ?>" 
                           placeholder="Zadajte názov nového tagu..."
                           maxlength="50"
                           required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Pridať tag
                    </button>
                </div>
            </div>
        </form>

        <?php if (empty($tags)): ?>
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Zatiaľ žiadne tagy</h5>
                <p class="text-muted">Vytvorte prvý tag pre lepšiu organizáciu článkov.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($tags as $tag): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-primary text-white fs-6">
                                        <?= $this->escapeHtml($tag->name()->toString()) ?>
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        <?= $tag->createdAt()->format('d.m.Y H:i') ?>
                                    </small>
                                </div>
                                <form method="post" action="<?= $this->url('mark.tags.delete', ['id' => $tag->id()->toString()]) ?>" 
                                      style="display: inline-block;" 
                                      onsubmit="return confirm('Naozaj chcete vymazať tag &quot;<?= $this->escapeHtml($tag->name()->toString()) ?>&quot;?')">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Vymazať">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->stop() ?>
