<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * CoderBlog - 程序员博客主题
 *
 * @package     CoderBlog
 * @author      CoderBlog Team
 * @version     1.0.0
 * @link        https://typecho.cn
 */

// 引入后台设置
require_once __DIR__ . '/includes/themeConfig.php';

/**
 * 初始化主题
 */
function themeInit($archive)
{
    // 评论框中加入 Prism.js 代码高亮支持
    if ($archive->is('single')) {
        // 文章页保留
    }

    // 首页文章数量（后台可设置 6/9/12 篇）
    if ($archive->is('index')) {
        $options = Typecho_Widget::widget('Widget_Options');
        if (!empty($options->indexPostNum) && is_numeric($options->indexPostNum)) {
            $archive->parameter->pageSize = (int)$options->indexPostNum;
        }
    }

    // 日期归档页：全部显示，不分页
    if ($archive->is('archive')) {
        $archive->parameter->pageSize = 9999;
    }
}

/**
 * 文章摘要 - 去除HTML标签后截取
 */
function cbExcerpt($content, $length = 150)
{
    $content = strip_tags($content);
    $content = preg_replace('/\s+/', ' ', trim($content));
    if (mb_strlen($content, 'UTF-8') > $length) {
        $content = mb_substr($content, 0, $length, 'UTF-8') . '...';
    }
    return $content;
}

/**
 * 判断文章是否设置了访问密码
 */
function cbIsPasswordProtected($archive)
{
    return !empty($archive->password);
}

/**
 * 判断密码是否已验证通过
 * Typecho 验证后会设置 cookie: __typecho_protect_password_{cid}
 */
function cbIsPasswordVerified($archive)
{
    if (empty($archive->password)) {
        return true;
    }
    // POST 提交时 Typecho 核心会处理，此时视为未验证
    if ($archive->request->isPost()) {
        return false;
    }
    $cookieName = '__typecho_protect_password_' . $archive->cid;
    $cookieVal  = Typecho_Cookie::get($cookieName);
    // Typecho 将密码哈希存入 cookie，匹配即验证通过
    return ($cookieVal === $archive->password);
}

/**
 * 解析自定义导航菜单
 * 返回解析后的菜单项数组
 * 格式：每行 名称|链接|图标(可选)
 * 特殊行：--- 表示分隔线
 */
function cbParseNavMenu($rawMenu)
{
    $items = [];
    if (empty(trim($rawMenu))) {
        return $items;
    }

    $lines = explode("\n", $rawMenu);
    $siteUrl = rtrim(Helper::options()->siteUrl, '/');

    foreach ($lines as $line) {
        $line = trim($line);
        // 跳过空行和注释
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        // 分隔线
        if ($line === '---') {
            $items[] = ['type' => 'separator'];
            continue;
        }
        // 按 | 分割（最多3段：名称|链接|图标）
        $parts = array_map('trim', explode('|', $line, 3));
        if (empty($parts[0]) || trim($parts[0]) === '') {
            continue;
        }

        $name  = trim($parts[0]);
        $url   = isset($parts[1]) && trim($parts[1]) !== '' ? trim($parts[1]) : '#';
        $icon  = isset($parts[2]) ? trim($parts[2]) : '';

        // 跳过明显是纯URL的行（用户误填）
        if (preg_match('#^https?://#', $name) || preg_match('#^/#', $name)) {
            continue;
        }

        // 替换 {siteUrl} 占位符
        $url = str_replace('{siteUrl}', $siteUrl, $url);

        // 相对路径补全
        if (!preg_match('#^https?://#', $url) && !preg_match('#^/#', $url) && $url !== '#') {
            $url = '/' . ltrim($url, '/');
        }

        // 验证图标格式
        $icon = (preg_match('/^fa[a-zA-Z-]*$/', $icon)) ? $icon : '';

        $items[] = [
            'type' => 'link',
            'name' => mb_substr($name, 0, 20, 'UTF-8'),
            'url'  => $url,
            'icon' => $icon,
        ];
    }
    return $items;
}

/**
 * 自动生成默认导航菜单（分类+页面）
 */
