<?php
// ÚPLNÝ ZAČIATOK layout/master.php
header('Vary: X-PJAX, HX-Request');

if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
    // Get the title - musíme získať title z dát
    if (isset($pageTitle)) {
        $title = $pageTitle;
    } elseif (!isset($title)) {
        $title = '';
    }

    header('Content-Type: application/json');
    header('X-PJAX: true');

    $content = $this->section('main');

    echo json_encode([
        'title' => $title ? $title . ' - Boson' : 'Boson',
        'content' => $content,
        'url' => $_SERVER['REQUEST_URI']
    ]);
    exit;
}

if (isset($_SERVER['HTTP_HX_REQUEST'])) {
    // HTMX request - vrátiť len content
    error_log('HTMX request detected: ' . $_SERVER['REQUEST_URI']);
    header('Content-Type: text/html');
    header('HX-Trigger: afterSwap');
    
    echo $this->section('main');
    exit;
}
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $this->e($pageTitle ?? 'Responsive PHP') ?>
    </title>
    <meta name="description" content="<?= $this->e($metaDescription ?? 'PHP desktop apps') ?>">
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=customElements"></script> -->
<script src="https://unpkg.com/@webcomponents/webcomponentsjs@2.8.0/webcomponents-bundle.js"></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <link rel="stylesheet" href="/assets/app.css">
</head>

<body>
    <?php if (!isset($showHeader) || $showHeader): ?>
        <?php $this->insert('partials::header') ?>
    <?php endif; ?>

    <main data-container>
        <?= $this->section('main') ?>
    </main>


    <?php if (!isset($showFooter) || $showFooter): ?>
        <?php $this->insert('partials::footer') ?>
    <?php endif; ?>

    <!-- JEDINÝ SCRIPT -->
    <script type="module" src="/assets/app.js"></script>
</body>

</html>