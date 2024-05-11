<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortotoro Management</title>
</head>
<body>
    <a href="auth.php">auth</a>
    <?php
        switch($_SESSION["user_role"]){
            case "admin":{
                echo "<a href='admin/users_management.php'>users_management</a>";
                break;
            }
            case "waiter":{

                break;
            }
            case "cook":{

                break;
            }
        }
    ?>
</body>
</html>