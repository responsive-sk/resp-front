<?php
// ÚPLNÝ ZAČIATOK layout/hero.php
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

    // Get the hero content
    $content = $this->section('hero');

    echo json_encode([
        'title' => $this->e($pageTitle ?? 'Responsive PHP'),
        'content' => $content,
        'url' => $_SERVER['REQUEST_URI']
    ]);
    exit;
}

if (isset($_SERVER['HTTP_HX_REQUEST'])) {
    // HTMX request - vrátiť len hero content
    error_log('HTMX request detected in hero: ' . $_SERVER['REQUEST_URI']);
    header('Content-Type: text/html');
    header('HX-Trigger: afterSwap');
    
    echo $this->section('hero');
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
    <style>
        /* Fullscreen hero layout - len pre hero stránky */
        body.hero-page {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        
        body.hero-page main[data-container] {
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        /* Hero page štýly pre resp-header */
        body.hero-page resp-header {
            background: rgba(13, 17, 25, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.hero-page resp-header .logo img {
            filter: brightness(0) invert(1);
        }
        
        body.home-page-header resp-header boson-button {
            color: rgba(255, 255, 255, 0.8);
        }
        
        body.home-page-header resp-header boson-button:hover {
            color: white;
        }
        
        /* Schovať search na home page */
        body.home-page-header resp-header boson-search-input {
            display: none;
        }
        
        @media (max-width: 768px) {
            body.home-page-header resp-header {
                padding: 16px 20px;
            }
        }
    </style>
    
    <script>
        // Pridať hero class len pre hero stránky
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname === '/' || window.location.pathname === '/home') {
                document.body.classList.add('hero-page');
            }
        });
    </script>
</head>

<body>

    <!-- Rovnaký header partial ako master layout -->
    <?php if (!isset($showHeader) || $showHeader): ?>
        <?php $this->insert('partials::header') ?>
    <?php endif; ?>

    <!-- Hero content - fullscreen s rovnakým headerom -->
    <main data-container>
        <?= $this->section('hero') ?>
    </main>

    <!-- JEDINÝ SCRIPT -->
    <script type="module" src="/assets/app.js"></script>
</body>

</html>