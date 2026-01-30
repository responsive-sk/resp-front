<?php
/**
 * @var int $status
 * @var string $reason
 * @var string|null $message
 */

$this->layout('layout::master', [
    'title' => 'Error ' . ($status ?? 500),
    'cssUrl' => $cssUrl ?? null,
    'jsUrl' => $jsUrl ?? null,
]);
?>

<?php $this->start('main') ?>

<boson-page-title>
    <h1>Error <?= $this->escapeHtml($status ?? 500) ?></h1>
</boson-page-title>

<div class="error-container">
    <div class="error-content">
        <h2><?= $this->escapeHtml($reason ?? 'Internal Server Error') ?></h2>

        <?php if (isset($message) && !empty($message)): ?>
            <p class="error-message"><?= $this->escapeHtml($message) ?></p>
        <?php endif; ?>

        <div class="error-actions">
            <a href="/" class="button">Go Home</a>
            <a href="javascript:history.back()" class="button secondary">Go Back</a>
        </div>

        <?php if (isset($trace)): ?>
            <div class="debug-info">
                <h3>Debug Information</h3>
                <div class="exception-details">
                    <strong>Exception:</strong> <?= $this->escapeHtml($exception_class ?? 'Unknown') ?><br>
                    <strong>File:</strong>
                    <?= $this->escapeHtml($file ?? 'Unknown') ?>:<?= $this->escapeHtml($line ?? '?') ?>
                </div>
                <pre class="trace"><?= $this->escapeHtml($trace) ?></pre>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* ... existing styles ... */
    .debug-info {
        margin-top: 3rem;
        text-align: left;
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        overflow-x: auto;
    }

    .debug-info h3 {
        color: #495057;
        margin-top: 0;
        font-size: 1.25rem;
    }

    .exception-details {
        margin-bottom: 1rem;
        font-family: monospace;
        color: #212529;
    }

    .trace {
        font-size: 0.85rem;
        white-space: pre-wrap;
        background: #212529;
        color: #f8f9fa;
        padding: 1rem;
        border-radius: 4px;
    }

    .error-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 50vh;
        padding: 2rem;
    }

    .error-content {
        text-align: center;
        max-width: 600px;
    }

    .error-content h2 {
        color: #dc3545;
        margin-bottom: 1rem;
    }

    .error-message {
        color: #666;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .button:hover {
        background: #0056b3;
    }

    .button.secondary {
        background: #6c757d;
    }

    .button.secondary:hover {
        background: #545b62;
    }
</style>

<?php $this->stop() ?>