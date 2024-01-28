<?php

namespace Controller;

use Model\AdminModel;

include "../../Model/AdminModel.php";
include "../../Database/Database.php";

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function showAllUsers()
    {
        $users = $this->adminModel->getAllUsers();
        return $users;
    }
    public function getUserById($id)
    {
        $this->checkAdminSession();
        $user = $this->adminModel->getUserById($id);
        if (!$user) {
            echo "User not found!";
            exit;
        }
        return $user;
    }

    public function getVoteById($id){
        $this->checkAdminSession();
        $voted = $this->adminModel->getVoteById($id);
        if (!$voted) {
            echo "User not found!";
            exit;
        }
        return $voted;
    }
    public function editUser($userId, $editedFirstName, $editedLastName, $editedPermission)
    {
        $this->checkAdminSession();

        $this->adminModel->editUser($userId, $editedFirstName, $editedLastName, $editedPermission);

        header("Location: /View/admin/admin.php");
        exit;
    }

    public function deleteUser($id)
    {
        $this->checkAdminSession();
        $this->adminModel->deleteUser($id);
        header("Location: /View/admin/admin.php");
        exit;
    }
    public function getVotes()
    {
        $this->checkAdminSession();
        $votes = $this->adminModel->getVotes();
        return $votes;
    }

    public function getVotesNames()
    {
        $this->checkAdminSession();
        $voteTypes = $this->adminModel->getVotesName();
        return $voteTypes;
    }


    public function editVoteType($vote_id,$editedVoteName)
    {
        $this->checkAdminSession();
        
        $this->adminModel->editVoteType($vote_id, $editedVoteName);

        header("Location: /View/admin/admin.php");
        exit;

    }

    public function deleteVoteName($vote_id)
    {
        $this->checkAdminSession();
        $this->adminModel->deleteVoteName($vote_id);
        header("Location: /View/admin/admin.php");
        exit;

    }

    public function logoutAdmin()
    {
        $_SESSION = array();
        session_destroy();
        header("Location: /");
        exit;
    }

    private function checkAdminSession()
    {

    }
}
?>