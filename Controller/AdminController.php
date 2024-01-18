<?php

namespace Controller;
use Model\AdminModel;
class AdminController
{
    private $adminModel;


    public function showAllUsers()
    {
        $this->checkAdminSession();
        $adminModel = new AdminModel();
        $users = $this->$adminModel->getAllUsers();


    }

    public function editUser($id)
    {
        $this->checkAdminSession();
    }

    public function deleteUser($id)
    {
        $this->checkAdminSession();
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
            header("Location:/");
            exit;
        }
    }
}
