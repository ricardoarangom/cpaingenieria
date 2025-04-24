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

$var1_Recordset1 = "0";
if (isset($usuario)) {
  $var1_Recordset1 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT IdCompra, compras.IdOrdencompra, proveedor, IdSolicitante, ordencompra.IdArea, area FROM ((compras inner join proveedores On compras.IdProveedor=proveedores.IdProveedor) inner join ordencompra on compras.IdOrdencompra=ordencompra.IdOrdencompra) inner join areas on ordencompra.IdArea=areas.IdArea WHERE compras.recibido is null and IdSolicitante=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php 
include('encabezado.php');
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center" style="width: 935px">
	<h4 align="center" class="Century" style="margin: 0">RECIBO Y EVALUACION DE ORDENES DE COMPRA</h4>
  <h5 align="center" class="Century" style="margin: 0">ORDENES DE COMPRA PENDIENTE POR RECIBIR Y EVALUAR</h5>
</div>
<BR>
<div class="contenedor" style="width: 700px">
  <?php 
  if($totalRows_Recordset1>0){   
		?>
		<table width="100%" border="1" class="tablita Arial14">
			<tbody>
				<tr class="titulos" >
					<td align="center" width="40px">No OC</td>
					<td align="center" width="40px">No SC</td>
					<td align="center" >PROVEEDOR</td>
					<td align="center" >AREA/PROYECTO</td>
					<td align="center" width="65px"></td>
					</tr>
					<?php 
					do{
						?>
						<tr>
							<td><?php echo $row_Recordset1['IdCompra']; ?></td>
							<td><?php echo $row_Recordset1['IdOrdencompra']; ?></td>
							<td><?php echo $row_Recordset1['proveedor'] ?></td>
							<td><?php echo $row_Recordset1['area'] ?></td>
							<td align="center">
								<a href="recibir1.php?orden=<?php echo $row_Recordset1['IdCompra'] ?>" class="btn btn-rosa btn-block btn-xs1">RECIBIR</a>
							</td>
						</tr>
						<?php                
					}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
					$rows = mysql_num_rows($Recordset1);
					if($rows > 0) {
						mysql_data_seek($Recordset1, 0);
						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
					}
					?>
			</tbody> 
		</table>
  <br>
  <?php
  }else{
		 echo "<h5 align='center' class='Century'>NO HAY ORDENES DE COMPRA POR RECIBIR</h5>"; 
  }
  ?>      
</div>  
  
</div>

<?php 
	mysql_close($datos);
?>




</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