function cbDefaultNavMenu($archive)
{
    $navItems = [
        ['type' => 'link', 'name' => '首页', 'url' => rtrim(Helper::options()->siteUrl, '/'), 'icon' => 'fa-home'],
    ];

    $db = Typecho_Db::get();
    try {
        // 分类列表
        $cats = $db->fetchAll(
            $db->select('mid', 'name', 'slug')->from('table.metas')
             ->where('type = ?', 'category')
             ->order('order', Typecho_Db::SORT_ASC)
        );
        if (!empty($cats)) {
            $navItems[] = ['type' => 'separator'];
            foreach ($cats as $cat) {
                $cat['slug'] = urlencode($cat['slug']);
                $navItems[] = [
                    'type' => 'link',
                    'name' => htmlspecialchars($cat['name']),
                    'url'  => Typecho_Router::url('category', ['slug' => $cat['slug'], 'mid' => $cat['mid']], Helper::options()->index),
                    'icon' => '',
                ];
            }
        }

        // 独立页面
        $pages = $db->fetchAll(
            $db->select('cid', 'title', 'slug')->from('table.contents')
             ->where('type = ?', 'page')
             ->where('status = ?', 'publish')
             ->order('order', Typecho_Db::SORT_ASC)
             ->limit(10)
        );
        if (!empty($pages)) {
            $navItems[] = ['type' => 'separator'];
            foreach ($pages as $page) {
                $page['slug'] = urlencode($page['slug']);
                $navItems[] = [
                    'type' => 'link',
                    'name' => htmlspecialchars($page['title']),
                    'url'  => Typecho_Router::url('page', ['cid' => $page['cid'], 'slug' => $page['slug'], Helper::options()->index]),
                    'icon' => ''
                ];
            }
        }
    } catch (Exception $e) {
        // 查询失败时返回最小菜单
    }
    return $navItems;
}

/**
 * 检查文章是否有真实缩略图（非随机占位图）
 * 用于加密文章：真实图片才做高斯模糊，占位图保留原样
 */
function cbHasRealThumbnail($widget)
{
    if (!empty($widget->fields->thumb)) return true;
    if (preg_match('/<img[^>]+src="([^"]+)"/i', $widget->content, $matches)) return true;
    return false;
}

/**
 * 获取文章缩略图
 * 优先：自定义字段 thumb → 文章第一张图片 → 随机占位图
 */
function cbThumbnail($widget, $default = 'random')
{
    // 自定义字段
    if (!empty($widget->fields->thumb)) {
        return $widget->fields->thumb;
    }
    // 正文第一张图片
    if (preg_match('/<img[^>]+src="([^"]+)"/i', $widget->content, $matches)) {
        return $matches[1];
    }
    // 随机占位图（基于文章cid保证同一文章每次一致）
    if ($default === 'random') {
        $seed = abs(crc32((string)$widget->cid)) % 1000;
        return "https://picsum.photos/seed/{$seed}/600/400";
    }
    return $default;
}

/**
 * 获取文章第一个分类
 */
function cbPrimaryCategory($widget)
{
    if (!empty($widget->categories)) {
        return $widget->categories[0];
    }
    // 尝试从数据库获取（不输出）
    $db = Typecho_Db::get();
    try {
        $row = $db->fetchRow($db->select('mid')->from('table.relationships')
            ->where('cid = ?', $widget->cid)->limit(1));
        if (!empty($row['mid'])) {
            $cat = $db->fetchRow($db->select('name', 'slug', 'permalink')
                ->from('table.metas')->where('mid = ?', $row['mid']));
            if ($cat) return ['name' => $cat['name'], 'permalink' => $cat['permalink'] ?? '#', 'slug' => $cat['slug']];
        }
    } catch (Exception $e) {}
    return ['name' => '未分类', 'permalink' => '#', 'slug' => 'uncategorized'];
}

/**
 * 获取分类图标颜色
 */
function cbCategoryColor($slug)
{
    $colors = [
        'frontend'    => 'blue',
        'backend'     => 'green',
        'devops'      => 'teal',
        'mobile'     => 'orange',
        'ai'         => 'purple',
        'design'     => 'pink',
        'database'   => 'indigo',
        'security'   => 'red',
        'default'    => 'primary',
    ];
    return $colors[$slug] ?? 'primary';
}

/**
 * 归档页面：获取入口文字（按年月日格式不同）
 */
function cbArchiveTitle($archive)
{
    if ($archive->is('category')) {
        $title = $archive->getArchiveTitle();
        return '分类 / <span class="font-bold">' . $title . '</span>';
    } elseif ($archive->is('tag')) {
        $title = $archive->getArchiveTitle();
        return '标签 / <span class="font-bold">' . $title . '</span>';
    } elseif ($archive->is('search')) {
        $title = $archive->getArchiveTitle();
        return '搜索 / <span class="font-bold">' . $title . '</span>';
    } elseif ($archive->is('author')) {
        $title = $archive->getArchiveTitle();
        return '作者 / <span class="font-bold">' . $title . '</span>';
    } else {
        // date archive
        $year  = $archive->year;
        $month = $archive->month ? sprintf('%02d', $archive->month) : '';
        $day   = $archive->day ? sprintf('%02d', $archive->day) : '';
        $date  = $year;
        if ($month) $date .= '-' . $month;
        if ($day)   $date .= '-' . $day;
        return '归档 / <span class="font-bold">' . $date . '</span>';
    }
}

