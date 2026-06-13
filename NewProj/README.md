# NewProj Theme

基于 [nxtrace.org](https://www.nxtrace.org/) 风格设计的 Typecho 主题。

## 特点

- **响应式布局**：完美适配桌面端、平板和移动设备
- **深色/浅色模式**：支持一键切换主题配色，自动跟随系统偏好
- **简洁现代**：卡片式设计，清晰的视觉层次
- **平滑动画**：滚动渐入、悬停效果等交互动画
- **Typecho 原生**：完整支持 Typecho 的文章、页面、分类、标签、评论系统

## 文件结构

```
NewProj/
├── css/
│   └── style.css          # 主题样式
├── js/
│   └── main.js            # 主题脚本
├── images/
│   └── (placeholder)      # 图片资源目录
├── index.php              # 首页模板
├── archive.php            # 文章列表/归档模板
├── post.php               # 文章详情模板
├── page.php               # 独立页面模板
├── header.php             # 头部公共模板
├── footer.php             # 底部公共模板
├── comments.php           # 评论模板
├── 404.php                # 404 页面模板
├── functions.php          # 主题函数
├── screenshot.png         # 主题缩略图
└── README.md              # 说明文档
```

## 安装方法

1. 下载主题压缩包
2. 解压后将 `NewProj` 文件夹上传到 Typecho 的 `/usr/themes/` 目录
3. 在 Typecho 后台 -> 控制台 -> 外观 中启用主题

## 配置选项

在 Typecho 后台的主题设置中，可以配置：

- **默认主题配色**：浅色/深色/跟随系统
- **站点 Logo**：自定义网站 Logo
- **站点 Favicon**：自定义网站图标
- **侧边栏显示**：分类、最新文章、标签云、归档等模块开关
- **统计代码**：百度统计、Google Analytics 等
- **ICP 备案号**：网站备案信息
- **自定义 CSS**：追加自定义样式

## 浏览器支持

- Chrome / Edge (最新 2 个版本)
- Firefox (最新 2 个版本)
- Safari (最新 2 个版本)

## 许可证

MIT License

## 致谢

设计风格参考自 [NextTrace 官方网站](https://www.nxtrace.org/)
