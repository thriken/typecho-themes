<?php
/**
 * CoderBlog - 404 页面
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="text-center">
        <h1 class="text-8xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-sky-600 to-sky-800 dark:from-sky-400 dark:to-sky-200 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">页面未找到</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            您访问的页面不存在或已被移除。请检查链接是否正确，或返回首页继续浏览。
        </p>
        <a href="<?php $this->options->siteUrl(); ?>" class="btn btn-primary inline-flex items-center">
            <i class="fas fa-home mr-2"></i>返回首页
        </a>
    </div>
</section>

<?php $this->need('footer.php'); ?>
