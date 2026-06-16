<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    </main>

    <!-- 页脚 -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <?php if ($this->options->logoUrl): ?>
                        <img src="<?php $this->options->logoUrl(); ?>" alt="Logo" class="w-10 h-10 rounded-xl mr-2">
                        <?php else: ?>
                        <div class="bg-sky-500 text-white w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xl mr-2">
                            <?php echo mb_substr($this->options->title, 0, 1, 'UTF-8'); ?>
                        </div>
                        <?php endif; ?>
                        <span class="text-xl font-bold text-gray-900 dark:text-white"><?php $this->options->title(); ?></span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 max-w-xl">
                        <?php $this->options->description(); ?>
                    </p>
                    <div class="flex space-x-4">
                        <?php if ($this->options->githubUrl): ?>
                        <a href="<?php $this->options->githubUrl(); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-sky-100 dark:hover:bg-sky-900/30 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            <i class="fab fa-github"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->options->twitterUrl): ?>
                        <a href="<?php $this->options->twitterUrl(); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-sky-100 dark:hover:bg-sky-900/30 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->options->zhihuUrl): ?>
                        <a href="<?php $this->options->zhihuUrl(); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-sky-100 dark:hover:bg-sky-900/30 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            <i class="fab fa-zhihu"></i>
                        </a>
                        <?php endif; ?>
                        <a href="<?php $this->options->feedUrl(); ?>" class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-sky-100 dark:hover:bg-sky-900/30 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            <i class="fas fa-rss"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">快速链接</h3>
                    <ul class="space-y-2">
                        <li><a href="<?php $this->options->siteUrl(); ?>" class="text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition">首页</a></li>
                        <?php $this->widget('Widget_Contents_Page_List')->to($footerPages); ?>
                        <?php while($footerPages->next()): ?>
                        <li><a href="<?php $footerPages->permalink(); ?>" class="text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition"><?php $footerPages->title(); ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">热门分类</h3>
                    <ul class="space-y-2">
                        <?php $this->widget('Widget_Metas_Category_List')->to($footerCats); ?>
                        <?php $i = 0; while($footerCats->next()): if(++$i > 6) break; ?>
                        <li><a href="<?php $footerCats->permalink(); ?>" class="text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition"><?php $footerCats->name(); ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 mt-12 pt-8 text-center text-gray-600 dark:text-gray-300 text-sm">
                <p>© <?php echo date('Y'); ?> <?php $this->options->title(); ?>. Powered by <a href="https://typecho.org" class="hover:text-sky-600 transition">Typecho</a> & <a href="#" class="hover:text-sky-600 transition">CoderBlog</a>.</p>
                <?php if ($this->options->icp): ?>
                <p class="mt-1"><a href="https://beian.miit.gov.cn/" rel="nofollow" target="_blank"><?php $this->options->icp(); ?></a></p>
                <?php endif; ?>
            </div>
        </div>
    </footer>

    <?php $this->footer(); ?>
    <script src="<?php $this->options->themeUrl('assets/js/float-menu.js'); ?>"></script>
    <?php if ($this->options->statistics): ?>
    <?php $this->options->statistics(); ?>
    <?php endif; ?>
    <?php if ($this->options->customCss): ?>
    <style><?php $this->options->customCss(); ?></style>
    <?php endif; ?>
</body>
</html>
