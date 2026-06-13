<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{
    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('站点 LOGO 地址'),
        _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO')
    );

    $form->addInput($logoUrl->addRule('url', _t('请填写一个合法的URL地址')));

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
    
    // 构建层级结构
    $hierarchical = [];
    
    // 首先获取所有顶级分类
    foreach ($allCategories as $cat) {
        if ($cat['parent'] == 0) {
            $topCat = $cat;
            $children = [];
            
            // 查找该顶级分类的子分类
            foreach ($allCategories as $childCat) {
                if ($childCat['parent'] == $topCat['mid']) {
                    $children[] = $childCat;
                }
            }
            
            $hierarchical[] = [
                'category' => $topCat,
                'children' => $children
            ];
        }
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
        // 创建查询参数
        $params = [
            'category' => $categoryId,
            'pageSize' => $limit,
            'page' => floor($offset / $limit) + 1,
            'type' => 'post',
            'status' => 'publish'
        ];
        
        // 设置排序
        if ($orderBy === 'created') {
            $params['order'] = $order;
        } elseif ($orderBy === 'modified') {
            $params['order'] = $order;
            //$params['sort'] = 'modified';
        } elseif ($orderBy === 'commentsNum') {
            // 评论数排序需要特殊处理
            $params['order'] = $order;
            //$params['sort'] = 'commentsNum';
        }
        
        // 获取文章列表
        $posts = \Typecho\Widget::widget('Widget_Archive', $params);
        
        $postList = [];
        
        // 遍历文章
        while ($posts->next()) {
            // 获取文章分类
            $category = $posts->category;
            $categoryArray = [];
            
            if (is_object($category) && method_exists($category, 'mid')) {
                $categoryArray = [
                    'id' => $category->mid,
                    'name' => $category->name,
                    'permalink' => $category->permalink
                ];
            }
            
            // 获取文章标签
            $tags = [];
            $postTags = $posts->tags;
            if (!empty($postTags)) {
                // 处理标签数组
                foreach ($postTags as $tag) {
                    $tags[] = [
                        'id' => (int)$tag['mid'],
                        'name' => $tag['name'],
                        'permalink' => $tag['permalink']
                    ];
                }
            }
            
            // 尝试获取浏览量（如果有统计插件）
            $views = 0;
            if (method_exists($posts, 'views')) {
                $views = (int)$posts->views;
            }
            
            // 检查是否有缩略图
            $hasThumbnail = false;
            $thumbnail = '';
            
            // 方法1: 通过自定义字段获取
            if (method_exists($posts, 'fields')) {
                $fields = $posts->fields;
                if (is_array($fields) && isset($fields['thumb'])) {
                    $hasThumbnail = true;
                    $thumbnail = $fields['thumb'];
                }
            }
            
            // 方法2: 从内容中提取第一张图片
            if (!$hasThumbnail) {
                $content = $posts->content;
                if (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches)) {
                    $hasThumbnail = true;
                    $thumbnail = $matches[1];
                }
            }
            
            // 构建文章数据数组
            $postData = [
                'cid' => $posts->cid,
                'title' => $posts->title,
                'slug' => $posts->slug,
                'permalink' => $posts->permalink,
                'excerpt' => $posts->excerpt,
                'content' => $posts->content,
                'text' => $posts->text,
                'created' => $posts->created,
                'modified' => $posts->modified,
                'authorId' => $posts->authorId,
                'authorName' => $posts->author->name,
                'authorPermalink' => $posts->author->permalink,
                'commentsNum' => (int)$posts->commentsNum,
                'categoryId' => $categoryArray['id'] ?? 0,
                'categoryName' => $categoryArray['name'] ?? '',
                'categoryPermalink' => $categoryArray['permalink'] ?? '',
                'tags' => $tags,
                'views' => $views,
                'isTop' => (bool)$posts->isTop,
                'hasThumbnail' => $hasThumbnail,
                'thumbnail' => $thumbnail
            ];
            
            $postList[] = $postData;
        }
        
        // 重置指针
        $posts->reset();
        
        return $postList;
        
    } catch (Exception $e) {
        // 记录错误但不中断页面
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

