<?php
    require_once "./task.php";
    require_once "./user.php";
    session_start();
    if (!isset($_SESSION["username"])){
        $loginPage = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
        header('Location: ' . $loginPage);
        return;
    }
    header("Content-type: application/json");
    $studentClass = new User($_SESSION['username']);
    $students = $studentClass->getAllStudentsFNs();
    $taskClass = new Task();
    $tasks = $taskClass->getAllTasks();
    $response = array();
    $response['students'] = $students;
    $response['tasks'] = $tasks;
    echo json_encode($response);
?>