<?php
/**
 * @var int $status
 * @var string $reason
 * @var string|null $message
 * @var string|null $trace
 * @var string|null $exception_class
 * @var string|null $file
 * @var int|null $line
 */

$this->layout('layout::master', [
    'title' => 'Error ' . ($status ?? 500) . ' :: Boson',
    'cssUrl' => $cssUrl ?? '/build/assets/app.css',
    'jsUrl' => $jsUrl ?? '/build/assets/app.js',
]);
?>

<?php $this->start('main') ?>

<div class="error-page-container">
    <div class="error-content">
        <div class="error-icon">
            <?php if (($status ?? 500) == 404): ?>
                🔍
            <?php else: ?>
                ⚠️
            <?php endif; ?>
        </div>

        <h1 class="error-title">
            <?= $this->escapeHtml($status ?? 500) ?>
        </h1>

        <h2 class="error-reason">
            <?= $this->escapeHtml($reason ?? 'Internal Server Error') ?>
        </h2>

        <p class="error-message">
            <?= $this->escapeHtml($message ?? 'An unexpected error occurred.') ?>
        </p>

        <div class="error-actions">
            <boson-button href="/" variant="primary">
                Back to Home
            </boson-button>
            <boson-button onclick="history.back()" variant="secondary">
                Go Back
            </boson-button>
        </div>

        <?php if (isset($trace) || isset($exception_class)): ?>
            <div class="debug-section">
                <details>
                    <summary>Technical Details <span>(Click to expand)</span></summary>
                    <div class="debug-content">
                        <?php if (isset($exception_class)): ?>
                            <div class="debug-item">
                                <strong>Exception:</strong>
                                <span class="mono"><?= $this->escapeHtml($exception_class) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($file)): ?>
                            <div class="debug-item">
                                <strong>File:</strong>
                                <span class="mono"><?= $this->escapeHtml($file) ?>:<?= $this->escapeHtml($line ?? '?') ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($trace)): ?>
                            <div class="trace-container">
                                <strong>Stack Trace:</strong>
                                <pre class="trace"><?= $this->escapeHtml($trace) ?></pre>
                            </div>
                        <?php endif; ?>
                    </div>
                </details>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .error-page-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        padding: 2rem;
        background: var(--color-bg, #0d1119);
        color: var(--color-text, #ffffff);
    }

    .error-content {
        text-align: center;
        max-width: 800px;
        width: 100%;
    }

    .error-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: float 3s ease-in-out infinite;
    }

    .error-title {
        font-size: 5rem;
        font-weight: 800;
        margin: 0;
        line-height: 1;
        background: linear-gradient(135deg, #ff5722 0%, #ff9800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-family: var(--font-title, 'Roboto Condensed', sans-serif);
    }

    .error-reason {
        font-size: 2rem;
        font-weight: 300;
        margin: 0.5rem 0 1.5rem;
        color: var(--color-text-secondary, #a0aec0);
    }

    .error-message {
        font-size: 1.1rem;
        color: var(--color-text-secondary, #a0aec0);
        margin-bottom: 2.5rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 3rem;
    }

    .debug-section {
        margin-top: 2rem;
        text-align: left;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 2rem;
    }

    details {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        overflow: hidden;
    }

    summary {
        padding: 1rem;
        cursor: pointer;
        font-weight: 600;
        color: var(--color-text-secondary, #a0aec0);
        user-select: none;
        transition: color 0.2s;
    }

    summary:hover {
        color: var(--color-text, #ffffff);
    }

    summary span {
        font-weight: 400;
        font-size: 0.85em;
        opacity: 0.7;
        margin-left: 0.5rem;
    }

    .debug-content {
        padding: 1rem;
        background: rgba(0, 0, 0, 0.3);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .debug-item {
        margin-bottom: 0.75rem;
        font-family: monospace;
        word-break: break-all;
    }

    .debug-item strong {
        color: #ff5722;
        margin-right: 0.5rem;
    }

    .mono {
        color: #e2e8f0;
    }

    .trace-container {
        margin-top: 1rem;
    }

    .trace-container strong {
        display: block;
        color: #ff5722;
        margin-bottom: 0.5rem;
        font-family: monospace;
    }

    .trace {
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
        font-size: 0.8rem;
        background: #1a202c;
        color: #d1d5db;
        padding: 1rem;
        border-radius: 4px;
        overflow-x: auto;
        white-space: pre-wrap;
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }
</style>

<?php $this->stop() ?>