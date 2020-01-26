<?php
    class TaskModel {
        private $connection;
        private $insertTaskStatement;
        private $selectTaskByIdStatement;
        private $selectActiveTasks;
        private $selectAllTasks;

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
            $sql = "INSERT INTO task(title, content, deadline, maxpoints, weight) VALUES(:title, :content, :deadline, :maxpoints, :weight)";
            $this->insertTaskStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM task WHERE taskId=:taskId";
            $this->selectTaskByIdStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM task WHERE status=1";
            $this->selectActiveTasks = $this->connection->prepare($sql);
            $sql = "SELECT * FROM task";
            $this->selectAllTasks = $this->connection->prepare($sql);
        }

        public function insertTask($data) {
            try {
                $this->connection->beginTransaction();
                $this->insertTaskStatement->execute($data);
                $this->connection->commit();
            } catch(PDOException $e) {
                $this->connection->rollBack();
                echo "Inserting task failed: " . $e->getMessage();
            }
        }

        public function selectTaskById($data) {
            try {
                $this->selectTaskByIdStatement->execute($data);
                return $this->selectTaskByIdStatement;
            } catch(PDOException $e) {
                echo "Selecting task failed: " . $e->getMessage();
            }
        }

        public function getActiveTasks() {
            try {
                $this->selectActiveTasks->execute();
                return $this->selectActiveTasks;
            } catch(PDOException $e) {
                echo "Selecting active tasks failed: " . $e->getMessage();
            }
        }

        public function getAllTasks() {
            try {
                $this->selectAllTasks->execute();
                return $this->selectAllTasks;
            } catch(PDOException $e) {
                echo "Selecting all tasks failed: " . $e->getMessage();
            }
        }

        public function __destruct() {
            $this->connection = null;
        }
    }
?>