<?php
    require_once "./task.php";
    require_once "./taskResult.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
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