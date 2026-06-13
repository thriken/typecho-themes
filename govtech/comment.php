<?php
// Govtech主题评论页 - 基于默认主题，添加自定义UI
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 自定义评论回调函数 - 紧凑横向布局
function threadedComments($comment, $singleCommentOptions) {
    $depth = $comment->getDepth();
    $isAuthor = $comment->authorId == $comment->ownerId;
    ?>
    <li id="<?php $comment->theId(); ?>" class="comment-body<?php if ($depth > 1) echo ' comment-child'; ?><?php if ($isAuthor) echo ' comment-by-author'; ?>">
        <div class="comment-inner">
            <!-- 左侧：头像 -->
            <div class="comment-avatar">
                <?php $comment->gravatar(32, 'mm'); ?>
            </div>
            
            <!-- 右侧：内容区 -->
            <div class="comment-main">
                <!-- 第一行：头部信息（作者、日期、回复） -->
                <div class="comment-header-row">
                    <span class="comment-author<?php if ($isAuthor) echo ' comment-author--admin'; ?>">
                        <?php $comment->author(); ?>
                        <?php if ($isAuthor): ?><span class="comment-badge">作者</span><?php endif; ?>
                    </span>
                    <span class="comment-meta">
                        <a href="<?php $comment->permalink(); ?>"><?php $comment->date('Y-m-d H:i'); ?></a>
                    </span>
                    <span class="comment-reply">
                        <?php $comment->reply(); ?>
                    </span>
                </div>
                
                <!-- 第二行：评论内容 -->
                <div class="comment-content">
                    <?php $comment->content(); ?>
                </div>
            </div>
        </div>
        
        <!-- 子评论 -->
        <?php if ($comment->children): ?>
            <div class="comment-children">
                <?php $comment->threadedComments(); ?>
            </div>
        <?php endif; ?>
    </li>
    <?php
}
?>

<section class="comments-section" id="comments">
    <?php $this->comments()->to($comments); ?>
    
    <!-- 评论列表 -->
    <?php if ($comments->have()): ?>
        <h2 class="comments-section__title">
            <?php $this->commentsNum('评论 (0)', '评论 (1)', '评论 (%d)'); ?>
        </h2>
        
        <ol class="comment-list">
            <?php $comments->listComments(); ?>
        </ol>
        
        <!-- 分页导航 -->
        <div class="comments-page-nav">
            <?php $comments->pageNav(); ?>
        </div>
    <?php else: ?>
        <h2 class="comments-section__title">评论 (0)</h2>
        <p class="comments-section__empty">暂无评论，来发表第一条评论吧。</p>
    <?php endif; ?>
    
    <!-- 评论表单 -->
    <?php if ($this->allow('comment')): ?>
        <div class="comment-form-wrap" id="<?php $this->respondId(); ?>">
            <!-- 取消回复 -->
            <div class="cancel-reply">
                <?php $comments->cancelReply(); ?>
            </div>
            
            <h3 class="comment-form__title">发表评论</h3>
            
            <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" class="comment-form comment-form--layout-41">
                <div class="comment-form__layout">
                    <!-- 左侧：文本区域 (占4/5) -->
                    <div class="comment-form__textarea-container">
                        <?php if ($this->user->hasLogin()): ?>
                            <p class="comment-form__logged">
                                <span class="comment-form__logged-avatar">
                                    <?php $this->user->gravatar(24, 'mm'); ?>
                                </span>
                                <span>您已以 <strong><?php $this->user->screenName(); ?></strong> 身份登录</span>
                                <a href="<?php $this->options->logoutUrl(); ?>" class="logout-link">退出</a>
                            </p>
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="textarea" class="form-label">评论内容 <span class="required">*</span></label>
                            <textarea id="textarea" name="text" rows="4" class="form-textarea" required 
                                placeholder="请输入您的评论..."><?php $this->remember('text'); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- 右侧：表单字段 (占1/5) -->
                    <div class="comment-form__fields-container">
                        <?php if (!$this->user->hasLogin()): ?>
                            <div class="form-group form-group--compact">
                                <label for="author" class="form-label">昵称 <span class="required">*</span></label>
                                <input type="text" id="author" name="author" class="form-input form-input--compact" required 
                                    value="<?php $this->remember('author'); ?>" placeholder="请输入昵称">
                            </div>
                            
                            <div class="form-group form-group--compact">
                                <label for="mail" class="form-label">邮箱 <span class="required">*</span></label>
                                <input type="email" id="mail" name="mail" class="form-input form-input--compact" required 
                                    value="<?php $this->remember('mail'); ?>" placeholder="example@mail.com">
                            </div>
                            
                            <div class="form-group form-group--compact">
                                <label for="url" class="form-label">网址</label>
                                <input type="url" id="url" name="url" class="form-input form-input--compact"
                                    value="<?php $this->remember('url'); ?>" placeholder="https://example.com">
                            </div>
                        <?php endif; ?>
                        
                        <!-- 提交按钮 -->
                        <div class="form-group form-group--compact">
                            <button type="submit" class="btn btn--primary btn--block"><?php _e('提交评论'); ?></button>
                        </div>
                        
                        <?php if ($this->options->commentsAntiSpam): ?>
                            <?php $comments->antiSpamField(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    <?php else: ?>
        <h3 class="comments-section__closed"><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</section>
