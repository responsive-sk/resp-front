<?php $this->layout('layout::master', [
    'title' => $title,
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'about',
]) ?>

<?php $this->start('main') ?>

<boson-default-layout>
    <boson-page-title>
        <h1>About Us</h1>
    </boson-page-title>

    <segment-section>

        <span slot="section">
            About Us
        </span>

        <h2>Our Technical Expertise</h2>

        <span slot="title">
            We are a team of passionate developers building robust solutions on both <span class="emphasis">frontend and
                backend</span>.
        </span>

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
        <div style="margin: 40px 0;">
            <horizontal-accordion content='<?= $accordionData ?>'></horizontal-accordion>
        </div>
        <h4 class="red">We bring your ideas to life!</h4>

        <boson-button slot="footer" href="<?= $this->url('home') ?>">
            View Our Projects
        </boson-button>
    </segment-section>

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

    <testimonials-section></testimonials-section>

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