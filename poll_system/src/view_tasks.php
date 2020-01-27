<?php
    require_once "./task.php";
    session_start();
    header("Content-type: application/json");
    $task = new Task();    
    $activeTasks = $task->getAllTasks();
    echo json_encode($activeTasks);
?>