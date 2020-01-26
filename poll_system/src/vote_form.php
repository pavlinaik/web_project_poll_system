<?php
    require_once "./poll.php";
    header("Content-type: application/json");
    $poll = new Poll();
    $pollData = $poll->getPollWithOptionsById($_POST['pollId']);
    echo json_encode($pollData);
?>