<?php require('../connections/datos.php');?>
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
$query_Recordset1 = "SELECT ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido FROM ((ordencompra INNER JOIN compras ON ordencompra.IdOrdencompra=compras.IdOrdencompra) INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea WHERE compras.comprado is null GROUP BY ordencompra.IdOrdencompra";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php 
include ('encabezado.php')
?>
</head> 
<body>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center">
  <h4>SOLICITUDES DE COMPRA PENDIENTES POR COMPRAR</h4>
</div>
<BR>
<div class="container" style="width: 800px">
  <?php 
  if($totalRows_Recordset1>0){
  ?>
  <table width="100%" border="1">
    <tbody>
      <tr class="Arial14" >
        <td align="center" width="30" bgcolor="#d8d8d8">No SC</td>
        <td align="center" bgcolor="#d8d8d8">SOLICITANTE</td>
        <td align="center" bgcolor="#d8d8d8">AREA</td>
        <td align="center" bgcolor="#d8d8d8">FECHA</td>
        <td align="center" bgcolor="#d8d8d8">&nbsp;</td>
        </tr>
      <?php 
        do{
        ?>
        <tr>
          <td align="right"><?php echo $row_Recordset1['IdOrdencompra']; ?>&nbsp;</td>
          <td>&nbsp;<?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido']; ?></td>
          <td>&nbsp;<?php echo $row_Recordset1['area']; ?></td>
          <td align="center"><?php echo $row_Recordset1['fsolicitud']; ?></td>
          <td align="center">
            <a href="confcrecompra.php?orden=<?php echo $row_Recordset1['IdOrdencompra']?>&comprar=1" class="btn btn-verde btn-xs1">COMPRAR</a>&nbsp;</td>
          </tr>
        <?php 
        }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
        ?>
      
      </tbody>
    </table>
  <?php 
  }else{
		echo "<h5 align='center'>NO HAY SOLICITUDES DE COMPRA POR COMPRAR</h5>"; 
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
?>
