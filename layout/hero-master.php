<?php
// ÚPLNÝ ZAČIATOK layout/hero-master.php
header('Vary: X-PJAX');

if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
    $title = '';
    if (isset($pageTitle)) {
        $title = $pageTitle;
    } elseif (!isset($title)) {
        $title = '';
    }

    header('Content-Type: application/json');
    header('X-PJAX: true');

    $content = $this->section('hero-content'); // Changed to hero-content based on user example

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
        body.layout-hero-master {
            margin: 0;
            padding: 0;
            background: #0d1119;
            overflow: hidden;
            /* Fullscreen hero usually implies no scroll on body */
        }
    </style>
</head>

<body class="layout-hero-master">

    <!-- Hero content is expected to handle its own layout/header/footer -->
    <?= $this->section('hero-content') ?>

    <script type="module" src="/build/assets/app.js"></script>
</body>

</html>