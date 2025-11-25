<?php require_once('../connections/datos.php'); ?>
<?php 
require("../smtptester/class.phpmailer.php");
$carta=$_GET['carta'];

$buscaCarta = " SELECT 
                    usuarios.nombre,
                    usuarios.apellido,
                    usuarios.correo,
                    IdCarta,
                    destinatario1,
                    destinatario2,
                    destinatario3,
                    destinatario4,
                    destinatario5,
                    asunto,
                    fecha,
                    firmante,
                    cartas.IdUsuario,
                    enviada,
                    cartas.cargo,
                    fenvio,
                    email,
                    radicado,
                    ano,
                    consAno,
                    anulada,
                    carta,
                    firmaAut,
                    IdAutorfirma,
                    usuarios_1.nombre as nombref,
                    usuarios_1.apellido as apellidof,
                    usuarios_1.correo as correof 
                FROM
                    ((cartas
                    LEFT JOIN usuarios ON cartas.IdUsuario = usuarios.IdUsuario)
                    LEFT JOIN usuarios AS usuarios_1 ON cartas.IdAutorfirma = usuarios_1.IdUsuario)
                WHERE
                    IdCarta = ".$carta;
$resultadoCarta = mysql_query($buscaCarta, $datos) or die(mysql_error());
$filaCarta = mysql_fetch_assoc($resultadoCarta);
$totalfilas_buscaCarta = mysql_num_rows($resultadoCarta);

?>
<?php 
include('encabezado.php');	

$destinatario[0]='ricardoarangom@gmail.com';
$destinatario[1]=$filaCarta['correo'];
$destinatario[2]=$filaCarta['correof'];

// echo "<pre>";
// print_r($destinatario);
// echo "</pre>";

// exit();


$mail = new PHPMailer();  
$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = "CARTAS - POST MASTER";
for($i=0;$i<=5;$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
}
   
$mail->Subject = utf8_decode("AUTORIZACION DE FIRMA CARTA CPA-".sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano']."");

$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
          <br>
          <br>

          <div style="position:relative; margin:auto; width:900px; background:white; padding:20px">
            <div align="center">
              <img style="width:550px" src="../imagenes/logofa1.png">
            </div>
            <h3 style="font-weight:100; color:#999" align="center">AUTORIZACION DE FIRMA</h3>
            <hr style="border:1px solid #ccc; width:100%">
            <p style="padding:0 20px" class="Arial16">Buen día:<br>
            '.$filaCarta['nombre'].' '.$filaCarta['apellido'].'
            <br>
            <br>
            '.$filaCarta['nombref'].' '.$filaCarta['apellidof'].' ya reviso la carta y la subio con su respectiva firma.
            <br><br>
            Consecutivo: '."CPA-".sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano'].'<br>
            Destinatario: '.$filaCarta['destinatario1'].'<br>
            Asunto: '.$filaCarta['asunto'].'<br>
                        
            <p style="padding:0 20px" class="Arial16">
            Ya se puede continuar con el respectivo proceso.
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

// echo $body;
// exit();
$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 200;
$mail->IsHTML(true);

if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
      echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
}else{
  ?>
  <script>
    window.close();
  </script>
  <?php

}
?>
<?php 
include('footer.php')
?>