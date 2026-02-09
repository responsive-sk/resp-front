<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($pageTitle ?? 'Admin Login') ?></title>
    <meta name="description" content="<?= $this->e($metaDescription ?? 'Admin login panel') ?>">
    
    <link rel="stylesheet" href="/assets/app.css">
</head>

<body class="admin-login">
    <main class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Admin Login</h1>
                <p>Mark Admin Dashboard</p>
            </div>
            
            <form class="login-form" method="POST" action="/admin/login">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-button">
                    Login
                </button>
            </form>
        </div>
    </main>

    <style>
        body.admin-login {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        
        .login-header h1 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 24px;
            font-weight: 600;
        }
        
        .login-header p {
            margin: 0 0 32px 0;
            color: #666;
            font-size: 14px;
        }
        
        .login-form {
            text-align: left;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .login-button {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 16px;
            }
            
            .login-card {
                padding: 24px;
            }
        }
    </style>
</body>
</html>
