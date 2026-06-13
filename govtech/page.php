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
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $replacement = '<a href="$1" data-fancybox="gallery" /><img src="$1" alt="'.$this->title.'" title="点击放大图片"></a>';
    $content = preg_replace($pattern, $replacement, $this->content);
    echo $content;
?>
                            <?php //$this->content(); ?>
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
