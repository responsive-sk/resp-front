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
        
        <h2>Welcome :)</h2>

            <span slot="title">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
                <span class="emphasis">standard capabilities</span>
            </span>
        <h4 class="red">Get started right now!</h4>

        <boson-button slot="footer" href="<?= $this->url('home') ?>">
            Try Boson For Free
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



</boson-default-layout>

<?php $this->stop() ?>
