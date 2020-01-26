<?php
    require_once "./taskResult.php";
    require_once "./task.php";
    require_once "./user.php";
    session_start();
    $errors = [];

    if($_POST) {
        $taskId = isset($_POST['task']) ? modifyInput($_POST['task']) : '';
        $studentId = isset($_POST['student']) ? modifyInput($_POST['student']) : '';
        $result = isset($_POST['points']) ? $_POST['points'] : '';
        if(!$taskId || !$studentId || !$result) {
            $errors[] = 'All fields are required';
        }
        $taskResult = new TaskResult();
        $taskResult->createTaskResult($studentId, $taskId, $result);
        $task = new Task();
        $task->getTaskById($taskId);
        $maxpoints = $task->getMaxpoints();
        $weight = $task->getWeight();
        $student = new User($_SESSION['user_id']);
        $rating = $student->getStudentRating($studentId);
        $newRating = recalcStudentRating($rating, $result, $maxpoints, $weight);
        $student->updateStudentRating($studentId, $newRating);
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
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../assess_student.html';
        header('Location: ' . $newUrl);
    }

    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }

    function recalcStudentRating($rating, $result, $maxpoints, $weight){
        return $rating - (($maxpoints - $result)/$maxpoints)*($weight/100.0);
    }
?>