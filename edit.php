<?php
require_once 'config.php';

$errors = [];
$id = $_GET['id'] ?? 0;

// 1. Kiểm tra ID hợp lệ
if (!$id) {
    header('Location: list.php');
    exit;
}

// 2. Lấy thông tin danh mục hiện tại
$stmt = db()->prepare('SELECT * FROM categories WHERE id = ?');
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    header('Location: list.php');
    exit;
}

// Khởi tạo biến dữ liệu ban đầu
$name = $category['name'];
$description = $category['description'];

// 3. Xử lý khi Submit Form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validate tên danh mục 2 - 100 ký tự
    $len = mb_strlen($name, 'UTF-8');
    if ($len < 2 || $len > 100) {
        $errors[] = 'Tên danh mục phải từ 2 đến 100 ký tự!';
    }

    if (empty($errors)) {
        try {
            $updateStmt = db()->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
            $updateStmt->execute([$name, $description, $id]);

            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000' || (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062)) {
                $errors[] = 'Tên danh mục "' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" đã tồn tại!';
            } else {
                $errors[] = 'Có lỗi hệ thống xảy ra, vui lòng thử lại!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa danh mục</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-box { max-width: 400px; padding: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .field { margin-bottom: 12px; }
        .field label { display: block; margin-bottom: 4px; }
        .field input { width: 100%; padding: 6px; box-sizing: border-box; }
        .error { color: red; margin-bottom: 10px; }
        .btn { padding: 6px 12px; background-color: #f0ad4e; color: white; border: none; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>

    <h2>Chỉnh sửa danh mục #<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-box">
        <form method="POST" action="edit.php?id=<?= $id ?>">
            <div class="field">
                <label for="name">Tên danh mục (*):</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="field">
                <label for="description">Mô tả:</label>
                <input type="text" id="description" name="description" value="<?= htmlspecialchars($description ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <button type="submit" class="btn">Lưu lại</button>
            <a href="list.php" style="margin-left: 10px;">Hủy</a>
        </form>
    </div>

</body>
</html>