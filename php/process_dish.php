<?php
include_once "connect_to_db.php";
session_start();

if($_SESSION['user_role'] == 'admin'){
    switch($_GET['action']){
        case "add":{
            $query = $pdo->prepare("INSERT INTO dish (iddish, ingredients, name, price) VALUES (:iddish, :ingredients, :name, :price)", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['iddish' => $_POST['iddish'], 'ingredients' => $_POST['ingredients'], 'name' => $_POST['name'], 'price' => $_POST['price']]);
            $pdo = null;
            header("Location: ../admin/dishes_management.php");
            break;
        }
    
        case "update":{
            $query = $pdo->prepare("UPDATE dish SET iddish = :iddish, ingredients = :ingredients, name = :name, price = :price WHERE iddish = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['iddish' => $_POST['iddish'], 'ingredients' => $_POST['ingredients'], 'name' => $_POST['name'], 'price' => $_POST['price'], 'given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../admin/dishes_management.php");
            break;
        }
    
        case "delete":{
            $query = $pdo->prepare("DELETE FROM dish WHERE iddish = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../admin/dishes_management.php");
            break;
        }
    }
}
else{
    $pdo = null;
    header("Location: ../", $response_code = 401);
}