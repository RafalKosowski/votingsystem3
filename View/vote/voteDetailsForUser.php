<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Details</title>
</head>
<body>
<?php

use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
// Assume $voteController is an instance of your VoteController
// Assume $_GET['id'] contains the vote ID from the URL parameter
$voteController = new VoteController();
$voteId = isset($_GET['id']) ? $_GET['id'] : null;

if ($voteId === null) {
    echo '<p>Invalid vote ID.</p>';
} else {
    $vote = $voteController->read($voteId);

    if ($vote) {
        echo '<h1>' . $vote['name'] . '</h1>';
        echo '<p>Start Date: ' . $vote['startdate'] . '</p>';
        echo '<p>End Date: ' . $vote['enddate'] . '</p>';
        echo '<p>Question: ' . $vote['question'] . '</p>';

        // You can add more details based on your database structure

        // Add a link to answer the questions if the vote is active
        $currentDate = date('Y-m-d H:i:s');
        if ($currentDate >= $vote['startdate'] && $currentDate <= $vote['enddate']) {
            echo '<a href="voteAnswerForm.php?id=' . $voteId . '">Answer Questions</a>';
        } else {
            echo '<p>This vote is not currently active.</p>';
        }
    } else {
        echo '<p>Vote not found.</p>';
    }
}
?>
</body>
</html>
