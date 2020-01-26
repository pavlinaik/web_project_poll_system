<?php
    class VoteModel {
        private $connection;
        private $insertVoteStatement;
        private $selectVotesForPoll;
        private $selectVotesForPollOption;
        private $selectVoteOfStudentForPoll;

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
            $sql = "INSERT INTO vote(pollId, optionId, userId, rating) VALUES(:pollId, :optionId, :userId, :rating)";
            $this->insertVoteStatement = $this->connection->prepare($sql);
            $sql = "SELECT * FROM vote WHERE pollId=:pollId";
            $this->selectVotesForPoll = $this->connection->prepare($sql);
            $sql = "SELECT * FROM vote WHERE pollId=:pollId AND optionId=:optionId";
            $this->selectVotesForPollOption = $this->connection->prepare($sql);
            $sql = "SELECT * FROM vote WHERE pollId=:pollId AND userId=:userId";
            $this->selectVoteOfStudentForPoll = $this->connection->prepare($sql);
        }

        public function insertVote($data) {
            try {
                $this->insertVoteStatement->execute($data);
            } catch(PDOException $e) {
                echo "Inserting vote failed: " . $e->getMessage();
            }
        }

        public function getAllVotesForPoll($data) {
            try {
                $this->selectVotesForPoll->execute($data);
                return $this->selectVotesForPoll;
            } catch(PDOException $e) {
                echo "Selecting all votes for poll failed: " . $e->getMessage();
            }
        }

        public function getAllVotesForPollOption($data){
            try {
                $this->selectVotesForPollOption->execute($data);
                return $this->selectVotesForPollOption;
            } catch(PDOException $e) {
                echo "Selecting all votes for poll option failed: " . $e->getMessage();
            }
        }
        
        public function getVoteOfStudentForPoll($data){
            try {
                $this->selectVoteOfStudentForPoll->execute($data);
                return $this->selectVoteOfStudentForPoll;
            } catch(PDOException $e) {
                echo "Selecting vote of student for poll failed: " . $e->getMessage();
            }
        }
        public function __destruct() {
            $this->connection = null;
        }
    }
?>