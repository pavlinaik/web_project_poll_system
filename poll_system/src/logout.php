<?php
session_start();
if($_SESSION['user_id']){
  session_unset();
  session_destroy();
  session_write_close();
  setcookie(session_name(),'',0,'/');
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../login.html';
  header('Location: ' . $home_url);
}
?>