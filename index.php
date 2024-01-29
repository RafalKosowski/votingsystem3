<?php
session_start();

use Controller\UserController;
use Model\User;

require ("Controller/UserController.php");
require ("Model/User.php");
require_once('Database/Database.php');
function test()
{
    for ($i = 11; $i < 100; $i++) {
        $user= new User();
        $user->newUser(
            1, "user$i", "zaq1@WSX",
            "user$i@user.pl",
            "User$i",
            "User",
            "3"
        );
        $userController = new UserController( $user );

        $a = (array) $user;
        $userController->create($a);
    }

}

//test();

if(!isset($_SESSION['current_user'])){
    header('location: View/loginForm.php');
}else{
    header('location: View/dashboard.php');
}
