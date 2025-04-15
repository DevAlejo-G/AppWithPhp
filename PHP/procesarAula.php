<?php
  $cod=$_POST['ic1'];
  $dcs=$_POST['ic2'];
  $bloque=$_POST['ic3'];
  $msj="Guardado correctamente.";

  $sql="INSERT INTO AULA (ID, DESCRIPCION, BLOQUESEDE, ESTADO)
    VALUES ('$cod','$dcs','$bloque', 'ACTIVO')";


  require_once 'conectar.php';

  if(isset($_GET['pk1'])){
    $id=$_GET['pk1'];
    $sql="DELETE FROM AULA WHERE ID='$id'";
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      $msj="Error eliminado ".mysqli_error($conexion);
    }
  }
if(isset($_POST['iguardar'])){
  $sql="SELECT * FROM AULA WHERE ID='$cod'";
  $result=mysqli_query($conexion,$sql);
  if(mysqli_errno($conexion)){
    $msj= "Error: ".mysqli_error($conexion);
}elseif(mysqli_num_rows($result)>0){
  $sql="UPDATE AULA SET DESCRIPCION='$dcs', BLOQUESEDE='$bloque',
  ESTADO='ACTIVO' WHERE ID='$cod'";
}else{
  $sql="INSERT INTO AULA (ID, DESCRIPCION, BLOQUESEDE, ESTADO)
  VALUES ('$cod','$dcs','$bloque', 'ACTIVO')";
}

$result=mysqli_query($conexion,$sql);
if(mysqli_errno($conexion)){
  $msj= "Error: ".mysqli_error($conexion);

}else{
  $msj="Guardado correctamente..";
}
}
header("location:../HTML/registrarAula.php?msj=$msj");
?>