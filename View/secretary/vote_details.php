<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Details</title>
</head>
<body>
<?php

use Controller\AnswerController;
use Controller\UserController;
use Controller\UserVoteController;
use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserVoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Controller/AnswerController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
// Assume $voteController is an instance of your VoteController
// Assume $_GET['id'] contains the vote ID from the URL parameter
$voteController = new VoteController();
$userVoteController = new UserVoteController();
$userController = new UserController();
$answerController = new AnswerController();

$voteId = isset($_GET['id']) ? $_GET['id'] : null;

if ($voteId === null) {
    echo '<p>Invalid vote ID.</p>';
} else {
    $vote = $voteController->getVoteWithAllDetails($voteId);

    if ($vote) {
        echo '<h1>' . $vote['name'] . '</h1>';
        echo '<div class="vote_valid"><p>'.
        $voteController->isVoteValid($voteId) ? '<li style="color:green">Ważne </li>': '<li style="color:red">Nieważne </li>'
            .'</p></div>';
        echo '<p>Data rozpoczęcia: ' . $vote['startdate'] . '</p>';
        echo '<p>Data zakończenia: ' . $vote['enddate'] . '</p>';
        echo '<p>Pytanie: ' . $vote['question'] . '</p>';
        echo '<p>Typ głosowania: ' . $vote['vote_type_name'] . '</p>';
        echo '<p>Kworum: ' . $vote['quorum_name'] . '</p>';
        echo '<p>Większość: ' . $vote['majority_name'] . '</p>';
        echo '<p>Odpowiedzi:</p>';
        // Get the answers and votes
        $answers = $answerController->read($voteId);
        $votes = $userVoteController->countAndGroupBySelectedAnswer($voteId);

        print_r($votes);
        // Calculate the total votes
        $totalUsers = $userController->countUsers();
        echo 'tu:'.$totalUsers;
// to do and repair
        // Display the answers and vote percentages
        foreach ($answers as $index => $answer) {
            $votesForAnswer = isset($votes[$index]) ? $votes[$index]['liczba'] : 0;
            echo $votesForAnswer;
            $percentage = $totalUsers > 0 ? round(($votesForAnswer / $totalUsers) * 100, 2) : 0;
            echo '<p>Odpowiedź: ' . $answer . ' - Głosy: ' . $votesForAnswer . ' (' . $percentage . '%)</p>';
        }
    } else {
        echo '<p>Vote not found.</p>';
    }

}
?>
</body>
</html>
