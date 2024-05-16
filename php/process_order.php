<?php
include_once "connect_to_db.php";
session_start();

switch($_GET['action']){
    case "add":{
        if ($_SESSION['user_role'] == 'waiter'){
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
        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "update":{
        if($_SESSION['user_role'] == 'waiter'){
            $query = $pdo->prepare("UPDATE `order` SET idorder = :idorder, shift_id = :shift_id WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['idorder' => $_POST['idorder'], 'shift_id' => $_POST['shift_id'], 'given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../waiter/order_management.php");
            break;
        }
        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "cancel":{
        if($_SESSION['user_role'] == 'waiter'){
            $query = $pdo->prepare("UPDATE `order` SET status = 5 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../waiter/order_management.php");
            break;
        }
        $pdo = null;
        header('Location: ../', $response_code = 401);
        break;
    }

    case "pay":{
        if($_SESSION['user_role'] == 'waiter'){
            $query = $pdo->prepare("UPDATE `order` SET status = 4 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../waiter/order_management.php");
            break;
        }
        $pdo = null;
        header('Location: ../', $response_code = 401);
        break;
    }

    case "finish":{
        if($_SESSION['user_role'] == 'cook'){
            $query = $pdo->prepare("UPDATE `order` SET status = 3 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../cook/order_check.php");
            break;
        }
        $pdo = null;
        header('Location: ../', $response_code = 401);
        break;
    }
    
    case "prepare":{
        if($_SESSION['user_role'] == 'cook'){
            $query = $pdo->prepare("UPDATE `order` SET status = 2 WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['given_id' => $_GET['given_id']]);
            $pdo = null;
            header("Location: ../cook/order_check.php");
            break;
        }
        $pdo = null;
        header('Location: ../', $response_code = 401);
        break;
    }
}
