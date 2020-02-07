<?php
    require_once "./taskResult.php";
    require_once "./task.php";
    require_once "./user.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    $errors = [];

    $xml=simplexml_load_file("../imports/gradesDump.xml") or die("Error: Cannot create object");
    foreach($xml->children() as $gradesRecord) {
        $task = new Task();
        $task = $task->getTaskByTitle($gradesRecord->task);
        if(empty($task)){
            return;
        }
        $maxpoints = $task['maxpoints'];
        $user = new User($_SESSION['user_id']);
        $student = $user->getStudentByFn($gradesRecord->fn);
        if(empty($student)){
            return;
        }
        if($gradesRecord->points > $maxpoints){
            $errors[] = 'Maxpoints are exceed';
        }
        $taskResult = new TaskResult();
        $taskResult->createTaskResult($student['id'], $task['taskId'], $gradesRecord->points);
        $weight = $task['weight'];
        $rating = $user->getStudentRating($student['id']);
        $newRating = recalcStudentRating($rating, $gradesRecord->points, $maxpoints, $weight);
        $user->updateStudentRating($student['id'], $newRating);
    }
    if($errors) {
        http_response_code(401);
        foreach($errors as $value) {
            echo $value . '<br/>';
        }
        session_unset();
        session_destroy();
    }

    function recalcStudentRating($rating, $result, $maxpoints, $weight){
        return $rating - (($maxpoints - $result)/$maxpoints)*($weight/100.0);
    }
?>