<?php  require_once('../connections/datos.php');?>
<?php

set_time_limit(0);

require_once('../fpdf/fpdf.php');
require_once('../funciones.php');
require_once('../phpqrcode/qrlib.php');
include('../includes/formatopdf.php');
?>

<?php

if(isset($_POST['oc'])){
 $ordenc=$_POST['oc'];
}
if(isset($_GET['oc'])){
 $ordenc=$_GET['oc']; 
}

//$ordenc=1;


session_start();
$usuario=$_SESSION['IdUsuario'];

//$usuario=1;


$busca="SELECT IdItem FROM itemcompra WHERE IdCompra=".$ordenc;
$resultado = mysql_query($busca, $datos) or die(mysql_error());
$fila = mysql_fetch_assoc($resultado);
$totalfilas = mysql_num_rows($resultado);

$busca2="SELECT IdOrdencompra from compras WHERE IdCompra=".$ordenc."";
$resultado2 = mysql_query($busca2, $datos) or die(mysql_error());
$fila2 = mysql_fetch_assoc($resultado2);

$busca3="SELECT IdOrdencompra, comprado from itemoc where IdOrdencompra=".$fila2['IdOrdencompra']." AND comprado is null";
$resultado3 = mysql_query($busca3, $datos) or die(mysql_error());
$fila3 = mysql_fetch_assoc($resultado3);
$totalfilas3 = mysql_num_rows($resultado3);

$busca4="SELECT autorizada, IdCompra, IdSolicitante, correo, ordencompra.IdArea, nombre, apellido, cargo from (compras INNER JOIN ordencompra ON compras.IdOrdencompra=ordencompra.IdOrdencompra) inner join usuarios On ordencompra.IdSolicitante=usuarios.IdUsuario where IdCompra=".$ordenc."";
$resultado4 = mysql_query($busca4, $datos) or die(mysql_error());
$fila4 = mysql_fetch_assoc($resultado4);
$totalfilas4 = mysql_num_rows($resultado4);

