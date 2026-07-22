<?php
require_once 'config.php';
$rows = db() ->query('SELECT id, name, description, create_at FROM categories order by id')->fetchALL();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sach danh muc</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
        th,td{
            border: 1px solid #ddd;
            padding: 8px;
        }
        th{
            background-color: #f2f2f2;
            text-align: left;
        }
        .btn{
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            background-color: #337ab7;
            color: #fff;
            border: 1px solid #2e6da4;
            border-radius: 4px;
        }
        .action{
            display: flex;
            align-items: center;}
        </style>
</head>
<body>
    <h2>Danh sách danh mục</h2>
    <a href="create.php" class="btn-add">Them danh muc moi</a>
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
                <td><?= htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['create_at'], ENT_QUOTES, 'UTF-8') ?></td>
                <td class="actions">
                    < href="edit.php?id=<?= $row['id'] ?>" class="btn-edit"Sua</a>
                    <form method ="POST" action="delete.php" onsubmit="return confirm('Ban co chac muon xoa danh muc nay?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn-delete">Xoa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</body>
</html>