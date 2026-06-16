<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN" class="<?php $color = $this->options->themeColor; if($color == 'dark') echo 'dark'; elseif($color == 'auto') echo ''; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#0ea5e9">
    <?php if ($this->options->favicon): ?>
    <link rel="icon" href="<?php $this->options->favicon(); ?>">
    <?php endif; ?>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title><?php $this->archiveTitle(['category'=>_t('分类：%s'),'search'=>_t('搜索：%s'),'tag'=>_t('标签：%s'),'author'=>_t('作者：%s')], '', ' - '); ?><?php $this->options->title(); ?></title>
    <?php $this->header('commentReply=1'); ?>
    <script>
        // Tailwind 配置
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-up': 'slideUp 0.4s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: 0 },
                            '100%': { transform: 'translateY(0)', opacity: 1 }
                        }
                    }
                }
            }
        };

        // 明暗模式初始化
        (function() {
            const savedMode = localStorage.getItem('cbDarkMode');
            const defaultMode = '<?php echo $this->options->themeColor; ?>';
            let isDark = false;
            if (defaultMode === 'dark') {
                isDark = true;
            } else if (defaultMode === 'auto' || !defaultMode) {
                if (savedMode !== null) {
                    isDark = savedMode === 'enabled';
                } else {
                    isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                }
            }
            if (isDark) {
                document.documentElement.classList.add('dark');
            }
            // 同步图标状态（避免 FOUC 双图标闪烁）
            syncDarkIcon(isDark);
        })();

        function syncDarkIcon(isDark) {
            var moon = document.getElementById('iconMoon');
            var sun = document.getElementById('iconSun');
            if (moon && sun) {
                moon.style.display = isDark ? 'none' : '';
                sun.style.display = isDark ? '' : 'none';
            }
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('cbDarkMode', isDark ? 'enabled' : 'disabled');
            syncDarkIcon(isDark);
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .card {
                @apply bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg;
            }
            .btn {
                @apply px-4 py-2 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500;
            }
            .btn-primary {
                @apply bg-sky-600 text-white hover:bg-sky-700 disabled:opacity-50;
            }
            .btn-outline {
                @apply bg-transparent border border-sky-500 text-sky-600 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-gray-700;
            }
            .tag {
                @apply inline-block px-3 py-1 rounded-full text-sm font-medium transition-colors;
            }
            .post-meta {
                @apply text-gray-500 dark:text-gray-300 text-sm flex flex-wrap gap-2;
            }
            .prose-content {
                @apply text-gray-800 dark:text-gray-200 leading-relaxed;
            }
            .prose-content h1 {
                @apply text-2xl md:text-3xl font-bold mt-8 mb-4 pb-3 border-b border-gray-200 dark:border-gray-700;
            }
            .prose-content h2 {
                @apply text-2xl font-bold mt-8 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700;
            }
            .prose-content h3 {
                @apply text-xl font-semibold mt-6 mb-3;
            }
            .prose-content h4 {
                @apply text-lg font-semibold mt-5 mb-2;
            }
            .prose-content p {
                @apply my-4;
            }
            .prose-content ul, .prose-content ol {
                @apply my-3 pl-6;
            }
            .prose-content ul {
                @apply list-disc;
            }
            .prose-content ol {
                @apply list-decimal;
            }
            .prose-content li {
                @apply my-1;
            }
            .prose-content blockquote:not(.cb-quote) {
                @apply border-l-4 border-sky-500 bg-sky-50 dark:bg-sky-900/10 pl-4 py-2 my-4 italic text-gray-700 dark:text-gray-300;
            }
            /* 短代码多色引用块 - 颜色由内联 Tailwind 类控制 */
            .prose-content blockquote.cb-quote {
                @apply pl-4 py-3 my-4 not-italic text-gray-700 dark:text-gray-300;
            }
            .prose-content a {
                @apply text-sky-600 dark:text-sky-400 hover:underline;
            }
            .prose-content img {
                @apply rounded-xl shadow-md max-w-full h-auto my-6;
            }
            .prose-content table {
                @apply w-full border-collapse my-6;
            }
            .prose-content th, .prose-content td {
                @apply border border-gray-300 dark:border-gray-700 px-4 py-2 text-left;
            }
            .prose-content th {
                @apply bg-gray-100 dark:bg-gray-800 font-semibold;
            }
            .prose-content pre {
                @apply rounded-xl my-6 shadow-lg;
            }
            .prose-content code {
                @apply text-sm;
            }
            .prose-content :not(pre) > code {
                @apply bg-gray-100 dark:bg-gray-800 text-pink-600 dark:text-pink-400 px-1.5 py-0.5 rounded text-sm;
            }
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
        }
    </style>
