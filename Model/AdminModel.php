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

}