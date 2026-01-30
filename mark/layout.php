<?php $this->layout('layout::master', [
    'title' => ($title ?? 'Panel') . ' - Mark Panel',
    'showHeader' => false,
    'showFooter' => false,
    'cssUrl' => '/build/assets/app.css', // Should ideally be mark.css if split build output supports it
    'jsUrl' => '/build/assets/mark.js', // Use the mark entry point
] + ($data ?? [])) ?>

<?php $this->start('main') ?>

<mark-layout>
    <mark-sidebar slot="sidebar">
        <span slot="logo">Mark Panel</span>

        <div class="nav-label">Main</div>
        <a href="<?= $this->url('mark.dashboard') ?>"
            class="<?= $this->e($currentRoute) === 'mark.dashboard' ? 'active' : '' ?>">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-label">Content</div>
        <a href="<?= $this->url('mark.articles.index') ?>"
            class="<?= (str_starts_with($this->e($currentRoute), 'mark.articles') ? 'active' : '') ?>">
            <span class="nav-icon">📝</span> Articles
        </a>

        <div class="nav-label">System</div>
        <a href="<?= $this->url('mark.users.index') ?>"
            class="<?= (str_starts_with($this->e($currentRoute), 'mark.users') ? 'active' : '') ?>">
            <span class="nav-icon">👥</span> Users
        </a>

        <div style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05);"></div>
        <a href="<?= $this->url('home') ?>">
            <span class="nav-icon">🏠</span> Back to Site
        </a>
        <a href="<?= $this->url('auth.logout') ?>" style="color: #ff6b6b;">
            <span class="nav-icon">🚪</span> Logout
        </a>
    </mark-sidebar>

    <mark-header slot="header" title="<?= $this->e($title ?? 'Dashboard') ?>" user="Mark User"
        role="Manager"></mark-header>

    <?= $this->section('mark-content') ?>

    <!-- Flash Messages Integration -->
    <?php if (isset($flash_success)): ?>
        <script>
            window.addEventListener('load', () => {
                const check = setInterval(() => {
                    if (window.MarkNotify) {
                        clearInterval(check);
                        MarkNotify.success(<?= json_encode($flash_success) ?>);
                    }
                }, 50);
            });
        </script>
    <?php endif; ?>

    <?php if (isset($flash_error)): ?>
        <script>
            window.addEventListener('load', () => {
                const check = setInterval(() => {
                    if (window.MarkNotify) {
                        clearInterval(check);
                        MarkNotify.error(<?= json_encode($flash_error) ?>);
                    }
                }, 50);
            });
        </script>
    <?php endif; ?>

</mark-layout>

<?php $this->stop() ?>