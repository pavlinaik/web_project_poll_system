<?php
    require_once "./poll.php";

    if($_GET) {
        $pollId = isset($_GET['pollID']) ? $_GET['pollID'] : '';
        $poll = new Poll();
        $pollInfo = $poll->deletePollById($pollId);
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../manage_polls.html';
        header('Location: ' . $newUrl);
    } else {
        http_response_code(400);
        echo 'Invalid request';
    }
?>    