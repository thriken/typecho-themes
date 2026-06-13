<?php

/**
 * GovNews Theme
 * 新闻主题
 *
 * @package GovNews
 * @author Thriken
 * @version 1.0.0
 * @link https://blog.elec.top
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('sidebar.php'); ?>


<!-- 右侧主内容 -->
<main class="main-content">
    <!-- 头条新闻 -->
    <div class="content-module">
        <div class="module-title">
            <h3>最新要闻</h3>
            <a href="#">更多>></a>
        </div>
        <ul class="news-list">
            <?php \Widget\Contents\Post\Recent::alloc('pageSize=5')->to($featured); ?>
            <?php 
            $i = 0;
            while ($featured->next()): $i++; ?>
                <?php if ($i === 1): ?>
                    <a href="<?php $featured->permalink(); ?>">
                        <?php if ($featured->fields->thumb): ?>
                            <img src="<?php echo $featured->fields->thumb; ?>" alt="<?php $featured->title(); ?>" loading="lazy">
                        <?php endif; ?>
                        <h2><span>[头条]</span>
                            <?php $featured->title(); ?>
                    </a>
                    <span class="news-time" datetime="<?php $featured->date('c'); ?>"><?php $featured->date('Y-m-d'); ?></span></h2>

                <?php else: ?>
                    <?php if ($i === 2): ?>
                        <ul class="news-list">
                        <?php endif; ?>
                        <li>
                            <a href="<?php $featured->permalink(); ?>"><?php $featured->title(); ?></a>
                            <span class="news-time"><?php $featured->date('m-d'); ?></span>
                        </li>
                        <?php if ($i === 5): ?>
                        </ul><?php endif; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- 通知公告+政务公开+本地资讯 三列 -->
    <div class="info-grid">
        <div class="content-module">
            <div class="module-title">
                <h3>通知公告</h3>
                <a href="#">更多>></a>
            </div>
            <ul class="news-list">
                <li>
                    <a href="#">不动产首次登记公告（XX集团有限公司）</a>
                    <span class="news-time">2026-03-25</span>
                </li>
                <li>
                    <a href="#">2026年度考试录用公务员公告</a>
                    <span class="news-time">2026-03-22</span>
                </li>
                <li>
                    <a href="#">关于注销网络预约出租汽车经营许可证的公告</a>
                    <span class="news-time">2026-03-23</span>
                </li>
            </ul>
        </div>
        <div class="content-module">
            <div class="module-title">
                <h3>政务公开</h3>
                <a href="#">更多>></a>
            </div>
            <ul class="news-list">
                <li>
                    <a href="#">2025年度政府网站工作年度报表</a>
                    <span class="news-time">2026-01-13</span>
                </li>
                <li>
                    <a href="#">财政预决算公开</a>
                    <span class="news-time">2026-03-10</span>
                </li>
                <li>
                    <a href="#">政策文件解读</a>
                    <span class="news-time">2026-01-14</span>
                </li>
            </ul>
        </div>
        <div class="content-module">
            <div class="module-title">
                <h3>本地资讯</h3>
                <a href="#">更多>></a>
            </div>
            <ul class="news-list">
                <li>
                    <a href="#">我县第一小学开展文明主题升旗仪式</a>
                    <span class="news-time">2026-03-23</span>
                </li>
                <li>
                    <a href="#">兴福镇开展人大代表进站履职活动</a>
                    <span class="news-time">2026-03-20</span>
                </li>
                <li>
                    <a href="#">陈户镇开展学雷锋精神主题宣讲活动</a>
                    <span class="news-time">2026-03-17</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- 政策文件模块 -->
    <div class="content-module">
        <div class="module-title">
            <h3>最新政策文件</h3>
            <a href="#">更多>></a>
        </div>
        <div class="info-grid">
            <div class="info-card">
                <h4>关于加快建立长期护理保险制度的意见</h4>
                <p>中共中央办公厅 国务院办公厅印发，明确长期护理保险制度建设的总体要求、主要内容和保障措施...</p>
            </div>
            <div class="info-card">
                <h4>国有企业领导人员廉洁从业规定</h4>
                <p>进一步规范国有企业领导人员廉洁从业行为，加强国有企业党风廉政建设和反腐败工作...</p>
            </div>
            <div class="info-card">
                <h4>加快培育服务消费新增长点工作方案</h4>
                <p>国务院办公厅印发，提出多项举措培育服务消费新增长点，推动消费提质升级...</p>
            </div>
        </div>
    </div>
</main>

<?php $this->need('footer.php'); ?>