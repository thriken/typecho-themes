<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        $commentClass .= ($comments->authorId == $comments->ownerId) ? ' comment-by-author' : ' comment-by-user';
    }
    $levelClass = ($comments->levels > 0) ? ' comment-child' : '';
?>
<li id="li-<?php $comments->theId(); ?>" class="comment-item<?php echo $commentClass . $levelClass; ?>">
  <div id="<?php $comments->theId(); ?>" class="comment-body">
    <div class="comment-avatar"><?php $comments->gravatar('40', ''); ?></div>
    <div class="comment-main">
      <div class="comment-header">
        <span class="comment-author">
          <?php if ($comments->url): ?><a href="<?php $comments->url(); ?>" rel="external nofollow" target="_blank"><?php endif; ?>
          <?php $comments->author(); ?>
          <?php if ($comments->url): ?></a><?php endif; ?>
        </span>
        <?php if ($comments->authorId == $comments->ownerId): ?><span class="comment-badge">作者</span><?php endif; ?>
        <time class="comment-time"><?php $comments->date('Y-m-d H:i'); ?></time>
      </div>
      <div class="comment-content"><?php $comments->content(); ?></div>
      <div class="comment-actions">
        <?php $comments->reply('回复'); ?>
      </div>
    </div>
  </div>
  <?php if ($comments->children): ?>
  <ol class="comment-children">
    <?php $comments->threadedComments($options); ?>
  </ol>
  <?php endif; ?>
</li>
<?php } ?>

<div id="comments" class="comments-area">
  <?php $this->comments()->to($comments); ?>

  <?php if ($comments->have()): ?>
  <h3 class="comments-title">
    <?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?>
  </h3>

  <ol class="comment-list">
    <?php $comments->listComments(['callback' => 'threadedComments', 'replyWord' => '回复']); ?>
  </ol>

  <?php $comments->pageNav('&laquo;', '&raquo;'); ?>
  <?php endif; ?>

  <?php if ($this->allow('comment')): ?>
  <div id="<?php $this->respondId(); ?>" class="comment-respond">
    <!-- 取消回复链接：PHP 生成的 link 只在 detected reply 状态出现；我们硬编码一份用 JS 控制 -->
    <a rel="nofollow" id="cancel-comment-reply-link" href="javascript:void(0);" onclick="return TypechoComment.cancelReply();" style="display:none;">取消回复</a>
    <?php $comments->cancelReply('取消回复'); ?>

    <h3 class="respond-title" id="response"><?php _e('添加新评论'); ?></h3>

    <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" role="form">
      <?php if ($this->user->hasLogin()): ?>
      <p class="comment-login-info">
        <?php _e('登录身份'); ?>: <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
        <a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?> &raquo;</a>
      </p>
      <?php else: ?>
      <div class="comment-fields">
        <p><label for="author" class="required"><?php _e('称呼'); ?></label>
          <input type="text" name="author" id="author" value="<?php $this->remember('author'); ?>" required /></p>
        <p><label for="mail" <?php if ($this->options->commentsRequireMail): ?>class="required"<?php endif; ?>><?php _e('邮箱'); ?></label>
          <input type="email" name="mail" id="mail" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?>/></p>
        <p><label for="url"><?php _e('网站'); ?></label>
          <input type="url" name="url" id="url" placeholder="http://" value="<?php $this->remember('url'); ?>" /></p>
      </div>
      <?php endif; ?>

      <input type="hidden" name="parent" id="comment-parent" value="0" />
      <input type="hidden" name="_" value="<?php echo Typecho_Widget::widget('Widget_Security')->getToken($this->request->getRequestUrl()); ?>" />

      <p class="comment-textarea-wrap">
        <label for="textarea"><?php _e('内容'); ?></label>
        <textarea rows="6" cols="50" name="text" id="textarea" class="comment-textarea" required placeholder="写下你的想法..."><?php $this->remember('text', false); ?></textarea>
      </p>

      <p class="comment-submit-wrap">
        <button type="submit" class="comment-submit-btn"><?php _e('提交评论'); ?></button>
      </p>
    </form>
  </div><!-- end #respond -->

  <script>
  (function() {
    var respondId = '<?php $this->respondId(); ?>';
    var isReplying = false;

    window.TypechoComment = {
      dom: function(id) { return document.getElementById(id); },

      reply: function(cid, coid) {
        if (isReplying) return false; // 防止重复点击
        isReplying = true;

        try {
          var comment = this.dom(cid);
          if (!comment) { isReplying = false; return false; }

          var response = this.dom(respondId);
          if (!response) { isReplying = false; return false; }

          var input = this.dom('comment-parent');
          var textarea = this.dom('textarea');
          var cancelLink = this.dom('cancel-comment-reply-link');

          // 设置父评论 ID
          if (input) input.value = coid;

          // 显示取消回复链接
          if (cancelLink) cancelLink.style.display = '';

          // 把回复框移到被回复评论的下方
          if (!response.classList.contains('respond-inline')) {
            var commentLi = comment;
            while (commentLi && !/comment-item/i.test(commentLi.className)) {
              commentLi = commentLi.parentElement;
            }
            // 存占位节点
            var holder = document.createElement('div');
            holder.id = 'comment-form-place-holder';
            response.parentNode.insertBefore(holder, response);
            if (commentLi) {
              commentLi.after(response);
              response.classList.add('respond-inline');
            }
          }

          // 聚焦到文本框
          if (textarea) {
            textarea.focus();
            var authorEl = comment.querySelector('.comment-author');
            var authorName = authorEl ? authorEl.textContent.replace(/\s+/g, ' ').trim() : '';
            textarea.placeholder = authorName ? '\u56de\u590d @' + authorName + '\uff1a' : '\u56de\u590d\uff1a';
          }

          // 滚动到回复框
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

        // 隐藏取消回复链接
        if (cancelLink) cancelLink.style.display = 'none';

        // 回复框移回原位
        if (holder && response) {
          response.classList.remove('respond-inline');
          holder.parentNode.replaceChild(response, holder);
        }

        // 重置 placeholder
        if (textarea) textarea.placeholder = '\u5199\u4e0b\u4f60\u7684\u60f3\u6cd5...';

        // 滚回顶部
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
      }
    };
  })();
  </script>

  <?php else: ?>
  <p class="comments-closed"><?php _e('评论已关闭'); ?></p>
  <?php endif; ?>

</div><!-- end #comments -->

