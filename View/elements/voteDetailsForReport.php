<?php

require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserVoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Controller/AnswerController.php");
require_once("../../Database/Database.php");

use Controller\VoteController;
use Controller\UserController;
use Controller\AnswerController;
use Controller\UserVoteController;


?>
<section>

    <?php
    //error_reporting(0);
    //ini_set('display_errors', 0);
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
        $voteValid= $voteController->isVoteValid($voteId) ? '<p style="color:#41f641">Ważne</p>' : '<p style="color:red">Nieważne</p>';

        //style="color:#41f641" style="color:red"


        if ($vote) {
            echo '<div class="vote-details">';

            echo '<h1>' . $vote['name'] . '</h1>';
          //  echo '<div class="vote_valid">';
           //echo '<p>'.$voteValid.'</p> ';
           echo $voteValid;
           // echo '</p>';
        //    echo '</div>';
            echo '<p>Data rozpoczęcia: ' . $vote['startdate'] . '</p>';
            echo '<p>Data zakończenia: ' . $vote['enddate'] . '</p>';
            echo '<p>Pytanie: ' . $vote['question'] . '</p>';
            echo '<p>Typ głosowania: ' . $vote['vote_type_name'] . '</p>';
            echo '<p>Kworum: ' . $vote['quorum_name'] . '</p>';
            echo isset($vote['majority_name'] ) ? '<p>Większość: ' . $vote['majority_name'] . '</p>':'';
// Calculate the total votes
            $totalUsers = $userVoteController->countVoteWithVoteId($voteId);
            echo '<p class="total-votes"> Głosowało: ' . $totalUsers . '</p>';

            echo '</div>';


            // Get the answers and votes
            $answers = $answerController->read($vote['answers_id']);
            $votes = $userVoteController->countAndGroupBySelectedAnswer($voteId);


            $voteResult = [];

            $i = 1;
            foreach ($votes as $vote) {
                $voteResult[$answers['option' . $vote['selected_answer']]] = $vote['number'];
            }
            echo '<h6> Odpowiedzi </h6>';
            echo '<table class="answersForVote">';
            echo '<tr><th>Odpowiedź</th><th>Głosy</th><th>Procentowo</th></tr>';
            foreach ($answers as $index => $answer) {
                if ($index != 'id' && $answer != null) {
                    $v = isset($voteResult[$answer]) ? $voteResult[$answer] : 0;
                    $percentage = $totalUsers > 0 ? round(($v / $totalUsers) * 100, 2) : 0;
                    echo '<tr><td>' . $answer . '</td><td>' . $v . '</td><td>' . $percentage . '%</td></tr>';
                }

            }
            echo '</table>';


        } else {
            echo '<p>Vote not found.</p>';
        }

    }
    ?>

</section>



