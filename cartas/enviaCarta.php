<?php 
require_once('../connections/datos.php'); 
require("../smtptester/class.phpmailer.php");

include('encabezado.php');
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

$IdCarta=$_GET['carta'];

$buscaCarta = "SELECT 
                    IdCarta,
                    destinatario1,
                    destinatario2,
                    destinatario3,
                    destinatario4,
                    destinatario5,
                    asunto,
                    fecha,
                    cartas.IdUsuario,
                    firmante,
                    cargo,
                    firma,
                    email,
                    fenvio,
                    ano,
                    consAno,
                    consello,
                    anulada,
                    carta
                FROM
                    cartas left join firmas on cartas.IdFirma=firmas.IdFirma
                WHERE
                    IdCarta = ".$IdCarta."  ";
$resultadoCarta = mysql_query($buscaCarta, $datos) or die(mysql_error());
$filaCarta = mysql_fetch_assoc($resultadoCarta);
$totalfilas_buscaCarta = mysql_num_rows($resultadoCarta);

$buscaAnexos = "SELECT 
                    nombre,
                    vinculo
                FROM
                    anexoscartas
                WHERE
                    IdCarta = ".$IdCarta."  ";
$resultadoAnexos = mysql_query($buscaAnexos, $datos) or die(mysql_error());
$filaAnexos = mysql_fetch_assoc($resultadoAnexos);
$totalfilas_buscaAnexos = mysql_num_rows($resultadoAnexos);

$buscaCop = " SELECT 
                  nombre,
                  correo
              FROM
                  copiados
              WHERE
                  IdCarta = ".$IdCarta."  ";
$resultadoCop = mysql_query($buscaCop, $datos) or die(mysql_error());
$filaCop = mysql_fetch_assoc($resultadoCop);
$totalfilas_buscaCop = mysql_num_rows($resultadoCop);

$actualiza="UPDATE cartas set enviada=1, fenvio='".date("Y-m-d")."' where IdCarta=".$_GET['carta'];
if ($results=@mysql_query($actualiza)){
}
$envia=1;

// include('carta-pdf.php');

$busca5="SELECT nombre, apellido, correo FROM usuarios WHERE IdUsuario=".$usuario."";
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila5 = mysql_fetch_assoc($resultado5);

if($filaCarta['destinatario2']){
  $destinatario2=$filaCarta['destinatario2']."<br>";
}else{
  $destinatario2="";
}
if($filaCarta['destinatario3']){
  $destinatario3=$filaCarta['destinatario3']."<br>";
}else{
  $destinatario3="";
}
if($filaCarta['destinatario4']){
  $destinatario4=$filaCarta['destinatario4']."<br>";
}else{
  $destinatario4="";
}
$varParrafos="";


if($totalfilas_buscaAnexos>0){
  $varAnexos="<strong>ANEXOS:</strong><br>";
  do{
    $varAnexos.=$filaAnexos['nombre']."<br>";
  } while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));
  $rows = mysql_num_rows($resultadoAnexos);
  if($rows > 0) {
      mysql_data_seek($resultadoAnexos, 0);
    $filaAnexos = mysql_fetch_assoc($resultadoAnexos);
  }
}else{
  $varAnexos="";
}

if($totalfilas_buscaCop>0){
  $varCopiados="<strong>C.C.:</strong><br>";
  $ncopiados=0;
  do{
    $varCopiados.=$filaCop['nombre']."<br>";
    $copiados[$ncopiados]=$filaCop['correo'];
    $ncopiados++;
  } while ($filaCop = mysql_fetch_assoc($resultadoCop));
  $rows = mysql_num_rows($resultadoCop);
  if($rows > 0) {
      mysql_data_seek($resultadoCop, 0);
    $filaCop = mysql_fetch_assoc($resultadoCop);
  }

}else{
  $varCopiados="";
}

$mail = new PHPMailer();

$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = utf8_decode('CPA '.$filaCarta['firmante']);

$mail->AddAddress($filaCarta['email']);
$mail->AddAddress($fila5['correo']);

for($i=0;$i<count($copiados);$i++){
  if($copiados[$i]<>""){
    $mail->AddAddress($copiados[$i]);
  }
}


$mail->ConfirmReadingTo = $fila5['correo'];
  
$mail->Subject = utf8_decode($filaCarta['asunto']);

$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:800px; background:white; padding:20px">						
						  <div align="center">
							 <img style="width:550px" src="../imagenes/logofa1.png">
              </div>
              <br>
              <p style="padding:0 20px" class="Arial16">
              <table border="0" width="100%">
              <tr><td>'.('Bogotá D.C., '.fechaactual6(date("Y-m-d"))).'</td>
              <td align="right">CPA-'.sprintf("%03d",$filaCarta['consAno']).'-'.$filaCarta['ano'].'</td></tr>
              </table>
              <br><br><br><br>
              Señores<br>
              '.$filaCarta['destinatario1'].'<br>'.$destinatario2.$destinatario3.$destinatario4.'
              <br><br>
              Referencia: '.$filaCarta['asunto'].'<br>
              <br>
              '.$filaCarta['destinatario5'].'<br><br>
              
              Agradecemos su atención.<br><br>
              Atentamente,<br><br>
              <img src="'. $filaCarta['firma'].'" width="220"><br>
              '.$filaCarta['firmante'].'<br>
              '.$filaCarta['cargo'].'<br>
              CPA INGENIERIA S.A.S.<br><br>
              '.$varAnexos.'
              '.$varCopiados.'
              </p>
            	<hr style="border:1px solid #ccc; width:100%">
						</div>

					</div>';  
  
//$mail->Body =$body;
echo $body;
$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 500;
$mail->IsHTML(true);

$documento='CPA-'.sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano'].'.pdf';

$ruta=$filaCarta['carta'];
$mail->AddAttachment($ruta, $documento);

if($totalfilas_buscaAnexos>0){
  do{
    $ruta1 = $filaAnexos['vinculo'];
    $arregloVinculo=explode(".",$filaAnexos['vinculo']);
    $mombreDoc=$filaAnexos['nombre'].".".end($arregloVinculo);
    $mail->AddAttachment($ruta1, $mombreDoc);
  } while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));
  
}
// exit();
if (!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
} else {
  echo "<div>LA CARTA FUE ENVIADA CON EXITO</div>";
  echo "</div><br>";
  $mensaje='<div>LA CARTA FUE ENVIADA CON EXITO</div><div></div>';
  ?>
  <script>
    swal({
        html: "<?php echo $mensaje ?>",
        type: "success",
        showConfirmButton: true,
        confirmButtonText: "Cerrar"
        }).then(function(result){
        if (result.value) {              
          // window.close()
        }
      });
</script>
  <?php
}




?>
