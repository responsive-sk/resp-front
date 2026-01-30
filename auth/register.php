<?php $this->layout('layout::master', [
    'title' => $title ?? 'Register',
    'showHeader' => false,
    'showFooter' => false,
    'cssUrl' => '/build/assets/app.css', // Keep app.css for fonts/reset
    'jsUrl' => '/build/assets/mark.js',   // Use Mark JS for components
    'currentRoute' => 'auth.register',
]) ?>

<?php $this->start('main') ?>

<style>
    :root {
        /* Mark Admin Theme Colors */
        --admin-bg: #151521;
        --admin-card-bg: #1e1e2d;
        --admin-text-primary: #ffffff;
        --admin-text-secondary: #a1a5b7;
        --admin-border-color: #2b2b40;
        --admin-input-bg: #151521;
        --admin-danger: #f1416c;
        --admin-success: #50cd89;
        
        /* Auth specific overrides */
        --auth-bg: var(--admin-bg);
    }

    body {
        background-color: var(--admin-bg);
        color: var(--admin-text-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .auth-container {
        width: 100%;
        max-width: 450px;
        padding: 1rem;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-logo {
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 0.5rem;
        display: block;
        text-decoration: none;
    }

    .auth-subtitle {
        color: var(--admin-text-secondary);
        font-size: 0.9rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .alert-error {
        background: rgba(241, 65, 108, 0.1);
        color: var(--admin-danger);
        border: 1px solid rgba(241, 65, 108, 0.2);
    }
</style>

<div class="auth-container">
    <div class="auth-header">
        <a href="/" class="auth-logo">MARK PANEL</a>
        <div class="auth-subtitle">Create your account to get started</div>
    </div>

    <mark-card>
        <div style="padding: 1rem 0;">
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?= $this->escapeHtml($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= $this->url('auth.register') ?>">
                
                <mark-input label="Email" required>
                    <input type="email" name="email" value="<?= $this->escapeHtml($email ?? '') ?>" required placeholder="name@example.com">
                </mark-input>

                <mark-input label="Password" required>
                    <input type="password" name="password" required placeholder="Create a password">
                </mark-input>

                <mark-input label="Confirm Password" required>
                    <input type="password" name="confirm_password" required placeholder="Confirm your password">
                </mark-input>

                <div style="margin-top: 2rem;">
                    <mark-button type="submit" variant="primary" style="width: 100%; justify-content: center; display: flex;">
                        Register
                    </mark-button>
                </div>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem; color: var(--admin-text-secondary);">
                Already have an account? 
                <a href="<?= $this->url('auth.login.form') ?>" style="color: #009ef7; text-decoration: none; font-weight: 600;">Sign In</a>
            </div>
        </div>
    </mark-card>
</div>

<?php $this->stop() ?>