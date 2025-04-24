<?php require_once('../connections/datos.php'); ?>
<?php 
require("../smtptester/class.phpmailer.php");
$solicitud=$_GET['solicitud'];
$mensaje=$_GET['mensaje'];
//$solicitud=2;
?>
<?php 

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
if (isset($solicitud)) {
  $var1_Recordset1 = $solicitud;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("select nombre, apellido, correo, area, municipio, departamentos, fsalida from (((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento where IdGviaje=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($solicitud)) {
  $var1_Recordset2 = $solicitud;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT * FROM itemgviaje WHERE IdGviaje=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<?php 
include('encabezado.php');	
?>

<?php 
include('encabezado1.php');	
?>

<div>
<br>
<div>
  <div class="container">
    <?php
      $total=0;
      do{
        if($row_Recordset2['rubro']=='taeropuerto'){
          $rubro='TRANSPORTE AEROPUERTO';
        }else{
          $rubro=strtoupper($row_Recordset2['rubro']);
        }
        $total=$total+($row_Recordset2['vunitario']*$row_Recordset2['cantidad']);
        $cuerpotabla.="<tr><td>".$rubro."</td><td align='center'>".$row_Recordset2['cantidad']."</td><td align='right'>".number_format($row_Recordset2['vunitario'])."</td><td align='right'>".number_format($row_Recordset2['vunitario']*$row_Recordset2['cantidad'])."</td></tr>"; 
      } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));

      $cuerpotabla.="<tr><td align='center' colspan='3'><strong>TOTAL</strong></td><td align='right'><strong>".number_format($total)."</strong></td></tr>";



$destinatario[0]=$row_Recordset1['correo'];
$destinatario[1]="ricardoarangom@gmail.com";
$destinatario[2]="gerenciageneral@cpaingenieria.com";
$destinatario[3]="auxiliar.contabilidad@cpaingenieria.com";
$destinatario[4]="contabilidad@cpaingenieria.com";
  

$mail = new PHPMailer();  

$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = utf8_decode($row_Recordset1['nombre'])." ".utf8_decode($row_Recordset1['apellido'])."";
for($i=0;$i<=count($destinatario);$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
}    
$mail->Subject = utf8_decode("SOLICITUD DE ANTICIPO GASTOS DE VIAJE No. ".$solicitud);
$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:700px; background:white; padding:20px">
						  <div align="center">
							 <img style="width:550px" src="../imagenes/logofa1.png">
              </div>
              <hr style="border:1px solid #ccc; width:100%">             
						
							<h4 style="font-weight:100; color:#999" align="center">SOLICITUD DE ANTICIPO GASTOS DE VIAJE</h4>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen día:
              <br><br>
              '.$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'].' acaba de realizar una <strong>SOLICITUD DE ANTICIPO</strong> de gastos de viaje, el consecutivo asignado es el número '.$solicitud.'
              <br><br>
              Proyecto / Area: <strong>'.$row_Recordset1['area'].'</strong><br>
              Fecha del viaje: <strong>'.fechaactual3($row_Recordset1['fsalida']).'</strong><br>
              Total anticipo: <strong>'.number_format($total).'</strong><br><br>
              
              Debe ingresar a la plataforma  <a href="https://cpaingenieria.com/" target="_blank">https://cpaingenieria.com/</a> para su aprobación, modificación o rechazo<br>
              <table class="tablita Arial13" border="1" align="center" width="80%" >
                <tr>
                  <td align="center" bgcolor="#d8d8d8"><strong>CONCEPTO</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>CANT</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>V UNITARIO</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>V TOTAL</strong></td>
                </tr>'
              .$cuerpotabla.
              '</table>  
              </p>
							<br>

							
              <p style="padding:0 20px;font-size:14px">Cordialmente,
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
// echo $body;
$mail->msgHTML(utf8_decode($body));
$mail->WordWrap = 200;
$mail->IsHTML(true);

if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
      echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
}else{
      
      ?>
    <div align="center"></div>
    <script language="JavaScript" type="text/javascript">
        swal({
              //title: "Error al subir el archivo",
              html: "<?php echo $mensaje ?>",
              type: "success",
              showConfirmButton: true,
              showCancelButton: true,
              confirmButtonText: "Terminar",
              cancelButtonColor: '#d33',
              cancelButtonText: 'Otra Solicitud'
              }).then(function(result){
              if (result.value) {
                window.location = "inicio.php";
              }else{
                window.location = "solicitud.php";
              }
            });
      </script>
    <?php
}  
?>
  </div>
  
</div>
	
</div>
<?php 
include('footer.php')
?>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
