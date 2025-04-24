<?php require_once('../connections/datos.php'); ?>
<?php 

$ordenc=$_GET['orden'];
//$item=$_GET['item'];

//$ordenc=3;
session_start();
 $autor=$_SESSION['IdUsuario'];


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
if (isset($ordenc)) {
  $var1_Recordset1 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("Select  ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido, direnvio, critico from (ordencompra  INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea where IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($ordenc)) {
  $var1_Recordset2 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT * FROM itemoc WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset3 = "0";
if (isset($ordenc)) {
  $var1_Recordset3 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset3 = sprintf("SELECT proveedores.IdProveedor, proveedor FROM proveedores inner join cotizaciones on proveedores.IdProveedor=cotizaciones.IdProveedor WHERE IdOrdencompra=%s GROUP BY proveedores.IdProveedor", GetSQLValueString($var1_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$var1_Recordset4 = "0";
if (isset($ordenc)) {
  $var1_Recordset4 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset4 = sprintf("SELECT proveedor, cotizaciones.precio, iva, cotizacion, cotizaciones.IdItem, cotizaciones.IdProveedor, cotizaciones.IdOrdencompra, cotizaciones.observaciones, IdCotizacion, fpago, descuento, cantidad, producto FROM ((cotizaciones INNER join proveedores On cotizaciones.IdProveedor=proveedores.IdProveedor) INNER JOIN itemoc ON cotizaciones.IdItem=itemoc.IdItem) LEFT join fpago ON cotizaciones.IdFpago=fpago.IdFpago WHERE cotizaciones.IdOrdencompra=%s", GetSQLValueString($var1_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>

<?php 
include('encabezado.php');
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="contenedor" align="center" style="width: 1200px">
  <table width="100%" border="1">
    <tbody>
      <tr>
        <td rowspan="3" width="200"><img src="../imagenes/logo.jpg" width="200" alt=""/></td>
        <td rowspan="3" width="400" align="center"><h4 class="Century24">CUADRO COMPARATIVO DE COTIZACIONES</h4></td>
        <td width="80" align="center"><span class="Arial12">CODIGO</span></td>
        <td width="80" align="center"><span class="Arial12">&nbsp;FC-CO-05</span></td>
        </tr>
      <tr>
        <td align="center"><span class="Arial12">VERSION</span></td>
        <td align="center"><span class="Arial12">01</span></td>
        </tr>
      <tr>
        <td align="center"><span class="Arial12">FECHA</span></td>
        <td align="center"><span class="Arial12">07/01/2020</span></td>
        </tr>
      </tbody>
    </table>
  <br><br>
</div>


  
<div class="contenedor" align="center">
  <h4 class="Century24">SOLICITUD DE COMPRA No <?php echo $ordenc ?></h4> 
  <br>
</div>
<div class="contenedor" style="width: 1200px">
	<div class="grid columna-16">
		<div class="span-3 Century18">
				PROYECTO/AREA 
		</div>
		<div class="span-3" style="font-weight:bold;font-size: 16px">
			<?php echo $row_Recordset1['area'] ?>
		</div>
		<div class="span-3 Century18" align="center" >
			FECHA DE SOLICITUD
		</div>
		<div class="span-2" align="right" style="font-weight:bold;font-size: 16px">
			<?php echo fechaactual3($row_Recordset1['fsolicitud']) ?>
		</div>
		<div class="span-2 Century18" align="right">
			SOLICITANTE
		</div>
		<div class="span-3" align="right">
			<strong><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido'] ?></strong>
		</div>
		<div class="span-3  Century18">
			DIRECCION DE ENVIO
		</div>
		<div class="span-4" style="font-weight:bold;font-size: 16px">
			<?php echo $row_Recordset1['direnvio'] ?>
		</div>
		<div class="span-2 Century18">
			CRITICO
		</div>
		<div class="span-1" style="font-weight:bold;font-size: 16px">
			<?php 
			if($row_Recordset1['critico']==1){
				echo 'SI';
			}else{
				echo 'NO';
			}
			?>
		</div>	
	</div>
  <br>  
  <table width="100%" border="1" class="tablita Arial14">
    <tbody>
      <tr class="titulos">
        <td width="230" align="center">PRODUCTO O SERVICIO</td>
        <td align="center">UND.</td>
        <td align="center">CANT.</td>
        <td align="center">FECHA PARA LA CUAL SE REQUIERE</td>
        <td width="230" align="center" class="Arial12">OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD </td>
        <td align="center">PROD</td>
        <td align="center">SERV</td>
			</tr>
      <?php 
      do{
        if($row_Recordset2['PS']==1){
          $prod="X";
          $serv="";
        }
        if($row_Recordset2['PS']==0){
          $prod="";
          $serv="X";
        }
      ?>
      <tr class="Arial14">
        <td><?php echo $row_Recordset2['producto']; ?></td>
        <td align="center"><?php echo $row_Recordset2['unidad']; ?></td>
        <td align="right"><?php echo $row_Recordset2['cantidad']; ?></td>
        <td align="center"><?php echo $row_Recordset2['frequerido']; ?></td>
        <td><?php echo $row_Recordset2['especificacion']; ?></td>
        <td align="center"><?php echo $prod ?></td>
        <td align="center"><?php echo $serv ?></td>
			</tr>
      <?php 
      }while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
      $rows = mysql_num_rows($Recordset2);
      if($rows > 0) {
				mysql_data_seek($Recordset2, 0);
        $row_Recordset2 = mysql_fetch_assoc($Recordset2);
      }
      ?>
      </tbody>
    </table>
  <br>
</div>
<?php 
$asunto="SOLICITUD DE COMPA NO. ".$ordenc;  
$sql="SELECT nombre, apellido from usuarios WHERE IdUsuario=".$autor."";
$resultado = mysql_query($sql, $datos) or die(mysql_error());
$fila = mysql_fetch_assoc($resultado);  
  
?>  
<div class="contenedor" style="width: 1200px">
  <div class="container" align="center">
    <h5 class="Century20">COTIZACIONES</h5>
    </div>
  <br>
  <?php 
do{ 
  ?>
  
  <table width="100%" border="1" >
    <tbody>
      <tr>
        <td colspan="5" style="padding-left: 3px; padding-right: 2px"><?php echo "<span class='Arial16'><strong>".number_format($row_Recordset2['cantidad'],0)." ".$row_Recordset2['producto']." ".$row_Recordset2['especificacion']."</strong></span>";?></td>
        </tr>
      </tbody>
  </table>
  
  <?php
  
?>
  <table width="100%" border="1" class="tablita Arial12">
    <tbody>
      <tr class="titulos">
        <td width="220" align="center">PROVEEDOR</td>
        <td width="100" align="center">PRECIO</td>
        <td width="100" align="center">SUB TOTAL</td>
        <td width="50" align="center">DESC.</td>
        <td width="100" align="center">TOTAL</td>
        <td width="50" align="center">IVA</td>
        <td width="100" align="center">TOTAL</td>
        <td width="100" align="center">F PAGO</td>
        <td align="center">OBSERVACIONES</td>
        <td width="120" align="center">COTIZACIONES</td>
        </tr>
      <?php
      do{
      ?>  
      
      <?php  
        
      $subtot=$row_Recordset4['precio']*$row_Recordset2['cantidad'];
      $subtotcd=$subtot*(1-$row_Recordset4['descuento']);  
      $totac=$subtotcd*(1+$row_Recordset4['iva']);
      if($row_Recordset2['IdItem']==$row_Recordset4['IdItem']){
      ?>
      <tr>
        <td><?php echo $row_Recordset4['proveedor'] ?></td>
        <td align="right"><?php echo "$&nbsp;".number_format($row_Recordset4['precio'],0) ?></td>
        <td align="right"><?php echo "$&nbsp;".number_format($subtot,0) ?></td>
        <td align="right"><?php echo number_format($row_Recordset4['descuento']*100,0)."%"; ?></td>
        <td align="right"><?php echo "$&nbsp;".number_format($subtotcd,0) ?></td>
        <td align="right"><?php echo number_format($row_Recordset4['iva']*100,0)."%" ?></td>
        <td align="right"><?php echo "$&nbsp;".number_format($totac,0) ?></td>
        <td><?php echo $row_Recordset4['fpago'] ?></td>
        <td align="center"><?php echo $row_Recordset4['observaciones']?></td>
        <td align="center">
          <?php 
            if(($row_Recordset4['cotizacion']=="")){

            }else{
            ?>
          <a href="<?php echo $row_Recordset4['cotizacion'] ?>" target="_blank" class="btn btn-rosa btn-xs1">Ver Cotizacion</a>
          <?php 
            }
            ?>
          </td>
        </tr>
      <?php
        }
      }while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
      $rows = mysql_num_rows($Recordset4);
      if($rows > 0) {
        mysql_data_seek($Recordset4, 0);
        $row_Recordset4 = mysql_fetch_assoc($Recordset4);
      }
    ?>
      </tbody>
  </table>
  
  <br> 
  <?php 
}while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
      $rows = mysql_num_rows($Recordset2);
      if($rows > 0) {
          mysql_data_seek($Recordset2, 0);
        $row_Recordset2 = mysql_fetch_assoc($Recordset2);
      }  
?>
  
  <br>
  <h5 class="Century20" align="center">RESUMEN POR PROVEEDOR</h5>  
  <br>
  <?php 
do{
  ?>
  <table width="720" class="tablita Arial12" align="center">
    <tr>
      <td><strong>PROVEEDOR: <?php echo $row_Recordset3['proveedor'] ?></strong></td>
      </tr>
    </table>
  <table width="720" border="1" class="Arial12" align="center">
    <tr class="titulos">
      <td width="220" align="center">PROVEEDOR</td>
      <td width="100" align="center">PRECIO</td>
      <td width="100" align="center">CANTIDAD</td>
      <td width="100" align="center">SUB TOTAL</td>
      <td width="50" align="center">DESC.</td>
      <td width="50" align="center">IVA</td>
      <td width="100" align="center">TOTAL</td>
      </tr>
    <?php
  $totalprov=0;
  do{
    if($row_Recordset3[IdProveedor]==$row_Recordset4['IdProveedor']){
      $subtot=$row_Recordset4['precio']*$row_Recordset4['cantidad'];
      $totalprod=($subtot*(1-$row_Recordset4['descuento']))*(1+$row_Recordset4['iva']);
      $totalprov=$totalprov+$totalprod;
      ?>
    <tr>
      <td><?php echo $row_Recordset4['producto'] ?></td>
      <td align="right" ><?php echo "$&nbsp;".number_format($row_Recordset4['precio'],0) ?></td>
      <td align="right" ><?php echo number_format($row_Recordset4['cantidad'],0) ?></td></td>
      <td align="right" ><?php echo "$&nbsp;".number_format($subtot,0) ?></td>
      <td align="right" ><?php echo number_format($row_Recordset4['descuento']*100,0)."%"; ?></td>
      <td align="right" ><?php echo number_format($row_Recordset4['iva']*100,0)."%" ?></td>
      <td align="right" ><?php echo "$&nbsp;".number_format($totalprod,0) ?></td>
      </tr>
    <?php
    }
  }while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
    mysql_data_seek($Recordset4, 0);
    $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }   
  ?>
    <tr>
      <td colspan="6" align="center"><strong><?php echo "TOTAL ".$row_Recordset3['proveedor']?></strong></td>
      <td align="right"><strong><?php echo "$&nbsp;".number_format($totalprov,0) ?></strong></td>
      </tr>
    </table>
  <br>
  <?php
}while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
$rows = mysql_num_rows($Recordset3);
if($rows > 0) {
  mysql_data_seek($Recordset3, 0);
  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
}  
?>
  
</div> 
<br>

</div>

<?php 
	mysql_close($datos);

include('footer.php')
?>



</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
