<?php

use Database\Database;
use Model\User;

session_start();

require_once ("../Database/Database.php");
require_once "../Model/User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Pobranie instancji połączenia z bazą danych
    $pdo = Database::getInstance()->getConnection();

    // Przygotowanie zapytania SQL
    $stmt = $pdo->prepare("SELECT * FROM user WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Sprawdzenie, czy użytkownik istnieje i czy hasło jest poprawne
    if ($user && password_verify($password, $user['password'])) {
        $us = new User();
        $us->create(
            $user['id'],
            $user['login'],
            $user['email'],
            $user['firstname'],
            $user['lastname'],
            $user['permission_id']
        );
        $_SESSION['current_user'] = $us;
        header("Location: /View/dashboard.php");
    } else {
        header("Location: /View/loginForm.php?loginError=1");
    }
}