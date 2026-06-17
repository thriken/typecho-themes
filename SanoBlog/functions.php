<?php
/**
 * SanoBlog - Typecho Theme Functions
 * Requires PHP 7.4+
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * Theme initial setup
 * 仅检测 views 列是否存在（static 缓存，单进程一次查询），不自动执行 DDL。
 * 若缺失，get_post_view() 会优雅降级；安装请访问 /usr/themes/SanoBlog/_install.php
 */
function themeInit($widget)
{
    // 静态缓存：整个 PHP 进程生命周期内只查一次
    static $checked = false;
    if ($checked) return;
    $checked = true;

    // 跨数据库兼容：尝试 SELECT views 列，失败则列不存在（兼容 MySQL/SQLite）
    try {
        $db = \Typecho\Db::get();
        $db->fetchAll($db->select('views')->from('table.contents')->limit(1));
        define('SB_HAS_VIEWS_COL', true);
    } catch (\Exception $e) {
        define('SB_HAS_VIEWS_COL', false);
    }
}

/**
 * Register theme features
 */
function themeConfig($form)
{
    // ═════════════════ 左侧悬浮导航 + 分组卡片样式 ═════════════════
    echo '<style>
/* 顶部横向导航 */
.sano-config-nav{display:flex;gap:6px;margin-bottom:18px;flex-wrap:wrap;}
.sano-config-nav a{display:flex;align-items:center;gap:6px;padding:7px 16px;border-radius:6px;font-size:13px;font-weight:600;color:#475569;text-decoration:none;background:#fff;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.08);transition:all .15s;white-space:nowrap;cursor:pointer;}
.sano-config-nav a:hover,.sano-config-nav a.active{background:#1f6feb;color:#fff;border-color:#1f6feb;}

/* 分组卡片 */
.sano-config-group{border:1px solid #e2e8f0;border-radius:10px;margin-bottom:20px;overflow:hidden;background:#fff;width:720px;max-width:100%;scroll-margin-top:60px;transition:all .2s;}
.sano-config-head{background:linear-gradient(135deg,#f8fafc 0%,#f1f5f9 100%);padding:11px 20px;border-bottom:1px solid #e2e8f0;font-weight:600;font-size:14px;color:#334155;display:flex;align-items:center;gap:8px;cursor:pointer;user-select:none;}
.sano-config-head:hover{background:linear-gradient(135deg,#eef2ff 0%,#e0e7ff 100%);}
.sano-config-head .sano-arrow{font-size:11px;transition:transform .2s;color:#94a3b8;margin-left:auto;}
.sano-config-body{padding:14px 20px 6px 20px;}
.sano-config-body.collapsed{display:none;}

/* 保存按钮独立容器 */
.sano-config-submit-wrap{width:720px;max-width:100%;margin-bottom:20px;padding:0;}
.sano-config-submit-wrap .typecho-option{border:none!important;padding:10px 0!important;margin:0!important;}

/* 返回顶部 */
.sano-back-top{position:fixed;bottom:24px;left:calc(50% + 380px);width:42px;height:42px;background:#1f6feb;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;text-decoration:none;box-shadow:0 3px 10px rgba(31,111,235,.35);z-index:99;transition:transform .15s;}
.sano-back-top:hover{transform:translateY(-3px);}
</style>';

    // 左侧纵向导航（点击切换分组，始终可见）
    echo '<nav class="sano-config-nav" title="快速跳转">';
    echo '<a href="javascript:void(0)" data-group="g-basic" onclick="showSection(\'g-basic\');return false;">⬛ 基础</a>';
    echo '<a href="javascript:void(0)" data-group="g-ad" onclick="showSection(\'g-ad\');return false;">📢 广告</a>';
    echo '<a href="javascript:void(0)" data-group="g-stats" onclick="showSection(\'g-stats\');return false;">📊 统计</a>';
    echo '<a href="javascript:void(0)" data-group="g-sidebar" onclick="showSection(\'g-sidebar\');return false;">📐 侧边栏</a>';
    echo '<a href="javascript:void(0)" data-group="g-footer" onclick="showSection(\'g-footer\');return false;">📄 页脚</a>';
    // 维护快捷入口（新标签页打开）
    echo '<a href="' . \Typecho\Widget::widget('Widget_Options')->themeUrl . '/_install.php" target="_blank" style="margin-top:auto;opacity:.65;border-top:1px solid #e2e8f0;padding-top:10px;margin-top:10px;">🔧 维护</a>';
    echo '</nav>';

    // 分组辅助函数
    $group = function($id, $icon, $title, $desc = '') {
        echo '<div class="sano-config-group" id="' . $id . '" style="display:none">';
        echo '<div class="sano-config-head" onclick="toggleBody(this)">' . $icon . ' <span>' . $title . '</span><span class="sano-arrow">&#9660;</span></div>';
        echo '<div class="sano-config-body">';
        if ($desc) {
            echo '<p style="color:#94a3b8;font-size:12px;margin:0 0 10px 0;">' . $desc . '</p>';
        }
    };
    $groupEnd = function() { echo '</div></div>'; };

    // ==================== 1. 站点基础 ====================
    $group('g-basic', '⬛', '站点基础', null);

    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl', null, null,
        _t('站点LOGO URL'), _t('留空则显示站点名称文字。推荐尺寸：200x50px')
    );
    $form->addInput($logoUrl);

    $faviconUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'faviconUrl', null, null,
        _t('Favicon URL'), _t('浏览器标签页小图标')
    );
    $form->addInput($faviconUrl);

    $defaultLayout = new \Typecho\Widget\Helper\Form\Element\Radio(
        'defaultLayout',
        ['list' => _t('列表模式'), 'grid' => _t('网格模式')],
        'list', _t('首页默认布局'),
        _t('列表模式适合文字为主的博客，网格模式适合图文内容')
    );
    $form->addInput($defaultLayout);

    $gridColumns = new \Typecho\Widget\Helper\Form\Element\Radio(
        'gridColumns',
        ['2' => _t('2列'), '3' => _t('3列（默认）'), '4' => _t('4列')],
        '3', _t('网格模式列数'),
        _t('仅对首页和列表页网格模式生效')
    );
    $form->addInput($gridColumns);

    $groupEnd();

    // ==================== 2. 广告位设置 ====================
    $group('g-ad', '📢', '广告位设置', '支持HTML/JS代码，留空则不显示。所有广告位均预留响应式样式。');

    $adTopbar = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'adTopbar', null, null,
        _t('顶部横栏广告'), _t('页面顶部通栏广告位，建议尺寸：1200x90')
    );
    $form->addInput($adTopbar);

    $adSidebar = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'adSidebar', null, null,
        _t('边栏广告'), _t('侧边栏广告位，建议尺寸：300x250')
    );
    $form->addInput($adSidebar);

    $adArticleTop = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'adArticleTop', null, null,
        _t('文章头部广告'), _t('文章标题下方、正文之前')
    );
    $form->addInput($adArticleTop);

    $adArticleBottom = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'adArticleBottom', null, null,
        _t('文章尾部广告'), _t('文章正文之后、标签之前')
    );
    $form->addInput($adArticleBottom);

    $adPrefooter = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'adPrefooter', null, null,
        _t('Footer前横栏广告'), _t('页脚上方通栏广告位，建议尺寸：1200x90')
    );
    $form->addInput($adPrefooter);

    $groupEnd();

    // ==================== 3. 统计代码 & 备案 ====================
    $group('g-stats', '📊', '统计代码 & 备案', '第三方统计分析与工信部备案信息');

    $statsCode = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'statsCode', null, null,
        _t('统计代码'), _t('如百度统计、Google Analytics等，将插入&lt;/body&gt;前')
    );
    $form->addInput($statsCode);

    $beianNumber = new \Typecho\Widget\Helper\Form\Element\Text(
        'beianNumber', null, null,
        _t('ICP备案号'), _t('如：粤ICP备XXXXXXXX号')
    );
    $form->addInput($beianNumber);

    $beianUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'beianUrl', null, 'https://beian.miit.gov.cn/',
        _t('备案链接'), _t('工信部备案查询地址')
    );
    $form->addInput($beianUrl);

    $groupEnd();

    // ==================== 4. 侧边栏设置 ====================
    $group('g-sidebar', '📐', '侧边栏设置', '各页面侧边栏独立开关 + 组件模块显示控制');

    $sidebarHome = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sidebarHome',
        ['1' => _t('显示（双栏）'), '0' => _t('隐藏（单栏）')],
        '1', _t('首页侧边栏'), _t('隐藏后首页内容区将占满全宽')
    );
    $form->addInput($sidebarHome);

    $sidebarPost = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sidebarPost',
        ['1' => _t('显示（双栏）'), '0' => _t('隐藏（单栏）')],
        '1', _t('文章页侧边栏'), _t('隐藏后文章内容区占满全宽，适合阅读体验')
    );
    $form->addInput($sidebarPost);

    $sidebarPage = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sidebarPage',
        ['1' => _t('显示（双栏）'), '0' => _t('隐藏（单栏）')],
        '0', _t('单页侧边栏'), _t('独立页面默认隐藏侧边栏')
    );
    $form->addInput($sidebarPage);

    // ── 侧边栏组件开关 ──
    $sbWidgetSearch = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sbWidgetSearch',
        ['1' => _t('显示'), '0' => _t('隐藏')],
        '1', _t('搜索框'), null
    );
    $form->addInput($sbWidgetSearch);

    $sbWidgetRecent = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sbWidgetRecent',
        ['1' => _t('显示'), '0' => _t('隐藏')],
        '1', _t('最新文章'), null
    );
    $form->addInput($sbWidgetRecent);

    $sbWidgetCategory = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sbWidgetCategory',
        ['1' => _t('显示'), '0' => _t('隐藏')],
        '1', _t('分类目录'), null
    );
    $form->addInput($sbWidgetCategory);

    $sbWidgetTag = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sbWidgetTag',
        ['1' => _t('显示'), '0' => _t('隐藏')],
        '1', _t('标签云'), null
    );
    $form->addInput($sbWidgetTag);

    $sbWidgetArchive = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sbWidgetArchive',
        ['1' => _t('显示'), '0' => _t('隐藏')],
        '1', _t('文章归档'), null
    );
    $form->addInput($sbWidgetArchive);

    $sbWidgetComment = new \Typecho\Widget\Helper\Form\Element\Radio(
        'sbWidgetComment',
        ['1' => _t('显示'), '0' => _t('隐藏')],
        '1', _t('最新评论'), null
    );
    $form->addInput($sbWidgetComment);

    $groupEnd();

    // ==================== 5. 页脚信息 ====================
    $group('g-footer', '📄', '页脚信息', '自定义底部区域文本，支持HTML');

    $footerText = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'footerText', null, null,
        _t('页脚自定义文本'), _t('显示在footer区域，支持HTML')
    );
    $form->addInput($footerText);

    $groupEnd();

    // 保存按钮独立容器（始终显示，不受分组切换影响）
    echo '<div class="sano-config-submit-wrap" id="g-submit"></div>';

    // ═════════════════ JS 已抽离到 assets/admin.js ═════════════════
    $themeUrl = \Typecho\Widget::widget('Widget_Options')->themeUrl;
    echo '<script src="' . $themeUrl . '/assets/admin.js?v=1.0"></script>';
    // 返回顶部按钮
    echo '<a href="#" class="sano-back-top" title="返回顶部">&#8593;</a>';
}

