<?php
$this->layout('layout::master', [
    'title' => '404 - Page Not Found',
    // 'showHeader' => true,
    // 'showFooter' => true,
    // 'cssUrl' => '/build/assets/app.css',
    // 'jsUrl' => '/build/assets/app.js',
    'currentRoute' => '404',
    'isPjax' => isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true'
]);
?>

<?php $this->start('main') ?>
<boson-default-layout>
    <boson-page-title>
        <h1>Úúps!</h1>
    </boson-page-title>

    <div style="text-align: center; padding: 40px 0;">
        <h2>404 - Page Not Found</h2>
        <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>
        <p><a href="<?= $this->url('home') ?>">Go back to homepage</a></p>
    </div>
</boson-default-layout>
<?php $this->stop() ?>