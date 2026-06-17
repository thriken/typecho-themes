<?php
/**
 * SanoBlog - 共享文章列表组件
 * 由 index.php 通过 include 引入，消除双栏/单栏分支的代码重复
 *
 * 依赖外部变量：$layout（'list'|'grid'）、$gridCols（列数）、$this（Widget_Archive）
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<?php if ($this->have()): ?>

<!-- View Toggle -->
<div class="sa-d-flex sa-flex-between sa-align-center sa-mb-4">
  <div>
    <?php if ($this->is('index') && !isset($_GET['s'])): ?>
    <span class="sa-text-secondary" style="font-size:0.9rem;">最新文章</span>
    <?php endif; ?>
  </div>
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
<!-- Grid Mode -->
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
<!-- List Mode -->
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
<!-- No posts -->
<div class="sb-no-posts">
  <p><i class="fa-regular fa-folder-open"></i> 暂无文章，敬请期待。</p>
</div>
<?php endif; ?>
