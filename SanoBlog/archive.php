<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php $this->need('header.php'); ?>

<?php
$layout = sbGetLayout();
$gridCols = sbGetGridCols();
?>

<!-- ===== Archive Header ===== -->
<div class="sb-archive-header">
  <?php if ($this->is('category')): ?>
  <h1><i class="fa-solid fa-folder"></i> <?php $this->archiveTitle(['category' => '%s'], '', ''); ?></h1>
  <?php if ($this->getDescription()): ?>
  <div class="sb-archive-desc sa-mt-2"><?php echo $this->getDescription(); ?></div>
  <?php endif; ?>

  <?php elseif ($this->is('tag')): ?>
  <h1><i class="fa-solid fa-tag"></i> <?php $this->archiveTitle(['tag' => '%s'], '', ''); ?></h1>
  <?php if ($this->getDescription()): ?>
  <div class="sb-archive-desc sa-mt-2"><?php echo $this->getDescription(); ?></div>
  <?php endif; ?>

  <?php elseif ($this->is('search')): ?>
  <h1><i class="fa-solid fa-magnifying-glass"></i> <?php $this->archiveTitle(['search' => '搜索：%s'], '', ''); ?></h1>
  <div class="sb-archive-desc sa-mt-2">
    共找到 <strong><?php echo $this->getTotal(); ?></strong> 篇相关文章
  </div>

  <?php elseif ($this->is('author')): ?>
  <h1><i class="fa-solid fa-user"></i> <?php $this->archiveTitle(['author' => '%s'], '', ''); ?></h1>

  <?php else: ?>
  <h1><?php $this->archiveTitle('', '', ''); ?></h1>
  <?php endif; ?>
</div>

<?php if ($this->have()): ?>

<!-- View Toggle -->
<div class="sa-d-flex sa-flex-between sa-align-center sa-mb-4">
  <span class="sa-text-secondary" style="font-size:0.9rem;">
    共 <?php echo $this->getTotal(); ?> 篇文章
  </span>
  <div class="sb-view-toggle sa-d-flex">
    <button data-mode="list" class="<?php echo $layout === 'list' ? 'active' : ''; ?>" title="列表模式">
      <i class="fa-solid fa-list"></i>
    </button>
    <button data-mode="grid" class="<?php echo $layout === 'grid' ? 'active' : ''; ?>" title="网格模式">
      <i class="fa-solid fa-grip"></i>
    </button>
  </div>
</div>

<?php if ($layout === 'grid'): ?>
<div class="sb-grid sb-grid-<?php echo $gridCols; ?>">
  <?php while ($this->next()): ?>
  <article class="sb-post-card">
    <?php $thumb = sbPostThumb($this->content); ?>
    <?php if ($thumb): ?>
    <a href="<?php $this->permalink(); ?>">
      <img class="sb-post-thumb" src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>" loading="lazy">
    </a>
    <?php endif; ?>
    <div class="sb-post-body">
      <h2 class="sb-post-title">
        <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
      </h2>
      <div class="sb-post-excerpt">
        <?php echo sbExcerpt($this->text, 80); ?>
      </div>
      <div class="sb-post-meta">
        <span><i class="fa-regular fa-clock"></i> <?php $this->date('Y-m-d'); ?></span>
        <span><i class="fa-regular fa-folder"></i> <?php $this->category(','); ?></span>
        <span><i class="fa-regular fa-comment"></i> <?php $this->commentsNum('0', '1', '%d'); ?></span>
      </div>
    </div>
  </article>
  <?php endwhile; ?>
</div>
<?php else: ?>
<?php while ($this->next()): ?>
<article class="sb-post-card sb-post-card-list sa-mb-4">
  <?php $thumb = sbPostThumb($this->content) ?: 'https://picsum.photos/seed/' . $this->cid . '/240/160'; ?>
  <a href="<?php $this->permalink(); ?>">
    <img class="sb-post-thumb" src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>" loading="lazy">
  </a>
  <div class="sb-post-body">
    <h2 class="sb-post-title">
      <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
    </h2>
    <div class="sb-post-excerpt">
      <?php echo sbExcerpt($this->text, 200); ?>
    </div>
    <div class="sb-post-meta">
      <span><i class="fa-regular fa-clock"></i> <?php $this->date('Y-m-d'); ?></span>
      <span><i class="fa-regular fa-folder"></i> <?php $this->category(','); ?></span>
      <span><i class="fa-regular fa-comment"></i> <?php $this->commentsNum('0', '1', '%d'); ?></span>
      <?php if (!empty($this->tags)): ?>
      <span><i class="fa-solid fa-tag"></i> <?php $this->tags(',', true, 'none'); ?></span>
      <?php endif; ?>
    </div>
  </div>
</article>
<?php endwhile; ?>
<?php endif; ?>

<!-- Pagination -->
<?php $this->pageNav('<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>', 3, '...', [
    'wrapTag' => 'div',
    'wrapClass' => 'sb-pagination sa-d-flex sa-justify-center',
    'currentClass' => 'current',
]); ?>

<?php else: ?>
<div class="sb-no-posts">
  <i class="fa-solid fa-inbox" style="font-size:3rem;color:#ddd;display:block;margin-bottom:1rem;"></i>
  <p><?php _e('没有找到相关内容'); ?></p>
  <?php if ($this->is('search')): ?>
  <p class="sa-mt-2 sa-text-secondary">试试其他关键词？</p>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php $this->need('footer.php'); ?>
