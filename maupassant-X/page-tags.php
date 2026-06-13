<?php    
   /**  
    * tags    
    * @package custom   
    */    
$this->need('header.php');?>   
<div class="col-8" id="main">
	<div class="res-cons">
            <article class="post">
                <div class="post-content-pages">
                    <h2>标签云</h2>
                    <div class="tag-cloud">
                        <?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 50))->to($tags); ?>
                        <?php while($tags->next()): ?>
                            <a href="<?php $tags->permalink(); ?>" style="font-size: 14px; margin: 0 10px 10px 0; display: inline-block; padding: 4px 12px; border: 1px solid #ddd; border-radius: 100px; color: #666; text-decoration: none;"><?php $tags->name(); ?></a>
                        <?php endwhile; ?>
                    </div>
                </div>
    		</article>
	</div>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>