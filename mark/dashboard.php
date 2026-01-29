<?php $this->layout('boson/layout/master') ?>

<h1>Vitaj, Mark!</h1>

<p>Toto je tvoj dashboard. Tu môžeš spravovať články.</p>

<div class="stats">
    <div class="card">
        <h3>Počet článkov</h3>
        <p class="number"><?= $articles_count ?? 0 ?></p>
    </div>
    <!-- Pridaj ďalšie štatistiky: publikované, drafty, atď. -->
</div>

<h2>Posledné články</h2>

<?php if (!empty($latest_articles)): ?>
    <ul>
        <?php foreach ($latest_articles as $article): ?>
            <li>
                <a href="/blog/<?= $article->slug()->toString() ?>">
                    <?= $this->e($article->title()->toString()) ?>
                </a>
                <span>(<?= $article->status()->toString() ?>)</span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Ešte nemáš žiadne články. <a href="/mark/articles/create">Vytvoriť prvý</a></p>
<?php endif; ?>

<a href="/mark/articles" class="btn">Spravovať články</a>
<a href="/logout" class="btn secondary">Odhlásiť sa</a>