<?php $this->layout('layout/mark-dashboard', [
    'title' => 'Manage Tags - Mark Dashboard'
]); ?>

<?php $this->start('main') ?>

<!-- Page Header -->
<div class="mark-card">
    <h3 class="mark-card-title">Manage Tags</h3>
    <p class="mark-card-description">Manage blog tags and categories</p>
</div>

<!-- Tags Management -->
<div class="mark-grid">
    <div class="mark-card">
        <h3 class="mark-card-title">Create New Tag</h3>
        
        <?php if (isset($error)): ?>
            <sl-alert type="danger" open>
                <sl-icon name="alert-triangle" slot="icon"></sl-icon>
                <?= $this->escapeHtml($error) ?>
            </sl-alert>
        <?php endif; ?>

        <form method="post" action="/mark/tags/create">
            <?= $this->csrfField() ?>
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                <sl-input 
                    type="text" 
                    name="name" 
                    value="<?= $this->escapeHtml($name ?? '') ?>" 
                    placeholder="Enter tag name..."
                    maxlength="50"
                    required
                    style="flex: 1;">
                </sl-input>
                <sl-button type="submit" variant="primary">
                    <sl-icon name="plus" slot="prefix"></sl-icon>
                    Add Tag
                </sl-button>
            </div>
        </form>
    </div>
    
    <div class="mark-card">
        <h3 class="mark-card-title">Existing Tags</h3>
        <div id="tags-list">
            <!-- Tags will be loaded here via JavaScript -->
            <sl-skeleton effect="sheen" style="width: 100%; height: 2rem;"></sl-skeleton>
        </div>
    </div>
</div>



<?php $this->stop() ?>
