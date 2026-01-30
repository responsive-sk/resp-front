<?php $this->layout('resp-front::mark/layout', [
    'title' => 'Create Article',
    'currentRoute' => 'mark.articles.create',
]) ?>

<?php $this->start('mark-content') ?>

<div class="section-headers"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #181c32;">New Article</h1>
        <p style="margin: 0.5rem 0 0; color: #a1a5b7; font-size: 0.9rem;">Write and publish new content</p>
    </div>
    <mark-button variant="secondary" href="<?= $this->url('mark.articles.index') ?>">← Back to Articles</mark-button>
</div>

<form method="post" action="<?= $this->url('mark.articles.store') ?>">
    <div style="display: flex; gap: 2rem; max-width: 1200px; margin: 0 auto;">
        <div style="flex: 3;">
            <mark-card>
                <?php if (isset($error)): ?>
                    <div
                        style="background: rgba(241, 65, 108, 0.1); color: #f1416c; padding: 1rem; border-radius: 0.6rem; margin-bottom: 1.5rem; border: 1px dashed rgba(241, 65, 108, 0.3); font-size: 0.9rem;">
                        <?= $this->escapeHtml($error) ?>
                    </div>
                <?php endif; ?>

                <mark-input label="Title" required>
                    <input type="text" id="title" name="title" value="<?= $this->escapeHtml($title ?? '') ?>" required
                        placeholder="Enter article title..." style="font-size: 1.1rem;">
                </mark-input>

                <mark-input label="Content" required>
                    <textarea id="content" name="content" rows="20" required placeholder="Start writing..."
                        style="resize: vertical; line-height: 1.6;"><?= $this->escapeHtml($content ?? '') ?></textarea>
                </mark-input>
            </mark-card>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <mark-card>
                <h3
                    style="margin-top: 0; font-size: 1rem; color: var(--admin-text-primary, #ffffff); margin-bottom: 1rem;">
                    Publishing</h3>

                <mark-input label="Status">
                    <select>
                        <option>Draft</option>
                        <option>Published</option>
                    </select>
                </mark-input>

                <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem;">
                    <mark-button type="submit" style="width: 100%; display: flex;">
                        <span style="width: 100%; text-align: center;">Save Article</span>
                    </mark-button>

                    <mark-button variant="secondary" href="<?= $this->url('mark.articles.index') ?>"
                        style="width: 100%; display: flex;">
                        <span style="width: 100%; text-align: center;">Cancel</span>
                    </mark-button>
                </div>
            </mark-card>
        </div>
    </div>
</form>

<?php $this->stop() ?>