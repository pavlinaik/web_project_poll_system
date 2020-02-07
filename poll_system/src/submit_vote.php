<?php
    require_once "./vote.php";
    require_once "./user.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    $errors = [];

    if($_POST) {
        $pollId = isset($_POST['poll']) ? modifyInput($_POST['poll']) : '';
        $optionId = isset($_POST['poll_option']) ? modifyInput($_POST['poll_option']) : '';
        if(!$pollId || !$optionId) {
            $errors[] = 'All fields are required';
        }
        $vote = new Vote();
        $userId = $_SESSION['user_id'];
        if($vote->checkIfStudentAlreadyVote($userId, $pollId)){
            $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../error_page.html';
            header('Location: ' . $newUrl);
            return;
            // header("Content-type: application/json");
            // echo json_encode(["code" => "fail", "cause" => "already vote"]);
            // exit();
        }
        $user = new User($_SESSION['username']);
        $user->isExisting();
        $vote->createVote($pollId, $optionId, $userId, $user->getRating()); 
    } else {
        http_response_code(400);
        echo 'Invalid request';
    }

    if($errors) {
        http_response_code(401);
        foreach($errors as $value) {
            echo $value . '<br/>';
        }
    } else {
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../active_polls.html';
        header('Location: ' . $newUrl);
        return;
    }

    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }
?>