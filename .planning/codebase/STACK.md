# Technology Stack

**Analysis Date:** 2026-01-30

## Languages

**Primary:**
- TypeScript 5.9.3 - All source code in `src/` directory
- CSS - Styling (custom CSS, no frameworks)

**Secondary:**
- JavaScript - Configuration files (`vite.config.ts`, `vitest.config.js`, `postcss.config.js`)

## Runtime

**Environment:**
- Node.js v25.4.0

**Package Manager:**
- pnpm 10.28.0
- Lockfile: `pnpm-lock.yaml` (lockfileVersion 9.0)

## Frameworks

**Core:**
- Lit 3.3.2 - Web Components framework for UI
- Vite 7.3.1 - Build tool and dev server

**Testing:**
- Vitest 0.34.6 - Test runner
- jsdom 27.4.0 - Browser environment simulation
- @testing-library/jest-dom 6.9.1 - DOM matchers

**Build/Dev:**
- esbuild - Minification (via Vite)
- TypeScript 5.9.3 - Type checking and compilation
- PostCSS - CSS processing (minimal config)

## Key Dependencies

**Critical:**
- Lit 3.3.2 - Core framework for all web components
- Vite 7.3.1 - Build system and hot module reloading

**Infrastructure:**
- Mermaid 11.12.2 - Diagram rendering (lazy loaded)
- Native Fetch API - HTTP requests (no axios/superagent)

## Configuration

**Environment:**
- Configured via `.env` files
- Variables prefixed with `VITE_` are exposed to client
- Key vars:
  - `VITE_API_URL` - Backend API endpoint
  - `VITE_APP_ENV` - Environment (development/test/production)
  - `VITE_FEATURE_FLAG_X` - Feature flags
- Example: `.env.example`

**Build:**
- `vite.config.ts` - Build configuration
  - Entry: `src/app.ts`
  - Output: `../blog/public/build/assets/`
  - Alias: `@` → `src`
- `tsconfig.json` - TypeScript configuration
  - Target: ES2020
  - Module: ESNext
  - Strict mode enabled
  - Experimental decorators enabled (for Lit @customElement)
  - Path alias: `@/*` → `./src/*`
- `vitest.config.js` - Test configuration
  - Environment: jsdom
  - Globals enabled
  - Alias: `@` → `src`

**Code Quality:**
- ESLint 9.39.2 (`.eslintrc.cjs`)
  - @typescript-eslint parser and plugin
  - Prettier integration
- Prettier 3.8.1 (`.prettierrc.cjs`)
  - No semicolons
  - Single quotes
  - Print width: 100

## Platform Requirements

**Development:**
- Node.js v25+ (current: v25.4.0)
- pnpm 10+ (current: 10.28.0)
- Modern browser with Web Components support

**Production:**
- Static file hosting
- Build output in `../blog/public/build/assets/`
- ES modules support required
- Deployment target not specified in config

## Build Characteristics

**Module System:**
- ES Modules (type: "module" in package.json)
- Dynamic imports for lazy loading components
- Native browser module loading

**TypeScript Configuration:**
- `experimentalDecorators: true` - Required for Lit decorators
- `useDefineForClassFields: false` - Compatibility with Lit
- Module resolution: bundler
- Allows JS alongside TS during migration

**Bundling Strategy:**
- Entry: `src/app.ts`
- Code splitting: chunks with hash names
- Asset naming: `[name]-[hash].[ext]`
- CSS: `app.css` (no hash)
- Minification: esbuild
- Sourcemaps: disabled

---

*Stack analysis: 2026-01-30*
