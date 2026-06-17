<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</main>

  <!-- ===== Pre-Footer Ad ===== -->
  <?php if ($this->options->adPrefooter): ?>
  <div class="sb-ad-prefooter"><?php sbAd('adPrefooter'); ?></div>
  <?php endif; ?>

  <!-- ===== Footer ===== -->
  <footer class="sb-footer">
    <div class="sa-container-content">
      <div class="sa-row">
        <div class="sa-col-lg-18 sa-col-24">
          <?php if ($this->options->footerText): ?>
          <div class="sa-mb-3"><?php $this->options->footerText(); ?></div>
          <?php endif; ?>
          <p>&copy; <?php echo date('Y'); ?> <?php $this->options->title(); ?>. Powered by <a href="https://typecho.org" target="_blank" rel="noopener">Typecho</a> &amp; <a href="https://www.sanoui.com" target="_blank" rel="noopener">SanoUI</a>. </p>
          <?php if ($this->options->beianNumber): ?>
          <div class="sb-footer-beian">
            <a href="<?php $this->options->beianUrl(); ?>" target="_blank" rel="noopener nofollow"><?php $this->options->beianNumber(); ?></a>
          </div>
          <?php endif; ?>
        </div>
        <div class="sa-col-lg-6 sa-col-24 sa-text-right" style="text-align:right;">
          <p class="sa-text-secondary">Theme by SanoBlog</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top -->
  <button class="sb-backtop" id="sbBackTop" title="返回顶部">
    <i class="fa-solid fa-chevron-up"></i>
  </button>

  <!-- Theme JS (extracted from inline) -->
  <script src="<?php $this->options->themeUrl('assets/theme.js?v=1.0'); ?>"></script>

  <!-- Stats Code -->
  <?php if ($this->options->statsCode): ?>
  <?php $this->options->statsCode(); ?>
  <?php endif; ?>

  <?php $this->footer(); ?>
  </body>
  </html>
