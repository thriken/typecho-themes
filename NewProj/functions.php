<?php
/**
 * NewProj Theme Functions
 *
 * @package NewProj
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 主题初始化
 */
function themeConfig($form) {
    // 主题配色
    $themeColor = new Typecho_Widget_Helper_Form_Element_Radio('themeColor',
        array(
            'light' => _t('浅色模式'),
            'dark' => _t('深色模式'),
            'auto' => _t('跟随系统')
        ),
        'auto',
        _t('默认主题配色'),
        _t('选择网站默认显示的主题配色模式')
    );
    $form->addInput($themeColor);

    // 站点 Logo
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL,
        _t('站点 Logo URL'),
        _t('在这里填入一个图片 URL 地址，以在网站标题前加上一个 Logo'));
    $form->addInput($logoUrl);

    // 站点图标
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL,
        _t('站点 Favicon'),
        _t('在这里填入一个图片 URL 地址，作为网站 Favicon'));
    $form->addInput($favicon);

    // 侧边栏显示设置（全站）
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock',
        array(
            'ShowCategory' => _t('显示分类目录'),
            'ShowRecentPosts' => _t('显示最新5篇文章'),
            'ShowTag' => _t('显示标签云'),
            'ShowArchive' => _t('显示归档'),
            'ShowOther' => _t('显示其它杂项（RSS、登录等）')
        ),
        array('ShowCategory', 'ShowRecentPosts', 'ShowTag', 'ShowArchive'),
        _t('侧边栏显示设置（首页 + 列表页通用）'),
        _t('勾选的模块将同时显示在首页和归档/列表页的右侧边栏中')
    );
    $form->addInput($sidebarBlock->multiMode());

    // 首页侧边栏开关
    $indexSidebar = new Typecho_Widget_Helper_Form_Element_Radio('indexSidebar',
        array(
            'show' => _t('显示侧边栏'),
            'hide' => _t('隐藏侧边栏（全宽文章列表）')
        ),
        'show',
        _t('首页侧边栏开关'),
        _t('控制首页是否显示右侧边栏模块。隐藏后首页文章列表将占满全宽')
    );
    $form->addInput($indexSidebar);

    // 首页文章数量
    $indexPostNum = new Typecho_Widget_Helper_Form_Element_Text('indexPostNum', NULL, '5',
        _t('首页显示文章数量'),
        _t('设置首页显示的文章条数，默认为5条'));
    $form->addInput($indexPostNum);

    // 统计代码
    $statistics = new Typecho_Widget_Helper_Form_Element_Textarea('statistics', NULL, NULL,
        _t('统计代码'),
        _t('在这里填入统计代码，如百度统计、Google Analytics 等'));
    $form->addInput($statistics);

    // ICP备案号
    $icp = new Typecho_Widget_Helper_Form_Element_Text('icp', NULL, NULL,
        _t('ICP 备案号'),
        _t('在这里填入 ICP 备案号'));
    $form->addInput($icp);

    // 自定义 CSS
    $customCss = new Typecho_Widget_Helper_Form_Element_Textarea('customCss', NULL, NULL,
        _t('自定义 CSS'),
        _t('在这里填入自定义 CSS 代码，会追加到主题样式之后'));
    $form->addInput($customCss);

    // Hero 区域类型选择
    $heroType = new Typecho_Widget_Helper_Form_Element_Radio('heroType',
        array(
            'post' => _t('置顶文章推荐'),
            'project' => _t('开源项目推介')
        ),
        'post',
        _t('首页 Hero 区域类型'),
        _t('选择首页顶部推荐区域的展示模式：置顶文章（填入文章ID）或开源项目推介')
    );
    $form->addInput($heroType);

    // 置顶文章 ID
    $heroPostId = new Typecho_Widget_Helper_Form_Element_Text('heroPostId', NULL, NULL,
        _t('置顶文章 ID'),
        _t('当 Hero 类型为"置顶文章推荐"时，填入要推荐的文章 cid（数字ID）'));
    $form->addInput($heroPostId);

    // 项目推介：项目名称
    $heroProjectName = new Typecho_Widget_Helper_Form_Element_Text('heroProjectName', NULL, NULL,
        _t('项目名称'),
        _t('当 Hero 类型为"开源项目推介"时，填入项目名称'));
    $form->addInput($heroProjectName);

    // 项目推介：一句话描述
    $heroProjectDesc = new Typecho_Widget_Helper_Form_Element_Text('heroProjectDesc', NULL, NULL,
        _t('项目简介'),
        _t('项目的简短一句话描述'));
    $form->addInput($heroProjectDesc);

    // 项目推介：Logo/截图 URL
    $heroProjectImage = new Typecho_Widget_Helper_Form_Element_Text('heroProjectImage', NULL, NULL,
        _t('项目展示图 URL'),
        _t('项目 Logo 或截图图片地址'));
    $form->addInput($heroProjectImage);

    // 项目推介：按钮1 - 文字
    $heroBtn1Text = new Typecho_Widget_Helper_Form_Element_Text('heroBtn1Text', NULL, _t('快速开始'),
        _t('按钮1文字'),
        _t('主按钮文字，如"快速开始"'));
    $form->addInput($heroBtn1Text);

    // 项目推介：按钮1 - 链接
    $heroBtn1Url = new Typecho_Widget_Helper_Form_Element_Text('heroBtn1Url', NULL, NULL,
        _t('按钮1链接'),
        _t('主按钮跳转地址'));
    $form->addInput($heroBtn1Url);

    // 项目推介：按钮2 - 文字
    $heroBtn2Text = new Typecho_Widget_Helper_Form_Element_Text('heroBtn2Text', NULL, _t('Github'),
        _t('按钮2文字'),
        _t('次按钮文字，如"Github"'));
    $form->addInput($heroBtn2Text);

    // 项目推介：按钮2 - 链接
    $heroBtn2Url = new Typecho_Widget_Helper_Form_Element_Text('heroBtn2Url', NULL, NULL,
        _t('按钮2链接'),
        _t('次按钮跳转地址'));
    $form->addInput($heroBtn2Url);

    // 项目推介：平台图标（逗号分隔）
    $heroPlatforms = new Typecho_Widget_Helper_Form_Element_Text('heroPlatforms', NULL, 'Windows,Linux,macOS',
        _t('支持平台'),
        _t('逗号分隔的平台名称，如 Windows,Linux,macOS'));
    $form->addInput($heroPlatforms);
}

