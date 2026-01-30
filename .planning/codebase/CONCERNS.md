# Codebase Concerns

**Analysis Date:** 2026-01-30

## Tech Debt

**TypeScript Migration Incomplete:**
- Issue: Source files migrated to TypeScript but imports still use `.js` extensions everywhere
- Files: `src/application/use-cases/CreateArticle.ts`, `src/infrastructure/api/ArticleApiClient.ts`, `src/domain/entities/Article.ts`, and ~35 other files
- Impact: Confusing for developers (importing `.js` in `.ts` files), relies on bundler to resolve correctly
- Fix approach: Either update tsconfig to use `"moduleResolution": "node"` and remove `.js` extensions, or document that this is intentional for ESM compatibility

**Test Suite Broken After Migration:**
- Issue: All 6 test files fail with "Failed to resolve import" errors looking for `.js` files when source is `.ts`
- Files: `tests/app.test.js`, `tests/domain/entities/Article.test.js`, `tests/application/use-cases/CreateArticle.test.js`, all test files in `tests/` directory
- Impact: No test coverage validation possible, can't verify code changes don't break functionality
- Fix approach: Update test imports to use `.ts` extensions or configure vitest to handle TypeScript module resolution properly

**ESLint Configuration Outdated:**
- Issue: `.eslintrc.cjs` exists but ESLint 9 expects `eslint.config.js` format, lint command fails entirely
- Files: `.eslintrc.cjs`
- Impact: Cannot run linting, no code quality checks in CI/CD
- Fix approach: Migrate to flat config format following ESLint 9 migration guide or downgrade ESLint to v8

**Loose Type Safety from `any` Usage:**
- Issue: Multiple uses of `any` type defeats TypeScript benefits
- Files: `src/infrastructure/di/container.ts` (lines 1, 14), `src/app.ts` (lines 24, 46), `src/test-app.ts` (lines 44, 51), `src/components/sections/article-list-section.ts` (line 8), `src/layout/docs.ts` (line 214)
- Impact: No type checking in critical areas (DI container, lazy loading, article lists), bugs can slip through
- Fix approach: Define proper interfaces for lazy load maps, use typed generics in Container, create IArticle interface for article-list-section

**Mixed PHP and TypeScript Codebase:**
- Issue: Frontend repo contains PHP view templates alongside TypeScript components
- Files: `article/create.php`, `app/home.php`, `modules/blog/*.php`, `layout/master.php`, etc.
- Impact: Unclear separation of concerns, confusing project structure, TypeScript tools ignore PHP files
- Fix approach: Move PHP templates to separate backend directory or document hybrid architecture clearly

**Backup Files Left in Codebase:**
- Issue: Migration backup file committed to repository
- Files: `vite.config.js.bckp`
- Impact: Clutters repository, suggests incomplete cleanup
- Fix approach: Remove backup file and add `*.bckp` to `.gitignore`

## Known Bugs

**Article Card Missing Type Property:**
- Symptoms: Article card tries to render `article.status` and `article.created_at` but IArticle interface only defines `publishedAt`
- Files: `src/components/ui/article-card.ts` (lines 38, 42), `src/types/index.ts` (IArticle interface)
- Trigger: Render any article card component with real API data
- Workaround: Backend must return `status` and `created_at` fields but they're not typed

**Test App Uses Unsafe Type Assertions:**
- Symptoms: Forces type casting with `as any` to set private properties
- Files: `src/test-app.ts` (lines 44, 51)
- Trigger: Run test-app.ts
- Workaround: Direct property assignment with type suppression, defeats encapsulation

## Security Considerations

**Hardcoded Author ID in Form:**
- Risk: PHP form template has hardcoded `author_id=1` with TODO comment
- Files: `article/create.php` (line 31)
- Current mitigation: None
- Recommendations: Implement session-based authentication and retrieve author from session

**No CORS Configuration in Build:**
- Risk: Build config outputs to different directory path (`../blog/public/build/assets`) suggesting cross-origin concerns
- Files: `vite.config.ts` (line 8)
- Current mitigation: CORS settings commented out in vite.config
- Recommendations: Enable and configure CORS properly if assets served from different origin

**Production Console Logs:**
- Risk: Sensitive debugging information logged in production builds
- Files: `src/infrastructure/api/ArticleApiClient.ts` (lines 26, 46, console.error on 29, 49, 73), `src/app.ts` (line 83), `src/test-app.ts` (multiple console.log statements)
- Current mitigation: None, all console statements active in production
- Recommendations: Use proper logging library with environment-based levels, remove sensitive logs from production builds

## Performance Bottlenecks

**Lazy Loading Observer Never Cleans Up:**
- Problem: IntersectionObserver created but never disconnected on page navigation
- Files: `src/app.ts` (lines 74-111)
- Cause: Observer is module-level, no lifecycle management for SPA navigation
- Improvement path: Wrap in cleanup function or use WeakMap to track observed elements

**Mermaid Loaded Multiple Times:**
- Problem: `loadMermaid` function checks flag but multiple observers might trigger simultaneous imports
- Files: `src/app.ts` (lines 22-42, called from line 102)
- Cause: Race condition between multiple mermaid elements entering viewport
- Improvement path: Use Promise.race() or single shared promise to prevent parallel imports

