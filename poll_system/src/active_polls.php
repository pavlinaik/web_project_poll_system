<?php
    require_once "./poll.php";
    require_once "./pollOption.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    header("Content-type: application/json");
    $pollClass = new Poll();
    $activePolls = $pollClass->getActivePolls();
    echo json_encode($activePolls);
?>