<?php
    require_once "./dbVote.php";
    class Vote {
        private $id;
        private $pollId;
        private $optionId;
        private $userId;
        private $db;
        
        public function __construct() {
            $this->db = new VoteModel();
        }

        public function getId(){
            return $this->id;
        }

        public function getUserId(){
            return $this->userId;
        }

        public function getPollId(){
            return $this->pollId;
        }

        public function getOptionId(){
            return $this->optionId;
        }

        public function getVotesForPollOption($pollId, $optionId) {
            $result = $this->db->getAllVotesForPollOption(["pollId" => $pollId, "optionId" => $optionId]);
            $optionVotes= $result->fetchAll(PDO::FETCH_ASSOC);
            return $optionVotes;
        }
        public function checkIfStudentAlreadyVote ($userId, $pollId){
            $result = $this->db->getVoteOfStudentForPoll(["pollId" => $pollId, "userId" => $userId]);
            $vote= $result->fetch(PDO::FETCH_ASSOC);
            if($vote){
                return true;
            }
            else{
                return false;
            }
        }
        public function createVote($pollId, $optionId, $userId, $rating) {
            $this->db->insertVote(["pollId" => $pollId, "optionId" => $optionId, "userId" => $userId, "rating" => $rating]);
        }
    }
?>  