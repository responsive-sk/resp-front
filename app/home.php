<?php $this->layout('layout::master', [
    'title' => $title,
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'home',
]) ?>

<?php $this->start('main') ?>

<boson-boson-docs-layout>
    <hero-section>
        <h1 slot="title">Be Native<br>
            <span>Stay [ PHP ]</span>
        </h1>

        <span slot="description">
            Turn your PHP project into cross-platform, compact, fast, native
            applications for Windows, Linux and macOS.
        </span>

        <boson-button slot="buttons" href="/about" icon="/images/icons/arrow_primary.svg" icon-width="20"
            icon-height="20">
            About Us
        </boson-button>

        <span slot="discovery">
            Discover more about boson
        </span>
    </hero-section>

    <segment-section>
        <span id="nativeness" class="anchor"></span>

        <span slot="section">
            Nativeness
        </span>

        <span slot="title">
            Familiar PHP. Now for desktop applications.
        </span>

        <p>
            "What makes you think PHP is only for the web?"<br>
            – Boson is changing the rules of the game!
        </p>
    </segment-section>

    <!-- <nativeness-section></nativeness-section> -->

    <segment-section>
        <span slot="section">
            Solves
        </span>

        <span slot="title">
            What you <span class="emphasis">can do</span> with <br>
            Boson?
        </span>

        <ul>
            <li>
                Launch any ready-made web project in a Desktop
                environment without a browser and server.
            </li>
            <li>
                Compile an application for the desired desktop platform
                based on an existing PHP project.
            </li>
        </ul>
    </segment-section>

    <solves-section></solves-section>

    <segment-section>
        <span slot="section">
            How It Works
        </span>

        <span slot="title">
            Under the Hood of <br />
            Boson
        </span>

        <p>
            Why Boson? Because it's not Electron! And much lighter...
        </p>

        <p>
            Want to know what makes Boson so compact, fast and versatile?
            We don't use Electron or other Chromium instance builds.
            Instead, our solution is based on simple, yet robust and
            up-to-date technologies that provide native performance
            and lightweight across all platforms.
        </p>
    </segment-section>

    <!--    <how-it-works-section></how-it-works-section>-->

    <!--    <right-choice-section></right-choice-section>-->

    <mobile-development-section>
        <segment-section type="vertical">
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

    <segment-section type="center">
        <span slot="section">
            Testimonials
        </span>

        <span slot="title">
            Developers that <br />
            believe in us
        </span>
    </segment-section>

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
    </boson-docs-layout>

    <?php $this->stop() ?>