<?php
/**
 * 404 页面模板
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<section style="padding-top: calc(var(--header-height) + 100px); padding-bottom: 100px; text-align: center;">
    <div class="container">
        <div style="font-size: 8rem; font-weight: 800; color: var(--color-border); line-height: 1;">404</div>
        <h1 style="font-size: 1.5rem; font-weight: 600; margin: 24px 0 12px;">页面未找到</h1>
        <p style="color: var(--color-text-secondary); margin-bottom: 32px;">抱歉，您访问的页面不存在或已被移除。</p>
        <a href="<?php $this->options->siteUrl(); ?>" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            返回首页
        </a>
    </div>
</section>

<?php $this->need('footer.php'); ?>
