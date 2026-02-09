// resp-front/src/mark.ts

import './styles/mark.css'
import './mark/components/mark-layout'
import './mark/components/mark-dashboard'
import './mark/components/mark-sidebar'
import './mark/components/mark-stats-card'
import './mark/components/mark-chart'
import './mark/components/mark-table'
import './mark/components/mark-toast'
import './mark/components/mark-badge'
import './mark/components/mark-button'
import './mark/components/mark-card'
import './mark/components/mark-header'
import './mark/components/mark-input'
import './mark/components/mark-session-warning'

// Shoelace components - use proper imports
import '@shoelace-style/shoelace/dist/components/button/button.js'
import '@shoelace-style/shoelace/dist/components/icon/icon.js'
import '@shoelace-style/shoelace/dist/components/card/card.js'
import '@shoelace-style/shoelace/dist/components/select/select.js'
import '@shoelace-style/shoelace/dist/components/option/option.js'
import '@shoelace-style/shoelace/dist/components/badge/badge.js'
import '@shoelace-style/shoelace/dist/components/spinner/spinner.js'
import '@shoelace-style/shoelace/dist/components/button-group/button-group.js'
import '@shoelace-style/shoelace/dist/components/input/input.js'

// Initialize theme
document.addEventListener('DOMContentLoaded', () => {
  // Set dark theme by default
  document.documentElement.setAttribute('data-theme', 'dark')

  // Apply mark theme class
  document.body.classList.add('mark-theme-dark')

  // Set up base path for Shoelace assets
  import('@shoelace-style/shoelace').then(({ setBasePath }) => {
    setBasePath('/node_modules/@shoelace-style/shoelace/dist')
  })

  console.log('Mark dashboard initialized')
})
