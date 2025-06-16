<?php

require_once "config.php";

class Db {
    private $conn;
    private $dbname = DB_NAME;
    private $dbhost = DB_HOST;
    private $dbuser = DB_USER;
    private $dbpass = DB_PASS;

    // Connect to the database
    public function connect() {
        $dsn = "mysql:host=".$this->dbhost.";dbname=".$this->dbname.";charset=utf8mb4";
        $settings = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            $this->conn = new PDO($dsn, $this->dbuser, $this->dbpass, $settings);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            return false;
        }
    }
}
?>