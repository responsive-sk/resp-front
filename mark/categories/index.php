<?php $this->layout('layout::master', [
    'title' => $title ?? 'Kategórie',
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/mark.js',
    'currentRoute' => 'mark.categories.index',
]) ?>

<?php $this->start('main') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Kategórie</h1>
        <p class="text-muted mb-0">Správa kategórií článkov</p>
    </div>
    <div>
        <a href="<?= $this->url('mark.categories.create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Vytvoriť kategóriu
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($categories)): ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Zatiaľ žiadne kategórie</h5>
                <p class="text-muted">Vytvorte prvú kategóriu pre organizáciu článkov.</p>
                <a href="<?= $this->url('mark.categories.create') ?>" class="btn btn-primary">
                    Vytvoriť kategóriu
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Názov</th>
                            <th>Slug</th>
                            <th>Popis</th>
                            <th>Vytvorené</th>
                            <th>Akcie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td>
                                    <strong><?= $this->escapeHtml($category->name()->toString()) ?></strong>
                                </td>
                                <td>
                                    <code class="text-muted"><?= $this->escapeHtml($category->slug()->toString()) ?></code>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?= $this->escapeHtml($category->description() ?: '—') ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= $category->createdAt()->format('d.m.Y H:i') ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= $this->url('mark.categories.edit', ['id' => $category->id()->toString()]) ?>" 
                                           class="btn btn-outline-primary" title="Upraviť">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="post" action="<?= $this->url('mark.categories.delete', ['id' => $category->id()->toString()]) ?>" 
                                              style="display: inline-block;" 
                                              onsubmit="return confirm('Naozaj chcete vymazať kategóriu &quot;<?= $this->escapeHtml($category->name()->toString()) ?>&quot;?')">
                                            <button type="submit" class="btn btn-outline-danger" title="Vymazať">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->stop() ?>
