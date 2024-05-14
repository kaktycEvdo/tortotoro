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
    <header><a href="../">НАЗАД</a></header>
    <main class="table-output">
        <header>
            <a href='?operation=get'>ПОСМОТРЕТЬ</a>
            <a href='?operation=add'>ДОБАВИТЬ</a>
            <a data-dependant href='?operation=edit'>ИЗМЕНИТЬ</a>
            <a data-dependant href='../php/process_user.php?action=delete'>УВОЛИТЬ</a>
        </header>
        <?php
            function get(){
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

            if($_SESSION['user_role'] == "admin"){
                if (@$_GET['operation']){
                    switch($_GET['operation']){
                        case "add":{
                            echo "<form method='POST' class='table-form' action='../php/process_user.php?action=add'>
                                <div>
                                    <label for='name'>Имя</label>
                                    <input type='text' id='name' name='name' />
                                    <label for='login'>Логин</label>
                                    <input type='text' id='login' name='login' />
                                    <label for='password'>Пароль</label>
                                    <input type='password' id='password' name='password' />
                                    <label for='photo_file'>Фото</label>
                                    <input type='file' id='photo_file' name='photo_file' />
                                    <label for='admin'>Администратор</label>
                                    <input type='radio' id='admin' name='role' value='1'/>
                                    <label for='waiter'>Официант</label>
                                    <input type='radio' id='waiter' checked name='role' value='2'/>
                                    <label for='cook'>Повар</label>
                                    <input type='radio' id='cook' name='role' value='3'/>
                                </div>
                                <div>
                                    <input type='submit' value='Добавить пользователя' />
                                </div>
                            </form>";
                            break;
                        }
                        case "edit":{
                            include_once "../php/connect_to_db.php";
                            $query = $pdo->prepare("SELECT login, name, password, photo_file, role_role_id FROM user WHERE login = :given_login", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                            $query->execute(['given_login' => $_GET['given_login']]);
                            $res = $query->fetch(PDO::FETCH_ASSOC);

                            if ($res){
                                echo "<form method='POST' class='table-form' action='../php/process_user.php?given_login=".$_GET['given_login']."&action=update'>
                                    <div>
                                        <label for='name'>Имя</label>
                                        <input type='text' id='name' name='name' value='".$res['name']."' />
                                        <label for='login'>Логин</label>
                                        <input type='text' id='login' name='login' value='".$res['login']."' />
                                        <label for='password'>Пароль</label>
                                        <input type='password' id='password' name='password' value='".$res['password']."' />
                                        <label for='photo_file'>Фото</label>
                                        <input type='file' id='photo_file' name='photo_file' value='".$res['photo_file']."' />
                                        <label for='admin'>Администратор</label>
                                        <input type='radio' ".($res['role_role_id'] == 1 ? 'checked' : '')." id='admin' name='role' value='1'/>
                                        <label for='waiter'>Официант</label>
                                        <input type='radio' ".($res['role_role_id'] == 2 ? 'checked' : '')."  id='waiter' name='role' value='2'/>
                                        <label for='cook'>Повар</label>
                                        <input type='radio' ".($res['role_role_id'] == 3 ? 'checked' : '')."  id='cook' name='role' value='3'/>
                                    </div>
                                    <div>
                                        <input type='submit' value='Изменить пользователя' />
                                    </div>
                                </form>";
                            }
                            else{
                                echo "ПОЛЬЗОВАТЕЛЬ НЕ НАЙДЕН";
                            }
                            break;
                        }
                        default:{
                            get();
                            break;
                        }
                    }
                    
                }
                else{
                    get();
                }
                
            }
            else{
                header("Location: ../");
            }
        ?>
    </main>
    <script src='../static/data_dependant_stuff.js'></script>
</body>
</html>