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

        public function isExisting() {
            $result = $this->db->selectUser([":username" => $this->username]);
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
    }
?>  