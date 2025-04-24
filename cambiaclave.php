<?php require_once('connections/datos.php'); ?>
<?php 
session_start();
if(!isset($_SESSION['IdUsuario'])){
	header("location:index.php");
}
$nivel=$_SESSION['nivel'];
$usuario=$_SESSION['IdUsuario'];
$snivel=$_SESSION['snivel'];
$ssnivel=$_SESSION['ssnivel'];
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<script language="JavaScript" type="text/javascript">

function Valida(form)
{ 
   if (form.clave1.value == "")
   {
      alert("Debes escribir la nueva clave");
      form.clave1.focus();
	  return false;
      
   }   
   if (form.clave2.value == "")
   {
      alert("Debes volver a escribir la nueva clave");
      form.clave2.focus();
	  return false;
      
   }
   if (form.clave2.value==form.clave1.value)
   {
	   form.submit();
   }else{
	   alert("Las dos claves son diferentes");
	   form.clave2.value="";
	   form.clave1.focus();
	   return false;   
		 
   }
   
}
//-->
</script>


<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php require_once('funciones.php');?> 	
	 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>MEDINA &amp; RIVERA</title>
<link rel="icon" href="imagenes/icono.png">
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="imagenes/iconos/styles.css">	
<link rel="stylesheet" href="css/stylefonts.css">

	
<link rel="stylesheet" href="css/frameworkra.css">
<script src="js/jquery.min.js"></script>
<script type="text/javascript" language="JavaScript" src="js/ajax.js"></script>
<script src="js/sweetalert2.all.js"></script>
	
<style>
	html{
		min-height: 100%;
	}
	
	body {		

		background-image: url("imagenes/fondo.jpeg"); 
		background-size: contain;
		background-size: cover;
		background-repeat:no-repeat; 		
		
	}

	#sm-div-logo{
		background-color:transparent;
	}

	
	#clave1, #clave2 {
		padding-left: 8px;
		color: #000000;
		font-family: 'Century-G'
		
	}

	
	#clave1, #clave2, #button, #button2{
		border-color: rgb(0, 176, 240)
	}

	

	.h4 { 
		font-size: calc(1 em + 1 vw); 
	}
	h6 {
		font-family: 'Arial';
		font-weight: bold;
		
	}
	
	#pie-pagina{
		width: 100%;
		padding: 0 50px 0 66px;
		color:#ffffff;
		font-family: 'Century-G';
		font-size: 12px;
		position: fixed;
		bottom: 0;
		z-index:2000;
		padding-bottom: 14px;
		background-color:transparent;			
	}	

	#pie-pagina-2{
		text-align: right;
	}
	
	
	@media screen and (max-width: 760px) {			
		#pie-pagina{
			padding: 0 0 0 0;
			text-align: center;
		}

		#pie-pagina-2{
			text-align: center;
		}
	}
	
</style>
</head> 
<body> 
<!-- <div id="sm-div-logo">
	<img src="imagenes/logofa.png" class="img-fluid" alt="Responsive image" width="260">
</div> -->
<?php 
if(isset($_POST['button'])){
   
  $clavecifrada=password_hash($_POST['clave1'],PASSWORD_DEFAULT);	
  $edita="UPDATE usuarios SET clave='".$clavecifrada."' WHERE IdUsuario=".$_POST['IdUsuario']."";
  //mysql_query($edita,$datos);
  if ($results=@mysql_query($edita)){ 
    ?>	
		<script>
			swal({
				//title: "Error al subir el archivo",
				text: "¡LA CLAVE FUE CAMBIADA!",
				type: "success",
				showConfirmButton: true,
				confirmButtonText: "¡Cerrar!"
				}).then(function(result){
					if (result.value) {
						window.location = "inicio/inicio.php"
					}
				});
	
		</script>
    <?php
  }else{ ?>
    <script>
			swal({
				//title: "Error al subir el archivo",
				text: "¡LA CLAVE NO FUE CAMBIADA!",
				type: "success",
				showConfirmButton: true,
				confirmButtonText: "¡Cerrar!"
				}).then(function(result){
					if (result.value) {
						window.location = "inicio/inicio.php"
					}
				});
	
		</script>
	<?php
  }  
}else{
  ?>
  <div class="contenedor" align="center" style="max-width: 350px;color: #ffffff" id="bloque">
		<h6 align="center" style="background-color: #84BE3F;padding: 5px;border-radius: 10px;color: #ffffff">CAMBIO DE CLAVE</h6>
    <form action="cambiaclave.php" method="post" name="form1">
      <table width="100%" height="106" border="0" cellspacing="0" style="color: #000">
				<col width="50%">
				<col width="50%">
        <tr>
          <td>Nueva Clave</td>
          <td><input name="clave1" type="password" class="campo-sm" id="clave1" required="required"/></td>
          </tr>
        <tr>
          <td>Repita la Nueva Clave</td>
          <td><input name="clave2" type="password" class="campo-sm" id="clave2" required="required"/></td>
          </tr>
        <tr>
          <td colspan="2" align="center">
            <input name="IdUsuario" type="hidden" value="<?php echo $_GET['Id'] ?>" />
            <br>
            <button type="submit" name="button" id="button" class="btn btn-rosa btn-sm" onClick="Valida(this.form)"  >Cambiar</button>
            </td>
          </tr>
        </table>
     </form>
     <?php
      if(isset($_GET['a'])){
      ?>	
        <br><strong><span class="Arial18">LAS CLAVES NO COINCIDEN</span></strong><br><br>
      <?php	
     }
     ?>
  </div>
  <?php  
}
?>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
	
<script>
	function comprobarAncho(){
		var altoVantana=window.innerHeight;
		var altoContenido=document.documentElement.scrollHeight;
		console.log(altoContenido)
		console.log(altoVantana)
		if (altoContenido>altoVantana){
			$('#pie-pagina').css("position","relative");
		}else{
			$('#pie-pagina').css("position","fixed");
		}
		
		var distancia = ((altoVantana)/2)-159
		$('#bloque').css("margin-top",distancia)
	}
	
	document.addEventListener('DOMContentLoaded', () => {
		comprobarAncho();

			$(window).resize(function() {

				comprobarAncho();

			});
		
	})
</script>
<div id="pie-pagina" class="grid columna-2 med-columna-1">
	<div class="span-1" style="padding: 14px 0 0 0" id="pie-pagina-1">
		
	</div>
	<div class="span-1" id="pie-pagina-2">
		<img src="imagenes/Iconosblanco.png" height="50px" alt="">
	</div>	
</div>
</body>
</html>