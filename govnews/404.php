<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="error-page-wrapper">
    <div class="error-page">
        <div class="error-icon">
            <svg viewBox="0 0 120 120" width="120" height="120">
                <circle cx="60" cy="60" r="52" fill="none" stroke="#005ea5" stroke-width="4"/>
                <text x="60" y="72" text-anchor="middle" font-size="42" font-weight="bold" fill="#005ea5">404</text>
            </svg>
        </div>
        <h2 class="error-title"><?php _e('页面没找到'); ?></h2>
        <p class="error-desc"><?php _e('您想查看的页面已被转移或删除，或者您输入的网址有误。'); ?></p>
        <form method="get" class="error-search" action="<?php $this->options->siteUrl(); ?>">
            <input type="text" name="s" class="error-search-input" placeholder="<?php _e('请输入关键字搜索'); ?>" autofocus/>
            <button type="submit" class="error-search-btn"><?php _e('搜索'); ?></button>
        </form>
        <div class="error-links">
            <a href="<?php $this->options->siteUrl(); ?>">← <?php _e('返回首页'); ?></a>
            <a href="javascript:history.back();">← <?php _e('返回上一页'); ?></a>
        </div>
    </div>
</div><!-- end #content-->
<?php $this->need('footer.php'); ?>
