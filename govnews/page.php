<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-mb-12 col-8" id="main" role="main">
    <main class="main-content">
        <article class="post" itemscope itemtype="http://schema.org/BlogPosting"></article>
        <h1 class="article-title"><?php $this->title(); ?></h1>
            <?php postMeta($this, 'page'); ?>
            <div class="article-content">
                <?php $this->content(); ?>
            </div>
            </article>
    </main>
</div><!-- end #main-->
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>