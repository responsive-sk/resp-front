<aside>
    <nav>
        <ul>
            <li>
                <?php if ($currentRoute === 'blog.index'): ?>
                    <strong>All Blog Articles</strong>
                <?php else: ?>
                    <a href="<?= $this->url('blog.index') ?>">All Blog Articles</a>
                <?php endif; ?>
            </li>
            <?php foreach ($categories as $availableCategory): ?>
                <li>
                    <?php if (isset($category) && $category->getUri() === $availableCategory->getUri()): ?>
                        <strong>
                            <?= $this->escapeHtml($availableCategory->getTitle()) ?>
                        </strong>
                    <?php else: ?>
                        <a href="<?= $this->url('blog.category', [
                            'category' => $availableCategory->getUri()
                        ]) ?>">
                            <?= $this->escapeHtml($availableCategory->getTitle()) ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</aside>
