<?php require_once('../connections/datos.php');

if(($_POST['proced']==1)){
	
	$busca="select IdMunicipio, municipio from municipios where IdDepartamento=".$_POST['IdDepartamento'];	
	$resultado = mysql_query($busca, $datos) or die(mysql_error());
	$row_resultado = mysql_fetch_assoc($resultado);

	do{
		$tabla[$row_resultado['IdMunicipio']]=$row_resultado['municipio'];
	}while ($row_resultado = mysql_fetch_assoc($resultado));

	$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);
	
	echo $cadenaTabla;
}

if(($_POST['proced']==2)){
//  echo "<pre>";
//  print_r($_POST);
//  echo "</pre>";
  
  $actualiza="UPDATE gviaje SET fautorizacion='".date("Y-m-d")."', rechazada=1, motivo='ELIMINADA' where IdGviaje=".$_POST['IdGviaje'];
  if ($results=@mysql_query($actualiza)){
   echo 'ok';
  }
}

if(($_POST['proced']==3)){
	//  echo "<pre>";
	//  print_r($_POST);
	//  echo "</pre>";
		
		$actualiza="UPDATE gviaje SET legalizado=1 where IdGviaje=".$_POST['IdGviaje'];
		if ($results=@mysql_query($actualiza)){
		 echo 'ok';
		}
}

if(($_POST['proced']==4)){
	//  echo "<pre>";
	//  print_r($_POST);
	//  echo "</pre>";
		
		$actualiza="UPDATE gviaje SET legalizado=0 where IdGviaje=".$_POST['IdGviaje'];
		if ($results=@mysql_query($actualiza)){
		 echo 'ok';
		}
}