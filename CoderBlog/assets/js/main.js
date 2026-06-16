/**
 * CoderBlog - 主题 JavaScript
 * 功能：搜索栏、移动端菜单、深色模式、Lightbox、滚动动画
 */

(function() {
    'use strict';

    // 搜索栏切换
    var searchBtn = document.getElementById('searchBtn');
    var searchBar = document.getElementById('searchBar');
    if (searchBtn && searchBar) {
        searchBtn.addEventListener('click', function() {
            var isHidden = searchBar.classList.toggle('hidden');
            if (!isHidden) {
                var input = searchBar.querySelector('input');
                if (input) setTimeout(function() { input.focus(); }, 100);
            }
        });
    }

    // 移动端菜单
    var mobileBtn = document.getElementById('mobileMenuBtn');
    var mobileMenu = document.getElementById('mobileMenu');
    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        // 点击菜单外部关闭
        document.addEventListener('click', function(e) {
            if (!mobileMenu.classList.contains('hidden') &&
                !mobileMenu.contains(e.target) &&
                !mobileBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }

    // Header 滚动阴影
    var header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
        });
    }

    // 平滑滚动
    document.addEventListener('click', function(e) {
        var link = e.target.closest('a[href^="#"]');
        if (link) {
            var targetId = link.getAttribute('href').substring(1);
            var target = document.getElementById(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });

    // 滚动渐入动画
    if ('IntersectionObserver' in window) {
        var observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px',
            threshold: 0.1
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function() {
            var elements = document.querySelectorAll('.animate-slide-up');
            elements.forEach(function(el) {
                observer.observe(el);
            });
        });
    }

    // 代码演示面板（模拟 CodePen/JSFiddle）
    var demoContainers = document.querySelectorAll('.cb-code-demo');
    demoContainers.forEach(function(container) {
        var codeBlock = container.querySelector('.cb-code-demo-code code');
        var runBtn = container.querySelector('.cb-code-demo-run');
        var outputFrame = container.querySelector('.cb-code-demo-output iframe');

        if (runBtn && codeBlock && outputFrame) {
            runBtn.addEventListener('click', function() {
                var code = codeBlock.textContent || '';
                var doc = outputFrame.contentDocument;
                doc.open();
                doc.write(code);
                doc.close();
            });
        }
    });

    // 图片 Lightbox 灯箱（兼容 LightboX 插件 + 原生支持）
    (function() {
        // 等待 LightboX 插件初始化（如果已安装），否则使用内置方案
        var initLightbox = function() {
            var contentImages = document.querySelectorAll('.prose-content img');
            if (!contentImages.length) return;

            // 检测是否已有 LightboX 插件处理过
            var hasPlugin = false;
            contentImages.forEach(function(img) {
                if (img.closest('a[href]') || img.hasAttribute('data-lightbox')) {
                    hasPlugin = true;
                }
            });

            // 如果插件未处理，则启用内置灯箱方案
            if (!hasPlugin) {
                contentImages.forEach(function(img) {
                    var src = img.getAttribute('src');
                    if (!src || img.closest('a')) return;

                    // 添加 cursor 标识可点击
                    img.style.cursor = 'zoom-in';
                    img.setAttribute('data-src-original', src);

                    img.addEventListener('click', function(e) {
                        e.preventDefault();
                        showLightbox(src, img.getAttribute('alt') || '');
                    });
                });
            }
        };

        // 内置简易灯箱
        var overlay = null;
        function showLightbox(src, alt) {
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'cb-lightbox-overlay';
                overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.85);z-index:9999;display:flex;align-items:center;justify-content:center;cursor:pointer;opacity:0;transition:opacity .25s ease';
                overlay.innerHTML = '<img style="max-width:90vw;max-height:90vh;object-fit:contain;border-radius:8px;transform:scale(.95);transition:transform .25s ease" /><span style="position:absolute;top:16px;right:20px;color:#fff;font-size:32px;line-height:1;cursor:pointer;user-select:none">&times;</span>';
                document.body.appendChild(overlay);

                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay || e.target.tagName === 'SPAN') closeLightbox();
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') closeLightbox();
                });
            }

            var imgEl = overlay.querySelector('img');
            imgEl.src = src;
            imgEl.alt = alt;
            overlay.style.display = 'flex';
            requestAnimationFrame(function() { overlay.style.opacity = '1'; imgEl.style.transform = 'scale(1)'; });
        }

        function closeLightbox() {
            if (!overlay) return;
            var imgEl = overlay.querySelector('img');
            overlay.style.opacity = '0';
            imgEl.style.transform = 'scale(.95)';
            setTimeout(function() { overlay.style.display = 'none'; }, 250);
        }

        // DOMContentLoaded 或稍后延迟初始化（兼容异步加载的插件）
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { setTimeout(initLightbox, 300); });
        } else {
            setTimeout(initLightbox, 300);
        }
        // 二次兜底：确保在页面完全加载后也执行一次
        window.addEventListener('load', function() { setTimeout(initLightbox, 500); });
    })();

    console.log('%c CoderBlog %c 主题已就绪 ',
        'background:#0ea5e9;color:white;padding:2px 6px;border-radius:3px 0 0 3px;',
        'background:#0284c7;color:white;padding:2px 6px;border-radius:0 3px 3px 0;');
})();
