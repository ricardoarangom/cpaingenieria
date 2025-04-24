<?php require_once('../connections/datos.php'); ?>
<?php 

set_time_limit(0);
require("../smtptester/class.phpmailer.php");

session_start();
$usuario=$_SESSION['IdUsuario'];

$busca5="SELECT nombre, apellido, correo FROM usuarios WHERE IdUsuario=".$usuario."";
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila5 = mysql_fetch_assoc($resultado5);
?>

<?php 
include('encabezado.php');	
?>

<?php 
include('encabezado1.php');	
?>
<?php 
// 	echo "<pre>";
// 	print_r($_POST);
// 	echo "</pre>";
?>
<?php
if(isset($_POST['boton1'])){

//   echo "<pre>";
//   print_r($_POST);
//   echo "</pre>";
	
	$cantGrabados=0;
	foreach($_POST['arreglo'] as $key=>$j){
		
		$texto="UPDATE tablagastos SET ";
		foreach($j as $llave=>$i){
			$texto.=$llave."=".str_replace(",","",$i).", ";
		}
		
		$texto=substr($texto, 0, -2);
		$texto.=" where IdTG=".$key;
				
		if ($results=@mysql_query($texto)){
			$cantGrabados++; 
		}
			
	}
	
	if(count($_POST['arreglo'])==$cantGrabados){
		?>
		<script>
				swal({
						text: "¡La tabla de gasto has sido actualizada con exito!",
						type: "success",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
						if (result.value) {
							window.location = "inicio.php";
						}
					});
		</script>
		<?php
	}
}

if(isset($_POST['boton2'])){

 	//echo "<pre>";
 	//print_r($_POST);
 	//echo "</pre>";
	
	$conValores=0;
	foreach($_POST['arreglo'] as $key=>$j){
		if($j['rubro'] and $j['vunitario']>0){
			$tablaGasto[$conValores]=$_POST['arreglo'][$key];
			$conValores++;
		}
	}
	//echo "<pre>";
 	//print_r($tablaGasto);
 	//echo "</pre>";
	
	if($conValores>0){
		
		$graba="INSERT INTO gviaje (IdSolicitante, IdArea, IdMunicipio, fsalida, fregreso, actividad, beneficiario, cedula, IdBanco, clasecuenta, cuenta, fsolicitud) VALUES(".$_POST['IdSolicitante'].", ".$_POST['IdArea'].", ".$_POST['IdMunicipio'].", '".$_POST['fsalida']."', '".$_POST['fregreso']."', '".$_POST['actividad']."', '".$_POST['beneficiario']."', '".$_POST['cedula']."', ".$_POST['IdBanco'].", ".$_POST['clasecuenta'].", '".$_POST['cuenta']."', '".date("Y-m-d")."')";
		//echo $graba."<br>";
		if ($results=@mysql_query($graba)){
			$last_id = mysql_insert_id($datos);
			
			$nitems=0;
			foreach($tablaGasto as $key=>$j){
				$graba1="INSERT INTO itemgviaje (IdGviaje, rubro, cantidad, vunitario) VALUES(".$last_id.", '".$j['rubro']."', ".$j['cantidad'].", ".str_replace(",","",$j['vunitario']).")";
				//echo $graba1."<br>";
				if ($results=@mysql_query($graba1)){
					$nitems++;
				}				
			}
			
			$texto="<div style='font-size:20px'>¡La solicitud fue grabada con exito!</div><div>Se grabaron ".$nitems." correctamente</div>";
			?>
			<script>
        window.location = "correogv.php?solicitud=<?php echo $last_id ?>&mensaje=<?php echo $texto ?>";
			</script>
			<?php		
		
		}

		if($_FILES['certificacion']['name']<>""){

			$tipo=$_FILES['certificacion']['type'];
			$tamano=$_FILES['certificacion']['size'];
			$fecha1=date("YmdHis");
			$ruta="certificaciones/".$fecha1."-".$last_id."-certificacion.pdf";
	
			move_uploaded_file($_FILES['certificacion']['tmp_name'],$ruta);
	
			$graba2="UPDATE gviaje SET certificacion='".$ruta."' WHERE IdGviaje=".$last_id;
			if ($results=@mysql_query($graba2)){
	
			}
	
		}
		
	}else{
		?>
		<script>
				swal({
						text: "¡No se ingresaron valores de gastos!",
						type: "warning",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
						if (result.value) {
							window.location = "solicitud.php";
						}
					});
		</script>
		<?php
		
	}
}

