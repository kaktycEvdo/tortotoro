<?php
include_once "connect_to_db.php";

switch($_GET['action']){
    case "add":{
        $query = $pdo->prepare("INSERT INTO `order` (idorder, status, shift_id, items) VALUES (:idorder, :status, :shift_id, :items)", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $built_string = $_POST['dishes'][0];
        for($i=1;$i<sizeof($_POST['dishes']);$i++){
            $built_string = $built_string.", ".$_POST['dishes'][$i];
        }
        $res = $query->execute(['idorder' => $_POST['idorder'], 'status' => 1, 'shift_id' => $_POST['shift_id'], 'items' => $built_string]);
        $pdo = null;
        header("Location: ../waiter/order_management.php");
        break;
    }

    case "update":{
        $query = $pdo->prepare("UPDATE `order` SET idorder = :idorder, shift_id = :shift_id WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['idorder' => $_POST['idorder'], 'shift_id' => $_POST['shift_id'], 'given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../waiter/order_management.php");
        break;
    }

    case "delete":{
        $query = $pdo->prepare("DELETE FROM `order` WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../waiter/order_management.php");
        break;
    }

    case "cancel":{
        $query = $pdo->prepare("UPDATE `order` SET status = 5 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../waiter/order_management.php");
        break;
    }

    case "pay":{
        $query = $pdo->prepare("UPDATE `order` SET status = 4 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../waiter/order_management.php");
        break;
    }

    case "finish":{
        $query = $pdo->prepare("UPDATE `order` SET status = 3 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../cook/order_check.php");
        break;
    }
    
    case "prepare":{
        $query = $pdo->prepare("UPDATE `order` SET status = 2 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../cook/order_check.php");
        break;
    }
}
