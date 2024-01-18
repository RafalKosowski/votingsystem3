<?php

use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
session_start();
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
    $user_permission = $current_user->permission_id;



//    $activeVotes = $voteController->getActiveVotesForUser($current_user->id);
}
$voteController = new VoteController();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Votes</title>
</head>
<body>
<button>
    <a href="addVoteForm.php"> Dodaj Głosowanie </a>
</button>
<div>
    <h1>Aktywne głosowania</h1>

    <?php

    $activeVotes = $voteController->getActiveVotes();
    $voteController ->showVotes($activeVotes);

    ?>
</div>

<div>
    <h1>Zakończone głosowania</h1>
    <?php

    $completedVotes = $voteController->getCompletedVotes();
    $voteController ->showVotes($completedVotes);

    ?>
</div>

<div>
    <h1>Nadchodzące głosowania</h1>
    <?php

    $upcomingVotes = $voteController->getUpcomingVotes();
    $voteController ->showVotes($upcomingVotes);

    ?>
</div>


</body>
</html>
