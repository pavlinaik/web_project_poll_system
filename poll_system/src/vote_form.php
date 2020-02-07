<?php
    require_once "./poll.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    header("Content-type: application/json");
    $poll = new Poll();
    $pollData = $poll->getPollWithOptionsById($_POST['pollId']);
    echo json_encode($pollData);
?>