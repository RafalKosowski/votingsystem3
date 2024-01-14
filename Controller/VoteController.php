<?php

namespace Controller;

use Database\Database;
use Model\Vote;
use PDO;
use PDOException;

class VoteController
{
   // private $model;

//    public function __construct(Vote $model) {
//        $this->model = $model;
//    }

    public function create($data) {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("INSERT INTO vote (name, startdate, enddate, question, answers_id, quorum_id, vote_type_id, majority_id) VALUES (:name, :startdate, :enddate, :question, :answers_id, :quorum_id, :vote_type_id, :majority_id)");

            // Validate input data here if needed

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':startdate', $data['startdate']);
            $stmt->bindParam(':enddate', $data['enddate']);
            $stmt->bindParam(':question', $data['question']);
            $stmt->bindParam(':answers_id', $data['answers_id']);
            $stmt->bindParam(':quorum_id', $data['quorum_id']);
            $stmt->bindParam(':vote_type_id', $data['vote_type_id']);
            $stmt->bindParam(':majority_id', $data['major_id']);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while creating a vote. Please try again later.");
        }
    }

    public function read($id) {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("SELECT * FROM vote WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving vote information. Please try again later.");
        }
    }

    public function update($id, $data) {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("UPDATE vote SET name = :name, startdate = :startdate, enddate = :enddate, question = :question, answers_id = :answers_id, quorum_id = :quorum_id, vote_type_id = :vote_type_id, majority_id = :majority_id WHERE id = :id");

            // Validate input data here if needed

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
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while updating the vote. Please try again later.");
        }
    }

    public function delete($id) {
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("DELETE FROM vote WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while deleting the vote. Please try again later.");
        }
    }

    public function getActiveVotes() {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT * FROM vote WHERE startdate <= CONVERT_TZ(NOW(), 'SYSTEM', 'Europe/Warsaw') AND enddate > NOW()");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving active votes. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }
    public function getAllVotes() {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT * FROM vote WHERE startdate <= CONVERT_TZ(NOW(), 'SYSTEM', 'Europe/Warsaw') AND enddate > NOW()");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving active votes. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }

    public function getCompletedVotes() {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT * FROM vote WHERE enddate <= NOW()");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving completed votes. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }

    public function getUpcomingVotes() {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT * FROM vote WHERE startdate > NOW()");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving upcoming votes. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }
    public function getActiveVotesForUser($userId) {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT v.* FROM vote v 
                              INNER JOIN user_vote uv ON v.id = uv.vote_id 
                              WHERE v.startdate <= NOW() AND v.enddate > NOW() AND uv.user_id = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving active votes for the user. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }

    public function getCompletedVotesForUser($userId) {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT v.* FROM vote v 
                              INNER JOIN user_vote uv ON v.id = uv.vote_id 
                              WHERE v.enddate <= NOW() AND uv.user_id = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving completed votes for the user. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }
    public function getUpcomingVotesForUser($userId) {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT v.* FROM vote v 
                              INNER JOIN user_vote uv ON v.id = uv.vote_id 
                              WHERE v.startdate > NOW() AND uv.user_id = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while retrieving upcoming votes for the user. Please try again later.");
            return []; // Return an empty array or false, depending on your error handling strategy.
        }
    }

    public function getVoteStatus($voteId) {
        try {
            $pdo = Database::getInstance()->getConnection();

            $stmt = $pdo->prepare("SELECT id, startdate, enddate FROM vote WHERE id = :voteId");
            $stmt->bindParam(':voteId', $voteId);
            $stmt->execute();

            $vote = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$vote) {
                // Vote not found
                return 'Not Found';
            }

            $currentDate = date('Y-m-d H:i:s');

            if ($currentDate < $vote['startdate']) {
                return 'Upcoming'; // Vote hasn't started yet
            } elseif ($currentDate >= $vote['startdate'] && $currentDate <= $vote['enddate']) {
                return 'Active'; // Vote is currently active
            } else {
                return 'Completed'; // Vote has ended
            }
        } catch (PDOException $e) {
            // Handle the exception (log, display error, etc.)
            // For example:
            // logError($e->getMessage());
            // displayErrorMessage("An error occurred while checking the status of the vote. Please try again later.");
            return 'Error'; // Return an error status, depending on your error handling strategy.
        }
    }

    public function showVotes($votes)
    {
        if (empty($votes)) {
            echo '<p>No votes available.</p>';
        } else {
            echo '<ul>';
            foreach ($votes as $vote) {
                echo '<li>';
                echo '<a href="/votingsystem3/View/user/vote_details.php?id=' . $vote['id'] . '">' . $vote['name'] . '</a>';

                echo '</li>';
            }
            echo '</ul>';
        }
    }

}
