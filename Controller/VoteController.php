<?php

namespace Controller;

use Database\Database;
use Model\Vote;
use PDO;

class VoteController
{
    private $model;

    public function __construct(Vote $model) {
        $this->model = $model;
    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO vote (name, startdate, enddate, question, answers_id, quorum_id, vote_type_id, majority_id) VALUES (:name, :startdate, :enddate, :question, :answers_id, :quorum_id, :vote_type_id, :majority_id)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':startdate', $data['startdate']);
        $stmt->bindParam(':enddate', $data['enddate']);
        $stmt->bindParam(':question', $data['question']);
        $stmt->bindParam(':answers_id', $data['answers_id']);
        $stmt->bindParam(':quorum_id', $data['quorum_id']);
        $stmt->bindParam(':vote_type_id', $data['vote_type_id']);
        $stmt->bindParam(':majority_id', $data['majority_id']);
        $stmt->execute();
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM vote WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE vote SET name = :name, startdate = :startdate, enddate = :enddate, question = :question, answers_id = :answers_id, quorum_id = :quorum_id, vote_type_id = :vote_type_id, majority_id = :majority_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':startdate', $data['startdate']);
        $stmt->bindParam(':enddate', $data['enddate']);
        $stmt->bindParam(':question', $data['question']);
        $stmt->bindParam(':answers_id', $data['answers_id']);
        $stmt->bindParam(':quorum_id', $data['quorum_id']);
        $stmt->bindParam(':vote_type_id', $data['vote_type_id']);
        $stmt->bindParam(':majority_id', $data['majority_id']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM vote WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}