<?php require('../connections/datos.php');?>
<?php require("../smtptester/class.phpmailer.php");

$orden=$_GET['orden'];
$mensaje=$_GET['mensaje'];
include('encabezado.php');

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
$query_Recordset1 = sprintf("SELECT IdOrdencompra, nombre, apellido, correo, critico, fsolicitud, area from (ordencompra inner join usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) left join areas on ordencompra.IdArea=areas.IdArea where IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($orden)) {
  $var1_Recordset2 = $orden;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("select  correo, ordencompra.IdEmpresa, ordencompra.IdOrdencompra, IdUsuario from ordencompra left join usuarios on ordencompra.IdSolicitante=usuarios.IdUsuario where IdOrdencompra=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset3 = "0";
if (isset($orden)) {
  $var1_Recordset3 = $orden;
}
mysql_select_db($database_datos, $datos);
$query_Recordset3 = sprintf("SELECT * FROM itemoc WHERE IdOrdencompra=%s AND autorizado is  null", GetSQLValueString($var1_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$var1_Recordset4 = "0";
if (isset($orden)) {
  $var1_Recordset4 = $orden;
}
mysql_select_db($database_datos, $datos);
$query_Recordset4 = sprintf("SELECT proveedor, cotizaciones.precio, iva, cotizacion, cotizaciones.IdItem, cotizaciones.IdProveedor, cotizaciones.IdOrdencompra, cotizaciones.observaciones, IdCotizacion, fpago, descuento, cantidad, producto FROM ((cotizaciones INNER join proveedores On cotizaciones.IdProveedor=proveedores.IdProveedor) INNER JOIN itemoc ON cotizaciones.IdItem=itemoc.IdItem) LEFT join fpago ON cotizaciones.IdFpago=fpago.IdFpago WHERE cotizaciones.IdOrdencompra=%s", GetSQLValueString($var1_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$tablaInf="";

do{
  $tablaInf.='<table width="90%">';
  $tablaInf.='<tr><td>Producto: '.$row_Recordset3['producto'].'  -  Cantidad: '.number_format($row_Recordset3['cantidad'],0).'</td></tr></table>';
  $tablaInf.='<table width="100%" border="1" style="font-size:13px;border-collapse:collapse"><col width="290px">';
  $tablaInf.='<tr style="background: #84BE3F;color: #000000;text-align: center;"><td>PROVEEDOR</td><td>PRECIO</td><td>SUB TOTAL</td><td>DESC.</td><td>TOTAL</td><td>IVA</td><td>TOTAL</td><td>F PAGO</td></tr>';
 
  do{          
    $subtot=$row_Recordset4['precio']*$row_Recordset3['cantidad'];
    $subtotcd=$subtot*(1-$row_Recordset4['descuento']);  
    $totac=$subtotcd*(1+$row_Recordset4['iva']);
    if($row_Recordset3['IdItem']==$row_Recordset4['IdItem']){
      $tablaInf.='<tr><td>'.$row_Recordset4['proveedor'].'</td><td align="right">'.number_format($row_Recordset4['precio'],0).'</td>';

      $tablaInf.='<td align="right">'.number_format($subtot,0).'</td><td align="right">'.number_format($row_Recordset4['descuento']*100,0).'%</td>';
      $tablaInf.='<td align="right">'.number_format($subtotcd,0).'</td><td align="right">'.number_format($row_Recordset4['iva']*100,0).'%</td>';
      $tablaInf.='<td align="right">'.number_format($totac,0).'</td><td>'.$row_Recordset4['fpago'].'</td></tr>';      
    }    
  }while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
    mysql_data_seek($Recordset4, 0);
    $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
  $tablaInf.='</table><br>';

} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));


if($row_Recordset1['critico']==1){
  $critico='Si';
}else{
  $critico='No';
}
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div>
  <br><br><br><br>
  <div class="container">
    <?php 

$destinatario[0]='gerenciageneral@cpaingenieria.com';
$destinatario[1]='oacaicedog@gmail.com';
$destinatario[2]="ricardoarangom@gmail.com";
$destinatario[3]='contabilidad@cpaingenieria.com';
$destinatario[4]=$row_Recordset2['correo'];


$mail = new PHPMailer();  
$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = "COTIZACIONES - POST MASTER";
for($i=0;$i<=5;$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
}
//$mail->ConfirmReadingTo = "interv29@gmail.com";    
$mail->Subject = utf8_decode("SOLICITUD DE COMPRA No. ".$orden." YA COTIZADA");

$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
          <br>
          <br>

          <div style="position:relative; margin:auto; width:900px; background:white; padding:20px">
            <div align="center">
              <img style="width:550px" src="../imagenes/logofa1.png">
            </div>
            <h3 style="font-weight:100; color:#999" align="center">SOLICITUD DE COMPRA YA COTIZADA</h3>
            <hr style="border:1px solid #ccc; width:100%">
            <p style="padding:0 20px" class="Arial16">Buen día:
            <br><br>
            El proceso de cotizaciones de la Solicitud de Compra No. '.$orden.' ya concluyo, esta lista para el proceso de aprobacion.</p>
            
            <p style="padding:0 20px" class="Arial16">
            Proyecto / Area: '.$row_Recordset1['area'].'<br>
            Solicitante: '.$row_Recordset1['nombre'].' '.$row_Recordset1['apellido'].'<br>
            Fecha Solicitud: '.fechaactual3($row_Recordset1['fsolicitud']).'<br>
            Critico: '.$critico.'<br>
            </p>
            <div style="padding:0 20px">
            '.$tablaInf.'
            </div>
            <br>
            Debe ingresar a la plataforma  <a href="https://cpaingenieria.com/" target="_blank">https://cpaingenieria.com/</a> para su aprobación o rechazo<br>
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
// $mail->Send();
  if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
      echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
    }else{
      echo "<div class='Arial14'>";
      echo "<div>LA INFORMACION FUE GRABADA CORRECTAMENTE CORRECTAMENTE</div>";
      echo "</div><br>";
      ?>
    <script>
        swal({
            html: "<?php echo $mensaje ?>",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
             window.location = "cotizar2.php?orden=<?php echo $orden ?>";
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
	mysql_close($datos);

include('footer.php')
?>



</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
