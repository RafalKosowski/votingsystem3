
<?php
require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');
require_once("../../Controller/AnswerController.php");
require_once("../../Controller/UserVoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");


use Controller\VoteController;
use Controller\UserController;
use Controller\AnswerController;
use Controller\UserVoteController;
//error_reporting(0);
//ini_set('display_errors', 0);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Odpowiedz na pytania</title>
</head>
<body>
<?php include "../elements/menu.php";?>

<section>
    <?php



    session_start();
    $voteController = new VoteController();
    $answerController = new AnswerController();
    $userVoteController = new UserVoteController();

    $voteId = isset($_GET['id']) ? $_GET['id'] : null;
    $userId = isset($_SESSION['current_user']) ? $_SESSION['current_user']->id : null;
    $lastSelectedAnswer = $userVoteController->readByUserAndVote($userId, $voteId);

    if ($voteId === null) {
        echo '<p>Invalid vote ID.</p>';
    } else {
        $vote = $voteController->read($voteId);

        if ($vote) {
            echo '<h1>' . $vote['name'] . '</h1>';
            echo '<p>Question: ' . $vote['question'] . '</p>';

            $answers = $answerController->read($vote['answers_id']);

            echo '<form method="post" action="../../Controller/submit_answers.php">';
            echo '<input type="hidden" name="vote_id" value="' . $voteId . '">';

            foreach ($answers as $option => $answer) {


                if (!empty($answer)&& $option!='id') {
                    preg_match('/\d+/', $option, $opt);
                    echo '<label>';
                    echo '<input type="radio" name="answer_id" value="' . $opt[0] . '"';

                    // Sprawdzanie, czy opcja była ostatnio wybrana przez użytkownika
                    if ($lastSelectedAnswer && $opt[0] == $lastSelectedAnswer['selected_answer']) {
                        echo ' checked';
                    }

                    echo '>';
                    echo $answer;
                    echo '</label><br>';
                }
            }

            echo '<input type="submit" value="Submit Answers">';
            echo '</form>';
        } else {
            echo '<p>Vote not found.</p>';
        }
    }
    ?>
</section>
<footer>
    // tu bedzie stopka
</footer>
</body>
</html>








