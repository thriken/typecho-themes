<?php
/**
 * 文章列表/归档页面模板
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php $this->archiveTitle(array(
            'category'  =>  _t('分类：%s'),
            'search'    =>  _t('搜索结果：%s'),
            'tag'       =>  _t('标签：%s'),
            'author'    =>  _t('作者：%s')
        ), '', ''); ?></h1>
        <p><?php echo $this->getDescription(); ?></p>
    </div>
</section>

<!-- Article List Section -->
<section class="article-list-section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a>
            <span class="breadcrumb-sep">/</span>
            <span><?php $this->archiveTitle('', '', ''); ?></span>
        </nav>

        <div class="article-list-layout">
            <!-- Main Content -->
            <div class="article-list">
                <?php if ($this->have()): ?>
                    <?php while($this->next()): ?>
                    <article class="article-item">
                        <?php if ($this->fields->thumb): ?>
                        <div class="article-thumb">
                            <img src="<?php $this->fields->thumb(); ?>" alt="<?php $this->title(); ?>">
                        </div>
                        <?php else: ?>
                        <div class="article-thumb">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <?php endif; ?>
                        <div class="article-content">
                            <div class="article-meta">
                                <span class="category">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                    <?php $this->category(','); ?>
                                </span>
                                <span><?php $this->date('Y-m-d'); ?></span>
                            </div>
                            <h2 class="article-title"><a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a></h2>
                            <p class="article-excerpt"><?php $this->excerpt(150, '...'); ?></p>
                            <div class="article-footer">
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                    <?php $this->commentsNum('0', '1', '%d'); ?>
                                </span>
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <?php echo getViewsNum($this->cid); ?>
                                </span>
                            </div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 60px 0; color: var(--color-text-secondary);">
                        <p>没有找到相关文章</p>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <nav class="pagination">
                    <?php $this->pageNav('&laquo; 上一页', '下一页 &raquo;'); ?>
                </nav>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
                <!-- Categories Widget -->
                <div class="widget">
                    <h3 class="widget-title">文章分类</h3>
                    <ul class="widget-list">
                        <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
                        <?php while($categories->next()): ?>
                        <li><a href="<?php $categories->permalink(); ?>"><?php $categories->name(); ?> <span class="count"><?php $categories->count(); ?></span></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
                <!-- Recent Posts Widget -->
                <div class="widget">
                    <h3 class="widget-title">最近文章</h3>
                    <ul class="widget-list">
                        <?php $this->widget('Widget_Contents_Post_Recent')->to($recent); ?>
                        <?php while($recent->next()): ?>
                        <li><a href="<?php $recent->permalink(); ?>"><?php $recent->title(); ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowTag', $this->options->sidebarBlock)): ?>
                <!-- Tags Widget -->
                <div class="widget">
                    <h3 class="widget-title">热门标签</h3>
                    <div class="tag-cloud">
                        <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=20')->to($tags); ?>
                        <?php while($tags->next()): ?>
                        <a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
                <!-- Archive Widget -->
                <div class="widget">
                    <h3 class="widget-title">文章归档</h3>
                    <ul class="widget-list">
                        <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y年m月')->to($archives); ?>
                        <?php while($archives->next()): ?>
                        <li><a href="<?php $archives->permalink(); ?>"><?php $archives->date(); ?> <span class="count"><?php $archives->count(); ?></span></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?php $this->need('footer.php'); ?>