/**
 * 文章浏览数统计
 */
function getViewsNum($archive) {
    $db = Typecho_Db::get();
    $cid = $archive;
    if (!is_numeric($cid)) {
        $cid = $archive->cid;
    }

    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($row) {
        return $row['views'] ? $row['views'] : 0;
    }
    return 0;
}

/**
 * 增加浏览数
 */
function theViews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));

    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }

        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views);
        }
    }

    echo $row['views'] ? $row['views'] : 0;
}

/**
 * 自定义摘要
 */
function excerpt($content, $length = 150) {
    $content = strip_tags($content);
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);

    if (mb_strlen($content, 'UTF-8') > $length) {
        $content = mb_substr($content, 0, $length, 'UTF-8') . '...';
    }

    return $content;
}

/**
 * 获取文章缩略图
 */
function getThumbnail($post, $default = '') {
    // 优先使用自定义字段 thumb
    if ($post->fields->thumb) {
        return $post->fields->thumb;
    }

    // 从文章内容中提取第一张图片
    $content = $post->content;
    preg_match('/<img.*?src="(.*?)".*?>/i', $content, $matches);
    if (!empty($matches[1])) {
        return $matches[1];
    }

    // 返回默认缩略图
    return $default;
}

/**
 * 获取文章分类的第一个分类
 */
function getPrimaryCategory($post) {
    $categories = $post->categories;
    if (!empty($categories)) {
        return $categories[0];
    }
    return null;
}

/**
 * 评论者头像
 */
function getAvatar($mail, $size = 40) {
    $gravatarUrl = 'https://www.gravatar.com/avatar/';
    $hash = md5(strtolower(trim($mail)));
    return $gravatarUrl . $hash . '?s=' . $size . '&d=identicon';
}

/**
 * 主题初始化钩子
 */
Typecho_Plugin::factory('Widget_Archive')->header = array('NewProj_Theme', 'header');
Typecho_Plugin::factory('Widget_Archive')->footer = array('NewProj_Theme', 'footer');

class NewProj_Theme {
    public static function header() {
        $options = Typecho_Widget::widget('Widget_Options');

        // 输出自定义 CSS
        if ($options->customCss) {
            echo '<style>' . $options->customCss . '</style>' . "\n";
        }

        // 输出 Favicon
        if ($options->favicon) {
            echo '<link rel="shortcut icon" href="' . $options->favicon . '">' . "\n";
        }
    }

    public static function footer() {
        $options = Typecho_Widget::widget('Widget_Options');

        // 输出统计代码
        if ($options->statistics) {
            echo $options->statistics . "\n";
        }
    }
}
