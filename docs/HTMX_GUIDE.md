# HTMX Príručka

## 🚀 Rýchly start

### 1. Inštalácia
```bash
# CDN (používané v projekte)
<script src="https://unpkg.com/htmx.org@1.9.10"></script>

# npm (pre TypeScript typy)
npm install htmx.org@1.9.10
```

### 2. Základné použitie
```html
<div hx-get="/users" hx-target="#result">
  Načítať používateľov
</div>
<div id="result"></div>
```

---

## 📖 Konfigurácia

### Globálne nastavenia
```typescript
// v app.ts
if (window.htmx) {
  window.htmx.config.historyEnabled = true;
  window.htmx.config.historyCacheSize = 10;
  window.htmx.config.defaultSwapStyle = 'innerHTML';
  window.htmx.config.indicatorClass = 'htmx-indicator';
  window.htmx.config.requestClass = 'htmx-request';
}
```

### Dôležité konfiguračné voľby
| Vlastnosť | Predvolená | Popis |
|-----------|------------|--------|
| `historyEnabled` | `true` | Povolí browser históriu |
| `indicatorClass` | `'htmx-indicator'` | CSS class pre loading indikátor |
| `requestClass` | `'htmx-request'` | CSS class počas requestu |
| `defaultSwapStyle` | `'innerHTML'` | Ako sa vymeni obsah |

---

## 🎯 Atribúty

### Základné atribúty
```html
<!-- HTTP metódy -->
<button hx-get="/data">GET</button>
<button hx-post="/data">POST</button>
<button hx-put="/data">PUT</button>
<button hx-delete="/data">DELETE</button>

<!-- Ciele -->
<div hx-get="/users" hx-target="#users-list">Načítať</div>
<div id="users-list"></div>

<!-- Triggery -->
<div hx-get="/data" hx-trigger="click">Klikni ma</div>
<div hx-get="/data" hx-trigger="load">Načítať pri štarte</div>
<div hx-get="/data" hx-trigger="every 2s">Každé 2s</div>
```

### Pokročilé atribúty
```html
<!-- Swap štýly -->
<div hx-get="/data" hx-swap="outerHTML">Vymeniť celý element</div>
<div hx-get="/data" hx-swap="beforebegin">Vložiť pred</div>
<div hx-get="/data" hx-swap="afterend">Vložiť za</div>

<!-- Indikátory -->
<div hx-get="/data" hx-indicator="#loading">Načítať</div>
<div id="loading" class="htmx-indicator">Načítavam...</div>

<!-- Potvrdenie -->
<button hx-delete="/item/1" hx-confirm="Naozaj zmazať?">Zmazať</button>
```

---

## 🔄 Event Handling

### Event Listeners
```typescript
// Globálne event listeners
window.htmx.on('htmx:afterSwap', (event: any) => {
  console.log('Obsah vymenený:', event.detail.target);
});

window.htmx.on('htmx:beforeRequest', (event: any) => {
  console.log('Request začína:', event.detail.pathInfo?.requestPath);
});

window.htmx.on('htmx:afterRequest', (event: any) => {
  console.log('Request dokončený:', event.detail.successful);
});

// Špecifické elementy
const myButton = document.getElementById('my-button');
window.htmx.on(myButton, 'click', (evt: Event) => {
  console.log('Button clicked:', evt);
});
```

### Dôležité HTMX Eventy
| Event | Kedy sa spustí |
|-------|---------------|
| `htmx:beforeRequest` | Pred odoslaním requestu |
| `htmx:afterRequest` | Po dokončení requestu |
| `htmx:beforeSwap` | Pred výmenou obsahu |
| `htmx:afterSwap` | Po výmene obsahu |
| `htmx:responseError` | Pri chybe response |

---

## 🛠️ API Funkcie

