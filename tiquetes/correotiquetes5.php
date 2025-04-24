<?php 
set_time_limit(0);

session_start();
$usuario=$_SESSION['IdUsuario'];

require_once('../connections/datos.php');
require_once('../smtptester/class.phpmailer.php');

$buscaTiquete="select IdTiquete, tiquetes.IdArea, area, ccostos, empresa, usuarios.nombre, usuarios.apellido, correo, fecha, trayectos, pasajeros, cotizacion, IdSolicitante from (((tiquetes left join areas on tiquetes.IdArea=areas.IdArea) left join empresas on tiquetes.IdEmpresa=empresas.IdEmpresa) left join usuarios on tiquetes.IdSolicitante=usuarios.IdUsuario) where IdTiquete=".$_GET['IdTiquete'];
$resultado = mysql_query($buscaTiquete, $datos) or die(mysql_error());
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);

$buscaMunicipios="SELECT IdMunicipio, municipio, departamentos FROM municipios left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento";
$resultado1 = mysql_query($buscaMunicipios, $datos) or die(mysql_error());
$row_resultado1 = mysql_fetch_assoc($resultado1);
$totalRows_resultado1 = mysql_num_rows($resultado1);

$buscaFun="SELECT correo, nombre, apellido from usuarios where IdUsuario=".$usuario;
$resultado2 = mysql_query($buscaFun, $datos) or die(mysql_error());
$row_resultado2 = mysql_fetch_assoc($resultado2);
$totalRows_resultado2 = mysql_num_rows($resultado2);

$buscaSol="SELECT correo, nombre, apellido from usuarios where IdUsuario=".$row_resultado['IdSolicitante'];
$resultado3 = mysql_query($buscaSol, $datos) or die(mysql_error());
$row_resultado3 = mysql_fetch_assoc($resultado2);
$totalRows_resultado3 = mysql_num_rows($resultado2);

do{
	$tablaMun[$row_resultado1['IdMunicipio']]['municipio']=$row_resultado1['municipio'];
	$tablaMun[$row_resultado1['IdMunicipio']]['departamento']=$row_resultado1['departamentos'];
	
} while($row_resultado1 = mysql_fetch_assoc($resultado1));
mysql_free_result($resultado1);

$nproyecto=$row_resultado['ccostos']." - ".$row_resultado['area'];

$pasajeros=json_decode($row_resultado['pasajeros'],true);
$trayectos=json_decode($row_resultado['trayectos'],true);

$destinatario[0]=$row_resultado3['correo'];
$destinatario[1]='recepcion@cpaingenieria.com';
$destinatario[2]='ricardoarangom@gmail.com';
$destinatario[3]=$row_resultado2['correo'];	


$cuerpoPas='';
foreach($pasajeros as $key=>$j){
	$cuerpoPas.='<tr><td valign="top">'.$j['nombre'].'</td>';
	$cuerpoPas.='<td valign="top">'.$j['cedula'].'</td>';
	$cuerpoPas.='<td valign="top">'.$j['telefono'].'</td>';
	$cuerpoPas.='<td valign="top">'.$j['email'].'</td>';
	
	if($j['equipaje']==1){
		$cuerpoPas.='<td valign="top">De mano</td></tr>';
	}else if($j['equipaje']==2){
		$cuerpoPas.='<td valign="top">De cabina</td></tr>';
	}else if($j['equipaje']==3){
		$cuerpoPas.='<td valign="top">De bodega</td></tr>';
	}
}

$cuerpoTra='';
foreach($trayectos as $key=>$j){
	$cuerpoTra.='<tr><td valign="top">'.$tablaMun[$j['muno']]['municipio'].'</td>';
	$cuerpoTra.='<td valign="top">'.$tablaMun[$j['mund']]['municipio'].'</td>';
	$cuerpoTra.='<td valign="top">'.$j['fecha'].'</td>';
	if($j['jornada']==0){
		$cuerpoTra.='<td valign="top">Madrugrada</td></tr>';
	}else if($j['jornada']==1){
		$cuerpoTra.='<td valign="top">Mañana</td></tr>';
	}else if($j['jornada']==2){
		$cuerpoTra.='<td valign="top">Tarde</td></tr>';
	}else if($j['jornada']==3){
		$cuerpoTra.='<td valign="top">Noche</td></tr>';
	}
	
}

