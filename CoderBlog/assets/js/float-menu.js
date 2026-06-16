/**
 * CoderBlog - 左侧浮动菜单（首页 / 顶部 / 目录 / 评论区 / 文章底部）
 */
(function() {
    'use strict';
    var menu = document.getElementById('cb-float-menu');
    if (!menu) return;

    // 根据主内容区位置定位菜单
    function positionMenu() {
        var article = document.querySelector('article');
        if (!article) return;
        var rect = article.getBoundingClientRect();
        var left = rect.left - 56;
        if (left < 8) left = 8;
        menu.style.left = left + 'px';
    }

    // 返回顶部
    var btn = document.getElementById('cb-back-top');
    if (btn) btn.addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    // 评论区
    btn = document.getElementById('cb-to-comments');
    if (btn) {
        btn.addEventListener('click', function() {
            var el = document.getElementById('comments');
            if (el) {
                var header = document.querySelector('header') || {};
                var offset = (header.offsetHeight || 64) + 16;
                var y = el.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
            }
        });
    }

    // 文章底部
    btn = document.getElementById('cb-to-bottom');
    if (btn) {
        btn.addEventListener('click', function() {
            var article = document.querySelector('article');
            if (article) article.scrollIntoView({ behavior: 'smooth', block: 'end' });
        });
    }

    // 目录面板开关
    var tocToggle = document.getElementById('cb-toc-toggle');
    var tocPanel  = document.getElementById('cb-toc-panel');
    if (tocToggle && tocPanel) {
        function panelPosition() {
            var rect = menu.getBoundingClientRect();
            tocPanel.style.top  = (rect.top - 10) + 'px';
            tocPanel.style.left = (rect.right + 12) + 'px';
        }
        tocToggle.addEventListener('click', function(e) {
            e.preventDefault();
            var isOpen = !tocPanel.classList.contains('hidden');
            if (isOpen) {
                tocPanel.classList.add('hidden');
            } else {
                panelPosition();
                tocPanel.classList.remove('hidden');
            }
        });
        // 关闭按钮
        var tocClose = document.getElementById('cb-toc-close');
        if (tocClose) tocClose.addEventListener('click', function() { tocPanel.classList.add('hidden'); });
        // 点击面板外关闭
        document.addEventListener('click', function(e) {
            if (!tocPanel.classList.contains('hidden') && !tocPanel.contains(e.target) && e.target !== tocToggle && !tocToggle.contains(e.target)) {
                tocPanel.classList.add('hidden');
            }
        });
        // TOC 链接点击：平滑滚动 + 关闭面板
        tocPanel.addEventListener('click', function(e) {
            var a = e.target.closest('a.toc-link');
            if (!a) return;
            e.preventDefault();
            var header = document.querySelector('header') || {};
            var offset = (header.offsetHeight || 64) + 12;
            var target = document.querySelector(a.getAttribute('href'));
            if (target) {
                var y = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
            }
            tocPanel.classList.add('hidden');
        });
        // 滚动时高亮当前标题
        var tocLinks = tocPanel.querySelectorAll('a.toc-link');
        if (tocLinks.length) {
            window.addEventListener('scroll', function() {
                var h = document.querySelector('header') || {};
                var navH = h.offsetHeight || 64;
                var cur = null;
                tocLinks.forEach(function(link) {
                    var id = link.getAttribute('href').substring(1);
                    var el = document.getElementById(id);
                    if (el && el.getBoundingClientRect().top <= navH + 60) cur = link;
                });
                tocLinks.forEach(function(l) { l.classList.remove('text-sky-600', 'dark:text-sky-400', 'font-medium'); });
                if (cur) cur.classList.add('text-sky-600', 'dark:text-sky-400', 'font-medium');
            }, { passive: true });
        }
    }

    positionMenu();
    window.addEventListener('resize', positionMenu, { passive: true });
})();
