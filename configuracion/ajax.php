<?php require('../connections/datos.php')?>


<?php 

if(($_POST['proced']==1)){
	
	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';

	$buscaArea="SELECT ccostos FROM areas WHERE ccostos='".$_POST['ccostos']."' and IdArea<>".$_POST['IdArea'];
	$resultadoArea = mysql_query($buscaArea, $datos) or die(mysql_error());
	$filaArea = mysql_fetch_assoc($resultadoArea);
	$totalfilasArea = mysql_num_rows($resultadoArea);

	if($totalfilasArea>0){
		echo 'ya';
	}else{
		$actualiza="UPDATE areas SET area='".$_POST['area']."', IdDirector=".$_POST['IdDirector'].", ccostos='".$_POST['ccostos']."' WHERE IdArea=".$_POST['IdArea'];
		if ($results=@mysql_query($actualiza)){
			echo "ok";
		}
	}
	
	
	
}

if(($_POST['proced']==2)){
	
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';

	$buscaArea="SELECT ccostos FROM areas WHERE ccostos='".$_POST['ccostos']."'";
	$resultadoArea = mysql_query($buscaArea, $datos) or die(mysql_error());
  $filaArea = mysql_fetch_assoc($resultadoArea);
  $totalfilasArea = mysql_num_rows($resultadoArea);

	if($totalfilasArea>0){
		echo 'ya';
	}else{
		$inserta="INSERT INTO areas (area, IdDirector, ccostos) VALUES ('".$_POST['area']."', ".$_POST['IdDirector'].", '".$_POST['ccostos']."')";
		if ($results=@mysql_query($inserta)){
			echo "ok";
		}
	}
	
}

if(($_POST['proced']==3)){
	
//		echo '<pre>';
//		print_r($_POST);
//		echo '</pre>';

	if($_POST['nivel']){
		$nivel=$_POST['nivel'];
	}else{
		$nivel=0;
	}
			// IdUsuario, usuario, clave, nombre, apellido, nivel, snivel, activado, correo, cargo, cedula, IdBanco, cuenta		
	$actualiza="UPDATE usuarios SET usuario='".$_POST['usuario']."', nombre='".$_POST['nombre']."', apellido='".$_POST['apellido']."', 	nivel=".$nivel.", activado=".$_POST['activado'].", 	correo='".$_POST['correo']."', cargo='".$_POST['cargo']."', cedula='".$_POST['cedula']."' WHERE IdUsuario=".$_POST['IdUsuario'];
	if ($results=@mysql_query($actualiza)){
		echo "ok";
	}
	
}

if(($_POST['proced']==4)){
	
//		echo '<pre>';
//		print_r($_POST);
//		echo '</pre>';
	
	$clave='$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu';
	if($_POST['nivel']){
	$nivel=$_POST['nivel'];
	}else{
		$nivel=0;
	}
	
	$inserta="INSERT INTO usuarios (usuario, clave, nombre, apellido, nivel, activado, correo, cargo, cedula) value ('".$_POST['usuario']."', '".$clave."', '".$_POST['nombre']."','".$_POST['apellido']."', ".$nivel.", ".$_POST['activado'].", '".$_POST['correo']."','".$_POST['cargo']."', '".$_POST['cedula']."' )";
	if ($results=@mysql_query($inserta)){
		echo "ok";
	}
		
}

if(($_POST['proced']==5)){
	
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';

	$inserta="INSERT INTO clasproveedores (clasificacion) VALUES('". $_POST['clasificacion'] ."')";
	if ($results=@mysql_query($inserta)){
		echo "ok";
	}

}
?>