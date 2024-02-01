<?php

echo "<table class='table'>";
//echo "<thead class='thead-dark'>";
echo "<tr><th>ID Głosowania</th><th>Nazwa Głosowania</th><th>Data Zakończenia</th><th>Liczba Głosujących</th><th>Liczba Uprawnionych</th><th>Status Głosowania</th><th>Szczegóły</th></tr>";
//echo "</thead>";
//echo "<tbody>";
foreach ($data as $row) {
    echo "<tr>";
    echo "<td>" . $row['ID Głosowania'] . "</td>";
    echo "<td>" . $row['Nazwa Głosowania'] . "</td>";
    echo "<td>" . $row['Data Zakończenia'] . "</td>";
    echo "<td>" . $row['Liczba Głosujących'] . "</td>";
    echo "<td>" . $row['Liczba Uprawnionych'] . "</td>";
    echo "<td>" . $row['Status Głosowania'] . "</td>";
    echo "<td><a href='../vote/voteDetailsforSecretary.php?id=" . $row['ID Głosowania'] . "' class='btn btn-info btn-sm'>Szczegóły</a></td>";
    echo "</tr>";
}
//echo "</tbody>";
echo "</table>";