<?php
    class TaskResultModel {
        private $connection;
        private $insertTaskResultStatement;
        private $selectAllResultsForTasks;
        private $selectAllResultsForStudent;
        private $selectResult;

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
            $sql = "INSERT INTO taskresult(studentId, taskId, result) VALUES(:studentId, :taskId, :result)";
            $this->insertTaskResultStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM taskresult WHERE taskId=:taskId";
            $this->selectAllResultsForTasks = $this->connection->prepare($sql);
            // $sql = "SELECT result, maxpoints, weight FROM taskresult 
            //         join task on taskresult.taskId = task.taskId
            //         where studentId = :studentId";
            $sql = "SELECT taskId, result FROM taskresult WHERE studentId = :studentId";
            $this->selectAllResultsForStudent = $this->connection->prepare($sql);
            $sql = "SELECT * FROM taskresult WHERE taskId=:taskId AND studentId=:studentId";
            $this->selectResult =  $this->connection->prepare($sql);
        }

        public function insertTaskResult($data) {
            try {
                $this->insertTaskResultStatement->execute($data);
            } catch(PDOException $e) {
                echo "Inserting task result failed: " . $e->getMessage();
            }
        }

        public function getAllResultsForTask($data) {
            try {
                $this->selectAllResultsForTasks->execute($data);
                return $this->selectAllResultsForTasks;
            } catch(PDOException $e) {
                echo "Selecting all results for task failed: " . $e->getMessage();
            }
        }

        public function getAllResultsForStudent($data){
            try {
                $this->selectAllResultsForStudent->execute($data);
                return $this->selectAllResultsForStudent;
            } catch(PDOException $e) {
                echo "Selecting all results for student failed: " . $e->getMessage();
            }
        }

        public function getResult($data){
            try {
                $this->selectResult->execute($data);
                return $this->selectResult;
            } catch(PDOException $e) {
                echo "Selecting all results for student failed: " . $e->getMessage();
            }
        }

        public function __destruct() {
            $this->connection = null;
        }
    }
?>