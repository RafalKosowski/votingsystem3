<?php



use Controller\UserController;
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");

$userController = new UserController();

if(!$userController->checkUserAccess(2)){
    header("Location: ../error/nopermission.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        }

        p {
            text-align: center;
        }

        form {
            width: 80%;
            margin: 20px auto;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<?php


use Controller\AnswerController;
use Controller\UserVoteController;
use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserVoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Controller/AnswerController.php");
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
        // Calculate the total votes
        $totalUsers = $userVoteController->countVoteWithVoteId($voteId);
        echo '<p> Głosowało:'.$totalUsers.'</p>';
        echo '<p>Odpowiedzi:</p>';
        // Get the answers and votes
        $answers = $answerController->read($voteId);
        $votes = $userVoteController->countAndGroupBySelectedAnswer($voteId);





 $voteResult=[];

        $i = 1;
        foreach ($votes as $vote) {
            $voteResult[$answers['option'.$vote['selected_answer']]]=$vote['number'];
        }

        echo '<table class="answersForVote">';
        echo '<tr><th>Odpowiedź</th><th>Głosy</th><th>Procentowo</th></tr>';
        foreach ($answers as $index => $answer) {
            if($index!= 'id' && $answer!=null){
                $v = isset($voteResult[$answer]) ? $voteResult[$answer] :0;
                $percentage = $totalUsers > 0 ? round(($v / $totalUsers) * 100, 2) : 0;
                echo '<tr><td>' . $answer. '</td><td>' . $v . '</td><td>' . $percentage . '%</td></tr>';
            }

        }
        echo '</table>';
        echo '  <!-- Dodaj miejsce na wykres -->';
        echo '<canvas id="myChart" style="max-width: 200px; max-height: 200px;"></canvas>
';
    } else {
        echo '<p>Vote not found.</p>';
    }

}
?>

</body>
<!-- Skrypt do generowania wykresu -->
<script>
    // Dane do wykresu
    var labels = <?php echo json_encode(array_map(function($label, $percentage) {
        return $label . ' (' . $percentage . '%)';
    }, array_keys($voteResult), array_map(function($value) use ($totalUsers) {
        return round(($value / $totalUsers) * 100, 2);
    }, array_values($voteResult)))); ?>;

    var data = <?php echo json_encode(array_values($voteResult)); ?>;



    // Utwórz kontekst dla wykresu
    var ctx = document.getElementById('myChart').getContext('2d');

    // Utwórz wykres kołowy
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(5,245,79,0.7)',
                    'rgba(239,10,10,0.7)',
                    'rgba(66,155,232,0.7)',
                    'rgba(30,77,180,0.7)',
                    'rgba(107,30,180,0.7)',
                    'rgba(66,62,62,0.7)',
                    // Dodaj więcej kolorów według potrzeb
                ],
            }]
        },
    });
</script>
</html>
