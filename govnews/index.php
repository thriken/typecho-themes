<?php

/**
 * GovNews Theme
 * 新闻主题
 *
 * @package GovNews
 * @author Thriken
 * @version 1.0.0
 * @link https://blog.elec.top
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('sidebar.php'); ?>


<!-- 右侧主内容 -->
<main class="main-content">
    <!-- 头条新闻 -->
    <div class="content-module">
        <div class="module-title">
            <h3>最新要闻</h3>
            <a href="#">更多>></a>
        </div>
        <ul class="news-list">
            <?php \Widget\Contents\Post\Recent::alloc('pageSize=5')->to($featured); ?>
            <?php 
            $i = 0;
            while ($featured->next()): $i++; ?>
                <?php if ($i === 1): ?>
                    <a href="<?php $featured->permalink(); ?>">
                        <?php if ($featured->fields->thumb): ?>
                            <img src="<?php echo $featured->fields->thumb; ?>" alt="<?php $featured->title(); ?>" loading="lazy">
                        <?php endif; ?>
                        <h2><span>[头条]</span>
                            <?php $featured->title(); ?>
                    </a>
                    <span class="news-time" datetime="<?php $featured->date('c'); ?>"><?php $featured->date('Y-m-d'); ?></span></h2>

                <?php else: ?>
                    <?php if ($i === 2): ?>
                        <ul class="news-list">
                        <?php endif; ?>
                        <li>
                            <a href="<?php $featured->permalink(); ?>"><?php $featured->title(); ?></a>
                            <span class="news-time"><?php $featured->date('m-d'); ?></span>
                        </li>
                        <?php if ($i === 5): ?>
                        </ul><?php endif; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- 通知公告+政务公开+本地资讯 三列（后台可配） -->
    <?php
    $col3Ids = array_filter(array_map('intval', explode(',', $this->options->homeCol3Cats)));
    if (!empty($col3Ids)): ?>
    <div class="info-grid">
        <?php foreach ($col3Ids as $mid):
            $cat = getCategoryById($mid);
            $posts = $cat ? getSimplePostsByCategoryId($mid, 3) : [];
        ?>
        <div class="content-module">
            <div class="module-title">
                <h3><?php echo $cat ? htmlspecialchars($cat['name']) : '#' . $mid; ?></h3>
                <?php if ($cat): ?><a href="<?php echo $cat['permalink']; ?>">更多&gt;&gt;</a><?php endif; ?>
            </div>
            <ul class="news-list">
                <?php foreach ($posts as $post): ?>
                <li>
                    <a href="<?php echo $post['permalink']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                    <span class="news-time"><?php echo date('m-d', $post['created']); ?></span>
                </li>
                <?php endforeach; ?>
                <?php if (empty($posts)): ?>
                <li><span style="color:#999;">暂无文章</span></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- 政策文件等单栏模块（后台可配，多个分类各占一行） -->
    <?php
    $col1Ids = array_filter(array_map('intval', explode(',', $this->options->homeCol1Cats)));
    if (!empty($col1Ids)):
        foreach ($col1Ids as $mid):
            $cat = getCategoryById($mid);
            $policyPosts = $cat ? getPostsByCategoryId($mid, 3) : [];
    ?>
    <div class="content-module">
        <div class="module-title">
            <h3><?php echo $cat ? htmlspecialchars($cat['name']) : '#' . $mid; ?></h3>
            <?php if ($cat): ?><a href="<?php echo $cat['permalink']; ?>">更多&gt;&gt;</a><?php endif; ?>
        </div>
        <div class="info-grid">
            <?php foreach ($policyPosts as $post): ?>
            <div class="info-card">
                <h4><a href="<?php echo $post['permalink']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h4>
                <p><?php echo htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?: $post['content']), 0, 120)); ?></p>
            </div>
            <?php endforeach; ?>
            <?php if (empty($policyPosts)): ?>
            <p style="color:#999;padding:10px;">暂无文章</p>
            <?php endif; ?>
        </div>
    </div>
    <?php
        endforeach;
    endif;
    ?>
</main>

<?php $this->need('footer.php'); ?>