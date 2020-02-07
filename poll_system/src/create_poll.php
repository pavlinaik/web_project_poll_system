<?php
    require_once "./poll.php";
    require_once "./pollOption.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    $errors = [];
    if($_POST) {
        $question = isset($_POST['poll_question']) ? modifyInput($_POST['poll_question']) : '';
        $options = isset($_POST['possible_answers']) ? modifyInput($_POST['possible_answers']) : '';
        $expiresAt = isset($_POST['expires_date']) ? $_POST['expires_date'] : '';
        if(!$question || !$options || !$expiresAt) {
            $errors[] = 'All fields are required';
        }
        $poll = new Poll();
        $pollId = $poll->createPoll($question, $expiresAt); 
        $optionsArray = explode("\n", $options);
        foreach($optionsArray as $opt){
            $pollOpt = new PollOption();
            $pollOpt->createPollOption($pollId, $opt);
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
    } else {
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../manage_polls.html';
        header('Location: ' . $newUrl);
    }

    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }
?>