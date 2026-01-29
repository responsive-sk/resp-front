# Resp Frontend

Minimalist frontend architecture built with Vite, Lit Web Components, and Domain-Driven Design principles.

## Project Goals
- Clean separation of concerns (domain, application, infrastructure, UI)
- High test coverage with Vitest
- Environment-based configuration (dev / test / prod)
- Ready for integration with backend (API + SQLite)

## Folder Structure

```
src/
  application/     # Use-cases
  domain/          # Entities and Value Objects
  infrastructure/  # API, DB, DI
  components/      # UI components
  styles/
  utils/
  app.js

tests/             # Mirrors src structure
public/            # Build output
```

## Scripts

```bash
pnpm dev        # start dev server
pnpm build      # production build
pnpm test       # run all tests
./tests.sh      # custom test runner
```

## Environment Setup

```
.env.development
.env.test
.env.production
```

Example:
```
VITE_API_URL=http://localhost:8000
VITE_APP_ENV=dev
DB_PATH=./src/infrastructure/db/sqlite.db
```

## Testing
- Vitest
- jsdom environment
- Tests live in `/tests` folder

Run:
```bash
pnpm test
```

## Build Output

Compiled files are generated into:

```
public/build/app.js
```

Used by:
```html
<script type="module" src="/build/app.js"></script>
```

## Status
Current state: 
- Core architecture (Clean Architecture) defined.
- `ArticleApiClient` implemented and connecting to backend `http://localhost:8000`.
- Entry point `test-app.js` demonstrates live API data fetching.