mysql_free_result($resultado2);

//echo "<pre>";
//print_r($destinatario);
//echo "</pre>";
?>
<?php 
include('encabezado.php');
?>
<style>
	.tablita td {
		border: 1px solid black;
		padding-left: 3px;
  	padding-right: 3px
	}

</style>

<?php
include('encabezado1.php');

$mail = new PHPMailer();  

$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = $row_resultado2['nombre']." ".$row_resultado2['apellido'];
for($i=0;$i<=count($destinatario);$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
	//echo $destinatario[$i]."<br>";
}
//$mail->AddAddress($destinatario[6]);   
$mail->Subject = utf8_decode("APROBACION DE TIQUETES AEREOS");


$body=('
    <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
      <br>
      <br>
      <div style="position:relative; margin:auto; width:750px; background:white; padding:20px">
        <div align="center">
         <img style="width:550px" src="../imagenes/logofa1.png">
        </div>
        <hr style="border:1px solid #ccc; width:100%">
        <h3 style="font-weight:100; color:#999" align="center">APROBACION DE TIQUETES AEREOS</h3>
        <hr style="border:1px solid #ccc; width:100%">

        <p style="padding:0 20px;font-size: 14px">Buenos días: 
        <br></p>

        <p style="padding:0 20px;font-size: 14px">
				En el proceso de la solicitud de tiquetes aereos realizada por '.$row_resultado['nombre']." ".$row_resultado['apellido'].' para el Proyecto/Area '.$nproyecto.', la cotizacón ya fue aprobada.
        <br><br>
				<strong>INFORMACION DE LOS PASAJEROS</strong></p>
				<table class="tablita" style="font-size:12px;margin-left:20px" border="1" cellspacing="0">
					<col width="225px">
					<col width="85px">
					<col width="80px">
					<col width="165px">
					<col width="75x">
					<tr>
						<td align="center" bgcolor="#d8d8d8">Nombre</td>
						<td align="center" bgcolor="#d8d8d8">Cedula</td>
						<td align="center" bgcolor="#d8d8d8">Telefono</td>
						<td align="center" bgcolor="#d8d8d8">E-mail</td>
						<td align="center" bgcolor="#d8d8d8">Equipaje</td>
					</tr>
					'.$cuerpoPas.'
				</table>
				<br>
				<p style="padding:0 20px;font-size: 14px">
				<strong>INFORMACION DE LOS TRAYECTOS</strong></p>
				<table class="tablita" style="font-size:12px;margin-left:20px" border="1" cellspacing="0">
					<col width="215px">
					<col width="215px">
					<col width="100px">
					<col width="150px">
					<tr>
						<td align="center" bgcolor="#d8d8d8">Origen</td>
						<td align="center" bgcolor="#d8d8d8">Destino</td>
						<td align="center" bgcolor="#d8d8d8">Fecha</td>
						<td align="center" bgcolor="#d8d8d8">Jornada</td>
					</tr>
					'.$cuerpoTra.'
				</table>
								
        <p style="padding:0 20px; font-size: 16px; color:#F00;" align="center"><strong>Esta es una notificación automática, por favor no responder este mensaje.</strong></p><br>

				
        <p style="padding:0 20px;font-size:14px">Cordialmente,
				<br>
				'.$row_resultado['empresa'].'</p>
				<div align="center">
        <img style="width:500px" src="../imagenes/banner.png">
        </div>
				<hr style="border:1px solid #ccc; width:100%;margin-bottom: 3px;margin-top: 3px;">
      </div>
    </div>');

echo $body;

$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 500;
$mail->IsHTML(true);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
}else{
//  echo "<div>LA INFORMACION FUE GRABADA CORRECTAMENTE CORRECTAMENTE</div>";
//  echo "</div><br>";
  ?>
    <script>
      window.close()
    </script>
  <?php
}


?>
<?php 
include('footer.php');

mysql_free_result($resultado);
?>