<?php
  session_start();
  if(!isset($_SESSION['USUARIO'])){
    header("Location:../HTML/index.php");
    exit();
  }

  include 'encabezado.php';
  require_once '../PHP/conectar.php';
  require_once '../PHP/consultarPrestamos.php';
  require_once '../PHP/consultarMaterial.php';

  $mensajeConfirmacion='Desea eliminar el registro?';
  $tituloConfirmacion='Eliminar registro';
  $condicion="";
  $id="";
  $msj="";
  $nex=0;
  $nex=0;
  $mat=0;

  date_default_timezone_set('America/Bogota');
  $hoy=date("Y-m-d");
  $fecha=$hoy;

  if(!empty($_POST['ifini'])){
    $fecha=$_POST['ifini'];
  }

  if(!empty($_POST['icmate'])){
    $mat=$_POST['icmate'];
  }

  $fechaFin=$fecha.' 23:59';
  if(!empty($_GET['m'])){
    $msj=$_GET['msj'];
    $msj="<p class='p-msj' id='ip-msj'>".$msj."</p>";
    echo "<script>";
      include '../js/jstemporizador.js';
    echo "</script>";
  }
  if(isset($_POST['imbuscar_y'])){
    $id=$_POST['ibuscar'];
    $condicion="(M.DESCRCION like '%".$id."%'
    OR A.DESCRIPCION like '%".$id."%' OR D.NOMBRE like '%".$id."%'
    OR D.APELLLIDO like '%".$id."%')";
  }
  if(isset($_GET['nex'])){
    $nex=$_GET['nex'];
  }

  $vistaTabla=tablaPrestamo($conexion,$mat,$fecha,$fechaFin,$condicion);
  $ver="";
  if(isset($_POST['imfiltro_y'])){
    if(!empty($_POST['ifini'])){
      $fecha=$_POST['ifini'];
      $fechaFin=$fecha.' 23:59';
      $ver="<form class='form-buscar' action='' method='post'>
      <input type='search' value='$id' name='ibuscar'
      placeholder='Buscar'/>
      <input type='image' name='imbuscar'
      src='../IMG/lupa.jpg'/>
      <input type='submit' class='boton-casitransparente'
      value='Opcion de busqueda'/>
      </form>
      ".$vistaTabla."
      <form action='../PHP/imprimirSolicitud.php' method='get'>
      <input name='fi' value='$fecha' hidden />
      <input name='ff' value='$fechaFin' hidden />
      <input type='submit' class='boton-casitransparente'
      value='imprimir'/>
      </form>";
    }
  }else{
    $ver="<form class='form-opcion-buscar' action='' method='post'
    onsubmit='return validarDatosBusqueda();' name='formularioB'>
        <fieldset>
          <legend>Opciones de buscqueda</legend>
          <input type='image' name='imfiltro'
          src='../IMG/lupa.jpg'/>
          <label>Fecha Consulta</label>
          <input type='date' value='$fecha' name='ifini'
          id='campo1' placeholder='Buscar'/>
        </fieldset>
      </form>";
  }
  echo "
      <div class='contenido_completo'>
      $msj
      $ver
      </div>"; 

  include 'pie.html'; 
?>