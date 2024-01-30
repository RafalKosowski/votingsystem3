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
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>
<?php include "../elements/menu.php";?>
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
    Stopka
</footer>
</body>
</html>
