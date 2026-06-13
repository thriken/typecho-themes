<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<aside class="side-nav">
    <?php
    /**
     * 获取分类目录的层级结构
     */

    $hierarchicalCategories = getHierarchicalCategories();

    foreach ($hierarchicalCategories as $item):
        $topCat = $item['category'];
        $children = $item['children'];
    ?>
        <div class="title"><?php echo htmlspecialchars($topCat['name']); ?></div>
        <ul>
            <?php if (empty($children)): ?>
                <li <?php if ($this->is('category', $topCat['slug'])): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo $topCat['permalink']; ?>" title="<?php echo htmlspecialchars($topCat['name']); ?>">
                        <?php echo htmlspecialchars($topCat['name']); ?>
                    </a>
                </li>
            <?php else: ?>
                <?php foreach ($children as $child): ?>
                    <li <?php if ($this->is('category', $child['slug'])): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo $child['permalink']; ?>" title="<?php echo htmlspecialchars($child['name']); ?>">
                            <?php echo htmlspecialchars($child['name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    <?php endforeach; ?>

</aside>