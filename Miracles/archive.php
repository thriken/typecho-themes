<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('includes/head.php');
$this->need('includes/header.php');
?>
    <main class="main-container container" role="main">
	  <div class="post-list">
		<?php if ($this->have()): ?>
		<?php while($this->next()): ?>
             <div class="post-item">
                    <div class="container-fluid"><div class="row">
			  <div class="col-md-6 post-banner-box">
			    <a href="<?php $this->permalink(); ?>" class="post-link">
			      <div class="post-banner">
				    <img src="<?php echo Utils::addLoadingImages($this->options->CDN, $this->options->loading_image, 'normal'); ?>" data-gisrc="<?php Utils::postBanner($this); ?>">
				  </div>
				</a>
			  </div>
			  <div class="col-md-6 post-item-content">
			    <a href="<?php $this->permalink(); ?>" class="post-link">
				  <h1 class="post-title"><?php $this->sticky(); ?><?php $this->title(); ?></h1>
				</a>
				<p class="post-excerpt">
				  <?php if($this->fields->excerpt && $this->fields->excerpt!='') {
				    echo htmlspecialchars($this->fields->excerpt, ENT_QUOTES, 'UTF-8');
				  }else{
					echo $this->excerpt(130);
				  }
				  ?>
				</p>
				<p class="post-meta"><i class="iconfont icon-block"></i> <?php $this->category(','); ?>&emsp;<i class="iconfont icon-comments"></i> <?php $this->commentsNum('还没有评论', '仅一条评论', '%d'); ?>&emsp;<i class="iconfont icon-clock"></i> <?php $this->date(); ?></p>
				<p class="post-button-box large-screen"><a href="<?php $this->permalink(); ?>" class="button post-button">Read More</a></p>
			  </div>
			</div></div>
		  </div>
          <br />
		<?php endwhile; ?>
		  <div class="post-pagenav">
            <span class="post-pagenav-left"><?php $this->pageLink('<i class="iconfont icon-chevron-left"></i>'); ?></span>
		    <span class="post-pagenav-right"><?php $this->pageLink('<i class="iconfont icon-chevron-right"></i>','next'); ?></span>
		  </div>
		<?php else: ?>
		  <div class="post-empty">
		    <div class="post-empty-icon"><i class="iconfont icon-file"></i></div>
		    <h2><?php gtecho('otherTexts', 'emptyTitle'); ?></h2>
		    <p><?php gtecho('otherTexts', 'emptyDesc'); ?></p>
		    <p><a href="<?php $this->options->siteUrl(); ?>" class="button post-button"><?php gtecho('otherTexts', 'backHome'); ?></a></p>
		  </div>
		<?php endif; ?>
	    </div>
	  </div>
	</main>
<?php $this->need('includes/footer.php'); ?>
