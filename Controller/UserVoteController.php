<?php

namespace Controller;

use Database\Database;
use Model\UserVote;
use PDO;
use PDOException;

class UserVoteController
{
//    private $model;
//
//    public function __construct(UserVote $model) {
//        $this->model = $model;
//    }

    public function create($userId, $voteId, $selectedAnswer) {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("INSERT INTO user_vote (user_id, vote_id, selected_answer) VALUES (:user_id, :vote_id, :selected_answer)");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':vote_id', $voteId);
            $stmt->bindParam(':selected_answer', $selectedAnswer);
            $stmt->execute();
            return true; // Return true on success
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            echo($e->getMessage());
            return false; // Return false on failure
        }
    }

    public function read($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user_vote WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("UPDATE user_vote SET user_id = COALESCE(:user_id, user_id), selected_answer = :selected_answer WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':selected_answer', $data['selected_answer']);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            return false; // Return false on failure
        }
    }
    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM user_vote WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function countVotesByVoteId($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user_vote WHERE user_vote.vote_id = :vote_id");
        $stmt->bindParam(':vote_id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function readByUserAndVote($userId, $voteId) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM user_vote WHERE user_id = :user_id AND vote_id = :vote_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':vote_id', $voteId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function countAndGroupBySelectedAnswer($vote_id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT selected_answer,COUNT(id) as 'liczba' FROM user_vote Where vote_id=:vote_id GROUP BY selected_answer;");
        $stmt->bindParam(':vote_id', $vote_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // TO REPAIR
    public function countVoteWithVoteId($vote_id)
    {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("SELECT * FROM user_vote WHERE vote_id = :vote_id");
            $stmt->bindParam(':vote_id', $vote_id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Wystąpił problem przy liczeniu'.$e;
            return null;

        }
    }
}