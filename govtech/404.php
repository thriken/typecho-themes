<?php $this->need('header.php'); ?>

<div class="layout-wrapper">
    <div class="main-content-area">
        <div class="container">
            <div class="layout-grid">
                <main class="main-column" role="main" id="main-content">
                    <div class="error-page">
                        <div class="error-page__icon" aria-hidden="true">
                            <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="none">
                                <circle cx="60" cy="60" r="58" stroke="#bfdbfe" stroke-width="2"/>
                                <text x="50%" y="52%" dominant-baseline="middle" text-anchor="middle"
                                      font-size="36" font-weight="700" fill="#1d4ed8" font-family="sans-serif">404</text>
                                <path d="M30 80 Q60 95 90 80" stroke="#93c5fd" stroke-width="2" stroke-linecap="round" fill="none"/>
                            </svg>
                        </div>
                        <h1 class="error-page__title">页面未找到</h1>
                        <p class="error-page__desc">您访问的页面不存在，可能已被删除或地址有误。</p>
                        <div class="error-page__actions">
                            <a href="<?php $this->options->siteUrl(); ?>" class="btn btn--primary">返回首页</a>
                        </div>
                        <div class="error-page__search">
                            <p style="font-size:14px;color:var(--text-muted);margin-bottom:10px;">或者尝试搜索：</p>
                            <form action="<?php $this->options->siteUrl(); ?>" method="get" class="error-search-form">
                                <input type="text" name="s" class="form-input" placeholder="搜索文章..." style="max-width:320px;">
                                <button type="submit" class="btn btn--primary" style="margin-left:8px;">搜索</button>
                            </form>
                        </div>
                    </div>
                </main>
                <?php $this->need('sidebar.php'); ?>
            </div>
        </div>
    </div>
<?php $this->need('footer.php'); ?>
