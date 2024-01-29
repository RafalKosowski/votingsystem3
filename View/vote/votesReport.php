<?php
require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');

use Controller\VoteController;
use Controller\UserController;
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>
<nav>
    <?php

    $uc = new UserController();
    $user = $uc->getLoggedUser();
    $menu = new MenuView();
    $menu->getMenu($user->permission_id, 2);
    ?>

</nav>

<section>

    <!-- Formularz do wyboru dat -->
    <form action="" method="post">
        <label for="startDate">Data początkowa:</label><br>
        <input type="date" id="startDate" name="startDate"><br>
        <label for="endDate">Data końcowa:</label><br>
        <input type="date" id="endDate" name="endDate"><br>
        <input type="submit" value="Pokaż raport">
    </form>

    <?php

    $voteController = new VoteController();

    // Sprawdź, czy formularz został wysłany
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pobierz daty z formularza
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];

        // Pobierz dane
        $data = $voteController->getVotingReport($startDate, $endDate);

        if (isset($data)) {
            // Wygeneruj tabelę HTML
            echo "<table>";
            echo "<tr><th>ID Głosowania</th><th>Nazwa Głosowania</th><<th>Data Rozpoczęcia</th><th>Data Zakończenia</th><th>Liczba Głosujących</th><th>Liczba Uprawnionych</th><th>Status Głosowania</th><th>Szczegóły</th></tr>";
            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . $row['ID Głosowania'] . "</td>";
                echo "<td>" . $row['Nazwa Głosowania'] . "</td>";
//        echo "<td>" . $row['Data Rozpoczęcia'] . "</td>";
                echo "<td>" . $row['Data Zakończenia'] . "</td>";
                echo "<td>" . $row['Liczba Głosujących'] . "</td>";
                echo "<td>" . $row['Liczba Uprawnionych'] . "</td>";
                echo "<td>" . $row['Status Głosowania'] . "</td>";
                echo "<td><a href='details.php?id=" . $row['ID Głosowania'] . "'>Szczegóły</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo '<form action="../PDF/generatePDFwithVotes.php" method="post">';
            echo '<input type="hidden" name="startDate" value="<?php echo $startDate; ?>">';
            echo '<input type="hidden" name="endDate" value="<?php echo $endDate; ?>">';
            echo '<input type="submit" value="Generuj PDF">';
            echo '</form>';
        } else {
            echo '<p>Nie było głosowań w wybranym okresie</p>';
        }

    }
    ?>


</section>
<footer>
    // tu bedzie stopka
</footer>
</body>
</html>




