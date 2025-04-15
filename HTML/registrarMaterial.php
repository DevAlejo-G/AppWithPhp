<?php
  session_start();
  if(!isset($_SESSION['USUARIO'])){
    header("Location:../HTML/index.php");
    exit();
  }

include "encabezado.php";
require_once "../PHP/conectar.php";
require_once "../PHP/consultarMaterial.php";

$id="";
$msj="";
if(isset($_POST['imbuscar_y'])){
  $id=$_POST['ibuscar'];
}


if(!empty($_GET['msj'])){
  $msj=$_GET['msj'];
  $msj="<p class='p-msj' id='ip-msj'>".$msj."</p>";
}

echo "
<div class='contenido_completo'>
  $msj
    <form class='form-buscar' action='' method='post' id='idFbuscar'>
        <input type='search' value='$id' name='ibuscar'
        placeholder='Buscar' />
        <input type='image' name='imbuscar' src='../IMG/lupa.jpg'/>
      </form>
      <a href='javascript:agregarRegistro()'
      class='a-add'><img src='../IMG/add.png' class='imgEliminar'/><a/>
      ";

      $vistaTabla=tablaMaterial($conexion,$id);

?>

<script>
  function agregarRegistro(){
    document.getElementById('campo1').value="";
    document.getElementById('campo1').removeAttribute("readonly", false);

    document.getElementById('campo2').value="";
    document.getElementById('campo2').removeAttribute("readonly", false);

    document.getElementById('campo3').value="";
    document.getElementById('campo3').removeAttribute("readonly", false);

    document.location.href="registrarMaterial.php#nuevoRegistro";
  }

  function editarRegistro(reg,pk){
    var max=reg.length;
    for(var i=0; i<max; i++){
      campo='campo'+(i+1);
      if(document.getElementById(campo)!=null){
        document.getElementById(campo).value=reg[i];
        if((i+1) <= pk){
          document.getElementById(campo).setAttribute("readonly","readonly", false);

        }
      }
    }
    document.location.href="registrarMaterial.php#nuevoRegistro";
  }
</script>

<?php echo $vistaTabla; ?>
  <div id="nuevoRegistro" class="modalDialog">
    <form class="form-resalto" action="../PHP/procesarMaterial.php" method="post" name="formulario1">
      <legend>Materiales</legend>
      <label>ID</label>
      <input type="text" class="input-subraya" 
      value="" maxlength="15" name="ic1" id="campo1" 
      placeholder="Ingrese Id" required>

      <label>Descripcion</label>
      <input type="text" class="input-subraya" 
      value="" maxlength="30" name="ic2" id="campo2" 
      placeholder="Ingrese descripcion" required>

      <label>Cantidad</label>
      <input type="text" class="input-subraya" 
      value="" maxlength="30" name="ic3" id="campo3" 
      placeholder="Ingrese cantidad" required>

      <div class="div-from-boton">
        <a href="" class="cancelar-semiovalado" id="botoncancelar">Cancelar</a>
        <input type="submit" class="boton-semiovalado" value="Guardar" name="iguardar">
      </div>
    </form>
  </div>
</div>

<?php
include "pie.html";
?>