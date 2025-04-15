<?php
  $cat=$_SESSION['CATEGORIA'];
?>
<html>
	<head>
		<title>SMD</title>
		<link rel='shorcut icon' href='../img/logo.png'/>
		<!-- ojo con el orden de los stilos.... siempre aplicara
		el ultimo en caso que se repitan atributos de una clase-->
		<link rel='stylesheet'  type='text/css' href='../css/myestiloColoresYFuentes.css'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloSecPaginas.css'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloFormas.css'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloAlarmas.css'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloAlarmas_Movil.css' media='only screen and (max-width:1050px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloFormas_Movil.css' media='only screen and (max-width:1050px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloPlantillaContenido1div1.css'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloMenuBasico.css'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloMenuBasico_Movil.css' media='only screen and (max-width:1050px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloMenuBasico_PC.css' media='only screen and (min-width:1051px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloPlantillaContenido1div1_Movil.css' media='only screen and (max-width:1050px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloPlantillaContenido1div1_PC.css' media='only screen and (min-width:1051px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloPlantillaContenido2div1_Movil.css' media='only screen and (max-width:1050px)'/>
		<link rel='stylesheet'  type='text/css' href='../css/myestiloPlantillaContenido2div1_PC.css' media='only screen and (min-width:1051px)'/>

	</head>
	<body>
		<div class='inicio'>
			<br/> <marquee scrolldelay='1' scrollamount='5' direction='left' loop='infinite' onmouseout='this.start()' onmouseover='this.stop()'>
				PRESTAMO DE MEDIOS DIDACTICOS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;
					HAZ TU SOLICITUD
			</marquee>
		</div>
		<header>
		
		</header>
		<nav>
			<input type='checkbox'  class='check-movil' id='movil'/><label  for='movil'  class='ico-menuMovil'></label>
			<a href='' class='a-carroMovil'><img src='img/carro.png' class='ico-carroMovil' /></a>
			<div class='menu1'>
				<ul class='menu-nivel1'>
					<li><a href='principal.php'>Inicio</a></li>
					<li><a href=''>Prestamo<sub></sub></a>
				<ul class='menu-nivel2'>
						<li><a  href='registrarPrestamo.php'>Solicitud</a>					
						</li>
						<li><a href='registrarCancelacion.php'>Cancelar</a></li>
						<li><a href=''><hr/></a></li>
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
		</ul>
		</div>
		<div class='menu2'>
			<ul class='menu-nivel1'>		
				<li class='as'><a href='' ><img src='img/carro.png' class='ico-carro' /></a></li>
				<li class='as'><a href='../PHP/cerrarSesion.php' >Cerrar Sesion</a></li>
				
			</ul>
		</div >
		</nav>
		<section>