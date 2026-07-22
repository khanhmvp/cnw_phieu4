<?php
require_once 'config.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name)) {
        $errors = 'Vui long nhap ten danh muc!';
    } else {
        $stmt = db()->prepare('INSERT INTO categories (name, description) VALUES (:name, :description, NOW())');
        try {
            $stmt->execute([$name, $description]);
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            $errors = 'Ten danh muc da ton tai hoac co loi xay ra ';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Them danh muc moi</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        .form-box{
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .field{
            margin-bottom: 15px;
        }
        .field label{
            display: block;
            margin-bottom: 5px;
        }
        .field input{
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .error{
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Thêm danh mục</h2>
    <?php if ($errors): ?>
        <p class="error"><?= htmlspecialchars($errors, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <div class="form-box">
    <form method="POST" action="create.php">
        <div class="field">
            <label for="name">Tên danh mục:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="field">
            <label for="description">Mô tả:</label>
            <input type="text" id="description" name="description">
        </div>
        <button type="submit">Them moi</button>
        <a href="list.php">Quay lai</a>
    </form>
</body>
</html>