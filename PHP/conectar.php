<?php
  $host="127.0.0.1"; //localhost
  $usu="root";
  $pw="12345678";
  $bd="prestamo";

  $conexion=mysqli_connect($host,$usu,$pw,$bd);
  if(mysqli_connect_errno()){
    echo "Error al conectarse: ".mysqli_connect_error();
  }else{
    //echo "Conexion exitosa!!!";
  }

?>