<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->

 <!-- 底部信息 -->
    <footer class="footer">
        <div class="container">
            <?php
            // 前 3 栏：后台 textarea 配置，格式 "名称|URL"
            for ($i = 1; $i <= 3; $i++):
                $colKey = 'footerCol' . $i;
                $raw = trim($this->options->{$colKey});
                $lines = $raw ? array_filter(array_map('trim', explode("\n", $raw))) : [];
                // 默认标题
                $titles = [1 => '政务链接', 2 => '便民服务', 3 => '更多服务'];
            ?>
            <div class="footer-item">
                <h4><?php echo $titles[$i]; ?></h4>
                <ul>
                    <?php if (empty($lines)): ?>
                        <li style="opacity:.5;">暂未配置</li>
                    <?php else: ?>
                        <?php foreach ($lines as $line):
                            $parts = explode('|', $line, 2);
                            $linkName = trim($parts[0]);
                            $linkUrl  = isset($parts[1]) ? trim($parts[1]) : '#';
                        ?>
                        <li><a href="<?php echo htmlspecialchars($linkUrl); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($linkName); ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endfor; ?>

            <!-- 第 4 栏：联系信息（后台直接填文本） -->
            <div class="footer-item">
                <h4>联系我们</h4>
                <ul>
                    <?php
                    $contactRaw = trim($this->options->footerContact);
                    $contactLines = $contactRaw ? array_filter(array_map('trim', explode("\n", $contactRaw))) : [];
                    if (empty($contactLines)):
                    ?>
                        <li style="opacity:.5;">请在后台配置</li>
                    <?php else: ?>
                        <?php foreach ($contactLines as $line): ?>
                        <li><?php echo htmlspecialchars($line); ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="https://typecho.org">Typecho</a> 强力驱动'); ?>.
        </div>
    </footer>
<?php $this->footer(); ?>
<script>
(function() {
    var body = document.body;
    var toggleBtn = document.getElementById('wide-screen-toggle');
    if (!toggleBtn) return;

    // 读取 localStorage 记录的状态
    if (localStorage.getItem('wideScreen') === '1') {
        body.classList.add('wide-screen');
    }

    // 根据当前状态更新按钮文字
    function updateBtnText() {
        toggleBtn.textContent = body.classList.contains('wide-screen') ? '窄屏' : '宽屏';
    }
    updateBtnText();

    // 点击切换
    toggleBtn.addEventListener('click', function() {
        body.classList.toggle('wide-screen');
        localStorage.setItem('wideScreen', body.classList.contains('wide-screen') ? '1' : '0');
        updateBtnText();
    });
})();
</script>
</body>
</html>
