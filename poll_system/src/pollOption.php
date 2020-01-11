<?php
    require_once "./dbPollOption.php";
    class PollOption {
        private $id;
        private $pollId;
        private $content;
        private $db;
        
        public function __construct() {
            $this->db = new PollOptionModel();
        }

        public function getId(){
            return $this->id;
        }

        public function getPollId(){
            return $this->pollId;
        }

        public function getContent(){
            return $this->content;
        }

        public function getPollOptionById($id) {
            $result = $this->db->selectPollOptionById(["id" => $id]);
            $poll = $result->fetch(PDO::FETCH_ASSOC);
            if($poll) {
                $this->id = $poll["id"];
                $this->pollId = $poll["pollId"];
                $this->content = $poll["content"];
                return true;
            }
            return false;
        }

        public function createPollOption($pollId, $content) {
            $this->db->insertPollOption(["pollId" => $pollId, "content" => $content]);
        }
    }
?>  