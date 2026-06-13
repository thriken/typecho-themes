    </div><!-- /.main-content-area -->
</div><!-- /.layout-wrapper -->

<!-- 页脚 -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="site-footer__inner">
            <!-- 友情链接 -->
            <?php $links = govtech_getLinks(); if (!empty($links)): ?>
            <div class="footer-links">
                <span class="footer-links__label">友情链接：</span>
                <?php foreach ($links as $link): ?>
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" class="footer-links__item" target="_blank" rel="noopener"><?php echo htmlspecialchars($link['name']); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="footer-info">
                <div class="footer-info__copyright">
                    <p>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. 版权所有</p>
                    <?php if ($this->options->icp): ?>
                        <p class="footer-icp">
                            <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener noreferrer"><?php $this->options->icp(); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="footer-info__powered">
                    <p>Powered by <a href="https://typecho.org" target="_blank" rel="noopener">Typecho</a>
                    &nbsp;·&nbsp; Theme <strong>GovTech</strong></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- 返回顶部 -->
<button class="back-to-top" id="js-back-to-top" aria-label="返回顶部" title="返回顶部">
    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 0 1 0-1.414l6-6a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1-1.414 1.414L11 5.414V17a1 1 0 1 1-2 0V5.414L4.707 9.707a1 1 0 0 1-1.414 0z" clip-rule="evenodd"/>
    </svg>
</button>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $( ".fancybox").fancybox();
    });
</script>
<script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
<?php $this->footer(); ?>
</body>
</html>
