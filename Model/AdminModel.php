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

}