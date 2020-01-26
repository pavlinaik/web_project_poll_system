<?php
    require_once "./dbTaskResult.php";
    class TaskResult {
        private $studentId;
        private $taskId;
        private $result;
        private $db;
        
        public function __construct() {
            $this->db = new TaskResultModel();
        }

        public function getId(){
            return $this->id;
        }

        public function getStudentId(){
            return $this->studentId;
        }

        public function getTaskId(){
            return $this->taskId;
        }

        public function getResult(){
            return $this->result;
        }

        public function getResultByStudentAndTask($studentId, $taskId) {
            $result = $this->db->getResult(["studentId" => $studentId, "taskId" => $taskId]);
            $taskResult = $result->fetch(PDO::FETCH_ASSOC);
            if($taskResult) {
                $this->studentId = $taskResult["studentId"];
                $this->taskId = $taskResult["taskId"];
                $this->result = $taskResult["result"];
                return true;
            }
            return false;
        }
        
        public function getAllPointsForStudent($studentId){
            $results = $this->db->getAllResultsForStudent(["studentId" => $studentId]);
            $rows = $results->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }

        public function createTaskResult($studentId, $taskId, $result) {
            $this->db->insertTaskResult(["studentId" => $studentId, "taskId" => $taskId, "result" => $result]);
        }
    }
?>  