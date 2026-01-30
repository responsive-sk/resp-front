<?php $this->layout('layout::master', [
    'title' => $title ?? 'Create Article',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'mark.articles.create',
]) ?>

<?php $this->start('main') ?>
<boson-default-layout>
    <div class="content-container" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
        <boson-page-title>
            <h1>Create New Article</h1>
        </boson-page-title>

        <div class="card"
            style="background: var(--surface-card, #fff); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
            <?php if (isset($error)): ?>
                <div class="alert alert-error"
                    style="background: #fde8e8; color: #dc3545; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #fbd5d5;">
                    <?= $this->escapeHtml($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= $this->url('mark.articles.store') ?>">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="title"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-primary, #333);">Title</label>
                    <input type="text" id="title" name="title" value="<?= $this->escapeHtml($title ?? '') ?>" required
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ced4da; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s; outline: none; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="content"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-primary, #333);">Content</label>
                    <textarea id="content" name="content" rows="15" required
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ced4da; border-radius: 8px; font-size: 1rem; font-family: monospace; transition: border-color 0.2s; outline: none; box-sizing: border-box; resize: vertical;"><?= $this->escapeHtml($content ?? '') ?></textarea>
                </div>

                <input type="hidden" name="author_id" value="1"> <!-- TODO: Get from session -->

                <div class="form-actions"
                    style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee;">
                    <button type="submit"
                        style="padding: 0.75rem 1.5rem; background: var(--color-primary, #007bff); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                        Create Article
                    </button>
                    <a href="<?= $this->url('mark.articles.index') ?>"
                        style="padding: 0.75rem 1.5rem; background: #e9ecef; color: #495057; text-decoration: none; border-radius: 8px; font-weight: 500; display: inline-block;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</boson-default-layout>
<?php $this->stop() ?>