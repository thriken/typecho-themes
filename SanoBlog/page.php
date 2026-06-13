<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php $this->need('header.php'); ?>

<?php $showSidebar = sbShowSidebar('page'); ?>

<?php if ($showSidebar): ?>
<div class="sa-row">

  <div class="sa-col-xl-17 sa-col-lg-16 sa-col-md-24">
<?php endif; ?>

  <article class="sb-article">

    <!-- Breadcrumb -->
    <div class="sb-breadcrumb sa-d-flex sa-align-center">
      <a href="<?php $this->options->siteUrl(); ?>">首页</a>
      <span>/</span>
      <span><?php $this->title(); ?></span>
    </div>

    <header class="sb-article-header">
      <h1 class="sb-article-title"><?php $this->title(); ?></h1>
      <?php if ($this->authorId == $this->user->uid): ?>
      <div class="sa-mt-2">
        <a href="<?php $this->options->adminUrl(); ?>write-page.php?cid=<?php echo $this->cid; ?>" class="sa-button" data-type="secondary" data-size="small">
          <i class="fa-solid fa-pen-to-square"></i> 编辑
        </a>
      </div>
      <?php endif; ?>
    </header>

    <div class="sb-article-content">
      <?php $this->content(); ?>
    </div>

  </article>

  <?php $this->need('comments.php'); ?>

<?php if ($showSidebar): ?>
  </div>

  <div class="sa-col-xl-7 sa-col-lg-8 sa-col-md-24">
    <?php $this->need('sidebar.php'); ?>
  </div>

</div>
<?php endif; ?>

<?php $this->need('footer.php'); ?>
