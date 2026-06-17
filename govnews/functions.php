<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{
    // ---- 站点设置 ----
    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('站点 LOGO 地址'),
        _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO')
    );
    $form->addInput($logoUrl->addRule('url', _t('请填写一个合法的URL地址')));

    // ---- 首页模块：三栏分类 ----
    $homeCol3Cats = new \Typecho\Widget\Helper\Form\Element\Text(
        'homeCol3Cats',
        null,
        null,
        _t('首页三栏分类'),
        _t('填写分类ID（mid），多个用英文逗号分隔。如：1,2,3。每个分类取最新3篇文章，以三列网格展示。')
    );
    $form->addInput($homeCol3Cats);

    // ---- 首页模块：政策/单栏分类（可多个） ----
    $homeCol1Cats = new \Typecho\Widget\Helper\Form\Element\Text(
        'homeCol1Cats',
        null,
        null,
        _t('首页单栏分类'),
        _t('填写分类ID（mid），多个用英文逗号分隔。如：4,5。每个分类独占一行，以卡片形式展示最新3篇文章。')
    );
    $form->addInput($homeCol1Cats);

    // ---- 底部栏位 1-3 ----
    for ($i = 1; $i <= 3; $i++) {
        $footerCol = new \Typecho\Widget\Helper\Form\Element\Textarea(
            'footerCol' . $i,
            null,
            null,
            _t('底部第' . $i . '栏'),
            _t('每行一条链接，格式：链接名称|链接URL。例如：中国政府网|https://www.gov.cn')
        );
        $form->addInput($footerCol);
    }

    // ---- 底部联系我们 ----
    $footerContact = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'footerContact',
        null,
        null,
        _t('底部联系信息'),
        _t('每行一条信息，直接填写文本。例如：地址：XX市XX县行政中心大楼')
    );
    $form->addInput($footerContact);

    // ---- 侧边栏设置 ----
    $sidebarBlock = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'sidebarBlock',
        [
            'ShowRecentPosts'    => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowCategory'       => _t('显示分类'),
            'ShowArchive'        => _t('显示归档'),
            'ShowOther'          => _t('显示其它杂项')
        ],
        ['ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'],
        _t('侧边栏显示')
    );
    $form->addInput($sidebarBlock->multiMode());
}

function postMeta(
    \Widget\Archive $archive,
    string $metaType = 'archive'
) {
    $titleTag = $metaType == 'archive' ? 'h2' : 'h1';
?>
    <?php if ($metaType != 'page'): ?>
        <div class="article-info">
            <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                <?php _e('作者'); ?>: <a itemprop="name"
                    href="<?php $archive->author->permalink(); ?>"
                    rel="author"><?php $archive->author(); ?></a>
            </span>
            <span><?php _e('时间'); ?>:
                <time datetime="<?php $archive->date('c'); ?>" itemprop="datePublished"><?php $archive->date(); ?></time>
            </span>
            <span><?php _e('分类'); ?>: <?php $archive->category(','); ?></span>
            <?php if ($metaType == 'archive'): ?>
                <span itemprop="interactionCount">
                    <a itemprop="discussionUrl"
                        href="<?php $archive->permalink() ?>#comments"><?php $archive->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></a>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php
}

/**
 * 获取所有顶级分类（parent=0的分类）
 * 
 * @return array 返回顶级分类数组，每个元素包含：
 *               - mid: 分类ID
 *               - name: 分类名称
 *               - slug: 分类别名
 *               - permalink: 分类链接
 *               - description: 分类描述
 *               - count: 文章数量
 */
function getTopCategories()
{
    $categories = \Typecho\Widget::widget('Widget_Metas_Category_List');
    $topCategories = [];
    
    while ($categories->next()) {
        if ($categories->parent == 0) {
            $topCategories[] = [
                'mid' => $categories->mid,
                'name' => $categories->name,
                'slug' => $categories->slug,
                'permalink' => $categories->permalink,
                'description' => $categories->description,
                'count' => $categories->count
            ];
        }
    }
    
    // 重置指针以供后续使用
    $categories->reset();
    
    return $topCategories;
}

