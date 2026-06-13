<?php

function themeConfig($form) {

    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('ShowRecentPosts' => _t('显示最新文章'),
    'ShowRecentComments' => _t('显示最近回复'),
    'ShowCategory' => _t('显示分类'),
    'ShowArchive' => _t('显示归档'),
    'ShowLinks' => _t('显示友情链接'),
    'ShowOther' => _t('显示其它杂项')),
    array('ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowLinks', 'ShowOther'), _t('侧边栏显示'));
    
    $form->addInput($sidebarBlock->multiMode());
    
    $links = new Typecho_Widget_Helper_Form_Element_Textarea('links', NULL, '', _t('友情链接'), _t('格式: 链接名称,链接地址 每行一个'));
    $form->addInput($links);
    
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, '', _t('Logo图片地址'), _t('请输入图片网址，留空则使用文字标题'));
    $form->addInput($logoUrl);
    
    $faviconUrl = new Typecho_Widget_Helper_Form_Element_Text('faviconUrl', NULL, '', _t('Favicon图标地址'), _t('请输入图片网址，留空则使用默认图标'));
    $form->addInput($faviconUrl);
}

function threadedComments($comments, $options) {
    $commentClass = 'comment';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        }
    }
    
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    $depthClass = ' comment-level-' . $comments->levels;
?>
<li id="<?php $comments->theId(); ?>" class="<?php echo $commentClass . $commentLevelClass . $depthClass; ?>">
    <div class="comment-body">
        <div class="comment-avatar">
            <?php 
            $email = $comments->mail;
            $hash = md5(strtolower(trim($email)));
            $avatarUrl = 'https://cravatar.cn/avatar/' . $hash . '?s=48';
            $author = $comments->author;
            echo '<img src="' . $avatarUrl . '" alt="' . $author . '" class="avatar" width="48" height="48" />';
            ?>
        </div>
        <div class="comment-main">
            <div class="comment-meta">
                <cite class="fn"><?php $comments->author(); ?></cite>
                <span class="comment-time">
                    <a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a>
                    <?php $comments->reply(); ?>
                </span>
            </div>
            <div class="comment-content">
                <?php $comments->content(); ?>
            </div>
        </div>
    </div>
    <?php if ($comments->children) { ?>
    <ul class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </ul>
    <?php } ?>
</li>
<?php
}

// 浏览量统计功能
function getPostView($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
}

// 为Widget_Archive添加views属性
Typecho_Plugin::factory('Widget_Archive')->beforeRender = function($archive) {
    if ($archive->is('single') || $archive->is('page')) {
        $cid = $archive->cid;
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
        $archive->views = isset($row['views']) ? $row['views'] : 0;
        // 更新浏览量
        $db->query($db->update('table.contents')->rows(array('views' => (int) $archive->views + 1))->where('cid = ?', $cid));
    }
};

// 修改Gravatar源为Cravatar镜像
function themeInit($archive) {
    // 修复Gravatar URL生成
    Typecho_Plugin::factory('Widget_Abstract_Comments')->gravatarUrl = function ($size, $rating, $default, $comments) {
        $hash = md5(strtolower(trim($comments->mail)));
        // 简化URL格式，确保Cravatar镜像能正确解析
        return 'https://cravatar.cn/avatar/' . $hash;
    };
}

// 直接修改Typecho的gravatarBaseUrl配置
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

try {
    $options = Typecho_Widget::widget('Widget_Options');
    $options->gravatarBaseUrl = 'https://cravatar.cn/avatar/';
} catch (Exception $e) {
    // 忽略错误
}
