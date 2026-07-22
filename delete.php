<?php
require_once 'config.php';
if($_SERVER['REQUEST_METHOD']==='POST')
    {
        $id = $_POST['id']??null;
        if($id && filter_var($id, FILTER_VALIDATE_INT)){
            $stmt = db()->prepare('delete from categories where id =?');
            $stmt->execute([$id]);
        }
    }
    header('Location: list.php');
    exit;