<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. All rights reserved.</p>
            <p style="margin-top: 8px; font-size: 0.75rem; opacity: 0.7;">Powered by <a href="http://typecho.org/" target="_blank">Typecho</a> &middot; Theme <a href="#">NewProj</a></p>
        </div>
    </footer>

    <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
    <?php $this->footer(); ?>
</body>
</html>
