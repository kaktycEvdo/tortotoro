<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortotoro Orders</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <?php
        if($_SESSION['user_role'] == "cook"){
            echo "access granted";
        }
        else{
            echo "wtf";
        }
    ?>
</body>
</html>