<?php
/**
 * CoderBlog - 归档页（按年月日）
 * 条目形式，无摘要
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- 主内容区 -->
        <div class="flex-1 min-w-0 lg:max-w-[calc(100%-320px)]">
            <!-- 归档标题 -->
            <?php 
            $archiveYear = intval(date('Y'));
            if (preg_match('#/(\d{4})(?:/\d{2})?(?:/\d{2})?/?$#', rtrim($_SERVER['REQUEST_URI'], '/'), $m)) {
                $archiveYear = intval($m[1]);
            }
            $baseUrl = rtrim($this->options->siteUrl, '/') . '/index.php';
            ?>
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        <i class="fas fa-archive mr-2 text-sky-500"></i><?php echo $archiveYear; ?>年文章归档
                    </h1>
                    <div class="flex items-center gap-2 text-sm">
                        <a href="<?php echo $baseUrl . '/' . ($archiveYear - 1) . '/'; ?>" 
                           class="text-gray-400 dark:text-gray-500 hover:text-sky-600 dark:hover:text-sky-400 transition px-2">
                            <i class="fas fa-chevron-left mr-1"></i><?php echo $archiveYear - 1; ?>
                        </a>
                        <span class="text-gray-300 dark:text-gray-600">|</span>
                        <a href="<?php echo $baseUrl . '/' . ($archiveYear + 1) . '/'; ?>" 
                           class="text-gray-400 dark:text-gray-500 hover:text-sky-600 dark:hover:text-sky-400 transition px-2">
                            <?php echo $archiveYear + 1; ?><i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">共 <?php echo $this->getTotal(); ?> 篇文章</p>
            </div>
            <?php if ($this->have()): ?>
            <?php 
            $currentYear = '';
            $currentMonth = '';
            while($this->next()): 
                $year  = date('Y', $this->created);
                $month = date('m', $this->created);
                $yearChanged  = ($year != $currentYear);
                $monthChanged = ($month != $currentMonth);
            ?>

            <?php if ($yearChanged): ?>
                <?php if ($currentYear): ?></div></div></div><?php endif; ?>
                <?php $currentYear = $year; $currentMonth = ''; ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b-2 border-sky-500 inline-block">
                    <a href="/<?php echo $year; ?>" >  
                    <?php echo $year; ?></a> 
                    </h2>
            <?php endif; ?>
            <?php if ($monthChanged): ?>
                <?php if ($currentMonth): ?></div></div><?php endif; ?>
                <?php $currentMonth = $month; ?>
                <div class="mb-4 ml-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <?php echo date('m月', $this->created); ?>
                    </h3>
                    <div class="space-y-1">
            <?php endif; ?>

            <!-- 归档条目 -->
            <div class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                <a href="<?php $this->permalink(); ?>" class="flex items-center gap-3 flex-1 min-w-0">
                    <span class="text-sm text-gray-400 dark:text-gray-500 w-10 text-right flex-shrink-0"><?php echo date('d', $this->created); ?></span>
                    <span class="text-gray-800 dark:text-gray-200 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors truncate flex-1 min-w-0"><?php $this->title(); ?></span>
                </a>
                <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0 ml-4 max-w-[150px] truncate">
                    <?php if (!empty($this->password)): ?><i class="fas fa-lock text-amber-500 mr-1" title="加密文章"></i><?php endif; ?>
                    <?php $this->category(','); ?>&emsp;
                    <?php $this->commentsNum('<i class="far fa-comment"></i> 0', '<i class="far fa-comment"></i> 1', '<i class="far fa-comment"></i> %d'); ?>
                </span>
            </div>

            <?php endwhile; ?>
            <?php if ($currentYear): ?></div></div></div><?php endif; ?>
            <?php else: ?>
            <div class="card p-12 text-center">
                <div class="text-6xl text-gray-300 dark:text-gray-600 mb-4"><i class="far fa-folder-open"></i></div>
                <h2 class="text-xl font-semibold text-gray-600 dark:text-gray-400">暂无文章</h2>
            </div>
            <?php endif; ?>
        </div>

        <!-- 侧边栏 -->
        <?php $this->need('sidebar.php'); ?>
    </div>
</section>

<?php $this->need('footer.php'); ?>
