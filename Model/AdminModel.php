<?php
namespace Model;

use Database\Database;
use PDO;

class AdminModel
{
    public function getAllUsers()
    {
        $query = "SELECT user.id, user.login, user.password, user.email, user.firstname, user.lastname, permission.name as permission_name
              FROM user
              JOIN permission ON user.permission_id = permission.id";
        // $query="SELECT*FROM user";
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM user_vote WHERE user_id = :id";
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $query = "DELETE FROM user WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function editUser($userId, $editedFirstName, $editedLastName, $editedPermission)
    {
        $query = "UPDATE user
                  SET firstname = :firstname, lastname = :lastname, permission_id = :permission_id
                  WHERE id = :id";

        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':firstname', $editedFirstName, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $editedLastName, PDO::PARAM_STR);
        $statement->bindParam(':permission_id', $editedPermission, PDO::PARAM_INT);
        $statement->execute();
    }

    public function getUserById($id)
    {
        $query = "SELECT id, login, password, email, firstname, lastname, permission_id
              FROM user
              WHERE id = :id";

        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function getVotes()
    {
        $query = "SELECT uv.*, v.name AS vote_name, v.startdate, v.enddate, v.question, a.*, vt.name AS vote_type,
        u.login AS user_login
 FROM user_vote uv
 JOIN vote v ON uv.vote_id = v.id
 JOIN answers a ON uv.selected_answer = a.id
 JOIN vote_type vt ON v.vote_type_id = vt.id
 JOIN user u ON uv.user_id = u.id;
";


        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->execute();

        $votes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $votes;
    }
    public function getVotesName()
    {
        $query = "SELECT v.id AS vote_id, v.name AS vote_name, vt.name AS vote_type 
        FROM vote v
        JOIN vote_type vt ON v.vote_type_id = vt.id;";

        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->execute();

        $voteTypes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $voteTypes;
    }
    public function deleteVoteName($vote_id)
    {
        $pdo = Database::getInstance()->getConnection();

        $query = "DELETE FROM user_vote WHERE vote_id = :vote_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':vote_id', $vote_id, PDO::PARAM_INT);
        $statement->execute();

        $query = "DELETE FROM vote WHERE id = :vote_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':vote_id', $vote_id, PDO::PARAM_INT);
        $statement->execute();
    }


    public function getVoteById($id)
    {
        $query = "SELECT v.id AS vote_id, v.name AS vote_name, vt.name AS vote_type 
    FROM vote v
    JOIN vote_type vt ON v.vote_type_id = vt.id WHERE v.id=:id";
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $voted = $statement->fetch(PDO::FETCH_ASSOC);

        return $voted;
    }
    public function editVoteType($vote_id, $editedVoteName)
    {
        $query = "UPDATE vote SET name = :editedVoteName WHERE id = :vote_id";
        
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare($query);
        $statement->bindParam(':editedVoteName', $editedVoteName, PDO::PARAM_STR);
        $statement->bindParam(':vote_id', $vote_id, PDO::PARAM_INT);
        $statement->execute();
    }
    
}
