<?php
  session_start();
  if(!isset($_SESSION['USUARIO'])){
    header("Location:../HTML/index.php");
    exit();
  }

  include 'encabezado.php';
  include '../PHP/conectar.php';
  include '../PHP/consultarPrestamos.php';
  include '../PHP/consultarMaterial.php';

  $condicion="";
  $id="";
  $msj="";
  $mat="";
  date_default_timezone_set('America/Bogota');
  $hoy=date("Y-m-d");
  $fecha=$hoy;
  $fechaFin=$hoy;
  $idusu=$_SESSION["USUARIO"];

  if(!empty($_POST['ifini'])){
    $fecha=$_POST['ifini'];
  }

  //El error esta por aqui

  if(!empty($_POST['ifin'])){
    $fechaFin=$_POST['ifin'];
    $fechaFin=$fechaFin.' 23:59';
  }

  if(!empty($_GET['msj'])){
    $msj=$_GET['msj'];
    $msj="<p class='p-msj' id='ip-msj'>".$msj."</p>";
  }

  if(isset($_POST['imbuscar_y'])){
    $id=$_POST['ibuscar'];
    $condicion="(M.DESCRIPCION like '%".$id."%'
    OR A.DESCRIPCION like '%".$id."%' OR D.NOMBRE
    like '%".$id."%' OR D.APELLIDO like '%".$id."%')";
  }
  $vistaTabla=tablaPrestamoparaCancelar($conexion,$mat,$fecha,
  $fechaFin,$condicion,$idusu);
  $ver="";
  if(isset($_POST['imfiltro_y'])){
    if(!empty($_POST['ifini'])){
      $fecha=$_POST['ifini'];
      $fechaFin=$_POST['ifin:'];
      $fechaFin=$fechaFin.' 23:59';
      $ver="<form class='form-buscar' action=''
      method='post'>
              <input type='search' value='$id'
              name='ibuscar'
              placeholder='Buscar' />
              <input type='image' name='imbuscar'
              src='../IMG/lupa.jpg' />
              <input type='submit'
              class='boton-casitransparente'
              value='Opcion de busqueda' />
            </form>
            ".$vistaTabla;
    }
  }else{
    $ver="<form class='form-opcion-buscar' action=''
    method='post' onsubmit='return validarDatosBusqueda();'
    name='formularioB'>
                <fieldset>
                <legend>Opciones de Busqueda</legend>
                <input type='image' name='imfiltro'
                src='../IMG/lupa.jpg'/>
                <label>Fecha Desde</label>
                <input type='date' value='$fecha'
                name='ifini' id='campo1'
                  min='$hoy' placeholder='Buscar'/>
                  <label>Fecha Hasta</label>
                <input type='date' value='$fechaFin'
                name='ifin' id='campo2'
                  min='$fecha' placeholder='Buscar'/>
                </fieldset>
            </form>";
  }
  echo "
        <div class='contenido_completo'>
          $msj
          $ver
        </div>";

?>

<div id="confirmModal" class="ModalDialog">
    
  <div>
    <a href="javascript: history.go(-1)"
    title="Close" class="close">X</a>
    <p class="titulo-confirm" id="titulo-confirm">
    Mi modal</p>
    <p id="msjConfirm" class="msj-Confirm">
    Refresque la pagina por favor.</p>
  </div>
    <a href="javascript: history.go(-1)"
    id="botonNOc" class="cancelar-semiovalado">
    No</a>
    <a id="botonSIc"
    href="javascript:submit_local('')"
    class="boton-semiovalado">Si</a>
    </div>
  </div>
</div>
<script>
  function confirmarSINO_My(link){
    if(link!=""){
      document.getElementById("botonSIc").href=link;
    }
      document.getElementById("msjConfirm").innerHTML=
      "Estas seguro de cancelar este prestamo?";
      document.getElementById("titulo-confirm").innerHTML=
      "Cancelar prestamo";
      document.location.href=
      'registrarCancelacion.php#confirmModal';
  }
</script>
<?php
  include 'pie.html';
?>

