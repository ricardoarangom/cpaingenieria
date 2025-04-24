<?php require_once('connections/datos.php'); ?>
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
$query_Recordset1 = "SELECT usuarios.usuario, usuarios.clave, usuarios.nivel, usuarios.snivel, usuarios.IdUsuario,  usuarios.nombre, usuarios.apellido FROM usuarios WHERE usuarios.activado=1";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CONSORCIO M&A PROSPERIDAD</title>
  
  
</head>
<link rel="stylesheet" href="css/stylefonts.css">
<link rel="stylesheet" href="css/frameworkra.css">
<script src="js/jquery.min.js"></script>
<script src="js/sweetalert2.all.js"></script>
<body>
<?php 

$login=htmlentities(addslashes($_POST['usuario']));
$password=htmlentities(addslashes($_POST['clave']));
$ok=0;
do{
	if($login==$row_Recordset1['usuario']){
	  if(password_verify($password,$row_Recordset1['clave'])){
	  	$ok=1;
			$nivel=$row_Recordset1['nivel'];
			$snivel=$row_Recordset1['snivel'];
			$IdUsuario=$row_Recordset1['IdUsuario'];
			$nombreusuario=$row_Recordset1['nombre']." ".$row_Recordset1['apellido'];
	  }
	}
}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));

if($ok==1){
	session_start();
	$_SESSION['usuario']=$_POST['usuario'];
  $_SESSION['nivel']=$nivel;
  $_SESSION['snivel']=$snivel;
	$_SESSION['ssnivel']=$ssnivel;
	$_SESSION['IdUsuario']=$IdUsuario;
	$_SESSION['nombreusuario']=$nombreusuario;
	
	if(isset($_POST['button'])){
		header("location:inicio/inicio.php");			  
	}
	if(isset($_POST['button2'])){
		header("location:cambiaclave.php?Id=$IdUsuario");
	}
	
}else{    
    header("location:index.php");
}


?>






</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
