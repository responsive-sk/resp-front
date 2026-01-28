# GitHub Copilot Instructions - Boson Framework

## Project Context
You are working on **Boson Frontend Framework** - a Lit.js component library following Clean Architecture and DDD principles.

**Tech Stack:**
- Lit.js 3.3.2
- Vite 7.3.1  
- pnpm (NOT npm)
- PHP backend (Plates templates)

---

## Ralph Loop Workflow

When I say "Ralph Loop" or "start loop", follow this process:

### LOOP ITERATION:
1. **READ** - Read PRD.md or task description
2. **ANALYZE** - Identify which files need changes
3. **PLAN** - Break into small steps (1-2 files max per step)
4. **IMPLEMENT** - Make changes
5. **BUILD** - Suggest: `pnpm build`
6. **VERIFY** - Check if step succeeded
7. **ASK** - Ask "Continue to next step?" before proceeding
8. **WAIT** - Wait for my approval
9. **REPEAT** - Go to step 4

### Rules:
- Change max 2 files per iteration
- Always run `pnpm build` after changes
- Wait for my "✅" or "continue" before next step
- If build fails, stop and fix immediately
- Explain what you changed and why

---

## Architecture Rules (Non-Negotiable)

### Domain-Driven Design:
- Domain logic is **framework-agnostic**
- No generic `Service` classes - use specific **use-cases**
- Business rules belong **only in Domain layer**
- Naming is critical - **bad names are bugs**

### File Structure:
```
assets/
├── domain/           # Business logic (NO Lit, NO Vite)
│   ├── entities/     # Has identity (ID)
│   ├── value-objects/# Immutable, no identity
│   └── repositories/ # Interfaces only
├── application/      # Use cases (orchestration)
├── infrastructure/   # API, storage (adapters)
└── components/       # Lit.js components (presentation)
```

### Naming Convention:
```javascript
// ❌ BAD - Vague, generic
class ArticleService { }
class PostManager { }

// ✅ GOOD - Specific, clear intent
class CreateArticle { }
class PublishArticle { }
class GetArticleById { }
```

---

## Coding Standards

### Always Do:
1. **Import `nothing` from Lit** when using it:
   ```javascript
   import { html, css, LitElement, nothing } from 'lit';
   ```

2. **Fail Fast** - Validate in constructors:
   ```javascript
   constructor(id, title) {
     if (!id) throw new Error('ID is required');
     if (!title) throw new Error('Title is required');
     this.id = id;
     this.title = title;
   }
   ```

3. **Accessibility** (WCAG 2.1 AA):
   ```javascript
   // Icon-only links need aria-label
   <a href="/github" aria-label="Visit GitHub">
     <img alt="" aria-hidden="true">
   </a>
   
   // Links with text need alt="" on icons
   <a href="/docs" aria-label="View documentation">
     <img alt="" aria-hidden="true">
     Documentation
   </a>
   ```

4. **Focus indicators**:
   ```css
   :focus-visible {
     outline: 2px solid var(--color-border-focus);
     outline-offset: 2px;
   }
   ```

5. **Brand color**:
   ```css
   --color-text-brand: #FF5722;  /* WCAG AA: 4.5:1 contrast */
   /* NOT #F93904 - fails contrast! */
   ```

### Never Do:
- ❌ Use `npm` - always use `pnpm`
- ❌ Put business logic in components
- ❌ Create generic Service classes
- ❌ Forget to import `nothing` from Lit
- ❌ Use #F93904 brand color (bad contrast)
- ❌ Redundant alt text on icons in links

---

## Before Making Changes

1. **Check if SKILL.md exists** for component type:
   ```
   /mnt/skills/public/docx/SKILL.md
   /mnt/skills/public/pptx/SKILL.md
   /mnt/skills/public/xlsx/SKILL.md
   ```

2. **Read PRD.md** if it exists in project

3. **Verify file paths**:
   - Components: `assets/components/`
   - Templates: `partials/`
   - Styles: `assets/styles/`

4. **Check package manager**:
   ```bash
   # ✅ Correct
   pnpm install
   pnpm build
   
   # ❌ Wrong
   npm install
   npm build
   ```

---

## Build & Test Commands

```bash
# Install dependencies
pnpm install

# Development server (with HMR)
pnpm dev

# Production build
pnpm build

# Preview production build
pnpm preview
```

