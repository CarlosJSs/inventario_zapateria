<?php
  session_start();
  unset($_SESSION['usuario']);
  unset($_SESSION['user_name']);
  header("Location: login.php");
  exit();
?>