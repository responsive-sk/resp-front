<?php $this->layout('layout::master', [
    'title' => $title,
    // 'showHeader' => true,
    // 'showFooter' => true,
    // 'cssUrl' => '/build/assets/app.css',
    // 'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'about',
    'isPjax' => isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true'
]) ?>

<?php $this->start('main') ?>

<boson-default-layout>
    <boson-page-title>
        <h1>About Us</h1>
    </boson-page-title>


    <?php
    $accordionData = json_encode([
        [
            'headline' => 'Frontend',
            'text' => 'Modern, responsive interfaces built with Lit, Web Components, and Vanilla JS. We prioritize performance and user experience.'
        ],
        [
            'headline' => 'Backend',
            'text' => 'Robust PHP architectures using DDD principles, Clean Code through Doctrine ORM, and scalable database designs.'
        ],
        [
            'headline' => 'API Design',
            'text' => 'RESTful APIs that are secure, documented, and easy to consume. Bridging the gap between your data and your users.'
        ],
        [
            'headline' => 'Architecture',
            'text' => 'Building scalable, maintainable systems that grow with your business needs.'
        ],
    ]);
    ?>

    <?php
    $galleryImages = [
        [
            'src' => 'https://xtendui.github.io/xtendui/stock/gpii_myxZG0.jpg',
            'alt' => 'Modern Website Design',
            'caption' => 'Modern website with dark theme',
            'width' => 800,
            'height' => 600
        ],
        [
            'src' => 'https://xtendui.github.io/xtendui/stock/164_6wVEHfI.jpg',
            'alt' => 'Mobile App UI',
            'caption' => 'iOS banking application',
            'width' => 800,
            'height' => 600
        ],
        [
            'src' => 'https://xtendui.github.io/xtendui/stock/j7zu2kpTnwY.jpg',
            'alt' => 'Dashboard Design',
            'caption' => 'Analytics dashboard with charts',
            'width' => 800,
            'height' => 600
        ],
        [
            'src' => 'https://xtendui.github.io/xtendui/stock/l8p1aWZqHvE.jpg',
            'alt' => 'E-commerce Platform',
            'caption' => 'Online shopping interface',
            'width' => 800,
            'height' => 600
        ],
        [
            'src' => 'https://xtendui.github.io/xtendui/stock/kP6knT7tjn4.jpg',
            'alt' => 'Brand Identity',
            'caption' => 'Logo and brand guidelines',
            'width' => 800,
            'height' => 600
        ],
        [
            'src' => 'https://xtendui.github.io/xtendui/stock/gpii_myxZG0.jpg',
            'alt' => 'Social Media Design',
            'caption' => 'Instagram templates and stories',
            'width' => 800,
            'height' => 600
        ]
    ];

    $galleryCategories = ['Web Design', 'Mobile', 'Dashboard', 'Branding'];
    ?>

    <gallery-section id="portfolio-gallery" title="Our Portfolio"
        description="Explore our latest projects and creative work" show-filters
        images='<?= json_encode($galleryImages, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
        categories='<?= json_encode($galleryCategories, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
    </gallery-section>

    <mobile-development-section>
        <segment-section type="horizontal">
            <span slot="section">
                Rich API
            </span>

            <span slot="title">
                Expanding the boundaries<br />
                of <span class="emphasis">standard capabilities</span>
            </span>

            <p>
                Boson provides not only the ability to create desktop
                applications, but also a variety of rich APIs for accessing
                PC subsystems.
            </p>

            <p>
                <boson-button href="/docs/latest/webview">
                    Read More
                </boson-button>
            </p>
        </segment-section>

    </mobile-development-section>


    <segment-section>

        <span slot="section">
            About Us
        </span>

        <h2>Our Technical Expertise</h2>

        <span slot="title">
            We are a team of passionate developers building robust solutions on both <span class="emphasis">frontend and
                backend</span>.
        </span>

        <div style="margin: 40px 0;">
            <horizontal-accordion content='<?= $accordionData ?>'></horizontal-accordion>
        </div>
        <h4 class="red">We bring your ideas to life!</h4>

        <boson-button slot="footer" href="<?= $this->url('home') ?>">
            View Our Projects
        </boson-button>
    </segment-section>


    <call-to-action-section>
        <h3>
            If you are a PHP developer, you can already <br>
            make native cross-platform applications.<br>
            Boson PHP makes it possible!<br>
        </h3>

        <h4 class="red">Get started right now!</h4>

        <boson-button slot="footer" href="/docs/latest/installation">
            Try Boson For Free
        </boson-button>
    </call-to-action-section>

</boson-default-layout>

<?php $this->stop() ?>