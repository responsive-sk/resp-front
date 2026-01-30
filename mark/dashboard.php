<?php $this->layout('resp-front::mark/layout', [
    'title' => 'Dashboard',
    'currentRoute' => 'mark.dashboard',
    'articles_count' => $articles_count ?? 0,
]) ?>

<?php $this->start('mark-content') ?>

<div class="welcome-section" style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.75rem; font-weight: 700; color: #181c32; margin-bottom: 0.5rem;">Welcome back, Mark!</h1>
    <p style="color: #a1a5b7; font-size: 1rem;">Here's what's happening with your blog today.</p>
</div>

<div class="stats-grid"
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Stat Card 1 -->
    <mark-stats-card title="Total Articles" value="<?= $articles_count ?? 0 ?>" trend="+2 new this week" icon="📝"
        iconBg="#e1f0ff">
    </mark-stats-card>

    <!-- Stat Card 2 (Placeholder) -->
    <mark-stats-card title="Active Users" value="24" trend="+5% vs last month" icon="👥" iconBg="#fff4de">
    </mark-stats-card>

    <!-- Stat Card 3 (Placeholder) -->
    <mark-stats-card title="Total Views" value="12.5k" trend="-2% vs last month" icon="👁️" iconBg="#ffe2e5">
    </mark-stats-card>
</div>

<div class="section-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #181c32;">Latest Articles</h2>
    <mark-button href="<?= $this->url('mark.articles.create') ?>">+ New Article</mark-button>
</div>

<?php if (!empty($latest_articles)): ?>
    <mark-card no-padding>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #eff2f5;">
                        <th
                            style="text-align: left; padding: 1rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Title</th>
                        <th
                            style="text-align: left; padding: 1rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Status</th>
                        <th
                            style="text-align: left; padding: 1rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Date</th>
                        <th style="padding: 1rem 1.5rem;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latest_articles as $article): ?>
                        <tr style="border-bottom: 1px dashed #eff2f5;">
                            <td style="padding: 1rem 1.5rem;">
                                <a href="<?= $this->url('blog.show.slug', ['slug' => $article->slug()->toString()]) ?>"
                                    style="color: #464e5f; font-weight: 600; text-decoration: none; font-size: 0.95rem; display: block; margin-bottom: 0.25rem;">
                                    <?= $this->e($article->title()->toString()) ?>
                                </a>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <mark-badge variant="primary">
                                    <?= $article->status()->toString() ?>
                                </mark-badge>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #7e8299; font-size: 0.9rem;">
                                <?= $article->publishedAt() ? $article->publishedAt()->format('M d, Y') : 'Draft' ?>
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <mark-button variant="icon"
                                    href="<?= $this->url('mark.articles.edit', ['id' => $article->id()->toString()]) ?>">
                                    ✏️
                                </mark-button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </mark-card>
<?php else: ?>
    <mark-card>
        <div class="empty-state" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
            <h3 style="font-size: 1.1rem; color: #181c32; font-weight: 600; margin-bottom: 0.5rem;">No Articles Yet</h3>
            <p style="color: #a1a5b7; margin-bottom: 1.5rem;">Start sharing your thoughts with the world.</p>
            <mark-button href="<?= $this->url('mark.articles.create') ?>">Create Your First Article</mark-button>
        </div>
    </mark-card>
<?php endif; ?>
<?php $this->stop() ?>