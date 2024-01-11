<?php

namespace Controller;

use Database\Database;
use Model\UserVote;
use PDO;

class UserVoteController
{
    private $model;

    public function __construct(UserVote $model) {
        $this->model = $model;
    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO user_vote (user_id, vote_id, selected_answer) VALUES (:user_id, :vote_id, :selected_answer)");
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':vote_id', $data['vote_id']);
        $stmt->bindParam(':selected_answer', $data['selected_answer']);
        $stmt->execute();
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user_vote WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE user_vote SET user_id = :user_id, vote_id = :vote_id, selected_answer = :selected_answer WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':vote_id', $data['vote_id']);
        $stmt->bindParam(':selected_answer', $data['selected_answer']);
        $stmt->execute();
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM user_vote WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}