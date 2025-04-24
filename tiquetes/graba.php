<?php require_once('../connections/datos.php'); ?>
<?php 

set_time_limit(0);
require("../smtptester/class.phpmailer.php");

session_start();
$usuario=$_SESSION['IdUsuario'];

$busca5="SELECT nombre, apellido FROM usuarios WHERE IdUsuario=".$usuario."";
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila6 = mysql_fetch_assoc($resultado5);


?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$var1_Recordset1 = "0";
if (isset($usuario)) {
  $var1_Recordset1 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT correo, nombre, apellido FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<?php 
include('encabezado.php');	
?>

<?php 
include('encabezado1.php');	
?>

<?php


if(isset($_POST['boton32'])){
	
	$fecha1=date("YmdHis");
	
	//echo('<pre>');
  //print_r($_POST);
  //echo('</pre>');
	
	//echo('<pre>');
  //print_r($_FILES);
  //echo('</pre>');
	
		
	$trayectos=$_POST['trayecto'];
	$pasajeros=$_POST['pasajero'];
	
	if($_POST['tipo']==1){
		$trayectos[2]['muno']=$trayectos[1]['mund'];
		$trayectos[2]['mund']=$trayectos[1]['muno'];
		
		$trayectos[2]['fecha']=$trayectos[2]['fecha'];
		$trayectos[2]['jornada']=$trayectos[2]['jornada'];
	}
	
	$cadenaTray=json_encode($trayectos);
	
	$ultFecha=date('Y-m-d');
	
	foreach($trayectos as $key=>$j){
		if($j['fecha']>$ultFecha){
			$ultFecha=$j['fecha'];
		}
	}
	
	$ultFecha=(strtotime ( '+2 day' , strtotime ( $ultFecha  )));
	$ultFecha=date("Y-m-d",$ultFecha);	
	
	foreach($_FILES['cedula']['name'] as $key=>$j){
		if($j){			
      $ruta="documentos/cedula-".$pasajeros[$key]['cedula']."-".$fecha1.".pdf";
      move_uploaded_file($_FILES['cedula']['tmp_name'][$key],$ruta);
			$pasajeros[$key]['link']=$ruta;			
		}	
	}
		
	$cadenaPasa=json_encode($pasajeros);
	
	$graba="INSERT INTO tiquetes (IdArea, IdEmpresa, IdSolicitante, fecha, trayectos, pasajeros, ufecha, motivo) VALUES (".$_POST['area'].", ".$_POST['empresa'].", ".$_POST['IdSolicitante'].", '".date("Y-m-d")."', '".$cadenaTray."', '".$cadenaPasa."', '".$ultFecha."', '".$_POST['motivo']."')";
	//echo $graba;
	if ($results=@mysql_query($graba)){
		$last_id = mysql_insert_id($datos);
		$mensaje.="<div class='container Arial14'>SOLCITUD DE TIQUETES CREADA</div>";
		?>
		<script>
        swal({
            html: "<?php echo $mensaje ?>",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
              window.location = "correotiquetes.php?id=<?php echo $last_id ?>";
            }
          });
    </script>
		<?php
	}
}
?>  
  
<?php 
include('footer.php');
?>
<?php
mysql_free_result($Recordset1);
?>
