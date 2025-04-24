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
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>CPA INGENIERIA</title>

<link rel="shortcut icon" href="../imagenes/icono.png">
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../imagenes/iconos/styles.css">
<link rel="stylesheet" href="../css/stylefonts.css">
<link rel="stylesheet" href="../css/frameworkra.css">
	
<script src="../js/jquery.min.js"></script>
<script src="../js/sweetalert2.all.js"></script>
<script type="text/javascript" language="JavaScript" src="../js/ajax.js"></script>
	
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/funciones.js"></script>

<?php 
require_once('../funciones.php');

?>





