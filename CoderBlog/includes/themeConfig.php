<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * CoderBlog 后台设置 — 参考 SanoBlog 分组卡片模式
 */
function themeConfig($form)
{
    // ═════════════════ 顶部横向导航 + 分组卡片样式 ═════════════════
    echo '<style>
.cb-config-nav{display:flex;gap:6px;margin-bottom:18px;flex-wrap:wrap;}
.cb-config-nav a{display:flex;align-items:center;gap:6px;padding:7px 16px;border-radius:6px;font-size:13px;font-weight:600;color:#475569;text-decoration:none;background:#fff;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.08);transition:all .15s;white-space:nowrap;cursor:pointer;}
.cb-config-nav a:hover,.cb-config-nav a.active{background:#0ea5e9;color:#fff;border-color:#0ea5e9;}

.cb-config-group{border:1px solid #e2e8f0;border-radius:10px;margin-bottom:20px;overflow:hidden;background:#fff;width:720px;max-width:100%;scroll-margin-top:60px;transition:all .2s;}
.cb-config-head{background:linear-gradient(135deg,#f8fafc 0%,#f1f5f9 100%);padding:11px 20px;border-bottom:1px solid #e2e8f0;font-weight:600;font-size:14px;color:#334155;display:flex;align-items:center;gap:8px;cursor:pointer;user-select:none;}
.cb-config-head:hover{background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%);}
.cb-config-head .cb-arrow{font-size:11px;transition:transform .2s;color:#94a3b8;margin-left:auto;}
.cb-config-body{padding:14px 20px 6px 20px;}
.cb-config-body.collapsed{display:none;}

.cb-config-submit-wrap{width:720px;max-width:100%;margin-bottom:20px;padding:0;}
.cb-config-submit-wrap .typecho-option{border:none!important;padding:10px 0!important;margin:0!important;}

.cb-nav-help{background:#f0f9ff;border:1px solid #bae6fd;border-radius:6px;padding:12px 16px;margin:0 0 12px 0;font-size:12.5px;color:#0c4a6e;line-height:1.7;}
.cb-nav-help th,.cb-nav-help td{padding:3px 8px;text-align:left;font-size:12px;}
.cb-nav-help th{color:#64748b;white-space:nowrap;width:48px;}
.cb-nav-help code{background:#e0f2fe;padding:1px 6px;border-radius:3px;font-family:monospace;font-size:12px;color:#0369a1;}
.cb-nav-help .cb-help-note{color:#64748b;font-size:11.5px;margin:8px 0 0 0;}
</style>';

    // 顶部横向导航标签
    echo '<nav class="cb-config-nav" title="快速跳转">';
    echo '<a href="javascript:void(0)" data-group="g-basic" onclick="cbShowSection(\'g-basic\');return false;">&#x2B1B; 基础</a>';
    echo '<a href="javascript:void(0)" data-group="g-home" onclick="cbShowSection(\'g-home\');return false;">&#x1F3E0; 首页</a>';
    echo '<a href="javascript:void(0)" data-group="g-sidebar" onclick="cbShowSection(\'g-sidebar\');return false;">&#x1F4D0; 侧边栏</a>';
    echo '<a href="javascript:void(0)" data-group="g-code" onclick="cbShowSection(\'g-code\');return false;">&#x1F4BB; 代码</a>';
    echo '<a href="javascript:void(0)" data-group="g-social" onclick="cbShowSection(\'g-social\');return false;">&#x1F517; 社交</a>';
    echo '<a href="javascript:void(0)" data-group="g-other" onclick="cbShowSection(\'g-other\');return false;">&#x2699; 其他</a>';
    echo '<a href="javascript:void(0)" data-group="g-nav" onclick="cbShowSection(\'g-nav\');return false;">&#x1F310; 菜单</a>';
    echo '</nav>';

    // 分组辅助函数
    $group = function($id, $icon, $title, $desc = '') {
        echo '<div class="cb-config-group" id="' . $id . '" style="display:none">';
        echo '<div class="cb-config-head" >' . $icon . ' <span>' . $title . '</span></div>';
        echo '<div class="cb-config-body">';
        if ($desc) echo '<p style="color:#94a3b8;font-size:12px;margin:0 0 10px 0;">' . $desc . '</p>';
    };
    $groupEnd = function() { echo '</div></div>'; };

    // ==================== 1. 站点基础 ====================
    $group('g-basic', '&#x2B1B;', '站点基础', null);

    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl', null, null,
        _t('站点 LOGO'), _t('输入 Logo 图片 URL，留空则显示文字 Logo')
    );
    $form->addInput($logoUrl);

    $favicon = new \Typecho\Widget\Helper\Form\Element\Text(
        'favicon', null, null,
        _t('Favicon'), _t('浏览器标签页小图标 URL')
    );
    $form->addInput($favicon);

    $themeColor = new \Typecho\Widget\Helper\Form\Element\Radio(
        'themeColor',
        ['auto' => _t('跟随系统'), 'light' => _t('浅色模式'), 'dark' => _t('深色模式')],
        'auto', _t('主题配色'), _t('选择默认配色方案')
    );
    $form->addInput($themeColor);

    $groupEnd();

    // ==================== 2. 首页设置 ====================
    $group('g-home', '&#x1F3E0;', '首页设置', null);

    $heroTitle = new \Typecho\Widget\Helper\Form\Element\Text(
        'heroTitle', null, '发现精彩内容',
        _t('Hero 标题'), _t('首页大标题文字')
    );
    $form->addInput($heroTitle);

    $heroDesc = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'heroDesc', null, '',
        _t('Hero 描述'), _t('首页副标题文字，留空使用站点描述')
    );
    $form->addInput($heroDesc);

    $indexShowCategories = new \Typecho\Widget\Helper\Form\Element\Radio(
        'indexShowCategories',
        ['show' => _t('显示'), 'hide' => _t('隐藏')],
        'show', _t('首页分类目录'), _t('是否在首页底部显示分类目录')
    );
    $form->addInput($indexShowCategories);

    $indexShowTags = new \Typecho\Widget\Helper\Form\Element\Radio(
        'indexShowTags',
        ['show' => _t('显示'), 'hide' => _t('隐藏')],
        'show', _t('首页标签云'), _t('是否在首页底部显示标签云')
    );
    $form->addInput($indexShowTags);

    $indexPostNum = new \Typecho\Widget\Helper\Form\Element\Select(
        'indexPostNum',
        ['6' => _t('6 篇（2 行）'), '9' => _t('9 篇（3 行）'), '12' => _t('12 篇（4 行）')],
        '6', _t('首页文章数量'), _t('首页每页显示的文章数，按 3 列网格排列')
    );
    $form->addInput($indexPostNum);

    $groupEnd();

    // ==================== 3. 侧边栏设置 ====================
    $group('g-sidebar', '&#x1F4D0;', '侧边栏设置', null);

    $sidebarBlocks = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'sidebarBlocks',
        ['ShowSearch' => _t('搜索'), 'ShowCategory' => _t('分类目录'), 'ShowRecentPost' => _t('最新文章'),
         'ShowTag' => _t('标签云'), 'ShowArchive' => _t('文章归档')],
        ['ShowSearch','ShowCategory','ShowRecentPost','ShowTag','ShowArchive'],
        _t('侧边栏模块'), _t('勾选要在侧边栏显示的模块')
    );
    $form->addInput($sidebarBlocks);

    $breadcrumb = new \Typecho\Widget\Helper\Form\Element\Radio(
        'breadcrumb',
        ['show' => _t('显示'), 'hide' => _t('隐藏')],
        'show', _t('面包屑导航'), _t('文章页是否显示面包屑导航')
    );
    $form->addInput($breadcrumb);

    $groupEnd();

    // ==================== 4. 代码演示设置 ====================
    $group('g-code', '&#x1F4BB;', '代码演示设置', null);

    $codeTheme = new \Typecho\Widget\Helper\Form\Element\Select(
        'codeTheme',
        ['prism-tomorrow' => _t('Tomorrow Night（暗色）'), 'prism' => _t('Default（亮色）'),
         'prism-okaidia' => _t('Okaidia（暗色）'), 'prism-coy' => _t('Coy（亮色）')],
        'prism-tomorrow', _t('代码高亮主题'), _t('选择 Prism.js 代码高亮配色')
    );
    $form->addInput($codeTheme);

    $codeDemos = new \Typecho\Widget\Helper\Form\Element\Radio(
        'codeDemos',
        ['enable' => _t('启用'), 'disable' => _t('禁用')],
        'enable', _t('代码在线演示'), _t('是否启用 CodePen / JSFiddle 风格演示面板')
    );
    $form->addInput($codeDemos);

    $groupEnd();

    // ==================== 5. 社交链接 ====================
    $group('g-social', '&#x1F517;', '社交链接', null);

    $githubUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'githubUrl', null, null,
        _t('GitHub'), _t('GitHub 主页链接')
    );
    $form->addInput($githubUrl);

    $twitterUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'twitterUrl', null, null,
        _t('Twitter / X'), _t('Twitter 链接')
    );
    $form->addInput($twitterUrl);

    $zhihuUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'zhihuUrl', null, null,
        _t('知乎'), _t('知乎主页链接')
    );
    $form->addInput($zhihuUrl);

    $groupEnd();

    // ==================== 6. 其他设置 ====================
    $group('g-other', '&#x2699;', '其他设置', null);

    $icp = new \Typecho\Widget\Helper\Form\Element\Text(
        'icp', null, null,
        _t('ICP 备案号'), _t('页面底部备案号')
    );
    $form->addInput($icp);

    $statistics = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'statistics', null, null,
        _t('统计代码'), _t('百度统计 / Google Analytics 等统计脚本，将插入 &lt;/body&gt; 前')
    );
    $form->addInput($statistics);

    $customCss = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'customCss', null, null,
        _t('自定义 CSS'), _t('自定义样式，无需写 &lt;style&gt; 标签')
    );
    $form->addInput($customCss);

    $groupEnd();

    // ==================== 7. 导航菜单 ====================
    $group('g-nav', '&#x1F310;', '导航菜单', '自定义桌面端导航菜单，支持分类/页面/外链/分隔线');

    // 帮助说明
    echo '<div class="cb-nav-help">
        <p style="margin:0 0 6px;"><strong>格式：</strong>每行一个菜单项 <code>名称 | 链接 | 图标(可选)</code></p>
        <table>
            <tr><th>首页</th><td><code>首页|{siteUrl}|fa-home</code></td></tr>
            <tr><th>分类</th><td><code>分类名|/category/slug</code></td></tr>
            <tr><th>页面</th><td><code>关于|/about.html</code></td></tr>
            <tr><th>外链</th><td><code>GitHub|https://github.com|fa-github</code></td></tr>
            <tr><th>分隔</th><td><code>---</code></td></tr>
        </table>
        <p class="cb-help-note">图标支持 Font Awesome 类名（如 fa-home），留空则不显示。留空此框则自动显示首页 + 全部分类 + 独立页面。</p>
    </div>';

    $navMenu = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'navMenu', null, null,
        _t('菜单配置'), _t('每行填写一项，留空使用默认自动菜单')
    );
    $navMenu->setAttribute('style', 'width:100%;min-height:160px;font-family:monospace;font-size:13px;');
    $form->addInput($navMenu);

    $groupEnd();

    // 保存按钮独立容器（始终显示，不受分组切换影响）
    echo '<div class="cb-config-submit-wrap" id="g-submit"></div>';

    // ═════════════════ JS：表单项归位 + 分组切换 + 折叠 ═════════════════
    echo '<script>
(function(){
    function cbRearrange(){
        var groups=document.querySelectorAll(".cb-config-group");
        if(!groups.length){setTimeout(cbRearrange,50);return;}
        var bodies=[];
        groups.forEach(function(g){var b=g.querySelector(".cb-config-body");if(b)bodies.push(b);});
        if(!bodies.length)return;

        var container=document.querySelector("form")||document.querySelector(".typecho-body")||document.querySelector(".main-content")||document.body;

        var orphans=[];
        var submitEl=null;
        var children=container.childNodes;
        for(var i=0;i<children.length;i++){
            var el=children[i];
            if(el.nodeType!==1)continue;
            if(el.classList&&(el.classList.contains("cb-config-nav")||el.classList.contains("cb-config-group")||el.classList.contains("cb-config-submit-wrap")))continue;
            var tag=el.tagName.toLowerCase();
            if(["script","style","link","meta","noscript"].indexOf(tag)!==-1)continue;
            if(el.querySelector("button[type=\"submit\"]")||(el.classList&&el.classList.contains("typecho-option")&&el.querySelector(".btn.primary"))){
                submitEl=el;
                continue;
            }
            orphans.push(el);
        }

        if(submitEl){
            var sw=document.getElementById("g-submit");
            if(sw)sw.appendChild(submitEl);
        }

        // 分组顺序：基础3→首页5→侧边栏2→代码2→社交3→其他3→菜单1
        var counts=[3,5,2,2,3,3,1];
        var idx=0;
        for(var g=0;g<bodies.length;g++){
            var limit=counts[g]||999;
            for(var c=0;c<limit&&idx<orphans.length;c++,idx++){
                bodies[g].appendChild(orphans[idx]);
            }
        }
        while(idx<orphans.length){
            bodies[bodies.length-1].appendChild(orphans[idx]);idx++;
        }

        var form=document.querySelector("form");
        if(form){
            var grps=document.querySelectorAll(".cb-config-group");
            for(var i=grps.length-1;i>=0;i--){
                form.insertBefore(grps[i], form.firstChild);
            }
            var sw=document.getElementById("g-submit");
            if(sw)form.appendChild(sw);
        }
    }

    window.cbShowSection=function(id){
        var all=document.querySelectorAll(".cb-config-group");
        all.forEach(function(g){
            g.style.display=(g.id===id)?"":"none";
        });
        document.querySelectorAll(".cb-config-nav a").forEach(function(a){
            a.classList.toggle("active", a.getAttribute("data-group") === id);
        });
    };


    if(document.readyState==="loading"){
        document.addEventListener("DOMContentLoaded",function(){
            cbRearrange();
            cbShowSection("g-basic");
        });
    }else{
        cbRearrange();
        cbShowSection("g-basic");
    }
})();
</script>';
}
