<?php $this->layout('layout::master', [
    'title' => '404 - Page Not Found',
    'showHeader' => true,
    'showFooter' => true,
]);
?>

<boson-default-layout>
    <boson-page-title>
        <h2>404 - Page Not Found</h2>
    </boson-page-title>

    <div style="text-align: center; padding: 40px 0;">
        <h1>Oops! Page not found.</h1>
        <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <p><a href="<?= $this->url('home') ?>">Go back to homepage</a></p>
    </div>
</boson-default-layout>
