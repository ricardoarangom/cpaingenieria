<?php require_once('../connections/datos.php'); ?>
<?php 
require("../smtptester/class.phpmailer.php");
$orden=$_GET['orden'];
$mensaje=$_GET['mensaje'];

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
if (isset($orden)) {
  $var1_Recordset1 = $orden;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT IdOrdencompra, nombre, apellido, correo from ordencompra inner join usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario where Idordencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($orden)) {
  $var1_Recordset2 = $orden;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT * FROM itemoc WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset2, "int"));
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
      do{
        $cuerpotabla.="<tr><td>".$row_Recordset2['producto']."</td><td>".$row_Recordset2['especificacion']."</td><td>".$row_Recordset2['unidad']."</td><td>".$row_Recordset2['cantidad']."</td></tr>"; 
      } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));

	


$destinatario[1]=$row_Recordset1['correo'];
$destinatario[2]="ricardoarangom@gmail.com";


$mail = new PHPMailer();  

$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = utf8_decode($row_Recordset1['nombre'])." ".utf8_decode($row_Recordset1['apellido'])."";
for($i=0;$i<=2;$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
}    
$mail->Subject = utf8_decode("SOLICITUD DE COMPRA No. ".$orden);
$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:700px; background:white; padding:20px">
						  <div align="center">
               <img style="width:550px" src="../imagenes/logofa1.png">
              </div>
              <hr style="border:1px solid #ccc; width:100%">						
							<h3 style="font-weight:100; color:#999" align="center">SOLICITUD DE COMPRA</h3>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen día:
              <br><br>
              '.$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'].' acaba de realizar una Solicitud de Compra, el consecutivo asignado es el número '.$orden.'
              <br><br>
              <table class="tablita Arial13" border="1" align="center" width="90%" >
                <tr>
                  <td align="center" bgcolor="#d8d8d8"><strong>PRODUCTO</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>ESPECIFICACIONES</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>UNIDAD</strong></td>
                  <td align="center" bgcolor="#d8d8d8"><strong>CANTIDAD</strong></td>
                </tr>'
              .$cuerpotabla.
              '</table>  
              </p>
							<br>

							
              <p style="padding:0 20px;font-size:14px">Cordialmente,
							<br>
							CPA INGENIERIA S.A.S
							</p>
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
      echo $mensaje;
      echo "<div class='container Arial14' align='left'>";
      echo "<div>LA INFORMACION FUE GRABADA CORRECTAMENTE CORRECTAMENTE</div>";
      echo "</div><br>";
      $mensaje.="<div class='container Arial12' align='left'>";
      $mensaje.="<div>LA INFORMACION FUE GRABADA CORRECTAMENTE CORRECTAMENTE</div>";
      $mensaje.="</div><br>";
      ?>
    <div align="center"></div>
    <h5 style="height: ;text-align: center" align="center"></h5>
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
                 window.location = "creaoc.php";
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
