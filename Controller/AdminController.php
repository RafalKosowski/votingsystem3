<?php

namespace Controller;
use Model\AdminModel;

include "../../Model/AdminModel.php";
include "../../Database/Database.php";


class AdminController
{
    private $adminModel;


    public function showAllUsers()
    {
        
        $adminModel = new AdminModel();
        $users = $adminModel->getAllUsers();
        return $users;


    }

    public function editUser($id)
    {
        $this->checkAdminSession();

    }

    public function deleteUser($id)
    {
        $this->checkAdminSession();
        $this->adminModel->deleteUser($id);
        header("Location: View/admin/admin.php");
        exit;
    }

    public function addVoteType()
    {
        $this->checkAdminSession();
    }

    public function editVoteType($id)
    {
        $this->checkAdminSession();
    }

    public function deleteVoteType($id)
    {
        $this->checkAdminSession();
    }

    public function logoutAdmin()
    {

    }

    private function checkAdminSession()
    {
        if (!isset($_SESSION['admin'])) {
//            header("Location: /");
            exit;
        }
    }
}
