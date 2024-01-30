
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style>
    .logout-btn {
        background-color: #ffb2a9; /* Czerwony */
        transition-duration: 0.4s;
    }

    .logout-btn:hover {
        background-color: #da190b;
        color: white;
    }
</style>

<?php
global $x;
error_reporting(0);
ini_set('display_errors', 0);
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');

use Controller\UserController;



$uc = new UserController();
$user = $uc->getLoggedUser();
$menu = new MenuView();
$x= isset($x) ? $x: 100;
$menu->getMenu($user->permission_id, $x);
?>




<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>