<!-- Formularz do wyboru dat -->
<form action="" method="post">
    <label for="startDate">Data początkowa:</label><br>
    <input type="date" id="startDate" name="startDate"><br>
    <label for="endDate">Data końcowa:</label><br>
    <input type="date" id="endDate" name="endDate"><br>
    <input type="submit" value="Pokaż raport">
</form>



<?php

use Controller\VoteController;

require_once("../../Controller/VoteController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
$voteController = new VoteController();

// Sprawdź, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz daty z formularza
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Pobierz dane
    $data = $voteController->getVotingReport($startDate, $endDate);

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
}
?>
<form action="../PDF/generatePDFwithVotes.php" method="post">
    <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
    <input type="hidden" name="endDate" value="<?php echo $endDate; ?>">
    <input type="submit" value="Generuj PDF">
</form>
