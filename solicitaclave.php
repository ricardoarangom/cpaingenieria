<?php require_once('connections/datos.php'); ?>
<link rel="shortcut icon" href="imagenes/icono.png">
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="imagenes/iconos/styles.css">
<link rel="stylesheet" href="css/stylefonts.css">
<link rel="stylesheet" href="css/frameworkra.css">
	
<script src="js/jquery.min.js"></script>
<script src="js/sweetalert2.all.js"></script>
<script type="text/javascript" language="JavaScript" src="js/ajax.js"></script>
	
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/funciones.js"></script>
<?php
require("smtptester/class.phpmailer.php");

function generarContrasena($longitud = 8) {
  $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $longitud_caracteres = strlen($caracteres);
  $contrasena = '';

  for ($i = 0; $i < $longitud; $i++) {
      $contrasena .= $caracteres[rand(0, $longitud_caracteres - 1)];
  }

  return $contrasena;
}

$nueva_contrasena = generarContrasena(8);
echo $nueva_contrasena."<br>";

$clavecifrada=password_hash($nueva_contrasena,PASSWORD_DEFAULT);	
echo $clavecifrada;

$buscaUsuario="SELECT IdUsuario, usuario from usuarios where correo='".$_POST['correo']."'";
$resultado = mysql_query($buscaUsuario, $datos) or die(mysql_error());
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);

if($totalRows_resultado>0){

  $destinatario[0]=$_POST['correo'];

  $mail = new PHPMailer();  

  $mail->PluginDir = "smtptester/";
  $mail->Timeout=120;
  $mail->IsSMTP();
  $mail->SMTPAuth = true;

  $mail->isHTML(true);
  include('includes/infcorreo.php');
  $mail->FromName = "CPA INGENIERIA ";
  for($i=0;$i<=2;$i++){
    if($destinatario[$i]<>""){
      $mail->AddAddress($destinatario[$i]);
    }
  }    

  $mail->Subject = utf8_decode("Generador de contraseña".$orden);
  $body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:700px; background:white; padding:20px">
						  <div align="center">
               <img style="width:550px" src="imagenes/logofa1.png">
              </div>
              <hr style="border:1px solid #ccc; width:100%">						
							<h3 style="font-weight:100; color:#999" align="center">GENERADOR DE CONTRASEÑA</h3>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen día:
              <br><br>
              De acuerdo a su solicitud se genero una nueva contraseña para su usuario en la plataforma de CPA INGENERIA.
              <br><br>
              La nueva contraseña es:
              <br><br>
              '.$nueva_contrasena.'
              </p>
							<br>

							
              <p style="padding:0 20px;font-size:14px">Cordialmente,
							<br>
							CPA INGENIERIA S.A.S
							</p>
							<div align="center">
              <img style="width:500px" src="imagenes/banner.png">
              </div>
              <hr style="border:1px solid #ccc; width:100%">
						</div>

					</div>';  
//$mail->Body =$body;
//echo $body;
$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 200;
$mail->IsHTML(true);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
 }else{
  $edita="UPDATE usuarios SET clave='".$clavecifrada."' WHERE IdUsuario=".$row_resultado['IdUsuario']."";
  //mysql_query($edita,$datos);
  if ($results=@mysql_query($edita)){ 
  }
  ?>
  <script>
      swal({
        //title: "Error al subir el archivo",
        text: "¡La nueva contraseña fue enviada a su correo!",
        type: "success",
        showConfirmButton: true,
        confirmButtonText: "¡Cerrar!"
        }).then(function(result){
          if (result.value) {
            // window.open('index.php');
          }
        });

  </script>
<?php
}  

}else{
  ?>
  <script>
			swal({
				//title: "Error al subir el archivo",
				text: "¡El correo digitado no corresponde a ninguno regsitrado en la base de datos!",
				type: "warning",
				showConfirmButton: true,
				confirmButtonText: "¡Cerrar!"
				}).then(function(result){
					if (result.value) {
						window.open('index.php');
					}
				});
	
  </script>
  <?php
}