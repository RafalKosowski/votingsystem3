<?php
session_start();
//error_reporting(0);
//ini_set('display_errors', 0);
use Controller\AdminController;

require_once("../../Controller/AdminController.php");

$adminController = new AdminController();

if (isset($_POST['deleteUser'])) {
    $userIdToDelete = $_POST['deleteUser'];
    $adminController->deleteUser($userIdToDelete);
    exit;
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
        exit;
    } else {
        echo "User not found!";
    }
}

if (isset($_POST['saveEditedUser'])) {
    $userIdToEdit = $_POST['userIdToEdit'];
    $editedFirstName = $_POST['editedFirstName'];
    $editedLastName = $_POST['editedLastName'];
    $editedPermission = $_POST['editedPermission'];

    $adminController->editUser($userIdToEdit, $editedFirstName, $editedLastName, $editedPermission);
    exit;
}

if (isset($_POST['logoutAdmin'])) {
    $adminController->logoutAdmin();
    exit;
}

if (isset($_POST['deleteVoteName'])) {
    $voteIdToDelete = $_POST['deleteVoteName'];

    $adminController->deleteVoteName($voteIdToDelete);
    exit;
}

if (isset($_POST['editVoteName'])) {
    $voteIdToEdit = $_POST['editVoteName'];
    $editedVoteData = $adminController->getVoteById($voteIdToEdit);
    if ($editedVoteData) {
        ?>
        <form action="" method="post">
            <label for="editedVoteName">Vote Name:</label><br>
            <input type="text" id="editedVoteName" name="editedVoteName" value="<?= $editedVoteData['vote_name'] ?>"><br>
            <input type="hidden" name="voteIdToEdit" value="<?= $voteIdToEdit ?>">
            <button class="btn" type="submit" name="saveEditedVote">Save Changes</button>
        </form>
        <?php
        exit;
    } else {
        echo "Vote not found!";
    }
}

if (isset($_POST['saveEditedVote'])) {
    $voteIdToEdit = $_POST['voteIdToEdit'];
    $editedVoteName = $_POST['editedVoteName'];

    $adminController->editVoteType($voteIdToEdit, $editedVoteName);
    exit;
}

$users = $adminController->showAllUsers();
$votes = $adminController->getVotes();
$voteName = $adminController->getVotesNames();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
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

        th,
        td {
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
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .col-6 {
            float: left;
            width: 50%;
            padding: 0 15px;
        }

        @media screen and (max-width: 600px) {
            .col-6 {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <button class="btn" type="submit" name="logoutAdmin">Logout</button>
        </form>
        <button onclick="goBack()">Powrót</button>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <div class="row">
            <div class="col-6">
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
                                        <button class="btn" type="submit" name="deleteUser"
                                            value="<?= $user['id'] ?>">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <button class="btn" type="submit" name="editUser"
                                            value="<?= $user['id'] ?>">Edit</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <h1>Vote List</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Login</th>
                            <th>Vote</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Question</th>
                            <th>Vote Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($votes as $vote): ?>
                            <tr>
                                <td>
                                    <?= $vote['id'] ?>
                                </td>
                                <td>
                                    <?= $vote['user_login'] ?>
                                </td>
                                <td>
                                    <?= $vote['vote_name'] ?>
                                </td>
                                <td>
                                    <?= $vote['startdate'] ?>
                                </td>
                                <td>
                                    <?= $vote['enddate'] ?>
                                </td>
                                <td>
                                    <?= $vote['question'] ?>
                                </td>
                                <td>
                                    <?= $vote['vote_type'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <h1>Vote Type List</h1>
        <table>
            <thead>
                <tr>
                    <th>Vote Id</th>
                    <th>Vote Name</th>
                    <th>Vote Type</th>
                    <th>Usuń</th>
                    <th>Edytuj</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voteName as $vote): ?>
                    <tr>
                        <td>
                            <?= $vote['vote_id'] ?>
                        </td>
                        <td>
                            <?= $vote['vote_name'] ?>
                        </td>
                        <td>
                            <?= $vote['vote_type'] ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <button class="btn" type="submit" name="deleteVoteName"
                                    value="<?= $vote['vote_id'] ?>">Delete</button>
                            </form>
                        </td>
                        <td>
                            <form action="" method="post">
                                <button class="btn" type="submit" name="editVoteName"
                                    value="<?= $vote['vote_id'] ?>">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>