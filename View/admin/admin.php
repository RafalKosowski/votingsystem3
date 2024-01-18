<h1>User List</h1>

<?php
use Controller\AdminController;

require_once("../../Controller/AdminController.php");

$adminController = new AdminController();

$users = $adminController->showAllUsers();


foreach ($users as $user) {
    echo "ID: " . $user['id'] . ", Name: " . $user['firstname'] . " " . $user['lastname'] . ", Permission: " . $user['permission_name'] . "<br>";
}
?>
