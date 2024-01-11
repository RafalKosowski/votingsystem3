<?php

namespace Database;
use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $conn;

    private $servername = "db4free.net";
    private $username = "piotrekrafal";
    private $password = "zaq1@WSX";
    private $dbname = "votingsystem3";

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // Ustawienia dla PDO, np. obsługa błędów
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

}