<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>

<div id="<?php $comments->theId(); ?>" class="comment-body<?php echo $commentLevelClass; ?><?php echo $commentClass; ?>">
    <div class="comment-author" style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3B82F6, #8B5CF6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
            <?php echo mb_substr($comments->author, 0, 1, 'UTF-8'); ?>
        </div>
        <div>
            <span style="font-weight: 600;"><?php $comments->author(); ?></span>
            <?php if ($comments->authorId == $comments->ownerId): ?>
                <span style="font-size: 0.75rem; color: var(--color-primary); margin-left: 8px; padding: 2px 8px; background: rgba(59, 130, 246, 0.1); border-radius: 12px;">作者</span>
            <?php endif; ?>
            <div style="font-size: 0.8rem; color: var(--color-text-muted);">
                <?php $comments->date('Y-m-d H:i'); ?>
            </div>
        </div>
    </div>
    <div class="comment-content" style="margin-left: 52px; padding: 16px; background: var(--color-bg); border-radius: var(--radius-md); margin-bottom: 16px;">
        <?php $comments->content(); ?>
    </div>
    <div class="comment-meta" style="margin-left: 52px; margin-bottom: 16px;">
        <span class="comment-reply" style="font-size: 0.85rem;">
            <?php $comments->reply('回复'); ?>
        </span>
    </div>

    <?php if ($comments->children) { ?>
    <div class="comment-children" style="margin-left: 32px;">
        <?php $comments->threadedComments($options); ?>
    </div>
    <?php } ?>
</div>

<?php } ?>

<div id="comments" style="margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--color-border);">
    <?php $this->comments()->to($comments); ?>

    <?php if ($comments->have()): ?>
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 24px;">
        <?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?>
    </h3>

    <?php $comments->listComments(['callback' => 'threadedComments', 'replyWord' => '回复']); ?>
    <?php $comments->pageNav('&laquo;', '&raquo;'); ?>

    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond" style="margin-top: 40px;">
        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 20px;"><?php _e('发表评论'); ?></h3>

        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
            <p style="margin-bottom: 16px; color: var(--color-text-secondary);">
                <?php _e('登录身份: '); ?>
                <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
            </p>
            <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px;">
                <div>
                    <input type="text" name="author" id="author" placeholder="昵称 *" value="<?php $this->remember('author'); ?>" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: var(--radius-md); background: var(--color-bg); color: var(--color-text); font-size: 0.9rem; outline: none; transition: border-color 0.2s;">
                </div>
                <div>
                    <input type="email" name="mail" id="mail" placeholder="邮箱 *" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: var(--radius-md); background: var(--color-bg); color: var(--color-text); font-size: 0.9rem; outline: none; transition: border-color 0.2s;">
                </div>
                <div>
                    <input type="url" name="url" id="url" placeholder="网站" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: var(--radius-md); background: var(--color-bg); color: var(--color-text); font-size: 0.9rem; outline: none; transition: border-color 0.2s;">
                </div>
            </div>
            <?php endif; ?>

            <div style="margin-bottom: 16px;">
                <textarea rows="5" name="text" id="textarea" placeholder="写下你的评论..." required style="width: 100%; padding: 12px 14px; border: 1px solid var(--color-border); border-radius: var(--radius-md); background: var(--color-bg); color: var(--color-text); font-size: 0.9rem; outline: none; transition: border-color 0.2s; resize: vertical; font-family: inherit;"><?php $this->remember('text'); ?></textarea>
            </div>

            <input type="hidden" name="parent" id="comment-parent" value="0" />
            <input type="hidden" name="_" value="<?php echo Typecho_Widget::widget('Widget_Security')->getToken($this->request->getRequestUrl()); ?>" />

            <div style="display: flex; align-items: center; justify-content: space-between;">
                <button type="submit" class="btn-primary" style="border: none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    提交评论
                </button>
                <a rel="nofollow" id="cancel-comment-reply-link" href="javascript:void(0);" onclick="return TypechoComment.cancelReply();" style="display:none; font-size:0.85rem; color:var(--color-text-muted);">取消回复</a>
                <?php $comments->cancelReply(); ?>
            </div>
        </form>
    </div>
    <?php else: ?>
    <p style="text-align: center; padding: 24px; color: var(--color-text-muted);"><?php _e('评论已关闭'); ?></p>
    <?php endif; ?>
</div>

<style>
#comments input:focus,
#comments textarea:focus {
    border-color: var(--color-primary) !important;
}
#comments .comment-reply a {
    color: var(--color-primary);
    font-weight: 500;
}
#comments .comment-reply a:hover {
    text-decoration: underline;
}
</style>

<script>
(function() {
    var respondId = '<?php $this->respondId(); ?>';
    var isReplying = false;

    window.TypechoComment = {
        dom: function(id) { return document.getElementById(id); },

        reply: function(cid, coid) {
            if (isReplying) return false;
            isReplying = true;

            try {
                var comment = this.dom(cid);
                if (!comment) { isReplying = false; return false; }

                var response = this.dom(respondId);
                if (!response) { isReplying = false; return false; }

                var input = this.dom('comment-parent');
                var textarea = this.dom('textarea');
                var cancelLink = this.dom('cancel-comment-reply-link');

                if (input) input.value = coid;
                if (cancelLink) cancelLink.style.display = '';

                // 把回复框移到被回复评论的下方
                if (!response.classList.contains('respond-inline')) {
                    var holder = document.createElement('div');
                    holder.id = 'comment-form-place-holder';
                    response.parentNode.insertBefore(holder, response);
                    comment.after(response);
                    response.classList.add('respond-inline');
                }

                // 聚焦文本框
                if (textarea) {
                    textarea.focus();
                    var authorEl = comment.querySelector('.comment-author .fw');
                    if (!authorEl) authorEl = comment.querySelector('.comment-author span');
                    var authorName = authorEl ? authorEl.textContent.replace(/\s+/g, ' ').trim() : '';
                    textarea.placeholder = authorName ? '回复 @' + authorName + '：' : '回复：';
                }

                if (response.scrollIntoView) {
                    response.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            } catch (e) {}
            isReplying = false;
            return false;
        },

        cancelReply: function() {
            var response = this.dom(respondId);
            var holder = this.dom('comment-form-place-holder');
            var input = this.dom('comment-parent');
            var textarea = this.dom('textarea');
            var cancelLink = this.dom('cancel-comment-reply-link');

            if (input) input.value = '0';
            if (cancelLink) cancelLink.style.display = 'none';

            if (holder && response) {
                response.classList.remove('respond-inline');
                holder.parentNode.replaceChild(response, holder);
            }

            if (textarea) textarea.placeholder = '写下你的评论...';
            return false;
        }
    };
})();
</script>
