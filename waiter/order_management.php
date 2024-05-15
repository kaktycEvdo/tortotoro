<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortotoro Orders</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header><a href="../">НАЗАД</a></header>
    <main class="table-output">
        <header>
            <a href='?operation=get'>ПОСМОТРЕТЬ</a>
            <a href='?operation=add'>ДОБАВИТЬ</a>
            <a data-dependant>ИЗМЕНИТЬ</a>
            <a data-dependant>ОТМЕТИТЬ ОПЛАЧЕННЫМ</a>
            <a class="red" data-dependant>ОТМЕНИТЬ</a>
        </header>
        <?php
            function get(){
                include_once "../php/connect_to_db.php";
                $query = $pdo->prepare("SELECT idorder, status, shift_id, dish.name FROM `order`, dish WHERE items LIKE dish.iddish");
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($res){
                    echo "<div class='table orders'>
                        <div>
                            <p>№</p>
                            <p>СТАТУС</p>
                            <p>№ СМЕНЫ</p>
                            <p>БЛЮДА</p>
                        </div>";
                    for ($i = 0; $i < sizeof($res); $i++){
                        echo "<div>
                                <p>
                                    ".$res[$i]['idorder']."
                                </p>
                                <p>
                                    ";
                                switch($res[$i]['status']){
                                    case '1':{
                                        echo 'ПРИНЯТ';
                                        break;
                                    }
                                    case '2':{
                                        echo 'ГОТОВИТСЯ';
                                        break;
                                    }
                                    case '3':{
                                        echo 'ГОТОВ';
                                        break;
                                    }
                                    case '4':{
                                        echo 'ОПЛАЧЕН';
                                        break;
                                    }
                                    case '5':{
                                        echo 'ОТМЕНЕН';
                                        break;
                                    }
                                }
                        echo "
                                </p>
                                <p>
                                    ".$res[$i]['shift_id']."
                                </p>
                                <p>
                                    ".$res[$i]['name']."
                                </p>
                            </div>";
                    }
                    $pdo = null;
                }
            }

            if($_SESSION['user_role'] == "waiter"){
                if (@$_GET['operation']){
                    switch($_GET['operation']){
                        case "add":{
                            include_once "../php/connect_to_db.php";
                            $query = $pdo->prepare("SELECT idorder FROM `order`");
                            $query->execute();
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            $new_id = sizeof($res) > 0 ? $res[sizeof($res)-1]['idorder']+1 : 1; // получает последний id и добавляет 1 к нему или просто ставит 1 если нет заказов
                            $query = $pdo->prepare("SELECT iddish, name FROM dish");
                            $query->execute();
                            $dishes = $query->fetchAll(PDO::FETCH_ASSOC);
                            $query = $pdo->prepare("SELECT idshift FROM shift WHERE status = 1");
                            $query->execute();
                            $shifts = $query->fetchAll(PDO::FETCH_ASSOC);
                            $last_shift = $shifts ? $shifts[sizeof($shifts)-1]['idshift'] : 0;
                            echo "<form method='POST' class='table-form' action='../php/process_order.php?action=add'>
                                <div>
                                    <label for='idorder'>ID заказа</label>
                                    <input type='text' id='idorder' name='idorder' value='$new_id' />
                                    <label for='shift_id'>shift_id</label>
                                    <input type='text' id='shift_id' name='shift_id' value='$last_shift' />
                                    ";
                            for($i = 0; $i < sizeof($dishes); $i++){
                                echo "<label for='dish$i'>".$dishes[$i]['iddish']." - ".$dishes[$i]['name']."</label>";
                                echo "<input type='checkbox' name='dishes[]' id='dish$i' value='".$dishes[$i]['iddish']."' />";
                            }
                            echo "</div>
                                <div>
                                    <input type='submit' value='Добавить заказ' />
                                </div>
                            </form>";
                            break;
                        }
                        case "edit":{
                            include_once "../php/connect_to_db.php";
                            $query = $pdo->prepare("SELECT iddish, name FROM dish");
                            $query->execute();
                            $dishes = $query->fetchAll(PDO::FETCH_ASSOC);
                            $query = $pdo->prepare("SELECT idorder, shift_id, items FROM `order` WHERE idorder = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                            $query->execute(['given_id' => $_GET['given_id']]);
                            $order = $query->fetch(PDO::FETCH_ASSOC);

                            if ($order && $dishes){
                                echo "<form method='POST' class='table-form' action='../php/process_order.php?given_id=".$_GET['given_id']."&action=update'>
                                    <div>
                                    <label for='idorder'>ID заказа</label>
                                    <input type='text' id='idorder' name='idorder' value='".$order['idorder']."' />
                                    <label for='shift_id'>shift_id</label>
                                    <input type='text' id='shift_id' name='shift_id' value='".$order['shift_id']."' />
                                    </div>
                                    <div>
                                        <input type='submit' value='Изменить смену' />
                                    </div>
                                </form>";
                            }
                            else{
                                echo "СМЕНА НЕ НАЙДЕНА";
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