<boson-header>
    <boson-button class="logo" type="ghost" slot="logo" href="<?= $this->url('home') ?>">
<!--        <img class="logo" src="/images/logo.svg" alt="logo" width="255" height="100" loading="eager">-->
        <img class="logo"
             src="/images/logo.svg"
             alt="responsive.sk logo"
             width="255"
             height="100"
             fetchpriority="high">
    </boson-button>

    <boson-dropdown>
        <boson-button type="ghost" slot="summary"
            href="/docs">
            References
        </boson-button>

        <boson-button type="ghost" href="/docs/latest/introduction">
            <img src="/images/icons/book.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
            Introduction
        </boson-button>

        <boson-button type="ghost" href="/docs/latest/installation">
            <img src="/images/icons/download.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
            Installation
        </boson-button>

        <boson-button type="ghost" href="/docs/latest/getting-started">
            <img src="/images/icons/play.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
            Getting Started
        </boson-button>
    </boson-dropdown>

    <boson-dropdown>
        <boson-button type="ghost" slot="summary"
            href="/blog">
            Blog
        </boson-button>

        <?php foreach ($blogCategories as $category): ?>
            <boson-button type="ghost" href="/blog/category/<?= $this->escapeHtml($category) ?>">
                <?= $this->escapeHtml(ucfirst($category)) ?>
            </boson-button>
        <?php endforeach; ?>
    </boson-dropdown>

    <!-- Search input -->
    <boson-search-input
        action="/search"
        query="<?= $this->escapeHtml($_GET['q'] ?? '') ?>">
    </boson-search-input>

    <boson-button type="ghost" slot="aside" external href="https://github.com/boson-php/boson" pc="true">
        <img src="/images/icons/github.svg" alt="github" width="24" height="24" loading="lazy">
        GitHub
    </boson-button>

    <boson-button type="ghost" slot="aside" external href="https://github.com/boson-php/boson" mobile="true">
        <img src="/images/icons/github.svg" alt="github" width="24" height="24" loading="lazy">
    </boson-button>

    <boson-button type="ghost" slot="aside" href="/docs/latest/installation">
        Get Started
        <img src="/images/icons/arrow_up_right.svg" alt="arrow_up_right" width="16" height="16" loading="lazy">
    </boson-button>

    <mobile-header-menu slot="mobile-menu">
        <div slot="references">
            <boson-button type="ghost" inheader="true" slot="references" href="/docs/latest/introduction">
                <img src="/images/icons/book.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
                Introduction
            </boson-button>

            <boson-button type="ghost" inheader="true" slot="references" href="/docs/latest/installation">
                <img src="/images/icons/download.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
                Installation
            </boson-button>

            <boson-button type="ghost" inheader="true" slot="references" href="/docs/latest/getting-started">
                <img src="/images/icons/play.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
                Getting Started
            </boson-button>
        </div>

        <div slot="blog">
            <?php foreach ($blogCategories as $category): ?>
                <boson-button type="ghost" inheader="true" slot="blog" href="/blog/category/<?= $this->escapeHtml($category) ?>">
                    <?= $this->escapeHtml(ucfirst($category)) ?>
                </boson-button>
            <?php endforeach; ?>
        </div>

        <div slot="actions" class="menu-section">
            <boson-button type="ghost" external href="https://github.com/boson-php/boson">
                <img src="/images/icons/github.svg" alt="github" width="24" height="24" loading="lazy">
                GitHub
            </boson-button>

            <?php if ($docsVersion): ?>
            <boson-button type="ghost" href="<?= $this->url('doc.show', [
                'version' => $docsVersion->getName(),
                'page' => 'introduction'
            ]) ?>">
                Get Started
                <img src="/images/icons/arrow_up_right.svg" alt="arrow_up_right" loading="lazy" width="16" height="16">
            </boson-button>
            <?php endif; ?>
        </div>

        <div slot="search" class="menu-section">
            <boson-search-input>
                action="/search"
                query="<?= $this->escapeHtml($_GET['q'] ?? '') ?>">
            </boson-search-input>
        </div>
    </mobile-header-menu>
</boson-header>
