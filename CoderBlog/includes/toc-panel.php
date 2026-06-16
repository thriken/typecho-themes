<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (empty($tocHtml)) return; ?>
<!-- 文章目录面板 -->
<div id="cb-toc-panel" class="hidden fixed z-50 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl py-3 px-1" style="max-height: 50vh; max-width: 260px; overflow-y: auto;">
    <div class="flex items-center justify-between px-3 pb-2 mb-2 border-b border-gray-100 dark:border-gray-700">
        <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">目录</span>
        <button id="cb-toc-close" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm leading-none">&times;</button>
    </div>
    <?php echo $tocHtml; ?>
</div>
