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
            <a data-dependant>ОТМЕТИТЬ ГОТОВЯЩИМСЯ</a>
            <a data-dependant>ОТМЕТИТЬ ГОТОВЫМ</a>
        </header>
        <?php
            function get(){
                include_once "../php/connect_to_db.php";
                $query = $pdo->prepare("SELECT idorder, status, shift_id, dish.name FROM `order`, dish WHERE items LIKE dish.iddish");
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($res){
                    echo "<div class='table orders-cook'>
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

            if($_SESSION['user_role'] == "cook"){
                if (@$_GET['operation']){
                    switch($_GET['operation']){
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