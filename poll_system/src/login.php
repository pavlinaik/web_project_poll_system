<?php
    require_once "./user.php";
    session_start();
    $errors = [];
    
    if($_POST) {
        $username = isset($_POST['username']) ? modifyInput($_POST['username']) : '';
        $password = isset($_POST['password']) ? modifyInput($_POST['password']) : '';
        if(!$username || !$password) {
            $errors[] = 'All fields are required';
        } else {
            $user = new User($username);
            if(!$user->isExisting()) {
                $errors[] = 'Invalid username or password';
            } else {
                if(!$user->isPasswordValid($password)) {
                    $errors[] = 'Invalid username or password';
                } else {
                    $_SESSION['username']  = $username;
                    $_SESSION['user_id']  = $user->getId();
                    $_SESSION['role'] = $user->getRole();
                }
            }
        }
    } else {
        http_response_code(400);
        echo 'Invalid request';
    }
    if($errors) {
        http_response_code(401);
        foreach($errors as $value) {
            echo $value . '<br/>';
        }

        session_unset();
        session_destroy();
    } else {
        if($_SESSION['role'] == 0){
            //user is a student
            $student_home = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../active_polls.html';
            header('Location: ' . $student_home);
        }
        else{
            //user is an admin
            $admin_home = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../create_poll.html';
            header('Location: ' . $admin_home);
        }
    }
    
    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }
?>