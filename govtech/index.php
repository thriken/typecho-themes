<?php
/**
 * 科技新闻
 * 政务科技风格Typecho主题，简洁蓝色科技配色，支持多屏幕自适应
 * License MIT License
 * @package GovTech
 * @author Thriken
 * @version 1.0.0
 * @link https://elec.top
 */
$this->need('header.php'); ?>

<!-- 主体布局 -->
<div class="layout-wrapper">
    <div class="main-content-area">
        <div class="container">
            <div class="layout-grid">

                <!-- 主内容区 -->
                <main class="main-column" role="main" id="main-content">

                    <!-- 顶部轮播/要闻区（首页） -->
                    <?php if ($this->is('index')): ?>
                    <div class="featured-section">
                        <div class="featured-section__header">
                            <span class="section-label">最新要闻</span>
                        </div>
                        <div class="featured-posts">
                            <?php \Widget\Contents\Post\Recent::alloc('pageSize=5')->to($featured); ?>
                            <?php $i = 0; while ($featured->next()): $i++; ?>
                            <?php if ($i === 1): ?>
                            <div class="featured-posts__primary">
                                <a href="<?php $featured->permalink(); ?>" class="featured-posts__link">
                                    <?php if ($featured->fields->thumb): ?>
                                        <div class="featured-posts__thumb">
                                            <img src="<?php echo $featured->fields->thumb; ?>" alt="<?php $featured->title(); ?>" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <div class="featured-posts__info">
                                        <span class="featured-posts__badge">头条</span>
                                        <h2 class="featured-posts__title"><?php $featured->title(); ?></h2>
                                        <p class="featured-posts__excerpt"><?php $featured->excerpt(120, '...'); ?></p>
                                        <time class="featured-posts__date" datetime="<?php $featured->date('c'); ?>"><?php $featured->date('Y-m-d'); ?></time>
                                    </div>
                                </a>
                            </div>
                            <?php else: ?>
                            <?php if ($i === 2): ?><ul class="featured-posts__secondary"><?php endif; ?>
                            <li class="featured-posts__side-item">
                                <a href="<?php $featured->permalink(); ?>" class="featured-posts__side-link">
                                    <span class="featured-posts__side-badge">要闻</span>
                                    <span class="featured-posts__side-title"><?php $featured->title(); ?></span>
                                    <time class="featured-posts__side-date"><?php $featured->date('m-d'); ?></time>
                                </a>
                            </li>
                            <?php if ($i === 5): ?></ul><?php endif; ?>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- 文章列表 -->
                    <div class="post-feed">
                        <?php if ($this->have()): ?>

                        <?php while ($this->next()): ?>
                        <article class="post-card" itemscope itemtype="https://schema.org/Article">
                            <div class="post-card__inner">

                                <!-- 分类标签 -->
                                <?php if (is_array($this->categories) && count($this->categories) > 0): ?>
                                <div class="post-card__cats">
                                    <?php $this->category(', '); ?>
                                </div>
                                <?php endif; ?>

                                <!-- 标题 -->
                                <h2 class="post-card__title" itemprop="headline">
                                    <a href="<?php $this->permalink(); ?>" class="post-card__title-link" itemprop="url"><?php $this->title(); ?></a>
                                </h2>

                                <!-- 摘要 -->
                                <p class="post-card__excerpt" itemprop="description"><?php $this->excerpt(200, '...'); ?></p>

                                <!-- 元信息 -->
                                <footer class="post-card__meta">
                                    <span class="post-meta__item post-meta__date">
                                        <svg viewBox="0 0 20 20" width="13" height="13" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1zm0 5a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H6z" clip-rule="evenodd"/></svg>
                                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d'); ?></time>
                                    </span>
                                    <span class="post-meta__item post-meta__author">
                                        <svg viewBox="0 0 20 20" width="13" height="13" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-7 9a7 7 0 1 1 14 0H3z" clip-rule="evenodd"/></svg>
                                        <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                                            <span itemprop="name"><?php $this->author->screenName(); ?></span>
                                        </span>
                                    </span>
                                    <span class="post-meta__item post-meta__comments">
                                        <svg viewBox="0 0 20 20" width="13" height="13" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 0 1-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg>
                                        <?php $this->commentsNum('0 条评论', '1 条评论', '%d 条评论'); ?>
                                    </span>
                                    <a href="<?php $this->permalink(); ?>" class="post-card__readmore">阅读全文 →</a>
                                </footer>
                            </div>
                        </article>
                        <?php endwhile; ?>

                        <!-- 分页 -->
                        <nav class="pagination" role="navigation" aria-label="文章分页">
                            <?php $this->pageNav('<span class="pagination__prev">« 上一页</span>', '<span class="pagination__next">下一页 »</span>', 5, '...', array(
                                'wrapTag'   => 'ul',
                                'wrapClass' => 'pagination__list',
                                'itemTag'   => 'li',
                                'currentClass' => 'is-current',
                                'prevClass' => 'pagination__item--prev',
                                'nextClass' => 'pagination__item--next',
                            )); ?>
                        </nav>

                        <?php else: ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 64 64" width="56" height="56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="32" cy="32" r="30" stroke="#93c5fd" stroke-width="2"/>
                                <path d="M22 27h20M22 33h14" stroke="#93c5fd" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <p>暂无文章内容</p>
                        </div>
                        <?php endif; ?>
                    </div>

                </main><!-- /.main-column -->

                <!-- 侧边栏 -->
                <?php $this->need('sidebar.php'); ?>

            </div><!-- /.layout-grid -->
        </div><!-- /.container -->
    </div>

<?php $this->need('footer.php'); ?>