/**
 * 获取层级分类结构（大类-小类）
 * 
 * @return array 返回层级分类数组，结构为：
 *               [
 *                   [
 *                       'category' => [顶级分类信息],
 *                       'children' => [子分类数组]
 *                   ],
 *                   ...
 *               ]
 *               每个分类信息包含：
 *               - mid: 分类ID
 *               - name: 分类名称
 *               - slug: 分类别名
 *               - permalink: 分类链接
 *               - description: 分类描述
 *               - count: 文章数量
 *               - parent: 父分类ID
 */
function getHierarchicalCategories()
{
    // 获取所有分类
    $categories = \Typecho\Widget::widget('Widget_Metas_Category_List');
    $allCategories = [];
    
    // 收集所有分类数据
    while ($categories->next()) {
        $allCategories[] = [
            'mid' => $categories->mid,
            'name' => $categories->name,
            'slug' => $categories->slug,
            'permalink' => $categories->permalink,
            'description' => $categories->description,
            'count' => $categories->count,
            'parent' => $categories->parent,
            'levels' => $categories->levels
        ];
    }
    
    // 重置指针
    $categories->reset();
    
    // 按 parent 建立索引 → O(n)
    $byParent = [];
    foreach ($allCategories as $cat) {
        $byParent[$cat['parent']][] = $cat;
    }

    // 构建层级：顶级分类 + 其子分类
    $hierarchical = [];
    foreach ($byParent[0] as $topCat) {
        $hierarchical[] = [
            'category' => $topCat,
            'children' => $byParent[$topCat['mid']] ?? []
        ];
    }
    
    return $hierarchical;
}

/**
 * 根据分类ID获取分类信息
 * 
 * @param int $mid 分类ID
 * @return array|null 分类信息数组，包含：
 *                    - mid: 分类ID
 *                    - name: 分类名称
 *                    - slug: 分类别名
 *                    - permalink: 分类链接
 *                    - description: 分类描述
 *                    - count: 文章数量
 *                    - parent: 父分类ID
 */
function getCategoryById($mid)
{
    $categories = \Typecho\Widget::widget('Widget_Metas_Category_List');
    
    while ($categories->next()) {
        if ($categories->mid == $mid) {
            $category = [
                'mid' => $categories->mid,
                'name' => $categories->name,
                'slug' => $categories->slug,
                'permalink' => $categories->permalink,
                'description' => $categories->description,
                'count' => $categories->count,
                'parent' => $categories->parent
            ];
            
            $categories->reset();
            return $category;
        }
    }
    
    $categories->reset();
    return null;
}

/**
 * 根据分类ID获取文章列表
 * 
 * @param int $categoryId 分类ID
 * @param int $limit 获取的文章数量，默认10篇
 * @param int $offset 偏移量，默认0
 * @param string $orderBy 排序方式，可选：'created'（发布时间，默认）、'modified'（修改时间）、'commentsNum'（评论数）、'views'（浏览量，如果有统计插件）
 * @param string $order 排序方向，'DESC'（降序，默认）或 'ASC'（升序）
 * @return array 返回文章数组，每个元素包含：
 *               - cid: 文章ID
 *               - title: 文章标题
 *               - slug: 文章别名
 *               - permalink: 文章链接
 *               - excerpt: 文章摘要
 *               - content: 文章内容（原始）
 *               - text: 文章内容（处理后的文本）
 *               - created: 创建时间戳
 *               - modified: 修改时间戳
 *               - authorId: 作者ID
 *               - authorName: 作者名称
 *               - authorPermalink: 作者主页链接
 *               - commentsNum: 评论数量
 *               - categoryId: 分类ID
 *               - categoryName: 分类名称
 *               - categoryPermalink: 分类链接
 *               - tags: 标签数组 [['id' => ..., 'name' => ..., 'permalink' => ...], ...]
 *               - views: 浏览量（如果有统计）
 *               - isTop: 是否置顶
 *               - hasThumbnail: 是否有缩略图
 *               - thumbnail: 缩略图URL
 * 
 * @example 
 * // 获取分类ID为1的前10篇文章
 * $posts = getPostsByCategoryId(1);
 * 
 * // 获取分类ID为2的前5篇文章，按评论数降序排列
 * $posts = getPostsByCategoryId(2, 5, 0, 'commentsNum', 'DESC');
 */
