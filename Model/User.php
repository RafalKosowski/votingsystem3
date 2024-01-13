<?php

namespace Model;

class User
{
    public $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $permission_id; //permission

    /**
     * @param $id
     * @param $login
     * @param $email
     * @param $firstname
     * @param $lastname
     * @param $permission
     */

    public function create($id, $login, $email, $firstname, $lastname, $permission)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->permission_id = $permission;
    }


    public function newUser($id, $login, $password, $email, $firstname, $lastname, $permission)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->permission_id = $permission;
    }




}