$autoriza=$fila4['autorizada'];
$solicitante=$fila4['IdSolicitante'];
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
$query_Recordset1 = sprintf("SELECT proveedor, proveedores.direccion, proveedores.telefono, ciudad, contacto, IdCompra, fecha, direnvio, fautorizado, empresa, email, email2, email3, empresas.nit, empresas.direccion AS DIREC, area, empresas.IdEmpresa, areas.IdArea, proveedores.IdProveedor, documento, banco, ccuenta, cuenta FROM (((((compras INNER JOIN proveedores ON compras.IdProveedor=proveedores.IdProveedor) inner join ordencompra ON compras.IdOrdencompra=ordencompra.IdOrdencompra) INNER JOIN empresas ON ordencompra.IdEmpresa=empresas.IdEmpresa) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea) left join bancos on proveedores.IdBanco=bancos.IdBanco) left join clasecuenta on proveedores.clasecuenta=clasecuenta.IdClasecuenta WHERE IdCompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($ordenc)) {
  $var1_Recordset2 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT IdCompra, IdItemcompra, precio, iva, impoconsumo, cantidad, producto, unidad, fpago, descuento, especificacion, cotizacion, medio FROM (((itemcompra INNER join cotizaciones ON itemcompra.IdCotizacion=cotizaciones.IdCotizacion) inner join itemoc On cotizaciones.IdItem=itemoc.IdItem) left join fpago on cotizaciones.IdFpago=fpago.IdFpago) left join mediosp on cotizaciones.IdMpago=mediosp.IdMpago WHERE IdCompra=%s ORDER BY producto", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset3 = "0";
if (isset($solicitante)) {
  $var1_Recordset3 = $solicitante;
}
mysql_select_db($database_datos, $datos);
$query_Recordset3 = sprintf("SELECT nombre, apellido, cargo, correo FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$var1_Recordset4 = "0";
if (isset($autoriza)) {
  $var1_Recordset4 = $autoriza;
}
mysql_select_db($database_datos, $datos);
$query_Recordset4 = sprintf("SELECT nombre, apellido, cargo FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>

<?php
$title="ORDEN DE COMPRA";
$ancho=210;
$codigo="FC-CO-10";
$version="01";
$fecha="24/08/2020";
$ruta_qr = 'qr/qr-'.$ordenc.'.png';

$texto='https://compras.cpaingenieria.com/compras/orcompra-pdf-con.php?oc='.$ordenc;
$level = "Q";
$tamano = 10;
$framSize =3;

QRcode::png($texto,$ruta_qr,$level,$tamano,$framSize);

$fpago=$row_Recordset2['fpago'];
$mpago=$row_Recordset2['medio'];
$fecmax=(strtotime ( '+'.(3).' day' , strtotime ( date("Y-m-d")  )));
$fecmax=date("Y-m-d",$fecmax);

$pdf = new PDF('P','mm',Letter);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(20);
$pdf->SetAutoPageBreak(1,40);
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Cell(180,6,"ORDEN DE COMPRA No. ".$ordenc,1,1,'C');
$pdf->Cell(75,6,utf8_decode("CIUDAD: Bogotá D. C. "),1,0,'L');
$pdf->Cell(105,6,utf8_decode("FECHA: ").fechaactual3($row_Recordset1['fecha']),1,1,'L');
$pdf->Cell(180,6,utf8_decode("PROYECTO: ").utf8_decode($row_Recordset1['area']),1,1,'L');
$pdf->Cell(125,6,utf8_decode("NOMBRE DEL PROVEEDOR: ").utf8_decode($row_Recordset1['proveedor']),1,0,'L');
$pdf->Cell(55,6,utf8_decode("N.I.T./ R.U.T.: ").utf8_decode($row_Recordset1['documento']),1,1,'L');

$pdf->Cell(125,6,utf8_decode("DIRECCIÓN: ").utf8_decode($row_Recordset1['direccion']),1,0,'L');
$pdf->Cell(55,6,utf8_decode("TELÉFONO: ").utf8_decode($row_Recordset1['telefono']),1,1,'L');

$pdf->Cell(180,6,utf8_decode("PERSONA CONTACTADA: ").utf8_decode($row_Recordset1['contacto']),1,1,'L');
$pdf->Cell(30,6,utf8_decode("E-MAIL:"),1,0,'L');
$pdf->Cell(150,6,utf8_decode($row_Recordset1['email']),1,1,'L');
$pdf->Cell(40,6,utf8_decode("FORMA DE PAGO:"),1,0,'L');
$pdf->Cell(140,6,$fpago,1,1,'L');
$pdf->Cell(40,6,utf8_decode("MEDIO DE PAGO:"),1,0,'L');
$pdf->Cell(140,6,$mpago,1,1,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(15,6,utf8_decode("BANCO:"),1,0,'L');
$pdf->Cell(55,6,utf8_decode($row_Recordset1['banco']),1,0,'L');
$pdf->Cell(30,6,utf8_decode("TIPO DE CUENTA:"),1,0,'L');
$pdf->Cell(25,6,utf8_decode($row_Recordset1['ccuenta']),1,0,'L');
$pdf->Cell(25,6,utf8_decode("No DE CUENTA:"),1,0,'L');
$pdf->Cell(30,6,utf8_decode($row_Recordset1['cuenta']),1,1,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(125,6,utf8_decode('LUGAR  Y DIRECCIÓN DE ENTREGA: ').utf8_decode($row_Recordset1['direnvio']),1,0,'L');
$pdf->Cell(55,6,utf8_decode('F. DE ENTREGA: ').fechaactual3($fecmax),1,1,'L');

//$pdf->Cell(25,7,$ordenc,1,1,'C');

$pdf->SetFont('Arial','',9);
$pdf->SetWidths(array(10,62,16,18,14,12,11,14,23));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C'));
//$pdf->SetFillColor(216,216,216);
//$pdf->fill(array(1,1,1,1,1,1,1));
$pdf->Row(array('ITEM',utf8_decode('DESCRIPCIÓN'),'UN','VR UNI.','CANT.','DESC.','IVA','IMPO CONS','VR PARCIAL'),5);
$pdf->SetFont('Arial','',8);
$totaloc=0;
$objeto="";
$ivaCont=0;
$item=1;
do{
  $tablaCotizaciones[$row_Recordset2['producto']]=$row_Recordset2['cotizacion'];

  $fpago=$row_Recordset2['fpago'];
  $subtotcd=($row_Recordset2['precio']*$row_Recordset2['cantidad'])*(1-$row_Recordset2['descuento']);
  $subtot=($subtotcd*(1+$row_Recordset2['iva']+$row_Recordset2['impoconsumo']));
  
  $descuento=($row_Recordset2['precio']*$row_Recordset2['cantidad'])*$row_Recordset2['descuento'];
  $iva=$subtotcd*$row_Recordset2['iva'];
  $impocons=$subtotcd*$row_Recordset2['impoconsumo'];
  $subtotal=$row_Recordset2['precio']*$row_Recordset2['cantidad'];
  $totDesc=$totDesc+$descuento;
  $totIva=$totIva+$iva;
  $totimpoc=$totimpoc+$impocons;
  $totSub=$totSub+$subtotal;
  $objeto.=$row_Recordset2['producto']." ";
  if($row_Recordset2['iva']<>0){
    $ivaCont=$row_Recordset2['iva'];
  }
  if($row_Recordset2['especificacion']){
    $especificacion=$row_Recordset2['producto']." - ".$row_Recordset2['especificacion'];
  }else{
    $especificacion=$row_Recordset2['producto'];
  }
  
  
  $totaloc=$totaloc+$subtot;
  $pdf->SetAligns(array('C','L','C','R','R','R','R','R','R'));
  $pdf->fill(array(0,0,0,0,0,0,0));
  $pdf->Row(array($item,utf8_decode($especificacion),utf8_decode($row_Recordset2['unidad']),number_format($row_Recordset2['precio'],2),number_format($row_Recordset2['cantidad'],2),number_format(($row_Recordset2['descuento']*100),0)."%",number_format(($row_Recordset2['iva']*100),0)."%",number_format(($row_Recordset2['impoconsumo']*100),0)."%",number_format($subtot,2)),5);  
	$item++;
}while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
$rows = mysql_num_rows($Recordset2);
if($rows > 0) {
	mysql_data_seek($Recordset2, 0);
  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
}

$linea=$pdf->GetY();
$pdf->Cell(120,5,'OBSERVACIONES',0,0,'L');
$pdf->SetX($linea);

$pdf->SetX(140);
$pdf->Cell(37,5,'SUB-TOTAL',1,0,'R');
$pdf->Cell(23,5,number_format($totSub,2),1,1,'R');

$pdf->SetX(140);
$pdf->Cell(37,5,'DESCUENTO',1,0,'R');
$pdf->Cell(23,5,number_format($totDesc,2),1,1,'R');

$pdf->SetX(140);
$pdf->Cell(37,5,'IVA',1,0,'R');
$pdf->Cell(23,5,number_format($totIva,2),1,1,'R');

$pdf->SetX(140);
$pdf->Cell(37,5,'IMPOCONSUMO',1,0,'R');
$pdf->Cell(23,5,number_format($totimpoc,2),1,1,'R');

$pdf->SetX(140);
$pdf->Cell(37,5,'TOTAL',1,0,'R');
$pdf->Cell(23,5,number_format($totaloc,2),1,1,'R');
$linea1=$pdf->GetY();

$pdf->Rect(20, $linea, 120, ($linea1-$linea));

$pdf->SetFont('Arial','',10);

$pdf->Cell(90,9,utf8_decode('ELABORÓ:'),1,0,'C');
$pdf->Cell(90,9,utf8_decode('APROBÓ:'),1,1,'C');

$pdf->SetFont('Arial','',9);
$linea=$pdf->GetY();
$pdf->MultiCell(90,9,utf8_decode($row_Recordset3['nombre']." ".$row_Recordset3['apellido']),1,'C');
$pdf->SetXY(110,$linea);
$pdf->MultiCell(90,9,utf8_decode($row_Recordset4['nombre']." ".$row_Recordset4['apellido']),1,'C');

$linea=$pdf->GetY();
$pdf->MultiCell(90,9,utf8_decode($row_Recordset3['cargo']),1,'C');
$pdf->SetXY(110,$linea);
$pdf->MultiCell(90,9,utf8_decode($row_Recordset4['cargo']),1,'C');

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(180,4,utf8_decode('Los productos y servicios suministrados son verificados y recibidos previo aprobación del área encargada, aquellos productos y servicios que no cumplen con los requisitos establecidos y acordados no serán recibidos.'),1,'J');
$pdf->MultiCell(180,4,utf8_decode('Anualmente los proveedores que han ofrecido sus productos y servicios son evaluados con el fin de determinar las mejoras necesarias, así como la continuidad de la relación comercial.'),1,'J');

$pdf->SetFont('Arial','',8);

$pdf->Output();

unlink($ruta_qr);


mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
	



?>