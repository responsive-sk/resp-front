<resp-header>

    <boson-button class="logo"
                  type="ghost"
                  slot="logo"
                  href="<?= $this->url('home') ?>">

        <img class="logo"
             src="/images/logo.svg"
             alt="responsive.sk development"
             width="255"
             height="100"
             fetchpriority="high">

    </boson-button>

    <boson-button type="ghost" href="<?= $this->url('blog') ?>">
        Blog
    </boson-button>

    <boson-button type="ghost" href="<?= $this->url('about') ?>">
        About Us
    </boson-button>

    <boson-button type="ghost" href="<?= $this->url('contact') ?>">
        Contact
    </boson-button>

    <!-- Search input -->
    <boson-search-input
        action="/search"
        query="<?= $this->escapeHtml($_GET['q'] ?? '') ?>">
    </boson-search-input>

    <boson-button type="ghost" slot="aside" external href="https://github.com/responsive-sk" pc="true">
        <img src="/images/icons/github.svg" alt="github" width="24" height="24" loading="lazy">
        GitHub
    </boson-button>

    <boson-button type="ghost" slot="aside" external href="https://github.com/responsive-sk" mobile="true">
        <img src="/images/icons/github.svg" alt="github" width="24" height="24" loading="lazy">
    </boson-button>

    <boson-button type="ghost" slot="aside" href="/blog">
        Get On
        <img src="/images/icons/arrow_up_right.svg" alt="arrow_up_right" width="16" height="16" loading="lazy">
    </boson-button>

    <mobile-header-menu slot="mobile-menu">
        <div slot="references">
            <boson-button type="ghost" inheader="true" slot="references" href="/blog">
                <img src="/images/icons/book.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
                Blog
            </boson-button>

            <boson-button type="ghost" inheader="true" slot="references" href="/contact">
                <img src="/images/icons/download.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
                Contact
            </boson-button>

            <boson-button type="ghost" inheader="true" slot="references" href="/">
                <img src="/images/icons/play.svg" alt="" aria-hidden="true" width="16" height="16" loading="lazy">
                G0 H0ME
            </boson-button>
        </div>

        <div slot="blog">
            <?php foreach ($this->blogCategories() as $category): ?>
                <boson-button type="ghost" inheader="true" slot="blog"
                    href="/blog/category/<?= $this->escapeHtml($category) ?>">
                    <?= $this->escapeHtml(ucfirst($category)) ?>
                </boson-button>
            <?php endforeach; ?>
        </div>

        <div slot="actions" class="menu-section">
            <boson-button type="ghost" external href="https://github.com/responsive-sk">
                <img src="/images/icons/github.svg" alt="github" width="24" height="24" loading="lazy">
                GitHub
            </boson-button>

        </div>

        <div slot="search" class="menu-section">
            <boson-search-input>
                action="/search"
                query="<?= $this->escapeHtml($_GET['q'] ?? '') ?>">
            </boson-search-input>
        </div>

    </mobile-header-menu>

</resp-header>