<?php
require_once("../Model/User.php");
session_start();


if (isset($_SESSION['current_user'])){
    $current_user = $_SESSION['current_user'];
    $user_permission = $current_user->permission_id;

    echo $user_permission;

    switch ($user_permission){
        case 3:
            header("Location: user/user.php");
            break;
        case 2:
            header("Location: secretary/secretary.php");
            break;
        case 1:
            header("Location: admin/admin.php");
            break;

        default:
            echo "Ups. We have a problem";
    }





}


