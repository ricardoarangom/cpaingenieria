
<?php require_once('../connections/datos.php'); 
require("../smtptester/class.phpmailer.php");

$ordenc=$_GET['orden'];

session_start();
$usuario=$_SESSION['IdUsuario'];

// $ordenc=2

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
if (isset($ordenc)) {
  $var1_Recordset1 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT cotizaciones.precio, iva, impoconsumo, IdCompra, cantidad, producto, especificacion, unidad, cotizaciones.IdProveedor, proveedor, cotizaciones.IdOrdencompra, cotizaciones.descuento, especificacion, itemoc.observaciones, derogada, autorizado FROM ((itemcompra INNER JOIN cotizaciones ON itemcompra.IdCotizacion=cotizaciones.IdCotizacion) INNER JOIN itemoc ON cotizaciones.IdItem=itemoc.IdItem) INNER JOIN proveedores ON cotizaciones.IdProveedor=proveedores.IdProveedor WHERE cotizaciones.IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($ordenc)) {
  $var1_Recordset2 = $ordenc;
}
$var2_Recordset2 = "0";
if (isset($usuario)) {
  $var2_Recordset2 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT correo from usuarios INNER JOIN ordencompra ON usuarios.IdUsuario=ordencompra.IdSolicitante where IdOrdencompra=%s UNION ALL   SELECT correo FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset2, "int"),GetSQLValueString($var2_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset3 = "0";
if (isset($usuario)) {
  $var1_Recordset3 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset3 = sprintf("SELECT correo, nombre, apellido FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$var1_Recordset4 = "0";
if (isset($ordenc)) {
  $var1_Recordset4 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset4 = sprintf("SELECT empresa FROM (ordencompra left join areas on ordencompra.IdArea=areas.IdArea) left join empresas on ordencompra.IdEmpresa=empresas.IdEmpresa WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$var1_Recordset5 = "0";
if (isset($ordenc)) {
  $var1_Recordset5 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset5 = sprintf("SELECT IdCompra, IdOrdencompra, proveedor, email, rut, camcom, certbanc, IdBanco, cuenta, clasecuenta, compras.IdProveedor, fecha, comprado FROM compras inner join proveedores on compras.IdProveedor=proveedores.IdProveedor WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$buscaItem="select producto, cantidad, especificacion, observaciones, derogada, autorizado from itemoc where IdOrdencompra=".$ordenc;
$resultadoItem=mysql_query($buscaItem, $datos) or die(mysql_error());
$filaItem=mysql_fetch_assoc($resultadoItem);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/frameworkra.css">

</head>

<body>

<?php 
  $j=2;
  do{
   $destinatario[$j]=$row_Recordset2['correo'];
   $j++;
    
  }while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
	
	$destinatario[0]="contabilidad@cpaingenieria.com";  
  $destinatario[1]="ricardoarangom@gmail.com";
  //$destinatario[3]=$row_Recordset3['correo'];
  $i=0;
  do{
    $productos[$i]['prod']=$filaItem['producto'];
    $productos[$i]['cant']=$filaItem['cantidad'];
    $productos[$i]['espe']=$filaItem['especificacion'];
    $productos[$i]['obse']=$filaItem['observaciones'];
    if($filaItem['derogada']==0){
     $productos[$i]['dero']="SI"; 
    }else{
     $productos[$i]['dero']="RECHAZADA"; 
    }
    if(is_null($filaItem['autorizado']) ){
     $productos[$i]['dero']="EN ESPERA";
    }
    $i++;
    
    
  }while ($filaItem=mysql_fetch_assoc($resultadoItem)); 
  

  $tablaInf='';
  if($totalRows_Recordset5>0){
    
    do{   
      $tablaInf.='<table width="100%" border="0" style="font-size:14px"><tr><td>ORDEN DE COMPRA No. '.$row_Recordset5['IdCompra'].'</td></tr>';
      $tablaInf.='<tr><td valign="top">PROVEEDOR: '.$row_Recordset5['proveedor'].'</td></tr></table>';
      $tablaInf.='<table width="100%" border="1" style="font-size:12px;border-collapse:collapse"><col width="250"><col width="100"><col width="100"><col width="100"><col width="100"><col width="60"><col width="60"><col width="100">';
      $tablaInf.='<tr style="background: #84BE3F;color: #000000;text-align: center;"><td>PRODUCTO</td><td>PRECIO</td><td>SUB-TOTAL</td><td>DESC.</td><td>TOTAL</td><td>IVA</td><td>IMPO CONSUMO</td><td>TOTAL</td></tr>';

      $totaloc=0; 
      do{
        if($row_Recordset5['IdCompra']==$row_Recordset1['IdCompra']){
          $subtotal=$row_Recordset1['cantidad']*$row_Recordset1['precio'];
          $subtotalcd=$subtotal*(1-$row_Recordset1['descuento']);
          $total=$subtotalcd*(1+$row_Recordset1['iva']+$row_Recordset1['impoconsumo']);

          $tablaInf.='<tr><td style="padding-left: 3px">'.$row_Recordset1['producto'].'</td>';
          $tablaInf.='<td align="right" style="padding-right: 3px">'.number_format($row_Recordset1['precio'],0).'</td><td align="right" style="padding-right: 3px">'.number_format($subtotal,0).'</td>';
          $tablaInf.='<td align="right" style="padding-right: 3px">'.number_format(($row_Recordset1['descuento']*100),0).'%</td>';
          $tablaInf.='<td align="right" style="padding-right: 3px">'.number_format($subtotalcd,0).'</td>';
          $tablaInf.='<td align="right" style="padding-right: 3px">'.number_format(($row_Recordset1['iva']*100),0).'%</td>';
          $tablaInf.='<td align="right" style="padding-right: 3px">'.number_format(($row_Recordset1['impoconsumo']*100),0).'%</td>';
          $tablaInf.='<td align="right" style="padding-right: 3px">'.number_format($total,0).'</td>';
          ?>
          
          <?php
        $totaloc=$totaloc+$total;
        }
      }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
      $rows = mysql_num_rows($Recordset1);
      if($rows > 0) {
          mysql_data_seek($Recordset1, 0);
        $row_Recordset1 = mysql_fetch_assoc($Recordset1);
      }
      $tablaInf.='<tr><td style="padding-left: 3px">TOTAL ORDEN DE COMPRA No. '.$row_Recordset5['IdCompra'].'</td>';
      $tablaInf.='<td colspan="7" style="padding-left: 3px"  align="right">'.number_format($totaloc,0).'</td></tr>';
      $tablaInf.='</table><br>';
       
    }while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
  }
  
$mail = new PHPMailer();  

$mail->PluginDir = "../smtptester/";
$mail->Timeout=120;
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->isHTML(true);
include('../includes/infcorreo.php');
$mail->FromName = "COMPRAS";
for($i=0;$i<=$j;$i++){
  if($destinatario[$i]<>""){
    $mail->AddAddress($destinatario[$i]);
  }
}   
$mail->Subject = utf8_decode("AUTORIZACION SOLICITUD DE COMPRA ".$ordenc);

foreach($productos as $j){
  $cuerpoTabla.= "<tr><td style='padding-left: 3px'>".$j['prod']."</td><td align='center'>".number_format($j['cant'],0)."</td><td style='padding-left: 3px'>".$j['espe']."</td><td align='center'>".$j['dero']."</td><td style='padding-left: 3px'>".$j['obse']."</td></tr>"; 
}
$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:900px; background:white; padding:20px">
						  <div align="center">
               <img style="width:550px" src="../imagenes/logofa1.png">
              </div>
						
							<h3 style="font-weight:100; color:#999" align="center">AUTORIZACION SOLICITUD DE COMPRA</h3>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen dia:
              <br>
              <br>
                        
              El proceso de autorización de la Solicitud de Compra No. '.$ordenc.' ya finalizó. 
							<br><br>
              <table border="1" style="font-size:14px;border-collapse:collapse" align="center" width="60%"><tr style="background: #84BE3F;color: #000000;text-align: center;"><td><strong>PRODUCTO</strong></td><td><strong>CANT</strong></td><td><strong>ESPECIFIC</strong></td><td><strong>AUTOR.</strong></td><td><strong>OBSERV.</strong></td></tr>              
              '.$cuerpoTabla.'              
              </table>
              </p>
              <p style="padding:0 20px" class="Arial16">
                Se generaron las siguientes Ordenenes de Compra:                
              </p>
              <div style="padding:0 20px">
                '.$tablaInf.'
              </div>
							<br>
              <p style="padding:0 20px" class="Arial16">Cordialmente,
            	<br>
            	CPA INGENIERIA S.A.S
            	</p>
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
  echo "<div>LA INFORMACION FUE GRABADA CORRECTAMENTE</div>";
  echo "</div><br>";
}    
  
?>
			<script>
				document.location.replace ("confcrecompra.php?orden=<?php echo $ordenc?>");
			</script>

  
  
  
  
  
  
  
  
<?php 
	mysql_close($datos);
?>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
