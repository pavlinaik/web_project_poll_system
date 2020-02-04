<?php
    class UserModel {
        private $connection;
        private $insertUserStatement;
        private $insertUserImport;
        private $selectUserByUsernameStatement;
        private $selectUserByFn;
        private $selectUserByIdStatement;
        private $selectAllStudentsFNs;
        private $updateStudentRating;

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
            $sql = "INSERT INTO user(username, email, password, fn, speciality, rating, role) VALUES(:username, :email, :password, :fn, :speciality, :rating, :role)";
            $this->insertUserImport = $this->connection->prepare($sql);
            $sql = "SELECT * FROM user WHERE username=:username";
            $this->selectUserByUsernameStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM user WHERE id=:id";
            $this->selectUserByIdStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM user WHERE fn=:fn";
            $this->selectUserByFn = $this->connection->prepare($sql);
            $sql = "SELECT id,fn FROM user WHERE role=0";
            $this->selectAllStudentsFNs = $this->connection->prepare($sql);
            $sql = "UPDATE user SET rating=:rating WHERE id=:id";
            $this->updateStudentRating = $this->connection->prepare($sql);
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

        public function importUser($data) {
            try {
                $this->insertUserImport->execute($data);
            } catch(PDOException $e) {
                echo "Importing user failed: " . $e->getMessage();
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

        public function selectUserById($data) {
            try {
                $this->selectUserByIdStatement->execute($data);
                return $this->selectUserByIdStatement;
            } catch(PDOException $e) {
                echo "Selecting user by id failed: " . $e->getMessage();
            }
        }

        public function selectUserByFn($data) {
            try {
                $this->selectUserByFn->execute($data);
                return $this->selectUserByFn;
            } catch(PDOException $e) {
                echo "Selecting user by fn failed: " . $e->getMessage();
            }
        }
        
        public function getAllStudentsFNs() {
            try {
                $this->selectAllStudentsFNs->execute();
                return $this->selectAllStudentsFNs;
            } catch(PDOException $e) {
                echo "Selecting student's fns failed: " . $e->getMessage();
            }
        }

        public function updateStudentRating($data) {
            try {
                $this->updateStudentRating->execute($data);
                return $this->updateStudentRating;
            } catch(PDOException $e) {
                echo "Updating student rating failed: " . $e->getMessage();
            }
        }

        public function __destruct() {
            $this->connection = null;
        }

    }
?>