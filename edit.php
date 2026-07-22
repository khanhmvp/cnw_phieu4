<?php
require_once 'config.php';
$id = $_GET['id'] ?? null;
if(!$id|| !filter_var($id, FILTER_VALIDATE_INT)){
    http_response_code(404);
    die('<h1>404 - ID danh muc khong hop le!</h1><a href="list.php">Quay lai danh sach</a>');
    //tim danh muc theo id
    $stmt = db()->prepare('select * from categories where id =?');
    $stmt->excute([$id]);
    $category = $stmt->fetch();
    if (!category) {
        http_response_code(404);
        die('<h1>404 - Không tìm thấy danh mục!</h1><a href="list.php">Quay lại danh sách</a>');
    }
    $errors =[];
    $name = $category['name'];
    $description = $category['description'];
    if ($_SEVER['REQUEST_METHOD']==='POST')
        {
            $name = trim($POST['name']??'');
            $description = trim($_POST['description']??'');
            $len = mb_strlen($name, 'UTF-8');
            if($len <2|| $len>100){
                $errors[] = 'Ten danh muc phai co do dai tu 2 den 100 ky tu';
            }
            if(empty($errors)){
                try{
                    $updateStmt =db()->prepare('UPDATE categories SET name =?, description =? WHERE id =?');
                    $updateStmt->excute([$name,$description, $id]);
                    header('Location: list.php');
                    exit;
                }catch(PDOException $e){
                    if ($e->getCode() ==23000){
                        $errors[] ='Ten danh muc"'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'" da trung voi danh muc khac!';
                    }
                    else{
                            $errors[]= 'Loi he thong khi cap nhat du lieu!';
                    }
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
    <title>Cap nhat danh muc</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-box { max-width: 400px; padding: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .field { margin-bottom: 12px; }
        .field label { display: block; margin-bottom: 4px; font-weight: bold; }
        .field input { width: 100%; padding: 8px; box-sizing: border-box; }
        .error { color: #d9534f; background: #f2dede; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .btn { padding: 8px 15px; background: #f0ad4e; color: #fff; border: none; cursor: pointer; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Chinh sua danh muc</h2>
    <?php if(!empty($errors)): ?>
        <div class="error">
            <<ul style="margin: 0; padding-left: 20px;">
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