<?php
function tablaAgendaLibre($conexion,$material,$fecha){
  $sql="SELECT A.ID,DATE_FORMAT(A.HORAINI,'%r') AS HORAINI,
  DATE_FORMAT(A.HORAFIN,'%r') AS HORAFIN,
  SUM(CANTDISPONIBLE-IFNULL(CANT,0)) AS CUPODISPONIBLE
          FROM (SELECT ID, HORAINI,HORAFIN, CANTDISPONIBLE
                FROM TEMP_AGENDAHORARIO,
                  MATERIALAPOYO) A LEFT JOIN
              (SELECT IDMATERIALAPOYO,HORAINI,HORAFIN,
                  SUM(CANTIDAD) AS CANT
                FROM (SELECT * FROM DETALLEPRESTAMO
                WHERE ESTADO='ACTIVO') D, TEMP_AGENDAHORARIO
                WHERE (HORAINI BETWEEN
                DATE_FORMAT(FECHAINICIO, '%H:%i') and
                DATE_FORMAT(FECHAFIN, '%H:%i'))
                AND IDMATERIALAPOYO='$material'
                and(DATE_FORMAT(FECHAINICIO, '%Y-%m-%d')=
                '$fecha' and DATE_FORMAT (FECHAFIN, '%Y-%m-%d')=
                '$fecha')
                Group by IDMATERIALAPOYO,HORAINI,HORAFIN)T
          on(T.IDMATERIALAPOYO=A.ID AND A.HORAINI=T.HORAINI
              AND A.HORAFIN=T.HORAFIN)
          WHERE ID='$material'
          GROUP BY A.ID,A.HORAINI,A.HORAFIN
          order by A.HORAINI
  ";
  $rsql=mysqli_query($conexion,$sql);
  if(mysqli_errno($conexion)){
      echo " Error ejecutando sql: ".mysqli_error($conexion);
  }
  $rsqlArray[0][0]="";
  $rsqlArray[0][1]="";
  $rsqlArray[0][2]="";
  $rsqlArray[0][3]="";
  $j=0;
  $dispo=true;
  while($row=mysqli_fetch_array($rsql)){
    $dispo=true;
    if($row['CUPODISPONIBLE']==0){
      $dispo=false;
    }
    if($j==0){
      $j++;
      $rsqlArray[$j][0]=$row['HORAINI'];
      $rsqlArray[$j][1]=$row['HORAFIN'];
      $rsqlArray[$j][2]=$row['CUPODISPONIBLE'];
      $rsqlArray[$j][3]=$dispo;
    }else if($rsqlArray[$j][2]==$row['CUPODISPONIBLE']){
      $rsqlArray[$j][1]=$row['HORAFIN'];
    }else{
      $j++;
      $rsqlArray[$j][0]=$row['HORAINI'];
      $rsqlArray[$j][1]=$row['HORAFIN'];
      $rsqlArray[$j][2]=$row['CUPODISPONIBLE'];
      $rsqlArray[$j][3]=$dispo;
    }
  }

  $ver="<table border class='tabla-tipo'>
          <tr>
            <td class='titulo-tabla'>Desde</td>
            <td class='titulo-tabla'>Hasta</td>
            <td class='titulo-tabla'>Cupo Disponible</td>
          </tr>";

  for($i=1; $i<=$j; $i++){
    $dispo=="";
    if(!$rsqlArray[$i][3]){
      $dispo='no-disponible';
    }
    $ver=$ver."<tr>";
    $ver=$ver."<td class='$dispo'>";
    $ver=$ver.$rsqlArray[$i][0];
    $ver=$ver."</td>";
    $ver=$ver."<td class='$dispo'>";
    $ver=$ver.$rsqlArray[$i][1];
    $ver=$ver."</td>";
    $ver=$ver."<td class='$dispo'>";
    $ver=$ver.$rsqlArray[$i][2];
    $ver=$ver."</td>";
    $ver=$ver."</tr>";
  }
  
  $ver=$ver."</table>";
  return $ver;
}

function validarDisponibilidad($conexion,$material,$fechaini,$fechafin){
  
  $sql="SELECT A.ID,SUM(D.CANTIDAD) AS CANT, CANTDISPONIBLE
        FROM MATERIALAPOYO A LEFT JOIN DETALLEPRESTAMO D
        ON(A.ID=D.IDMATERIALAPOYO)
        WHERE ((FECHAINICIO BETWEEN '$fechaini' and '$fechafin')
            (FECHAINICIO <= '$fechaini' and FECHAFIN >=
            '$fechaini' ) OR (FECHAINICIO <= '$fechafin'
            AND FECHAFIN >= '$fechafin' )) and
            A.ID='$material' AND D.ESTADO ='ACTIVO'
        Group by A.ID";
  $disponible=false;
  $rsql=mysqli_query($conexion,$sql);
  if($row=mysqli_fetch_array($rsql)){
    if($row['CANTDISPONIBLE'] > $row['CANT']){
      $disponible=true;
    }
  }else{
    $disponible=true;
  }
  return $disponible;
}

function nextIdPrestamo($conexion){
  $sql="SELECT max(id) as ID FROM PRESTAMO";
  $rsql=mysqli_query($conexion,$sql);
  $id=0;
  if($row=mysqli_fetch_array($rsql)){
    $id=$row['ID'];
    $id++;
  }
  return $id;
}


