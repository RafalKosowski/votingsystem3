<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 10px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    session_start();

    use Controller\AdminController;

    require_once("../../Controller/AdminController.php");

    $adminController = new AdminController();

    if (isset($_POST['deleteUser'])) {
        $userIdToDelete = $_POST['deleteUser'];
        $adminController->deleteUser($userIdToDelete);
    }

    if (isset($_POST['editUser'])) {
        $userIdToEdit = $_POST['editUser'];
        $editedUserData = $adminController->getUserById($userIdToEdit);
        if ($editedUserData) {
            ?>
            <form action="" method="post">
                <label for="editedFirstName">First Name:</label><br>
                <input type="text" id="editedFirstName" name="editedFirstName" value="<?= $editedUserData['firstname'] ?>"><br>
                <label for="editedLastName">Last Name:</label><br>
                <input type="text" id="editedLastName" name="editedLastName" value="<?= $editedUserData['lastname'] ?>"><br>
                <label for="editedPermission">Permission:</label><br>
                <input type="text" id="editedPermission" name="editedPermission" value="<?= $editedUserData['permission_id'] ?>">
                <input type="hidden" name="userIdToEdit" value="<?= $userIdToEdit ?>">
                <button class="btn" type="submit" name="saveEditedUser">Save Changes</button>
            </form>
            <?php
        } else {
            echo "User not found!";
        }
    }

    if (isset($_POST['logoutAdmin'])) {
        $adminController->logoutAdmin();
    }

    if (isset($_POST['saveEditedUser'])) {
        $userIdToEdit = $_POST['userIdToEdit'];
        $editedFirstName = $_POST['editedFirstName'];
        $editedLastName = $_POST['editedLastName'];
        $editedPermission = $_POST['editedPermission'];

        $adminController->editUser($userIdToEdit, $editedFirstName, $editedLastName, $editedPermission);
    }

    $users = $adminController->showAllUsers();
    ?>

    <form action="" method="post">
        <button class="btn" type="submit" name="logoutAdmin">Logout</button>
    </form>

    <h1>User List</h1>

    <table>
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
                <td><?= $user['id'] ?></td>
                <td><?= $user['firstname'] ?></td>
                <td><?= $user['lastname'] ?></td>
                <td><?= $user['permission_name'] ?></td>
                <td>
                    <form action="" method="post">
                        <button class="btn" type="submit" name="deleteUser" value="<?= $user['id'] ?>">Delete</button>
                    </form>
                </td>
                <td>
                    <form action="" method="post">
                        <button class="btn" type="submit" name="editUser" value="<?= $user['id'] ?>">Edit</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
