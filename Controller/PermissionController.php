<?php

namespace Controller;

use Database\Database;
use Model\Permission;
use PDO;

class PermissionController
{
    private $model;

    public function __construct(Permission $model) {
        $this->model = $model;
    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO permission (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM permission WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE permission SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM permission WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
