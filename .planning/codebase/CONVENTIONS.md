# Coding Conventions

**Analysis Date:** 2026-01-30

## Naming Patterns

**Files:**
- TypeScript components: `kebab-case.ts` (e.g., `hero-section.ts`, `article-card.ts`, `mobile-header-menu.ts`)
- Domain entities: `PascalCase.ts` (e.g., `Article.ts`, `ArticleTitle.ts`)
- Test files: Match source file name with `.test.js` suffix (e.g., `Article.test.js`)
- CSS files: `kebab-case.css` (e.g., `typography.css`)

**Functions:**
- Public methods: `camelCase` (e.g., `isPublished()`, `canBeEditedBy()`, `fetchArticles()`)
- Private methods: Prefix with underscore `_camelCase` (e.g., `_handleClick()`, `_formatError()`)
- Async functions: Use `async`/`await` pattern consistently (e.g., `async execute()`, `async fetchArticles()`)

**Variables:**
- Local variables: `camelCase` (e.g., `articleTitle`, `currentUser`, `mermaidLoaded`)
- Constants: `camelCase` for module-level (e.g., `lazyLoadSections`, `componentObserver`)
- Type definitions: `PascalCase` with `I` prefix for interfaces (e.g., `IArticle`, `IAuthor`)

**Types:**
- Interfaces: `PascalCase` with `I` prefix (e.g., `IArticle`, `IAuthor`, `IArticleRepository`)
- Classes: `PascalCase` (e.g., `Article`, `Button`, `HeroSection`, `ArticleApiClient`)
- Type aliases: `PascalCase` (e.g., `LazyLoadMap`)
- Generic types: Single uppercase letter or descriptive `PascalCase` (e.g., `ApiResponse<T>`)

**Custom Elements:**
- Tag names: `kebab-case` (e.g., `boson-button`, `hero-section`, `article-card`)
- Prefix component-specific tags with `boson-` for UI library components (e.g., `boson-button`, `boson-dropdown`, `boson-breadcrumbs`)
- Section components: Use `-section` suffix (e.g., `hero-section`, `article-list-section`)

## Code Style

**Formatting:**
- Tool: Prettier 3.8.1
- Configuration: `.prettierrc.cjs`
- Semi-colons: Disabled (`semi: false`)
- Quotes: Single quotes (`singleQuote: true`)
- Print width: 100 characters
- Tab width: 2 spaces
- Trailing commas: ES5 style (`trailingComma: 'es5'`)
- Run: `pnpm format:fix` to format all files

**Linting:**
- Tool: ESLint 9.39.2 with TypeScript plugin
- Configuration: `.eslintrc.cjs`
- Parser: `@typescript-eslint/parser`
- Rules: Extends `eslint:recommended`, `plugin:@typescript-eslint/recommended`, and `prettier`
- Environments: Browser, ES2021, Node
- Ignored: `node_modules/`, `dist/`, `public/build/`
- Run: `pnpm lint` to check all files

## Import Organization

**Order:**
1. External library imports (e.g., `import { css, html, LitElement } from 'lit'`)
2. Lit decorators (e.g., `import { customElement, property } from 'lit/decorators.js'`)
3. Type imports using `type` keyword (e.g., `import type { IAuthor } from '...'`)
4. Internal utility imports (e.g., `import { sharedStyles } from '@/utils/sharedStyles.js'`)
5. Component/module imports (e.g., `import './components/ui/button.ts'`)

**Path Aliases:**
- `@/*` maps to `./src/*` (configured in `tsconfig.json` and `vitest.config.js`)
- Always use `.js` extension in imports, even for `.ts` files (ESM module resolution)
- Example: `import { Article } from '@/domain/entities/Article.js'`

**Import Style:**
- Use explicit `.js` extensions for all local imports
- Use named imports when importing specific items (e.g., `import { css, html } from 'lit'`)
- Use `import type` for type-only imports to enable better tree-shaking
- Side-effect imports for CSS: `import './app.css'`
- Side-effect imports for component registration: `import './components/ui/button.ts'`

## Error Handling

**Patterns:**
- Validation in constructors: Throw `Error` with descriptive message (e.g., `throw new Error('Article must have an ID')`)
- Value objects: Validate in constructor and freeze object (e.g., `Object.freeze(this)`)
- API clients: Try-catch with console.error logging using emoji prefixes (e.g., `console.error('❌ Failed to fetch articles:', error)`)
- Async error propagation: Catch, log, and re-throw for caller handling
- HTTP errors: Check `response.ok` and throw with status (e.g., `throw new Error(\`HTTP error! status: \${response.status}\`)`)

**Error Messages:**
- Use clear, specific messages (e.g., "Title cannot be empty", "Title too long")
- Avoid generic messages like "Invalid input"

## Logging

**Framework:** console (native)

**Patterns:**
- Success logs: Use emoji prefix `📚` for fetched data, `📄` for single items
- Error logs: Use emoji prefix `❌` for failures
- Debug logs: Use `console.log` with descriptive messages (e.g., `console.log(\`Lazy loaded: \${tagName}\`)`)
- Log placement: After successful operations and in catch blocks
- Example: `console.log('📚 Fetched articles:', data)`
- Example: `console.error('❌ Failed to fetch articles:', error)`

## Comments

**When to Comment:**
- Section headers for code organization (e.g., `// Core components that are used on every page`)
- Complex logic explanation (e.g., `// Lazy load Mermaid only when needed`)
- Disabled code with reason (e.g., `// import './layout/docs.ts';` - reason not documented but pattern observed)
- Type definitions (e.g., `// Lit component type helpers`, `// Article domain types`)

