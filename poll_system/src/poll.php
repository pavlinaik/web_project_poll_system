<?php
    require_once "./dbPoll.php";
    class Poll {
        private $id;
        private $question;
        private $expiresAt;
        private $status;
        private $db;
        
        public function __construct() {
            $this->db = new PollModel();
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

        public function getPollById($id) {
            $result = $this->db->selectPollById(["id" => $id]);
            $poll = $result->fetch(PDO::FETCH_ASSOC);
            if($poll) {
                $this->id = $poll["id"];
                $this->question = $poll["question"];
                $this->expiresAt = $poll["expiresAt"];
                $this->status = $poll["status"];
                return true;
            }
            return false;
        }

        public function createPoll($question, $expiresAt) {
            return $this->db->insertPoll(["question" => $question, "expiresAt" => $expiresAt]);
        }
    }
?>  