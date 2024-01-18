<?php
require_once("../Model/User.php");
session_start();


if (isset($_SESSION['current_user'])){
    $current_user = $_SESSION['current_user'];
    $user_permission = $current_user->permission_id;

    echo $user_permission;

    switch ($user_permission){
        
        case 4:
            header("Location: roles/admin/admin.php");
            break;

        case 3:
            header("Location: roles/user/user.php");
            break;
        case 2:
            header("Location: roles/secretary/secretary.php");
            break;
        case 1:
            header("Location: roles/admin/admin.php");
            break;

        default:
            echo "Ups. We have a problem";
    }





}


