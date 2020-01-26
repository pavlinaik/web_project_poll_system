<?php
    session_start();
    require_once "./task.php";
    require_once "./user.php";
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