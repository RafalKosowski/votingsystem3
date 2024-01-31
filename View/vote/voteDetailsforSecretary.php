<?php
require_once("../../Controller/VoteController.php");
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


$userController = new UserController();

if (!$userController->checkUserAccess(2)) {
    header("Location: ../error/nopermission.php");
}

?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../style.css">



    <title> Raport szczegółowy</title>
</head>
<body>
<?php include "../elements/menu.php"; ?>
<div class="container">

    <?php
        require_once("../elements/voteDetailsForReport.php");

    ?>
    <div class="chart-container">
        <h6>  Wykres </h6>
        <canvas id="myChart" style="max-width: 200px; max-height: 200px;"></canvas>
    </div>

    <form method="post" action="../PDF/generatePDFwithVoteDetails.php?id=<?php echo $_GET['id']?>;" target="_blank">
        <button type="submit" name="generate_pdf">Generate PDF</button>
    </form>

</div>
<?php include_once "../elements/footer.php"; ?>
<script>
    // Dane do wykresu
    var labels = <?php echo json_encode(array_map(function ($label, $percentage) {
        return $label . ' (' . $percentage . '%)';
    }, array_keys($voteResult), array_map(function ($value) use ($totalUsers) {
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
</body>
</html>








