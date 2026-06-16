# CoderBlog · 程序员博客主题

> 平台：Typecho 1.3 | PHP 7.4 ~ 8.4 | UI：Tailwind CSS + Font Awesome

面向开发者与极客的双栏博客主题，支持代码高亮、短代码、暗色模式。

---

## 功能特性

| 特性 | 说明 |
|---|---|
| 代码高亮 | Prism.js（line-numbers / toolbar / copy / match-braces / autoload） |
| 短代码 | `[video]` `[audio]` `[file]` `[quote]` `[ref]` |
| 暗色模式 | 跟随系统 / 手动切换，`localStorage` 记忆 |
| 图片预览 | 依赖 [LightboX](https://atlinker.cn) 插件，后台可开关 |
| 响应式 | 桌面双栏 / 移动端单栏，汉堡菜单 |
| 搜索 | 顶部栏内嵌搜索 |
| 后台设置 | 6 个设置分区，独立文件分离 |

---

## 短代码参考

```markdown
[file url="xxx.pdf" name="下载文档"]
[video url="xxx.mp4"]
[video bvid="BVxxx"]           # B站
[video youtube_id="xxx"]       # YouTube
[audio url="xxx.mp3"]
[quote color="blue|green|yellow|red|purple|gray"]...[/quote]
[ref id="123"]                 # 引用站内文章
```

---

## 目录结构

```
CoderBlog/
├── 404.php              # 404 错误页
├── archive.php          # 按年月归档（条目形式，无摘要）
├── category.php         # 分类 / 标签 / 搜索页
├── comments.php         # 评论模板（支持代码高亮 + 嵌套回复）
├── footer.php           # 页脚（社交链接 / 快速链接 / 分类 / ICP）
├── functions.php        # 主题函数（短代码 / 摘要 / 缩略图 / 资源加载）
├── header.php           # 头部（Tailwind CDN + Font Awesome + 导航 + 搜索）
├── index.html           # 静态原型（开发参考）
├── index.php            # 首页（Hero + 文章网格 + 分类目录 + 标签云）
├── page.php             # 独立页面
├── post.php             # 文章页（面包屑 / 题图 / 代码高亮 / 评论区）
├── readme.md            # 本文件
├── screenshot.png       # 主题预览截图
├── sidebar.php          # 侧边栏（搜索 / 分类 / 最新文章 / 标签云 / 归档）
├── assets/
│   ├── css/prism.css    # Prism.js 高亮主题（Tomorrow Night）
│   ├── js/main.js       # 主题交互脚本
│   └── img/             # 图片资源
└── includes/
    └── themeConfig.php  # 后台主题设置页（独立文件）
```

---

## 依赖与注意事项

- **Tailwind CSS** 通过 CDN 加载（`cdn.tailwindcss.com`），仅限开发/测试使用。**生产环境请替换为编译版**，参考 [Tailwind 安装指南](https://tailwindcss.com/docs/installation)。
- **图片灯箱** 依赖 Typecho 插件 [LightboX](https://atlinker.cn)，请在后台安装并启用。主题不内置 lightbox 文件。
- **代码高亮** 使用 Prism.js CDN，主题内含 `prism.css` 为高亮配色。
- 主题内置的 `primary` 色系可通过后台"主题颜色"设置调整；其余颜色使用 Tailwind 标准 `gray` 色系。
- 自定义颜色一律使用 Tailwind 内置色值，避免 CDN 编译时报 `CssSyntaxError`。

---

## 开发计划

- [x] 双栏布局 + 响应式
- [x] Prism.js 代码高亮
- [x] 短代码（video / audio / file / quote / ref）
- [x] 暗色模式切换
- [x] functions.php 与 themeConfig.php 分离
- [x] LightboX 插件集成
- [ ] Tailwind 生产编译
- [ ] `[demo]` 代码在线演示平台
