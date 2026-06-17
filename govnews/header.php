<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle([
                'category' => _t('分类 %s 下的文章'),
                'search'   => _t('包含关键字 %s 的文章'),
                'tag'      => _t('标签 %s 下的文章'),
                'author'   => _t('%s 发布的文章')
            ], '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header('commentReply=&antiSpam=1'); ?>
</head>

<body>
    <!-- 顶部导航栏 -->
    <div class="top-nav">
        <div class="container">
            <a<?php if ($this->is('index')): ?> class="current" <?php endif; ?>
                href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
                <?php while ($pages->next()): ?>
                    <a<?php if ($this->is('page', $pages->slug)): ?> class="current" <?php endif; ?>
                        href="<?php $pages->permalink(); ?>"
                        title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                    <?php endwhile; ?>
            <a href="javascript:;" id="wide-screen-toggle" class="wide-btn" title="切换宽屏模式">宽屏</a>
        </div>
    </div>

    <!-- 头部通栏 -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <?php if ($this->options->logoUrl): ?>
                    <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                        <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" />
                    </a>
                <?php else: ?>
                    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><img src="<?php $this->options->themeUrl('img/logo.png') ?>" /></a>
                    <div class="logo-title"><?php $this->options->description() ?></div>
                <?php endif; ?>
            </div>
            <div class="search-box">
                <form id="search" method="get" action="<?php $this->options->siteUrl(); ?>" role="search">
                    <label for="s" class="sr-only"><?php _e('搜索'); ?></label>
                    <input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
                    <button type="submit" class="submit"><?php _e('搜索'); ?></button>
                </form>
            </div>
        </div>
    </header>

    <nav class="main-nav">
        <div class="container">
            <ul>
                <li><a href="<?php $this->options->siteUrl(); ?>" <?php if ($this->is('index')): ?> class="active" <?php endif; ?>>首页</a></li>
                <?php
                $cats = getTopCategories();
                foreach ($cats as $cat) {
                ?>
                    <li><a href="<?php echo $cat['permalink']; ?>" <?php if ($this->is('category', $cat['slug'])): ?> class="active" <?php endif; ?>><?php echo $cat['name']; ?></a></li>
                <?php }
                ?>
            </ul>
        </div>
    </nav>

    <!-- 核心内容区 -->
    <div class="content container">