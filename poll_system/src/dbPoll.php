<?php
    class PollModel {
        private $connection;
        private $insertPollStatement;
        private $selectPollByIdStatement;

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
            $sql = "INSERT INTO poll(question, expiresAt) VALUES(:question, :expiresAt)";
            $this->insertPollStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM poll WHERE id=:id";
            $this->selectPollByIdStatement = $this->connection->prepare($sql);
        }

        public function insertPoll($data) {
            try {
                $this->connection->beginTransaction();
                $this->insertPollStatement->execute($data);
                $lastId = $this->connection->lastInsertId();
                $this->connection->commit();
                return $lastId;
            } catch(PDOException $e) {
                $this->connection->rollBack();
                echo "Inserting poll failed: " . $e->getMessage();
            }
        }

        public function selectPollById($data) {
            try {
                $this->selectPollByIdStatement->execute($data);
                return $this->selectPollByIdStatement;
            } catch(PDOException $e) {
                echo "Selecting poll failed: " . $e->getMessage();
            }
        }

        public function __destruct() {
            $this->connection = null;
        }
    }
?>