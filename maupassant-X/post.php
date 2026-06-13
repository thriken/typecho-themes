<?php $this->need('header.php'); ?>
<div class="col-8" id="main">
	<div class="res-cons">
		<article class="post">
			<h1 class="post-title"><?php $this->title() ?></h1>
			<div class="post-meta">
					<i class="fas fa-calendar-alt"></i> <?php $this->date('Y年m月d日'); ?>
					<?php if ($this->categories): ?>
					<span class="category"><i class="fas fa-folder"></i> <?php $this->category(', '); ?></span>
					<?php endif; ?>
					<span class="views-count"><i class="fas fa-eye"></i> <?php if(isset($this->views)) echo $this->views; else echo '0'; ?> 浏览</span>
					<span class="comment-count"><i class="fas fa-comment"></i> <?php $this->commentsNum('0 评论', '1 评论', '%d 评论'); ?></span>
				</div>
			<div class="post-content">
				<?php $this->content(); ?>
			</div>
			
			<!-- 文章底部信息 -->
			<div class="post-footer">
				<!-- 标签 -->
				<div class="post-tags">
					<?php if ($this->tags): ?>
					<i class="fas fa-tags"></i>
					<?php $this->tags(', ', true, '无标签'); ?>
					<?php endif; ?>
				</div>
				
				<!-- 分享按钮 -->
				<div class="post-share">
					<a href="http://service.weibo.com/share/share.php?url=<?php echo urlencode($this->permalink()); ?>&title=<?php echo urlencode($this->title()); ?>&pic=<?php echo urlencode($this->permalink()); ?>" target="_blank" class="share-weibo">
						<i class="fas fa-share-alt"></i> 分享到微博
					</a>
				</div>
			</div>
		</article>
		
		<!-- 上一篇下一篇导航 -->
		<div class="post-nav">
			<?php $this->thePrev('%s', '没有了'); ?>
			<?php $this->theNext('%s', '没有了'); ?>
		</div>
		
		<?php $this->need('comments.php'); ?>
	</div>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
