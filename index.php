<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortotoro Management</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <main id="index">
        <div>
            <h1>Добро пожаловать в Tortotoro.</h1>
            <p style="white-space: pre-line;">Данный сайт является ИС для компании, которая создала кафе-кондитерскую.
                Сотрудники – пользователи сайта, поэтому на данный сайт другие лица попасть не смогут.</p>
        </div>
        <div>
            <h2>Ссылки:</h2>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <?php
                if (@$_SESSION["user_role"]){
                    echo "<header>
                        <a class='red' href='php/process_user.php?action=exit'>ВЫЙТИ</a>
                    </header>";
                    switch($_SESSION["user_role"]){
                        case "admin":{
                            echo "<a href='admin/users_management.php'>users_management</a>";
                            echo "<a href='admin/shifts_management.php'>shifts_management</a>";
                            echo "<a href='admin/dishes_management.php'>dishes_management</a>";
                            break;
                        }
                        case "waiter":{
                            echo "<a href='waiter/order_management.php'>order_management</a>";
                            break;
                        }
                        case "cook":{
                            echo "<a href='cook/order_check.php'>order_check</a>";
                            break;
                        }
                    }
                }
                else{
                    echo "<a href='auth.php'>Авторизация</a>";
                }
            ?>
            </div>
        </div>
    </main>
</body>
</html>