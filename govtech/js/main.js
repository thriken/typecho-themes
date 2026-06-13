/**
 * GovTech Typecho Theme - JavaScript
 * 功能：移动端导航 / 返回顶部 / 顶部日期 / 评论回复
 */
(function () {
  'use strict';

  /* ── 工具函数 ── */
  function $(sel, ctx) { return (ctx || document).querySelector(sel); }
  function $$(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

  /* ── 顶部日期显示 ── */
  var dateEl = $('#js-date');
  if (dateEl) {
    var now = new Date();
    var days = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
    dateEl.textContent =
      now.getFullYear() + '年' +
      (now.getMonth() + 1) + '月' +
      now.getDate() + '日 ' +
      days[now.getDay()];
  }

  /* ── 移动端导航切换 ── */
  var navToggle = $('#js-nav-toggle');
  var nav       = $('#js-nav');
  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      navToggle.classList.toggle('is-open', open);
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.style.overflow = open ? 'hidden' : '';
    });
    // 点击导航项后自动关闭
    $$('.main-nav__link', nav).forEach(function (link) {
      link.addEventListener('click', function () {
        nav.classList.remove('is-open');
        navToggle.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
    // 点击遮罩关闭
    document.addEventListener('click', function (e) {
      if (nav.classList.contains('is-open') &&
          !nav.contains(e.target) && e.target !== navToggle) {
        nav.classList.remove('is-open');
        navToggle.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  /* ── 返回顶部 ── */
  var backToTop = $('#js-back-to-top');
  if (backToTop) {
    var toggleBackToTop = function () {
      if (window.scrollY > 400) {
        backToTop.classList.add('is-visible');
      } else {
        backToTop.classList.remove('is-visible');
      }
    };
    window.addEventListener('scroll', toggleBackToTop, { passive: true });
    toggleBackToTop();
    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ── 平滑锚点 ── */
  $$('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var hash = a.getAttribute('href');
      if (hash.length < 2) return;
      var target = document.querySelector(hash);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.pushState(null, '', hash);
      }
    });
  });

  /* ── 代码块复制按钮 ── */
  $$('.article__body pre').forEach(function (pre) {
    var btn = document.createElement('button');
    btn.className = 'code-copy-btn';
    btn.title = '复制代码';
    btn.setAttribute('aria-label', '复制代码');
    btn.innerHTML =
      '<svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor">' +
      '<path d="M8 3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2zm0 2H6v11h8V5h-2v1a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V5z"/>' +
      '</svg>';
    pre.style.position = 'relative';
    pre.appendChild(btn);
    btn.addEventListener('click', function () {
      var code = pre.querySelector('code') || pre;
      navigator.clipboard.writeText(code.innerText).then(function () {
        btn.innerHTML =
          '<svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor">' +
          '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.414 0z" clip-rule="evenodd"/>' +
          '</svg>';
        setTimeout(function () {
          btn.innerHTML =
            '<svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor">' +
            '<path d="M8 3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2zm0 2H6v11h8V5h-2v1a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V5z"/>' +
            '</svg>';
        }, 1800);
      }).catch(function () {});
    });
  });

})();
