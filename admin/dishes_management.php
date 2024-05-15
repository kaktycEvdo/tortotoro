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
            <a data-dependant>ИЗМЕНИТЬ</a>
            <a class="red" data-dependant>УДАЛИТЬ</a>
        </header>
        <?php
            function get(){
                include_once "../php/connect_to_db.php";
                $query = $pdo->prepare("SELECT iddish, ingredients, name, price FROM dish");
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($res){
                    echo "<div class='table dishes'>
                        <div>
                            <p>№</p>
                            <p>ИНГРЕДИЕНТЫ</p>
                            <p>НАЗВАНИЕ</p>
                            <p>ЦЕНА</p>
                        </div>";
                    for ($i = 0; $i < sizeof($res); $i++){
                        echo "<div>
                                <p>
                                    ".$res[$i]['iddish']."
                                </p>
                                <p>
                                    ".$res[$i]['ingredients']."
                                </p>
                                <p>
                                    ".$res[$i]['name']."
                                </p>
                                <p>
                                    ".$res[$i]['price']."₽
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
                            include_once "../php/connect_to_db.php";
                            $query = $pdo->prepare("SELECT iddish FROM dish");
                            $query->execute();
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            $new_id = sizeof($res) > 0 ? $res[sizeof($res)-1]['iddish']+1 : 1; // получает последний id и добавляет 1 к нему или просто ставит 1 если нет блюд
                            echo "<form method='POST' class='table-form' action='../php/process_dish.php?action=add'>
                                <div>
                                    <label for='iddish'>ID</label>
                                    <input type='text' id='iddish' name='iddish' value='$new_id' />
                                    <label for='ingredients'>ИНГРЕДИЕНТЫ</label>
                                    <input type='text' id='ingredients' name='ingredients' />
                                    <label for='name'>НАЗВАНИЕ</label>
                                    <input type='text' id='name' name='name' />
                                    <label for='price'>ЦЕНА</label>
                                    <input type='text' id='price' name='price' />
                                </div>
                                <div>
                                    <input type='submit' value='Добавить блюдо' />
                                </div>
                            </form>";
                            break;
                        }
                        case "edit":{
                            include_once "../php/connect_to_db.php";
                            $query = $pdo->prepare("SELECT iddish, ingredients, name, price FROM dish WHERE iddish = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                            $query->execute(['given_id' => $_GET['given_id']]);
                            $res = $query->fetch(PDO::FETCH_ASSOC);

                            if ($res){
                                echo "<form method='POST' class='table-form' action='../php/process_dish.php?action=update&given_id='".$_GET['given_id'].">
                                <div>
                                    <label for='iddish'>ID</label>
                                    <input type='text' id='iddish' name='iddish' value='".$res['iddish']."' />
                                    <label for='ingredients'>ИНГРЕДИЕНТЫ</label>
                                    <input type='text' id='ingredients' name='ingredients' value='".$res['ingredients']."' />
                                    <label for='name'>НАЗВАНИЕ</label>
                                    <input type='text' id='name' name='name' value='".$res['name']."' />
                                    <label for='price'>ЦЕНА</label>
                                    <input type='text' id='price' name='price' value='".$res['price']."' />
                                </div>
                                <div>
                                    <input type='submit' value='Изменить блюдо' />
                                </div>
                            </form>";
                            }
                            else{
                                echo "БЛЮДО НЕ НАЙДЕНО";
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