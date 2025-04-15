<?php
session_start();
$id=$des="";
$cant=1;
date_default_timezone_set('America/Bogota');
$hoy=date("Y-m-d H:i:s");
$fechaini=$fechafin=$hoy;
$idusuario="";
if(!empty($_POST['imate'])){
  $mat=$_POST['imate'];
}
if(!empty($_POST['icaula'])){
  $aula=$_POST['icaula'];
}
if(!empty($_POST['icdoce'])){
  $idusuario=$_POST['icdoce'];
}
if(!empty($_POST['ifecha']) && !empty($_POST['ihini']) &&
  !empty($_POST['ihfin'])){
    $fechaini=$_POST['ifecha'].' '.$_POST['ihini'];
    $fechafin=$_POST['ifecha'].' '.$_POST['ihfin'];
}

$msj="Guardado correctamente";
$err="";
require_once 'conectar.php';
require_once 'consultarPrestamos.php';

if(!empty($_GET['pk1'])){
  $id=$_GET['pk1'];
  $err=eliminarPrestamo($conexion,$id);
  $msj="Cancelado correctamente";
  header("location:../HTML/registrarCancelacion.php?msj=$msj");
  exit();
}else if(isset($_POST['iguardar'])){
  
  if(validarDisponibilidad($conexion,$mat,$fechaini,$fechafin)){
    mysqli_autocommit($conexion,false);
    $err="";
    try{
      $tx=true;
      $id=nextIdPrestamo($conexion);
      $sql="INSERT INTO PRESTAMO (ID,FECHAREGISTRO,
      IDSOLICITANTE,ESTADO) VALUE
      ('$id', '$hoy', '$idusuario', 'ACTIVO')";
      mysqli_query($conexion,$sql);
      if(mysqli_errno($conexion)){
        $tx=false;
        $err=mysqli_error($conexion);
      }else{
        $sql="INSERT INTO DETALLEPRESTAMO (ID, ITEM,
        IDMATERIALAPOYO, CANTIDAD, FECHAINICIO, FECHAFIN,
        IDAULA, ESTADO) VALUE ('$id','1','$mat','1',
        '$fechaini','$fechafin','$aula','ACTIVO')";
        mysqli_query($conexion,$sql);
        if(mysqli_errno($conexion)){
          $tx=false;
          $err=mysqli_error($conexion);
        }
        
        if($tx){
          mysqli_commit($conexion);
        }else{
          mysqli_rollback($conexion);
        }
      }
      mysqli_autocommit($mysqli, true);

    }catch(mysqli_sql_exception $exception){
      mysqli_rollback($conexion);
      echo $exception;
    }
    $msj=$err;
  }else{
    $msj="No hay disponibilidad para ese rango de hora";
    $err=$msj;
  }
}

$msj=$err;
header("location:../HTML/registrarPrestamo.php?msj=$msj");

?>