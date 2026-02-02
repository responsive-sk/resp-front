<?php
// ÚPLNÝ ZAČIATOK layout/master.php
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
    // Get the title - musíme získať title z dát
    $title = '';
    if (isset($pageTitle)) {
        $title = $pageTitle;
    } elseif (isset($title)) {
        $title = $title;
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
        <?= $this->e($pageTitle ?? 'Responsive PHP') ?>
    </title>
    <meta name="description" content="<?= $this->e($metaDescription ?? 'PHP desktop apps') ?>">

    <link rel="preload" as="image" href="/images/logo.svg">
    <link rel="preload" href="/fonts/inter-400.woff2" as="font" type="font/woff2" crossorigin>

    <!-- <style>
        .pjax-loading main {
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .pjax-loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #FF5722 0%, #3498db 50%, #FF5722 100%);
            background-size: 200% 100%;
            animation: pjax-loading 1.5s ease infinite;
            z-index: 9999;
            display: none;
        }

        .pjax-loading .pjax-loading-indicator {
            display: block;
        }

        @keyframes pjax-loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style> -->

    <link rel="stylesheet" href="/build/assets/app.css">
</head>

<body>
    <!-- <div class="pjax-loading-indicator"></div> -->

    <!-- <?php
    // PJAX CHECK - ak je to PJAX request, vykresli len obsah
    if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true'):
        // Vráť len obsah section 'main'
        echo $this->section('main');
        exit;
    endif;
    ?> -->

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
    <script type="module" src="/build/assets/app.js"></script>
</body>

</html>