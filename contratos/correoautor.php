<?php require_once('../connections/datos.php'); ?>
<?php require("../smtptester/class.phpmailer.php");

include('encabezado.php');

// echo $usuario;

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

$busca = "  SELECT 
                nombre, apellido, correo, contrato, IdClase, consec, autorizado
            FROM
                ((solcontratos
                LEFT JOIN usuarios ON solcontratos.IdUsuario = usuarios.IdUsuario)
                LEFT JOIN contrat ON solcontratos.IdContrato = contrat.IdContrato)
            WHERE
                IdSolicitud =  " .$_GET['IdSolicitud'];
$resultado = mysql_query($busca, $datos) or die(mysql_error());
$fila = mysql_fetch_assoc($resultado);
$totalfilas_busca = mysql_num_rows($resultado);

$buscaUsu = " SELECT 
                  correo
              FROM
                  usuarios
              WHERE
                  IdUsuario =  ".$usuario;
$resultadoUsu = mysql_query($buscaUsu, $datos) or die(mysql_error());
$filaUsu = mysql_fetch_assoc($resultadoUsu);
$totalfilas_buscaUsu = mysql_num_rows($resultadoUsu);

if($fila['IdClase']==1){
  $consec='LAB '.sprintf("%03d",$fila['consec']);
}
if($fila['IdClase']==2){
  $consec='PS '.sprintf("%03d",$fila['consec']);
}

if($fila['autorizado']==1){
  $autorizado = " AUTORIZADA.";
  $parrafo="<br>En adjunto enviamos copia del respectivo contrato.<br>";
}
if($fila['autorizado']==2){
  $autorizado = " RECHAZADA.";
  $parrafo="";
}

$destinatario[0]="ricardoarangom@gmail.com";
$destinatario[1]=$fila['correo'];
$destinatario[2]=$filaUsu['correo'];

$mail = new PHPMailer();  
$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = "TALENTO HUMANO - CPA";
for($i=0;$i<=5;$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
}
    
$mail->Subject = utf8_decode("AUTORIZACION CONSULTA CONTRATO ".$consec);

$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
          <br>
          <br>

          <div style="position:relative; margin:auto; width:900px; background:white; padding:20px">
            <div align="center">
              <img style="width:550px" src="../imagenes/logofa1.png">
            </div>
            <h3 style="font-weight:100; color:#999" align="center">AUTORIZACION CONSULTA CONTRATO '.$consec.'</h3>
            <hr style="border:1px solid #ccc; width:100%">
            <p style="padding:0 20px" class="Arial16">Buen día:
            <br>'.$fila['nombre'].' '.$fila['apellido'].'<br>
            <br>
            Le informamos que su solicitud para consultar el contrtato '.$consec.' ha sido '.$autorizado.'<br>            
            '.$parrafo.'
            </p>
            
            
          
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
        
// echo $body;
//$mail->Body =$body;
$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 200;
$mail->IsHTML(true);

if($fila['autorizado']==1){
  $ruta=$fila['contrato'];
  $documento='Contrato - '.$consec.'.pdf';
  $mail->AddAttachment($ruta, $documento);
}


// if(!$mail->Send()) {
//   echo "Mailer Error: " . $mail->ErrorInfo;
//   echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
// }else{


// }
$mail->Send();
?>
<script>
window.close()
</script>
