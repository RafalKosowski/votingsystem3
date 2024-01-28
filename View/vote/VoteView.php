<?php

use Controller\UserController;
use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");

$userController = new UserController();
$userId = $userController->getLoggedUser()->id;
class VoteView
{




    public function buildVoteListForSecretary()
    {
        $voteController = new VoteController();
        $activeVotes = $voteController->getActiveVotes();
        $this ->showVoteList($activeVotes, 'Aktywne głosowania');
        $completedVotes= $voteController->getUpcomingVotes();
        $this ->showVoteList($completedVotes, 'Zakończone głosowania');
        $upcomingVotes = $voteController->getUpcomingVotes();
        $this ->showVoteList($upcomingVotes, 'Nadchodzące głosowania');

    }

    public function buildVoteListforUser()
    {
        global $userId;

        $voteController = new VoteController();
        $activeVotes = $voteController->getActiveVotesForUser($userId);
        $this ->showVoteList($activeVotes, 'Aktywne głosowania');

    }

    public function showVoteList($votes,$nameList)
    {
        echo '<div>';
        echo  '<h1>'. $nameList .'</h1>';
        if (empty($votes)) {
            echo '<p>No votes available.</p>';
        } else {
            echo '<ul>';
            foreach ($votes as $vote) {
                echo '<li>';
                echo '<a href="/votingsystem3/View/secretary/voteDetailsForUser.php?id=' . $vote['id'] . '">' . $vote['name'] . '</a>';

                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
}
?>
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

    div {
        margin-bottom: 20px;
    }

    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    li {
        margin-bottom: 10px;
    }
</style>
