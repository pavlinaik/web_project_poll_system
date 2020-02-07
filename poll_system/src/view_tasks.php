<?php
    require_once "./task.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    header("Content-type: application/json");
    $task = new Task();    
    $activeTasks = $task->getAllTasks();
    echo json_encode($activeTasks);
?>