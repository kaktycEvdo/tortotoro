<?php
include_once "connect_to_db.php";

switch($_GET['action']){
    case "add":{
        $query = $pdo->prepare("INSERT INTO shift (idshift, day, beginning, end, user_login) VALUES (:idshift, :day, :beginning, :end, :user_login)", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $built_string = $_POST['users'][0];
        for($i=1;$i<sizeof($_POST['users']);$i++){
            $built_string = $built_string.", ".$_POST['users'][$i];
        }
        $res = $query->execute(['idshift' => $_POST['id_shift'], 'day' => $_POST['day'], 'beginning' => $_POST['beginning'], 'end' => $_POST['end'], 'user_login' => $built_string]);
        $pdo = null;
        header("Location: ../admin/shifts_management.php");
        break;
    }

    case "update":{
        $query = $pdo->prepare("UPDATE shift SET idshift = :idshift, day = :day, beginning = :beginning, end = :end, status = :status, user_login = :users WHERE idshift = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $built_string = $_POST['users'][0];
        for($i=1;$i<sizeof($_POST['users']);$i++){
            $built_string = $built_string.", ".$_POST['users'][$i];
        }
        $res = $query->execute(['idshift' => $_POST['id_shift'], 'day' => $_POST['day'], 'beginning' => $_POST['beginning'], 'end' => $_POST['end'], 'status' => $_POST['status'], 'users' => $built_string, 'given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../admin/shifts_management.php");
        break;
    }

    case "delete":{
        $query = $pdo->prepare("DELETE FROM shift WHERE idshift = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../admin/shifts_management.php");
        break;
    }

    case "close":{
        $query = $pdo->prepare("UPDATE shift SET status = 0 WHERE idshift = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_id' => $_GET['given_id']]);
        $pdo = null;
        header("Location: ../admin/shifts_management.php");
        break;
    }
}
