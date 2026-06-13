<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->

 <!-- 底部信息 -->
    <footer class="footer">
        <div class="container">
            <div class="footer-item">
                <h4>政务链接</h4>
                <ul>
                    <li><a href="#">中国政府网</a></li>
                    <li><a href="#">山东省政府网</a></li>
                    <li><a href="#">滨州市政府网</a></li>
                    <li><a href="#">区县政府网</a></li>
                </ul>
            </div>
            <div class="footer-item">
                <h4>便民服务</h4>
                <ul>
                    <li><a href="#">社保查询</a></li>
                    <li><a href="#">公积金查询</a></li>
                    <li><a href="#">违章查询</a></li>
                    <li><a href="#">医保报销</a></li>
                    <li><a href="#">学历查询</a></li>
                </ul>
            </div>
            <div class="footer-item">
                <h4>便民服务</h4>
                <ul>
                    <li><a href="#">社保查询</a></li>
                    <li><a href="#">公积金查询</a></li>
                    <li><a href="#">违章查询</a></li>
                    <li><a href="#">医保报销</a></li>
                    <li><a href="#">学历查询</a></li>
                </ul>
            </div>
            <div class="footer-item">
                <h4>联系我们</h4>
                <ul>
                    <li>地址：XX市XX县行政中心大楼</li>
                    <li>电话：0543-XXXXXXX</li>
                    <li>邮编：256500</li>
                    <li>邮箱：xxzf@163.com</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="https://typecho.org">Typecho</a> 强力驱动'); ?>.
        </div>
    </footer>
<?php $this->footer(); ?>
</body>
</html>
