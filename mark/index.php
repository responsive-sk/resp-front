<?php

// Mark admin routes
Route::get('/mark/login', function() {
    include __DIR__ . '/login.php';
});

Route::get('/mark/dashboard', function() {
    include __DIR__ . '/dashboard.php';
});

Route::post('/mark/login', function() {
    // Handle login logic here
    // Validate credentials, set session, redirect to dashboard
    header('Location: /mark/dashboard');
    exit;
});

Route::get('/mark/logout', function() {
    // Handle logout logic here
    // Clear session, redirect to login
    header('Location: /mark/login');
    exit;
});
