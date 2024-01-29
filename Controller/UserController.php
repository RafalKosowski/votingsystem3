<?php

namespace Controller;

use Database\Database;
use Model\User;
use PDO;

class UserController
{
    
    
    public function create($data)
    {
        // Pobranie instancji połączenia z bazą danych
        $pdo = Database::getInstance()->getConnection();

        // Sprawdzenie, czy użytkownik o podanym e-mailu już istnieje
        $stmtCheckEmail = $pdo->prepare("SELECT id FROM user WHERE login = :login");
        $stmtCheckEmail->bindParam(':login', $data['login']);
        $stmtCheckEmail->execute();
        $existingUser = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            throw new \Exception("Użytkownik o podanym loginie już istnieje.");
        }

        // Przygotowanie zapytania SQL
        $stmt = $pdo->prepare("INSERT INTO user (login, password, email, firstname, lastname, permission_id) VALUES (:login, :password, :email, :firstname, :lastname, :permission_id)");

        // Hashowanie hasła
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Powiązanie parametrów
        $stmt->bindParam(':login', $data['login']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':permission_id', $data['permission_id']);

        // Wykonanie zapytania
        $stmt->execute();

        // Sprawdzenie błędów po wykonaniu zapytania
        if ($stmt->errorCode() !== '00000') {
            $errorInfo = $stmt->errorInfo();
            throw new \Exception("Error during SQL query execution: " . $errorInfo[2]);
        }
    }


    public function read($id)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function countUsers()
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user ");
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function update($id, $data)
    {
        // Pobranie instancji połączenia z bazą danych
        $pdo = Database::getInstance()->getConnection();

        // Sprawdzenie, czy użytkownik o podanym e-mailu już istnieje (jeśli jest podany)
        if (isset($data['email'])) {
            $stmtCheckEmail = $pdo->prepare("SELECT id FROM user WHERE login = :login AND id <> :id");
            $stmtCheckEmail->bindParam(':login', $data['login']);
            $stmtCheckEmail->bindParam(':id', $id);
            $stmtCheckEmail->execute();
            $existingUser = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                throw new \Exception("Inny użytkownik o podanym loginie już istnieje.");
            }
        }

        // Przygotowanie zapytania SQL
        $stmt = $pdo->prepare("UPDATE user SET login = :login, email = :email, firstname = :firstname, lastname = :lastname, permission_id = :permission_id WHERE id = :id");

        // Powiązanie parametrów
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':login', $data['login']);

        // Aktualizacja hasła tylko jeśli zostało przekazane
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':permission_id', $data['permission_id']);

        // Wykonanie zapytania
        $stmt->execute();

        // Sprawdzenie błędów po wykonaniu zapytania
        if ($stmt->errorCode() !== '00000') {
            $errorInfo = $stmt->errorInfo();
            throw new \Exception("Error during SQL query execution: " . $errorInfo[2]);
        }
    }


    public function delete($id)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Sprawdzenie błędów po wykonaniu zapytania
        if ($stmt->errorCode() !== '00000') {
            $errorInfo = $stmt->errorInfo();
            throw new \Exception("Error during SQL query execution: " . $errorInfo[2]);
        }
    }

    public function getLoggedUser()
    {
        session_start();
        if (isset($_SESSION['current_user'])) {
            return $_SESSION['current_user'];
        }
//        else{
//            //header('Location /votingsystem3/View/loginForm.php');
//        }
        return null;


    }

    public function checkUserAccess($userLevel)
    {
        if($this->getLoggedUser()->permission_id <= $userLevel)
            return true;

        return  false;
    }
}
