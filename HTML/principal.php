<?php
  session_start();
  if(!isset($_SESSION['USUARIO'])){
    header("Location:../index.php");
    exit();
  }
  
  include 'encabezado.php';
  echo "<div class='contenido_completo'>
  </div>";
  include 'pie.html';


?>