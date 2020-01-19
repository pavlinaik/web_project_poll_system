<?php
    class PollOptionModel {
        private $connection;
        private $insertPollOptionStatement;
        private $selectPollOptionByIdStatement;
        private $selectPollOptionsByPollId;

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
            $sql = "INSERT INTO polloption(pollId, content) VALUES(:pollId, :content)";
            $this->insertPollOptionStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM polloption WHERE id=:id";
            $this->selectPollOptionByIdStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM polloption WHERE pollId=:pollId";
            $this->selectPollOptionsByPollId = $this->connection->prepare($sql);
        }

        public function insertPollOption($data) {
            try {
                $this->connection->beginTransaction();
                $this->insertPollOptionStatement->execute($data);
                $this->connection->commit();
            } catch(PDOException $e) {
                $this->connection->rollBack();
                echo "Inserting poll option failed: " . $e->getMessage();
            }
        }

        public function selectPollOptionById($data) {
            try {
                $this->selectPollOptionByIdStatement->execute($data);
                return $this->selectPollOptionByIdStatement;
            } catch(PDOException $e) {
                echo "Selecting poll option failed: " . $e->getMessage();
            }
        }

        public function getPollOptionsByPollId($data){
            try {
                $this->selectPollOptionsByPollId->execute($data);
                return $this->selectPollOptionsByPollId;
            } catch(PDOException $e) {
                echo "Selecting poll option by pollId failed: " . $e->getMessage();
            }
        }

        public function __destruct() {
            $this->connection = null;
        }
    }
?>