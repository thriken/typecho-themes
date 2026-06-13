<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $this->archiveTitle([
        'category' => _t('分类 %s 下的文章'),
        'search'   => _t('包含关键字 %s 的文章'),
        'tag'      => _t('标签 %s 下的文章'),
        'author'   => _t('%s 发布的文章')
    ], '', ' - '); ?><?php $this->options->title(); ?></title>
    <meta name="description" content="<?php $this->options->description(); ?>">

    <!-- 主样式 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/main.css'); ?>">
    <!-- 规范化 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/normalize.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <?php $this->header(); ?>
</head>
<body>
<!-- 顶部信息栏 -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar__left">
            <span class="top-bar__date" id="js-date"></span>
        </div>
        <div class="top-bar__right">
            <?php if ($this->user->hasLogin()): ?>
                <a href="<?php $this->options->adminUrl(); ?>"><?php _e('控制台'); ?></a>
                <span class="divider">|</span>
                <a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a>
            <?php else: ?>
                <a href="<?php $this->options->loginUrl(); ?>"><?php _e('登录'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- 站点头部 -->
<header class="site-header" role="banner">
    <div class="container">
        <div class="site-header__inner">
            <!-- Logo / 站名 -->
            <div class="site-brand">
                <a href="<?php $this->options->siteUrl(); ?>" class="site-logo" rel="home">
                    <span class="site-logo__icon" aria-hidden="true">
                        <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
                            <rect width="40" height="40" rx="4" fill="#1a56db"/>
                            <path d="M8 20 L20 8 L32 20 L28 20 L28 32 L22 32 L22 24 L18 24 L18 32 L12 32 L12 20 Z" fill="#fff"/>
                        </svg>
                    </span>
                    <span class="site-logo__text">
                        <strong class="site-name"><?php $this->options->title(); ?></strong>
                        <?php if ($this->options->description()): ?>
                            <small class="site-desc"><?php $this->options->description(); ?></small>
                        <?php endif; ?>
                    </span>
                </a>
            </div>

            <!-- 搜索框 -->
            <div class="site-search">
                <form action="<?php $this->options->siteUrl(); ?>" method="get" class="search-form" role="search">
                    <input type="text" name="s" class="search-form__input" placeholder="搜索文章关键词..."
                           value="<?php if ($this->is('search') && $this->archive && method_exists($this->archive, 'keywords')): ?><?php $this->archive->keywords(false, ''); ?><?php endif; ?>"
                           aria-label="搜索">
                    <button type="submit" class="search-form__btn" aria-label="搜索">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor">
                            <path d="M9 3a6 6 0 1 0 0 12A6 6 0 0 0 9 3zm-8 6a8 8 0 1 1 14.32 4.906l4.387 4.387-1.414 1.414-4.387-4.387A8 8 0 0 1 1 9z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- 移动端菜单按钮 -->
            <button class="nav-toggle" id="js-nav-toggle" aria-label="展开菜单" aria-expanded="false" aria-controls="js-nav">
                <span class="nav-toggle__bar"></span>
                <span class="nav-toggle__bar"></span>
                <span class="nav-toggle__bar"></span>
            </button>
        </div>
    </div>
</header>

<!-- 主导航 -->
<nav class="main-nav" id="js-nav" role="navigation" aria-label="主导航">
    <div class="container">
        <ul class="main-nav__list">
            <li class="main-nav__item <?php if ($this->is('index')): ?>is-active<?php endif; ?>">
                <a href="<?php $this->options->siteUrl(); ?>" class="main-nav__link">
                    <svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor" aria-hidden="true"><path d="M10.707 2.293a1 1 0 0 0-1.414 0l-7 7a1 1 0 0 0 1.414 1.414L4 10.414V17a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-6.586l.293.293a1 1 0 0 0 1.414-1.414l-7-7z"/></svg>
                    首页
                </a>
            </li>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while ($pages->next()): ?>
                <li class="main-nav__item <?php if ($this->is('page', $pages->slug)): ?>is-active<?php endif; ?>">
                    <a href="<?php $pages->permalink(); ?>" class="main-nav__link"><?php $pages->title(); ?></a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</nav>

<!-- 面包屑 / 栏目标题 -->
<?php if (!$this->is('index')): ?>
<div class="page-banner">
    <div class="container">
        <nav class="breadcrumb" aria-label="面包屑导航">
            <a href="<?php $this->options->siteUrl(); ?>" class="breadcrumb__link">首页</a>
            <span class="breadcrumb__sep" aria-hidden="true">›</span>
            <?php if ($this->is('category')): ?>
                <span class="breadcrumb__current"><?php $this->category('', '', '', ''); ?></span>
            <?php elseif ($this->is('tag')): ?>
                <span>标签</span>
                <span class="breadcrumb__sep" aria-hidden="true">›</span>
                <span class="breadcrumb__current"><?php $this->tag('', '', '', ''); ?></span>
            <?php elseif ($this->is('search')): ?>
                <?php if ($this->archive && method_exists($this->archive, 'keywords')): ?>
                    <span class="breadcrumb__current">搜索：<?php $this->archive->keywords(false, ''); ?></span>
                <?php else: ?>
                    <span class="breadcrumb__current">搜索结果</span>
                <?php endif; ?>
            <?php elseif ($this->is('single') || $this->is('page')): ?>
                <?php if (is_array($this->categories) && count($this->categories) > 0): ?>
                    <?php $this->category(', ', ' › '); ?>
                    <span class="breadcrumb__sep" aria-hidden="true">›</span>
                <?php endif; ?>
                <span class="breadcrumb__current"><?php $this->title(); ?></span>
            <?php else: ?>
                <span class="breadcrumb__current">文章列表</span>
            <?php endif; ?>
        </nav>
    </div>
</div>
<?php endif; ?>
