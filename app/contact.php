<?php $this->layout('layout::master', [
    'title' => $title,
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/build/assets/app.css',
    'jsUrl' => '/build/assets/app.js',
    'currentRoute' => 'contact',
]) ?>

<?php $this->start('main') ?>

<boson-default-layout>
    <boson-page-title>
        <h1>Contact Us</h1>
    </boson-page-title>

    <segment-section>
        <span slot="section">
            Get in touch
        </span>

        <h2>We'd love to hear from you</h2>

        <span slot="title">
            Have a project in mind or want to learn more about our services? <br>
            <span class="emphasis">Drop us a line!</span>
        </span>

        <p>
            Whether you are interested in our frontend expertise, backend solutions, or just want to say hello, we are
            always open to new opportunities and collaborations.
        </p>

        <div
            style="margin-top: 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div
                style="background: var(--color-bg-secondary); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
                <h3 style="margin-top: 0;">Email Us</h3>
                <p>
                    <a href="mailto:hello@boson-lab.com"
                        style="color: var(--color-primary); text-decoration: none; font-size: 1.1em;">hello@boson-lab.com</a>
                </p>
                <p style="color: var(--color-text-secondary);">For general inquiries and project proposals.</p>
            </div>

            <div
                style="background: var(--color-bg-secondary); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
                <h3 style="margin-top: 0;">Join the Team</h3>
                <p>
                    <a href="mailto:careers@boson-lab.com"
                        style="color: var(--color-primary); text-decoration: none; font-size: 1.1em;">careers@boson-lab.com</a>
                </p>
                <p style="color: var(--color-text-secondary);">Talented developers are always welcome.</p>
            </div>
        </div>

        <h4 class="red">Ready to start?</h4>

        <boson-button slot="footer" href="mailto:hello@boson-lab.com">
            Send us an Email
        </boson-button>
    </segment-section>

</boson-default-layout>

<?php $this->stop() ?>