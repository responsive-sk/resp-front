# Codebase Structure

**Analysis Date:** 2026-01-30

## Directory Layout

```
resp-front/
├── src/                  # TypeScript source code (Clean Architecture)
│   ├── app.ts           # Main entry point
│   ├── app.css          # Critical global styles
│   ├── test-app.ts      # Development test entry
│   ├── domain/          # Business logic (entities, value objects)
│   ├── application/     # Use cases
│   ├── infrastructure/  # External services (API, DB, DI)
│   ├── components/      # Lit Web Components
│   ├── layout/          # Page layouts
│   ├── styles/          # CSS modules
│   ├── types/           # TypeScript type definitions
│   └── utils/           # Shared utilities
├── tests/               # Test suite mirroring src/
├── public/              # Static assets and build output
├── modules/             # PHP backend modules (blog, docs, search)
├── app/                 # PHP page controllers
├── auth/                # PHP authentication
├── layout/              # PHP master layout
├── partials/            # PHP partial templates
├── mark/                # Markdown content
├── node_modules/        # Dependencies
├── .planning/           # GSD planning documents
├── index.html           # HTML entry point
├── vite.config.ts       # Vite build configuration
├── tsconfig.json        # TypeScript configuration
└── package.json         # Dependencies and scripts
```

## Directory Purposes

