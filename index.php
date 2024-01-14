<?php
session_start();

use Controller\UserController;
use Model\User;

require ("Controller/UserController.php");
require ("Model/User.php");
require_once('Database/Database.php');
function test()
{
    $user= new User();
    $user->newUser(
        1, "admin", "zaq1@WSX",
        "admin@admin.pl",
        "Admin",
        "Admin",
        "1"
    );
    $userController = new UserController( $user );

    $a = (array) $user;
    $userController->create($a);
}

//test();

if(!isset($_SESSION['current_user'])){
    header('location: View/loginForm.php');
}else{
    header('location: View/dashboard.php');
}
