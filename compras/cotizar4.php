<?php require_once('../connections/datos.php'); ?>
<?php 

$ordenc=$_GET['orden'];
$cargo=$_GET['cargo'];
$funcionario=$_GET['funcionario'];
$correof=$_GET['correof'];
$cedulaf=$_GET['cedulaf'];
$cexamen=$_GET['cexamen'];
$fexa=$_GET['fexa'];
$hexa=$_GET['hexa']
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
$query_Recordset1 = sprintf("Select  ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido from (ordencompra  INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea where IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($ordenc)) {
  $var1_Recordset2 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT * FROM itemoc LEFT JOIN rubros ON itemoc.IdRubro=rubros.IdRubro WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT * FROM rubros";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdProveedor, proveedor FROM proveedores WHERE IdSegmento=7";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><!-- InstanceBegin template="/Templates/plantillacomp.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

	 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>CPA INGENIERIA</title>
<!-- InstanceEndEditable -->
<link rel="shortcut icon" href="../imagenes/icono.png">
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../imagenes/iconos/styles.css" />
<link rel="stylesheet" href="../css/stylefonts.css">

<link rel="stylesheet" href="../css/frameworkra.css" />	
	
<?php 
require_once('../funciones.php');
?>
<?php
session_start(); 
if(!isset($_SESSION['IdUsuario'])){
	header("location:../index.php");
}
  	
$nivel=$_SESSION['nivel'];
$usuario=$_SESSION['IdUsuario'];
$snivel=$_SESSION['snivel'];
$ssnivel=$_SESSION['ssnivel'];

$carpeta=getcwd();
$findme   = '\\';
$findme1   = '/';

$pos = strpos($carpeta,$findme);
$pos1 = strpos($carpeta,$findme1);

if($pos === false){

}else{
	$carpeta1=explode("\\",$carpeta);
}
if($pos1 === false){
	
}else{
	$carpeta1=explode("/",$carpeta);
}
$carpeta2=$carpeta1[count($carpeta1)-1];
?> 
<!-- InstanceBeginEditable name="head" -->
<?php require_once('../funciones.php');?> 	
<script language="JavaScript" type="text/javascript">
  function precios(valor){
    window.open('preciosips.php?proveedor='+valor,'','width=520,height=420, scrollbars=yes, resizable=yes, top=25, left=100');
  }
  function bloquear(id){
  document.getElementById(id).style.display='none'
  $(".espera").html(`
  		<center>
        <img src="../imagenes/status.gif" id="status" />
        <br>
      </center>
							`);
} 
</script>  
<style>
	.titulos {
		background: rgb(43,75,140);
		color: #FFFFFF;
		text-align: center;
		border-bottom-color: #ffffff;
		border-top-color: #ffffff;
		border-right-color: #ffffff;
		border-left-color: #ffffff;
	}
</style>
<!-- InstanceEndEditable -->
</head> 
<body>

<?php 
include('../inicio/supermenu.php');	
?>
<div>
<br>	
<!-- InstanceBeginEditable name="EditRegion3" --> 
 

  
<div class="container" align="center">
<h4 class="Century">ASIGNAR PROVEEDOR Y PRECIOS SOLICITUD DE COMPRA No <?php echo $ordenc ?></h4> 
<br><br>
</div>
<div class="container" style="width: 1000px">
 <div class="row">
  <div class="col-2">
   PROYECTO/AREA 
  </div>
  <div class="col-4">
    <strong><?php echo $row_Recordset1['area'] ?></strong> 
    </div>
  <div class="col-3">
    FECHA DE SOLICITUD 
  </div>
  <div class="col-3">
   <strong><?php echo fechaactual3($row_Recordset1['fsolicitud']) ?></strong>
  </div>
 </div>
  <br><br>
 <form action="graba.php" method="post" onSubmit="bloquear('boton')">
   <div class="row">
    <div class="col-2">
     SOLICITANTE
    </div>
    <div class="col-3">
     <strong><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido'] ?></strong>
    </div>
    <div class="col-3">SELECCIONE EL PROVEEDOR</div>
    <div class="col-4">
      <select name="proveedor" id="" required="required" class="campo-sm Arial12" onChange="precios(this.value)">
        <option value=''>Seleccione</option>
        <?php
        do {  
        ?>
          <option value="<?php echo $row_Recordset4['IdProveedor']?>"><?php echo $row_Recordset4['proveedor']?></option>
        <?php
        } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
        $rows = mysql_num_rows($Recordset4);
        if($rows > 0) {
          mysql_data_seek($Recordset4, 0);
          $row_Recordset4 = mysql_fetch_assoc($Recordset4);
        }
        ?>
      </select>
      <a class="btn btn-azul btn-xs1" href="regflashproveedores.php" role="button" target="_blank">Agregar Proveedor</a>
    </div>
   </div>
   <br>
   <table width="100%" border="1" class="tablita Arial12">
    <tbody>
      <tr class="titulos">
        <td width="300">PRODUCTO O SERVICIO</td>
        <td width="70">UND.</td>
        <td width="70">CANT.</td>
        <td width="150">FECHA PARA LA CUAL SE REQUIERE</td>
        <td width="300">OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD </td>
        <td>PRECIO</td>
        
      </tr>
      <?php 
      do{
      ?>
      <tr>
        <td><?php echo $row_Recordset2['producto']; ?></td>
        <td align="center"><?php echo $row_Recordset2['unidad']; ?></td>
        <td align="right"><?php echo number_format($row_Recordset2['cantidad'],0); ?></td>
        <td align="center"><?php echo $row_Recordset2['frequerido']; ?></td>
        <td><?php echo $row_Recordset2['especificacion']; ?></td>
        <td align="center">
        <input type="text" class="campo-xs"  name="precio[<?php echo $row_Recordset2['IdItem']; ?>]" style="width: 80px" required="required">
        <input type="hidden" name="id[<?php echo $row_Recordset2['IdItem']; ?>]" value="<?php echo $row_Recordset2['IdItem']; ?>">  
        </td>
        
      </tr>
      <?php 
      }while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
      ?>
    </tbody>
   </table>
   <br>
   <input type="hidden" name="orden" value="<?php echo $ordenc?>" />
   <div class="container" align="center">
     <input type="hidden" name="cargo" value="<?php echo $cargo ?>">
     <input type="hidden" name="funcionario" value="<?php echo $funcionario ?>">
     <input type="hidden" name="correof" value="<?php echo $correof ?>">
     <input type="hidden" name="cedulaf" value="<?php echo $cedulaf ?>">
     <input type="hidden" name="cexamen" value="<?php echo $cexamen ?>">
     <input type="hidden" name="fexa" value="<?php echo $fexa ?>">
     <input type="hidden" name="hexa" value="<?php echo $hexa ?>">
     <button type="submit" name="boton9" id="boton" class="btn btn-azul btn-sm">GRABAR</button>
     <div class="espera"></div>
   </div>
  </form>
</div> 
<br>

<!-- InstanceEndEditable -->
</div>
<!-- InstanceBeginEditable name="EditRegion4" -->

 

<!-- InstanceEndEditable -->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/funciones.js"></script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
<?php 
	mysql_close($datos);
?>
<script src="../js/supermenu.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', () => {
		var carpeta = '<?php echo $carpeta2 ?>';
		console.log(carpeta);
		comprobarAncho();
		$(window).resize(function() {
			comprobarAncho();
		});
		
	})
</script>
<div id="pie-pagina" class="grid columna-2 med-columna-1">
	<div class="span-1" style="padding: 14px 0 0 0" id="pie-pagina-1">
		<table align="left">
			<tr>
				<td style="padding: 0;height: 16px">USUARIO:</td>
			</tr>
			<tr>
				<td style="padding: 0;height: 16px"><?php echo $_SESSION['nombreusuario'] ?></td>
			</tr>
		</table>
	</div>
	<div class="span-1" id="pie-pagina-2">
		<img src="../imagenes/Iconosblanco.png" height="50px" alt="">
	</div>	
</div>

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
