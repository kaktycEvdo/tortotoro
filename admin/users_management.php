<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortotoro Users</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <main>
        <?php
            if($_SESSION['user_role'] == "admin"){
                echo "<header><a href='?operation=get'>GET</a><a href='?operation=add'>ADD</a><a href='?operation=edit'>EDIT</a><a href='?operation=fire'>FIRE</a></header>";
                if (@$_GET['operation']){
                    switch($_GET['operation']){
                        default:{
                            include_once "../php/connect_to_db.php";
                        }
                    }
                    
                }
                else{
                    include_once "../php/connect_to_db.php";
                    $query = $pdo->prepare("SELECT login, name, password, photo_file, role.role_name FROM user, role WHERE role_role_id = role.role_id");
                    $query->execute();
                    $res = $query->fetch(PDO::FETCH_ASSOC);

                    if ($res){
                        echo "<table>
                            <tr>
                                <td>№</td>
                                <td>ЛОГИН</td>
                                <td>ИМЯ</td>
                                <td>ПАРОЛЬ</td>
                                <td>НАЗВАНИЕ ФОТО</td>
                                <td>СТАТУС</td>
                            </tr>";
                        echo $res['login'];
                        for ($i = 0; $i < sizeof($res['login']); $i++){
                            echo "<tr>
                                    <td>
                                        $i
                                    </td>
                                    <td>
                                        ".$res['login'][$i]."
                                    </td>
                                    <td>
                                        ".$res['name'][$i]."
                                    </td>
                                    <td>
                                        ".$res['password'][$i]."
                                    </td>
                                    <td>
                                        ".$res['photo_file'][$i]."
                                    </td>
                                    <td>
                                        ".$res['role_name'][$i]."
                                    </td>
                                </tr>";
                        }
                        $pdo = null;
                    }
                }
                
            }
            else{
                header("Location: ../");
            }
        ?>
    </main>
</body>
</html>