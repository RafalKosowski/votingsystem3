
<?php
require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');

use Controller\VoteController;
use Controller\UserController;
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


    <h1>User List</h1>

    <?php
    use Controller\AdminController;

    require_once("../../Controller/AdminController.php");

    $adminController = new AdminController();

    $users = $adminController->showAllUsers();

    if (isset($_POST['deleteUser'])) {
        $userIdToDelete = $_POST['deleteUser'];
        $adminController->deleteUser($userIdToDelete);
    }


    if (isset($_POST['editUser'])) {
        $userIdToEdit = $_POST['editUser'];
        $editedUserData = $adminController->editUser($userIdToEdit);

        echo '<form action="" method="post">';
        echo 'First Name: <input type="text" name="editedFirstName" value="' . $editedUserData['firstname'] . '"><br>';
        echo 'Last Name: <input type="text" name="editedLastName" value="' . $editedUserData['lastname'] . '"><br>';
        echo 'Permission: <input type="text" name="editedPermission" value="' . $editedUserData['permission_name'] . '"><br>';
        echo '<input type="hidden" name="userIdToEdit" value="' . $userIdToEdit . '">';
        echo '<button type="submit" name="saveEditedUser">Save Changes</button>';
        echo '</form>';
    }
    if(isset($_POST['logoutAdmin'])){
        $adminIdToLogout = $_POST['logoutAdmin'];
        $adminController->logoutAdmin();
    }

    ?>
    <form action="" method="post">
        <button type="submit" name="logoutAdmin">Logout</button>
    </form>

    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Permission</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <?= $user['id'] ?>
                </td>
                <td>
                    <?= $user['firstname'] ?>
                </td>
                <td>
                    <?= $user['lastname'] ?>
                </td>
                <td>
                    <?= $user['permission_name'] ?>
                </td>
                <td>
                    <form action="" method="post">
                        <button type="submit" name="deleteUser" value="<?= $user['id'] ?>">Delete</button>
                    </form>
                </td>
                <td>
                    <form action="" method="post">
                        <button type="submit" name="editUser" value="<?= $user['id'] ?>">Edit</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</section>
<footer>
    // tu bedzie stopka
</footer>
</body>
</html>

