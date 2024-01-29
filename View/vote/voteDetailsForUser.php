<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Details</title>
</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    p {
        text-align: center;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
    }

    a:hover {
        background-color: #45a049;
    }
</style>

<?php
error_reporting(0);
ini_set('display_errors', 0);
use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");

$voteController = new VoteController();
$voteId = isset($_GET['id']) ? $_GET['id'] : null;

if ($voteId === null) {
    echo '<p>Invalid vote ID.</p>';
} else {
    $vote = $voteController->read($voteId);

    if ($vote) {
        echo '<h1>' . $vote['name'] . '</h1>';
        echo '<p>Data rozpoczęcia: ' . $vote['startdate'] . '</p>';
        echo '<p>Data zakończenia: ' . $vote['enddate'] . '</p>';
        echo '<p>Pytanie: ' . $vote['question'] . '</p>';


        $currentDate = date('Y-m-d H:i:s');
        if ($currentDate >= $vote['startdate'] && $currentDate <= $vote['enddate']) {
            //można zrobić jakiś przycisk
            echo '<a href="voteAnswerForm.php?id=' . $voteId . '">Zagłosuj teraz!</a>';
        } else {
            echo '<p>To głosowanie jest obecnie niedostępne</p>';

        }
    } else {
        echo '<p>Nie znaleziono głosowania</p>';
        // mozna zrobić przekierowanie na 404
    }
}
?>
</body>
</html>
