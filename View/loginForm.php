
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <h1>
        Zaloguj się
    </h1>
    <?php
    error_reporting(0);
    ini_set('display_errors', 0);
    if (isset($_GET['loginError'])&&$_GET['loginError']==1)
        echo('<p class="loginError">Podano niepoprawne dane logowania</p>');
    if (isset($_GET['logout'])&&$_GET['logout']==1)
        unset($_SESSION['currentUser']);
        session_destroy();
            echo('<p class="loginError">Wylogowano pomyślnie</p>');

    ?>
    <form action="../Controller/Auth.php" method="post">
        <label for="login">Login:</label><br>
        <input type="text" id="login" name="login"><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Zaloguj się">
    </form>

</body>
</html>