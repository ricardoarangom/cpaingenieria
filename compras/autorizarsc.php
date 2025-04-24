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
$query_Recordset1 = "SELECT ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido  FROM (((ordencompra INNER JOIN itemoc ON ordencompra.IdOrdencompra=itemoc.IdOrdencompra) INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea) INNER join empresas on ordencompra.IdEmpresa=empresas.IdEmpresa  WHERE ordencompra.fcierre is not null AND ordencompra.fautorizado is null  GROUP BY ordencompra.IdOrdencompra";
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
  <h4 class="Century24">SOLICITUDES DE COMPRA PENDIENTES POR AUTORIZAR</h4>
</div>
<br />
  <?php //echo $usuario  ?>
<div class="container" style="width: 1000px">
  <?php 
  if($totalRows_Recordset1>0){
  ?>
  <table width="100%" border="1" class="tablita Arial13">
    <tbody>
      <tr class="Arial14 titulos" >
        <td align="center">No SC</td>
        <td align="center">SOLICITANTE</td>
        <td align="center">AREA</td>
        <td align="center">FECHA</td>
        <td align="center"></td>
        </tr>
      <?php 
        do{
        ?>
        <tr>
          <td align="right"><?php echo $row_Recordset1['IdOrdencompra']; ?></td>
          <td><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido']; ?></td>
          <td><?php echo $row_Recordset1['area']; ?></td>
          <td align="center"><?php echo $row_Recordset1['fsolicitud']; ?></td>
          <td align="center">
            <a href="autorizarsc1.php?orden=<?php echo $row_Recordset1['IdOrdencompra'] ?>" class="btn btn-rosa btn-xs1">AUTORIZAR</a>
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
      <h5>NO HAY SOLICITUDES DE COMPRA POR AUTORIZAR</h5>
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