</head>
<body class="font-sans text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- 页眉 -->
    <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- 网站Logo -->
                <div class="flex items-center">
                    <a href="<?php $this->options->siteUrl(); ?>" class="flex items-center space-x-2">
                        <?php if ($this->options->logoUrl): ?>
                        <img src="<?php $this->options->logoUrl(); ?>" alt="Logo" class="w-10 h-10 rounded-xl">
                        <?php else: ?>
                        <div class="bg-sky-500 text-white w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xl">
                            <?php echo mb_substr($this->options->title, 0, 1, 'UTF-8'); ?>
                        </div>
                        <?php endif; ?>
                        <span class="text-xl font-bold text-gray-900 dark:text-white"><?php $this->options->title(); ?></span>
                    </a>

                    <!-- 导航菜单（桌面端：lg 以上才横排，md 以下收进汉堡） -->
                    <nav class="hidden lg:flex items-center ml-6 lg:ml-10 flex-1 overflow-x-auto no-scrollbar">
                        <?php
                        $rawMenu = trim((string)($this->options->navMenu ?? ''));
                        $navItems = (!empty($rawMenu)) ? cbParseNavMenu($rawMenu) : cbDefaultNavMenu($this);
                        $currentUrl = rtrim($this->request->getRequestUrl(), '/');
                        // 确保菜单不为空
                        if (empty($navItems)) {
                            $navItems = [['type' => 'link', 'name' => '首页', 'url' => rtrim($this->options->siteUrl, '/'), 'icon' => 'fa-home']];
                        }
                        foreach ($navItems as $item):
                            if ($item['type'] === 'separator'):
                        ?>
                        <span class="mx-2 text-gray-300 dark:text-gray-600">|</span>
                        <?php else:
                            $safeUrl = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
                            $safeName = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                            $isActive = (rtrim($item['url'], '/') === $currentUrl || (strpos($item['name'], '首页') === 0 && $this->is('index')));
                        ?>
                        <a href="<?php echo $safeUrl; ?>" class="whitespace-nowrap px-2 py-1 text-sm text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 font-medium transition<?php echo $isActive ? ' text-sky-600 dark:text-sky-400' : ''; ?>">
                            <?php if (!empty($item['icon'])): ?><i class="fas <?php echo htmlspecialchars($item['icon']); ?> mr-1"></i><?php endif; ?><?php echo $safeName; ?>
                        </a>
                        <?php endif; endforeach; ?>
                    </nav>
                </div>

                <!-- 操作区 -->
                <div class="flex items-center space-x-4">
                    <!-- 搜索按钮 -->
                    <button id="searchBtn" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-search text-gray-600 dark:text-gray-400"></i>
                    </button>

                    <!-- 明暗模式切换 -->
                    <button onclick="toggleDarkMode()" id="darkModeBtn" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" aria-label="切换明暗模式">
                        <i id="iconMoon" class="fas fa-moon text-gray-600"></i>
                        <i id="iconSun" class="fas fa-sun text-yellow-300" style="display:none"></i>
                    </button>

                    <!-- 移动端/平板菜单按钮（lg 以下显示） -->
                    <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-bars text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
            </div>

            <!-- 搜索栏（隐藏状态） -->
            <div id="searchBar" class="py-4 hidden">
                <div class="max-w-2xl mx-auto">
                    <form method="get" action="<?php $this->options->siteUrl(); ?>" class="relative">
                        <input type="text" name="s" placeholder="搜索文章..." class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition text-gray-800 dark:text-gray-200">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-sky-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- 平板/移动端菜单（隐藏） -->
            <nav id="mobileMenu" class="lg:hidden hidden pb-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                <?php foreach ($navItems as $item):
                    if ($item['type'] === 'separator'):
                ?>
                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                <?php else:
                    $safeUrl = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
                    $safeName = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                    $isMobileActive = (rtrim($item['url'], '/') === $currentUrl || (strpos($item['name'], '首页') === 0 && $this->is('index')));
                ?>
                <a href="<?php echo $safeUrl; ?>" class="block py-2.5 text-gray-700 dark:text-gray-300 hover:text-sky-600 transition<?php echo $isMobileActive ? ' text-sky-600' : ''; ?>">
                    <?php if (!empty($item['icon'])): ?><i class="fas <?php echo htmlspecialchars($item['icon']); ?> mr-2 w-5 text-center"></i><?php endif; ?><?php echo $safeName; ?>
                </a>
                <?php endif; endforeach; ?>
            </nav>
        </div>
    </header>

    <!-- 主要内容 -->
    <main class="flex-grow">
