		</div>
    </div>
</div>
<footer id="footer">
	<div class="container">
		&copy; <?php echo date('Y'); ?> <a rel="nofollow" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. 模板由<a href="http://pagecho.com">cho</a>制作 | <a href="http://pagecho.com">Rao</a>修改 | 本版本支持Typecho 1.3.0
	</div>
</footer>
<?php $this->footer(); ?>

<!-- 返回顶部按钮 -->
<a href="#" id="back-to-top" class="back-to-top" title="返回顶部">
    <i class="fas fa-square-caret-up"></i>
</a>

<!-- 返回顶部脚本 -->
<script type="text/javascript">
// 使用DOMContentLoaded事件，确保DOM加载完成后执行
document.addEventListener('DOMContentLoaded', function() {
    var backToTop = document.getElementById('back-to-top');
    
    // 检查元素是否存在
    if (!backToTop) {
        console.error('返回顶部按钮元素未找到');
        return;
    }
    
    // 获取滚动元素（兼容不同浏览器）
    function getScrollElement() {
        return document.scrollingElement || document.documentElement || document.body;
    }
    
    // 显示/隐藏返回顶部按钮
    function toggleBackToTop() {
        var scrollTop = getScrollElement().scrollTop;
        if (scrollTop > 300) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    }
    
    // 初始检查
    toggleBackToTop();
    
    // 滚动时检查
    window.addEventListener('scroll', toggleBackToTop);
    
    // 点击返回顶部
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        
        var scrollElement = getScrollElement();
        var start = scrollElement.scrollTop;
        var end = 0;
        var duration = 500;
        var startTime = null;
        
        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            var timeElapsed = currentTime - startTime;
            var progress = Math.min(timeElapsed / duration, 1);
            // 使用更简单的缓动函数
            var easeOutQuad = 1 - (1 - progress) * (1 - progress);
            var distance = start * (1 - easeOutQuad) + end * easeOutQuad;
            
            scrollElement.scrollTop = distance;
            
            if (timeElapsed < duration) {
                requestAnimationFrame(animation);
            }
        }
        
        requestAnimationFrame(animation);
    });
});
</script>
</body>
</html>
