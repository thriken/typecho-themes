<!DOCTYPE HTML>
<html>
<?php 
// 定义翻译函数，消除IDE错误提示
if (!function_exists('_t')) {
    function _t($text) {
        return $text;
    }
}
if (!function_exists('_e')) {
    function _e($text) {
        echo $text;
    }
}
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="<?php $this->options->charset(); ?>" />
	<meta name="viewport" content="width=device-width,user-scalable=no">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
	<!--[if lt IE 9]>
    <script type="text/javascript" src="<?php $this->options->themeUrl('javascript/html5shiv.js'); ?>"></script>
    <![endif]-->
    <!-- Favicon -->
    <?php if($this->options->faviconUrl): ?>
    <link rel="shortcut icon" href="<?php $this->options->faviconUrl(); ?>" type="image/x-icon" />
    <?php endif; ?>
    <link rel="stylesheet" href="<?php $this->options->adminUrl('css/normalize.css'); ?>">
    <link rel="stylesheet" href="https://s4.zstatic.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
    <?php $this->header("generator=&template=&"); ?>
</head>
<body>

<header id="header" class="clearfix">
    <div class="container">
        <div class="col-group">
            <div class="site-name ">
                <?php if ($this->options->logoUrl): ?>
                    <?php if ($this->is('index')): ?>
                        <h1>
                            <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                                <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title() ?>" style="max-height: 60px;" />
                            </a>
                        </h1>
                    <?php else:?>
                        <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                            <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title() ?>" style="max-height: 60px;" />
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($this->is('index')): ?>
                        <h1>
                            <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                                <?php $this->options->title() ?>
                            </a>
                        </h1>
                    <?php else:?>
                        <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                            <?php $this->options->title() ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
        	    <p class="description"><?php $this->options->description() ?></p>
            </div>
            <div>
                <nav id="nav-menu" class="clearfix">
                    <a class="<?php if($this->is('index')): ?>current<?php endif; ?> <?php if($this->is('post')): ?>current<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>"><i class="fas fa-home"></i> <?php _e('首页'); ?></a>
                    
                    <!-- 分类菜单 -->
                    <?php 
                    $this->widget('Widget_Metas_Category_List', array('sort' => 'order', 'ignoreZeroCount' => true))->to($categories);
                    if ($categories->have()) {
                        while ($categories->next()) {
                            if (!$categories->parent) { // 只显示一级分类
                                $active = ($this->is('category', $categories->slug)) ? ' class="current"' : '';
                                echo '<a'. $active .' href="'. $categories->permalink .'">'.'<i class="fas fa-folder"></i> '. $categories->name .'</a>';
                            }
                        }
                    }
                    ?>
                    
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><i class="fas fa-file"></i> <?php $pages->title(); ?></a>
                    <?php endwhile; ?>
                </nav>
            </div>
        </div>
    </div>
</header>
<div id="body">
    <div class="container">
        <div class="col-group">
