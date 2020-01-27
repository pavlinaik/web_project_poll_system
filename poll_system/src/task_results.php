<?php
    require_once "./task.php";
    require_once "./taskResult.php";
    session_start();
    header("Content-type: application/json");
    $response = array();
    $task = new Task();    
    $allTasks = $task->getAllTasks();
    $taskResult = new TaskResult();
    $results = $taskResult->getAllPointsForStudent($_SESSION['user_id']);
    $response['tasks'] = $allTasks;
    $response['results'] = $results;
    echo json_encode($response);
?>