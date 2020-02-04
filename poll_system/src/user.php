<?php
    require_once "./dbUser.php";
    class User {
        private $id;
        private $username;
        private $email;
        private $password;
        private $fn;
        private $speciality;
        private $rating;
        private $role;
        private $db;
        
        public function __construct($username) {
            $this->db = new UserModel();
            $this->username = $username;
        }

        public function getId(){
            return $this->id;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getFn(){
            return $this->fn;
        }

        public function getSpeciality(){
            return $this->speciality;
        }

        public function getRating(){
            return $this->rating;
        }

        public function getRole(){
            return $this->role;
        }

        public function isExisting() {
            $result = $this->db->selectUser(["username" => $this->username]);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if($user) {
                $this->id = $user["id"];
                $this->email = $user["email"];
                $this->password = $user["password"];
                $this->fn = $user["fn"];
                $this->speciality = $user["speciality"];
                $this->rating = $user["rating"];
                $this->role = $user["role"];
                return true;
            }
            return false;
        }

        public function isPasswordValid($password) {
            return password_verify($password, $this->password);
        }

        public function createUser($email, $password, $fn, $speciality) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->insertUser(["username" => $this->username, "email" => $email, "password" => $hash, "fn" => $fn, "speciality" => $speciality]);
            $this->email = $email;
            $this->password = $hash;
        }

        public function importUser($email, $password, $fn, $speciality, $rating, $role) {
            $this->db->importUser(["username" => $this->username, "email" => $email, "password" => $password, "fn" => $fn, "speciality" => $speciality, "rating" => $rating, "role" => $role]);
        }

        public function getStudentByFn($fn){
            $result = $this->db->selectUserByFn(["fn" => $fn]);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            return $user;
        }

        public function getAllStudentsFNs()
        {
            $result = $this->db->getAllStudentsFNs();
            $students = $result->fetchAll(PDO::FETCH_ASSOC);
            return $students;
        }
        
        public function getStudentRating($studentId){
            $result = $this->db->selectUserById(["id" => $studentId]);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            return $user["rating"];
        }

        public function updateStudentRating($studentId, $rating) {
            $this->db->updateStudentRating(["id" => $studentId, "rating" => $rating]);
        }
    }
?>  