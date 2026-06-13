<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="<?php $this->language(); ?>">

<head>
  <meta charset="<?php $this->options->charset(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <?php if ($this->options->faviconUrl): ?>
    <link rel="icon" href="<?php $this->options->faviconUrl(); ?>" type="image/x-icon">
  <?php endif; ?>

  <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
          ], '', ' - '); ?><?php $this->options->title(); ?></title>

  <!-- SanoUI CSS -->
  <link rel="stylesheet" href="https://www.sanoui.com/sanoui/sanoui.min.css">
  <!-- FontAwesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Theme CSS -->
  <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
  <?php $this->header('commentReply=1'); ?>
</head>
<body>
  <?php if ($this->options->adTopbar): ?>
    <div class="sb-ad-topbar"><?php sbAd('adTopbar'); ?></div>
  <?php endif; ?>
  <header class="sb-header sa-d-flex sa-align-center">
    <div class="sa-container-content sa-d-flex sa-align-center sa-flex-between" style="height:100%;">
      <div class="sa-d-flex sa-align-center sa-gap-3">
        <a href="<?php $this->options->siteUrl(); ?>" class="sb-logo sa-d-flex sa-align-center sa-gap-2">
          <?php if ($this->options->logoUrl): ?>
            <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>" style="height:36px;">
          <?php else: ?>
            <?php $this->options->title(); ?>
          <?php endif; ?>
        </a>
      </div>
      <nav class="sa-d-flex sa-align-center sa-gap-2 sb-nav" role="navigation">
        <button class="sb-nav-toggle" aria-label="菜单" onclick="document.querySelector('.sb-nav-desktop').classList.toggle('open')">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="sa-d-flex sa-align-center sa-gap-1 sb-nav-desktop">
          <a href="<?php $this->options->siteUrl(); ?>" class="sb-nav-link<?php echo $this->is('index') ? ' active' : ''; ?>">
            <i class="fa-solid fa-house"></i>&nbsp;首页
          </a>
          <?php
          $catTree = sbCategoryTree();
          foreach ($catTree as $cat):
            sbNavItem($cat, false, $this);
          endforeach;
          ?>
        </div>
        <!-- 明暗切换 -->
        <button class="sb-theme-toggle" id="sbThemeToggle" aria-label="切换明暗主题" title="切换明暗主题">
          <i class="fa-solid fa-moon"></i>
          <i class="fa-solid fa-sun"></i>
        </button>
      </nav>
    </div>
  </header>
  <main class="sa-container-content sa-py-5">