//segunda parte
function tablaPrestamoparaCancelar($conexion,$material,
$fechaini,$fechafin,$condicion,$usu){
  $cat=$_SESSION['CATEGORIA'];
  $sql="SELECT P.ID,date_format(DT.FECHAINICIO,'%Y-%m-%d')
  AS FECHA, date_format(DT.FECHAINICIO,'%r') as HORAINI,
  date_format(DT.FECHAFIN,'%r') AS HORAFIN,
        M.DESCRIPCION AS MATERIAL,A.DESCRIPCION AS
        AULA,D.NOMBRE,D.APELLIDO
    FROM PRESTAMO P JOIN DETALLEPRESTAMO DT
    ON(P.ID=DT.ID) JOIN DOCENTE D ON(
    P.IDSOLICITANTE=D.IDCLIENTE) JOIN AULA A
        ON (A.ID=DT.IDAULA) JOIN MATERIALAPOYO
        M ON(M.ID=DT.IDMATERIALAPOYO)
    WHERE FECHAINICIO BETWEEN '$fechaini'
    AND '$fechafin' AND DT.ESTADO ='ACTIVO'";
    if($material!=""){
      $sql=$sql." and IDMATERIALAPOYO = '$material'"; 
    }
    if($condicion!=""){
      $sql=$sql." and ".$condicion." AND
      (P.IDSOLICITANTE = '$usu' OR $cat='A')";
    }else if($cat=="U"){
      $sql=$sql." and P.IDSOLICITANTE ='$usu'";
    }

    $linkE='../PHP/procesarPrestamo.php';

    $rsql=mysqli_query($conexion,$sql);
    $ver=$ver= "<table border class='tabla-tipo'>
        <tr>
          <td class='titulo-tabla'>ID</td>
          <td class='titulo-tabla'>Fecha</td>
          <td class='titulo-tabla'>HoraIni</td>
          <td class='titulo-tabla'>HoraFin</td>
          <td class='titulo-tabla'>Material</td>
          <td class='titulo-tabla'>Aula</td>
          <td class='titulo-tabla'>Nombre</td>
          <td class='titulo-tabla'>Apellido</td>
          <td class='titulo-tabla'>
          <img class='imgEliminar'
          src='../IMG/eliminar.jpg'/></td>
        </tr>";
    
    while($row=mysqli_fetch_array($rsql)){
      $ver=$ver."<tr><td>";
      $ver=$ver.$row[0];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[1];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[2];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[3];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[4];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[5];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[6];
      $ver=$ver."</td><td>";
      $ver=$ver.$row[7];
      $ver=$ver."</td><td>";
      $linkB='"'.$linkE.'?pk1='.$row[0].'&"';
      $ver=$ver."
      <a href='javascript:confirmarSINO_My($linkB)'>
        <img class='imgEliminar' src='../IMG/eliminar.jpg'/>
      </a></td></tr>";
    }

    $ver=$ver."</table>";
    return $ver;
}


function eliminarPrestamo($conexion,$id){
  $tx=true;
  $err="";
  try{
    $sql="UPDATE prestamo SET ESTADO = 'ELIMINADO'
          WHERE  ID='$id'";

    mysqli_query($conexion,$sql);
      if(mysqli_errno($conexion)){
        $err=mysqli_error($conexion);
        $tx=false;
      }else{
        $sql="UPDATE detalleprestamo SET
        ESTADO ='ELIMINADO'
        WHERE ID='$id'";

        mysqli_query($conexion,$sql);
          if(mysqli_errno($conexion)){
            $err=mysqli_error($conexion);
            $tx=false;
          }
        }
        if($tx){
          mysqli_commit($conexion);
        }else{
          mysqli_rollback($conexion);
        }
      }catch(mysqli_sql_exception $exception){
        mysqli_rollback($conexion);
        throw $exception;
      }
      
      return $err;
}
//lo nuevo que se agg
function tablaPrestamo($conexion,$material,$fechaini,$fechafin,$condicion){
  $sql="SELECT P.ID,date_format(DT.FECHAINICIO,'%Y-%m-%d') AS FECHA,
  date_format(DT.FECHAINICIO,'%r') as HORAINI,
  date_format(DT.FECHAFIN,'%r') AS HORAFIN,
      M.DESCRIPCION AS MATERIAL,A.DESCRIPCION AS AULA,
      D.NOMBRE,D.APELLIDO
    FROM PRESTAMO P JOIN DETALLEPRESTAMO DT ON(P.ID=DT.ID)
    JOIN DOCENTE D ON(P.IDSOLICITANTE=D.IDCLIENTE) JOIN AULA A
      ON(A.ID=DT.IDAULA) JOIN MATERIALAPOYO M
      ON(M.ID=DT.IDMATERIALAPOYO)
    WHERE FECHAINICIO BETWEEN '$fechaini' AND '$fechafin'
    AND DT.ESTADO ='ACTIVO'";
  if($material!=""){
    $sql=$sql." and IDMATERIALAPOYO = '$material'";
  }
  if($condicion!=""){
    $sql=$sql." and ".$condicion;
  }
  $rsql= mysqli_query($conexion,$sql);
  $ver=$ver= "<table border class='tabla-tipo'>
            <tr>
              <td class='titulo-tabla'>Id</td>
              <td class='titulo-tabla'>Fecha</td>
              <td class='titulo-tabla'>HoraIni</td>
              <td class='titulo-tabla'>HoraFin</td>
              <td class='titulo-tabla'>Material</td>
              <td class='titulo-tabla'>Aula</td>
              <td class='titulo-tabla'>Nombre</td>
              <td class='titulo-tabla'>Apellido</td>
            </tr>";
  while($row=mysqli_fetch_array($rsql)){
    $ver=$ver."<tr><td>";
    $ver=$ver.$row[0];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[1];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[2];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[3];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[4];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[5];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[6];
    $ver=$ver."</td><td>";
    $ver=$ver.$row[7];
    $ver=$ver."</td></tr>";
  }
  $ver=$ver."</table>";
  return $ver;
}

?>