<?php $this->need('header.php'); ?>

<div class="layout-wrapper">
    <div class="main-content-area">
        <div class="container">
            <div class="layout-grid">
                <main class="main-column" role="main" id="main-content">
                    <div class="post-feed">
                        <?php if ($this->have()): ?>
                        <?php while ($this->next()): ?>
                        <article class="post-card">
                            <div class="post-card__inner">
                                <?php if (is_array($this->categories) && count($this->categories) > 0): ?>
                                <div class="post-card__cats">
                                    <?php $this->category(', '); ?>
                                </div>
                                <?php endif; ?>
                                <h2 class="post-card__title">
                                    <a href="<?php $this->permalink(); ?>" class="post-card__title-link"><?php $this->title(); ?></a>
                                </h2>
                                <p class="post-card__excerpt"><?php $this->excerpt(200, '...'); ?></p>
                                <footer class="post-card__meta">
                                    <span class="post-meta__item post-meta__date">
                                        <svg viewBox="0 0 20 20" width="13" height="13" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1zm0 5a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H6z" clip-rule="evenodd"/></svg>
                                        <time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y-m-d'); ?></time>
                                    </span>
                                    <a href="<?php $this->permalink(); ?>" class="post-card__readmore">阅读全文 →</a>
                                </footer>
                            </div>
                        </article>
                        <?php endwhile; ?>
                        <nav class="pagination" role="navigation" aria-label="文章分页">
                            <?php $this->pageNav('<span class="pagination__prev">« 上一页</span>', '<span class="pagination__next">下一页 »</span>', 5, '...', array(
                                'wrapTag' => 'ul', 'wrapClass' => 'pagination__list', 'itemTag' => 'li', 'currentClass' => 'is-current',
                            )); ?>
                        </nav>
                        <?php else: ?>
                        <div class="empty-state"><p>该分类下暂无文章。</p></div>
                        <?php endif; ?>
                    </div>
                </main>
                <?php $this->need('sidebar.php'); ?>
            </div>
        </div>
    </div>
<?php $this->need('footer.php'); ?>
