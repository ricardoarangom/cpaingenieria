<?php require_once('../connections/datos.php'); ?>
<?php 
session_start();
$usuario=$_SESSION['IdUsuario'];
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_datos, $datos);
$query_Recordset1 = "SELECT gviaje.IdGviaje, nombre, apellido, area, municipio, departamentos, fsalida, fregreso, actividad, fsolicitud, beneficiario, total FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join totgviaje on gviaje.IdGviaje=totgviaje.IdGviaje  where fautorizacion is null";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?> 
<?php
include('encabezado.php')
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center">
  <h4 class="Century24">GASTOS DE VIAJE PENDIENTES POR AUTORIZAR</h4>
</div>
<br />
  <?php //echo $usuario  ?>
<div class="contenedor-ancho" style="width: 1600px">
  <?php 
  if($totalRows_Recordset1>0){
  ?>
  <table border="1" class="tablita Arial13" align="center">
		<col width="45px">
		<col width="80px">
		<col width="220px">
		<col width="250px">
		<col width="280px">
		<col width="80px">
		<col width="80px">
		<col width="150px">
    <col width="150px">
    <col width="82px">
		<col width="82px">
    <tbody>
      <tr class="Arial13 titulos" >
        <td align="center">No. Sol.</td>
				<td align="center">FECHA SOLICITUD</td>
        <td align="center">SOLICITANTE</td>
        <td align="center">AREA/PROYECTO</td>
				<td align="center">ACTIVIDAD</td>
        <td align="center">FECHA SALIDA</td>
				<td align="center">FECHA REGRESO</td>
				<td align="center">DESTINO</td>
        <td>QUIEN VIAJA</td>
        <td>VALOR</td>
        <td align="center">Autorizar / Rechazar </td>
        </tr>
      <?php 
        do{
        ?>
        <tr class="Arial12">
          <td align="right" valign="top"><?php echo $row_Recordset1['IdGviaje']; ?></td>
					<td align="center" valign="top"><?php echo fechaactual3($row_Recordset1['fsolicitud']); ?></td>
          <td valign="top"><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido']; ?></td>
          <td valign="top"><?php echo $row_Recordset1['area']; ?></td>
          <td valign="top"><?php echo $row_Recordset1['actividad']; ?></td>
					<td align="center" valign="top"><?php echo fechaactual3($row_Recordset1['fsalida']); ?></td>
					<td align="center" valign="top"><?php echo fechaactual3($row_Recordset1['fregreso']); ?></td>
					<td valign="top"><?php echo $row_Recordset1['municipio']; ?><br><?php echo $row_Recordset1['departamentos']; ?></td>
          <td valign="top"><?php echo $row_Recordset1['beneficiario']; ?></td>
          <td valign="top" align="right"><?php echo number_format($row_Recordset1['total']); ?></td>
          <td align="center" valign="top">
            <a href="autorizargv1.php?solicitud=<?php echo $row_Recordset1['IdGviaje'] ?>" target="_blank" class="btn btn-rosa btn-xs1">AUTORIZAR</a>
            </td>
          </tr>
        <?php 
        }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
        ?>
      </tbody>
    </table>
  <?php 
  }else{
    ?>
</div>
    <div class="container" align="center">
      <h5>NO HAY GASTOS DE VIAJE POR AUTORIZAR</h5>
    </div>
    <div> 
      <?php     }
  ?>
</div>
  
</div>

<?php 
	mysql_close($datos);

include('footer.php')
?>



</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
