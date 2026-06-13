<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php $this->need('header.php'); ?>

<div class="sb-404 sa-text-center">
  <div class="sb-404-icon">
    <i class="fa-solid fa-circle-exclamation"></i>
  </div>
  <h1>404</h1>
  <p><?php _e('抱歉，你访问的页面不存在或已被移除。'); ?></p>
  <div class="sa-d-flex sa-justify-center sa-gap-3">
    <a href="<?php $this->options->siteUrl(); ?>" class="sa-button" data-type="primary">
      <i class="fa-solid fa-house"></i> 返回首页
    </a>
    <a href="javascript:history.back();" class="sa-button" data-type="secondary">
      <i class="fa-solid fa-arrow-left"></i> 返回上页
    </a>
  </div>

  <hr class="sb-divider sa-mt-5 sa-mb-5">

  <h3 class="sa-mb-3">试试搜索？</h3>
  <form class="sb-search-form sa-mx-auto" method="get" action="<?php $this->options->siteUrl(); ?>" style="max-width:400px;">
    <input type="text" name="s" placeholder="输入关键词搜索..." required>
    <button type="submit" class="sa-button" data-type="primary">
      <i class="fa-solid fa-magnifying-glass"></i> 搜索
    </button>
  </form>

  <h3 class="sa-mt-5 sa-mb-3">最新文章</h3>
  <div class="sb-404-recent">
    <ul class="sb-404-recent-list">
      <?php \Widget\Contents\Post\Recent::alloc()
          ->parameter('pageSize=6')
          ->to($recentPosts);
      while ($recentPosts->next()): ?>
      <li>
        <a href="<?php $recentPosts->permalink(); ?>">
          <i class="fa-solid fa-file-lines sa-text-secondary"></i>
          <?php $recentPosts->title(); ?>
        </a>
        <span class="sa-text-secondary sb-404-recent-date"><?php $recentPosts->date('Y-m-d'); ?></span>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>
</div>

<?php $this->need('footer.php'); ?>
