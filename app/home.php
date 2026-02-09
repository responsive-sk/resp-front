<?php $this->layout('layout::hero', [
    'title' => $title,
    'showHeader' => true,
    'showFooter' => false,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'home',
    'isPjax' => isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true'
]) ?>

<?php $this->start('hero') ?>

<!-- Horizontal Scroll Hero Section -->

<boson-hero-layout>

    <div id="pjax-container" data-pjax-container>
        <horizontal-scroll-hero slides='<?= json_encode([
            [
                "id" => "hero-1",
                "tag" => "BOSON",
                "titleLine1" => "Be Native",
                "titleLine2" => "Stay [ PHP ]",
                "subtitle" => "Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.",
                "link" => "/about",
                "backgroundImage" => "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop",
                "backgroundImageMobile" => "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=800&auto=format&fit=crop",
                "themeColor" => "#3E3E3E",
                "buttonText" => "Discover Boson"
            ],
            [
                "id" => "hero-2",
                "tag" => "PERFORMANCE",
                "titleLine1" => "Pure PHP",
                "titleLine2" => "No Electron",
                "subtitle" => "Our solution is based on simple, yet robust technologies that provide native performance and lightweight across all platforms.",
                "link" => "/docs/latest/installation",
                "backgroundImage" => "https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop",
                "backgroundImageMobile" => "https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800&auto=format&fit=crop",
                "themeColor" => "#666666",
                "buttonText" => "View Documentation"
            ],
            [
                "id" => "hero-3",
                "tag" => "COMMUNITY",
                "titleLine1" => "Open Source",
                "titleLine2" => "For Everyone",
                "subtitle" => "Join our growing community of developers building the next generation of desktop apps.",
                "link" => "/contact",
                "backgroundImage" => "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=2070&auto=format&fit=crop",
                "backgroundImageMobile" => "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop",
                "themeColor" => "#1f478a",
                "buttonText" => "Get Involved"
            ]
        ]) ?>' autoplay-interval="5000" show-navigation show-scroll-hint></horizontal-scroll-hero>
    </div>

</boson-hero-layout>

<?php $this->stop() ?>