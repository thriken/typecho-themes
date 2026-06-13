<?php
/**
 * 简单的响应式模板
 * 
 * @package Maupassant
 * @author cho
 * @version 1.3.0
 * @link https://github.com/pickcho/maupassant
 */
 $this->need('header.php');
 ?>
<div class="col-8" id="main">
	<div class="res-cons">
		<?php while($this->next()): ?>
			<article class="post">
				<h2 class="post-title">
					<a href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
				</h2>
				<div class="post-meta">
					<i class="fas fa-calendar-alt"></i> <?php $this->date('Y年m月d日'); ?>
					<?php if ($this->categories): ?>
					<span class="category"><i class="fas fa-folder"></i> <?php $this->category(', '); ?></span>
					<?php endif; ?>
					<span class="views-count"><i class="fas fa-eye"></i> <?php getPostView($this); ?> 浏览</span>
					<span class="comment-count"><i class="fas fa-comment"></i> <?php $this->commentsNum('0 评论', '1 评论', '%d 评论'); ?></span>
				</div>
				<div class="post-content">
					<?php $this->excerpt(200, '...'); ?>
					<div class="read-more"><a href="<?php $this->permalink() ?>">阅读全文</a></div>
				</div>
			</article>
		<?php endwhile; ?>
		<?php $this->pageNav('&laquo; 上一页','下一页 &raquo;',10,'...');?>
	</div>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
