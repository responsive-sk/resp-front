# Product Requirements Document (PRD)
## Resp-Front: Domain-Driven Design Frontend Application

**Version:** 1.0  
**Date:** 2026-01-29  
**Status:** Active Development  
**Project Type:** DDD Frontend Architecture with Web Components

---

## 1. Executive Summary

### 1.1 Product Vision

Resp-Front is a **framework-agnostic frontend application** built using **Domain-Driven Design (DDD) principles** and **Web Components** (Lit). It serves as the presentation layer for a PHP-based blog system, demonstrating how Clean Architecture and DDD can be applied to frontend development.

### 1.2 Core Objectives

1. **Separation of Concerns**: Domain logic completely isolated from UI and infrastructure
2. **Framework Independence**: Business rules work without Lit, React, or any framework
3. **Testability**: Every layer independently testable
4. **Scalability**: Add new features without touching existing code
5. **Maintainability**: Clear boundaries make refactoring safe and predictable

### 1.3 Target Audience

- **Primary**: Development teams building complex frontend applications
- **Secondary**: Frontend architects seeking DDD implementation examples
- **Tertiary**: Educational purposes for Clean Architecture patterns

---

## 2. Product Architecture

### 2.1 Architectural Layers

```
┌─────────────────────────────────────────────────────────┐
│                     Presentation Layer                   │
│  (Web Components, Layouts, UI Components, Styles)       │
├─────────────────────────────────────────────────────────┤
│                    Application Layer                     │
│           (Use Cases, Orchestration Logic)               │
├─────────────────────────────────────────────────────────┤
│                      Domain Layer                        │
│        (Entities, Value Objects, Business Rules)         │
├─────────────────────────────────────────────────────────┤
│                  Infrastructure Layer                    │
│    (API Clients, Repositories, DI Container, DB)         │
└─────────────────────────────────────────────────────────┘
```

### 2.2 Dependency Rule

**Critical Principle**: Dependencies point **inward only**.

- ✅ Application → Domain
- ✅ Infrastructure → Domain
- ✅ Presentation → Application → Domain
- ❌ Domain → Application (NEVER)
- ❌ Domain → Infrastructure (NEVER)

### 2.3 Technology Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| **Web Components** | Lit 3.x | UI components with Shadow DOM |
| **Module Bundler** | Vite 7.x | Fast dev server + build |
| **Testing** | Vitest | Unit + integration tests |
| **Styling** | CSS + CSS Variables | Shadow DOM + Light DOM strategy |
| **API Communication** | Fetch API | RESTful backend integration |
| **Storage** | SQLite (dev) | Local development database |

---

## 3. Domain Model

### 3.1 Bounded Context: Blog

**Primary Aggregate**: Article

#### 3.1.1 Entities

**Article** (`src/domain/entities/Article.js`)

```javascript
class Article {
  constructor(id, title, content, status, authorId, createdAt, updatedAt)
  
  // Business rules
  publish()      // Only drafts can be published
  unpublish()    // Only published can be unpublished
  isPublished()  // Status check
  canBeEdited()  // Business rule: only drafts editable
}
```

**Invariants:**
- Article title must not be empty
- Status can only be 'draft' or 'published'
- Published articles cannot be deleted
- Author ID must be valid

#### 3.1.2 Value Objects

**ArticleTitle** (`src/domain/value-objects/ArticleTitle.js`)

```javascript
class ArticleTitle {
  constructor(value)
  
  // Validation rules
  - Minimum length: 3 characters
  - Maximum length: 255 characters
  - No special characters in title
  - Immutable (readonly)
}
```

**Future Value Objects:**
- `ArticleContent` - Rich text validation
- `ArticleStatus` - Enumeration with state machine
- `ArticleSlug` - URL-safe identifier generation
- `AuthorId` - User reference validation

### 3.2 Repository Interfaces

Defined in Domain, implemented in Infrastructure:

```javascript
// Domain layer defines contract
interface ArticleRepository {
  findById(id): Article
  findAll(): Article[]
  save(article): void
  delete(id): void
}
```

---

## 4. Application Layer

### 4.1 Use Cases

Each business operation is a **dedicated class** (no generic "Service" classes).

#### 4.1.1 Current Use Cases

**CreateArticle** (`src/application/use-cases/CreateArticle.js`)

```javascript
class CreateArticle {
  constructor(articleRepository)
  
  execute(title, content, authorId): Article
  
  // Orchestration logic:
  // 1. Validate input
  // 2. Create Article entity
  // 3. Save via repository
  // 4. Return created article
}
```

#### 4.1.2 Planned Use Cases

