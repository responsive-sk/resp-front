<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($pageTitle ?? 'Admin Dashboard') ?></title>
    <meta name="description" content="<?= $this->e($metaDescription ?? 'Mark admin dashboard') ?>">
    
    <link rel="stylesheet" href="/assets/app.css">
</head>

<body class="admin-dashboard">
    <header class="admin-header">
        <div class="admin-nav">
            <div class="admin-logo">
                <h1>Mark Admin</h1>
            </div>
            <nav class="admin-menu">
                <a href="/admin/dashboard" class="admin-link active">Dashboard</a>
                <a href="/admin/posts" class="admin-link">Posts</a>
                <a href="/admin/users" class="admin-link">Users</a>
                <a href="/admin/settings" class="admin-link">Settings</a>
                <a href="/logout" class="admin-link logout">Logout</a>
            </nav>
        </div>
    </header>

    <main class="admin-main">
        <aside class="admin-sidebar">
            <div class="sidebar-section">
                <h3>Quick Actions</h3>
                <ul class="sidebar-menu">
                    <li><a href="/admin/posts/new">New Post</a></li>
                    <li><a href="/admin/pages/new">New Page</a></li>
                    <li><a href="/admin/media">Media Library</a></li>
                </ul>
            </div>
            
            <div class="sidebar-section">
                <h3>Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">42</span>
                        <span class="stat-label">Posts</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">128</span>
                        <span class="stat-label">Pages</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1,234</span>
                        <span class="stat-label">Users</span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="admin-content">
            <div class="content-header">
                <h2>Dashboard Overview</h2>
                <p>Welcome back! Here's what's happening with your Mark site.</p>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>Recent Posts</h3>
                    <div class="recent-list">
                        <div class="recent-item">
                            <span class="recent-title">Getting Started with Mark</span>
                            <span class="recent-date">2 hours ago</span>
                        </div>
                        <div class="recent-item">
                            <span class="recent-title">New Features Released</span>
                            <span class="recent-date">5 hours ago</span>
                        </div>
                        <div class="recent-item">
                            <span class="recent-title">Performance Updates</span>
                            <span class="recent-date">1 day ago</span>
                        </div>
                    </div>
                    <a href="/admin/posts" class="card-link">View All Posts</a>
                </div>

                <div class="dashboard-card">
                    <h3>System Status</h3>
                    <div class="status-list">
                        <div class="status-item">
                            <span class="status-indicator online"></span>
                            <span class="status-text">All Systems Operational</span>
                        </div>
                        <div class="status-item">
                            <span class="status-indicator warning"></span>
                            <span class="status-text">Database Backup Needed</span>
                        </div>
                        <div class="status-item">
                            <span class="status-indicator online"></span>
                            <span class="status-text">Cache Updated</span>
                        </div>
                    </div>
                    <a href="/admin/settings" class="card-link">System Settings</a>
                </div>

                <div class="dashboard-card">
                    <h3>Quick Stats</h3>
                    <div class="quick-stats">
                        <div class="quick-stat">
                            <span class="quick-number">89%</span>
                            <span class="quick-label">Uptime</span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-number">2.3s</span>
                            <span class="quick-label">Load Time</span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-number">456</span>
                            <span class="quick-label">Visitors Today</span>
                        </div>
                    </div>
                    <a href="/admin/analytics" class="card-link">View Analytics</a>
                </div>
            </div>
        </div>
    </main>

    <style>
        body.admin-dashboard {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .admin-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .admin-nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }
        
        .admin-logo h1 {
            margin: 0;
            color: #1a202c;
            font-size: 20px;
            font-weight: 700;
        }
        
        .admin-menu {
            display: flex;
            gap: 8px;
        }
        
        .admin-link {
            padding: 8px 16px;
            text-decoration: none;
            color: #64748b;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
        }
        
        .admin-link:hover {
            background: #f1f5f9;
            color: #1a202c;
        }
        
        .admin-link.active {
            background: #3b82f6;
            color: white;
        }
        
        .admin-link.logout {
            background: #ef4444;
            color: white;
        }
        
        .admin-link.logout:hover {
            background: #dc2626;
        }
        
        .admin-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 24px;
        }
        
        .admin-sidebar {
            background: white;
            border-radius: 8px;
            padding: 20px;
            height: fit-content;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-section {
            margin-bottom: 24px;
        }
        
        .sidebar-section h3 {
            margin: 0 0 12px 0;
            color: #1a202c;
            font-size: 14px;
            font-weight: 600;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 4px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: #64748b;
            border-radius: 4px;
            font-size: 13px;
            transition: background 0.2s ease;
        }
        
        .sidebar-menu a:hover {
            background: #f1f5f9;
            color: #1a202c;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }
        
        .stat-item {
            background: #f8fafc;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
        }
        
        .stat-number {
            display: block;
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
        }
        
        .stat-label {
            display: block;
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }
        
        .admin-content {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .content-header h2 {
            margin: 0 0 8px 0;
            color: #1a202c;
            font-size: 24px;
            font-weight: 700;
        }
        
        .content-header p {
            margin: 0 0 24px 0;
            color: #64748b;
            font-size: 14px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }
        
        .dashboard-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .dashboard-card h3 {
            margin: 0 0 16px 0;
            color: #1a202c;
            font-size: 16px;
            font-weight: 600;
        }
        
        .recent-list {
            margin-bottom: 16px;
        }
        
        .recent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .recent-title {
            color: #1a202c;
            font-size: 13px;
            font-weight: 500;
        }
        
        .recent-date {
            color: #64748b;
            font-size: 12px;
        }
        
        .status-list {
            margin-bottom: 16px;
        }
        
        .status-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .status-item:last-child {
            border-bottom: none;
        }
        
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .status-indicator.online {
            background: #10b981;
        }
        
        .status-indicator.warning {
            background: #f59e0b;
        }
        
        .status-text {
            color: #1a202c;
            font-size: 13px;
            font-weight: 500;
        }
        
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .quick-stat {
            text-align: center;
            padding: 12px;
            background: #f8fafc;
            border-radius: 4px;
        }
        
        .quick-number {
            display: block;
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
        }
        
        .quick-label {
            display: block;
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }
        
        .card-link {
            display: inline-block;
            color: #3b82f6;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        .card-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .admin-main {
                grid-template-columns: 1fr;
                padding: 16px;
            }
            
            .admin-sidebar {
                order: 2;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
