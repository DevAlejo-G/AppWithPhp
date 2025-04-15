<?php
  session_start();
  $id=$pww="";
  $id=$_POST['ic1'];
  $pww=$_POST['ic2'];

  $msj="Error";
  $err="";
  require_once 'conectar.php';
  if(isset($_POST['iaceptar'])){
    $sql="select IDUSU, NOMBRE, APELLIDO, CATEGORIA,
    CLAVE, ESTADO from usuario where idusu='$id'";
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      $err=mysqli_error($conexion);
    }else{
      if($row=mysqli_fetch_array($rsql)){
        $cat=$row['CATEGORIA'];
        $nom=$row['NOMBRE']." ".$row['APELLIDO'];
        if($pww == $row['CLAVE']){
          $_SESSION['USUARIO']=$id;
          $_SESSION['CATEGORIA']=$cat;
          $_SESSION['NOMPMA']=$nom;
          header("Location:../HTML/principal.php");
          exit();
        
        }else{
          $msj="Clave Erronea";
        }
      }else{
        $msj="Usuario no Existe";
      }
    }
  }
  header("Location:../HTML/login.php?msj=$msj");
?>