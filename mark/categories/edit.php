<?php $this->layout('layout::master', [
    'title' => $title ?? 'Upraviť kategóriu',
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/mark.js',
    'currentRoute' => 'mark.categories.edit',
]) ?>

<?php $this->start('main') ?>

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0">Upraviť kategóriu</h1>
            <p class="text-muted mb-0">Upravte kategóriu "<?= $this->escapeHtml($category->name()->toString()) ?>"</p>
        </div>
        <div>
            <a href="<?= $this->url('mark.categories.index') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Späť
            </a>
        </div>
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

        <form method="post" action="<?= $this->url('mark.categories.update', ['id' => $category->id()->toString()]) ?>">
            <?= $this->csrfField() ?>

            <div class="mb-3">
                <label for="name" class="form-label">Názov kategórie *</label>
                <input type="text" 
                       class="form-control" 
                       id="name" 
                       name="name" 
                       value="<?= $this->escapeHtml($category->name()->toString()) ?>" 
                       required 
                       maxlength="100"
                       placeholder="Napr. Technológie, Spoločnosť, Šport...">
                <div class="form-text">Názov bude automaticky prevedený na slug (URL-friendly formát).</div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Popis</label>
                <textarea class="form-control" 
                          id="description" 
                          name="description" 
                          rows="3"
                          placeholder="Krátky popis kategórie (voliteľné)"><?= $this->escapeHtml($category->description() ?? '') ?></textarea>
                <div class="form-text">Popis pomôže používateľom lepšie pochopiť, aké články kategória obsahuje.</div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" 
                               class="form-control" 
                               value="<?= $this->escapeHtml($category->slug()->toString()) ?>" 
                               readonly>
                        <div class="form-text">Slug sa automaticky generuje z názvu kategórie.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Vytvorené</label>
                        <input type="text" 
                               class="form-control" 
                               value="<?= $category->createdAt()->format('d.m.Y H:i') ?>" 
                               readonly>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= $this->url('mark.categories.index') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Zrušiť
                </a>
                <div>
                    <form method="post" action="<?= $this->url('mark.categories.delete', ['id' => $category->id()->toString()]) ?>" 
                          style="display: inline-block;" 
                          onsubmit="return confirm('Naozaj chcete vymazať kategóriu &quot;<?= $this->escapeHtml($category->name()->toString()) ?>&quot;?')">
                        <button type="submit" class="btn btn-outline-danger me-2">
                            <i class="fas fa-trash me-2"></i>Vymazať
                        </button>
                    </form>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Uložiť zmeny
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->stop() ?>
