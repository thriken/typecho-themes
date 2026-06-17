<?php 
/**
 * 基于 sanoui 风格设计的 Typecho 主题，推荐搭配LightBox插件
 * 特点：
 * - 响应式布局，支持移动端
 * - 深色/浅色模式切换
 * - 简洁现代的卡片式设计
 * - 平滑的交互动画
 * - 首页双栏布局（文章+侧边栏模块）
 * 
 * @package SanBlog
 * @author thriken
 * @version 1.1.0
 * @link https://blog.elec.top
 *
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php $this->need('header.php'); ?>

<?php
$layout = sbGetLayout();
$gridCols = sbGetGridCols();
$showSidebar = sbShowSidebar('home');
?>

<?php if ($showSidebar): ?>
<!-- ===== Dual-column Layout ===== -->
<div class="sa-row">
  <!-- Main Content -->
  <div class="sa-col-xl-17 sa-col-lg-16 sa-col-md-24">
    <?php include __DIR__ . '/_posts.php'; ?>
  </div>
  <!-- Sidebar -->
  <div class="sa-col-xl-7 sa-col-lg-8 sa-col-md-24">
    <?php $this->need('sidebar.php'); ?>
  </div>
</div>
<?php else: ?>
<!-- ===== Single-column (no sidebar) Layout ===== -->
<?php include __DIR__ . '/_posts.php'; ?>
<?php endif; ?>

<?php $this->need('footer.php'); ?>
