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
<li id="li-<?php $comments->theId(); ?>" class="comment-item<?php echo $commentClass . $commentLevelClass; ?>">
  <div id="<?php $comments->theId(); ?>" class="sa-d-flex sa-gap-3">
    <div class="author-avatar">
      <?php $comments->gravatar('48', ''); ?>
    </div>
    <div class="sa-flex-1">
      <div class="sa-d-flex sa-align-center sa-gap-2">
        <cite class="comment-author">
          <?php if ($comments->url): ?><a href="<?php $comments->url(); ?>" rel="external nofollow"><?php endif; ?>
          <?php $comments->author(); ?>
          <?php if ($comments->url): ?></a><?php endif; ?>
        </cite>
        <?php if ($comments->authorId == $comments->ownerId): ?>
        <span class="sb-comment-badge">作者</span>
        <?php endif; ?>
      </div>
      <div class="comment-meta">
        <time datetime="<?php $comments->date('c'); ?>"><?php $comments->date('Y-m-d H:i'); ?></time>
      </div>
      <div class="comment-content">
        <?php $comments->content(); ?>
      </div>
      <div class="sa-mt-2">
        <?php $comments->reply('<i class="fa-solid fa-reply"></i> 回复'); ?>
      </div>
    </div>
  </div>

  <?php if ($comments->children): ?>
  <div class="comment-children sa-ml-2">
    <?php $comments->threadedComments($options); ?>
  </div>
  <?php endif; ?>
</li>
<?php } ?>

