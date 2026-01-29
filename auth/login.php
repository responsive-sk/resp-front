<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->escapeHtml($title ?? 'Login') ?></title>
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc;">
        <h1>Login</h1>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;">
                <?= $this->escapeHtml($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?= $this->url('login') ?>">
            <div style="margin-bottom: 15px;">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?= $this->escapeHtml($email ?? '') ?>" required style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 8px;">
            </div>
            
            <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer;">
                Login
            </button>
        </form>
        
        <p style="margin-top: 20px;">
            Don't have an account? <a href="<?= $this->url('register_form') ?>">Register here</a>
        </p>
        
        <p>
            <a href="<?= $this->url('home') ?>">← Back to home</a>
        </p>
    </div>
</body>
</html>
