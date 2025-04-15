<?php
  function tablaAula($conexion,$id){
    $linKE='../PHP/procesarAula.php';
    $sql="SELECT ID, DESCRIPCION, BLOQUESEDE, ESTADO
    FROM AULA WHERE ESTADO='ACTIVO'";
    if($id!=""){
      $sql=$sql." AND (ID LIKE '%$id%' OR DESCRIPCION LIKE '%$id%' OR
      BLOQUESEDE LIKE '%$id%')"; 
    }
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      echo "Error sql: ".mysqli_errno($conexion);
    }
    $ver = "<table border class='tabla-tipo'>
    <tr>
      <td class='titulo-tabla'>ID</td>
      <td class='titulo-tabla'>DCS</td>
      <td class='titulo-tabla'>Bloque</td>
      <td class='titulo-tabla'>
        <img class='imgEliminar' src='../IMG/detalle.jpg'>
      </td>
      <td class='titulo-tabla'>
        <img class='imgEliminar' src='../IMG/eliminar.jpg'>
      </td>
    </tr>";

    while($row=mysqli_fetch_array($rsql)){
      $ver=$ver."<tr>";
      $ver=$ver."<td>";
      $ver=$ver.$row['ID'];
      $ver=$ver."</td>";
      $ver=$ver."<td>";
      $ver=$ver.$row['DESCRIPCION'];
      $ver=$ver."</td>";
      $ver=$ver."<td>";
      $ver=$ver.$row['BLOQUESEDE'];
      $ver=$ver."</td>";
      $linKD='Array("'.$row["ID"].' "," '.$row["DESCRIPCION"].' "," '.$row["BLOQUESEDE"].'")';
      $linKE="../PHP/procesarAula.php?pk1=".$row["ID"];
      $ver=$ver."<td><a href='javascript:editarRegistro($linKD,1)'><img class='imgDetalle'
      src='../IMG/detalle.jpg'/></a></td>";
      $ver=$ver."<td><a href='$linKE'><img class='imgEliminar'
      src='../IMG/eliminar.jpg'/></a></td>
      </tr>";
    }
    $ver=$ver."</table>";
    return $ver;
  }

  function comboListaAula($conexion,$valor){
    $ver="";
    $sql="SELECT ID, DESCRIPCION, ESTADO
          FROM AULA WHERE ESTADO='ACTIVO'";
    $rsql= mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      echo "Error generado comboaula ".mysqli_error($conexion);
    }else{
      $ver="
      <select name='icaula' class='input-subraya' id='icaula' >";
      $ver=$ver."
      <option value='0'>----Seleccione una opcion----</option>";

      while($row=mysqli_fetch_array($rsql)){
        $sele="";
        $val=$row[0];
        $desc=$row[1];
        if($valor==$val){
          $sele="selected";
        }
        $ver=$ver."<option value='$val' $sele>$desc</option>";

      }
      $ver=$ver."</select>";
    }

    return $ver;
  }
?>