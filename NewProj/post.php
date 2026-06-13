<?php
/**
 * 文章详情页模板
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php $this->title(); ?></h1>
        <p style="margin-top: 12px; color: var(--color-text-secondary);">
            <span><?php $this->date('Y-m-d'); ?></span>
            <span style="margin: 0 8px;">·</span>
            <span><?php $this->category(','); ?></span>
            <span style="margin: 0 8px;">·</span>
            <span><?php $this->author(); ?></span>
        </p>
    </div>
</section>

<!-- Article Content Section -->
<section class="article-list-section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a>
            <span class="breadcrumb-sep">/</span>
            <?php $this->category(','); ?>
            <span class="breadcrumb-sep">/</span>
            <span><?php $this->title(); ?></span>
        </nav>

        <div class="article-list-layout">
            <!-- Main Content -->
            <article class="post-article" style="background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-lg);">
                <div class="post-content">
                    <?php $this->content(); ?>
                </div>

                <!-- Tags -->
                <?php if ($this->tags): ?>
                <div style="margin-top: 40px; padding-top: 24px; border-top: 1px solid var(--color-border);">
                    <div class="tag-cloud">
                        <?php $this->tags(' ', true, ''); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Post Navigation -->
                <div style="margin-top: 40px; padding-top: 24px; border-top: 1px solid var(--color-border); display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div>
                        <?php $this->thePrev('上一篇：%s', ''); ?>
                    </div>
                    <div style="text-align: right;">
                        <?php $this->theNext('下一篇：%s', ''); ?>
                    </div>
                </div>

                <!-- Comments -->
                <?php $this->need('comments.php'); ?>
            </article>

            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Author Widget -->
                <div class="widget">
                    <h3 class="widget-title">关于作者</h3>
                    <div style="text-align: center;">
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #3B82F6, #8B5CF6); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700; margin: 0 auto 12px;">
                            <?php echo mb_substr($this->author->screenName, 0, 1, 'UTF-8'); ?>
                        </div>
                        <h4 style="font-weight: 600;"><?php $this->author(); ?></h4>
                        <p style="font-size: 0.85rem; color: var(--color-text-secondary); margin-top: 4px;"><?php $this->author->mail(); ?></p>
                    </div>
                </div>

                <!-- Related Posts -->
                <div class="widget">
                    <h3 class="widget-title">相关文章</h3>
                    <ul class="widget-list">
                        <?php $this->related(5)->to($related); ?>
                        <?php if ($related->have()): ?>
                            <?php while($related->next()): ?>
                            <li><a href="<?php $related->permalink(); ?>"><?php $related->title(); ?></a></li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li style="color: var(--color-text-muted);">暂无相关文章</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php $this->need('footer.php'); ?>
