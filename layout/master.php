<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ PRIDAJ - povinný title -->
    <title><?= $this->e($pageTitle ?? 'Boson - Go Native. Stay PHP') ?></title>
    <meta name="description" content="<?= $this->e($metaDescription ?? 'Turn your PHP project into cross-platform, compiled applications') ?>">

    <!-- ✅ PRIDAJ - Preload LCP image (logo) -->
    <link rel="preload" as="image" href="/images/logo.svg" fetchpriority="high">

    <!-- 1. Preload kritických fontov -->
    <link rel="preload" href="/fonts/inter-400.woff2" as="font" type="font/woff2" crossorigin>

    <!-- 2. Modulepreload pre JS -->
    <?php if (isset($jsUrl) && $jsUrl): ?>
        <link rel="modulepreload" href="<?= $jsUrl ?>">
    <?php endif; ?>

    <!-- 3. Inline kritické CSS -->
    <style>
        /* Critical above-the-fold CSS */
        boson-landing-layout {
            display: block;
            min-height: 100vh;
        }
        boson-landing-layout main {
            display: block;
            min-height: 700px;
        }

        /* Font loading */
        @font-face {
            font-family: 'Inter';
            src: url('/fonts/inter-400.woff2') format('woff2');
            font-weight: 400;
            font-display: swap;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        /* ✅ PRIDAJ - Critical logo styles */
        .logo {
            display: block;
            width: 255px;
            height: 100px;
        }
    </style>

    <!-- 4. Link na full CSS -->
    <?php if (isset($cssUrl) && $cssUrl): ?>
        <link rel="stylesheet" href="<?= $cssUrl ?>" fetchpriority="high">
    <?php endif; ?>
</head>
<body>
<?php if (!isset($showHeader) || $showHeader): ?>
    <?php $this->insert('partials::header', [
            'currentRoute' => $currentRoute ?? '',
            'searchQuery' => $searchQuery ?? '',
    ]) ?>
<?php endif; ?>
<main>
    <?= $this->section('main') ?>
</main>

<?php if (!isset($showFooter) || $showFooter): ?>
    <?php $this->insert('partials::footer') ?>
<?php endif; ?>

<!-- Scripts - w3c recommendation: If a script has type="module", you should not include the defer attribute since module scripts defer automatically. -->
<?php if (isset($jsUrl) && $jsUrl): ?>
    <script type="module" src="<?= $jsUrl ?>"></script>
<?php endif; ?>
</body>
</html>