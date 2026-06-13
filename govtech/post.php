<?php $this->need('header.php'); ?>

<div class="layout-wrapper">
    <div class="main-content-area">
        <div class="container">
            <div class="layout-grid">

                <main class="main-column" role="main" id="main-content">

                    <?php while ($this->next()): ?>
                    <article class="article" itemscope itemtype="https://schema.org/Article">

                        <!-- 文章头部 -->
                        <header class="article__header">
                            <!-- 分类 -->
                            <?php if (is_array($this->categories) && count($this->categories) > 0): ?>
                            <div class="article__cats">
                                <?php $this->category(', '); ?>
                            </div>
                            <?php endif; ?>

                            <h1 class="article__title" itemprop="headline"><?php $this->title(); ?></h1>
                            
                            <!-- 元信息条 -->
                            <div class="article__meta">
                                <span class="post-meta__item">
                                    <svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1zm0 5a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H6z" clip-rule="evenodd"/></svg>
                                    发布：<time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y年m月d日'); ?></time>
                                </span>
                                <span class="post-meta__item">
                                    <svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-7 9a7 7 0 1 1 14 0H3z" clip-rule="evenodd"/></svg>
                                    作者：<span itemprop="author"><?php $this->author->screenName(); ?></span>
                                </span>
                                <span class="post-meta__item">
                                    <svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 0 1-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg>
                                    <?php $this->commentsNum('0 条评论', '1 条评论', '%d 条评论'); ?>
                                </span>
                                <?php if ($this->tags): ?>
                                <span class="post-meta__item post-meta__tags">
                                    <svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 0 1 0 1.414l-7 7a1 1 0 0 1-1.414 0l-7-7A.997.997 0 0 1 2 10V5a3 3 0 0 1 3-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" clip-rule="evenodd"/></svg>
                                    <?php $this->tags('<a href="{permalink}" class="article__tag">{name}</a>', true, '&nbsp;'); ?>
                                </span>
                                <?php endif; ?>
                                <?php 
                                if ($this->user->hasLogin()) {
                                        echo '<span class="post-meta__item"><a href="https://typecho.cn/admin/write-post.php?cid=' . $this->cid . '">编辑</a></span>';
                                }
                            ?>
                            </div>
                        </header>

                        <!-- 文章正文 -->
                        <div class="article__body" itemprop="articleBody">
                            <?php //$this->content(); ?>
                            <?php
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $replacement = '<a href="$1" data-fancybox="gallery" /><img src="$1" alt="'.$this->title.'" title="点击放大图片"></a>';
    $content = preg_replace($pattern, $replacement, $this->content);
    echo $content;
?>
                        </div>
                        
                        <?php if(isset($this->fields->DownloadUrl)): ?>
                        <!-- 下载区 -->
                        <div class="download-card">
                            <div class="download-card__header">
                                <div class="download-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                        <path d="M12 2a1 1 0 0 1 1 1v10.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 1 1 1.414-1.414L11 13.586V3a1 1 0 0 1 1-1z"/>
                                        <path d="M4 15a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-3a1 1 0 1 1 2 0v3a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-3a1 1 0 0 1 1-1z"/>
                                    </svg>
                                </div>
                                <div class="download-card__title">相关下载</div>
                                <span class="download-card__badge">外链</span>
                            </div>
                            <div class="download-card__body">
                                <div class="download-card__desc">此文章包含相关下载资源，请点击下方按钮下载，外部资源，谨慎使用，本站不承担任何责任！</div>
                                <div class="download-card__url">
                                        <?php 
                                            echo htmlspecialchars( $this->fields->DownloadUrl);
                                        ?>
                                </div>
                                <div class="download-card__actions">
                                    <a href="<?php echo $this->fields->DownloadUrl; ?>" class="download-card__btn download-card__btn--primary" target="_blank" rel="noopener noreferrer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg>
                                        立即下载
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- 文章底部 -->
                        <footer class="article__footer">
                            <!-- 上下篇 -->
                            <nav class="post-nav" aria-label="上下篇文章">
                                <div class="post-nav__prev">
                                    <?php $this->thePrev('<span class="post-nav__label">← 上一篇</span><span class="post-nav__title">%s</span>', ''); ?>
                                </div>
                                <div class="post-nav__next">
                                    <?php $this->theNext('<span class="post-nav__label">下一篇 →</span><span class="post-nav__title">%s</span>', ''); ?>
                                </div>
                            </nav>
                        </footer>
                    </article>
                    <?php 
                    $this->need('comment.php');
                endwhile; ?>
                </main>
                <?php $this->need('sidebar.php'); ?>
            </div>
        </div>
    </div>

<?php $this->need('footer.php'); ?>
