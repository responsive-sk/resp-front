# External Integrations

**Analysis Date:** 2026-01-30

## APIs & External Services

**Backend API:**
- Custom REST API - Article management system
  - Default URL: `http://localhost:8000/api`
  - Client: Native Fetch API
  - Implementation: `src/infrastructure/api/ArticleApiClient.ts`
  - Endpoints:
    - `GET /articles` - Fetch all articles
    - `GET /articles/:id` - Fetch single article
    - `POST /articles` - Create article
  - Auth: `VITE_API_URL` environment variable
  - No SDK - direct fetch() calls

**Diagram Rendering:**
- Mermaid 11.12.2 - Render diagrams in markdown
  - Lazy loaded via dynamic import when `.mermaid` elements detected
  - Theme: dark with custom colors
  - Initialized in `src/app.ts`

## Data Storage

**Databases:**
- None (frontend only)
  - Backend connection string referenced in `.env.example`: `DB_PATH=src/infrastructure/db/sqlite.db`
  - Backend uses SQLite (not accessed directly by frontend)

**File Storage:**
- Local filesystem only
  - Build assets: `../blog/public/build/assets/`
  - Public assets: `public/`

**Caching:**
- None (browser-native caching only)

## Authentication & Identity

**Auth Provider:**
- Custom (in development)
  - ArticleApiClient supports authenticated POST requests
  - No auth headers implemented yet
  - TODO: Authentication layer

## Monitoring & Observability

**Error Tracking:**
- None (console.error only)

**Logs:**
- Console logging in development
  - `console.log()` for success messages
  - `console.error()` for errors
  - Example: `src/infrastructure/api/ArticleApiClient.ts` logs fetch results

## CI/CD & Deployment

**Hosting:**
- Not configured
  - Build output targets: `../blog/public/build/assets/`
  - Suggests static site deployment

**CI Pipeline:**
- None detected
  - GitHub directory exists (`.github/`) but no workflows found

## Environment Configuration

**Required env vars:**
- `VITE_API_URL` - Backend API endpoint (default: `http://localhost:8000/api`)
- `VITE_APP_ENV` - Application environment (development/test/production)

**Optional env vars:**
- `VITE_FEATURE_FLAG_X` - Feature flags
- `DB_PATH` - Referenced but not used by frontend

**Secrets location:**
- `.env` file (gitignored)
- `.env.example` provides template

## Webhooks & Callbacks

**Incoming:**
- None

**Outgoing:**
- None

## External Resources

**CDN/External Assets:**
- External link icon: `https://intellij-icons.jetbrains.design/icons/AllIcons/expui/ide/externalLink_dark.svg`
  - Used in `src/styles/typography.css`

**Fonts:**
- Not detected (likely system fonts or bundled)

## Development Tools

**Browser DevTools Integration:**
- Lit DevTools support (Web Components)
- Source maps disabled in production build

## HTTP Client Details

**Implementation:**
- Native Fetch API (no external HTTP library)
- Error handling: try/catch with console.error
- Response validation: checks `response.ok`
- Content-Type: `application/json`
- No retry logic
- No request/response interceptors

**Location:**
- `src/infrastructure/api/ArticleApiClient.ts`

**Configuration:**
- Base URL configurable via constructor
- Defaults to `http://localhost:8000/api`
- Can be overridden with `VITE_API_URL`

## Build-time Integrations

**Vite Plugins:**
- None detected (vanilla Vite config)

**CSS Processing:**
- PostCSS - Minimal configuration
  - Config: `postcss.config.js`
  - No Tailwind or other plugins

**TypeScript:**
- Built-in via Vite
- No separate tsc build step
- Type checking on demand via `tsc --noEmit`

---

*Integration audit: 2026-01-30*
