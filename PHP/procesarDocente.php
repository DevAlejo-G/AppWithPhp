<?php
  $cod=$_POST['ic1'];
  $nom=$_POST['ic2'];
  $apell=$_POST['ic3'];
  $msj="";

  $sql="INSERT INTO DOCENTE (IDCLIENTE, NOMBRE, APELLIDO, ESTADO)
    VALUES ('$cod','$nom','$apell', 'ACTIVO')";


  require_once 'conectar.php';

  if(isset($_GET['pk1'])){
    $id=$_GET['pk1'];
    $sql="DELETE FROM DOCENTE WHERE IDCLIENTE='$id'";
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      $msj="Error eliminado ".mysqli_error($conexion);
    }
  }
  if(isset($_POST['iguardar'])){
    $sql="SELECT * FROM DOCENTE WHERE IDCLIENTE='$cod'";
    $result=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      $msj= "Error: ".mysqli_error($conexion);
  }elseif(mysqli_num_rows($result)>0){
    $sql="UPDATE DOCENTE SET NOMBRE='$nom', APELLIDO='$apell',
    ESTADO='ACTIVO' WHERE IDCLIENTE='$cod'";
  }else{
    $sql="INSERT INTO DOCENTE (IDCLIENTE, NOMBRE, APELLIDO, ESTADO)
    VALUES ('$cod','$nom','$apell', 'ACTIVO')";
  }

  $result=mysqli_query($conexion,$sql);
  if(mysqli_errno($conexion)){
    $msj= "Error: ".mysqli_error($conexion);

  }else{
    $msj="Guardado correctamente..";
  }
}
header("location:../HTML/registrarDocente.php?msj=$msj");
?>