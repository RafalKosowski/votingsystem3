<?php

namespace Controller;

use Database\Database;
use Model\Answer;
use PDO;

class AnswerController
{
//    private $model;
//
//    public function __construct(Answer $model) {
//        $this->model = $model;
//    }


    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO answers (option1, option2, option3, option4, option5, option6) VALUES (:option1, :option2, :option3, :option4, :option5, :option6)");

        try {
            $stmt->bindParam(':option1', $data['option1']);
            $stmt->bindParam(':option2', $data['option2']);
            $stmt->bindParam(':option3', $data['option3']);
            $stmt->bindParam(':option4', $data['option4']);
            $stmt->bindParam(':option5', $data['option5']);
            $stmt->bindParam(':option6', $data['option6']);
            $stmt->execute();
            return $pdo->lastInsertId(); // Zwróć id ostatnio dodanego rekordu
        } catch (\PDOException $e) {
            // Obsługa błędów dodawania odpowiedzi
            // ...
            throw $e; // Przekaż wyjątek dalej, jeśli to konieczne
        }
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM answers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE answers SET option1 = :option1, option2 = :option2, option3 = :option3, option4 = :option4, option5 = :option5, option6 = :option6 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':option1', $data['option1']);
        $stmt->bindParam(':option2', $data['option2']);
        $stmt->bindParam(':option3', $data['option3']);
        $stmt->bindParam(':option4', $data['option4']);
        $stmt->bindParam(':option5', $data['option5']);
        $stmt->bindParam(':option6', $data['option6']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM answers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getAll($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM answers ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}