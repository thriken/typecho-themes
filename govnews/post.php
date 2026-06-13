<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!-- post.php START -->
<?php 
$this->need('header.php');
$this->need('sidebar.php'); ?>

<main class="main-content">
    <h1 class="article-title" itemprop="name headline"><?php $this->title(); ?></h1>
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting"></article>
    <?php postMeta($this, 'post'); ?>
    <div class="article-content" itemprop="articleBody">
        <?php $this->content(); ?>
    </div>
    </article>
    <p itemprop="keywords" class="tags"><?php _e('标签'); ?>: <?php $this->tags(', ', true, 'none'); ?></p>
    <div class="back-btn">
        <ul class="post-near">
            <li>上一篇: <?php $this->thePrev('%s', _t('没有了')); ?></li>
            <li>下一篇: <?php $this->theNext('%s', _t('没有了')); ?></li>
        </ul>
    </div>
<!-- 评论区 -->
<?php $this->need('comments.php'); ?>
</main>

<?php $this->need('footer.php'); ?>