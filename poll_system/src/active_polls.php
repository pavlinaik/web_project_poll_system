<?php
    require_once "./poll.php";
    require_once "./pollOption.php";
    session_start();
    header("Content-type: application/json");
    $pollClass = new Poll();
    $activePolls = $pollClass->getActivePolls();
    echo json_encode($activePolls);
?>