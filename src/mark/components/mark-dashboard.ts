// resp-front/src/mark/components/mark-dashboard.ts
import { LitElement, html, css } from 'lit'
import { customElement, property, state } from 'lit/decorators.js'
import './mark-sidebar.js'
import './mark-stats-card.js'
import './mark-chart.js'
import './mark-table.js'

@customElement('mark-dashboard')
export class MarkDashboard extends LitElement {
  @property({ type: String }) activeMenu = 'dashboard'
  @property({ type: Object }) stats: any = {}
  @property({ type: Array }) recentLogs: any[] = []
  @property({ type: Array }) recentArticles: any[] = []
  @property({ type: Array }) recentUsers: any[] = []

  @state() private isLoading = true
  @state() private timeRange = 'today' // today, week, month, year
  @state() private chartType = 'bar' // bar, line, pie

  static styles = css`
    :host {
      display: block;
      min-height: 100vh;
      background: var(--sl-color-neutral-50);
      color: var(--sl-color-neutral-900);
    }

    .dashboard-container {
      display: grid;
      grid-template-columns: 250px 1fr;
      min-height: 100vh;
      transition: all 0.3s ease;
    }

    .dashboard-main {
      padding: var(--sl-spacing-large);
      overflow-y: auto;
      max-height: calc(100vh - var(--header-height, 60px));
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--sl-spacing-x-large);
      padding-bottom: var(--sl-spacing-medium);
      border-bottom: 1px solid var(--sl-color-neutral-200);
    }

    .dashboard-title {
      font-size: var(--sl-font-size-2x-large);
      font-weight: 600;
      color: var(--sl-color-neutral-900);
      margin: 0;
    }

    .dashboard-actions {
      display: flex;
      gap: var(--sl-spacing-small);
      align-items: center;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: var(--sl-spacing-large);
      margin-bottom: var(--sl-spacing-x-large);
    }

    .charts-container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: var(--sl-spacing-x-large);
      margin-bottom: var(--sl-spacing-x-large);
    }

    .recent-activity {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: var(--sl-spacing-x-large);
      margin-bottom: var(--sl-spacing-x-large);
    }

    .card {
      background: var(--sl-color-neutral-0);
      border-radius: var(--sl-border-radius-large);
      padding: var(--sl-spacing-large);
      box-shadow: var(--sl-shadow-medium);
      border: 1px solid var(--sl-color-neutral-200);
      transition: all 0.3s ease;
    }

    .card:hover {
      box-shadow: var(--sl-shadow-large);
      transform: translateY(-2px);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--sl-spacing-medium);
    }

    .card-title {
      font-size: var(--sl-font-size-large);
      font-weight: 600;
      color: var(--sl-color-neutral-900);
      margin: 0;
    }

    .card-actions {
      display: flex;
      gap: var(--sl-spacing-x-small);
    }

    .empty-state {
      text-align: center;
      padding: var(--sl-spacing-x-large);
      color: var(--sl-color-neutral-500);
    }

    .empty-state-icon {
      font-size: 3rem;
      margin-bottom: var(--sl-spacing-medium);
      opacity: 0.5;
    }

    .loading {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 400px;
    }

    .loading-spinner {
      width: 40px;
      height: 40px;
      border: 3px solid var(--sl-color-neutral-200);
      border-top-color: var(--sl-color-primary-600);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    @media (max-width: 1024px) {
      .dashboard-container {
        grid-template-columns: 1fr;
      }

      .charts-container {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }

      .recent-activity {
        grid-template-columns: 1fr;
      }
    }
  `

  connectedCallback() {
    super.connectedCallback()
    this.loadDashboardData()
  }

  async loadDashboardData() {
    this.isLoading = true

    try {
      // Load stats
      const statsResponse = await fetch('/api/mark/dashboard/stats')
      this.stats = await statsResponse.json()

      // Load recent logs
      const logsResponse = await fetch('/api/mark/audit-logs/recent')
      this.recentLogs = await logsResponse.json()

      // Load recent articles
      const articlesResponse = await fetch('/api/mark/articles/recent')
      this.recentArticles = await articlesResponse.json()

      // Load recent users
      const usersResponse = await fetch('/api/mark/users/recent')
      this.recentUsers = await usersResponse.json()
    } catch (error) {
      console.error('Failed to load dashboard data:', error)
      this.showToast('Error loading dashboard data', 'danger')
    } finally {
      this.isLoading = false
    }
  }

  private showToast(message: string, variant: 'success' | 'danger' | 'warning' = 'success') {
    const event = new CustomEvent('mark-toast', {
      detail: { message, variant },
      bubbles: true,
      composed: true,
    })
    this.dispatchEvent(event)
  }

  private formatNumber(num: number): string {
    return new Intl.NumberFormat().format(num)
  }

  private getEventColor(eventType: string): string {
    const colors: Record<string, string> = {
      login: 'success',
      logout: 'neutral',
      article: 'primary',
      user: 'warning',
      image: 'purple',
      system: 'danger',
    }

    for (const [key, color] of Object.entries(colors)) {
      if (eventType.includes(key)) return color
    }
    return 'neutral'
  }

