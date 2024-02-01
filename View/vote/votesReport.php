

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Raport</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php
require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');

use Controller\VoteController;
use Controller\UserController;
require_once("../../Controller/UserController.php");

$userController = new UserController();

if(!$userController->checkUserAccess(2)){
    header("Location: ../error/nopermission.php");
}

$x = 2;
include "../elements/menu.php";
?>

<section class="container mt-4">

    <!-- Formularz do wyboru dat -->
    <form action="" method="post">
        <div class="form-group">
            <label for="startDate">Data początkowa:</label>
            <input type="date" id="startDate" name="startDate" class="form-control">
        </div>
        <div class="form-group">
            <label for="endDate">Data końcowa:</label>
            <input type="date" id="endDate" name="endDate" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Pokaż raport</button>
    </form>

    <?php
    $voteController = new VoteController();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];

        $data = $voteController->getVotingReport($startDate, $endDate);

        if (isset($data)) {
           require_once ('../elements/votesTable.php');

           echo "<form action='../PDF/generatePDFwithVotes.php' method='post'>";
            echo "<input type='hidden' name='startDate' value='$startDate'>";
            echo "<input type='hidden' name='endDate' value='$endDate'>";
            echo "<button type='submit' class='btn btn-success'>Generuj PDF</button>";
            echo "</form>";
        } else {
            echo '<p>Nie było głosowań w wybranym okresie</p>';
        }
    }
    ?>

</section>

<?php include_once "../elements/footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
