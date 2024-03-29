<?php
use Controller\AnswerController;
use Controller\VoteController;
use Controller\UserVoteController;

require_once("VoteController.php");
require_once("AnswerController.php");
require_once("UserVoteController.php");
require_once("../Model/User.php");
require_once("../Database/Database.php");

session_start();
$voteController = new VoteController();
$answerController = new AnswerController();
$userVoteController = new UserVoteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming form fields are named 'answer_id'
    // You may need to adjust these based on your form structure
    $userId = isset($_SESSION['current_user']) ? $_SESSION['current_user']->id :null;

    $voteId = isset($_POST['vote_id']) ? $_POST['vote_id'] : null;
    $selectedAnswerId = isset($_POST['answer_id']) ? $_POST['answer_id'] : null;
    echo($_POST['answer_id']);

    // Check if all required fields are filled
    if ($userId === null || $voteId === null || $selectedAnswerId === null) {
        echo('user: '.$userId. '  vote: '. $voteId .' selected: '. $selectedAnswerId);
        echo('<br>');
        echo ' Invalid form submission.';
        header('Location: /View/dashboard/dashboard.php?err=true');
        exit;
    }

    // Check if the user has already voted for this particular vote
    $existingVote = $userVoteController->readByUserAndVote($userId, $voteId);

    if ($existingVote) {
        // User has already voted, update the existing vote
        $userVoteController->update($existingVote['id'], [
            'selected_answer' => $selectedAnswerId,
        ]);

        echo 'Vote updated successfullyaaa!';
        header('Location: /View/dashboard/dashboard.php?updated=true');
    } else {
        // User hasn't voted for this vote, create a new vote
        $userVoteController->create(
            $userId,
             $voteId,
            $selectedAnswerId
        );

        echo 'Vote submitted successfullyaaa!';

        header('Location: /View/dashboard/dashboard.php?submited=true');
    }
} else {
    echo 'Invalid request.';
    header('Location: /View/dashboard/dashboard.php?err=true');
}
?>