function getPostsByCategoryId($categoryId, $limit = 10, $offset = 0, $orderBy = 'created', $order = 'DESC')
{
    // 参数验证
    $categoryId = (int)$categoryId;
    $limit = max(1, min(100, (int)$limit)); // 限制1-100篇
    $offset = max(0, (int)$offset);
    
    // 有效的排序字段
    $validOrderFields = ['created', 'modified', 'commentsNum'];
    if (!in_array($orderBy, $validOrderFields)) {
        $orderBy = 'created';
    }
    
    // 有效的排序方向
    $order = strtoupper($order);
    if (!in_array($order, ['ASC', 'DESC'])) {
        $order = 'DESC';
    }
    
    try {
        $db = \Typecho\Db::get();
        $options = \Typecho\Widget::widget('Widget_Options');
        
        // 获取分类信息
        $cat = $db->fetchRow(
            $db->select()->from('table.metas')
                ->where('mid = ? AND type = ?', $categoryId, 'category')
        );
        if (!$cat) {
            return [];
        }
        
        // 递归收集本分类及所有子分类ID
        $stack = [$categoryId];
        $visited = [];
        while ($stack) {
            $cur = array_pop($stack);
            if (in_array($cur, $visited)) continue;
            $visited[] = $cur;
            $rows = $db->fetchAll(
                $db->select('mid')->from('table.metas')
                    ->where('parent = ? AND type = ?', $cur, 'category')
            );
            foreach ($rows as $r) {
                $stack[] = (int)$r['mid'];
            }
        }
        $allMids = array_unique($visited);
        
        // 排序字段映射
        $orderField = 'table.contents.created';
        if ($orderBy === 'modified') {
            $orderField = 'table.contents.modified';
        } elseif ($orderBy === 'commentsNum') {
            $orderField = 'table.contents.commentsNum';
        }
        
        // 查询文章CID列表
        $query = $db->select('DISTINCT table.contents.cid')
            ->from('table.contents')
            ->join('table.relationships', 'table.contents.cid = table.relationships.cid')
            ->where('table.relationships.mid IN ?', $allMids)
            ->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.created < ?', $options->time)
            ->order($orderField, $order === 'ASC' ? \Typecho\Db::SORT_ASC : \Typecho\Db::SORT_DESC)
            ->offset($offset)
            ->limit($limit);
        
        $cids = $db->fetchAll($query);
        $cidList = array_column($cids, 'cid');
        
        if (empty($cidList)) {
            return [];
        }
        
        // 批量查询完整文章数据
        $rows = $db->fetchAll(
            $db->select()->from('table.contents')
                ->where('cid IN ?', $cidList)
        );
        
        // 按原始排序整理
        $rowMap = [];
        foreach ($rows as $row) {
            $rowMap[$row['cid']] = $row;
        }
        
        // 查询文章自定义字段（缩略图等）
        $fieldsMap = [];
        $fieldsRows = $db->fetchAll(
            $db->select()->from('table.fields')
                ->where('cid IN ?', $cidList)
        );
        foreach ($fieldsRows as $f) {
            $fieldsMap[$f['cid']][$f['name']] = $f[$f['type'] . '_value'];
        }
        
        // 查询文章标签
        $tagsMap = [];
        $tagsRows = $db->fetchAll(
            $db->select('r.cid', 'm.mid', 'm.name', 'm.slug')
                ->from('table.metas m')
                ->join('table.relationships r', 'r.mid = m.mid')
                ->where('r.cid IN ?', $cidList)
                ->where('m.type = ?', 'tag')
        );
        foreach ($tagsRows as $t) {
            $tagsMap[$t['cid']][] = [
                'id' => (int)$t['mid'],
                'name' => $t['name'],
                'permalink' => \Typecho\Router::url(
                    'tag',
                    ['slug' => urlencode($t['slug'])],
                    $options->index
                )
            ];
        }
        
        // 构建结果
        $postList = [];
        $catSlug = $cat['slug'];
        $catPermalink = \Typecho\Router::url(
            'category',
            [
                'directory' => urlencode($catSlug),
                'slug' => urlencode($catSlug)
            ],
            $options->index
        );
        foreach ($cidList as $cid) {
            $row = $rowMap[$cid] ?? null;
            if (!$row) continue;
            
            $fields = $fieldsMap[$cid] ?? [];
            $thumbnail = '';
            $hasThumbnail = false;
            
            if (!empty($fields['thumb'])) {
                $thumbnail = $fields['thumb'];
                $hasThumbnail = true;
            } elseif (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $row['text'], $m)) {
                $thumbnail = $m[1];
                $hasThumbnail = true;
            }
            
            $postPermalink = '';
            if (null != \Typecho\Router::get($row['type'])) {
                $postPermalink = \Typecho\Router::url($row['type'], $row, $options->index);
            }
            
            $postList[] = [
                'cid'         => (int)$row['cid'],
                'title'       => $row['title'],
                'slug'        => $row['slug'],
                'permalink'   => $postPermalink,
                'excerpt'     => \Typecho\Common::subStr(strip_tags($row['text']), 0, 200, '...'),
                'content'     => $row['text'],
                'text'        => $row['text'],
                'created'     => (int)$row['created'],
                'modified'    => (int)$row['modified'],
                'authorId'    => (int)$row['authorId'],
                'authorName'  => '',
                'authorPermalink' => '',
                'commentsNum' => (int)$row['commentsNum'],
                'categoryId'  => (int)$categoryId,
                'categoryName' => $cat['name'],
                'categoryPermalink' => $catPermalink,
                'tags'        => $tagsMap[$cid] ?? [],
                'views'       => 0,
                'isTop'       => false,
                'hasThumbnail' => $hasThumbnail,
                'thumbnail'   => $thumbnail,
            ];
        }
        
        return $postList;
        
    } catch (Exception $e) {
        error_log("getPostsByCategoryId error: " . $e->getMessage());
        return [];
    }
}

