import {css, html, LitElement} from 'lit';

export class SearchLayout extends LitElement {
    static styles = [css`
        .search-layout {

        }

        .search-content {
            width: var(--width-content);
            max-width: var(--width-max);
            margin: 0 auto;
            padding-bottom: 3em;
        }

        ::slotted(section) {
            margin: 2em 0;
        }
    `];

    render() {
        return html`
            <main class="search-layout">
                <slot></slot>

                <section class="search-content">
                    <slot name="content"></slot>
                </section>
            </main>
        `;
    }
}

customElements.define('boson-search-layout', SearchLayout);
