<?php
  session_start();
  if(!isset($_SESSION['user']) or !isset($_SESSION['senha'])) {
    header("location: formLogin.php");
    die;
  }
?>