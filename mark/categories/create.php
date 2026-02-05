<?php $this->layout('layout::master', [
    'title' => $title ?? 'Vytvoriť kategóriu',
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/mark.js',
    'currentRoute' => 'mark.categories.create',
]) ?>

<?php $this->start('main') ?>

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0">Vytvoriť kategóriu</h1>
            <p class="text-muted mb-0">Pridajte novú kategóriu pre organizáciu článkov</p>
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

        <form method="post" action="<?= $this->url('mark.categories.store') ?>">
            <?= $this->csrfField() ?>

            <div class="mb-3">
                <label for="name" class="form-label">Názov kategórie *</label>
                <input type="text" 
                       class="form-control" 
                       id="name" 
                       name="name" 
                       value="<?= $this->escapeHtml($name ?? '') ?>" 
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
                          placeholder="Krátky popis kategórie (voliteľné)"><?= $this->escapeHtml($description ?? '') ?></textarea>
                <div class="form-text">Popis pomôže používateľom lepšie pochopiť, aké články kategória obsahuje.</div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= $this->url('mark.categories.index') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Zrušiť
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Vytvoriť kategóriu
                </button>
            </div>
        </form>
    </div>
</div>

<?php $this->stop() ?>