**src/**
- Purpose: All TypeScript application code following Clean Architecture
- Contains: Domain, application, infrastructure, UI layers
- Key files: `app.ts` (entry), `test-app.ts` (dev entry), `app.css` (global styles)

**src/domain/**
- Purpose: Core business entities and value objects
- Contains: Pure TypeScript classes with no framework dependencies
- Key files: `entities/Article.ts`, `value-objects/ArticleTitle.ts`
- Subdirectories: `entities/`, `value-objects/`, `repositories/` (interfaces only)

**src/application/**
- Purpose: Application use cases orchestrating business logic
- Contains: Use case implementations
- Key files: `use-cases/CreateArticle.ts`
- Subdirectories: `use-cases/`

**src/infrastructure/**
- Purpose: External service integrations and implementations
- Contains: API clients, database adapters, DI container
- Key files: `api/ArticleApiClient.ts`, `di/container.ts`, `db/sqlite.db`
- Subdirectories: `api/`, `di/`, `db/`, `repositories/`

**src/components/**
- Purpose: Reusable Lit Web Components
- Contains: UI elements and section components
- Key files: `ui/button.ts`, `ui/header.ts`, `sections/hero-section.ts`
- Subdirectories: `ui/` (atomic components), `sections/` (composite sections)

**src/layout/**
- Purpose: Page-level layout components
- Contains: Layout wrappers for different page types
- Key files: `landing.ts`, `blog.ts`, `default.ts`, `docs.ts`, `search.ts`

**src/styles/**
- Purpose: Global CSS modules
- Contains: Typography, fonts, layout, API styles
- Key files: `typography.css`, `fonts.css`, `layout.css`, `api-blog.css`

**src/types/**
- Purpose: Shared TypeScript type definitions
- Contains: Interfaces for domain models and API responses
- Key files: `index.ts`

**src/utils/**
- Purpose: Shared utility functions and styles
- Contains: Helper functions, shared Lit styles
- Key files: `sharedStyles.ts`

**tests/**
- Purpose: Test suite organized by layer
- Contains: Unit tests mirroring src structure
- Subdirectories: `domain/`, `application/`, `infrastructure/`, `components/`

**public/**
- Purpose: Static assets and build output
- Contains: Images, fonts, styles, compiled JS
- Subdirectories: `build/`, `styles/`

**modules/**
- Purpose: PHP backend module implementations
- Contains: Blog, docs, search modules with PHP logic
- Subdirectories: `blog/`, `docs/`, `search/`

**app/**
- Purpose: PHP page controllers
- Contains: Page-level PHP files
- Key files: `home.php`, `about.php`, `contact.php`

**auth/**
- Purpose: Authentication logic
- Contains: Login and registration PHP files
- Key files: `login.php`, `register.php`

**layout/**
- Purpose: PHP master layout template
- Contains: HTML structure wrapper
- Key files: `master.php`

**partials/**
- Purpose: Reusable PHP template fragments
- Contains: Shared HTML/PHP snippets

**mark/**
- Purpose: Markdown content storage
- Contains: Articles and documentation in markdown
- Subdirectories: `articles/`

**.planning/**
- Purpose: GSD command planning documents
- Contains: Codebase analysis, project plans
- Subdirectories: `codebase/`

## Key File Locations

**Entry Points:**
- `index.html`: HTML document root
- `src/app.ts`: Main JavaScript entry (production + dev)
- `src/test-app.ts`: Development test harness

**Configuration:**
- `vite.config.ts`: Build tool configuration
- `tsconfig.json`: TypeScript compiler settings
- `package.json`: Dependencies and scripts
- `.eslintrc.cjs`: Linting rules
- `.prettierrc.cjs`: Code formatting rules
- `postcss.config.js`: CSS processing
- `vitest.config.js`: Test runner configuration

**Core Logic:**
- `src/domain/entities/Article.ts`: Article domain model
- `src/application/use-cases/CreateArticle.ts`: Article creation use case
- `src/infrastructure/api/ArticleApiClient.ts`: Backend API client

**Testing:**
- `tests.sh`: Custom test runner script
- `test.vite.config.js`: Vite test configuration
- `tests/domain/entities/`: Domain entity tests
- `tests/components/`: Component tests

## Naming Conventions

**Files:**
- Components: `kebab-case.ts` (e.g., `hero-section.ts`, `mobile-header-menu.ts`)
- Domain/Application: `PascalCase.ts` (e.g., `Article.ts`, `CreateArticle.ts`)
- Utilities: `camelCase.ts` (e.g., `sharedStyles.ts`)
- Layouts: `kebab-case.ts` (e.g., `landing.ts`, `blog.ts`)
- CSS: `kebab-case.css` (e.g., `typography.css`, `api-blog.css`)

**Directories:**
- lowercase with hyphens: `value-objects/`, `use-cases/`
- no hyphens for short names: `domain/`, `components/`, `layout/`

**Custom Elements:**
- Format: `prefix-name` (e.g., `boson-button`, `hero-section`)
- Prefixes: `boson-` for UI library components, no prefix for sections

**Classes:**
- PascalCase: `Article`, `CreateArticle`, `Button`, `HeroSection`

## Where to Add New Code

**New Feature:**
- Primary code: `src/application/use-cases/FeatureName.ts`
- Domain entity: `src/domain/entities/EntityName.ts`
- API client: `src/infrastructure/api/EntityApiClient.ts`
- Tests: `tests/application/use-cases/`, `tests/domain/entities/`

**New Component:**
- UI component: `src/components/ui/component-name.ts`
- Section component: `src/components/sections/section-name.ts`
- Tests: `tests/components/ui/` or `tests/components/sections/`
- Import in `src/app.ts` (eager or lazy load map)

**New Layout:**
- Implementation: `src/layout/layout-name.ts`
- Import in `src/app.ts` to register

**New Page (PHP):**
- Controller: `app/page-name.php`
- Module: `modules/module-name/` (if complex)

**Utilities:**
- Shared helpers: `src/utils/helperName.ts`
- Shared styles: Import in `src/utils/sharedStyles.ts`

**New Value Object:**
- Implementation: `src/domain/value-objects/ValueName.ts`
- Tests: `tests/domain/value-objects/`

**New Repository Implementation:**
- Interface: `src/domain/repositories/EntityRepository.ts` (if needed)
- Implementation: `src/infrastructure/repositories/EntityRepositoryImpl.ts`

## Special Directories

**node_modules/**
- Purpose: NPM package dependencies
- Generated: Yes (via `pnpm install`)
- Committed: No

**public/build/**
- Purpose: Compiled JavaScript and CSS output
- Generated: Yes (via `vite build`)
- Committed: No (typically)

**src/infrastructure/db/**
- Purpose: SQLite database file
- Generated: Yes (at runtime)
- Committed: No (`.gitignore`)

**.planning/**
- Purpose: GSD planning artifacts
- Generated: Yes (by GSD commands)
- Committed: Yes

## Import Patterns

**Path Aliases:**
- `@/*` maps to `src/*` (configured in `tsconfig.json` and `vite.config.ts`)
- Example: `import { sharedStyles } from '@/utils/sharedStyles.js'`

**Relative Imports:**
- Same layer: `./sibling.ts`
- Parent layer: `../../domain/entities/Article.ts`
- Always include `.js` extension for ESM compatibility

**Lazy Loading:**
- Dynamic: `await import('./components/sections/section-name.ts')`
- Registered in `lazyLoadSections` or `lazyLoadUI` maps in `src/app.ts`

**CSS Imports:**
- Inline CSS: `import typography from '../styles/typography.css?inline'`
- Direct import: `import './app.css'`

## Component Registration Strategy

**Eager Loading (Critical Path):**
- Core UI: `button.ts`, `header.ts`, `footer.ts`, `logo.ts`, `search-input.ts`
- Above-fold sections: `hero-section.ts`, `segment-section.ts`
- Layouts: `landing.ts`, `default.ts`, `blog.ts`, `search.ts`

**Lazy Loading (Intersection Observer):**
- Sections: `article-list-section.ts`, `call-to-action-section.ts`, `how-it-works-section.ts`, `mobile-development-section.ts`, `right-choice-section.ts`
- UI components: `dropdown.ts`, `breadcrumbs.ts`, `mobile-header-menu.ts`, `dots-container.ts`, `horizontal-accordion.ts`, `subtitle.ts`, `page-title.ts`
- External libraries: Mermaid (when `.mermaid` elements detected)

---

*Structure analysis: 2026-01-30*
