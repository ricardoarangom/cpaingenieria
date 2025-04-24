<?php 
require_once('../connections/datos.php');

$fecha=date("Y-m-d");

$arregloFecha=explode("-",$fecha);

$nuevomes=$arregloFecha[1]-3;
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
$ssnivel=$_SESSION['ssnivel'];


$buscaNot="select * from noticias where fecha>='".$nuevafecha."' order by fecha desc";
$resultado = mysql_query($buscaNot, $datos) or die(mysql_error());
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);




?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>MEDINA &amp; RIVERA</title>

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
<title>MEDINA &amp; RIVERA</title>
</head>
<style>
	
	html{
		min-height: 100%;
	}
	
	body {		

		background-image: url("../imagenes/d1.gif"); 
		background-size: cover;
		background-repeat:no-repeat;
		background-position:bottom; 		
		
	}

	hr {
		margin-bottom: 0;
    margin-top: 0;
    border-top: 1px solid rgb(255,255,255);
	}
	
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
	
	#noticias{
		grid-row-gap:5px;
		max-height: 350px;
		overflow-y: scroll;
		background-color:rgb(0, 0, 63, 0.5);
		color: #FFFFFF;
		margin: 0 58px 0 0;		
	}
	
	#noticias::-webkit-scrollbar {
    -webkit-appearance: none;
	}

	#noticias::-webkit-scrollbar:vertical {
			width:10px;
	}
	
	#noticias::-webkit-scrollbar-button:increment,#noticias::-webkit-scrollbar-button {
    display: none;
	} 
	
	#noticias::-webkit-scrollbar-thumb {
    background-color: rgb(37, 65, 121, 0.5) ;
    border-radius: 20px;
/*    border: 2px solid #eee;*/
	}
	
	
	#medinapp-1{		
		font-family: Century-G-B;
		/* font-weight: bold; */
		font-size: 85px;
		height: 92px;
			
	}
	
	#medinapp-2{		
		font-family: Century-G;
		font-size: 28px;
		height: 37px
	}
	
	#medinapp-3{		
		font-family: Century-G;
		font-size: 11.8px
	}
	
	#pie-pagina{
		width: 100%;
		padding: 0 50px 0 66px;
		color: #ffffff;
		font-family: 'Century-G';
		font-size: 12px;
		position: fixed;
		bottom: 0;
		z-index: 2000;
		padding-bottom: 14px;
		background-color: transparent;			
	}	
			
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

	@media screen and (max-width: 760px) {		
		.sm-menu_bar .sm-bt-menu{
			background-color:transparent;		}

		.nv-sm-menu-se{
			background-color:transparent;			
		}
		
		.nv-sm-menu-se ul li .children{		
			background:transparent;
			border: 0px solid rgba(0, 0, 0, 0.3);			
		}
		
		#medinapp{		
			margin-left: 20px;
			padding-top: 300px;
			padding-bottom: 60px;
		}

		#medinapp-1{		
			font-size: 50px;
			height: 55px
		}
	
		#medinapp-2{		
			font-family: Century-G;
			font-size: 18px;
			height: 25px
		}
		
		#pie-pagina{
			padding: 0 20px 0 0;
		}
	}	

	.parrafo{
/*		display: flex;*/
   	align-items: center;
	}
	
	.parrafo1{  
		line-height: 19px;
		font-size: 14px;
		padding-top: 5px;
	}

	.parrafo2{
		line-height: 11px;
		font-size: 10px;
		text-align: right;
		padding-right: 5px;
		padding-bottom: 7px;
	}
	
	.parrafo3 {
		display: flex;
		align-items: center;
		font-size: 40px;
		padding: 7px 5px 0px 7px;
		margin: 0;
		line-height: 40px;
	}
	
</style>

<body>
	
<?php 
include('supermenu.php')	
?>
<div class="grid columna-6 peq-columna-1" style="grid-column-gap:0px;grid-row-gap:0px;">
	<div id="medinapp" class="span-4 peq-span-1">
		<div id="medinapp-1">
			MEDINAPP
		</div>  
		<div id="medinapp-2">
			Plataforma de Gestión Integral
		</div>  
		<div id="medinapp-3">
			Del grupo organizacional MEDINA & RIVERA INGENIEROS ASOCIADOS SAS
		</div>
	</div>
	<div class="span-2 peq-span-1">
		<?php 
		if($totalRows_resultado>0){
			?>
    	<div class="grid columna-10 Century" id="noticias" style="">
				<?php 
	
					do{
						if($row_resultado['link']){
							$estilo="cursor: pointer;";
							$formula='onClick="abreVinculo(this.id)"';
							$tabla[$row_resultado['IdNoticia']]=$row_resultado['link'];
						}else{
							$estilo="";
							$formula="";
						}
						?>
						<div class="span-1 parrafo3" id="ni-<?php echo  $row_resultado['IdNoticia'] ?>" style="<?php echo $estilo ?>" <?php echo $formula ?>>
							<i class="<?php echo $row_resultado['icono']?>" ></i>
						</div>
						<div class="span-9 parrafo" id="nt-<?php echo  $row_resultado['IdNoticia'] ?>" style="<?php echo $estilo ?>" <?php echo $formula ?>>
							<div class="parrafo1">
								<?php 
								echo $row_resultado['texto'];
								?>
							</div>
							<div class="parrafo2">
								<?php 
								echo "Publicado: ". fechaactual3($row_resultado['fecha'])."<br>";
								?>
							</div>							
						</div>
						<div class="span-10">
							<hr>
						</div>
						<?php
					} while ($row_resultado = mysql_fetch_assoc($resultado));
					if($tabla){
						$cadenatabla=json_encode($tabla);
					}
				?>
    	</div>
		<?php 
		}
		?>
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
	function comprobarAncho(){
		var altoVantana=window.innerHeight;
		var altoContenido=document.documentElement.scrollHeight;
//		console.log(altoContenido)
//		console.log(altoVantana)
		if (altoContenido>altoVantana){
			$('#pie-pagina').css("position","relative");
		}else{
			$('#pie-pagina').css("position","fixed");
		}
		
		var distancia = ((altoVantana-144)/2)-89
		$('#medinapp').css("margin-top",distancia)
		
		var alnot = document.getElementById('noticias').clientHeight;
		
		var distancia2 = ((altoVantana-alnot)/2)-102
		$('#noticias').css("margin-top",distancia2)
		
		console.log(document.getElementById('noticias').clientHeight)
	}
	
	document.addEventListener('DOMContentLoaded', () => {
		comprobarAncho();

			$(window).resize(function() {

				comprobarAncho();

			});
		
	})
	
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
</html>