/**
 * Get ad slot content
 * Usage: sbAd('adTopbar') or $this->options->adTopbar in templates
 */
function sbAd($slot)
{
    $options = \Typecho\Widget::widget('Widget_Options');
    if (isset($options->$slot) && !empty($options->$slot)) {
        echo $options->$slot;
    }
}

/**
 * Check if sidebar should show
 */
function sbShowSidebar($context = 'home')
{
    $opt = \Typecho\Widget::widget('Widget_Options');
    switch ($context) {
        case 'home':
            return $opt->sidebarHome !== '0';
        case 'post':
            return $opt->sidebarPost !== '0';
        case 'page':
            return $opt->sidebarPage !== '0';
        default:
            return true;
    }
}

/**
 * Get layout mode
 */
function sbGetLayout()
{
    // 1. Cookie (user preference) takes priority
    if (isset($_COOKIE['sb_layout']) && in_array($_COOKIE['sb_layout'], ['list', 'grid'])) {
        return $_COOKIE['sb_layout'];
    }
    // 2. Default from theme options
    return \Typecho\Widget::widget('Widget_Options')->defaultLayout ?? 'list';
}

/**
 * Get grid columns
 */
function sbGetGridCols()
{
    $cols = \Typecho\Widget::widget('Widget_Options')->gridColumns ?? '3';
    return intval($cols);
}

