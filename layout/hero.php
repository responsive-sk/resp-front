<?php
// ÚPLNÝ ZAČIATOK layout/hero.php
header('Vary: X-PJAX');

if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
    // Get the title
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
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $this->e($pageTitle ?? 'Boson - Native PHP Apps') ?>
    </title>
    <meta name="description"
        content="<?= $this->e($metaDescription ?? 'Turn your PHP project into cross-platform, compact, fast, native applications.') ?>">

    <link rel="preload" as="image" href="/images/logo.svg">
    <link rel="preload" href="/fonts/inter-400.woff2" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="/build/assets/app.css">

    <style>
        /* Special styles for hero layout */
        body.layout-hero {
            margin: 0;
            padding: 0;
            background: #0d1119;
            overflow-x: hidden;
        }

        .hero-header-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
        }

        /* Ensure header background is transparent */
        .hero-header-wrapper header {
            background: transparent !important;
            border-bottom: none !important;
        }
    </style>
</head>

<body class="layout-hero">

    <?php if (!isset($showHeader) || $showHeader): ?>
        <div class="hero-header-wrapper">
            <?php $this->insert('partials::header') ?>
        </div>
    <?php endif; ?>

    <main>
        <?= $this->section('main') ?>
    </main>

    <?php if (!isset($showFooter) || $showFooter): ?>
        <?php $this->insert('partials::footer') ?>
    <?php endif; ?>

    <script type="module" src="/build/assets/app.js"></script>
</body>

</html>