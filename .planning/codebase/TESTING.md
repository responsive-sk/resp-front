# Testing Patterns

**Analysis Date:** 2026-01-30

## Test Framework

**Runner:**
- Vitest 0.34.6
- Config: `vitest.config.js`

**Assertion Library:**
- Vitest (built-in, Chai-compatible API)
- `@testing-library/jest-dom` 6.9.1 for DOM matchers

**Run Commands:**
```bash
pnpm test              # Run all tests
pnpm test -- --watch   # Watch mode (vitest watch not explicitly configured)
# No coverage command configured
```

## Test File Organization

**Location:**
- Parallel directory structure: Tests mirror source structure
- Root: `tests/` directory
- Example: `src/domain/entities/Article.ts` → `tests/domain/entities/Article.test.js`

**Naming:**
- Pattern: `{FileName}.test.js`
- Examples:
  - `Article.test.js`
  - `article-card.test.js`
  - `CreateArticle.test.js`
  - `container.test.js`
  - `app.test.js`

**Structure:**
```
tests/
├── application/
│   └── use-cases/
│       └── CreateArticle.test.js
├── components/
│   ├── sections/
│   │   └── article-list-section.test.js
│   └── ui/
│       └── article-card.test.js
├── domain/
│   └── entities/
│       └── Article.test.js
├── infrastructure/
│   └── di/
│       └── container.test.js
└── app.test.js
```

## Test Structure

**Suite Organization:**
```typescript
import { describe, it, expect } from 'vitest';
import * as moduleUnderTest from '@/domain/entities/Article.js';

describe('domain/entities/Article.js', () => {
  it('should have placeholder test', () => {
    expect(moduleUnderTest).toBeDefined();
  });
});
```

**Patterns:**
- Use `describe()` for test suites with module path as description
- Use `it()` for individual test cases with descriptive names
- Import entire module for structural tests: `import * as moduleUnderTest from '...'`
- Use `@/` path alias for imports (matches src structure)
- Always use `.js` extension in imports, even when testing `.ts` files

**Current State:**
- All tests are placeholder tests checking module existence
- No actual functionality tests implemented yet
- Tests currently fail with import resolution errors (`.ts` files imported as `.js`)

## Setup and Teardown

**Configuration:**
```javascript
// vitest.config.js
export default defineConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  test: {
    globals: true,
    environment: 'jsdom',
    include: ['tests/**/*.test.js'],
  },
})
```

**Patterns:**
- Global test utilities enabled via `globals: true`
- JSDOM environment for DOM testing
- No setup/teardown files currently configured
- No test helpers or utilities directory

## Mocking

**Framework:** Vitest (built-in mocking)

**Patterns:**
- Not currently implemented in existing tests
- No mock patterns established yet

**Guidelines (Inferred from Architecture):**
- Mock external API calls in `ArticleApiClient` tests
- Mock repositories in use case tests
- Mock dependencies injected via constructor
- Use Vitest's `vi.fn()` for function mocks
- Use Vitest's `vi.mock()` for module mocks

**What to Mock:**
- HTTP requests (`fetch` calls)
- External services
- Repository implementations
- Time-dependent functions (e.g., `Date.now()`, `crypto.randomUUID()`)

**What NOT to Mock:**
- Pure functions
- Domain entities
- Value objects
- Simple utilities

## Fixtures and Factories

**Test Data:**
- Not currently implemented
- No fixtures directory exists

**Recommendations (Based on Domain Model):**
```typescript
// Suggested pattern for future implementation
const createTestArticle = (overrides = {}) => ({
  id: crypto.randomUUID(),
  title: 'Test Article',
  content: 'Test content',
  author: { id: '1', name: 'Test Author' },
  publishedAt: null,
  ...overrides,
});
```

**Location:**
- Should be created in `tests/fixtures/` or `tests/helpers/` when needed

## Coverage

**Requirements:** None enforced

**View Coverage:**
```bash
# No coverage script configured
# Would need to add: vitest run --coverage
```

**Current State:**
- No coverage tools configured
- No coverage thresholds set
- No coverage reporting

## Test Types

**Unit Tests:**
- Intended for domain entities, value objects, and use cases
- Currently only placeholder tests exist
- Pattern: Test pure business logic in isolation
- Examples that should exist:
  - `Article.ts`: Test validation, `isPublished()`, `canBeEditedBy()`
  - `ArticleTitle.ts`: Test validation, length limits, trimming
  - `CreateArticle.ts`: Test article creation with mocked repository

