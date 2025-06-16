<?php

require_once "config.php";
    class Db{
        private $conn;
        private $dbname = DB_NAME;
        private $dbhost = DB_HOST;
        private $dbuser = DB_USER;
        private $dbpass = DB_PASS;
        // this method connect to the database, any class that needs access to database can extend this class and use this method
        public function connect(){
            $dsn = "mysql:dbhost=".$this->dbhost.";dbname=" .$this->dbname;
            $settings = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            try{
                $this->conn = new PDO($dsn, $this->dbuser, $this->dbpass , $settings);//create connection
                return $this->conn;//returning connection
            }catch(PDOException $e){
                // echo $e->getMessage();
                return false;
            }
        }
    }
    $db1 = new Db;
    $connection = $db1->connect();
    // var_dump($connection);
?>