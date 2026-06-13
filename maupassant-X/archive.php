<?php 
// 定义翻译函数，消除IDE错误提示
if (!function_exists('_t')) {
    function _t($text) {
        return $text;
    }
}
if (!function_exists('_e')) {
    function _e($text) {
        echo $text;
    }
}
$this->need('header.php'); ?>
<div class="col-8" id="main">
	<div class="res-cons">
        <h3 class="archive-title"><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?>
		</h3>
        <?php if ($this->have()): ?>
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
        <?php else: ?>
            <article class="post">
                <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
            </article>
        <?php endif; ?>
        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
	</div>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
