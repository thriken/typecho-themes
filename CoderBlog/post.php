<?php
/**
 * CoderBlog - 文章详情页
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
                <?php $breadCat = cbPrimaryCategory($this); ?>
                <a href="<?php echo $breadCat['permalink']; ?>" class="hover:text-sky-600 dark:hover:text-sky-400 transition"><?php echo $breadCat['name']; ?></a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-400 dark:text-gray-500">正文</span>
            </nav>
            <?php endif; ?>

            <!-- 文章头部 -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php $this->title(); ?>
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <span><i class="far fa-calendar mr-1"></i> <?php $this->date('Y-m-d'); ?></span>
                    <span><i class="far fa-folder mr-1"></i> <?php $this->category(','); ?></span>
                    <span><i class="far fa-user mr-1"></i> <?php $this->author(); ?></span>
                    <span><i class="far fa-comment mr-1"></i> <?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></span>
                </div>
            </div>

            <?php if (cbThumbnail($this) && !$this->is('page')): ?>
            <!-- 题图 -->
            <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                <img src="<?php echo htmlspecialchars(cbThumbnail($this)); ?>"
                     alt="<?php $this->title(); ?>"
                     class="w-full max-h-96 object-cover"
                     loading="lazy">
            </div>
            <?php endif; ?>

            <!-- 文章内容 -->
            <div class="card p-6 md:p-8 mb-8">
                <div class="prose-content max-w-none">
                    <?php
                    // 模板层直接处理：短代码 → Markdown → 标题ID → 代码高亮
                    $_raw = $this->text;
                    $_raw = cbShortcode($_raw);
                    $_raw = \Utils\Markdown::convert($_raw);
                    $_raw = cbAddHeadingIds($_raw);
                    echo cbCodeHighlight($_raw);
                    ?>
                </div>
            </div>

            <!-- 标签 -->
            <?php if (count($this->tags) > 0): ?>
            <div class="flex flex-wrap items-center gap-2 mb-8">
                <span class="text-sm text-gray-500 dark:text-gray-400"><i class="fas fa-tags mr-1"></i>标签：</span>
                <?php foreach ($this->tags as $tag): ?>
                <a href="<?php echo $tag['permalink']; ?>" class="tag bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-xs">
                    <?php echo $tag['name']; ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- 上一篇/下一篇 -->
            <nav class="flex flex-col sm:flex-row justify-between gap-4 mb-8">
                <div class="flex-1">
                    <?php $this->thePrev('<span class="btn btn-outline text-sm block text-center"><i class="fas fa-arrow-left mr-2"></i>%s</span>', ''); ?>
                </div>
                <div class="flex-1 text-right">
                    <?php $this->theNext('<span class="btn btn-outline text-sm block text-center">%s<i class="fas fa-arrow-right ml-2"></i></span>', ''); ?>
                </div>
            </nav>

            <!-- 评论区 -->
            <div class="card p-6 md:p-8">
                <?php $this->need('comments.php'); ?>
            </div>
        </div>

        <!-- 侧边栏 -->
        <?php $this->need('sidebar.php'); ?>
    </div>
</article>

<?php $this->need('footer.php'); ?>
