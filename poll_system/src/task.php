<?php
    require_once "./dbTask.php";
    class Task {
        private $id;
        private $title;
        private $content;
        private $deadline;
        private $maxpoints;
        private $weight;
        private $status;
        private $db;
        
        public function __construct() {
            $this->db = new TaskModel();
        }

        public function getId(){
            return $this->id;
        }

        public function getTitle(){
            return $this->title;
        }

        public function getContent(){
            return $this->content;
        }

        public function getDeadline(){
            return $this->deadline;
        }

        public function getMaxpoints(){
            return $this->maxpoints;
        }

        public function getWeight(){
            return $this->weight;
        }

        public function isActive(){
            return $this->status === 1;
        }

        public function getTaskById($id) {
            $result = $this->db->selectTaskById(["taskId" => $id]);
            $task = $result->fetch(PDO::FETCH_ASSOC);
            if($task) {
                $this->id = $task["taskId"];
                $this->title = $task["title"];
                $this->content = $task["content"];
                $this->deadline = $task["deadline"];
                $this->maxpoints = $task["maxpoints"];
                $this->weight = $task["weight"];
                $this->status = $task["status"];
                return true;
            }
            return false;
        }

        public function getTaskByTitle($title) {
            $result = $this->db->selectTaskByTitle(["title" => $title]);
            $task = $result->fetch(PDO::FETCH_ASSOC);
            if($task) {
                return $task;
            }
            return false;
        }

        public function getActiveTasks(){
            $result = $this->db->getActiveTasks();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }

        public function getAllTasks(){
            $result = $this->db->getAllTasks();
            $tasks = $result->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        }

        public function createTask($title, $content, $deadline, $maxpoints, $weight) {
            $this->db->insertTask(["title" => $title, "content" => $content, "deadline" => $deadline, "maxpoints" => $maxpoints, "weight" => $weight]);
        }
    }
?>  