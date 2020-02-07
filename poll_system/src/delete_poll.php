<?php
    require_once "./poll.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    if($_GET) {
        $pollId = isset($_GET['pollID']) ? $_GET['pollID'] : '';
        $poll = new Poll();
        $pollInfo = $poll->deletePollById($pollId);
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../manage_polls.html';
        header('Location: ' . $newUrl);
        return;
    } else {
        http_response_code(400);
        echo 'Invalid request';
    }
?>    