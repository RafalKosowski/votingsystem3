<?php

namespace Controller;

use Database\Database;
use Model\Quorum;
use PDO;

class QuorumController
{
//    private $model;
//
//    public function __construct(Quorum $model) {
//        $this->model = $model;
//    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO quorum (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM quorum WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE quorum SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM quorum WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getAll() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM quorum");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}