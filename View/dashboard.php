<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<nav>
    <?php
    require_once('../Model/User.php');
    require_once('../Controller/UserController.php');

    require_once('MenuView.php');

    use Controller\UserController;

    $uc = new UserController();
    $user = $uc->getLoggedUser();
    $menu = new MenuView();
    $menu->getMenu($user->permission_id, 10);



    ?>

</nav>

<section>
    <p> Witaj w systemie głosowania</p>

</section>
<footer>
    // tu bedzie stopka
</footer>
</body>
</html>

