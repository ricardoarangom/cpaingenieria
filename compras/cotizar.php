<?php require('../connections/datos.php');?>
<?php 
include('encabezado.php');
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
$query_Recordset1 = "Select ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido from ((ordencompra INNER JOIN itemoc ON ordencompra.IdOrdencompra=itemoc.IdOrdencompra) INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea where itemoc.cotizado is null Group By ordencompra.IdOrdencompra";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$var1_Recordset1 = "0";
if (isset($usuario)) {
  $var1_Recordset1 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("Select  ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido  from ((ordencompra left JOIN itemoc ON ordencompra.IdOrdencompra=itemoc.IdOrdencompra) left JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) left JOIN areas ON ordencompra.IdArea=areas.IdArea  where itemoc.cotizado is null and IdSolicitante=%s Group By ordencompra.IdOrdencompra", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

	
<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center">
  <h4 class="Century">SOLICITUDES DE COMPRA PENDIENTES POR COTIZAR</h4>
</div>
<BR>
<div class="container" style="width: 1000px">
  <?php 
  if($totalRows_Recordset1>0){
  ?>
  <table width="100%" class="tablita Arial14" border="1">
    <tbody>
      <tr class="Arial14 titulos" >
        <td width="30">No SC</td>
        <td>AREA/PROYECTO</td>
        <td>FECHA</td>
        <td></td>
        </tr>
      <?php 
        do{
        ?>
        <tr>
          <td align="right"><?php echo $row_Recordset1['IdOrdencompra']; ?></td>
          <td><?php echo $row_Recordset1['area']; ?></td>
          <td align="center"><?php echo $row_Recordset1['fsolicitud']; ?></td>
          <td align="center">
            <a href="cotizar2.php?orden=<?php echo $row_Recordset1['IdOrdencompra'] ?>" class="btn btn-rosa btn-xs1">COTIZAR</a></td>
          </tr>
        <?php 
        }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
        ?>
      
      </tbody>
    </table>
  <br><br>
  <?php 
  }else{
         echo "<h5 align='center'>NO HAY SOLICITUDES DE COMPRA POR COTIZAR</h5>"; 
        }
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
