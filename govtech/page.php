<?php $this->need('header.php'); ?>
<div class="layout-wrapper">
    <div class="main-content-area">
        <div class="container">
            <div class="layout-grid">
                <main class="main-column" role="main" id="main-content">
                    <?php while ($this->next()): ?>
                    <article class="article article--page">
                        <header class="article__header">
                            <h1 class="article__title"><?php $this->title(); ?></h1>
                        </header>
                        <div class="article__body">
                            <?php
                            // 用 ob 捕获 content() 渲染后的 HTML，确保 Markdown/插件已处理
                            ob_start();
                            $this->content();
                            $renderedContent = ob_get_clean();
                            // 支持双引号和单引号的 src，跳过已有 data-fancybox 的图片
                            $pattern = '/<img(?!.*data-fancybox)[^>]*\ssrc\s*=\s*["\']([^"\']+)["\'][^>]*>/i';
                            $replacement = '<a href="$1" data-fancybox="gallery"><img src="$1" alt="' . htmlspecialchars($this->title) . '" title="点击放大图片"></a>';
                            echo preg_replace($pattern, $replacement, $renderedContent);
                            ?>
                        </div>
                    </article>

                    <?php 
                $this->need('comment.php');
                endwhile; ?>
                </main>
                <?php $this->need('sidebar.php'); ?>
            </div>
        </div>
    </div>
<?php $this->need('footer.php'); ?>