After any component change, always suggest:
```bash
pnpm build
```

---

## Accessibility Requirements

All components must meet WCAG 2.1 AA:

### Contrast:
- Minimum 4.5:1 for normal text
- Minimum 3:1 for large text (18pt+)

### Links:
```html
<!-- ✅ Text link -->
<a href="/page">Link Text</a>

<!-- ✅ Icon + text -->
<boson-button href="/page" aria-label="Descriptive label">
  <img alt="" aria-hidden="true">
  Text
</boson-button>

<!-- ✅ Icon only -->
<boson-button href="/page" aria-label="Descriptive label">
  <img alt="" aria-hidden="true">
</boson-button>
```

### Focus:
```css
/* All interactive elements need visible focus */
:focus-visible {
  outline: 2px solid #FF5722;
  outline-offset: 2px;
}
```

---

## Error Handling

### Fail Fast Pattern:
```javascript
// ✅ Good - fail immediately
class Article {
  constructor(id, title) {
    if (!id) throw new Error('Article ID is required');
    if (!title?.trim()) throw new Error('Article title is required');
    
    this.id = id;
    this.title = title;
  }
}

// ❌ Bad - fail later
class Article {
  constructor(id, title) {
    this.id = id;
    this.title = title;
  }
  
  save() {
    if (!this.title) throw new Error('Title required'); // Too late!
  }
}
```

---

## When Suggesting Changes

### Format:
```markdown
📋 Step X: [Description]

Files to modify:
- path/to/file1.js
- path/to/file2.php

Changes:
1. Line X: Change Y to Z
2. Add lines X-Y: [code snippet]

Reason: [Why this change is needed]

Apply? [Y/n]
```

### After Changes:
```markdown
✅ Changes applied

Next step:
```bash
pnpm build
```

If build succeeds, I'll suggest next step.
If build fails, I'll help fix errors.

Ready to test? [Y/n]
```

---

## Example Ralph Loop Session

**User:** "Start Ralph Loop - implement accessibility fixes from PRD.md"

**You respond:**
```
📋 Ralph Loop Started

Reading PRD.md...
✓ Found 4 phases
✓ Current: Phase 1 - CSS Updates

Step 1: Update brand color in app.css
Files: assets/app.css
Changes:
- Line 34: --color-text-brand: #F93904 → #FF5722
- Line 35: --color-text-brand-hover: #972203 → #FF7043
- Add: --color-border-focus: #FF5722

Apply? [Y/n]
```

**User:** "Y"

**You respond:**
```
✅ Applied changes to assets/app.css

Verify with:
```bash
pnpm build
```

After successful build, respond "✅" to continue to Step 2.
```

**User:** "✅"

**You respond:**
```
📋 Step 2: Add focus indicators

Files: assets/app.css
Changes: [show changes]

Apply? [Y/n]
```

And so on...

---

## Common Patterns

### Lit Component Template:
```javascript
import { LitElement, html, css, nothing } from 'lit';

export class MyComponent extends LitElement {
  static properties = {
    myProp: { type: String },
  };

  static styles = css`
    :host {
      display: block;
    }
    
    :focus-visible {
      outline: 2px solid var(--color-border-focus);
      outline-offset: 2px;
    }
  `;

  constructor() {
    super();
    this.myProp = '';
  }

  render() {
    return html`
      <div>
        ${this.myProp || nothing}
      </div>
    `;
  }
}

customElements.define('my-component', MyComponent);
```

### Use Case Template:
```javascript
// application/use-cases/CreateArticle.js
export class CreateArticle {
  constructor(articleRepository, currentUser) {
    this.articleRepository = articleRepository;
    this.currentUser = currentUser;
  }

  async execute(title, content) {
    // Validation (fail fast)
    if (!title?.trim()) {
      throw new Error('Title is required');
    }

    // Create entity
    const article = new Article(
      crypto.randomUUID(),
      title,
      content,
      this.currentUser,
      null // unpublished
    );

    // Persist
    await this.articleRepository.save(article);

    return article;
  }
}
```

---

## Remember

- **Ralph Loop = Iterative, step-by-step development**
- **Always wait for approval** before next step
- **Fail fast** - validate early, error clearly
- **WCAG AA** - accessibility is non-negotiable
- **pnpm** - never suggest npm
- **Clean Architecture** - domain is sacred

When in doubt, ask the user before making assumptions.
