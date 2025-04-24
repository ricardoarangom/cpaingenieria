<?php require_once('../connections/datos.php'); 
require("../smtptester/class.phpmailer.php");

$solicitud=$_GET['solicitud'];
$rechazada=$_GET['rechazada'];
$cambios=$_GET['cambios'];

include('encabezado.php');
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

$buscaSolicitud="SELECT beneficiario, actividad, nombre, apellido, correo, municipio, departamentos, motivo from ((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento where IdGviaje=".$solicitud;
$resultadoSol = mysql_query($buscaSolicitud, $datos) or die(mysql_error());
$filaSol = mysql_fetch_assoc($resultadoSol);

$busca5="SELECT nombre, apellido, correo FROM usuarios WHERE IdUsuario=".$usuario."";
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila5 = mysql_fetch_assoc($resultado5);

$buscaItems="SELECT * FROM itemgviaje WHERE IdGviaje=".$solicitud;
$resultadoItems = mysql_query($buscaItems, $datos) or die(mysql_error());
$filaItems = mysql_fetch_assoc($resultadoItems);

$destinatario[0]="ricardoarangom@gmail.com";
$destinatario[1]=$filaSol['correo'];
$destinatario[2]=$fila5['correo'];


if($rechazada==0){
  $destinatario[3]="auxiliar.contabilidad@cpaingenieria.com";
  $destinatario[4]="contabilidad@cpaingenieria.com";

  if($cambios==0){
    $texto="AUTORIZADA";
  }else{
    $texto="MODIFICADA Y AUTORIZADA";
  }
  
  $objeto="AUTORIZACION GASTOS DE VIAJE";
  $motivo="";
  $tabla='<table class="tablita Arial13" border="1" align="center" width="80%" ><tr><td align="center" bgcolor="#d8d8d8"><strong>CONCEPTO</strong></td><td align="center" bgcolor="#d8d8d8"><strong>CANT</strong></td><td align="center" bgcolor="#d8d8d8"><strong>V UNITARIO</strong></td><td align="center" bgcolor="#d8d8d8"><strong>V TOTAL</strong></td></tr>';
    $total=0;
  do{
    if($filaItems['rubro']=='taeropuerto'){
      $rubro='TRANSPORTE AEROPUERTO';
    }else{
      $rubro=strtoupper($filaItems['rubro']);
    }
    $total=$total+($filaItems['vunitario']*$filaItems['cantidad']);
    $tabla.="<tr><td>".$rubro."</td><td align='center'>".$filaItems['cantidad']."</td><td align='right'>".number_format($filaItems['vunitario'])."</td><td align='right'>".number_format($filaItems['vunitario']*$filaItems['cantidad'])."</td></tr>"; 
  } while ($filaItems = mysql_fetch_assoc($resultadoItems));
  $tabla.="<tr><td align='center' colspan='3'><strong>TOTAL</strong></td><td align='right'><strong>".number_format($total)."</strong></td></tr>";
  $tabla.="</table><br>";
}else{
  $texto="RECHAZADA";
  $objeto="RECHAZO GASTOS DE VIAJE";
  $motivo="Motivo:<br>".$filaSol['motivo']."<br>";
  $tabla="";
}

$mail = new PHPMailer();  

$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = "GASTOS DE VIAJE";
for($i=0;$i<count($destinatario);$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
    //echo $destinatario[$i];
  }
}   
$mail->Subject = utf8_decode($objeto." - SOLICITUD No. ".$solicitud);

$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">						
						  <div align="center">
							 <img style="width:500px" src="../imagenes/logofa1.png">
              </div>
              <hr style="border:1px solid #ccc; width:100%"> 
							<h4 style="font-weight:100; color:#999" align="center">'.$objeto.'</h4>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen dia:
              <br>
              <br>
                        
              El proceso de autorización de la Solicitud de Gastos de Viaje No. '.$solicitud.' ya finalizó. Y esta fue <strong>'.$texto.'</strong>.
							<br>              
              <br>
              '.$motivo.'
              '.$tabla.'
              </p>
							<br>
              <p style="padding:0 20px" class="Arial16">Cordialmente,
            	<br>
            	CPA INGENIERIA S.A.S
            	</p>
            	<div align="center">
							<img style="width:500px" src="../imagenes/banner.png">
              </div>
            	<hr style="border:1px solid #ccc; width:100%">
						</div>

					</div>';  
  
//$mail->Body =$body;
$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 200;
$mail->IsHTML(true);
// echo $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
}else{
  echo "hola";
  $mensaje="¡LA SOLICITUD DE GASTOS DE VIAJE FUE ".$texto."!";
  ?>
  <script language="JavaScript" type="text/javascript">
    swal({
          //title: "Error al subir el archivo",
          text: "<?php echo $mensaje ?>",
          type: "success",
          showConfirmButton: true,
          confirmButtonText: "¡Cerrar!"
      }).then(function(result){
        if (result.value) {
          window.location = "inicio.php";
        }
      });
  </script>
    <?php
} 

?>