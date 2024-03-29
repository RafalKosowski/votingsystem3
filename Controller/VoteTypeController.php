<?php

namespace Controller;
use Database\Database;
use Model\VoteType;
use PDO;

class VoteTypeController
{
//    private $model;
//
//    public function __construct(VoteType $model) {
//        $this->model = $model;
//    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO vote_type (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM vote_type WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAll() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM vote_type");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE vote_type SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM vote_type WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}