### Core API
```typescript
// Manuálne AJAX volanie
window.htmx.ajax('GET', '/api/users', '#users-container');

// Spracovanie elementu
window.htmx.process(document.body); // Prehľadať hx-* atribúty

// Nájdenie elementov
const element = window.htmx.find('#my-div');
const elements = window.htmx.findAll('.my-class');

// Najbližší rodič
const parent = window.htmx.closest(element, 'form');
```

### Utility Funkcie
```typescript
// CSS triedy
window.htmx.addClass(element, 'active');
window.htmx.removeClass(element, 'active');
window.htmx.toggleClass(element, 'active');
window.htmx.takeClass(element, 'selected');

// Odstránenie elementu
window.htmx.remove(element, 1000); // s 1s delayom

// Výmena obsahu
window.htmx.swap('#target', '<div>Nový obsah</div>', {
  swapStyle: 'innerHTML',
  swapDelay: 0
});
```

---

## 🎨 Styling a Indikátory

### Loading indikátor
```css
.htmx-indicator {
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
}

.htmx-request .htmx-indicator {
  opacity: 1;
}

.htmx-request {
  opacity: 0.7;
  transition: opacity 0.2s ease;
}
```

### Animácie
```css
/* Pre transition efekty */
.htmx-swapping {
  opacity: 0;
}

.htmx-settling {
  transition: all 0.3s ease;
}
```

---

## 🔧 Pokročilé Funkcie

### Extensions
```typescript
// Vlastná extension
window.htmx.defineExtension('debug', {
  onEvent: function(name: string, evt: Event) {
    console.log(`HTMX Event: ${name}`, evt);
  }
});
```

### WebSocket a SSE
```typescript
// WebSocket konfigurácia
window.htmx.createWebSocket = function(url: string) {
  return new WebSocket(url, ['wss']);
};

// EventSource konfigurácia
window.htmx.createEventSource = function(url: string) {
  return new EventSource(url, { withCredentials: false });
};
```

---

## 📝 Príklady z Projektu

### 1. Auto-boost pre všetky odkazy
```typescript
// Automaticky boost všetky odkazy a formuláre
document.body.setAttribute('hx-boost', 'true');
```

### 2. Re-inicializácia komponentov
```typescript
window.htmx.on('htmx:afterSwap', (event: any) => {
  // Re-inicializovať custom komponenty po výmene obsahu
  if (window.reinitializeComponents) {
    window.reinitializeComponents();
  }
});
```

### 3. Error handling
```typescript
window.htmx.on('htmx:responseError', (event: any) => {
  console.error('HTMX Error:', event.detail);
  // Zobraziť error message
  const errorDiv = document.createElement('div');
  errorDiv.className = 'error-message';
  errorDiv.textContent = 'Nastala chyba pri načítaní';
  document.body.appendChild(errorDiv);
});
```

---

## 🐛 Debugging

### Zapnutie logovania
```typescript
// Zapnúť všetky HTMX logy
window.htmx.logAll();

// Vlastný logger
window.htmx.logger = function(elt: any, event: string, data: any) {
  console.log(`HTMX ${event}:`, elt, data);
};
```

### Testovanie
```typescript
// Testovanie HTMX funkčnosti
if (window.htmx) {
  console.log('HTMX verzia:', window.htmx.version);
  console.log('HTMX konfigurácia:', window.htmx.config);
} else {
  console.error('HTMX nenájdené!');
}
```

---

## 🔗 Zdroje

- [Oficiálna dokumentácia](https://htmx.org/)
- [Examples](https://htmx.org/examples/)
- [Reference](https://htmx.org/reference/)

---

## 📝 Best Practices

1. **Vždy používajte CDN script pred app.js** - HTMX parsuje HTML pri načítaní
2. **Konfigurujte HTMX hneď na začiatku** - pred akýmikoľvek HTMX operáciami
3. **Používajte indikátory** - pre lepšie UX
4. **Error handling** - spracujte `htmx:responseError`
5. **Re-inicializácia** - po `htmx:afterSwap` re-inicializujte JS komponenty

---

*Táto príručka je pre váš projekt - prispôsobte si ju podľa potrebností!*