**Large Section Components Not Code-Split:**
- Problem: Large components like right-choice-section (529 lines) and nativeness-section (444 lines) loaded as chunks
- Files: `src/components/sections/right-choice-section.ts`, `src/components/sections/nativeness-section.ts`
- Cause: All section content inline in render methods
- Improvement path: Split content into separate template files or further break down into subcomponents

## Fragile Areas

**Docs Layout Scroll Handler:**
- Files: `src/layout/docs.ts` (lines 245-264)
- Why fragile: Manual DOM manipulation with heading tag slicing, array reversal logic, magic number (120px offset)
- Safe modification: Test thoroughly with different heading structures, consider using Intersection Observer instead of scroll events
- Test coverage: No tests for navigation highlighting logic

**Type Casting in Docs Heading Parser:**
- Files: `src/layout/docs.ts` (line 214)
- Why fragile: `(heading.tagName.slice(1) as any) | 0` - string to number coercion with type suppression
- Safe modification: Replace with proper parseInt() or explicit type guard
- Test coverage: Untested edge cases (non-h2/h3 elements, malformed HTML)

**DI Container Has No Type Safety:**
- Files: `src/infrastructure/di/container.ts`
- Why fragile: Generic `get<T = any>()` doesn't verify returned type matches T, factory functions untyped
- Safe modification: Add service registry with typed service keys, validate factory return types
- Test coverage: Tests exist but fail to run due to module resolution

## Scaling Limits

**In-Memory DI Container:**
- Current capacity: Services stored in Map, recreated on every get() call
- Limit: No singleton support, no lifecycle management, no dependency graph validation
- Scaling path: Replace with proper DI framework (tsyringe, inversify) or add singleton/transient lifecycle options

**No Pagination for Articles:**
- Current capacity: ArticleApiClient fetches all articles at once
- Limit: Will break with 100+ articles (memory, render time)
- Scaling path: Add pagination to `fetchArticles()`, implement virtual scrolling in article-list-section

## Dependencies at Risk

**Lit Listed in Both dependencies and devDependencies:**
- Risk: package.json has `lit: ^3.3.2` in both sections (lines 22, 30)
- Impact: Confusing dependency management, could cause version conflicts
- Migration plan: Remove from devDependencies, only keep in dependencies

**Vite Version Mismatch:**
- Risk: Two different Vite versions in node_modules (`vite@5.4.21` and `vite@7.3.1`), package.json specifies 7.3.1
- Impact: Test config using older Vite (vitest config references old version)
- Migration plan: Update vitest to compatible version with Vite 7.3.1

**Vitest Outdated:**
- Risk: Using vitest 0.34.6, current is 2.x+, missing features and bug fixes
- Impact: Test runner may have unfixed issues, can't use newer testing features
- Migration plan: Upgrade vitest to latest stable (verify Lit component testing compatibility)

## Missing Critical Features

**No Error Boundary:**
- Problem: Lit components have no top-level error catching
- Blocks: Production errors crash entire app silently
- Priority: High - add error boundary wrapper in app.ts

**No Loading States:**
- Problem: Components immediately render empty or undefined data
- Blocks: Poor UX during API calls, no skeleton screens
- Priority: Medium - add loading property to article-list-section

**No Authentication Layer:**
- Problem: API client has no token management, commented TODO in PHP form
- Blocks: Can't secure admin features or user-specific content
- Priority: High - implement auth before production deployment

**No Input Validation in Components:**
- Problem: Article card and list section assume data shape without validation
- Blocks: Runtime errors if API contract changes
- Priority: Medium - add Zod or similar for runtime type validation

## Test Coverage Gaps

**Component Tests Are Placeholders:**
- What's not tested: All component tests just check module is defined
- Files: `tests/components/ui/article-card.test.js`, `tests/components/sections/article-list-section.test.js`, `tests/domain/entities/Article.test.js`
- Risk: No verification of render logic, event handling, or Lit lifecycle
- Priority: High

**API Client Not Tested:**
- What's not tested: Fetch error handling, response parsing, network failures
- Files: `src/infrastructure/api/ArticleApiClient.ts` (no corresponding test file)
- Risk: API changes break application silently
- Priority: High

**Lazy Loading Logic Untested:**
- What's not tested: Intersection Observer setup, component loading, race conditions
- Files: `src/app.ts` (observer logic lines 74-133)
- Risk: Performance optimizations may break without notice
- Priority: Medium

**Domain Logic Partially Tested:**
- What's not tested: Article validation rules (empty title, max length checks in ArticleTitle)
- Files: `src/domain/entities/Article.ts`, `src/domain/value-objects/ArticleTitle.ts`
- Risk: Business rules can change without test failures catching regressions
- Priority: High - domain layer should have highest coverage

**No E2E Tests:**
- What's not tested: Full user flows, PHP/TypeScript integration, actual DOM rendering
- Files: No E2E test directory or config
- Risk: Integration points between frontend and backend untested
- Priority: Medium - add Playwright or Cypress for critical paths

---

*Concerns audit: 2026-01-30*
