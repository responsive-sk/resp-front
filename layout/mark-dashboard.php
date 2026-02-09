<?php

declare(strict_types=1);

// Mark Dashboard Layout - Dark theme with Shoelace support
// Specifically designed for Mark admin interface

header('Vary: X-PJAX');

if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === 'true') {
    // Get the title
    if (isset($pageTitle)) {
        $title = $pageTitle;
    } elseif (!isset($title)) {
        $title = '';
    }

    header('Content-Type: application/json');
    header('X-PJAX: true');

    $content = $this->section('main');

    echo json_encode([
        'title' => $title ? $title . ' - Mark Dashboard' : 'Mark Dashboard',
        'content' => $content,
        'url' => $_SERVER['REQUEST_URI']
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="sk" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' - Mark Dashboard' : 'Mark Dashboard' ?></title>
    
    <!-- Mark CSS Build -->
    <link rel="stylesheet" href="/assets/mark/mark.css">
    
    <!-- Shoelace Web Components - Dark Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0/dist/themes/dark.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0/dist/shoelace.js"></script>
    
    <!-- Mark Dashboard Styles -->
    <style>
        :root {
            /* Dark theme variables */
            --sl-color-primary-600: #0ea5e9;
            --sl-color-success-600: #10b981;
            --sl-color-warning-600: #f59e0b;
            --sl-color-danger-600: #ef4444;
            
            /* Neutral colors for dark theme */
            --sl-color-neutral-0: #0f172a;
            --sl-color-neutral-50: #1e293b;
            --sl-color-neutral-100: #334155;
            --sl-color-neutral-200: #475569;
            --sl-color-neutral-300: #64748b;
            --sl-color-neutral-400: #94a3b8;
            --sl-color-neutral-500: #cbd5e1;
            --sl-color-neutral-600: #e2e8f0;
            --sl-color-neutral-700: #f1f5f9;
            --sl-color-neutral-800: #f8fafc;
            --sl-color-neutral-900: #ffffff;
            
            /* Custom Mark colors */
            --mark-bg: #0f172a;
            --mark-surface: #1e293b;
            --mark-border: #334155;
            --mark-text: #f8fafc;
            --mark-text-muted: #94a3b8;
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            background: var(--mark-bg);
            color: var(--mark-text);
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }
        
        /* Shoelace dark theme overrides */
        sl-card {
            --sl-panel-background-color: var(--mark-surface);
            --sl-color-neutral-950: var(--mark-text);
            border: 1px solid var(--mark-border);
        }
        
        sl-select::part(display-input),
        sl-input::part(input),
        sl-textarea::part(textarea) {
            background-color: var(--mark-surface);
            color: var(--mark-text);
            border-color: var(--mark-border);
        }
        
        sl-button::part(base) {
            background-color: var(--sl-color-primary-600);
            color: white;
            border: none;
        }
        
        sl-button::part(base):hover {
            background-color: #0284c7;
        }
        
        /* Mark specific styles */
        .mark-header {
            background: var(--mark-surface);
            border-bottom: 1px solid var(--mark-border);
            padding: 1rem 2rem;
        }
        
        .mark-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .mark-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--mark-text);
            text-decoration: none;
        }
        
        .mark-nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .mark-nav-link {
            color: var(--mark-text-muted);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .mark-nav-link:hover {
            color: var(--mark-text);
            background: var(--mark-border);
        }
        
        .mark-nav-link.active {
            color: var(--sl-color-primary-600);
            background: rgba(14, 165, 233, 0.1);
        }
        
        .mark-main {
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }
        
        .mark-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .mark-card {
            background: var(--mark-surface);
            border: 1px solid var(--mark-border);
            border-radius: 0.5rem;
            padding: 1.5rem;
        }
        
        .mark-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--mark-text);
        }
        
        .mark-card-description {
            color: var(--mark-text-muted);
            margin-bottom: 1rem;
        }
        
        .mark-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 1rem;
        }
        
        .mark-stat {
            text-align: center;
        }
        
        .mark-stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--sl-color-primary-600);
        }
        
        .mark-stat-label {
            font-size: 0.875rem;
            color: var(--mark-text-muted);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .mark-header {
                padding: 1rem;
            }
            
            .mark-nav {
                flex-direction: column;
                gap: 1rem;
            }
            
            .mark-nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .mark-main {
                padding: 1rem;
            }
            
            .mark-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    <?= $this->section('head') ?>
</head>

<body>
    <!-- Mark Header -->
    <header class="mark-header">
        <nav class="mark-nav">
            <div>
                <a href="/mark" class="mark-brand">Mark Dashboard</a>
            </div>
            <div class="mark-nav-links">
                <a href="/mark" class="mark-nav-link" data-page="dashboard">Dashboard</a>
                <a href="/mark/articles" class="mark-nav-link" data-page="articles">Articles</a>
                <a href="/mark/users" class="mark-nav-link" data-page="users">Users</a>
                <a href="/mark/categories" class="mark-nav-link" data-page="categories">Categories</a>
                <a href="/mark/tags" class="mark-nav-link" data-page="tags">Tags</a>
                <a href="/blog" class="mark-nav-link">View Blog</a>
                <a href="/logout" class="mark-nav-link">Logout</a>
            </div>
        </nav>
    </header>

    <!-- Main content -->
    <main class="mark-main">
        <?= $this->section('main') ?>
    </main>

    <!-- Mark JS Build -->
    <script type="module" src="/assets/mark/mark.js"></script>
    
    <!-- Mark Components Build -->
    <script type="module" src="/assets/mark/components/mark-components.js"></script>
    
    <!-- Additional scripts -->
    <?= $this->section('scripts') ?>
    
    <!-- Mark Dashboard JavaScript -->
    <script>
        // Set active navigation based on current path
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.mark-nav-link[data-page]');
            
            navLinks.forEach(link => {
                const page = link.getAttribute('data-page');
                let isActive = false;
                
                switch(page) {
                    case 'dashboard':
                        isActive = currentPath === '/mark' || currentPath === '/mark/dashboard';
                        break;
                    case 'articles':
                        isActive = currentPath.startsWith('/mark/articles');
                        break;
                    case 'users':
                        isActive = currentPath.startsWith('/mark/users');
                        break;
                    case 'categories':
                        isActive = currentPath.startsWith('/mark/categories');
                        break;
                    case 'tags':
                        isActive = currentPath.startsWith('/mark/tags');
                        break;
                }
                
                if (isActive) {
                    link.classList.add('active');
                }
            });
            
            // Load dashboard stats if we're on dashboard page
            if (currentPath === '/mark' || currentPath === '/mark/dashboard') {
                loadDashboardStats();
            }
            
            // Load tags if we're on tags page
            if (currentPath === '/mark/tags') {
                loadTags();
            }
        });
        
        // Load dashboard statistics from API
        async function loadDashboardStats() {
            try {
                const response = await fetch('/api/mark/dashboard/stats');
                const stats = await response.json();
                
                // Update stat values
                const statElements = document.querySelectorAll('.mark-stat-value');
                if (statElements.length >= 3) {
                    statElements[0].textContent = stats.totalArticles || 0;
                    statElements[1].textContent = stats.totalUsers || 0;
                    statElements[2].textContent = stats.publishedArticles || 0;
                }
                
                console.log('Dashboard stats loaded:', stats);
            } catch (error) {
                console.error('Failed to load dashboard stats:', error);
            }
        }
        
        // Load tags via API
        async function loadTags() {
            try {
                const response = await fetch('/api/mark/tags');
                const tags = await response.json();
                
                const tagsList = document.getElementById('tags-list');
                if (!tagsList) return;
                
                if (tags.length === 0) {
                    tagsList.innerHTML = `
                        <div style="text-align: center; padding: 2rem;">
                            <sl-icon name="tags" style="font-size: 3rem; color: var(--sl-color-neutral-500);"></sl-icon>
                            <h5 style="color: var(--sl-color-neutral-500); margin: 1rem 0;">No tags yet</h5>
                            <p style="color: var(--sl-color-neutral-500);">Create your first tag for better article organization.</p>
                        </div>
                    `;
                } else {
                    tagsList.innerHTML = tags.map(tag => `
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; border: 1px solid var(--mark-border); border-radius: 0.375rem; margin-bottom: 0.5rem;">
                            <div>
                                <sl-badge variant="primary" style="margin-right: 0.5rem;">${tag.name}</sl-badge>
                                <small style="color: var(--mark-text-muted); display: block; margin-top: 0.25rem;">
                                    ${new Date(tag.created_at).toLocaleString()}
                                </small>
                            </div>
                            <form method="post" action="/mark/tags/${tag.id}/delete" 
                                  style="display: inline-block;" 
                                  onsubmit="return confirm('Really delete tag "${tag.name}"?')">
                                <sl-button type="submit" variant="danger" size="small" title="Delete">
                                    <sl-icon name="trash"></sl-icon>
                                </sl-button>
                            </form>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Failed to load tags:', error);
                const tagsList = document.getElementById('tags-list');
                if (tagsList) {
                    tagsList.innerHTML = `
                        <sl-alert type="danger" open>
                            Failed to load tags. Please refresh the page.
                        </sl-alert>
                    `;
                }
            }
        }
        
        // Initialize Mark dashboard if components are available
        if (typeof customElements !== 'undefined' && !customElements.get('mark-dashboard')) {
            console.log('Mark dashboard components not loaded - using fallback mode');
        }
    </script>
</body>

</html>