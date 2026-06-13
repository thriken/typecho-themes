<?php
/**
 * 独立页面模板
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php $this->title(); ?></h1>
    </div>
</section>

<!-- Page Content -->
<section class="article-list-section">
    <div class="container">
        <article style="background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 40px; max-width: 800px; margin: 0 auto;">
            <div class="post-content">
                <?php $this->content(); ?>
            </div>
        </article>
    </div>
</section>

<?php $this->need('footer.php'); ?>
