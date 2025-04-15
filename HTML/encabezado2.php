<?php
  $cat=$_SESSION['CATEGORIA'];
  include 'encabezado.html';
?>
<html>
  <head>
    <title>SMD</title>
    <link rel='shorcut icon' href='../IMG/logo.png' />



    <link rel='stylesheet' type='text/css'
    href="../CSS/myestiloColoresYFuentes.css" />
    <link rel='stylesheet' type='text/css'
    href='../CSS/myestiloSecPaginas.css' />
    <link rel='stylesheet' type='text/css'
    href="../CSS/myestiloFormas.css" />
    <link rel='stylesheet' type='text/css'
    href="../CSS/myestiloAlarmas.css" />
        <li><a href="registrarPrestamo.php">Solicitud</a>
        </li>
        <li><a href="registrarCancelacion.php">Cancelar</a></li>
        <li><a href=""><hr/></a></li>
        <?php
          if($cat=="A"){
          echo "<li><a href='consultaInforme.php'>Informes</a></li>";
          }
        ?>
      </ul>
    </li>
    <?php
    if($cat=="A"){
    echo "<li><a href=''>Configuracion<sub></sub></a>
        <ul class='menu-nivel2'>
            <li><a href='registrarMaterial.php'>Material</a></li>
            <li><a href='registrarAula.php'>Aulas</a></li>
            <li><a href=''>Personas<sub></sub></a>
              <ul class='menu-nivel3'>
                <li><a href='registrarDocente.php'>Docentes
                </a></li>
              </ul>
            </li>
            <li><a href=''>Horario</a></li>
        </ul>
    </li>";
  }
?>

<?php
  include 'pie.html';
?>