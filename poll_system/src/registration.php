<?php
    require_once "./user.php";
    session_start();
    $errors = [];

    if($_POST) {
        $username = isset($_POST['username']) ? modifyInput($_POST['username']) : '';
        $email = isset($_POST['email']) ? modifyInput($_POST['email']) : '';
        $password = isset($_POST['password']) ? modifyInput($_POST['password']) : '';
        $confirmPassword = isset($_POST['confirm_password']) ? modifyInput($_POST['confirm_password']) : '';
        $fn = isset($_POST['fn']) ? modifyInput($_POST['fn']) : '';
        $spec = isset($_POST['spec']) ? modifyInput($_POST['spec']) : '';
        if(!$username || !$email || !$password || !$confirmPassword || !$fn) {
            $errors[] = 'All fields except speciality are required';
        }
        if(mb_strlen($username) > 45) {
            $errors[] = 'The username must be less than 45 symbols';
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter valid email';
        }
        if($password !== $confirmPassword) {
            $errors[] = 'Passwords must match';
        }
        if(mb_strlen($fn) > 10){
            $errors[] = 'The faculty number must be less than 10 symbols';
        }
        if(mb_strlen($spec) > 45){
            $errors[] = 'The speciality must be less than 45 symbols';
        }
        if(empty($spec)){
            $spec = "NULL";
        }
        $user = new User($username);
        if($user->isExisting()) {
            $errors[] = 'Username is already taken';
        } else {
            $user->createUser($email, $password, $fn, $spec);
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
        $login = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $login);
        return;
    }

    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }
?>