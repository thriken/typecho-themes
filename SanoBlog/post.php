<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php $this->need('header.php'); ?>

<?php $showSidebar = sbShowSidebar('post'); ?>

<?php if ($showSidebar): ?>
<div class="sa-row">

  <div class="sa-col-xl-17 sa-col-lg-16 sa-col-md-24">
<?php endif; ?>

  <!-- ===== Article ===== -->
  <article class="sb-article">

    <!-- Breadcrumb -->
    <div class="sb-breadcrumb sa-d-flex sa-align-center">
      <a href="<?php $this->options->siteUrl(); ?>">首页</a>
      <span>/</span>
      <?php if ($this->category && count($this->categories) > 0): ?>
      <a href="<?php echo $this->categories[0]['permalink']; ?>"><?php echo $this->categories[0]['name']; ?></a>
      <span>/</span>
      <?php endif; ?>
      <span><?php $this->title(); ?></span>
    </div>

    <!-- Article Header -->
    <header class="sb-article-header">
      <h1 class="sb-article-title"><?php $this->title(); ?></h1>
      <div class="sb-article-meta">
        <span><i class="fa-regular fa-user"></i> <?php $this->author(); ?></span>
        <span><i class="fa-regular fa-clock"></i> <?php $this->date('Y-m-d H:i'); ?></span>
        <span><i class="fa-regular fa-folder"></i> <?php $this->category(','); ?></span>
        <span><i class="fa-regular fa-eye"></i> <?php get_post_view($this); ?> 阅读</span>
        <span><i class="fa-regular fa-comment"></i> <?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></span>
      </div>
    </header>

    <!-- Article Top Ad (before content) -->
    <?php if ($this->options->adArticleTop): ?>
    <div class="sb-ad-article-top"><?php sbAd('adArticleTop'); ?></div>
    <?php endif; ?>

    <!-- Article Content -->
    <div class="sb-article-content">
      <?php $this->content(); ?>
    </div>

    <!-- Article Bottom Ad -->
    <?php if ($this->options->adArticleBottom): ?>
    <div class="sb-ad-article-bottom"><?php sbAd('adArticleBottom'); ?></div>
    <?php endif; ?>

    <!-- Article Footer -->
    <footer class="sb-article-footer">
      <?php if (!empty($this->tags)): ?>
      <div class="sb-article-tags">
        <i class="fa-solid fa-tags" style="margin-right:0.25rem;"></i>
        <?php $this->tags('', true, ''); ?>
      </div>
      <?php endif; ?>

      <div class="sb-article-nav sa-d-flex sa-gap-4">
        <span><?php $this->thePrev('<i class="fa-solid fa-chevron-left"></i> %s', '没有了'); ?></span>  |  
        <span><?php $this->theNext('%s <i class="fa-solid fa-chevron-right"></i>', '没有了'); ?></span>
      </div>
    </footer>

  </article>

  <!-- Comments -->
  <?php $this->need('comments.php'); ?>

<?php if ($showSidebar): ?>
  </div>

  <!-- Sidebar -->
  <div class="sa-col-xl-7 sa-col-lg-8 sa-col-md-24">
    <?php $this->need('sidebar.php'); ?>
  </div>

</div>
<?php endif; ?>

<?php $this->need('footer.php'); ?>
