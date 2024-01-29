<?php

require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');
require_once("VoteView.php");

use Controller\UserController;

$userController = new UserController();
$voteView = new VoteView();

?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>
<nav>
    <?php

    $uc = new UserController();
    $user = $uc->getLoggedUser();
    $menu = new MenuView();
    $menu->getMenu($user->permission_id, 2);
    ?>

</nav>
<section>
    <button>
        <a href="addVoteForm.php"> Dodaj Głosowanie </a>
    </button>
    <?php
    if ($userController->checkUserAccess(2)) {
        $voteView->buildVoteListForSecretary();
    } elseif ($userController->checkUserAccess(3)) {
        $voteView->buildVoteListForUser();
    }
    ?>
</section>
<footer>
    // tu bedzie stopka
</footer>
</body>
</html>
