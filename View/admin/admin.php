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
?>

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
                <td><Button>Edit</Button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>