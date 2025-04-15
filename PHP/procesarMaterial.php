<?php
  $cod=$_POST['ic1'];
  $dcs=$_POST['ic2'];
  $cant=$_POST['ic3'];
  $msj="Guardado correctamente.";

  $sql="INSERT INTO MATERIALAPOYO (ID, DESCRIPCION, CANTDISPONIBLE, ESTADO)
    VALUES ('$cod','$dcs','$cant', 'ACTIVO')";


  require_once 'conectar.php';

  if(isset($_GET['pk1'])){
    $id=$_GET['pk1'];
    $sql="DELETE FROM MATERIALAPOYO WHERE ID='$id'";
    $rsql=mysqli_query($conexion,$sql);

    if(mysqli_errno($conexion)){
      $msj= "Error eliminando: ".mysqli_error($conexion);
    }

}  
if(isset($_POST['iguardar'])){
  $sql="SELECT * FROM MATERIALAPOYO WHERE ID='$cod'";
  $result=mysqli_query($conexion,$sql);
  if(mysqli_errno($conexion)){
    $msj= "Error: ".mysqli_error($conexion);
}elseif(mysqli_num_rows($result)>0){
  $sql="UPDATE MATERIALAPOYO SET DESCRIPCION='$dcs', CANTDISPONIBLE='$cant',
  ESTADO='ACTIVO' WHERE ID='$cod'";
}else{
  $sql="INSERT INTO MATERIALAPOYO (ID, DESCRIPCION, CANTDISPONIBLE, ESTADO)
  VALUES ('$cod','$dcs','$cant', 'ACTIVO')";
}

$result=mysqli_query($conexion,$sql);
if(mysqli_errno($conexion)){
  $msj= "Error: ".mysqli_error($conexion);

}else{
  $msj="Guardado correctamente..";
}
}
header("location:../HTML/registrarMaterial.php?msj=$msj");
?>