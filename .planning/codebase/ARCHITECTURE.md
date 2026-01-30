# Architecture

**Analysis Date:** 2026-01-30

## Pattern Overview

**Overall:** Clean Architecture with Domain-Driven Design (DDD)

**Key Characteristics:**
- Strict layering with domain-first approach
- Lit Web Components for UI layer with TypeScript decorators
- Lazy loading via Intersection Observer for performance
- Infrastructure abstraction for external services

## Layers

**Domain Layer:**
- Purpose: Core business logic and entities independent of frameworks
- Location: `src/domain/`
- Contains: Entities, Value Objects, Repository interfaces
- Depends on: Nothing (pure TypeScript classes)
- Used by: Application layer, Infrastructure layer

**Application Layer:**
- Purpose: Orchestrates business logic through use cases
- Location: `src/application/`
- Contains: Use case implementations
- Depends on: Domain layer entities and interfaces
- Used by: Infrastructure layer, UI components

**Infrastructure Layer:**
- Purpose: External integrations, API clients, database, dependency injection
- Location: `src/infrastructure/`
- Contains: API clients, DI container, repository implementations
- Depends on: Domain layer interfaces
- Used by: Application layer

**UI Layer (Components):**
- Purpose: Presentation logic and user interaction
- Location: `src/components/`
- Contains: Lit Web Components (sections and UI elements)
- Depends on: Lit framework, shared styles, application layer
- Used by: Layout components, entry point

**Layout Layer:**
- Purpose: Page-level layouts and composition
- Location: `src/layout/`
- Contains: Layout components (landing, blog, docs, default, search)
- Depends on: Lit framework, UI components
- Used by: Entry point (`src/app.ts`)

## Data Flow

**Frontend Initialization Flow:**

1. Entry point (`src/app.ts`) loads critical CSS and components
2. Core components (button, header, footer) eagerly loaded
3. Critical above-the-fold sections (hero, segment) eagerly loaded
4. Layout components registered
5. Intersection Observer watches for lazy-loadable components
6. When components enter viewport → dynamic import triggered
7. Component registered and rendered

**API Data Flow (Article Management):**

1. UI component triggers action
2. Application use case (`CreateArticle`) invoked
3. Use case creates domain entity (`Article`) with validation
4. Infrastructure API client (`ArticleApiClient`) makes HTTP request
5. Response parsed and returned as domain entities
6. UI component receives data and renders

**State Management:**
- Reactive properties via Lit decorators (`@property`)
- Local component state
- No global state management library

## Key Abstractions

**Entity:**
- Purpose: Domain model with identity and business rules
- Examples: `src/domain/entities/Article.ts`
- Pattern: Plain TypeScript classes with validation in constructor

**Value Object:**
- Purpose: Immutable value with validation
- Examples: `src/domain/value-objects/ArticleTitle.ts`
- Pattern: Frozen objects with validation, no identity

**Use Case:**
- Purpose: Single application action encapsulation
- Examples: `src/application/use-cases/CreateArticle.ts`
- Pattern: Class with single `execute()` method

**API Client:**
- Purpose: HTTP communication abstraction
- Examples: `src/infrastructure/api/ArticleApiClient.ts`
- Pattern: Class methods for each endpoint, returns domain types

**Lit Component:**
- Purpose: Reusable UI elements
- Examples: `src/components/ui/button.ts`, `src/components/sections/hero-section.ts`
- Pattern: Class extending LitElement with `@customElement` decorator

**Layout Component:**
- Purpose: Page structure composition
- Examples: `src/layout/landing.ts`, `src/layout/blog.ts`
- Pattern: Lit component providing slot-based composition

**DI Container:**
- Purpose: Dependency injection and service registration
- Examples: `src/infrastructure/di/container.ts`
- Pattern: Map-based factory registry

## Entry Points

**Main Application Entry:**
- Location: `src/app.ts`
- Triggers: Loaded by `index.html` via `<script type="module" src="/src/app.js">`
- Responsibilities: Load critical components, register lazy loaders, initialize Intersection Observer

**Test Application Entry:**
- Location: `src/test-app.ts`
- Triggers: Development/testing mode
- Responsibilities: Fetch articles from API, render article list, handle API errors

**HTML Entry:**
- Location: `index.html`
- Triggers: Browser navigation
- Responsibilities: Mount app div, load module script

## Error Handling

**Strategy:** Defensive programming with throw-early validation

**Patterns:**
- Entity constructors throw on invalid data (`Article`, `ArticleTitle`)
- API clients catch and log HTTP errors, then re-throw
- UI layer catches errors and displays user-friendly messages
- Console logging with emoji prefixes (🚀, ✅, ❌, 📚)

## Cross-Cutting Concerns

**Logging:** Console logging with contextual emoji prefixes for dev/debug

**Validation:** Enforced in domain layer (entities and value objects) at construction time

**Authentication:** Placeholder in use cases (`currentUser: IAuthor`), not yet implemented

**Type Safety:** Strict TypeScript configuration with `strict: true`, interfaces in `src/types/index.ts`

**Performance Optimization:**
- Lazy loading via Intersection Observer for non-critical components
- Dynamic imports for Mermaid diagrams only when detected
- CSS imported inline for critical path optimization

**Component Registration:**
- Global type declarations via `declare global { interface HTMLElementTagNameMap }`
- Custom element registration via `@customElement('tag-name')` decorator

---

*Architecture analysis: 2026-01-30*
