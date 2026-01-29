import { unsafeCSS, css } from 'lit';
import typography from '../styles/typography.css?inline';

export const sharedStyles = css`
  ${unsafeCSS(typography)}

  /* Accessibility: default text contrast & focus */
  :host {
    color: var(--color-text);
  }

  a, button {
    color: var(--color-text);
    text-decoration: none;
  }

  a:focus-visible,
  button:focus-visible,
  [role="button"]:focus-visible {
    outline: 2px solid var(--color-border-focus);
    outline-offset: 2px;
    box-shadow: 0 0 0 4px var(--color-border-focus-ring, rgba(255, 87, 34, 0.1));
  }

  /* Low-contrast text helper classes */
  .text-secondary {
    color: var(--color-text-secondary);
  }
`;
