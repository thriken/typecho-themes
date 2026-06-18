<!-- category.php 分类页 -->
<?php
/**
 * CoderBlog - 分类页 / 标签页 / 搜索页
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- 主内容区 -->
        <div class="flex-1 min-w-0">
            <!-- 归档标题 -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php if ($this->is('category')): ?>
                        <i class="fas fa-folder mr-2 text-sky-500"></i>分类：<?php $this->archiveTitle('','',''); ?>
                    <?php elseif ($this->is('tag')): ?>
                        <i class="fas fa-tag mr-2 text-sky-500"></i>标签：<?php $this->archiveTitle('','',''); ?>
                    <?php elseif ($this->is('search')): ?>
                        <i class="fas fa-search mr-2 text-sky-500"></i>搜索：<?php echo htmlspecialchars($this->request->s); ?>
                    <?php else: ?>
                        <i class="fas fa-box mr-2 text-sky-500"></i><?php $this->archiveTitle('','',''); ?>
                    <?php endif; ?>
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">共 <?php echo $this->getTotal(); ?> 篇文章</p>
            </div>

            <?php if ($this->have()): ?>
            <!-- 文章列表 -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <?php $delay = 0; while($this->next()): $delay += 100; ?>
                <article class="card group animate-slide-up" style="animation-delay: <?php echo $delay; ?>ms">
                    <a href="<?php $this->permalink(); ?>" class="block">
                        <?php $thumb = cbThumbnail($this, 'random'); ?>
                        <?php $isEncrypted = !empty($this->password); ?>
                        <?php $hasRealImg  = $isEncrypted && cbHasRealThumbnail($this); ?>
                        <!-- 封面图（始终显示） -->
                        <div class="relative overflow-hidden rounded-t-xl">
                            <img src="<?php echo htmlspecialchars($thumb); ?>"
                                 alt="<?php $this->title(); ?>"
                                 class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-105<?php if ($hasRealImg): ?> blur-xl scale-110<?php endif; ?>"
                                 loading="lazy">
                            <?php if ($hasRealImg): ?>
                            <!-- 加密遮罩 -->
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <span class="text-white text-3xl font-extrabold tracking-[0.3em] drop-shadow-[0_2px_8px_rgba(0,0,0,0.6)] select-none">加密</span>
                            </div>
                            <?php endif; ?>
                            <!-- 标题遮罩层 -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-5">
                                <h2 class="text-lg font-bold text-white line-clamp-2 leading-snug">
                                    <?php $this->title(); ?>
                                </h2>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <?php $cat = cbPrimaryCategory($this); ?>
                                <span class="tag bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300 text-xs whitespace-nowrap max-w-[120px] truncate"><?php echo htmlspecialchars($cat['name']); ?></span>
                                <?php if (!empty($this->password)): ?>
                                <span class="inline-flex items-center gap-0.5 tag bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs" title="加密文章"><i class="fas fa-lock text-[10px]"></i></span>
                                <?php endif; ?>
                                <span class="text-xs text-gray-400 whitespace-nowrap"><i class="far fa-clock mr-1"></i><?php $this->date('Y-m-d'); ?></span>
                                <span class="text-xs text-gray-400 whitespace-nowrap"><i class="far fa-comment mr-1"></i><?php $this->commentsNum('0', '1', '%d'); ?></span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                <?php echo cbExcerpt($this->excerpt ?: $this->content, 100); ?>
                            </p>
                        </div>
                    </a>
                </article>
                <?php endwhile; ?>
            </div>

            <!-- 分页 -->
            <div class="flex justify-center">
                <?php $this->pageLink('<span class="btn btn-outline text-sm mr-2"><i class="fas fa-chevron-left mr-1"></i>上一页</span>'); ?>
                <?php $this->pageLink('<span class="btn btn-outline text-sm">下一页<i class="fas fa-chevron-right ml-1"></i></span>', 'next'); ?>
            </div>
            <?php else: ?>
            <div class="card p-12 text-center">
                <div class="text-6xl text-gray-300 dark:text-gray-600 mb-4"><i class="far fa-folder-open"></i></div>
                <h2 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">暂无内容</h2>
                <p class="text-gray-400 dark:text-gray-500 mb-6">
                    <?php if ($this->is('search')): ?>
                    没有找到与 "<?php echo htmlspecialchars($this->request->s); ?>" 相关的文章。
                    <?php else: ?>
                    该分类下暂无文章。
                    <?php endif; ?>
                </p>
                <a href="<?php $this->options->siteUrl(); ?>" class="btn btn-primary text-sm">返回首页</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- 侧边栏 -->
        <?php $this->need('sidebar.php'); ?>
    </div>
</section>

<?php $this->need('footer.php'); ?>
