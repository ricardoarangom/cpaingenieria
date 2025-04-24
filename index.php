<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
<meta charset="utf-8">
<title>CPA INGENIERIA</title>
<link rel="icon" href="imagenes/icono.png">
<link rel="stylesheet" href="css/bootstrap.min.css">	
<link rel="stylesheet" href="imagenes/iconos/styles.css">	
<link rel="stylesheet" href="css/stylefonts.css">	
<link rel="stylesheet" href="css/frameworkra.css">

</head>

<script>
	function olvido(){
		$('#olvido1').modal({backdrop: 'static', keyboard: false});
	}
</script>
<style>

body {		

	background-image: url("imagenes/fondo.jpeg"); 
	background-size: contain;
	background-size: cover;
	background-repeat:no-repeat; 
	/* background-position:bottom; 		 */

}

	#usuario, #clave {
		padding-left: 25px;
		color: #000000;
		font-family: 'Century-G'
		
	}

	#usuario::placeholder, #clave::placeholder { 
		color: #000000;
		font-family: 'Century-G'
	}
	

	h6 {
		font-family: 'Arial';
		font-weight: bold;
		
	}
		
	
</style>
<body>
<div class="contenedor" >
	<!-- <img src="imagenes/logofasf.png" class="img-fluid" alt="Responsive image" width="260"> -->
</div>
<br><br>
<br><br>
<br><br><br><br><br>
<div class="contenedor" style="max-width: 300px" id="bloque">
	<h6 align="center" style="background-color: #84BE3F;padding: 5px;border-radius: 10px;color: #ffffff">DIGITE SU USUARIO Y CLAVE</h6>	
	<form action="validausuario.php" method="post" class="">
		<div class="grid columna-2 med-columna-1 peq-columna-1" style="grid-row-gap:10px;">
			<div class="span-2 med-span-1 peq-span-1">
				<input name="usuario" type="text" class="campo-sm" id="usuario" placeholder="USUARIO">
			</div>
			<div class="span-2 med-span-1 peq-span-1">
				<input name="clave" type="password" class="campo-sm" id="clave" placeholder="CONTRASEÑA">
			</div>
			<div class="span-1">
				<input name="button" type="submit" class="btn btn-rosa btn-sm btn-block" id="button" value="INGRESAR">
			</div>
			<div class="span-1">
				<input name="button2" type="submit" class="btn btn-rosa btn-sm btn-block" id="button2" value="CAMBIAR CLAVE">
			</div>
			<div class="span-2" align="center">
				<button type="button" class="btn btn-gris btn-xs1" onClick="olvido()">Olvide mi contraseña</button>
			</div>
		</div>
		<div class="form-block mb-2">	

		</div>
		<div class="form-block mb-2">

		</div>
		<div class="form-row">
			<div align="center" class="col-md-6 col-sm-12 mb-2">

			</div>
			<div align="center" class="col-md-6 col-sm-12 mb-2">

			</div>
		</div>
	</form>

</div>

<div id="olvido1" class="modal fade" role="dialog" >
  <div class="modal-dialog">    
    <div class="modal-content">
      <form method="post" id="formulario" name="formulario" action="solicitaclave.php">
        <div class="modal-body">
					<div class="container" style="width: 300px" align="center">
						<h6>Ingrese el correo registrado</h6>
						<input type="email" name="correo" id="correo" class="campo-sm">
						<input type="hidden" id="contrato" >
					</div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="boton" class="btn btn-rosa btn-sm">Solicitar Contraseña</button>
          <button type="button" class="btn btn-gris btn-sm pull-left" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
	


</body>
</html>