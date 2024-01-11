<?php

namespace Controller;

use Database\Database;
use Model\User;
use PDO;

class UserController
{
    private $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function create($data) {
        // Pobranie instancji połączenia z bazą danych
        $pdo = Database::getInstance()->getConnection();

        // Przygotowanie zapytania SQL
        $stmt = $pdo->prepare("INSERT INTO user (login, password, email, firstname, lastname, permission_id) VALUES (:login, :password, :email, :firstname, :lastname, :permission_id)");

        // Powiązanie parametrów
        $stmt->bindParam(':login', $data['login']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':permission_id', $data['permission_id']);

        // Wykonanie zapytania
        $stmt->execute();
    }
    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE user SET login = :login, password = :password, email = :email, firstname = :firstname, lastname = :lastname, permission_id = :permission_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':login', $data['login']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':permission_id', $data['permission_id']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


}