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

<?php
  $msj="";
  if(!empty($_GET['msj'])){
    $msj=$_GET['msj'];
    $msj="<p class='p-msj' id='ip-msj'>".$msj."</p>";
  }

  echo "<body>
		<div class='inicio'>
			<br/> <marquee scrolldelay='1' scrollamount='5' 
			direction='left' loop='infinite' 
			onmouseout='this.start()' 
			onmouseover='this.stop()'>
			PRESTAMO DE MEDIOS DIDACTICOS &nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				HAZ TU SOLICITUD
			</marquee>
	</div>
	<header>
		
	</header>
		<nav>
			<div class='menu1'>
			</div>
			<div class='menu2'>
			</div >
		</nav>
		<section>
			<div class='contenido_completo'>
			$msj
			";
?>
<form class="form-resalto" action="../PHP/procesarlogin.php"
		method="post" name="formulario1">
		<legend>Login</legend>
		<label for="">Usuario</label>
		<input class="input-subraya"
		value="" maxlength="15" name="ic1" type="text" id="campo1"
		placeholder="Ingrese Usuario" required />
		<label for="">Clave</label>
		<input class="input-subraya"
		value="" maxlength="30" name="ic2" type="password"
		id="id-password1"
		placeholder="Ingrese Contraseña" required >
		<input type="image" src="../IMG/ojocerrado.png"
		id="id-boton-ojo1" onclick="verclave(1);"
		form="nada" />
		<div class="div-from-boton">
			<a class="cancelar-semiovalado" id="botonCancelar"
			href="">Cancelar</a>
			<input class="boton-semiovalado"
			value="Acceder" name="iaceptar" type="submit">
		</div>
</form>

</div>
<script>
	function verclave(n){
		var obj1, obj2;
		obj1=document.getElementById('id-password'+n);
		obj2=document.getElementById('id-boton-ojo'+n);
			if(obj1.type=='password'){
				obj1.type='text';
				obj2.src="../IMG/ojoabierto.png";
			}else{
				obj1.type="password";
				obj2.src="../IMG/ojocerrado.png";
			}
			return -1;
	}
</script>
<?php
include "../HTML/pie.html"
?>