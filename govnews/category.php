<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php $this->need('sidebar.php'); ?>

<main class="main-content">
    <div class="content-module">
        <div class="module-title">
            <h3><?php $this->archiveTitle(['category' => _t('%s')], '', ''); ?></h3>
        </div>

        <?php if ($this->have()): ?>
        <ul class="news-list">
            <?php while ($this->next()): ?>
            <li>
                <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                <span class="news-time"><?php $this->date('Y-m-d'); ?></span>
            </li>
            <?php endwhile; ?>
        </ul>

        <div class="page-box">
            <?php $this->pageNav('&laquo;', '&raquo;'); ?>
        </div>
        <?php else: ?>
        <p style="text-align:center;padding:60px 20px;color:#999;font-size:16px;"><?php _e('该分类下暂无文章'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php $this->need('footer.php'); ?>
