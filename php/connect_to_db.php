<?php
    $env = parse_ini_file('../.env');
try{
    $pdo = new PDO("mysql:host=".$env["HOST"].";dbname=".$env["DB_NAME"], $env["USER"], $env["PSWRD"]);
}
catch (PDOException $e) {
    header("Location: ../", response_code:500);
}