<?php require_once('../connections/datos.php'); 
require("../smtptester/class.phpmailer.php");

$solicitud=$_GET['solicitud'];

include('encabezado.php');
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

//$solicitud=3;

$buscaSolicitud="SELECT beneficiario, actividad, nombre, apellido, correo, municipio, departamentos, soporte from ((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento where IdGviaje=".$solicitud;

$resultadoSol = mysql_query($buscaSolicitud, $datos) or die(mysql_error());
$filaSol = mysql_fetch_assoc($resultadoSol);

$busca5="SELECT nombre, apellido, correo FROM usuarios WHERE IdUsuario=".$usuario."";
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila5 = mysql_fetch_assoc($resultado5);

$buscaItem="SELECT rubro, cantidad, vunitario FROM itemgviaje WHERE IdGviaje=".$solicitud."";
$resultadoItem = mysql_query($buscaItem, $datos) or die(mysql_error());
$filaItem = mysql_fetch_assoc($resultadoItem);

$cuerpotabla="";
$total=0;
do{
  $cuerpotabla.="<tr>";

  if($row_resultado1['rubro']=='taeropuerto'){
    $cuerpotabla.= '<td>TRANSPORTES AEROPUERTO</td>';
  }else{
    $cuerpotabla.= '<td>'.strtoupper($filaItem['rubro']).'</td>';
  }

  $cuerpotabla.='<td align="right">'.$filaItem['cantidad'].'</td>';
  $cuerpotabla.='<td align="right">'.number_format($filaItem['vunitario']).'</td>';
  $cuerpotabla.='<td align="right">'.number_format($filaItem['vunitario']*$filaItem['cantidad']).'</td></tr>';

  $total=$total+($filaItem['vunitario']*$filaItem['cantidad']);

} while ($filaItem = mysql_fetch_assoc($resultadoItem));

$cuerpotabla.='<tr><td colspan="3" align="center"><strong>TOTAL</strong></td>';
$cuerpotabla.='<td align="right"><strong>'.number_format($total).'</strong></td></tr>';

$destinatario[0]="ricardoarangom@gmail.com";
$destinatario[1]=$filaSol['correo'];
$destinatario[2]=$fila5['correo'];
// $destinatario[3]="contabilidad@cpaingenieria.com";

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
    // echo $destinatario[$i];
  }
}   
$mail->Subject = utf8_decode("PAGO GASTOS DE VIAJE  SOLICITUD No. ".$solicitud);

$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">						
						  <div align="center">
							 <img style="width:550px" src="../imagenes/logofa1.png">
              </div>
              <hr style="border:1px solid #ccc; width:100%">  
							<h4 style="font-weight:100; color:#999" align="center">PAGO GASTOS DE VIAJE</h4>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen dia:
              <br>
              <br>
              El valor correspondiente a los gastos de viaje de la solicitud No '.$solicitud.' ya fueron pagados.
              <br>         
              <table class="tablita" border="0" cellspacing="0" style="border-collapse:collapse;font-size:12px" align="center" width="90%" >
								<col width=125px>
                <tr>
                  <td valign="top">QUIEN VIAJA:</td>
                  <td>'.$filaSol['beneficiario'].'</td>
                </tr>
                <tr>
                  <td valign="top">DESTINO:</td>
                  <td>'.$filaSol['municipio'].' - '.$filaSol['departamentos'].'</td>
                </tr>
                <tr>
                  <td valign="top">MOTIVO DEL VIAJE:</td>
                  <td>'.$filaSol['actividad'].'</td>
                </tr>
              </table>
              <br>
              <p style="padding:0 20px" class="Arial16"><strong>RELACION DE GASTOS:</strong></p>
              <table class="tablita" border="1" cellspacing="0" style="border-collapse:collapse;font-size:12px" align="center" width="90%" >
								<col width=200px>
                <col width=65px>
                <col width=70px>
                <col width=70px>
                <tr>
                  <td align="center" bgcolor="#d8d8d8"><strong>CONCEPTO</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>CANTIDAD</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>VALOR UNITARIO</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>VALOR TOTAL</strong></td>
                </tr>'
              .$cuerpotabla.
              '</table>
              </p>
              <p style="padding:0 20px;font-size:16px;font-weight: bold;">
              La legalización de los gastos anticipados se debe hacer dentro de las 48 horas siguientes al finalizar el viaje.
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

//  echo $body;

$mail->AddAttachment($filaSol['soporte'], 'soporte.pdf');

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
}else{
  echo "<div class='Arial14'>";
  echo "<div>LA INFORMACION FUE GRABADA CORRECTAMENTE</div>";
  echo "</div><br>";
  $mensaje="¡EL PAGO FUE GRABADO CON EXITO!";
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