/**
 * 短代码处理
 * 支持的短代码：
 *   [video url="..."]  
 *   [audio url="..."]  
 *   [file url="..." name="..."]  
 *   [quote color="red|blue|green|yellow|purple" title="..."]内容[/quote]  
 *   [ref id="123"]  
 */
function cbShortcode($content)
{
    // 视频嵌入
    $content = preg_replace_callback(
        '/\[video\s+url="([^"]+)"\s*\]/i',
        function ($m) {
            $url = htmlspecialchars($m[1]);
            $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
            if (in_array($ext, ['mp4', 'webm', 'ogg'])) {
                return '<div class="cb-video-wrapper my-6 rounded-xl overflow-hidden shadow-lg"><video controls class="w-full"><source src="' . $url . '" type="video/' . $ext . '">您的浏览器不支持视频播放。</video></div>';
            }
            // YouTube / Bilibili 等
            if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $vm);
                $vid = $vm[1] ?? '';
                return '<div class="cb-video-wrapper my-6 rounded-xl overflow-hidden shadow-lg aspect-video"><iframe src="https://www.youtube.com/embed/' . $vid . '" class="w-full h-full" frameborder="0" allowfullscreen></iframe></div>';
            }
            if (strpos($url, 'bilibili.com') !== false) {
                preg_match('/\/video\/(BV[a-zA-Z0-9]+)/', $url, $bm);
                $bvid = $bm[1] ?? '';
                return '<div class="cb-video-wrapper my-6 rounded-xl overflow-hidden shadow-lg aspect-video"><iframe src="https://player.bilibili.com/player.html?bvid=' . $bvid . '" class="w-full h-full" frameborder="0" allowfullscreen></iframe></div>';
            }
            return '<div class="cb-video-wrapper my-6"><a href="' . $url . '" target="_blank" class="btn btn-primary"><i class="fas fa-play mr-2"></i>打开视频</a></div>';
        },
        $content
    );

    // 音频嵌入
    $content = preg_replace_callback(
        '/\[audio\s+url="([^"]+)"\s*\]/i',
        function ($m) {
            $url = htmlspecialchars($m[1]);
            return '<div class="cb-audio-wrapper my-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl"><audio controls class="w-full"><source src="' . $url . '">您的浏览器不支持音频播放。</audio></div>';
        },
        $content
    );

    // 文件下载
    $content = preg_replace_callback(
        '/\[file\s+url="([^"]+)"\s+name="([^"]*)"\s*\]/i',
        function ($m) {
            $url  = htmlspecialchars($m[1]);
            $name = $m[2] ? htmlspecialchars($m[2]) : basename(parse_url($url, PHP_URL_PATH));
            return '<a href="' . $url . '" class="cb-file-link inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors my-2" target="_blank"><i class="fas fa-download"></i><span>' . $name . '</span></a>';
        },
        $content
    );

    // 多色引用块
    $content = preg_replace_callback(
        '/\[quote\s+color="(red|blue|green|yellow|purple|orange|pink|gray)"(?:\s+title="([^"]*)")?\](.*?)\[\/quote\]/is',
        function ($m) {
            $color = $m[1];
            $title = !empty($m[2]) ? '<div class="font-semibold mb-2">' . htmlspecialchars($m[2]) . '</div>' : '';
            $text  = trim($m[3]);
            return '<blockquote class="cb-quote cb-quote-' . $color . ' border-l-4 border-' . $color . '-500 bg-' . $color . '-50 dark:bg-' . $color . '-900/20 p-4 rounded-r-lg my-4 not-italic">' . $title . $text . '</blockquote>';
        },
        $content
    );

    // 内链引用 [ref id="123"] — 紧凑行内卡片
    $content = preg_replace_callback(
        '/\[ref\s+id="(\d+)"\s*\]/i',
        function ($m) {
            $db = Typecho_Db::get();
            $cid = intval($m[1]);
            $row = $db->fetchRow($db->select('title', 'slug')->from('table.contents')->where('cid = ? AND type = ?', $cid, 'post'));
            if ($row) {
                $siteUrl = rtrim(Helper::options()->siteUrl, '/');
                $url = Typecho_Router::url('post', ['cid' => $cid, 'slug' => rawurlencode($row['slug'])], $siteUrl);
                return '转到文章：<a href="' . $url . '" class="cb-ref-card inline-flex items-center gap-3 border border-gray-200 dark:border-gray-700 rounded-xl px-5 py-2.5 my-1.5 no-underline hover:border-sky-400 dark:hover:border-sky-500 hover:shadow-sm transition-all duration-150 group align-middle">'
                    . '<i class="fas fa-arrow-up-right-from-square text-base text-sky-500"></i>'
                    . '<span class="text-[1.15rem] text-gray-700 dark:text-gray-300 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors whitespace-nowrap">' . htmlspecialchars($row['title']) . '</span></a>';
            }
            return '<span class="text-gray-400 text-sm">[引用文章不存在]</span>';
        },
        $content
    );

    return $content;
}

