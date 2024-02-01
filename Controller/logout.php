<?php
session_start(); // Rozpocznij sesję, jeśli nie została jeszcze rozpoczęta

// Usuń wszystkie zmienne sesyjne
session_unset();

// Zniszcz sesję
session_destroy();

// Przekieruj użytkownika na stronę logowania
header("Location: /View/loginForm.php?logout=1");
exit();
?>
