<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!-- 左侧浮动菜单 -->
<div id="cb-float-menu" class="hidden lg:flex flex-col items-center gap-2 fixed z-40" style="top: 50%; transform: translateY(-50%);">
    <a href="<?php $this->options->siteUrl(); ?>" title="返回首页" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md flex items-center justify-center hover:border-sky-400 hover:text-sky-500 dark:hover:border-sky-500 text-gray-500 dark:text-gray-400 transition-colors duration-200">
        <i class="fas fa-home text-sm"></i>
    </a>
    <a href="javascript:void(0);" id="cb-back-top" title="返回顶部" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md flex items-center justify-center hover:border-sky-400 hover:text-sky-500 dark:hover:border-sky-500 text-gray-500 dark:text-gray-400 transition-colors duration-200">
        <i class="fas fa-arrow-up text-sm"></i>
    </a>
    <?php if (!empty($tocHtml)): ?>
    <a href="javascript:void(0);" id="cb-toc-toggle" title="目录" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md flex items-center justify-center hover:border-sky-400 hover:text-sky-500 dark:hover:border-sky-500 text-gray-500 dark:text-gray-400 transition-colors duration-200">
        <i class="fas fa-list-ul text-sm"></i>
    </a>
    <?php endif; ?>

    <a href="javascript:void(0);" id="cb-to-bottom" title="文章底部" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md flex items-center justify-center hover:border-sky-400 hover:text-sky-500 dark:hover:border-sky-500 text-gray-500 dark:text-gray-400 transition-colors duration-200">
        <i class="fas fa-arrow-down text-sm"></i>
    </a>
        <a href="javascript:void(0);" id="cb-to-comments" title="评论区" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md flex items-center justify-center hover:border-sky-400 hover:text-sky-500 dark:hover:border-sky-500 text-gray-500 dark:text-gray-400 transition-colors duration-200">
        <i class="fas fa-comments text-sm"></i>
    </a>
</div>
