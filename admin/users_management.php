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
    <main class="table-output">
        <?php
            if($_SESSION['user_role'] == "admin"){
                echo "<header><a href='?operation=get'>ПОСМОТРЕТЬ</a><a href='?operation=add'>ДОБАВИТЬ</a><a href='?operation=edit'>ИЗМЕНИТЬ</a><a href='?operation=fire'>УВОЛИТЬ</a></header>";
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
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    if ($res){
                        echo "<div class='table users'>
                            <div>
                                <p>№</p>
                                <p>ЛОГИН</p>
                                <p>ИМЯ</p>
                                <p>ПАРОЛЬ</p>
                                <p>НАЗВАНИЕ ФОТО</p>
                                <p>СТАТУС</p>
                            </div>";
                        for ($i = 0; $i < sizeof($res); $i++){
                            echo "<div>
                                    <p>
                                        $i
                                    </p>
                                    <p>
                                        ".$res[$i]['login']."
                                    </p>
                                    <p>
                                        ".$res[$i]['name']."
                                    </p>
                                    <p>
                                        ".$res[$i]['password']."
                                    </p>
                                    <p>
                                        ".($res[$i]['photo_file'] ? $res[$i]['photo_file'] : "НЕТУ")."
                                    </p>
                                    <p>
                                        ".$res[$i]['role_name']."
                                    </p>
                                </div>";
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