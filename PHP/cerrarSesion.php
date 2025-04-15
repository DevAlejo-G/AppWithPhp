<?php
  session_start();
  session_unset($_SESSION['USUARIO']);
  session_unset($_SESSION['CATEGORIA']);
  session_unset($_SESSION['NOMPMA']);
  session_destroy();
  header("Location:../HTML/index.php");
?>