/**
 * 代码高亮 - 文章内容中为 pre code 添加 Prism.js 需要的 class
 */
function cbCodeHighlight($content)
{
    // 为 <pre><code> 添加 line-numbers class
    $content = str_replace('<pre><code class="language-', '<pre class="line-numbers"><code class="language-', $content);
    $content = str_replace('<pre><code>', '<pre class="line-numbers"><code>', $content);
    return $content;
}

/**
 * 为渲染后的 HTML 中 h1/h2/h3 添加锚点 id（与目录联动）
 */
function cbAddHeadingIds($html)
{
    $usedIds = [];
    return preg_replace_callback(
        '/<(h[1-3])>(.*?)<\/\1>/is',
        function ($m) use (&$usedIds) {
            $tag  = $m[1];
            $text = trim(strip_tags($m[2]));
            if (empty($text)) return $m[0];
            $base = 'heading-' . trim(preg_replace('/[^\x{4e00}-\x{9fa5}a-z0-9]+/u', '-', mb_strtolower($text)), '-');
            $id = $base; $n = 1;
            while (isset($usedIds[$id])) { $id = $base . '-' . (++$n); }
            $usedIds[$id] = true;
            return '<' . $tag . ' id="' . htmlspecialchars($id) . '" class="scroll-mt-20">' . $m[2] . '</' . $tag . '>';
        },
        $html
    );
}

/**
 * 从原始 Markdown 文本生成目录 HTML（含嵌套，与 cbAddHeadingIds 生成相同 id）
 * @return string 空字符串表示无标题
 */
function cbTocGenerate($rawText)
{
    if (!preg_match_all('/^(#{1,3})\s+(.+)$/m', $rawText, $m, PREG_SET_ORDER)) return '';
    $usedIds = [];
    $html = '';
    $prevLevel = 0;
    $first = true;
    foreach ($m as $h) {
        $level = strlen($h[1]);
        $title = trim(strip_tags($h[2]));
        if (empty($title)) continue;

        // 与 cbAddHeadingIds 相同的 id 生成逻辑
        $base = 'heading-' . trim(preg_replace('/[^\x{4e00}-\x{9fa5}a-z0-9]+/u', '-', mb_strtolower($title)), '-');
        $id = $base; $n = 1;
        while (isset($usedIds[$id])) { $id = $base . '-' . (++$n); }
        $usedIds[$id] = true;

        // 嵌套处理
        if ($first) {
            $html .= '<ul class="toc-list space-y-0.5">';
            $first = false;
        }
        if ($level > $prevLevel) {
            for ($i = $prevLevel; $i < $level; $i++) $html .= '<ul class="toc-sublist ml-3 space-y-0.5">';
        } elseif ($level < $prevLevel) {
            for ($i = $level; $i < $prevLevel; $i++) $html .= '</ul>';
        }

        $pad = ($level - 1) * 12;
        $html .= '<li><a href="#' . htmlspecialchars($id) . '" class="toc-link block py-1 px-2 rounded text-sm text-gray-500 dark:text-gray-400 hover:text-sky-600 dark:hover:text-sky-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 truncate transition-colors" style="padding-left:' . ($pad + 8) . 'px" data-toc-level="' . $level . '">'
              . htmlspecialchars($title) . '</a></li>';

        $prevLevel = $level;
    }
    for ($i = 1; $i < $prevLevel; $i++) $html .= '</ul>';
    $html .= '</ul>';
    return $html;
}


// 注册摘要过滤器：去标签
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = function ($excerpt, $widget) {
    return strip_tags(cbShortcode($excerpt));
};

/**
 * 主题资源注册
 */
function cbThemeHeader()
{
    $options = Helper::options();
    $themeUrl = $options->themeUrl;
    ?>
    <!-- Prism.js 代码高亮 CSS -->
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/assets/css/prism.css">
    <?php
}
Typecho_Plugin::factory('Widget_Archive')->header = 'cbThemeHeader';

function cbThemeFooter()
{
    $options = Helper::options();
    $themeUrl = $options->themeUrl;
    ?>
    <!-- Prism.js 代码高亮 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/match-braces/prism-match-braces.min.js"></script>
    <!-- 主题 JS -->
    <script src="<?php echo $themeUrl; ?>/assets/js/main.js"></script>
    <?php
}
Typecho_Plugin::factory('Widget_Archive')->footer = 'cbThemeFooter';
