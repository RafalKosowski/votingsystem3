<?php

use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
session_start();
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
    $user_permission = $current_user->permission_id;

    $voteController = new VoteController();

//    $activeVotes = $voteController->getActiveVotesForUser($current_user->id);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Votes</title>
</head>
<body>
<h1>List of Votes</h1>

<?php
// Assume $voteController is an instance of your VoteController
$activeVotes = $voteController->getActiveVotes();

if (empty($activeVotes)) {
    echo '<p>No active votes available.</p>';
} else {
    echo '<ul>';
    foreach ($activeVotes as $vote) {
        echo '<li>';
        echo '<a href="/votingsystem3/View/user/voteDetailsForUser.php?id=' . $vote['id'] . '">' . $vote['name'] . '</a>';
        echo '</li>';
    }
    echo '</ul>';
}
?>

</body>
</html>