/**
 * 根据分类ID获取文章数量
 * 
 * @param int $categoryId 分类ID
 * @return int 文章数量
 */
function getPostCountByCategoryId($categoryId)
{
    $categoryId = (int)$categoryId;
    
    try {
        $db = \Typecho\Db::get();
        $prefix = $db->getPrefix();
        
        // 查询该分类下的文章数量
        $sql = "SELECT COUNT(*) as count FROM {$prefix}contents c
                INNER JOIN {$prefix}relationships r ON c.cid = r.cid
                WHERE c.type = 'post' AND c.status = 'publish' AND r.mid = ?";
        
        $result = $db->fetchRow($db->query($sql, $categoryId));
        
        return $result ? (int)$result['count'] : 0;
        
    } catch (Exception $e) {
        error_log("getPostCountByCategoryId error: " . $e->getMessage());
        return 0;
    }
}

/**
 * 根据分类ID获取文章（简化版，只获取基本信息）
 * 
 * @param int $categoryId 分类ID
 * @param int $limit 获取的文章数量，默认10篇
 * @return array 返回简化版文章数组，每个元素包含：
 *               - cid: 文章ID
 *               - title: 文章标题
 *               - permalink: 文章链接
 *               - excerpt: 文章摘要
 *               - created: 创建时间戳
 *               - commentsNum: 评论数量
 *               - thumbnail: 缩略图URL（如果有）
 */
function getSimplePostsByCategoryId($categoryId, $limit = 10)
{
    $posts = getPostsByCategoryId($categoryId, $limit);
    
    $simplePosts = [];
    foreach ($posts as $post) {
        $simplePosts[] = [
            'cid' => $post['cid'],
            'title' => $post['title'],
            'permalink' => $post['permalink'],
            'excerpt' => $post['excerpt'],
            'created' => $post['created'],
            'commentsNum' => $post['commentsNum'],
            'thumbnail' => $post['thumbnail']
        ];
    }
    
    return $simplePosts;
}

