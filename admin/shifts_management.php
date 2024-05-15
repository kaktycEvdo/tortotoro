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
            <a class="red" data-dependant>ЗАКРЫТЬ</a>
            <a class="red" data-dependant>УДАЛИТЬ</a>
        </header>
        <?php
            function get(){
                include_once "../php/connect_to_db.php";
                $query = $pdo->prepare("SELECT idshift, day, beginning, end, status, user_login FROM shift");
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($res){
                    echo "<div class='table shifts'>
                        <div>
                            <p>№</p>
                            <p>ДЕНЬ</p>
                            <p>НАЧАЛО СМЕНЫ</p>
                            <p>КОНЕЦ СМЕНЫ</p>
                            <p>СТАТУС</p>
                            <p>ПОЛЬЗОВАТЕЛИ</p>
                        </div>";
                    for ($i = 0; $i < sizeof($res); $i++){
                        echo "<div>
                                <p>
                                    ".$res[$i]['idshift']."
                                </p>
                                <p>
                                    ".$res[$i]['day']."
                                </p>
                                <p>
                                    ".$res[$i]['beginning']."
                                </p>
                                <p>
                                    ".$res[$i]['end']."
                                </p>
                                <p>
                                    ".($res[$i]['status'] ? "ОТКРЫТА" : "ЗАКРЫТА")."
                                </p>
                                <p>
                                    ".$res[$i]['user_login']."
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
                            $query = $pdo->prepare("SELECT idshift FROM shift");
                            $query->execute();
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            $new_id = sizeof($res) > 0 ? $res[sizeof($res)-1]['idshift']+1 : 1; // получает последний id и добавляет 1 к нему или просто ставит 1 если нет смен
                            $query = $pdo->prepare("SELECT login, name, role.role_name FROM user, role WHERE role_role_id > 1 and role_role_id = role.role_id"); // выбирает пользователей неадминов
                            $query->execute();
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            echo "<form method='POST' class='table-form' action='../php/process_shift.php?action=add'>
                                <div>
                                    <label for='idshift'>ID смены</label>
                                    <input type='text' id='idshift' name='id_shift' value='$new_id' />
                                    <label for='day'>day</label>
                                    <input type='date' id='day' name='day' />
                                    <label for='beginning'>beginning</label>
                                    <input type='time' id='beginning' name='beginning' value='07:00' />
                                    <label for='end'>end</label>
                                    <input type='time' id='end' name='end' value='21:00' />
                                    ";
                            for($i = 0; $i < sizeof($res); $i++){
                                echo "<label for='user$i'>".$res[$i]['login']." - ".$res[$i]['name']." - ".$res[$i]['role_name']."</label>";
                                echo "<input type='checkbox' name='users[]' id='user$i' value='".$res[$i]['login']."' />";
                            }
                            echo "</div>
                                <div>
                                    <input type='submit' value='Добавить смену' />
                                </div>
                            </form>";
                            break;
                        }
                        case "edit":{
                            include_once "../php/connect_to_db.php";
                            $query = $pdo->prepare("SELECT login, name, role.role_name FROM user, role WHERE role_role_id > 1 and role_role_id = role.role_id"); // выбирает пользователей неадминов
                            $query->execute();
                            $users = $query->fetchAll(PDO::FETCH_ASSOC);
                            $query = $pdo->prepare("SELECT idshift, day, beginning, end, status, user_login FROM shift WHERE idshift = :given_id", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                            $query->execute(['given_id' => $_GET['given_id']]);
                            $shift = $query->fetch(PDO::FETCH_ASSOC);

                            if ($shift && $users){
                                echo "<form method='POST' class='table-form' action='../php/process_shift.php?given_id=".$_GET['given_id']."&action=update'>
                                    <div>
                                    <label for='idshift'>ID смены</label>
                                    <input type='text' id='idshift' name='id_shift' value='".$shift['idshift']."' />
                                    <label for='day'>day</label>
                                    <input type='date' id='day' name='day' value='".$shift['day']."' />
                                    <label for='beginning'>beginning</label>
                                    <input type='time' id='beginning' name='beginning' value='".$shift['beginning']."' />
                                    <label for='end'>end</label>
                                    <input type='time' id='end' name='end' value='".$shift['end']."' />
                                    <label for='status'>Открытая смена</label>
                                    <input type='radio' id='status' name='status' ".($shift['status'] == 1 ? 'checked' : '')." value='1' />
                                    <label for='status_closed'>Закрытая смена</label>
                                    <input type='radio' id='status_closed' name='status' ".($shift['status'] == 0 ? 'checked' : '')." value='0' />
                                    ";
                                    for($i = 0; $i < sizeof($users); $i++){
                                        echo "<label for='user$i'>".$users[$i]['login']." - ".$users[$i]['name']." - ".$users[$i]['role_name']."</label>";
                                        echo "<input type='checkbox' name='users[]' ".(str_contains($shift['user_login'], $users[$i]['login']) ? 'checked' : '')." id='user$i' value='".$users[$i]['login']."' />";
                                    }
                                    echo "</div>
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