<?php
/**
 * 基于 nxtrace.org 风格设计的 Typecho 主题，推荐搭配LightBox插件
 * 特点：
 * - 响应式布局，支持移动端
 * - 深色/浅色模式切换
 * - 简洁现代的卡片式设计
 * - 首页双栏布局（文章+侧边栏模块）
 * 
 * @package NewProj
 * @author NextTrace Team
 * @version 1.1.0
 * @link https://blog.elec.top
 *
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <?php $heroType = $this->options->heroType ?: 'post'; ?>
        <?php if ($heroType == 'project' && $this->options->heroProjectName): ?>
        <!-- ===== 开源项目推介模式 ===== -->
        <div class="hero-content">
            <h1 class="hero-title"><?php echo $this->options->heroProjectName; ?></h1>
            <p class="hero-subtitle"><?php echo $this->options->heroProjectDesc; ?></p>
            <div class="hero-actions">
                <?php if ($this->options->heroBtn1Text && $this->options->heroBtn1Url): ?>
                <a href="<?php echo $this->options->heroBtn1Url; ?>" class="btn-primary" target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    <?php echo $this->options->heroBtn1Text; ?>
                </a>
                <?php endif; ?>
                <?php if ($this->options->heroBtn2Text && $this->options->heroBtn2Url): ?>
                <a href="<?php echo $this->options->heroBtn2Url; ?>" class="btn-outline" target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    <?php echo $this->options->heroBtn2Text; ?>
                </a>
                <?php endif; ?>
            </div>
            <?php if ($this->options->heroPlatforms): ?>
            <div class="platform-icons">
                <?php $platforms = array_map('trim', explode(',', $this->options->heroPlatforms)); ?>
                <?php foreach ($platforms as $p): ?>
                <span class="platform-icon" title="<?php echo $p; ?>">
                    <?php if (stripos($p, 'Windows') !== false): ?>
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.9-1.801"/></svg>
                    <?php elseif (stripos($p, 'Linux') !== false): ?>
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.504 0c-.155 0-.315.008-.48.021-4.226.333-3.105 4.807-3.17 6.298-.076 1.092-.3 1.953-1.05 3.02-.885 1.051-2.127 2.75-2.716 4.521-.278.832-.41 1.684-.287 2.489a.424.424 0 00-.11.135c-.26.268-.45.6-.663.839-.199.199-.485.267-.797.4-.313.136-.658.269-.864.68-.09.189-.136.394-.132.602 0 .199.027.4.055.536.058.399.116.728.04.97-.249.68-.28 1.145-.106 1.484.174.334.535.47.94.601.81.2 1.91.135 2.774.6.926.466 1.866.67 2.616.47.526-.116.97-.464 1.208-.946.587-.003 1.23-.269 2.26-.334.699-.058 1.574.267 2.577.2.025.134.063.198.114.333l.003.003c.391.778 1.113 1.132 1.884 1.071.771-.06 1.592-.536 2.257-1.306.631-.765 1.683-1.084 2.378-1.503.348-.199.629-.469.649-.853.023-.4-.2-.811-.714-1.376v-.097l-.003-.003c-.17-.2-.25-.535-.338-.926-.085-.401-.182-.786-.492-1.046h-.003c-.059-.054-.123-.067-.188-.135a.357.357 0 00-.19-.064c.431-1.278.264-2.55-.173-3.694-.533-1.41-1.465-2.638-2.175-3.483-.796-1.005-1.576-1.957-1.56-3.368.026-2.152.236-6.133-3.544-6.139zm.529 3.405h.013c.213 0 .396.062.584.198.19.135.33.332.438.533.105.259.158.459.166.724 0-.02.006-.04.006-.06v.105a.086.086 0 01-.004-.021l-.004-.024a1.807 1.807 0 01-.15.706.953.953 0 01-.213.335.71.71 0 00-.088-.042c-.104-.045-.198-.064-.284-.133a1.312 1.312 0 00-.22-.066c.05-.06.146-.133.183-.198.053-.128.082-.264.088-.402v-.02a1.21 1.21 0 00-.061-.4c-.045-.134-.101-.2-.183-.333-.084-.066-.167-.132-.267-.132h-.016c-.093 0-.176.03-.262.132a.8.8 0 00-.205.334 1.18 1.18 0 00-.09.41v.019c.002.089.008.179.037.268.027.15.074.266.137.397.063.132.134.2.233.333.098.13.197.2.296.264-.11.047-.21.1-.296.165-.09.065-.166.133-.233.2-.065.066-.13.165-.196.265-.066.1-.13.233-.163.365-.033.133-.066.3-.066.465 0 .2.033.367.1.533.066.167.166.3.266.4.1.1.233.166.366.233.133.066.3.1.466.1.2 0 .367-.034.533-.1.167-.067.3-.134.4-.234.1-.1.166-.233.233-.4.067-.166.1-.333.1-.533 0-.165-.033-.332-.066-.465-.034-.132-.098-.265-.164-.365a1.619 1.619 0 00-.233-.265 1.217 1.217 0 00-.296-.165c.1-.065.198-.134.296-.265.1-.132.17-.2.233-.332.063-.133.11-.249.137-.4a1.18 1.18 0 00.037-.267v-.02a1.2 1.2 0 00-.09-.41.8.8 0 00-.205-.333c-.086-.102-.17-.132-.262-.132h-.016z"/></svg>
                    <?php elseif (stripos($p, 'mac') !== false || stripos($p, 'macOS') !== false): ?>
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                    <?php else: ?>
                    <span style="font-size:0.75rem;font-weight:600;color:var(--color-text-muted)"><?php echo mb_substr($p, 0, 1); ?></span>
                    <?php endif; ?>
                </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($this->options->heroProjectImage): ?>
        <div class="hero-demo">
            <div class="hero-project-image">
                <img src="<?php echo $this->options->heroProjectImage; ?>" alt="<?php echo $this->options->heroProjectName; ?>">
            </div>
        </div>
        <?php endif; ?>

        <?php elseif ($heroType == 'post' && $this->options->heroPostId): ?>
        <!-- ===== 置顶文章推荐模式 ===== -->
        <?php $heroData = getHeroPostData(intval($this->options->heroPostId)); ?>
        <?php if ($heroData): ?>
        <?php $heroPost = $heroData['post']; ?>
        <div class="hero-content">
            <h1 class="hero-title"><a href="<?php echo $heroData['permalink']; ?>" style="color:inherit;text-decoration:none;"><?php echo $heroPost['title']; ?></a></h1>
            <?php if ($heroData['category']): ?>
            <p class="hero-subtitle" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <span class="category" style="background:var(--color-primary);color:#fff;padding:2px 10px;border-radius:20px;font-size:0.8rem;"><?php echo $heroData['category']; ?></span>
                <span style="color:var(--color-text-muted);font-size:0.85rem;"><?php echo date('Y-m-d', $heroPost['created']); ?></span>
            </p>
            <?php endif; ?>
            <p class="hero-subtitle"><?php echo np_excerpt($heroPost['text'], 100); ?></p>
            <div class="hero-actions">
                <a href="<?php echo $heroData['permalink']; ?>" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    阅读全文
                </a>
            </div>
        </div>
        <?php if ($heroData['thumb']): ?>
        <div class="hero-demo">
            <div class="hero-project-image">
                <img src="<?php echo $heroData['thumb']; ?>" alt="<?php echo $heroPost['title']; ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php else: ?>
        <!-- 文章不存在，回退显示站点信息 -->
        <div class="hero-content">
            <h1 class="hero-title"><?php $this->options->title(); ?></h1>
            <p class="hero-subtitle"><?php $this->options->description(); ?></p>
        </div>
        <?php endif; ?>
        <?php else: ?>
        <!-- ===== 默认：站点信息 ===== -->
        <div class="hero-content">
            <h1 class="hero-title"><?php $this->options->title(); ?></h1>
            <p class="hero-subtitle"><?php $this->options->description(); ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Latest Posts Section with Sidebar -->
<section class="article-list-section">
    <div class="container">
        <?php if ($this->options->indexSidebar != 'hide'): ?>
        <div class="article-list-layout">
        <?php else: ?>
        <div class="article-list-layout article-list-fullwidth">
        <?php endif; ?>
            <!-- Main Content: Latest Articles -->
            <div class="article-list">
                <h2 class="section-title" style="text-align:left; margin-bottom: 24px;">最新文章</h2>
                <?php if ($this->have()): ?>
                    <?php while($this->next()): ?>
                    <article class="article-item" itemscope itemtype="https://schema.org/Article">
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
                            <h2 class="article-title">
                                <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                            </h2>
                            <p class="article-excerpt"><?php echo np_excerpt($this->text, 120); ?></p>
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
                        <p>暂无文章</p>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <nav class="pagination">
                    <?php $this->pageNav('&laquo; 上一页', '下一页 &raquo;'); ?>
                </nav>
            </div>

            <!-- Sidebar Widgets -->
            <?php if ($this->options->indexSidebar != 'hide'): ?>
            <aside class="sidebar">
                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
                <!-- Categories Widget -->
                <div class="widget">
                    <h3 class="widget-title">分类目录</h3>
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
                    <h3 class="widget-title">最新文章</h3>
                    <ul class="widget-list widget-recent-list">
                        <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=5')->to($recent); ?>
                        <?php while($recent->next()): ?>
                        <li>
                            <a href="<?php $recent->permalink(); ?>">
                                <span class="recent-title"><?php $recent->title(); ?></span>
                                <span class="recent-date"><?php $recent->date('m-d'); ?></span>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowTag', $this->options->sidebarBlock)): ?>
                <!-- Tags Widget -->
                <div class="widget">
                    <h3 class="widget-title">标签云</h3>
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

                <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
                <!-- Other Widget -->
                <div class="widget">
                    <h3 class="widget-title">其它</h3>
                    <ul class="widget-list">
                        <?php if($this->user->hasLogin()): ?>
                        <li><a href="<?php $this->options->adminUrl(); ?>">后台管理</a></li>
                        <li><a href="<?php $this->options->logoutUrl(); ?>">退出登录</a></li>
                        <?php else: ?>
                        <li><a href="<?php $this->options->adminUrl('login.php'); ?>">登录</a></li>
                        <?php endif; ?>
                        <li><a href="<?php $this->options->feedUrl(); ?>">文章 RSS</a></li>
                        <li><a href="<?php $this->options->commentsFeedUrl(); ?>">评论 RSS</a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $this->need('footer.php'); ?>
