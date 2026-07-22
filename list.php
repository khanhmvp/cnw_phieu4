<?php
require_once 'config.php';
$rows = db()->query('SELECT id, name, description, created_at FROM categories ORDER BY id')->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .btn-add {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 10px;
            font-size: 14px;
            cursor: pointer;
            background-color: #337ab7;
            color: #fff;
            border: 1px solid #2e6da4;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-edit {
            color: #0275d8;
            text-decoration: none;
            margin-right: 10px;
        }
        .btn-delete {
            color: #d9534f;
            background: none;
            border: 1px solid #d9534f;
            padding: 2px 6px;
            cursor: pointer;
            border-radius: 3px;
        }
        .actions {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <h2>Danh sách danh mục</h2>
    <a href="create.php" class="btn-add">Thêm danh mục mới</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                <td class="actions">
                    <!-- Đã sửa thẻ <a href= chuẩn -->
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Sửa</a>
                    
                    <form method="POST" action="delete.php" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');" style="margin:0;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn-delete">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>