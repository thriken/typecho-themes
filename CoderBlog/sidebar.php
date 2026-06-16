<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!-- 侧边栏 -->
<aside class="w-full lg:w-80 flex-shrink-0">
    <div class="space-y-8 lg:sticky lg:top-20">
        <?php $sidebarBlocks = $this->options->sidebarBlocks ?: ['ShowSearch','ShowCategory','ShowRecentPost','ShowTag','ShowArchive']; ?>

        <?php if (in_array('ShowSearch', $sidebarBlocks)): ?>
        <!-- 搜索 -->
        <div class="card p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">搜索</h3>
            <form method="get" action="<?php $this->options->siteUrl(); ?>" class="relative">
                <input type="text" name="s" placeholder="输入关键词..." class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition text-gray-800 dark:text-gray-200 text-sm">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-sky-600">
                    <i class="fas fa-search text-sm"></i>
                </button>
            </form>
        </div>
        <?php endif; ?>

        <?php if (in_array('ShowCategory', $sidebarBlocks)): ?>
        <!-- 分类目录 -->
        <div class="card p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">分类目录</h3>
            <ul class="space-y-1">
                <?php $this->widget('Widget_Metas_Category_List')->to($sbCats); ?>
                <?php while($sbCats->next()): ?>
                <li>
                    <a href="<?php $sbCats->permalink(); ?>" class="flex items-center justify-between py-1.5 text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition text-sm">
                        <span><?php $sbCats->name(); ?></span>
                        <span class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full"><?php $sbCats->count(); ?></span>
                    </a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (in_array('ShowRecentPost', $sidebarBlocks)): ?>
        <!-- 最新文章 -->
        <div class="card p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">最新文章</h3>
            <ul class="space-y-3">
                <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=5')->to($sbRecent); ?>
                <?php while($sbRecent->next()): ?>
                <li>
                    <a href="<?php $sbRecent->permalink(); ?>" class="block text-sm text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition line-clamp-2">
                        <?php $sbRecent->title(); ?>
                    </a>
                    <span class="text-xs text-gray-400 dark:text-gray-500"><?php $sbRecent->date('Y-m-d'); ?></span>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (in_array('ShowTag', $sidebarBlocks)): ?>
        <!-- 标签云 -->
        <div class="card p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">标签云</h3>
            <div class="flex flex-wrap gap-2">
                <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=20')->to($sbTags); ?>
                <?php while($sbTags->next()): ?>
                <a href="<?php $sbTags->permalink(); ?>" class="tag bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300 hover:bg-sky-200 dark:hover:bg-sky-900/50 text-xs">
                    <?php $sbTags->name(); ?>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (in_array('ShowArchive', $sidebarBlocks)): ?>
        <!-- 文章归档 -->
        <div class="card p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">文章归档</h3>
            <ul class="space-y-1">
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y年m月&limit=12')->to($sbArchive); ?>
                <?php while($sbArchive->next()): ?>
                <li>
                    <a href="<?php $sbArchive->permalink(); ?>" class="flex items-center justify-between py-1.5 text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition text-sm">
                        <span><?php $sbArchive->date('Y年m月'); ?></span>
                        <span class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full"><?php $sbArchive->count(); ?></span>
                    </a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</aside>