/**
 * Post excerpt with length limit
 */
function sbExcerpt($content, $limit = 150)
{
    $content = trim(strip_tags((string)$content));
    // If strip_tags yields nothing (e.g. empty HTML tags), return empty
    if (mb_strlen($content, 'UTF-8') < 1) {
        return '';
    }
    $content = preg_replace('/\s+/', ' ', $content);
    if (mb_strlen($content, 'UTF-8') > $limit) {
        $content = mb_substr($content, 0, $limit, 'UTF-8') . '...';
    }
    return $content;
}

/**
 * Get first image from post content
 */
function sbPostThumb($content)
{
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches)) {
        return $matches[1];
    }
    return '';
}

/**
 * Register sidebar widgets
 */
function themeWidgets($widgets)
{
    // Typecho will auto-discover widgets registered here if needed
    // For now we use built-in widgets
}

/**
 * Get category tree with subcategories
 * Uses Typecho Widget_Metas_Category_Rows for reliable results
 */
function sbCategoryTree()
{
    $categories = [];
    \Typecho\Widget::widget('Widget\Metas\Category\Rows')
        ->to($cats)
        ->execute();
    while ($cats->next()) {
        // Deduplicate by mid to prevent repeated subcategory entries
        $categories[$cats->mid] = [
            'mid'    => $cats->mid,
            'name'   => $cats->name,
            'slug'   => $cats->slug,
            'parent' => $cats->parent,
            'count'  => $cats->count,
        ];
    }
    $categories = array_values($categories);

    $tree = [];
    $children = [];

    foreach ($categories as $cat) {
        if ($cat['parent'] == 0) {
            $tree[$cat['mid']] = $cat;
        } else {
            $children[$cat['parent']][] = $cat;
        }
    }

    foreach ($tree as $mid => &$cat) {
        $cat['children'] = $children[$mid] ?? [];
    }

    return $tree;
}