- **PublishArticle**: Change article status to published
- **UnpublishArticle**: Revert to draft
- **UpdateArticle**: Modify existing article
- **DeleteArticle**: Remove article (if rules allow)
- **SearchArticles**: Filter and paginate
- **GetArticleBySlug**: Retrieve by URL-friendly identifier

### 4.2 Use Case Pattern

```javascript
class [UseCase]Name {
  constructor(...dependencies) {
    this.repository = repository;
  }
  
  execute(...params) {
    // 1. Validate input
    // 2. Load domain entities
    // 3. Apply business rules
    // 4. Persist changes
    // 5. Return result
  }
}
```

**Rules:**
- One use case = One business operation
- No business logic here (only orchestration)
- Dependencies injected via constructor
- Returns domain entities or value objects

---

## 5. Infrastructure Layer

### 5.1 API Integration

**ArticleApiClient** (`src/infrastructure/api/ArticleApiClient.js`)

**Endpoints:**
```
GET    /api/articles       → List all articles
GET    /api/articles/:id   → Get single article
POST   /api/articles       → Create article
PATCH  /api/articles/:id   → Update article
DELETE /api/articles/:id   → Delete article
```

**Configuration:**
- Base URL: `http://localhost:8000/api` (configurable)
- CORS enabled for `localhost:5173`
- JSON response format
- Error handling with descriptive messages

### 5.2 Repository Implementation

**Future**: `ArticleApiRepository` implements `ArticleRepository` interface.

```javascript
class ArticleApiRepository {
  constructor(apiClient)
  
  async findById(id): Article {
    const data = await apiClient.fetchArticle(id);
    return Article.fromJSON(data);
  }
  
  // ... other methods
}
```

### 5.3 Dependency Injection

**Container** (`src/infrastructure/di/container.js`)

```javascript
const container = {
  articleRepository: new ArticleApiRepository(apiClient),
  createArticle: new CreateArticle(articleRepository),
  // ... other use cases
};
```

### 5.4 Local Database (Development)

**Location:** `src/infrastructure/db/sqlite.db`

**Purpose:** 
- Development/testing only
- Mock data for offline development
- Schema alignment with backend

**Schema:**
```sql
CREATE TABLE articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'draft',
    author_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## 6. Presentation Layer

### 6.1 Component Architecture

#### 6.1.1 Component Types

**Section Components** (`src/components/sections/`)
- Large page sections
- Layout structure
- Use `<slot>` for content projection
- Minimal business logic

**UI Components** (`src/components/ui/`)
- Reusable widgets
- Buttons, inputs, cards
- Emit custom events
- Stateless where possible

**Layout Components** (`src/layout/`)
- Page templates
- Route-specific layouts
- Shell structure

#### 6.1.2 Current Components

| Component | Type | Purpose |
|-----------|------|---------|
| `article-list-section` | Section | Display article grid |
| `article-card` | UI | Single article preview |
| `hero-section` | Section | Landing page hero |
| `segment-section` | Section | Content segments |
| `call-to-action-section` | Section | CTA prompts |
| `button` | UI | Customizable buttons |
| `header` | UI | Navigation header |
| `footer` | UI | Page footer |
| `breadcrumbs` | UI | Navigation breadcrumbs |
| `search-input` | UI | Search functionality |
| `dropdown` | UI | Dropdown menus |
| `slider` | UI | Image/content slider |
| `horizontal-accordion` | UI | Collapsible sections |
| `mobile-header-menu` | UI | Mobile navigation |
| `page-title` | UI | Page headings |
| `subtitle` | UI | Subheadings |
| `dots-container` | UI | Pagination dots |
| `docs-toc` | Section | Table of contents |
| `logo` | UI | Brand logo component |

#### 6.1.3 Component Pattern (Lit)

```javascript
import { LitElement, html, css } from 'lit';
import { sharedStyles } from '@/utils/sharedStyles.js';

export class ArticleCard extends LitElement {
  static properties = {
    article: { type: Object }
  };
  
  static styles = [sharedStyles, css`
    /* Component-specific layout only */
    :host {
      display: block;
      padding: 1rem;
    }
  `];
  
  render() {
    return html`
      <article>
        <h3>${this.article.title}</h3>
        <p>${this.article.content}</p>
      </article>
    `;
  }
}

