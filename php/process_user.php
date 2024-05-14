<?php
include_once "connect_to_db.php";

// TODO: actual actions
switch($_GET['action']){
    case "auth":{
        session_start();
        $query = $pdo->prepare("SELECT login, name, role.role_name FROM user, role WHERE (login = :login and password = :password) and role_role_id = role.role_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $query->execute(['login' => $_POST['login'], 'password' => md5($_POST['password'])]);
        $res = $query->fetch(PDO::FETCH_ASSOC);

        if ($res){
            $_SESSION['user'] = $res['login'];
            $_SESSION['user_role'] = $res['role_name'];
            $pdo = null;
            echo $res['role_name'];
            header("Location: ../");
            break;
        }

        $pdo = null;
        header("Location: ../", $response_code = 401);
        break;
    }

    case "add":{
        $query = $pdo->prepare("INSERT INTO user (name, login, password, photo_file, role_role_id) VALUES (:name, :login, :password, :photo_file, :role)", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['login' => $_POST['login'], 'password' => md5($_POST['password']), 'name' => $_POST['name'], 'photo_file' => $_POST['photo_file'], 'role' => $_POST['role']]);
        $pdo = null;
        header("Location: ../admin/users_management.php");
        break;
    }

    case "update":{
        $query = $pdo->prepare("UPDATE user SET name = :name, login = :login, password = :password, photo_file = :photo_file, role_role_id = :role WHERE login = :given_login", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['login' => $_POST['login'], 'password' => md5($_POST['password']), 'name' => $_POST['name'], 'photo_file' => $_POST['photo_file'], 'role' => $_POST['role'], 'given_login' => $_GET['given_login']]);
        $pdo = null;
        header("Location: ../admin/users_management.php");
        break;
    }

    case "delete":{
        $query = $pdo->prepare("DELETE FROM user WHERE login = :given_login", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $res = $query->execute(['given_login' => $_GET['given_login']]);
        $pdo = null;
        header("Location: ../admin/users_management.php");
        break;
    }
}
