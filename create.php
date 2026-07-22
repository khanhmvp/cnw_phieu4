<?php
require_once 'config.php';
$errors = [];
$name = '';
$description = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    //validate ten danh muc do dai 2-100 ky tu
    $len = mb_strlen($name, 'UTF-8');
    if($len <2 || $len >100){
        $errors[] = 'Ten danh muc phai co do dai tu 2 den 100 ki tu';
    }
    if (empty($errors)) {
        try{
            $stmt = db() ->prepare('insert into categories (name, description) value');
            $stmt ->execute([$name, $description]);
            header('Location: list.php');
            exit;
        }catch(PDOException $e){
            //bat loi trung unique danh muc
            if($e->getCode() == 23000){
                $errors[] = 'Ten danh muc "'.htmlspecialchars($name,ENT_QUOTES,'UTF-8').' da ton tai!';
            }
            else{
                $errors[] ='Co loi he thong xay ra, vui long thu lai!';
            }
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
        .btn{
            padding: 8px 15px;
            background:#0275d8;
        }
    </style>
</head>
<body>
    <h2>Them danh muc moi</h2>
    <?php if (!empty($errors)): ?>
        <div class ="errors">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $err):?>
                    <li><?=  $err ?></li>
                    <?php endforeach;?>
                </ul>
        </div>
        <?php endif;?>
        <div class="form-box">
            <form method ="POST" action="create.php">
                <div class="field">
                    <label for="name">Ten danh muc</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?>" required>
                </div>
                <div class="field">
                    <label for="description">Mo ta</label>
                    <input type="text" id="description" name="description" value="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <button type="submit" class="btn">Luu lai</button>
                <a href="list.php" style="margin-left: 10px;">Huy</a>
            </form>

        </div>
</body>
</html>