if(isset($_POST['boton3'])){

	//  echo "<pre>";
	//  print_r($_POST);
	//  echo "</pre>";

	foreach ($_POST['arreglo'] as $key => $j) {
		if($j['cantidad']==0 or $j['vunitario']==0){
		// echo "borrar ".$j['IdItem'];
			$actualizaItem="DELETE FROM itemgviaje WHERE IdItem=".$j['IdItem'];
		}else{
		// echo "grabar ".$j['IdItem'];
			$actualizaItem="UPDATE itemgviaje SET cantidad=".$j['cantidad']." , vunitario=".str_replace(",","",$j['vunitario'])." WHERE IdItem=".$j['IdItem'];
		}
    
		if ($results=@mysql_query($actualizaItem)){
		}else{
      
    }
	}
	$actualiza="UPDATE gviaje SET fautorizacion='".date("Y-m-d")."', rechazada=0, IdAutorizador=".$_POST['autorizador']." WHERE IdGviaje=".$_POST['solicitud'];
  
	if ($results=@mysql_query($actualiza)){
		// echo 'hola';
		?>
		<script>
			 window.location = "correoautor.php?solicitud=<?php echo $_POST['solicitud'] ?>&rechazada=0&cambios=<?php echo $_POST['cambios'] ?>";
		</script>
		<?php
	}
}

if(isset($_POST['boton4'])){

 	// echo "<pre>";
 	// print_r($_POST);
 	// echo "</pre>";

	$actualiza="UPDATE gviaje SET fautorizacion='".date("Y-m-d")."', rechazada=1, IdAutorizador=".$_POST['autorizador'].", motivo='".$_POST['motivo']."' WHERE IdGviaje=".$_POST['solicitud'];
	// echo $actualiza;
	if ($results=@mysql_query($actualiza)){
		?>
		<script>
			window.location = "correoautor.php?solicitud=<?php echo $_POST['solicitud'] ?>&rechazada=1";
		</script>
		<?php
	}
}

if(isset($_POST['boton5'])){

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

	// echo "<pre>";
	// print_r($_FILES);
	// echo "</pre>";

	if($_FILES['soporte']['name']<>""){

    $tipo=$_FILES['soporte']['type'];
    $tamano=$_FILES['soporte']['size'];
    $fecha1=date("YmdHis");
    $ruta="soportes/".$fecha1."-".$_POST['solicitud']."-soporte.pdf";

		move_uploaded_file($_FILES['soporte']['tmp_name'],$ruta);

		$graba="UPDATE gviaje SET fpago='".date("Y-m-d")."', soporte='".$ruta."' WHERE IdGviaje=".$_POST['solicitud'];

	}else{
		$graba="UPDATE gviaje SET fpago='".date("Y-m-d")."' WHERE IdGviaje=".$_POST['solicitud'];
	}

	if ($results=@mysql_query($graba)){
		?>
		<script>
			window.location = "correopago.php?solicitud=<?php echo $_POST['solicitud'] ?>";
		</script>
		<?php
	}
}

if(isset($_POST['boton6'])){

// 	echo "<pre>";
// 	print_r($_POST);
// 	echo "</pre>";
    
  if($_FILES['certificacion']['name']<>""){

    $tipo=$_FILES['certificacion']['type'];
    $tamano=$_FILES['certificacion']['size'];
    $fecha1=date("YmdHis");
    $ruta="certificaciones/".$fecha1."-".$_POST['solicitud']."-certificacion.pdf";

    move_uploaded_file($_FILES['certificacion']['tmp_name'],$ruta);

    $graba2="UPDATE gviaje SET certificacion='".$ruta."', beneficiario='".$_POST['beneficiario']."', cedula='".$_POST['cedula']."', IdBanco=".$_POST['IdBanco'].", clasecuenta=".$_POST['clasecuenta'].", cuenta='".$_POST['cuenta']."' WHERE IdGviaje=".$_POST['solicitud'];
    // echo $graba2;
    if ($results=@mysql_query($graba2)){
    
      ?>
      <script>
          swal({
              text: "¡Solicitud actualizada!",
              type: "success",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
              if (result.value) {
                window.location = "inicio.php";
              }
            });
      </script>
      <?php
    
    }

  }
 
}
?>
</body>
</html>