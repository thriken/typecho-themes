<?php
/**
 * CoderBlog - 独立页面
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- 主内容区 -->
        <div class="flex-1 min-w-0 relative">
            <?php $tocHtml = cbTocGenerate($this->text); ?>
            <?php include 'includes/float-menu.php'; ?>
            <?php include 'includes/toc-panel.php'; ?>

            <!-- 面包屑 -->
            <?php if ($this->options->breadcrumb != 'hide'): ?>
            <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
                <a href="<?php $this->options->siteUrl(); ?>" class="hover:text-sky-600 dark:hover:text-sky-400 transition">首页</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-400 dark:text-gray-500"><?php $this->title(); ?></span>
            </nav>
            <?php endif; ?>

            <!-- 页面标题 -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-8">
                <?php $this->title(); ?>
            </h1>

            <!-- 页面内容 -->
            <div class="card p-6 md:p-8 mb-8">
                <div class="prose-content max-w-none">
                    <?php
                    $_raw = $this->text;
                    $_raw = cbShortcode($_raw);
                    $_raw = \Utils\Markdown::convert($_raw);
                    $_raw = cbAddHeadingIds($_raw);
                    echo cbCodeHighlight($_raw);
                    ?>
                </div>
            </div>

            <!-- 评论区（如果页面允许评论） -->
            <?php if ($this->allow('comment')): ?>
            <div class="card p-6 md:p-8">
                <?php $this->need('comments.php'); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- 侧边栏 -->
        <?php $this->need('sidebar.php'); ?>
    </div>
</article>

<?php $this->need('footer.php'); ?>