<div id="comments" class="sb-comments">
  <?php $this->comments()->to($comments); ?>

  <?php if ($comments->have()): ?>
  <h3 class="sa-mb-4">
    <?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?>
  </h3>

  <ol class="comment-list">
    <?php $comments->listComments(['callback' => 'threadedComments', 'replyWord' => '<i class="fa-solid fa-reply"></i> 回复']); ?>
  </ol>

  <?php $comments->pageNav('<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>', 3, '...', [
      'wrapTag' => 'div',
      'wrapClass' => 'sb-pagination sa-d-flex sa-justify-center sa-mt-4',
      'currentClass' => 'current',
  ]); ?>
  <?php endif; ?>

  <?php if ($this->allow('comment')): ?>
  <div id="<?php $this->respondId(); ?>" class="respond sa-mt-5">
    <h3 class="sa-mb-4">
      <?php _e('发表评论'); ?>
      <a id="cancel-reply-link" href="javascript:void(0)" onclick="return TypechoComment.cancelReply();" style="display:none;font-size:0.875rem;color:#94a3b8;margin-left:1rem;text-decoration:none;">&laquo; <?php _e('取消回复'); ?></a>
    </h3>

    <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" class="sb-comment-form" role="form">
      <!-- 安全令牌（Typecho 反垃圾验证必需） -->
      <input type="hidden" name="_" value="<?php echo Typecho_Widget::widget('Widget_Security')->getToken($this->request->getRequestUrl()); ?>" />
      <?php if (!$this->user->hasLogin()): ?>
      <div class="sa-row sa-mb-3">
        <div class="sa-col-md-8 sa-col-24 sa-mb-3">
          <div class="sa-form-item">
            <label class="sa-form-item__label" for="author"><?php _e('称呼'); ?></label>
            <div class="sa-form-item__content">
              <input type="text" name="author" id="author" class="sa-input" value="<?php $this->remember('author'); ?>" required placeholder="<?php _e('你的名字'); ?>">
            </div>
          </div>
        </div>
        <div class="sa-col-md-8 sa-col-24 sa-mb-3">
          <div class="sa-form-item">
            <label class="sa-form-item__label" for="mail"><?php _e('邮箱'); ?></label>
            <div class="sa-form-item__content">
              <input type="email" name="mail" id="mail" class="sa-input" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?> placeholder="<?php _e('你的邮箱'); ?>">
            </div>
          </div>
        </div>
        <div class="sa-col-md-8 sa-col-24 sa-mb-3">
          <div class="sa-form-item">
            <label class="sa-form-item__label" for="url"><?php _e('网站'); ?></label>
            <div class="sa-form-item__content">
              <input type="url" name="url" id="url" class="sa-input" value="<?php $this->remember('url'); ?>" placeholder="<?php _e('https://'); ?>">
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- 回复目标隐藏字段 -->
      <input type="hidden" name="parent" id="comment-parent" value="0" />

      <div class="sa-form-item sa-mb-3">
        <div class="sa-form-item__content">
          <textarea name="text" id="textarea" rows="5" class="sa-input" required placeholder="<?php _e('写下你的想法...'); ?>"><?php $this->remember('text', false); ?></textarea>
        </div>
      </div>

      <div class="sb-submit-row">
          <button type="submit" class="sb-submit-btn">
            <i class="fa-solid fa-paper-plane"></i> <?php _e('提交评论'); ?>
          </button>
      </div>
    </form>
  </div>

  <!-- 评论回复 JS -->
  <script type="text/javascript">
  (function() {
    var respondId = '<?php $this->respondId(); ?>';
    var isReplying = false;
    var holderEl = null;

    window.TypechoComment = {
      dom: function(id) { return document.getElementById(id); },
      reply: function(cid, coid) {
        try {
          var comment = this.dom(cid);
          if (!comment) return false;

          var response = this.dom(respondId);
          if (!response) return false;

          // 设置回复目标
          var input = document.getElementById('comment-parent');
          if (input) input.value = coid;

          // 取消链接显示
          var cancelLink = document.getElementById('cancel-reply-link');
          if (cancelLink) cancelLink.style.display = '';

          // 移动表单到目标评论之后
          var commentLi = comment.closest ? comment.closest('.comment-item') : null;
          if (!commentLi) {
            // 兼容：向上查找 li
            commentLi = comment.parentNode;
            while(commentLi && commentLi.tagName !== 'LI'){
              commentLi = commentLi.parentNode;
            }
          }

          if (commentLi && response && !isReplying) {
            holderEl = document.createElement('div');
            holderEl.id = 'comment-form-place-holder';
            response.parentNode.insertBefore(holderEl, response);
            commentLi.parentNode.insertBefore(response, commentLi.nextSibling);
            response.classList.add('respond-inline');
            isReplying = true;
          }

          // 聚焦输入框 + 更新 placeholder
          var textarea = this.dom('textarea');
          if (textarea) {
            textarea.focus();
            var authorName = '用户';
            var authorEl = comment.querySelector('.comment-author');
            if (authorEl) authorName = authorEl.textContent.trim().split(/\s/)[0];
            textarea.placeholder = '\u56DE\u590D @' + authorName + '\uFF1A';
          }
        } catch(e) { console.error('TypechoComment.reply error:', e); }
        return false;
      },
      cancelReply: function() {
        try {
          var response = this.dom(respondId);
          var input = document.getElementById('comment-parent');
          var textarea = this.dom('textarea');

          // 隐藏取消链接
          var cancelLink = document.getElementById('cancel-reply-link');
          if (cancelLink) cancelLink.style.display = 'none';

          // 重置 parent
          if (input) input.value = '0';
          if (textarea) textarea.placeholder = '\u5199\u4E0B\u4F60\u7684\u60F3\u6CD5...';

          // 表单归位
          if (holderEl && response && holderEl.parentNode) {
            response.classList.remove('respond-inline');
            holderEl.parentNode.replaceChild(response, holderEl);
            holderEl = null;
          }
          isReplying = false;
        } catch(e) { console.error('TypechoComment.cancelReply error:', e); }
        return false;
      }
    };
  })();
  </script>
  <?php else: ?>
  <div class="sa-mt-4 sa-text-secondary">
    <i class="fa-solid fa-lock"></i> <?php _e('评论已关闭'); ?>
  </div>
  <?php endif; ?>
</div>
