<?php
/**
 * CoderBlog - 程序员博客主题
 * > 平台：Typecho 1.3 | PHP 7.4 ~ 8.4 | UI：Tailwind CSS + Font Awesome
 * 面向开发者与极客的双栏博客主题，支持代码高亮、短代码、暗色模式，推荐搭配LightBox插件
 * <a href="" _target="blank">查看文档</a>
 * @package CoderBlog
 * @author thriken
 * @version 1.0
 * @link https://blog.elec.top/
 */
 
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- 首页内容 -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero 区域 -->
    <div class="text-center mb-12 animate-fade-in">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-sky-600 to-sky-800 dark:from-sky-400 dark:to-sky-200">
            <?php if ($this->options->heroTitle): ?>
            <?php $this->options->heroTitle(); ?>
            <?php else: ?>
            发现精彩内容
            <?php endif; ?>
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            <?php if ($this->options->heroDesc): ?>
            <?php $this->options->heroDesc(); ?>
            <?php else: ?>
            <?php $this->options->description(); ?>
            <?php endif; ?>
        </p>
    </div>

    <!-- 最新文章 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        <?php if ($this->have()): ?>
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
        <?php else: ?>
        <!-- 无文章时 -->
        <div class="col-span-full">
            <div class="card p-12 text-center">
                <div class="text-6xl text-gray-300 dark:text-gray-600 mb-4"><i class="far fa-file-alt"></i></div>
                <h2 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">暂无文章</h2>
                <p class="text-gray-400 dark:text-gray-500">还没有发布任何文章。</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- 分页 -->
    <?php if ($this->have()): ?>
    <div class="flex justify-center mb-16">
        <div class="flex space-x-2">
            <?php $this->pageLink('<span class="btn btn-outline text-sm"><i class="fas fa-chevron-left mr-1"></i>上一页</span>'); ?>
            <?php $this->pageLink('<span class="btn btn-outline text-sm">下一页<i class="fas fa-chevron-right ml-1"></i></span>', 'next'); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->options->indexShowCategories != 'hide'): ?>
    <!-- 分类展示 -->
    <div class="mb-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">热门分类</h2>
        </div>
        <?php $this->widget('Widget_Metas_Category_List')->to($homeCats); ?>
        <?php if ($homeCats->have()): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php $catIcons = ['fa-code','fa-paint-brush','fa-server','fa-robot','fa-mobile-alt','fa-cogs','fa-database','fa-shield-alt','fa-globe','fa-cube']; $ci = 0; ?>
            <?php while($homeCats->next()): ?>
            <?php $colorClass = cbCategoryColor($homeCats->slug); ?>
            <a href="<?php $homeCats->permalink(); ?>" class="card p-5 text-center hover:scale-[1.02] transition-transform">
                <div class="w-12 h-12 mx-auto mb-3 bg-<?php echo $colorClass; ?>-100 dark:bg-<?php echo $colorClass; ?>-900/30 rounded-xl flex items-center justify-center text-<?php echo $colorClass; ?>-600 dark:text-<?php echo $colorClass; ?>-400">
                    <i class="fas <?php echo $catIcons[$ci % count($catIcons)]; ?> text-xl"></i>
                </div>
                <h3 class="font-medium mb-1 text-gray-800 dark:text-gray-200"><?php $homeCats->name(); ?></h3>
                <span class="text-sm text-gray-500 dark:text-gray-400"><?php $homeCats->count(); ?> 篇文章</span>
            </a>
            <?php $ci++; endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($this->options->indexShowTags != 'hide'): ?>
    <!-- 标签云 -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">热门标签</h2>
        </div>
        <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=20')->to($homeTags); ?>
        <?php if ($homeTags->have()): ?>
        <div class="flex flex-wrap gap-2">
            <?php $tagColors = ['primary','blue','purple','green','indigo','cyan','violet','pink','amber','red','emerald','lime']; $ti = 0; ?>
            <?php while($homeTags->next()): ?>
            <?php $tc = $tagColors[$ti % count($tagColors)]; ?>
            <a href="<?php $homeTags->permalink(); ?>" class="tag bg-<?php echo $tc; ?>-100 text-<?php echo $tc; ?>-800 dark:bg-<?php echo $tc; ?>-900/30 dark:text-<?php echo $tc; ?>-300 hover:bg-<?php echo $tc; ?>-200 dark:hover:bg-<?php echo $tc; ?>-900/50">
                <?php $homeTags->name(); ?>
            </a>
            <?php $ti++; endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</section>

<?php $this->need('footer.php'); ?>
