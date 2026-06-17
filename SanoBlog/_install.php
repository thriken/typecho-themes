<?php
/**
 * SanoBlog 安装/卸载脚本（兼容 MySQL / SQLite）
 *
 * 访问方式：浏览器打开 https://你的域名/usr/themes/SanoBlog/_install.php
 *          或从「控制台→外观→设置外观」左侧导航点击「🔧 维护」
 */

// 不直接 define __TYPECHO_ROOT_DIR__（config.inc.php 会定义，避免重复）
$__root = dirname(__FILE__, 4);

require_once $__root . '/config.inc.php';
require_once $__root . '/var/Typecho/Db.php';
require_once $__root . '/var/Typecho/Widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'check';
$db = \Typecho\Db::get();
$prefix = $db->getPrefix();
$isSqlite = (stripos($db->getAdapterName(), 'sqlite') !== false);
$messages = [];

/**
 * 跨数据库检测 views 列是否存在
 * 用 Typecho 查询构造器尝试 SELECT views LIMIT 1，失败则列不存在
 */
function columnExists($db)
{
    try {
        $db->fetchAll($db->select('views')->from('table.contents')->limit(1));
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

$columnExists = columnExists($db);

// 检查 theme:SanoBlog 选项行是否存在
$optionExists = false;
try {
    $optionRow = $db->fetchRow(
        $db->select()->from('table.options')
            ->where('name = ?', 'theme:SanoBlog')
    );
    $optionExists = !empty($optionRow);
} catch (\Exception $e) {
    $messages[] = ['error', '选项查询失败：' . $e->getMessage()];
}

// ── 安装 ──
if ($action === 'install') {
    if (!$columnExists) {
        try {
            $db->query("ALTER TABLE {$prefix}contents ADD COLUMN views INTEGER DEFAULT 0");
            $columnExists = true;
            $messages[] = ['ok', '✅ views 列已成功添加到 contents 表'];
        } catch (\Exception $e) {
            $messages[] = ['error', '❌ views 列添加失败：' . $e->getMessage()];
        }
    } else {
        $messages[] = ['info', '⏭️ views 列已存在，无需重复安装'];
    }
}

// ── 卸载 ──
if ($action === 'uninstall') {
    // 1. 删除 views 列
    if ($columnExists) {
        try {
            $db->query("ALTER TABLE {$prefix}contents DROP COLUMN views");
            $columnExists = false;
            $messages[] = ['ok', '✅ views 列已从 contents 表移除'];
            $messages[] = ['warn', '⚠️ 浏览统计数据已永久删除'];
        } catch (\Exception $e) {
            $messages[] = ['error', '❌ views 列删除失败：' . $e->getMessage()];
            if ($isSqlite) {
                $messages[] = ['warn', '⚠️ DROP COLUMN 需要 SQLite 3.35.0+，如版本过低请手动在数据库工具中删除该列'];
            }
        }
    } else {
        $messages[] = ['info', '⏭️ views 列不存在，跳过'];
    }

    // 2. 删除主题选项行（虽然切换主题时 Typecho 会自动删，但防孤儿残留）
    if ($optionExists) {
        try {
            $db->query(
                $db->delete('table.options')
                    ->where('name = ?', 'theme:SanoBlog')
            );
            $optionExists = false;
            $messages[] = ['ok', '✅ theme:SanoBlog 选项行已从 options 表移除'];
        } catch (\Exception $e) {
            $messages[] = ['error', '❌ 选项删除失败：' . $e->getMessage()];
        }
    } else {
        $messages[] = ['info', '⏭️ theme:SanoBlog 选项行不存在，跳过'];
    }
}

// ── 输出页面 ──
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>SanoBlog 安装管理</title>
<style>
*{box-sizing:border-box}
body{font-family:system-ui,-apple-system,sans-serif;max-width:580px;margin:40px auto;padding:20px;background:#f8fafc;color:#334155}
.card{background:#fff;border-radius:10px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,.08);margin-bottom:16px}
h2{color:#1e293b;margin:0 0 16px 0;font-size:18px}
.status{display:inline-block;padding:3px 10px;border-radius:12px;font-size:13px;font-weight:600}
.status-ok{background:#dcfce7;color:#166534}
.status-missing{background:#fef3c7;color:#92400e}
.msg{padding:6px 0;line-height:1.7;font-size:14px}
.msg-ok{color:#166534}
.msg-error{color:#dc2626}
.msg-info{color:#64748b}
.msg-warn{color:#d97706}
.actions{display:flex;gap:10px;margin-top:16px;flex-wrap:wrap}
.btn{display:inline-block;padding:9px 20px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:all .15s}
.btn-primary{background:#1f6feb;color:#fff}
.btn-primary:hover{background:#1a5fc4}
.btn-danger{background:#dc2626;color:#fff}
.btn-danger:hover{background:#b91c1c}
.btn-ghost{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0}
.btn-ghost:hover{background:#e2e8f0}
.db-badge{font-size:11px;padding:1px 8px;border-radius:10px;background:#e2e8f0;color:#64748b;margin-left:6px}
.divider{border:none;border-top:1px solid #e2e8f0;margin:16px 0}
.note{font-size:12px;color:#94a3b8;margin-top:16px;line-height:1.6}
</style>
</head>
<body>

<div class="card">
    <h2>🔧 SanoBlog 安装管理<span class="db-badge"><?php echo $isSqlite ? 'SQLite' : 'MySQL'; ?></span></h2>

    <p style="margin:0 0 12px 0;">
        views 列：
        <span class="status <?php echo $columnExists ? 'status-ok' : 'status-missing'; ?>">
            <?php echo $columnExists ? '已安装' : '未安装'; ?>
        </span>
        &nbsp;
        theme选项：
        <span class="status <?php echo $optionExists ? 'status-ok' : 'status-missing'; ?>">
            <?php echo $optionExists ? '已存在' : '不存在'; ?>
        </span>
    </p>

    <?php foreach ($messages as $msg): ?>
    <div class="msg msg-<?php echo $msg[0]; ?>"><?php echo $msg[1]; ?></div>
    <?php endforeach; ?>

    <div class="actions">
        <?php if ($columnExists || $optionExists): ?>
            <a href="?_install.php&action=uninstall" class="btn btn-danger" onclick="return confirm('确定要卸载吗？\n\n将执行以下操作：\n1. 删除 contents 表的 views 列（浏览数据将永久丢失）\n2. 删除 options 表的 theme:SanoBlog 行（外观设置将清除）\n\n此操作不可恢复！')">🗑 全部卸载</a>
        <?php else: ?>
            <a href="?_install.php&action=install" class="btn btn-primary">⚡ 安装 views 列</a>
        <?php endif; ?>
        <a href="?_install.php&action=check" class="btn btn-ghost">🔄 刷新状态</a>
    </div>

    <hr class="divider">

    <div class="note">
        <strong>数据库影响总览：</strong><br>
        <table style="width:100%;border-collapse:collapse;margin-top:8px;">
            <tr style="border-bottom:1px solid #e2e8f0">
                <td style="padding:6px 8px"><code>contents</code> 表 <code>views</code> 列</td>
                <td style="padding:6px 8px;text-align:right">本脚本管理（安装/卸载）</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0">
                <td style="padding:6px 8px"><code>options</code> 表 <code>theme:SanoBlog</code> 行</td>
                <td style="padding:6px 8px;text-align:right">切换主题时 Typecho 自动删除<br>本脚本卸载时也一并清理</td>
            </tr>
        </table>
        <br>
        <strong>场景说明：</strong><br>
        • <strong>切换主题</strong>：Typecho 自动清理 theme:SanoBlog 行；views 列保留但不影响<br>
        • <strong>卸载主题</strong>：请先点击上方「全部卸载」按钮，再删除主题文件夹<br>
        • <strong>重新安装</strong>：安装脚本幂等，已存在则自动跳过<br>
        • views 列缺失时，<code>get_post_view()</code> 会优雅降级返回 0，不会报错
    </div>
</div>

</body>
</html>
