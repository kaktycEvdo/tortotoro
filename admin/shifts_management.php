<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortotoro Users</title>
</head>
<body>
    <?php
        if($_SESSION['user_role'] === "admin"){
            echo "access granted";
        }
        else{
            echo "wtf";
        }
    ?>
</body>
</html>