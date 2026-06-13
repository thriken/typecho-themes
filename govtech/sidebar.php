<!-- 侧边栏 -->
<aside class="sidebar" role="complementary" aria-label="侧边栏">
    <!-- 公告 / 站点简介 -->
    <?php if ($this->options->sideNotice): ?>
    <div class="widget widget--notice">
        <div class="widget__header">
            <span class="widget__icon" aria-hidden="true">
                <svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M18 3a1 1 0 0 0-1.447-.894L8.763 6H5a3 3 0 0 0 0 6h.28l1.771 5.316A1 1 0 0 0 8 18h1a1 1 0 0 0 1-1v-4.382l6.553 3.276A1 1 0 0 0 18 15V3z" clip-rule="evenodd"/></svg>
            </span>
            <h3 class="widget__title">站点公告</h3>
        </div>
        <div class="widget__body widget__body--notice">
            <?php $this->options->sideNotice(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- 最新文章 -->
    <div class="widget">
        <div class="widget__header">
            <span class="widget__icon" aria-hidden="true">
                <svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M2 5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/><path d="M15 7h1a2 2 0 0 1 2 2v5.5a1.5 1.5 0 0 1-3 0V7z"/></svg>
            </span>
            <h3 class="widget__title">最新文章</h3>
        </div>
        <div class="widget__body">
            <ul class="post-list post-list--compact">
                <?php \Widget\Contents\Post\Recent::alloc('pageSize=8')->to($recent); ?>
                <?php while ($recent->next()): ?>
                <li class="post-list__item">
                    <span class="post-list__date"><?php $recent->date('m-d'); ?></span>
                    <a href="<?php $recent->permalink(); ?>" class="post-list__title" title="<?php $recent->title(); ?>"><?php $recent->title(); ?></a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <!-- 文章分类 -->
    <div class="widget">
        <div class="widget__header">
            <span class="widget__icon" aria-hidden="true">
                <svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path d="M7 3a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2H7zM4 7a1 1 0 0 1 1-1h10a1 1 0 1 1 0 2H5a1 1 0 0 1-1-1zM2 11a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-4z"/></svg>
            </span>
            <h3 class="widget__title">文章分类</h3>
        </div>
        <div class="widget__body">
            <ul class="category-list">
                <?php \Widget\Metas\Category\Rows::alloc()->to($cats); ?>
                <?php while ($cats->next()): ?>
                <li class="category-list__item" style="padding-left: <?php echo ($cats->levels - 1) * 14; ?>px">
                    <a href="<?php $cats->permalink(); ?>" class="category-list__link <?php if ($this->is('category', $cats->slug)): ?>is-active<?php endif; ?>">
                        <svg viewBox="0 0 20 20" width="12" height="12" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0z" clip-rule="evenodd"/></svg>
                        <?php $cats->name(); ?>
                    </a>
                    <span class="category-list__count"><?php $cats->count(); ?></span>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <!-- 标签云 -->
    <div class="widget">
        <div class="widget__header">
            <span class="widget__icon" aria-hidden="true">
                <svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 0 1 0 1.414l-7 7a1 1 0 0 1-1.414 0l-7-7A.997.997 0 0 1 2 10V5a3 3 0 0 1 3-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" clip-rule="evenodd"/></svg>
            </span>
            <h3 class="widget__title">文章标签</h3>
        </div>
        <div class="widget__body">
            <div class="tag-cloud">
                <?php \Widget\Metas\Tag\Cloud::alloc('sort=count&ignoreZeroCount=1&limit=30')->to($tags); ?>
                <?php while ($tags->next()): ?>
                    <a href="<?php $tags->permalink(); ?>" class="tag-cloud__item <?php if ($this->is('tag', $tags->slug)): ?>is-active<?php endif; ?>"><?php $tags->name(); ?></a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- 归档 -->
    <div class="widget">
        <div class="widget__header">
            <span class="widget__icon" aria-hidden="true">
                <svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path d="M9 2a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 0 1 2-2 3 3 0 0 0 3 3h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5zm3 4a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2H7zm3 0a1 1 0 0 0 0 2h3a1 1 0 0 0 0-2h-3zm-3 4a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2H7zm3 0a1 1 0 0 0 0 2h3a1 1 0 0 0 0-2h-3z" clip-rule="evenodd"/></svg>
            </span>
            <h3 class="widget__title">文章归档</h3>
        </div>
        <div class="widget__body">
            <ul class="archive-list">
                <?php \Widget\Contents\Post\Date::alloc('type=month&format=Y年m月&limit=12')->to($archives); ?>
                <?php while ($archives->next()): ?>
                <li class="archive-list__item">
                    <a href="<?php $archives->permalink(); ?>" class="archive-list__link">
                        <?php $archives->date(); ?>
                    </a>
                    <span class="archive-list__count">(<?php $archives->count(); ?>)</span>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

</aside>
