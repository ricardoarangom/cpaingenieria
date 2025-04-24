<?php require_once('../connections/datos.php'); ?>
<?php 
$minrequ=(strtotime ( '+'.(10).' day' , strtotime ( date("Y-m-d")  )));
$minrequ=date("Y-m-d",$minrequ);

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
if (isset($_GET['oc'])) {
  $var1_Recordset1 = $_GET['oc'];
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT IdOrdencompra, IdSolicitante, ordencompra.IdArea, ordencompra.IdEmpresa, fsolicitud, area, concat(nombre,' ',apellido) as solicitante, critico FROM (ordencompra inner join areas on ordencompra.IdArea=areas.IdArea) inner join usuarios on ordencompra.IdSolicitante=usuarios.IdUsuario WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($_GET['oc'])) {
  $var1_Recordset2 = $_GET['oc'];
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT IdItem, IdOrdencompra, PS, producto, especificacion, unidad, cantidad, frequerido, clase FROM itemoc LEFT JOIN clasesisc on itemoc.IdCalse=clasesisc.IdClase WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<?php 
include('encabezado.php');
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center" style="width: 1100px">
  <?php 
  include('encabsolcomp.html');
  ?>
  <br><br>
</div>
<form method="post" action="consulsc1.php" name="form1">  
  <div class="container" style="width: 1100px;" >
    <div>
      <div class="row" >
        <div class="col-3">
          PROYECTO/AREA 
          </div>
        <div class="col-6">
          <strong><?php echo $row_Recordset1['area'] ?></strong>  
          </div>
        <div class="col-1"><strong>SC No</strong></div>
        <div class="col-2"><strong><?php echo $row_Recordset1['IdOrdencompra'] ?></strong></div>
        </div>
      <br>
      <div class="row">
        <div class="col-3">
          FECHA DE SOLICITUD 
          </div>
        <div class="col-3">
          <strong><?php echo fechaactual3($row_Recordset1['fsolicitud']) ?></strong>
          </div>
        </div>
      <br>
      <div class="row">
        <div class="col-3">
          SOLICITANTE
         </div>
        	<div class="col-5">
          	<strong><?php echo $row_Recordset1['solicitante'] ?></strong>
          </div>
					<div class="col-4">
						CRITICO <?php echo ($row_Recordset1['critico']==1) ? "<strong>SI</strong>" : "<strong>NO</strong>"?>					
					</div>
			</div>
				
      </div>
    <br>
    <table width="1070" border="1" class="Arial12" id="productos">
      <tbody>
        <col width="30">
				<col width="210">
				<col width="70">
				<col width="70">
				<col width="180">
				<col width="90">
				<col width="250">
				<col width="55">
				<col width="55">
      <tr class="titulos">
        <td align="center">&nbsp;No.&nbsp;</td>
        <td align="center">&nbsp;PRODUCTO O SERVICIO&nbsp;</td>
        <td align="center">&nbsp;UND.&nbsp;</td>
        <td align="center">&nbsp;CANT.&nbsp;</td>
				<td align="center">&nbsp;CLASE&nbsp;</td>
        <td align="center">&nbsp;FECHA PARA LA CUAL SE REQUIERE&nbsp;</td>
        <td align="center">&nbsp;OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD &nbsp;</td>
        <td align="center">&nbsp;PROD&nbsp;</td>
        <td align="center">&nbsp;SERV&nbsp;</td>
        </tr>
      <?php
        $item=1;
        do{
          if($row_Recordset2['PS']==1){
            $servicio="";
            $producto="X";
          }else{
            $servicio="X";
            $producto="";
          }
          ?>
      <tr class="Arial12">
        <td align="center"><?php echo $item ?></td>
        <td style="padding-left: 3px"><?php echo $row_Recordset2['producto'] ?></td>
        <td align="center"><?php echo $row_Recordset2['unidad'] ?></td>
        <td align="right" style="padding-right: 3px"><?php echo $row_Recordset2['cantidad'] ?></td>
				<td style="padding-right: 3px"><?php echo $row_Recordset2['clase'] ?></td>
        <td align="center"><?php echo fechaactual3($row_Recordset2['frequerido']) ?></td>
        <td style="padding-left: 3px"><?php echo $row_Recordset2['especificacion'] ?></td>
        <td align="center"><?php echo $producto ?></td>
        <td align="center"><?php echo $servicio ?></td>
        </tr>
      <?php
          $item++;
        } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
        $rows = mysql_num_rows($Recordset2);
        if($rows > 0) {
            mysql_data_seek($Recordset2, 0);
          $row_Recordset2 = mysql_fetch_assoc($Recordset2);
        }
        ?>
      </tbody>
      </table>
    <br>
    <input type="hidden" name="area" value="<?php echo $row_Recordset1['IdArea']  ?>" />
    <div class="container" align="center">
      <button type="button" name="boton" class="btn btn-rosa btn-sm" onclick="window.close()">Cerrar pestaña</button>
      </div>  
    </div>  
</form> 
<br>
</div>

<?php 
	mysql_close($datos);
					 
	include('footer.php');
?>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
           
?>
