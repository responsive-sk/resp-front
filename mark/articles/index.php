<?php $this->layout('resp-front::mark/layout', [
    'title' => $title ?? 'Manage Articles',
    'currentRoute' => 'mark.articles.index',
]) ?>

<?php $this->start('mark-content') ?>

<div class="section-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #181c32;">Articles</h1>
        <p style="margin: 0.5rem 0 0; color: #a1a5b7; font-size: 0.9rem;">Manage your blog content</p>
    </div>
    <mark-button href="<?= $this->url('mark.articles.create') ?>">+ New Article</mark-button>
</div>

<?php if (isset($articles) && count($articles) > 0): ?>
    <mark-card no-padding>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #eff2f5;">
                        <th
                            style="text-align: left; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; width: 60px;">
                            ID</th>
                        <th
                            style="text-align: left; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Article</th>
                        <th
                            style="text-align: left; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Author</th>
                        <th
                            style="text-align: right; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr style="border-bottom: 1px dashed #eff2f5;">
                            <td style="padding: 1rem 1.5rem; color: #7e8299; font-weight: 600;">
                                #<?= $article->id()->toInt() ?>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <a href="<?= $this->url('blog.show.slug', ['slug' => $article->slug()->toString()]) ?>"
                                    style="color: #464e5f; font-weight: 600; text-decoration: none; font-size: 0.95rem; display: block; margin-bottom: 0.35rem;">
                                    <?= $this->escapeHtml($article->title()->toString()) ?>
                                </a>
                                <mark-badge variant="secondary">
                                    <?= $article->status()->toString() ?>
                                </mark-badge>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div
                                        style="width: 35px; height: 35px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600; color: #5e6278;">
                                        ID:<?= $article->authorId()->toString() ?>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                    <mark-button variant="icon"
                                        href="<?= $this->url('mark.articles.edit', ['id' => $article->id()->toInt()]) ?>">
                                        ✏️
                                    </mark-button>
                                    <mark-button variant="icon-danger"
                                        href="<?= $this->url('mark.articles.delete', ['id' => $article->id()->toInt()]) ?>"
                                        onclick="return confirm('Delete this article?');">
                                        🗑️
                                    </mark-button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </mark-card>
<?php else: ?>
    <mark-card>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
            <h3 style="font-size: 1.1rem; color: #181c32; font-weight: 600; margin-bottom: 0.5rem;">No Articles Found</h3>
            <p style="color: #a1a5b7; margin-bottom: 1.5rem;">Get started by creating your first article.</p>
            <mark-button href="<?= $this->url('mark.articles.create') ?>">Create Article</mark-button>
        </div>
    </mark-card>
<?php endif; ?>

<?php $this->stop() ?>