customElements.define('article-card', ArticleCard);
```

### 6.2 Styling Strategy

**See:** `docs/CSS_ARCHITECTURE.md`

#### 6.2.1 Shadow DOM Styles (Component .js files)

✅ Layout and positioning  
✅ Component structure  
✅ `::slotted()` for direct children  
✅ CSS variable definitions

#### 6.2.2 Light DOM Styles (Global CSS files)

✅ Typography (`typography.css`)  
✅ Font loading (`fonts.css`)  
✅ Layout utilities (`layout.css`)  
✅ Documentation styles (`docs.css`)

#### 6.2.3 Design Tokens (`sharedStyles.js`)

All CSS variables centralized:

```javascript
export const sharedStyles = css`
  :host {
    --font-title: 'Inter', sans-serif;
    --font-size-h1: clamp(3rem, 5vw, 5rem);
    --color-text: #e8e6e3;
    --color-text-brand: #da2f2e;
    --width-max: 1400px;
  }
`;
```

### 6.3 Layouts

| Layout | File | Purpose |
|--------|------|---------|
| `landing` | `src/layout/landing.js` | Homepage |
| `blog` | `src/layout/blog.js` | Article listing |
| `docs` | `src/layout/docs.js` | Documentation pages |
| `search` | `src/layout/search.js` | Search results |
| `default` | `src/layout/default.js` | Fallback layout |

---

## 7. Testing Strategy

### 7.1 Test Pyramid

```
       ┌─────────────┐
       │   E2E (10%)  │
       ├─────────────┤
       │ Integration  │
       │    (30%)     │
       ├─────────────┤
       │     Unit     │
       │    (60%)     │
       └─────────────┘
```

### 7.2 Test Coverage Requirements

| Layer | Coverage Target | Test Types |
|-------|----------------|------------|
| Domain | 100% | Unit tests |
| Application | 90% | Unit + Integration |
| Infrastructure | 70% | Integration |
| Presentation | 60% | Component tests |

### 7.3 Current Tests

**Domain Tests:**
- `tests/domain/entities/Article.test.js` - Entity business rules

**Application Tests:**
- `tests/application/use-cases/CreateArticle.test.js` - Use case orchestration

**Infrastructure Tests:**
- `tests/infrastructure/di/container.test.js` - Dependency injection

**Component Tests:**
- `tests/components/ui/article-card.test.js` - UI component rendering
- `tests/components/sections/article-list-section.test.js` - Section component

**App Tests:**
- `tests/app.test.js` - Application initialization

### 7.4 Testing Tools

```bash
# Run all tests
npm test

# Watch mode
npm test -- --watch

# Coverage report
npm test -- --coverage

# Run test script
./tests.sh
```

### 7.5 Test Pattern Examples

**Domain Entity Test:**
```javascript
describe('Article', () => {
  it('should publish draft article', () => {
    const article = new Article(1, 'Title', 'Content', 'draft');
    article.publish();
    expect(article.isPublished()).toBe(true);
  });
  
  it('should not publish already published article', () => {
    const article = new Article(1, 'Title', 'Content', 'published');
    expect(() => article.publish()).toThrow();
  });
});
```

**Use Case Test:**
```javascript
describe('CreateArticle', () => {
  it('should create article with valid data', async () => {
    const repository = new MockArticleRepository();
    const useCase = new CreateArticle(repository);
    
    const article = await useCase.execute('Title', 'Content', 1);
    
    expect(article.title).toBe('Title');
    expect(repository.saved).toBe(true);
  });
});
```

---

## 8. Development Workflow

### 8.1 Project Setup

```bash
# Clone repository
git clone <repo-url>
cd resp-front

# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Run tests
npm test
```

### 8.2 Development Commands

| Command | Purpose |
|---------|---------|
| `npm run dev` | Start Vite dev server (port 5173) |
| `npm run build` | Build for production |
| `npm run preview` | Preview production build |
| `npm test` | Run Vitest tests |
| `./tests.sh` | Run test suite script |

### 8.3 File Structure Conventions

```
src/
├── domain/               # Business logic (framework-agnostic)
│   ├── entities/        # Rich domain models
│   ├── value-objects/   # Immutable values
│   └── repositories/    # Repository interfaces
├── application/         # Use cases (orchestration)
│   └── use-cases/       # One class per business operation
├── infrastructure/      # External integrations
│   ├── api/            # HTTP clients
│   ├── repositories/   # Repository implementations
│   ├── db/             # Database (dev only)
│   └── di/             # Dependency injection
├── components/          # Presentation layer
│   ├── sections/       # Large page sections
│   └── ui/             # Reusable UI components
├── layout/              # Page templates
├── styles/              # Global CSS
└── utils/               # Shared utilities
```

### 8.4 Naming Conventions

**Files:**
- PascalCase for classes: `Article.js`, `CreateArticle.js`
- kebab-case for components: `article-card.js`, `hero-section.js`
- lowercase for utilities: `sharedStyles.js`, `container.js`

**Components:**
- Custom elements: `<article-card>`, `<hero-section>`
- Two-word minimum (Web Components standard)

**CSS:**
- kebab-case: `.article-card`, `.hero-section`
- BEM methodology for complex components
- CSS variables: `--color-text-brand`, `--font-size-h1`

---

## 9. Build & Deployment

### 9.1 Build Configuration

**Vite Config** (`vite.config.js`)

```javascript
export default defineConfig({
  server: { port: 5173 },
  publicDir: 'public',
  build: {
    outDir: 'public/build',
    emptyOutDir: true,
    rollupOptions: {
      input: 'src/app.js',
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name].[ext]'
      }
    }
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src')
    }
  }
});
```

### 9.2 Build Output

```
public/build/
├── app.js              # Bundled application
├── index.html          # HTML entry point
├── favicon.ico         # Favicon
└── dev-index.html      # Development HTML
```

### 9.3 Environment Variables

```bash
# .env.development
VITE_API_URL=http://localhost:8000/api
VITE_APP_ENV=development

