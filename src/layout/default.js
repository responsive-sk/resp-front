import {css, html, LitElement} from 'lit';

export class DefaultLayout extends LitElement {
    static styles = [css`
        .default-layout {

        }
    `];

    render() {
        return html`
            <main class="default-layout">
                <slot></slot>
            </main>
        `;
    }
}

customElements.define('boson-default-layout', DefaultLayout);
