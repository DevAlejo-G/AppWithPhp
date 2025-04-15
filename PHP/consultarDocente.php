<?php
  function tablaDocente($conexion,$id){
    $linKE='../PHP/procesarDocente.php';
    $sql="SELECT IDCLIENTE, NOMBRE, APELLIDO, ESTADO
    FROM DOCENTE WHERE ESTADO='ACTIVO'";
    if($id!=""){
      $sql=$sql." AND (IDCLIENTE LIKE '%$id%' OR NOMBRE LIKE '%$id%' OR
      APELLIDO LIKE '%$id%')"; 
    }
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      echo "Error sql: ".mysqli_errno($conexion);
    }
    $ver = "<table border class='tabla-tipo'>
    <tr>
      <td class='titulo-tabla'>ID</td>
      <td class='titulo-tabla'>NOMBRE</td>
      <td class='titulo-tabla'>APELLIDO</td>
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
      $ver=$ver.$row['IDCLIENTE'];
      $ver=$ver."</td>";
      $ver=$ver."<td>";
      $ver=$ver.$row['NOMBRE'];
      $ver=$ver."</td>";
      $ver=$ver."<td>";
      $ver=$ver.$row['APELLIDO'];
      $ver=$ver."</td>";
      $linKD='Array("'.$row["IDCLIENTE"].' "," '.$row["NOMBRE"].' "," '.$row["APELLIDO"].'")';
      $linKE="../PHP/procesarDocente.php?pk1=".$row["IDCLIENTE"];
      $ver=$ver."<td><a href='javascript:editarRegistro($linKD,1)'><img class='imgDetalle'
      src='../IMG/detalle.jpg'/></a></td>";
      $ver=$ver."<td><a href='$linKE'><img class='imgEliminar'
      src='../IMG/eliminar.jpg'/></a></td>
      </tr>";
    }
    $ver=$ver."</table>";
    return $ver;
  }

  function comboListaDocente($conexion,$valor){
    $ver="";
    $sql="SELECT IDCLIENTE, concat(NOMBRE,' ',APELLIDO)
            as NOMBRE,ESTADO
          FROM DOCENTE WHERE ESTADO='ACTIVO'";
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      echo "Error generado combodocente ".mysqli_error($conexion);
    }else{
      $ver="
      <select name='icdoce' class='input-subraya'
      id='icdocente'>";
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