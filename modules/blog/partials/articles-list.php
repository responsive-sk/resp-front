<?php
    $articlesData = array_map(function ($article) {
        return [
            'id' => $article->id()->toInt(),
            'title' => $article->title()->toString(),
            'content' => $article->content()->toString(),
            'status' => $article->status()->toString(),
            'created_at' => $article->createdAt()->format(\DateTime::ATOM),
        ];
    }, $articles);

    $articlesJson = json_encode($articlesData);
?>

<article-list-section></article-list-section>

<script>
    customElements.whenDefined('article-list-section').then(() => {
        const articleList = document.querySelector('article-list-section');
        if (articleList) {
            articleList.articles = <?= $articlesJson ?>;
        }
    });
</script>
