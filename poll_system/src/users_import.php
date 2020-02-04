<?php
    require_once "./user.php";
    session_start();
    $errors = [];
    $xml=simplexml_load_file("../imports/usersDump.xml") or die("Error: Cannot create object");
    foreach($xml->children() as $userRecord) {
        $user = new User($userRecord->username);
        if($user->isExisting()) {
            $errors[] = 'Username is already taken';
        } else {
            $user->importUser($userRecord->email, $userRecord->password, $userRecord->fn, $userRecord->speciality, $userRecord->rating, $userRecord->role);
        }
    }
    if($errors) {
        http_response_code(401);
        foreach($errors as $value) {
            echo $value . '<br/>';
        }
        session_unset();
        session_destroy();
    }
?>