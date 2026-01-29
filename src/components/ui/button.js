import {css, html, nothing, LitElement} from 'lit';
import {sharedStyles} from '@/utils/sharedStyles.js';

export class Button extends LitElement {
    static properties = {
        href: {type: String},
        external: {type: Boolean},
        type: {type: String},
        icon: {type: String},
        iconWidth: {type: String},
        iconHeight: {type: String},
        active: {type: Boolean},
        ariaLabel: {type: String, attribute: 'aria-label'},
    };

    static styles = [
        sharedStyles,
        css`
        :host {
            display: inline-block;
            line-height: var(--height-ui);
            height: var(--height-ui);
            justify-content: center;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 2em;
            gap: 1em;
            font-family: var(--font-title), sans-serif;
            font-size: var(--font-size-secondary);
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            color: var(--color-text-button);
            background: var(--color-bg-button);
        }

        /* Varianty tlačidiel */
        .button-primary {
            background: var(--color-bg-button);
            color: var(--color-text-button);
        }
        .button-primary.button-active,
        .button-primary:hover {
            background: var(--color-bg-button-hover);
        }

        .button-secondary {
            background: var(--color-bg-button-secondary);
            color: var(--color-text-button-secondary, var(--color-text));
        }
        .button-secondary.button-active,
        .button-secondary:hover {
            background: var(--color-bg-button-secondary-hover);
        }

        .button-ghost {
            background: transparent;
            color: var(--color-text-secondary);
        }
        .button-ghost.button-active,
        .button-ghost:hover {
            background: var(--color-bg-hover);
            color: var(--color-text);
        }

        .icon {
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 1/1;
            height: 32px;
            margin-right: -1em;
            user-select: none;
        }
        .icon img {
            height: var(--font-size-secondary);
            margin: -2px 0 0 0;
        }
        `
    ];

    constructor() {
        super();
        this.href = '';
        this.type = 'primary';
        this.icon = '';
        this.iconWidth = '';
        this.iconHeight = '';
        this.external = false;
        this.active = false;
        this.ariaLabel = '';
    }

    render() {
        const classes = `button button-${this.type} ${this.active ? 'button-active' : ''}`;

        if (!this.href) {
            return html`
                <span class="${classes}" role="button" aria-label="${this.ariaLabel || nothing}">
                    <slot></slot>
                    ${this.icon ? html`<span class="icon" aria-hidden="true">
                        <img class="img" src="${this.icon}" width="${this.iconWidth}" height="${this.iconHeight}" alt=""/>
                    </span>` : nothing}
                </span>
            `;
        }

        return html`
            <a href="${this.href}"
               class="${classes}"
               target="${this.external ? '_blank' : '_self'}"
               rel="${this.external ? 'noopener noreferrer' : nothing}"
               aria-label="${this.ariaLabel || nothing}">
                <slot></slot>
                ${this.icon ? html`<span class="icon" aria-hidden="true">
                    <img class="img" src="${this.icon}" width="${this.iconWidth}" height="${this.iconHeight}" alt=""/>
                </span>` : nothing}
            </a>
        `;
    }
}

customElements.define('boson-button', Button);
