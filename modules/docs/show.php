<?php $this->layout('layout::master', [
    'title' => $document->getTitle()->toString() . ' :: Documentation',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    'jsUrl' => $jsUrl ?? '/build/assets/app.js',
    'currentRoute' => $currentRoute ?? 'docs.show',
    'docsVersion' => null, // $document->getVersion(),
    'docsCategories' => [], // $navigation ?? [],
]) ?>

<?php $this->start('main') ?>

<boson-page-title>
    <h1><?= $this->escapeHtml($document->getTitle()->toString()) ?></h1>
</boson-page-title>

<boson-breadcrumbs>
    <div class="breadcrumb-item">
        <boson-button type="ghost" href="<?= $this->url('home') ?>">
            Home
        </boson-button>
    </div>

    <div class="breadcrumb-item">
        <boson-button type="ghost" href="<?= $this->url('docs.index') ?>">
            Documentation
        </boson-button>
    </div>

    <div class="breadcrumb-item">
        <boson-button type="ghost">
            <?= $this->escapeHtml($document->getVersion()->getDisplayName()) ?>
        </boson-button>
    </div>

    <div class="breadcrumb-item">
        <boson-button type="ghost">
            <?= $this->escapeHtml($document->getTitle()->toString()) ?>
        </boson-button>
    </div>
</boson-breadcrumbs>

<div class="docs-layout-simple" style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem; max-width: 1200px; margin: 0 auto; padding: 2rem;">
    <!-- Sidebar -->
    <aside class="docs-sidebar" style="border-right: 1px solid #e5e7eb; padding-right: 2rem;">
        <div class="version-selector" style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.2rem; margin-bottom: 1rem;">Version</h2>
            <select onchange="window.location.href = '/docs/' + this.value + '/<?= $document->getSlug() ?>'" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
                <?php foreach ($availableVersions ?? [] as $version): ?>
                    <option value="<?= $this->escapeHtml($version->toString()) ?>"
                            <?= $version->equals($document->getVersion()) ? 'selected' : '' ?>>
                        <?= $this->escapeHtml($version->getDisplayName()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <nav class="docs-navigation">
            <?php foreach ($navigation ?? [] as $category => $documents): ?>
                <div class="nav-category">
                    <h3><?= $this->escapeHtml($category) ?></h3>
                    <ul>
                        <?php foreach ($documents as $doc): ?>
                            <li>
                                <a href="<?= $this->url('docs.show', [
                                    'version' => $doc->getVersion()->toString(),
                                    'page' => $doc->getSlug()
                                ]) ?>"
                                   class="<?= $doc->getSlug() === $document->getSlug() ? 'active' : '' ?>">
                                    <?= $this->escapeHtml($doc->getTitle()->toString()) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="docs-content">
        <article class="document" style="line-height: 1.7; font-size: 1.1rem;">
            <?= $document->getContent()->toString() ?>
        </article>

        <!-- Document navigation -->
        <div class="document-navigation" style="display: flex; justify-content: space-between; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
            <?php if ($previousDocument ?? null): ?>
                <a href="<?= $this->url('docs.show', [
                    'version' => $previousDocument->getVersion()->toString(),
                    'page' => $previousDocument->getSlug()
                ]) ?>" class="nav-previous" style="text-decoration: none; color: #3b82f6; font-weight: 500;">
                    ← <?= $this->escapeHtml($previousDocument->getTitle()->toString()) ?>
                </a>
            <?php else: ?>
                <div></div>
            <?php endif; ?>

            <?php if ($nextDocument ?? null): ?>
                <a href="<?= $this->url('docs.show', [
                    'version' => $nextDocument->getVersion()->toString(),
                    'page' => $nextDocument->getSlug()
                ]) ?>" class="nav-next" style="text-decoration: none; color: #3b82f6; font-weight: 500;">
                    <?= $this->escapeHtml($nextDocument->getTitle()->toString()) ?> →
                </a>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php $this->stop() ?>
