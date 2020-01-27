<?php
    require_once "./task.php";
    $errors = [];

    if($_POST) {
        $title = isset($_POST['task_title']) ? modifyInput($_POST['task_title']) : '';
        $content = isset($_POST['task_req']) ? modifyInput($_POST['task_req']) : '';
        $deadline = isset($_POST['task_deadline']) ? $_POST['task_deadline'] : '';
        $maxpoints = isset($_POST['task_maxpoints']) ? $_POST['task_maxpoints'] : '';
        $weight = isset($_POST['task_weight']) ? $_POST['task_weight'] : '';
        if(!$title || !$content || !$deadline || !$maxpoints || !$weight) {
            $errors[] = 'All fields are required';
        }
        if(mb_strlen($title) > 50) {
            $errors[] = 'The task title must be less than 50 symbols';
        }
        $task = new Task();
        $task->createTask($title, $content, $deadline, intval($maxpoints), intval($weight)); 
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
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../view_tasks.html';
        header('Location: ' . $newUrl);
    }

    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }
?>