import {css, html, LitElement} from 'lit';

export class LandingLayout extends LitElement {
    static styles = [css`
        .landing-layout {
            display: flex;
            flex-direction: column;
            gap: var(--landing-layout-gap);
        }
    `];

    render() {
        return html`
            <main class="landing-layout">
                <slot></slot>
            </main>
        `;
    }
}

customElements.define('boson-landing-layout', LandingLayout);
