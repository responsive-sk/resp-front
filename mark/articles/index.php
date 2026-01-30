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
        <mark-table>
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Article</th>
                        <th>Author</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td style="color: var(--admin-text-secondary); font-weight: 600;">
                                #<?= $article->id()->toInt() ?>
                            </td>
                            <td>
                                <a href="<?= $this->url('blog.show.slug', ['slug' => $article->slug()->toString()]) ?>"
                                    style="color: var(--admin-text-primary); font-weight: 600; text-decoration: none; font-size: 0.95rem; display: block; margin-bottom: 0.35rem;">
                                    <?= $this->escapeHtml($article->title()->toString()) ?>
                                </a>
                                <mark-badge variant="secondary">
                                    <?= $article->status()->toString() ?>
                                </mark-badge>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div
                                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.05); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600; color: #fff;">
                                        ID:<?= $article->authorId()->toString() ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                    <mark-button variant="icon"
                                        href="<?= $this->url('mark.articles.edit', ['id' => $article->id()->toInt()]) ?>">
                                        <!-- Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </mark-button>
                                    <mark-button variant="icon-danger"
                                        href="<?= $this->url('mark.articles.delete', ['id' => $article->id()->toInt()]) ?>"
                                        onclick="return confirm('Delete this article?');">
                                        <!-- Delete Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                    </mark-button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </mark-table>
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