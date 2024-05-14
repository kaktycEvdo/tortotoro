<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизационная страница</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <main>
        <form action="php/process_user.php?action=auth" method="POST">
            <h2>Авторизация</h2>
            <>
                <label for="login">Логин</label>
                <input id="login" name="login" maxlength="50" />
                <label for="password">Пароль</label>
                <input id="password" name="password" maxlength="50" />
            </div>
            <div>
                <input type="submit" value="Авторизоваться" />
            </div>
        </form>
    </main>
</body>
</html>