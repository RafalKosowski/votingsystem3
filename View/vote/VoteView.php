<?php
error_reporting(0);
ini_set('display_errors', 0);
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
        $this ->showVoteList($activeVotes, 'Aktywne głosowania',2);
        $completedVotes= $voteController->getUpcomingVotes();
        $this ->showVoteList($completedVotes, 'Zakończone głosowania',2);
        $upcomingVotes = $voteController->getUpcomingVotes();
        $this ->showVoteList($upcomingVotes, 'Nadchodzące głosowania',2);

    }

    public function buildVoteListForUser()
    {
        global $userId;

        $voteController = new VoteController();
        $activeVotes = $voteController->getActiveVotes($userId);
        $this ->showVoteList($activeVotes, 'Aktywne głosowania',3);

    }

    public function showVoteList($votes,$nameList,$userLevel)
    {
        echo '<div>';
        echo  '<h1>'. $nameList .'</h1>';
        if (empty($votes)) {
            echo '<p>No votes available.</p>';
        } else {
            echo '<ul>';
            foreach ($votes as $vote) {
                echo '<li>';
                if ($userLevel<3){
                    echo '<a href="voteDetailsForSecretary.php?id=' . $vote['id'] . '">' . $vote['name'] . '</a>';
                }elseif ($userLevel>=3){
                    echo '<a href="voteDetailsForUser.php?id=' . $vote['id'] . '">' . $vote['name'] . '</a>';
                }


                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
}
?>

