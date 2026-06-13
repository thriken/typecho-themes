<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<aside class="sb-sidebar">

  <!-- Sidebar Ad -->
  <?php if ($this->options->adSidebar): ?>
  <div class="sb-ad-sidebar"><?php sbAd('adSidebar'); ?></div>
  <?php endif; ?>

  <!-- Search Widget -->
  <?php if ($this->options->sbWidgetSearch !== '0'): ?>
  <div class="sb-widget">
    <h3 class="sb-widget-title"><i class="fa-solid fa-magnifying-glass"></i> 搜索</h3>
    <form class="sb-search-form" method="get" action="<?php $this->options->siteUrl(); ?>" role="search">
      <input type="text" name="s" placeholder="输入关键词搜索..." value="<?php echo isset($_GET['s']) ? htmlspecialchars($_GET['s']) : ''; ?>" required>
      <button type="submit" class="sa-button" data-type="primary">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </form>
  </div>
  <?php endif; ?>

  <!-- Recent Posts Widget -->
  <?php if ($this->options->sbWidgetRecent !== '0'): ?>
  <div class="sb-widget">
    <h3 class="sb-widget-title"><i class="fa-solid fa-clock"></i> 最新文章</h3>
    <ul>
      <?php $this->widget('Widget\Contents\Post\Recent', 'pageSize=8')->to($recentPosts); ?>
      <?php while ($recentPosts->next()): ?>
      <li><a href="<?php $recentPosts->permalink(); ?>" title="<?php $recentPosts->title(); ?>">
        <?php $recentPosts->title(); ?>
      </a></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <!-- Categories Widget -->
  <?php if ($this->options->sbWidgetCategory !== '0'): ?>
  <div class="sb-widget">
    <h3 class="sb-widget-title"><i class="fa-solid fa-folder"></i> 分类目录</h3>
    <ul>
      <?php $this->widget('Widget\Metas\Category\Rows')->to($catList); ?>
      <?php $seen = []; ?>
      <?php while ($catList->next()): ?>
      <?php if (in_array($catList->mid, $seen)) continue; $seen[] = $catList->mid; ?>
      <li>
        <a href="<?php $catList->permalink(); ?>">
          <?php $catList->name(); ?>
          <span class="sa-text-secondary" style="font-size:0.8rem;">(<?php $catList->count(); ?>)</span>
        </a>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <!-- Tags Widget -->
  <?php if ($this->options->sbWidgetTag !== '0'): ?>
  <div class="sb-widget">
    <h3 class="sb-widget-title"><i class="fa-solid fa-tags"></i> 标签云</h3>
    <div class="sb-tag-cloud">
      <?php $this->widget('Widget\Metas\Tag\Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=30')->to($tagCloud); ?>
      <?php while ($tagCloud->next()): ?>
      <a href="<?php $tagCloud->permalink(); ?>" style="font-size:<?php echo max(0.75, min(1.3, 0.75 + $tagCloud->count / 30)); ?>rem;">
        <?php $tagCloud->name(); ?>
      </a>
      <?php endwhile; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Archives Widget -->
  <?php if ($this->options->sbWidgetArchive !== '0'): ?>
  <div class="sb-widget">
    <h3 class="sb-widget-title"><i class="fa-solid fa-calendar"></i> 文章归档</h3>
    <ul>
      <?php $this->widget('Widget\Contents\Post\Date', 'type=month&format=Y年m月&limit=12')->to($archives); ?>
      <?php while ($archives->next()): ?>
      <li><a href="<?php $archives->permalink(); ?>">
        <?php $archives->date(); ?>
        <span class="sa-text-secondary" style="font-size:0.8rem;">(<?php $archives->count(); ?>)</span>
      </a></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <!-- Comments Widget -->
  <?php if ($this->options->sbWidgetComment !== '0'): ?>
  <div class="sb-widget">
    <h3 class="sb-widget-title"><i class="fa-solid fa-comments"></i> 最新评论</h3>
    <ul>
      <?php $this->widget('Widget\Comments\Recent', 'pageSize=6')->to($recentComments); ?>
      <?php while ($recentComments->next()): ?>
      <li>
        <a href="<?php $recentComments->permalink(); ?>" title="<?php $recentComments->title(); ?>">
          <?php $recentComments->author(false); ?>:
          <?php $recentComments->excerpt(30, '...'); ?>
        </a>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

</aside>