**Integration Tests:**
- No integration tests currently exist
- Should test component interaction with services
- Examples that should exist:
  - API client with mock server
  - Repository implementations with mock database
  - Component event handling

**E2E Tests:**
- Not configured
- No E2E framework installed

## Component Testing

**Framework:**
- `jsdom` environment enabled via Vitest config
- `@testing-library/jest-dom` available for DOM assertions

**Patterns:**
- No component tests implemented yet
- Lit components require custom element registration before testing

**Recommendations:**
```typescript
// Suggested pattern for Lit component testing
import { fixture, html } from '@open-wc/testing';
import { Button } from '@/components/ui/button.js';

describe('boson-button', () => {
  it('renders with text', async () => {
    const el = await fixture(html`<boson-button>Click me</boson-button>`);
    expect(el.shadowRoot.textContent).toContain('Click me');
  });
});
```

**Missing Dependencies:**
- `@open-wc/testing` not installed (recommended for Lit component testing)
- `@testing-library/dom` not installed
- `@testing-library/user-event` not installed

## Common Patterns

**Async Testing:**
```typescript
// Current pattern (basic)
it('should fetch articles', async () => {
  const client = new ArticleApiClient();
  const articles = await client.fetchArticles();
  expect(articles).toBeDefined();
});
```

**Error Testing:**
```typescript
// Recommended pattern (not yet implemented)
it('should throw error for empty title', () => {
  expect(() => new ArticleTitle('')).toThrow('Title cannot be empty');
});

it('should throw error for long title', () => {
  expect(() => new ArticleTitle('x'.repeat(201))).toThrow('Title too long');
});
```

**Custom Event Testing:**
```typescript
// Recommended pattern for Lit components (not yet implemented)
it('should dispatch article-selected event', async () => {
  const el = await fixture(html`<article-card .article=${testArticle}></article-card>`);
  const handler = vi.fn();
  el.addEventListener('article-selected', handler);

  el.shadowRoot.querySelector('article').click();

  expect(handler).toHaveBeenCalledWith(
    expect.objectContaining({
      detail: { article: testArticle }
    })
  );
});
```

## Known Issues

**Import Resolution:**
- Tests import `.js` extensions but source files are `.ts`
- Causes "Failed to resolve import" errors
- All 6 test suites currently fail due to this issue
- Vitest using older Vite version (5.4.21) in test config vs newer (7.3.1) in main

**Missing Test Implementation:**
- All tests are placeholder tests checking `toBeDefined()`
- No actual behavior tests for:
  - Domain entities (Article)
  - Value objects (ArticleTitle)
  - Use cases (CreateArticle)
  - Components (article-card, article-list-section)
  - Infrastructure (container, API clients)

**Test Environment:**
- JSDOM configured but not utilized
- No component mounting patterns established
- No test utilities for Lit component testing

## Testing Infrastructure Needs

**To Fix Import Issues:**
1. Update vitest.config.js to use same Vite version as main config
2. Configure proper TypeScript module resolution for tests
3. Consider using `.ts` for test files to match source

**To Enable Real Testing:**
1. Install `@open-wc/testing` for Lit component testing
2. Create test fixtures/factories for domain objects
3. Set up mock utilities for API calls
4. Add coverage tooling (vitest --coverage with c8)
5. Implement actual test cases for existing code

**To Improve DX:**
1. Add watch mode script: `"test:watch": "vitest"`
2. Add coverage script: `"test:coverage": "vitest run --coverage"`
3. Add test:ui script: `"test:ui": "vitest --ui"`
4. Set up pre-commit hook to run tests
5. Configure coverage thresholds

## Test Writing Guidelines

**For Domain Entities:**
- Test all validation rules in constructor
- Test all business logic methods
- Test edge cases (null, empty, boundary values)
- Don't mock entity methods (test them directly)

**For Value Objects:**
- Test immutability (Object.isFrozen)
- Test all validation rules
- Test trimming/normalization
- Test boundary conditions

**For Use Cases:**
- Mock repository dependencies
- Test successful execution path
- Test error handling
- Test business rule enforcement
- Verify repository methods called correctly

**For Components:**
- Test initial render
- Test property changes trigger updates
- Test user interactions (clicks, input)
- Test custom events dispatched correctly
- Test accessibility attributes

**For API Clients:**
- Mock fetch globally
- Test successful response handling
- Test error response handling
- Test request parameters
- Test authentication headers (when added)

---

*Testing analysis: 2026-01-30*
