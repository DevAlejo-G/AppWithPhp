<?php
  function tablaMaterial($conexion,$id){
    $linKE='../PHP/procesarMaterial.php';
    $sql="SELECT ID, DESCRIPCION, CANTDISPONIBLE, ESTADO
    FROM MATERIALAPOYO WHERE ESTADO='ACTIVO'";
    if($id!=""){
      $sql=$sql." AND (ID LIKE '%$id%' OR DESCRIPCION LIKE '%$id%' OR
      CANTDISPONIBLE LIKE '%$id%')"; 
    }
    $rsql=mysqli_query($conexion,$sql);
    if(mysqli_errno($conexion)){
      echo "Error sql: ".mysqli_errno($conexion);
    }
    $ver = "<table border class='tabla-tipo'>
    <tr>
      <td class='titulo-tabla'>ID</td>
      <td class='titulo-tabla'>DSC</td>
      <td class='titulo-tabla'>CANT</td>
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
      $ver=$ver.$row['CANTDISPONIBLE'];
      $ver=$ver."</td>";
      $linKD='Array("'.$row["ID"].' "," '.$row["DESCRIPCION"].' "," '.$row["CANTDISPONIBLE"].'")';
      $linKE="../PHP/procesarMaterial.php?pk1=".$row["ID"];
      $ver=$ver."<td><a href='javascript:editarRegistro($linKD,1)'><img class='imgDetalle'
      src='../IMG/detalle.jpg'/></a></td>";
      $ver=$ver."<td><a href='$linKE'><img class='imgEliminar'
      src='../IMG/eliminar.jpg'/></a></td>
      </tr>";
    }
    $ver=$ver."</table>";
    return $ver;
  }

  function comboListaMaterial($conexion,$valor){
    $ver="";
    $sql="SELECT ID, DESCRIPCION, CANTDISPONIBLE, ESTADO
          FROM MATERIALAPOYO WHERE ESTADO='ACTIVO'";
    $rsql=mysqli_query($conexion,$sql);
      if(mysqli_errno($conexion)){
        echo "Error generado combomaterial".mysqli_error($conexion);
      }else{
        $ver="
        <select name='icmate' class='input-subraya' id='icmate'
        onchange='cambiar(1);'>";
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