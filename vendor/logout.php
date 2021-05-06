<?php 
  session_start();
  unset($_SESSION['user'], $_SESSION['account']);
  header('Location: ../sign-in.php');
?>