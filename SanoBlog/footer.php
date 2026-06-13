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

  <!-- Theme JS -->
  <script>
  (function(){
    // Theme toggle (dark/light)
    function applyTheme(theme) {
      document.documentElement.setAttribute('data-theme', theme);
      try { localStorage.setItem('sb-theme', theme); } catch(e) {}
    }

    function getPreferredTheme() {
      // 1. User saved preference
      var saved = null;
      try { saved = localStorage.getItem('sb-theme'); } catch(e) {}
      if (saved === 'dark' || saved === 'light') return saved;
      // 2. System preference
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) return 'dark';
      return 'light';
    }

    // Apply on load
    applyTheme(getPreferredTheme());

    // Toggle button
    var toggleBtn = document.getElementById('sbThemeToggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', function() {
        var current = document.documentElement.getAttribute('data-theme');
        applyTheme(current === 'dark' ? 'light' : 'dark');
      });
    }

    // Listen for system preference changes
    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        // Only auto-switch if user hasn't manually set a preference
        var saved = null;
        try { saved = localStorage.getItem('sb-theme'); } catch(ex) {}
        if (!saved) {
          applyTheme(e.matches ? 'dark' : 'light');
        }
      });
    }

    // Back to top visibility
    var btn = document.getElementById('sbBackTop');
    if (btn) {
      var _scrollLock = false; // 防止点击后 scroll 事件立刻把按钮显示回来

      btn.addEventListener('click', function() {
        btn.classList.remove('visible');
        _scrollLock = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // smooth scroll 结束后解锁（约 500ms）
        setTimeout(function(){ _scrollLock = false; }, 500);
      });

      window.addEventListener('scroll', function() {
        if (_scrollLock) return;
        btn.classList.toggle('visible', window.scrollY > 300);
      });
    }

    // Mobile nav: close on outside click
    document.addEventListener('click', function(e){
      var nav = document.querySelector('.sb-nav-desktop');
      var toggle = document.querySelector('.sb-nav-toggle');
      if (nav && nav.classList.contains('open') && !nav.contains(e.target) && e.target !== toggle && !toggle.contains(e.target)) {
        nav.classList.remove('open');
      }
    });

    // View mode switcher (list/grid) — saves to cookie, reloads page
    (function(){
      document.querySelectorAll('.sb-view-toggle button').forEach(function(btn){
        btn.addEventListener('click', function(){
          var mode = this.dataset.mode;
          // Set cookie with 1 year expiry, path /
          var d = new Date();
          d.setFullYear(d.getFullYear() + 1);
          document.cookie = 'sb_layout=' + mode + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
          // Reload to apply server-side
          window.location.reload();
        });
      });
    })();
  })();
  </script>

  <!-- Stats Code -->
  <?php if ($this->options->statsCode): ?>
  <?php $this->options->statsCode(); ?>
  <?php endif; ?>

  <?php $this->footer(); ?>
  </body>
  </html>
