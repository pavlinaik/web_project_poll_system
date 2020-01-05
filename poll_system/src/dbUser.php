<?php
    class UserModel {
        private $connection;
        private $insertUserStatement;
        private $selectUserByUsernameStatement;
        private $selectUserByIdStatement;

        public function __construct() {
            $config = parse_ini_file("../config/config.ini", true);
            $host = $config['db']['host'];
            $dbname = $config['db']['dbname'];
            $user = $config['db']['user'];
            $password = $config['db']['password'];
            $this->init($host, $dbname, $user, $password);
        }

        private function init($host, $dbname, $user, $password) {
            try {
                $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $this->prepareStatements();
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        private function prepareStatements() {
            $sql = "INSERT INTO user(username, email, password, fn, speciality) VALUES(:username, :email, :password, :fn, :speciality)";
            $this->insertUserStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM user WHERE username=:username";
            $this->selectUserByUsernameStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM user WHERE id=:id";
            $this->selectUserByIdStatement = $this->connection->prepare($sql);
        }

        public function insertUser($data) {
            try {
                $this->connection->beginTransaction();
                $this->insertUserStatement->execute($data);
                $this->connection->commit();
            } catch(PDOException $e) {
                $this->connection->rollBack();
                echo "Inserting user failed: " . $e->getMessage();
            }
        }

        public function selectUser($data) {
            try {
                $this->selectUserByUsernameStatement->execute($data);
                return $this->selectUserByUsernameStatement;
            } catch(PDOException $e) {
                echo "Selecting user failed: " . $e->getMessage();
            }
        }

        public function __destruct() {
            $this->connection = null;
        }

    }
?>