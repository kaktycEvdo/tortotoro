<?php
include_once "connect_to_db.php";
session_start();

switch($_GET['action']){
    case "auth":{
        $query = $pdo->prepare("SELECT login, name, role.role_name FROM user, role WHERE (login = :login and password = :password) and role_role_id = role.role_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $query->execute(['login' => $_POST['login'], 'password' => md5($_POST['password'])]);
        $res = $query->fetch(PDO::FETCH_ASSOC);

        if ($res){
            $_SESSION['user'] = $res['login'];
            $_SESSION['user_role'] = $res['role_name'];
            $pdo = null;
            header("Location: ../");
            break;
        }

        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "exit":{
        if($_SESSION['user'] && $_SESSION['user_role']){
            $_SESSION['user'] = null;
            $_SESSION['user_role'] = null;
            $pdo = null;
            header("Location: ../");
            break;
        }
        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "add":{
        if ($_SESSION['user_role'] == 'admin'){
            $query = $pdo->prepare("INSERT INTO user (name, login, password, photo_file, role_role_id) VALUES (:name, :login, :password, :photo_file, :role)", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['login' => $_POST['login'], 'password' => md5($_POST['password']), 'name' => $_POST['name'], 'photo_file' => $_POST['photo_file'], 'role' => $_POST['role']]);
            $pdo = null;
            header("Location: ../admin/users_management.php");
        }
        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "update":{
        if ($_SESSION['user_role'] == 'admin'){
            $query = $pdo->prepare("UPDATE user SET name = :name, login = :login, password = :password, photo_file = :photo_file, role_role_id = :role WHERE login = :given_login", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['login' => $_POST['login'], 'password' => md5($_POST['password']), 'name' => $_POST['name'], 'photo_file' => $_POST['photo_file'], 'role' => $_POST['role'], 'given_login' => $_GET['given_login']]);
            $pdo = null;
            header("Location: ../admin/users_management.php");
        }
        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "delete":{
        if ($_SESSION['user_role'] == 'admin'){
            $query = $pdo->prepare("DELETE FROM user WHERE login = :given_login", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $res = $query->execute(['given_login' => $_GET['given_login']]);
            $pdo = null;
            header("Location: ../admin/users_management.php");
        }
        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }
}
