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

<div class="row" style="margin-bottom: 2rem;">
    <mark-card>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.1rem; color: var(--admin-text-primary);">Traffic Overview</h3>
            <div style="font-size: 0.85rem; color: var(--admin-text-secondary);">Last 7 Days</div>
        </div>

        <?php
        $chartData = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'datasets' => [
                [
                    'label' => 'Page Views',
                    'data' => [120, 190, 300, 250, 280, 350, 400],
                    'borderColor' => '#009ef7',
                    'backgroundColor' => 'rgba(0, 158, 247, 0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#1e1e2d',
                    'pointBorderColor' => '#009ef7',
                    'pointBorderWidth' => 2
                ]
            ]
        ];
        ?>
        <mark-chart type="line" data='<?= json_encode($chartData) ?>' height="300px"></mark-chart>
    </mark-card>
</div>

<div class="section-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: var(--admin-text-primary);">Latest Articles</h2>
    <mark-button href="<?= $this->url('mark.articles.create') ?>">+ New Article</mark-button>
</div>

<?php if (!empty($latest_articles)): ?>
    <mark-card no-padding>
        <mark-table>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latest_articles as $article): ?>
                        <tr>
                            <td>
                                <a href="<?= $this->url('blog.show.slug', ['slug' => $article->slug()->toString()]) ?>"
                                    style="color: var(--admin-text-primary); font-weight: 600; text-decoration: none; font-size: 0.95rem; display: block; margin-bottom: 0.25rem;">
                                    <?= $this->e($article->title()->toString()) ?>
                                </a>
                            </td>
                            <td>
                                <mark-badge variant="primary">
                                    <?= $article->status()->toString() ?>
                                </mark-badge>
                            </td>
                            <td style="color: var(--admin-text-secondary); font-size: 0.9rem;">
                                <?= $article->publishedAt() ? $article->publishedAt()->format('M d, Y') : 'Draft' ?>
                            </td>
                            <td style="text-align: right;">
                                <mark-button variant="icon"
                                    href="<?= $this->url('mark.articles.edit', ['id' => $article->id()->toString()]) ?>">
                                    <!-- Edit Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </mark-button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </mark-table>
    </mark-card>
<?php else: ?>
    <mark-card>
        <div class="empty-state" style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
            <h3 style="font-size: 1.1rem; color: var(--admin-text-primary); font-weight: 600; margin-bottom: 0.5rem;">No
                Articles Yet</h3>
            <p style="color: var(--admin-text-secondary); margin-bottom: 1.5rem;">Start sharing your thoughts with the
                world.</p>
            <mark-button href="<?= $this->url('mark.articles.create') ?>">Create Your First Article</mark-button>
        </div>
    </mark-card>
<?php endif; ?>
<?php $this->stop() ?>