// Mark Admin Panel Entry Point

// Import Layout Components
import './mark/components/mark-layout.ts';
import './mark/components/mark-sidebar.ts';
import './mark/components/mark-header.ts';
import './mark/components/mark-table.ts';
import './mark/components/mark-toast.ts';
import './mark/components/mark-chart.ts';
import './mark/components/mark-session-warning.ts';

// Import UI Components
import './mark/components/mark-card.ts';
import './mark/components/mark-stats-card.ts';
import './mark/components/mark-badge.ts';
import './mark/components/mark-button.ts';
import './mark/components/mark-input.ts';

// We can add global admin specific styles here if needed, but we currently use inline/view-specific styles or global.css
// For now, let components handle their own styles or rely on global defaults.
import './app.css'; // Reuse main app styles for consistency if needed, though we have many admin overrides
