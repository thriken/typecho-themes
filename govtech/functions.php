<?php
/**
 * GovTech 主题功能配置文件
 * 注册主题设置、自定义配置项
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 主题初始化
 */
function themeConfig(Typecho_Widget_Helper_Form $form) {

    // ---- 站点设置 ----
    $tab_site = new Typecho_Widget_Helper_Form_Element_Text(
        'icp',
        null,
        '',
        _t('ICP 备案号'),
        _t('填写后将显示在页脚，例如：京ICP备xxxxxxxx号')
    );
    $form->addInput($tab_site);

    $sideNotice = new Typecho_Widget_Helper_Form_Element_Textarea(
        'sideNotice',
        null,
        '',
        _t('侧边栏公告内容'),
        _t('将显示在侧边栏顶部，支持 HTML 标签。留空则不显示。')
    );
    $form->addInput($sideNotice);

    // ---- 友情链接 ----
    $linksText = new Typecho_Widget_Helper_Form_Element_Textarea(
        'linksRaw',
        null,
        '',
        _t('友情链接'),
        _t('每行一条，格式：<code>名称|https://url.com</code>，留空则不显示。')
    );
    $form->addInput($linksText);

    // ---- 头部横幅 ----
    $headerSlogan = new Typecho_Widget_Helper_Form_Element_Text(
        'headerSlogan',
        null,
        '',
        _t('头部标语'),
        _t('显示在 Logo 下方的一行小字（可留空）')
    );
    $form->addInput($headerSlogan);
}

/**
 * 个人设置（用户面板）
 */
function themeFields($layout) {
    //$downloadUrl = new Typecho_Widget_Helper_Form_Element_Text('DownloadUrl', NULL, NULL, _t('下载链接'), _t('在这里填入一个下载链接地址'));
    //$layout->addItem($downloadUrl);
}

/**
 * 初始化钩子：解析友情链接文本为结构化数据
 */
function govtech_init() {
    // 此处预留扩展
}

/**
 * 工具函数：获取友情链接数组
 */
function govtech_getLinks() {
    $options = Helper::options();
    $raw = isset($options->linksRaw) ? trim($options->linksRaw) : '';
    if (empty($raw)) return array();
    $links = array();
    foreach (explode("\n", $raw) as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        $parts = explode('|', $line, 2);
        if (count($parts) === 2) {
            $links[] = array('name' => trim($parts[0]), 'url' => trim($parts[1]));
        }
    }
    return $links;
}