**JSDoc/TSDoc:**
- Use JSDoc for public API methods in infrastructure layer
- Document purpose, parameters, and return types
- Example from `ArticleApiClient`:
```typescript
/**
 * API Client for Article endpoints
 * Infrastructure layer - communicates with backend
 */
export class ArticleApiClient {
  /**
   * Fetch all articles
   */
  async fetchArticles(): Promise<IArticle[]> { ... }
}
```

**Comment Style:**
- Single-line comments: Use `//` with space after
- Multi-line comments: Use JSDoc style `/** */` for documentation
- Avoid obvious comments (e.g., don't comment `// get id` above `getId()`)

## Function Design

**Size:**
- Keep functions focused on single responsibility
- Most methods under 30 lines
- Extract complex logic into helper functions (e.g., `loadMermaid()`, `observeComponents()`)

**Parameters:**
- Use constructor injection for dependencies (e.g., `constructor(articleRepository: ArticleRepository, currentUser: IAuthor)`)
- Use options objects for functions with many parameters
- Prefer explicit parameters over implicit global state
- Use default parameters when appropriate (e.g., `baseUrl: string = 'http://localhost:8000/api'`)

**Return Values:**
- Use typed return values (e.g., `Promise<IArticle[]>`, `boolean`, `void`)
- Return consistent types (don't mix null/undefined)
- Use `Promise` for all async operations
- Use `void` for functions without return values

## Module Design

**Exports:**
- Export classes directly: `export class Article { ... }`
- Export constants: `export const sharedStyles: CSSResult = ...`
- Use default export for custom element registration when appropriate
- Always include global type declaration for custom elements:
```typescript
declare global {
  interface HTMLElementTagNameMap {
    'boson-button': Button;
  }
}
```

**Barrel Files:**
- Use `index.ts` for type exports (e.g., `src/types/index.ts`)
- Consolidate related type definitions in single file
- Don't create barrel files for components (import directly)

## TypeScript Conventions

**Strict Mode:**
- `strict: true` enabled in `tsconfig.json`
- `noUnusedLocals: true` - no unused variables
- `noUnusedParameters: true` - no unused parameters
- `noImplicitReturns: true` - all code paths must return value
- All code must type-check without errors

**Decorators:**
- Use experimental decorators: `experimentalDecorators: true`
- `useDefineForClassFields: false` for Lit compatibility
- Apply `@customElement('tag-name')` for all Lit components
- Use `@property()` decorator for reactive properties with explicit types:
```typescript
@property({ type: String })
href: string = '';

@property({ type: Boolean })
external: boolean = false;
```

**Type Annotations:**
- Always annotate function return types (e.g., `: Promise<Article>`, `: boolean`)
- Annotate class properties with types (e.g., `id: string`)
- Use `readonly` for immutable properties (e.g., `readonly value: string`)
- Use union types for limited sets (e.g., `type: 'primary' | 'secondary' | 'ghost'`)

**Type vs Interface:**
- Use `interface` for object shapes with `I` prefix (e.g., `IArticle`, `IAuthor`)
- Use `type` for unions, intersections, and mapped types (e.g., `LazyLoadMap`)
- Use `type` for function signatures (e.g., `type LoaderFunction = () => Promise<any>`)

## Lit Component Conventions

**Component Structure:**
1. Imports
2. `@customElement` decorator
3. Class declaration extending `LitElement`
4. `@property` decorators
5. Static `styles` property
6. Lifecycle methods (if needed)
7. Custom methods
8. `render()` method
9. Global type declaration

**Property Definitions:**
- Use decorator syntax: `@property({ type: String })`
- Provide default values: `href: string = ''`
- Use correct type mapping: `String`, `Boolean`, `Number`, `Array`, `Object`
- Use `attribute` option for custom attribute names: `@property({ type: String, attribute: 'aria-label' })`

**Styles:**
- Use static `styles` array: `static styles = [sharedStyles, css\`...\`]`
- Import `sharedStyles` for consistent typography and accessibility
- Use CSS custom properties for theming (e.g., `var(--color-text)`)
- Use `:host` selector for component root styling

**Templates:**
- Use `html` tagged template literal
- Use `nothing` from Lit for conditional rendering (e.g., `${this.icon ? html\`...\` : nothing}`)
- Use `@event` syntax for event handlers (e.g., `@click=${this._handleClick}`)
- Use `?` for boolean attributes (e.g., `?disabled=${this.disabled}`)

**Events:**
- Use `CustomEvent` for component events
- Set `bubbles: true, composed: true` for events that should cross shadow DOM
- Use descriptive event names (e.g., `article-selected`)
- Include relevant data in `detail` property

## Domain-Driven Design Patterns

**Entities:**
- Location: `src/domain/entities/`
- Validation in constructor
- Business logic methods (e.g., `isPublished()`, `canBeEditedBy()`)
- Example: `Article.ts`

**Value Objects:**
- Location: `src/domain/value-objects/`
- Immutable (use `readonly` and `Object.freeze(this)`)
- Validation in constructor
- Example: `ArticleTitle.ts`

**Use Cases:**
- Location: `src/application/use-cases/`
- Single responsibility per use case
- Dependency injection via constructor
- Example: `CreateArticle.ts`

**Infrastructure:**
- Location: `src/infrastructure/`
- API clients: `src/infrastructure/api/`
- Repositories: `src/infrastructure/repositories/`
- DI container: `src/infrastructure/di/`

---

*Convention analysis: 2026-01-30*
