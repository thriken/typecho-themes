<?php
/**
 * CoderBlog - 评论模板（支持代码高亮、嵌套回复）
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 评论回调函数（Typecho 标准签名：$comments 为当前评论对象，$options 为配置数组）
 */
function threadedComments($comments, $options)
{
    $commentClass = 'mb-4';
    if ($comments->authorId && $comments->authorId == $comments->ownerId) {
        $commentClass .= ' comment-by-author';
    }
    $colorSeed = crc32((string)$comments->author);
    $hueColors = ['blue','green','purple','pink','indigo','teal','orange','red','cyan','violet'];
    $avatarColor = $hueColors[abs($colorSeed) % count($hueColors)];
?>
<li id="li-<?php $comments->theId(); ?>" class="<?php echo $commentClass; ?>">
    <div id="<?php $comments->theId(); ?>" class="comment-body">
        <div class="flex gap-3">
            <!-- 头像 -->
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-<?php echo $avatarColor; ?>-100 dark:bg-<?php echo $avatarColor; ?>-900/30 flex items-center justify-center text-<?php echo $avatarColor; ?>-600 dark:text-<?php echo $avatarColor; ?>-400 font-bold text-sm">
                    <?php echo mb_substr((string)$comments->author, 0, 1, 'UTF-8'); ?>
                </div>
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-semibold text-sm text-gray-900 dark:text-white">
                        <?php $comments->author(); ?>
                    </span>
                    <?php if ($comments->authorId == $comments->ownerId): ?>
                    <span class="text-xs bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 px-1.5 py-0.5 rounded">作者</span>
                    <?php endif; ?>
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        <?php $comments->date('Y-m-d H:i'); ?>
                    </span>
                </div>

                <!-- 评论内容 -->
                <div class="text-sm text-gray-700 dark:text-gray-300 prose-content max-w-none">
                    <?php $comments->content(); ?>
                </div>

                <!-- 回复链接（使用 Typecho 内置回复机制） -->
                <div class="mt-2">
                    <?php $comments->reply('<i class="fas fa-reply mr-1"></i>回复'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 子评论（使用 threadedComments 方法递归渲染） -->
    <?php if ($comments->children): ?>
    <ul class="ml-10 mt-4 space-y-4 border-l-2 border-gray-100 dark:border-gray-700 pl-4">
        <?php $comments->threadedComments($options); ?>
    </ul>
    <?php endif; ?>
</li>
<?php } ?>

<div id="comments">
    <!-- 评论列表 -->
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
        <?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?>
    </h3>
    <ul class="space-y-4">
        <?php $comments->listComments(['callback' => 'threadedComments']); ?>
    </ul>
    <?php endif; ?>

    <!-- 评论表单 -->
    <?php if ($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
            <i class="fas fa-pencil-alt mr-2 text-sky-500"></i>发表评论
            <a id="cancel-reply-link" href="javascript:void(0)" onclick="return TypechoComment.cancelReply();" style="display:none;font-size:0.75rem;color:#94a3b8;margin-left:1rem;text-decoration:none;">&laquo; 取消回复</a>
        </h3>

        <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" role="form" class="space-y-4">
            <?php if ($this->user->hasLogin()): ?>
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <i class="fas fa-user"></i>
                <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                <a href="<?php $this->options->logoutUrl(); ?>" class="text-sky-600 dark:text-sky-400 hover:underline" title="退出">退出</a>
            </div>
            <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <input type="text" name="author" id="author" placeholder="昵称 *" required
                           class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition text-gray-800 dark:text-gray-200 text-sm"
                           value="<?php $this->remember('author'); ?>">
                </div>
                <div>
                    <input type="email" name="mail" id="mail" placeholder="邮箱<?php if($this->options->commentsRequireMail): ?> *<?php endif; ?>"
                           class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition text-gray-800 dark:text-gray-200 text-sm"
                           value="<?php $this->remember('mail'); ?>">
                </div>
                <div>
                    <input type="url" name="url" id="url" placeholder="网站 http://"
                           class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition text-gray-800 dark:text-gray-200 text-sm"
                           value="<?php $this->remember('url'); ?>">
                </div>
            </div>
            <?php endif; ?>

            <div>
                <textarea name="text" id="textarea" rows="5" placeholder="在这里写下你的评论..."
                          class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition text-gray-800 dark:text-gray-200 text-sm resize-y"><?php $this->remember('text', false); ?></textarea>
            </div>

            <!-- 回复目标隐藏字段 -->
            <input type="hidden" name="parent" id="comment-parent" value="0">

            <div class="flex items-center gap-3">
                <button type="submit" class="btn btn-primary text-sm">
                    <i class="fas fa-paper-plane mr-1"></i>提交评论
                </button>
            </div>
            <?php $security = $this->widget('Widget_Security'); ?>
            <input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getRequestUrl()); ?>">
        </form>
    </div>

    <!-- Typecho 内置评论回复脚本 -->
    <script type="text/javascript">
    (function() {
        window.TypechoComment = {
            dom: function(id) { return document.getElementById(id); },
            reply: function(cid, coid) {
                try {
                    var comment = this.dom(cid), response = this.dom('<?php $this->respondId(); ?>');
                    if (!comment || !response) return false;
                    document.getElementById('comment-parent').value = coid;
                    this.dom('cancel-reply-link').style.display = '';
                    var li = comment.closest ? comment.closest('li') : null;
                    if (!li) { li = comment.parentNode; while(li && li.tagName !== 'LI') li = li.parentNode; }
                    if (li && !window._cbHolderEl) {
                        window._cbHolderEl = document.createElement('div');
                        response.parentNode.insertBefore(window._cbHolderEl, response);
                        li.parentNode.insertBefore(response, li.nextSibling);
                    }
                    this.dom('textarea').focus();
                } catch(e) {}
                return false;
            },
            cancelReply: function() {
                try {
                    var response = this.dom('<?php $this->respondId(); ?>'), input = document.getElementById('comment-parent');
                    if (input) input.value = '0';
                    this.dom('cancel-reply-link').style.display = 'none';
                    if (window._cbHolderEl && response) {
                        window._cbHolderEl.parentNode.replaceChild(response, window._cbHolderEl);
                        window._cbHolderEl = null;
                    }
                } catch(e) {}
                return false;
            }
        };
    })();
    </script>
    <?php else: ?>
    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
        <i class="fas fa-lock mr-1"></i>评论已关闭
    </div>
    <?php endif; ?>
</div>
