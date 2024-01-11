<?php

namespace Controller;
use Database\Database;
use Model\Majority;
use PDO;

class MajorityController
{
    private $model;

    public function __construct(Majority $model) {
        $this->model = $model;
    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO majority (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM majority WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE majority SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM majority WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}