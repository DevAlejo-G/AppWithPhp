<?php
  session_start();
  if(!isset($_SESSION['USUARIO'])){
    header("Location:../HTML/index.php");
    exit();
  }

include 'encabezado.php';
require_once '../PHP/conectar.php';
require_once '../PHP/consultarDocente.php';
require_once '../PHP/consultarMaterial.php';
require_once '../PHP/consultarAula.php';
require_once '../PHP/consultarPrestamos.php';
//inicializoVariables
$tdisponible="";
$mat="";
$msj="";
$doce="";
date_default_timezone_set('America/Bogota');
$hoy=date("Y-m-d");
$fecha=$hoy;
$ahora=""; //rangoCuartoHora (date ('H:i'))
$ahoraF=new DateTime();
$ahoraF->modify('+1 hours');
$ahoraF= $ahoraF->format('H:i');
$ahoraF="";
$hini=$ahora;
$hfin='21:00';
$formReg="";
$aula="";
$observa="";
//valido si las variables vienen en el formulario para mostrar por
if(!empty ($_POST['ifini'])){
  $fecha=$_POST['ifini'];
}
if(!empty($_POST['ihini'])){
  $ahora=$_POST['ihini'];
}
if(!empty($_POST['ihfin'])){
  $ahoraF=$_POST['ihfin'];
}
if(!empty($_POST['icaula'])){
  $aula=$_POST['icaula'];
}
if(!empty($_POST['icdoce'])){
  $doce=$_POST['icdoce'];
}

if(!empty($_GET['msj'])){
  $msj=$_GET['msj'];
  $msj="<p class='p-msj' id='ip-msj'>".$msj."<p/>";
}
if(!empty($_POST['ifini'])){
  $fecha=$_POST['ifini'];
  if($fecha!=$hoy){
    $hini='07:00';
  }
}
if(!empty($_POST['icmate'])){
  $mat=$_POST['icmate'];

  $tdisponible=tablaAgendaLibre($conexion,$mat,$fecha);
  $vistaComboAula=comboListaAula($conexion,$aula);
  $campo4='"campo4"';
  $vistaComboDocente="";
  $vistaComboDocente="<label>Docente</label>
  ".comboListaDocente($conexion, $doce);

  $formReg="<form class='form-resalto' action=
  '../PHP/procesarPrestamo.php' method='post'
  name='formulario1' onsubmit=
  'return validarDatosPrestamo();'>
  
  <legend>Registrar Prestamo</legend>
  <label>Hora Inicio</label>
  <input type='time' value='$ahora' name='ihini'
  id='campo3' min='$hini' max='$hfin'
  onblur='cambiar(3);'/> 
  <label>Hora Fin</label>
  <input type='time' value='$ahoraF'
  name='ihfin' id='campo4' min ='$ahoraF' max='$hfin'
  onblur='rangoHora($campo4);' />
  $vistaComboDocente
  <label>Aula</label>
  $vistaComboAula
  <input type='hidden' name='iobserva' value='$observa'
  id='iobserva' />
  <input type='hidden' name='imate' value='$mat'
  id='imate' />
  <input type='hidden' name='ifecha' value='$fecha'
  id='ifecha' />
  <div class='div-from-boton'>
      <input class='cancelar-semiovalado'
      value='Cancelar' name='icancelar' type='reset'/>
      <input class='boton-semiovalado' value='Guardar'
      name='iguardar' type='submit'/>
  </div>
  </form>";
}
$vistaCombo=comboListaMaterial($conexion,$mat);
echo "<div class='contenido_izquierda'>
    
    <form class='form-opcion-buscar' action=''
    method='post' onsubmit='return validarDatosBusqueda();'
    name='formularioB'>
      <fieldset>
      <legend>Opciones de busqueda</legend>
      <input type='image' name='imbuscar'
      src='../IMG/lupa.jpg'/>
      <label>Material de apoyo</label>
      $vistaCombo
      <label>Fecha Inicio</label>
      <input type='date' value='$fecha' name='ifini'
      id='campo1' min='$hoy' onchange='cambiar(2);'
      placeholder='Buscar'/>
      </fieldset>
    </form>
  $formReg
</div>
<div class='contenido_derecha'>
  $msj
  $tdisponible
</div>";
include 'pie.html';
?>
<script>
function rangoHora(campo){
  
  var horaT=document.getElementById(campo).value;
  var minutos=horaT.substr(3, 2);
  var minuto=parseInt(minutos);

  var hora=horaT.substr(0, 2);

  if(minuto > 0 && minuto < 15){
    minutos="00";
  }else if(minuto > 15 && minuto < 30){
    minutos="15";
  }else if(minuto > 30 && minuto < 45){
    minutos="30";
  }else if(minuto > 45 && minuto > 59){
    minutos="45";
  }
  document.getElementById(campo).value=hora+":"+minutos;
}

function cambiar(opc){
  switch(opc){
    case 1: //si es la materia
      document.getElementById('imate').value=
      document.getElementById('icmate').value;
      document.formularioB.submit();
      break;
    case 2: //si es la fecha de consulta
      document.getElementById('ifecha').value=
      document.getElementById('campo1').value;
      document.formularioB.submit();
      break;
    case 3: //si es la hora inicial de la consulta
      rangoHora('campo3')
      document.getElementById('campo4').min=
      document.getElementById('campo3').value;
      break;
  }
}
</script>