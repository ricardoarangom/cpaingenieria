<?php 

require_once('../connections/datos.php');

$fecha=date("Y-m-d");

$arregloFecha=explode("-",$fecha);

$nuevomes=$arregloFecha[1]-1;
$nuevoano=$arregloFecha[0];
$nuevodia=$arregloFecha[2];

if($nuevomes<1){
	$nuevomes=$nuevomes+12;
	$nuevoano=$arregloFecha[0]-1;
}

if(($nuevomes==4 or $nuevomes==6 or $nuevomes==9 or $nuevomes==11) and $nuevodia>30){
	$nuevodia=30;
}

if($nuevomes==2 and $nuevodia>28){
	$nuevodia=28;
}

$nuevafecha=$nuevoano."-".sprintf("%02d",$nuevomes)."-".sprintf("%02d",$nuevodia);


session_start();
if(!isset($_SESSION['IdUsuario'])){
	header("location:../index.php");
}
$nivel=$_SESSION['nivel'];
$usuario=$_SESSION['IdUsuario'];
$snivel=$_SESSION['snivel'];




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
	

<script src="../js/sweetalert2.all.js"></script>
<script type="text/javascript" language="JavaScript" src="../js/ajax.js"></script>  
<?php 
require_once('../funciones.php');
?>
<meta charset="utf-8">
</head>
<style>
	
	body{
		/* background-color:#000000; */
	}

	hr {
		margin-bottom: 0;
    margin-top: 0;
    border-top: 1px solid rgb(255,255,255);
	}
	
/* 
	#sm-div-logo{
		background-color:transparent;
	}

	#sm-cabecera{
		background-color:transparent;
	}
	#medinapp{		
		color: #FFFFFF;
		margin-left: 66px;
	}
*/
	
	
	
	
			
/* 
	.nv-sm-menu{		
		background-color:transparent;		
	}
	
	.hd-sm-menu{
		width: 100%;
		background-color:transparent;	
	}
	
	#relleno-sm{
		background-color:transparent;
	}
	
	.a-sec-ch{
		color: #ffffff;
	}

	.a-sec-ch:hover, .a-sec-ch:focus{
		color: #ffffff;
	}
	.nv-sm-menu-se ul li .children{		
		background:#00003F;
		border: 0px solid rgba(0, 0, 0, 0.3);			
	}

	.nv-sm-menu-se ul li .children li:hover{
		background-color:rgb(37,65,121,0.8)	
	}
*/

	@media screen and (max-width: 760px) {		
/* 
		.sm-menu_bar .sm-bt-menu{
			background-color:transparent;		}

		.nv-sm-menu-se{
			background-color:transparent;			
		}
		
		.nv-sm-menu-se ul li .children{		
			background:transparent;
			border: 0px solid rgba(0, 0, 0, 0.3);			
		}
*/
		
		
	}	


	

	
</style>

<body>
	
<?php 
include('supermenu.php')	
?>

<br><br>
<div class="contenedor grid columna-6 peq-columna-1" style="grid-column-gap:0px;grid-row-gap:0px;">
	<div class="span-6 peq-span-1">
		<h5 align="center" class="Century" style="font-size:25px">BIENVENIDO</h5>
		<h5 align="center" class="Century" style="font-size:25px"><?php echo $_SESSION['nombreusuario'] ?></h5>
	</div>
	
</div>


<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/funciones.js"></script>
<script>
	$(function () {
			$('[data-toggle="popover"]').popover()
	})
</script>
<script src="../js/supermenu.js"></script>
<script>
	
	function visibilizarSuperMenu(menu){
		var navegadores = document.querySelectorAll('.navegadores');
		for(var i=0;i<navegadores.length;i++){
			document.getElementById(navegadores[i].id).style.display='none';
		}
		document.getElementById('bt-'+menu).style.display='';
		document.getElementById('nv-'+menu).style.display='';
		if(menuVisible ==1){
				$('#nv-1').animate({
					left:'0'
				});
				menuVisible[1] = 0;
			}else{
				menuVisible[1] = 1;
				$('#nv-1').animate({
					left:'-100%'
				});
			}
			document.getElementById('relleno-sm').style.display='none';
	}
	
	function abreVinculo(id){
		
		var tabla = '<?php echo $cadenatabla ?>';
		var arreglotabla=JSON.parse(tabla);
		var arregloId=id.split("-");
		window.open(arreglotabla[arregloId[1]], '_blank');
		
	}
</script>
</body>
</html>