/**
 * Build category URL using Typecho routing table
 */
function sbCategoryUrl($slug)
{
    static $options = null;
    static $routePattern = null;

    if ($options === null) {
        $options = \Typecho\Widget::widget('Widget_Options');
        // Get category route pattern from routing table
        if (isset($options->routingTable['category']['url'])) {
            $routePattern = $options->routingTable['category']['url'];
        } else {
            $routePattern = 'category/[slug]';
        }
    }

    $path = str_replace('[slug]', rawurlencode($slug), $routePattern);
    return rtrim($options->siteUrl, '/') . '/' . ltrim($path, '/');
}

/**
 * Render navigation menu item
 */
function sbNavItem($item, $current = false, $widget = null)
{
    $url = sbCategoryUrl($item['slug']);

    // 自动检测当前页面是否匹配该分类（或其子分类）
    if (!$current && !empty($widget)) {
        try {
            if ($widget->is('category')) {
                $request = $widget->request;
                $currentCat = isset($request->slug) ? $request->slug : '';
                // 匹配当前分类
                if ($currentCat === $item['slug']) {
                    $current = true;
                }
                // 检查子分类
                if (!$current && !empty($item['children'])) {
                    foreach ($item['children'] as $child) {
                        if ($currentCat === $child['slug']) {
                            $current = true;
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {}
    }

    $active = $current ? ' active' : '';

    if (!empty($item['children'])) {
        echo '<div class="sa-d-flex sb-dropdown">';
        echo '<a href="' . $url . '" class="sb-dropdown-toggle' . $active . '">' . htmlspecialchars($item['name']) . '</a>';
        echo '<div class="sb-dropdown-menu">';
        foreach ($item['children'] as $child) {
            $childUrl = sbCategoryUrl($child['slug']);
            echo '<a href="' . $childUrl . '">' . htmlspecialchars($child['name']) . '</a>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<a href="' . $url . '" class="' . trim('sb-nav-link' . $active) . '">' . htmlspecialchars($item['name']) . '</a>';
    }
}

/**
 * Post view count（优雅降级：views 列不存在时返回 0 且不报错）
 */
function get_post_view($archive)
{
    $cid = $archive->cid;

    // views 列不存在时静默返回 0（需先执行 _install.php 安装）
    if (!defined('SB_HAS_VIEWS_COL') || !SB_HAS_VIEWS_COL) {
        echo '0';
        return;
    }

    $db = \Typecho\Db::get();
    try {
        $row = $db->fetchRow(
            $db->select('views')->from('table.contents')
                ->where('cid = ?', $cid)
        );
    } catch (\Exception $e) {
        echo '0';
        return;
    }

    if (is_array($row)) {
        $views = isset($row['views']) ? intval($row['views']) : 0;
    } elseif (is_object($row)) {
        $views = isset($row->views) ? intval($row->views) : 0;
    } else {
        $views = 0;
    }

    // If viewing single post, increment
    if ($archive->is('single')) {
        $cookieKey = '__sb_post_viewed_' . $cid;
        if (!isset($_COOKIE[$cookieKey])) {
            try {
                $db->query(
                    $db->update('table.contents')
                        ->rows(['views' => $views + 1])
                        ->where('cid = ?', $cid)
                );
                setcookie($cookieKey, '1', time() + 3600, '/');
                $views++;
            } catch (\Exception $e) {
                // Silently ignore update failure
            }
        }
    }

    echo number_format($views);
}

/**
 * Get current user identity (for comment form)
 */
function sbGetCommentUser()
{
    if (\Typecho\Cookie::get('__typecho_remember_author')) {
        return \Typecho\Cookie::get('__typecho_remember_author');
    }
    return '';
}

function sbGetCommentMail()
{
    if (\Typecho\Cookie::get('__typecho_remember_mail')) {
        return \Typecho\Cookie::get('__typecho_remember_mail');
    }
    return '';
}

function sbGetCommentUrl()
{
    if (\Typecho\Cookie::get('__typecho_remember_url')) {
        return \Typecho\Cookie::get('__typecho_remember_url');
    }
    return '';
}
