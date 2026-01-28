# Resp Frontend – Architecture

Projekt je navrhnutý podľa princípov **Clean Architecture** a **Domain Driven Design (DDD)**.
Cieľom je mať:
- oddelenú doménovú logiku
- testovateľný kód
- škálovateľnú architektúru
- jasné hranice medzi vrstvami

---

## Folder structure

src/
├── application
│ └── use-cases
├── components
│ ├── sections
│ └── ui
├── domain
│ ├── entities
│ ├── repositories
│ └── value-objects
├── infrastructure
│ ├── api
│ ├── db
│ ├── di
│ └── repositories
├── layout
├── styles
├── utils
└── app.js

tests/
├── application
├── components
├── domain
├── infrastructure
└── app.test.js

---

## Layers

### Domain layer
Obsahuje čistú biznis logiku.

- entities (Article)
- value-objects (ArticleTitle)
- repositories (interfaces)

Nezávisí na žiadnom frameworku ani infraštruktúre.

---

### Application layer
Obsahuje use-cases.

- CreateArticle
- orchestration logiky
- validácie

Závisí len na Domain.

---

### Infrastructure layer
Technické implementácie:

- API
- SQLite DB
- Dependency Injection container
- repository implementácie

Závisí na Domain.

---

### UI / Components layer

- ui – malé komponenty (card, button)
- sections – väčšie bloky (article-list)
- layout – layouty aplikácie

Žiadna biznis logika.

---

## Dependency rule

Závislosti môžu ísť len jedným smerom:

UI -> Application -> Domain
Infrastructure -> Domain

Domain nikdy neimportuje z Application ani Infrastructure.

---

## Module alias

Používa sa alias:

@ = /src

Príklad:

```js
import { Article } from '@/domain/entities/Article.js'
~~~

## Environment configuration

Používané prostredia:

development

test

production

Env premenné:

VITE_API_URL

VITE_APP_ENV

DB_PATH

Testing

Použité:

Vitest

jsdom

Štruktúra testov kopíruje src:

tests/domain/entities/Article.test.js
tests/application/use-cases/CreateArticle.test.js
tests/components/ui/article-card.test.js


Spustenie testov:

pnpm test


alebo:

./tests.sh

Build & deploy

Build:

pnpm build


Output:

public/build/app.js


Apache:

rewrite na index.php

cache static assets

gzip compression

Architecture goals

modulárnosť

testovateľnosť

čistá doména

oddelenie UI a logiky

jednoduchý deploy


---

## Roadmap docs/roadmap.md

```md
# Boson Frontend – Roadmap

---

## Phase 1 – Stabilization (current)

- [x] Clean architecture structure
- [x] Vitest setup
- [x] Env config (dev/test/prod)
- [x] Dependency Injection container
- [x] SQLite DB
- [x] Apache build pipeline
- [x] UI base components
- [x] All tests passing

---

## Phase 2 – Data layer

- [ ] Repository pattern for SQLite
- [ ] Migrations system
- [ ] Seed data
- [ ] Transactions
- [ ] Error handling strategy

---

## Phase 3 – Application features

- [ ] CRUD Articles
- [ ] Pagination
- [ ] Search & filtering
- [ ] Permissions
- [ ] Validation layer

---

## Phase 4 – UI improvements

- [ ] Layout system
- [ ] Theme (dark/light)
- [ ] Loading states
- [ ] Error states
- [ ] Accessibility (a11y)

---

## Phase 5 – Testing & quality

- [ ] Coverage report
- [ ] Integration tests
- [ ] E2E tests (Playwright)
- [ ] ESLint
- [ ] Prettier

---

## Phase 6 – DevOps

- [ ] CI pipeline (GitHub Actions)
- [ ] Automated tests on push
- [ ] Versioning
- [ ] Changelog
- [ ] Release process

---

## Phase 7 – Documentation

- [ ] API documentation
- [ ] Architecture diagrams
- [ ] Setup guide
- [ ] Deployment guide
- [ ] Contribution guide

---

## Long-term ideas

- Plugin system
- Offline-first mode
- PWA
- Multi-language support
- Headless frontend mode
- Performance profiling

---

## Rules

- Tests before features
- Domain always independent
- No business logic in UI
- Docs updated with every major change
