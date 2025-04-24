<?php 
require_once("../connections/datos.php");
require_once('../funciones.php');  

//echo('<pre>');
//print_r($_POST);
//echo('</pre>');  


if($_POST['proced']==1){

	$sql="SELECT IdEmpresa, area FROM areas WHERE IdArea=".$_POST['area']."";
	$res=mysql_query($sql);
	$fila=mysql_fetch_array($res);
			
	echo $fila['IdEmpresa'];
}

if($_POST['proced']==2){
	
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";
//	
//	echo "<pre>";
//	print_r($_FILES);
//	echo "</pre>";
		
	if($_FILES['cotizacion']['name']<>""){
    
    $ruta="documentos/cotizacion-".$_POST['IdTiquete'].".pdf";
    move_uploaded_file($_FILES['cotizacion']['tmp_name'],$ruta);
		$archivo=$ruta;
			
			$guardaDoc="UPDATE tiquetes SET cotizacion='".$archivo."', IdCotizador=".$_POST['usuario'].", fcotizacion='".date("Y-m-d")."' WHERE IdTiquete=".$_POST['IdTiquete'];
//			echo $guardaDoc;
			if ($results=@mysql_query($guardaDoc)){
				echo 'ok';
			}
		}
	
}

if($_POST['proced']==3){
	
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";
//	
//	echo "<pre>";
//	print_r($_FILES);
//	echo "</pre>";
		
	if($_FILES['tiquete']['name']<>""){
    
      $ruta="documentos/tiquete-".$_POST['IdTiquete'].".pdf";
      move_uploaded_file($_FILES['tiquete']['tmp_name'],$ruta);
			$archivo=$ruta;
			
			$guardaDoc="UPDATE tiquetes SET tiquete='".$archivo."', fcompra='".date("Y-m-d")."', mpago='".$_POST['mpago']."' WHERE IdTiquete=".$_POST['IdTiquete'];
//			echo $guardaDoc;
			if ($results=@mysql_query($guardaDoc)){
				echo 'ok';
			}
		}
}

if($_POST['proced']==4){
	
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";
	
	$guardaDoc="UPDATE tiquetes SET motivo='".$_POST['observacion']."', rechazado=1 WHERE IdTiquete=".$_POST['IdTiquete'];
//			echo $guardaDoc;
	if ($results=@mysql_query($guardaDoc)){
		echo 'ok';
	}
	
}

if($_POST['proced']==5){
	
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";
	
	$guardaDoc="UPDATE tiquetes SET fautorizacion='".date("Y-m-d")."', IdAutorizador=".$_POST['usuario'].", observaciones='".$_POST['observacion']."' WHERE IdTiquete=".$_POST['IdTiquete'];
//			echo $guardaDoc;
	if ($results=@mysql_query($guardaDoc)){
		echo 'ok';
	}
	
}

if($_POST['proced']==6){
	
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";
	
	$guardaDoc="UPDATE tiquetes SET eliminado=1  WHERE IdTiquete=".$_POST['IdTiquete'];
//			echo $guardaDoc;
	if ($results=@mysql_query($guardaDoc)){
		echo 'ok';
	}
	
}

if($_POST['proced']==7){
	
  $busca="select trayectos, pasajeros from tiquetes where IdTiquete=".$_POST['IdTiquete'];
	$res=mysql_query($busca);
	$fila=mysql_fetch_array($res);
  
  echo $fila['trayectos'].";".$fila['pasajeros'];
}
?>







