<?php
    require_once "./dbPoll.php";
    require_once "./dbPollOption.php";
    class Poll {
        private $id;
        private $question;
        private $expiresAt;
        private $status;
        private $db;
        private $dbOptions;
        
        public function __construct() {
            $this->db = new PollModel();
            $this->dbOptions = new PollOptionModel();
        }

        public function getId(){
            return $this->id;
        }

        public function getQuestion(){
            return $this->question;
        }

        public function getExpiresAt(){
            return $this->expiresAt;
        }

        public function isActive(){
            return $this->status === 1;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setQuestion($quest){
            $this->question = $quest;
        }

        public function setExpiresAt($date){
            $this->expiresAt = $date;
        }

        public function setStatus($stat){
            $this->status = $stat;
        }

        public function getPollWithOptionsById($id) {
            $pollData = array();
            $result = $this->db->selectPollById(["id" => $id]);
            $poll = $result->fetch(PDO::FETCH_ASSOC);
            $pollData['poll'] = $poll;
            $optionResult = $this->dbOptions->getPollOptionsByPollId(["pollId" => $id]);
            $pollData['options'] = $optionResult->fetchAll(PDO::FETCH_ASSOC);
            return $pollData;
            // if($poll) {
            //     $this->id = $poll["id"];
            //     $this->question = $poll["question"];
            //     $this->expiresAt = $poll["expiresAt"];
            //     $this->status = $poll["status"];
            //     return true;
            // }
            // return false;
        }

        public function createPoll($question, $expiresAt) {
            return $this->db->insertPoll(["question" => $question, "expiresAt" => $expiresAt]);
        }

        public function getActivePolls(){
            $result = $this->db->getActivePolls();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }

        public function getAllPolls(){
            $result = $this->db->getAllPolls();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }

        public function deletePollById($id) {
            return $this->db->deletePollById(["id" => $id]);
        }
    }
?>  