# .env.production
VITE_API_URL=https://api.production.com
VITE_APP_ENV=production
```

### 9.4 Deployment Targets

**Static Hosting:**
- Netlify
- Vercel
- GitHub Pages
- Cloudflare Pages

**CDN:**
- Upload `public/build/*` to CDN
- Configure API endpoint

---

## 10. Feature Roadmap

### 10.1 Phase 1: Foundation (Current)

**Status:** ✅ Complete

- [x] DDD architecture setup
- [x] Domain layer (Article entity)
- [x] Application layer (CreateArticle use case)
- [x] Infrastructure layer (API client)
- [x] Basic UI components
- [x] Testing framework
- [x] Build pipeline

### 10.2 Phase 2: Core Features (In Progress)

**Status:** 🔄 Active Development

- [ ] Complete CRUD operations
  - [ ] UpdateArticle use case
  - [ ] DeleteArticle use case
  - [ ] PublishArticle use case
- [ ] Article repository implementation
- [ ] Enhanced value objects (ArticleContent, ArticleSlug)
- [ ] State management for complex forms
- [ ] Search functionality
- [ ] Pagination component

### 10.3 Phase 3: Advanced Features (Planned)

**Status:** 📋 Planning

- [ ] Rich text editor integration
- [ ] Image upload and management
- [ ] Article categories/tags
- [ ] Author management
- [ ] Comments system (new bounded context)
- [ ] Real-time updates (WebSocket)
- [ ] Offline support (Service Worker)

### 10.4 Phase 4: Optimization (Future)

**Status:** 💡 Backlog

- [ ] Code splitting per route
- [ ] Lazy loading components
- [ ] Performance monitoring
- [ ] A/B testing framework
- [ ] Analytics integration
- [ ] SEO optimization
- [ ] Accessibility audit (WCAG 2.1 AA)

---

## 11. Technical Constraints

### 11.1 Browser Support

| Browser | Minimum Version | Notes |
|---------|----------------|-------|
| Chrome | 90+ | Full support |
| Firefox | 88+ | Full support |
| Safari | 14+ | Partial CSS features |
| Edge | 90+ | Full support |
| Mobile Safari | iOS 14+ | Touch optimizations |
| Mobile Chrome | Android 90+ | Full support |

### 11.2 Performance Budgets

| Metric | Target | Maximum |
|--------|--------|---------|
| First Contentful Paint | < 1.5s | 2s |
| Largest Contentful Paint | < 2.5s | 3s |
| Time to Interactive | < 3s | 4s |
| Total Blocking Time | < 200ms | 300ms |
| Cumulative Layout Shift | < 0.1 | 0.15 |
| Bundle Size (JS) | < 100KB | 150KB |
| Bundle Size (CSS) | < 30KB | 50KB |

### 11.3 Dependencies

**Production:**
- `lit@^3.3.2` - Web Components framework

**Development:**
- `vite@^7.3.1` - Build tool
- `vitest@^0.34.6` - Testing framework
- `jsdom@^27.4.0` - DOM testing
- `@testing-library/jest-dom@^6.9.1` - Test utilities

### 11.4 Backend Integration

**Required Backend:**
- RESTful API at `/api/articles`
- CORS enabled for `localhost:5173`
- JSON response format
- HTTP methods: GET, POST, PATCH, DELETE

**Backend Repository:** `packages/blog/` (PHP DDD implementation)

---

## 12. Non-Functional Requirements

### 12.1 Accessibility

**Target:** WCAG 2.1 Level AA

- [ ] Semantic HTML throughout
- [ ] ARIA labels for interactive elements
- [ ] Keyboard navigation support
- [ ] Focus indicators visible
- [ ] Color contrast ratio ≥ 4.5:1
- [ ] Screen reader compatible
- [ ] Alt text for images

**See:** `docs/ACCESSIBILITY.md`

### 12.2 Security

- [ ] XSS prevention (sanitize user input)
- [ ] CSRF protection for API calls
- [ ] Content Security Policy headers
- [ ] No sensitive data in client storage
- [ ] HTTPS only in production

### 12.3 Performance

- [ ] Code splitting by route
- [ ] Lazy load below-fold components
- [ ] Image optimization (WebP, lazy loading)
- [ ] Service Worker for caching
- [ ] Bundle analysis and tree-shaking

### 12.4 Maintainability

- [ ] 100% TypeScript migration (future)
- [ ] Automated dependency updates
- [ ] Comprehensive documentation
- [ ] Code review process
- [ ] Continuous integration

---

## 13. Documentation

### 13.1 Available Documentation

| Document | Purpose |
|----------|---------|
| `README.md` | Project overview and setup |
| `docs/architecture.md` | Architecture decisions |
| `docs/ACCESSIBILITY.md` | Accessibility guidelines |
| `docs/CSS_ARCHITECTURE.md` | Styling strategy |
| `docs/PRD.md` | This document |

### 13.2 Future Documentation

- [ ] API Integration Guide
- [ ] Component Development Guide
- [ ] Testing Best Practices
- [ ] Deployment Guide
- [ ] Contributing Guidelines
- [ ] Code Style Guide

---

## 14. Success Metrics

### 14.1 Technical Metrics

| Metric | Current | Target |
|--------|---------|--------|
| Test Coverage | 60% | 85% |
| Build Time | <5s | <3s |
| Bundle Size | 120KB | <100KB |
| Lighthouse Score | 85 | 95+ |

### 14.2 Development Metrics

| Metric | Target |
|--------|--------|
| Time to add new use case | <1 hour |
| Time to add new component | <2 hours |
| Time to fix bug | <4 hours |
| Onboarding new developer | <1 day |

### 14.3 Business Metrics

| Metric | Target |
|--------|--------|
| Article creation success rate | >95% |
| Search result relevance | >80% |
| User task completion | >90% |
| Error rate | <1% |

---

## 15. Risk Management

### 15.1 Technical Risks

| Risk | Impact | Mitigation |
|------|--------|------------|
| Browser compatibility | Medium | Progressive enhancement |
| Bundle size growth | High | Code splitting, tree-shaking |
| API endpoint changes | High | Adapter pattern, versioning |
| Third-party dependency issues | Medium | Lock versions, minimal deps |

### 15.2 Project Risks

| Risk | Impact | Mitigation |
|------|--------|------------|
| Scope creep | High | Strict PRD adherence |
| Technical debt | Medium | Regular refactoring sprints |
| Knowledge silos | Medium | Documentation, pair programming |

---

## 16. Glossary

**Aggregate**: Cluster of domain objects treated as a single unit  
**Bounded Context**: Explicit boundary within domain model  
**Domain-Driven Design (DDD)**: Software design approach focused on domain model  
**Entity**: Domain object with unique identity  
**Light DOM**: Regular DOM (outside Shadow DOM)  
**Repository**: Abstraction for data access  
**Shadow DOM**: Encapsulated DOM tree in Web Components  
**Use Case**: Application-specific business operation  
**Value Object**: Immutable object without identity  
**Web Component**: Reusable custom HTML element

---

## 17. Appendices

### 17.1 Related Projects

- **Backend**: `packages/blog/` - PHP DDD blog system
- **Admin Panel**: `packages/mark/` - Moonshine admin
- **Documentation**: Main project `README.md`

### 17.2 References

- [Domain-Driven Design by Eric Evans](https://www.domainlanguage.com/ddd/)
- [Clean Architecture by Robert C. Martin](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- [Lit Documentation](https://lit.dev/)
- [Web Components MDN](https://developer.mozilla.org/en-US/docs/Web/Web_Components)

---

## 18. Changelog

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | 2026-01-29 | Initial PRD creation |

---

## 19. Approval

**Product Owner:** _[Pending]_  
**Tech Lead:** _[Pending]_  
**Date:** _[Pending]_

---

**Document Status:** Draft  
**Next Review:** 2026-02-15  
**Contact:** Resp-Front Team
