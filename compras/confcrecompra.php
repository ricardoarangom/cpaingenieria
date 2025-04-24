<?php require('../connections/datos.php');?>
<?php 
$ordenc=$_GET['orden'];

//$ordenc=4;

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
$query_Recordset1 = sprintf("SELECT IdCompra, IdOrdencompra, proveedor, email, rut, camcom, certbanc, IdBanco, cuenta, clasecuenta, compras.IdProveedor, fecha, comprado FROM compras inner join proveedores on compras.IdProveedor=proveedores.IdProveedor WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($ordenc)) {
  $var1_Recordset2 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT cotizaciones.precio, iva, IdCompra, cantidad, producto, especificacion, unidad, cotizaciones.IdProveedor, proveedor, cotizaciones.IdOrdencompra, cotizaciones.descuento FROM ((itemcompra INNER JOIN cotizaciones ON itemcompra.IdCotizacion=cotizaciones.IdCotizacion) INNER JOIN itemoc ON cotizaciones.IdItem=itemoc.IdItem) INNER JOIN proveedores ON cotizaciones.IdProveedor=proveedores.IdProveedor WHERE cotizaciones.IdOrdencompra=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset5 = "0";
if (isset($ordenc)) {
  $var1_Recordset5 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset5 = sprintf("SELECT producto, unidad, cantidad, observaciones FROM itemoc WHERE derogada=1 AND IdOrdencompra=%s", GetSQLValueString($var1_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
 
?>
<?php 
include ('encabezado.php')
?>

<?php

?> 
<script>

	function muestraCc(valor){
		if(valor==1){
			document.getElementById('ccontrato').style.display='';
		}
		if(valor==0){
			document.getElementById('ccontrato').style.display='none';
		}
	}

</script>
</head> 
<body>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center" style="width: 1000px">
  
  <h4>DOCUMENTOS CORRESPONDIENTES A LA SOLICITUD DE COMPRA No. <?php echo $ordenc?></h4>
  
  <br><br> 
  <?php
if($totalRows_Recordset1>0){
  do{    
  ?>
  <table width="100%" border="0" class="Arial16">
    <col width="600">
    <col width="300">
		<col width="100">
    <tr>
      <td>ORDEN DE COMPRA No.&nbsp;<?php echo $row_Recordset1['IdCompra']?></td>
      
			<?php 
			if(is_null($row_Recordset1['comprado']) ){
				if(($row_Recordset1['email'] and $row_Recordset1['rut'] and $row_Recordset1['certbanc'] and $row_Recordset1['IdBanco']<>0 and $row_Recordset1['cuenta'] and $row_Recordset1['clasecuenta']) or $row_Recordset1['IdProveedor']<=110){
					?>
					<td rowspan="2">
					</td>
					<td rowspan="2" align="right">
						<form action="orcompra-pdf.php" method="post" target="_blank">
							<input type="hidden" name="oc" value="<?php echo $row_Recordset1['IdCompra'] ?>" />
							<button name="boton" type="submit" class="btn btn-verde btn-sm">COMPRAR</button> 
						</form>
					</td>
					<?php
				}else{
					?>
					<td rowspan="2" class="Arial14R" align="center">
						El proveedor no tiene su información y documentación completa.<br>
						<a href="editaprov.php?id=<?php echo  $row_Recordset1['IdProveedor']?>" class="btn btn-rosa btn-xs1">Completar información</a>
					</td>
					<td rowspan="2">
						<button type="button" class="btn btn-gris btn-sm" disabled>COMPRAR</button>
					</td>

					<?php
//							$textoBoton=
				}

			}
			?>
        
		</tr>
    <tr>
      <td valign="top">PROVEEDOR:&nbsp;<?php echo $row_Recordset1['proveedor']?></td>
      </tr>
    </table>    
  <table width="100%" border="1" class="tablita Arial14">
    <col width="300">
    <col width="100">
    <col width="100">
    <col width="100">
    <col width="100">
    <col width="100">
    <col width="100">
    <col width="100">
    <tbody>
      <tr class="titulos">
        <td>PRODUCTO</td>
        <td>CANTIDAD</td>
        <td>PRECIO</td>
        <td>SUB-TOTAL</td>
        <td>DESC.</td>
        <td>TOTAL</td>
        <td>IVA</td>
        <td>TOTAL</td>
        </tr>
      <?php
      $totaloc=0; 
      do{
        if($row_Recordset1['IdCompra']==$row_Recordset2['IdCompra']){
          $subtotal=$row_Recordset2['cantidad']*$row_Recordset2['precio'];
          $subtotalcd=$subtotal*(1-$row_Recordset2['descuento']);
          $total=$subtotalcd*(1+$row_Recordset2['iva']);
      ?>
      <tr>
        <td><?php echo $row_Recordset2['producto']; ?></td>
        <td align="right"><?php echo number_format($row_Recordset2['cantidad'],0); ?></td>
        <td align="right"><?php echo "$ ".number_format($row_Recordset2['precio'],0); ?></td>
        <td align="right"><?php echo "$ ".number_format($subtotal,0) ?></td>
        <td align="right"><?php echo number_format(($row_Recordset2['descuento']*100),0)."%"; ?></td>
        <td align="right"><?php echo "$ ".number_format($subtotalcd,0) ?></td>
        <td align="right"><?php echo number_format(($row_Recordset2['iva']*100),0)."%"; ?></td>
        <td align="right"><?php echo "$ ".number_format($total,0) ?></td>
        </tr>
      <?php
        $totaloc=$totaloc+$total;
        }
      }while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
      $rows = mysql_num_rows($Recordset2);
      if($rows > 0) {
          mysql_data_seek($Recordset2, 0);
        $row_Recordset2 = mysql_fetch_assoc($Recordset2);
      }
      ?>
      <tr>
        <td colspan="2">TOTAL ORDEN DE COMPRA No.&nbsp;<?php echo $row_Recordset1['IdCompra']?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><?php echo "$ ".number_format($totaloc,0) ?></td>
        </tr>
      </tbody>
    </table>
  <br><br>
  <?php 
  }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
}
?>  
  
</div>
<br>
<div class="container Arial16" align="left" style="width: 800px" >
  <?php 
if($totalRows_Recordset5>0){
  do{
    echo "<strong>".number_format($row_Recordset5['cantidad'],0)." ".$row_Recordset5['producto']." no fue(ron) autorizado porque ".$row_Recordset5['observaciones']."</strong><br>";

  }while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
}
?>
</div>
  
</div>

<?php 
include('footer.php')	
?>



</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset5);
?>
