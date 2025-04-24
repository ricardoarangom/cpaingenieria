<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link href="ccs/fuentes.css" rel="stylesheet" type="text/css">
<link href="ccs/estilo.css" rel="stylesheet" type="text/css">

<?php require_once('funciones.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>

</head>
<body>

<?php 
     session_start(); 
     session_destroy(); 
	   header("location:index.php");
   ?>    
</table>
</body>
</html>