  render() {
    if (this.isLoading) {
      return html`
        <div class="dashboard-container">
          <mark-sidebar .activeMenu=${this.activeMenu}></mark-sidebar>
          <div class="dashboard-main">
            <div class="loading">
              <div class="loading-spinner"></div>
            </div>
          </div>
        </div>
      `
    }

    return html`
      <div class="dashboard-container">
        <mark-sidebar .activeMenu=${this.activeMenu}></mark-sidebar>

        <main class="dashboard-main">
          <header class="dashboard-header">
            <h1 class="dashboard-title">Dashboard Overview</h1>
            <div class="dashboard-actions">
              <sl-select
                size="small"
                value=${this.timeRange}
                @sl-change=${(e: any) => (this.timeRange = e.target.value)}
              >
                <sl-option value="today">Today</sl-option>
                <sl-option value="week">This Week</sl-option>
                <sl-option value="month">This Month</sl-option>
                <sl-option value="year">This Year</sl-option>
              </sl-select>

              <sl-button size="small" variant="neutral" @click=${this.loadDashboardData}>
                <sl-icon name="arrow-clockwise"></sl-icon> Refresh
              </sl-button>
            </div>
          </header>

          <!-- Statistics Grid -->
          <section class="stats-grid">
            <mark-stats-card
              title="Total Articles"
              value=${this.formatNumber(this.stats.totalArticles || 0)}
              icon="newspaper"
              trend=${this.stats.articlesTrend || 0}
              color="primary"
            ></mark-stats-card>

            <mark-stats-card
              title="Total Users"
              value=${this.formatNumber(this.stats.totalUsers || 0)}
              icon="people"
              trend=${this.stats.usersTrend || 0}
              color="success"
            ></mark-stats-card>

            <mark-stats-card
              title="Today's Activity"
              value=${this.formatNumber(this.stats.todayActivity || 0)}
              icon="activity"
              trend=${this.stats.activityTrend || 0}
              color="warning"
            ></mark-stats-card>

            <mark-stats-card
              title="Storage Used"
              value="${((this.stats.storageUsed || 0) / 1024).toFixed(1)} GB"
              icon="hdd"
              trend=${this.stats.storageTrend || 0}
              color="danger"
              subtitle="of ${this.stats.storageTotal || 10} GB total"
            ></mark-stats-card>
          </section>

          <!-- Charts Section -->
          <section class="charts-container">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Activity Overview</h3>
                <div class="card-actions">
                  <sl-button-group>
                    <sl-button
                      size="small"
                      ?outline=${this.chartType !== 'bar'}
                      @click=${() => (this.chartType = 'bar')}
                    >
                      Bar
                    </sl-button>
                    <sl-button
                      size="small"
                      ?outline=${this.chartType !== 'line'}
                      @click=${() => (this.chartType = 'line')}
                    >
                      Line
                    </sl-button>
                  </sl-button-group>
                </div>
              </div>
              <mark-chart
                type=${this.chartType}
                .data=${this.stats.chartData || {}}
                height="300"
              ></mark-chart>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Event Distribution</h3>
              </div>
              <mark-chart
                type="pie"
                .data=${this.stats.eventDistribution || {}}
                height="300"
              ></mark-chart>
            </div>
          </section>

          <!-- Recent Activity Section -->
          <section class="recent-activity">
            <!-- Recent Audit Logs -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Recent Activity</h3>
                <sl-button size="small" variant="text" href="/mark/audit-logs">
                  View All
                </sl-button>
              </div>

              ${this.recentLogs.length > 0
                ? html`
                    <mark-table
                      .data=${this.recentLogs}
                      .columns=${[
                        { key: 'event', header: 'Event', width: '40%' },
                        { key: 'user', header: 'User', width: '30%' },
                        { key: 'time', header: 'Time', width: '30%' },
                      ]}
                      .renderRow=${(log: any) => html`
                        <div style="display: flex; align-items: center; gap: 8px;">
                          <sl-badge variant=${this.getEventColor(log.eventType)} pill>
                            <sl-icon name=${this.getEventIcon(log.eventType)}></sl-icon>
                          </sl-badge>
                          <div>
                            <div style="font-weight: 500;">${log.description}</div>
                            <small style="color: var(--sl-color-neutral-500);"
                              >${log.eventType}</small
                            >
                          </div>
                        </div>
                      `}
                    ></mark-table>
                  `
                : html`
                    <div class="empty-state">
                      <div class="empty-state-icon">
                        <sl-icon name="clipboard"></sl-icon>
                      </div>
                      <p>No recent activity</p>
                    </div>
                  `}
            </div>

            <!-- Recent Articles -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Recent Articles</h3>
                <sl-button size="small" variant="text" href="/mark/articles"> View All </sl-button>
              </div>

              ${this.recentArticles.length > 0
                ? html`
                    <mark-table
                      .data=${this.recentArticles}
                      .columns=${[
                        { key: 'article', header: 'Article', width: '60%' },
                        { key: 'status', header: 'Status', width: '40%' },
                      ]}
                      .renderRow=${(article: any) => html`
                        <div>
                          <div style="font-weight: 500; margin-bottom: 4px;">${article.title}</div>
                          <small style="color: var(--sl-color-neutral-500);">
                            ${article.excerpt.substring(0, 60)}...
                          </small>
                        </div>
                      `}
                    ></mark-table>
                  `
                : html`
                    <div class="empty-state">
                      <div class="empty-state-icon">
                        <sl-icon name="file-text"></sl-icon>
                      </div>
                      <p>No articles yet</p>
                    </div>
                  `}
            </div>
          </section>
        </main>
      </div>

      <!-- Toast Container -->
      <mark-toast></mark-toast>
    `
  }

  private getEventIcon(eventType: string): string {
    const icons: Record<string, string> = {
      login: 'box-arrow-in-right',
      logout: 'box-arrow-right',
      article: 'file-text',
      user: 'person',
      image: 'image',
      system: 'gear',
    }

    for (const [key, icon] of Object.entries(icons)) {
      if (eventType.includes(key)) return icon
    }
    return 'info-circle'
  }
}

declare global {
  interface HTMLElementTagNameMap {
    'mark-dashboard': MarkDashboard
  }
}
