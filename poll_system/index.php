<?php
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.html';
  header('Location: ' . $home_url);
?>