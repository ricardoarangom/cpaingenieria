<?php  require_once('../connections/datos.php');?>
<?php

set_time_limit(0);

require_once('../fpdf/fpdf.php');
require_once('../funciones.php');
require_once('../phpqrcode/qrlib.php');
include('../includes/formatopdf1.php');
?>

<?php

if(isset($_POST['gviaje'])){
 $gviaje=$_POST['gviaje'];
}
if(isset($_GET['gviaje'])){
 $gviaje=$_GET['gviaje']; 
}

//$gviaje=1;


session_start();
$usuario=$_SESSION['IdUsuario'];

//$usuario=1;



$busca="SELECT IdItem, IdGviaje, rubro, cantidad, vunitario FROM itemgviaje WHERE IdGviaje=".$gviaje;
$resultado = mysql_query($busca, $datos) or die(mysql_error());
$fila = mysql_fetch_assoc($resultado);
$totalfilas = mysql_num_rows($resultado);


$busca2="SELECT gviaje.IdGviaje, usuarios.nombre, usuarios.apellido, usuarios.cedula, usuarios.cargo, area, ccostos, municipio, departamentos, fsalida, fregreso, actividad, beneficiario, banco, ccuenta, gviaje.cuenta, usuarios_1.nombre as nombrea, usuarios_1.apellido as apellidoa, usuarios_1.cargo as cargoa, fautorizacion, rechazada, gviaje.cedula as cedulab FROM ((((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join bancos on gviaje.IdBanco=bancos.IdBanco) left join clasecuenta on gviaje.clasecuenta=clasecuenta.IdClasecuenta) left join usuarios as usuarios_1 on gviaje.IdAutorizador=usuarios_1.IdUsuario where IdGviaje=".$gviaje;
$resultado2 = mysql_query($busca2, $datos) or die(mysql_error());
$fila2 = mysql_fetch_assoc($resultado2);


$title="SOLICITUD DE ANTICIPO DE GASTOS DE VIAJE";
$subtitulo=$gviaje;
$ancho=210;

$ruta_qr = 'qr/qr-'.$gviaje.'.png';

$texto='https://compras.cpaingenieria.com/gviaje/gviaje-pdf.php?gviaje='.$gviaje;
$level = "Q";
$tamano = 10;
$framSize =3;

QRcode::png($texto,$ruta_qr,$level,$tamano,$framSize);

$pdf = new PDF('P','mm',Letter);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(20);
$pdf->SetAutoPageBreak(1,40);
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$pdf->SetWidths(array(30,60,30,60));
$pdf->SetAligns(array('L','L','L','L'));
$pdf->SetBorde(array(0,0,0,0));
$pdf->Row(array(utf8_decode("SOLICITANTE: "),utf8_decode($fila2['nombre']." ".$fila2['apellido']),utf8_decode("CÉDULA:"),colocapuntos($fila2['cedula'])));
$pdf->Row(array(utf8_decode("CARGO: "),utf8_decode($fila2['cargo']),utf8_decode("NOMBRE DE PROYECTO:"),utf8_decode($fila2['area'])));
$pdf->Row(array(utf8_decode("CENTRO DE COSTO: "),utf8_decode($fila2['ccostos']),utf8_decode("LUGAR:"),utf8_decode($fila2['municipio']."\n".$fila2['departamentos'])));
$pdf->Row(array(utf8_decode("F. DE SALIDA: "),fechaactual3($fila2['fsalida']),utf8_decode("F DE REGRESO:"),fechaactual3($fila2['fregreso'])));

$pdf->SetWidths(array(30,90,60));
$pdf->SetAligns(array('L'));
$pdf->Row(array(utf8_decode("NOMBRE DEL VIAJERO: "),utf8_decode($fila2['beneficiario']),"CEDULA:\n".colocapuntos($fila2['cedulab'])));

$pdf->SetWidths(array(30,60,30,60));
$pdf->SetAligns(array('L','L','L','L'));
$pdf->Row(array(utf8_decode("TIPO / No DE CUENTA BANCARIA: "),utf8_decode($fila2['ccuenta']."\n".$fila2['cuenta']),utf8_decode("BANCO:"),utf8_decode($fila2['banco'])));

$pdf->SetFont('Arial','B',11);
$pdf->Cell(180,6,utf8_decode("ACTIVIDAD A DESARROLLAR"),1,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->MultiCell(180,5,utf8_decode(strtoupper($fila2['actividad'])),1,'L');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(180,6,utf8_decode("DESCRIPCION ESTIMADA DEL ANTICIPO"),1,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->SetWidths(array(15,75,30,30,30));
$pdf->SetAligns(array('C','C','C','C','C'));
$pdf->Row(array(utf8_decode("ITEM"),utf8_decode("DESCRIPCIÓN"),utf8_decode("CANTIDAD"),utf8_decode("VALOR UNITARIO"),utf8_decode("VALOR TOTAL")));

$pdf->SetFont('Arial','',10);
$pdf->SetAligns(array('C','L','R','R','R'));
$item=1;
$vtotal=0;
do{
  $vtotal=$vtotal+($fila['vunitario']*$fila['cantidad']);
  if($fila['rubro']=='taeropuerto'){
    $rubro='TRANSPORTES AEROPUERTO';
  }else{
    $rubro=strtoupper($fila['rubro']);
  }
  $pdf->Row(array($item,utf8_decode($rubro),$fila['cantidad'],number_format($fila['vunitario']),number_format($fila['vunitario']*$fila['cantidad'])));
  $item++;
}while($fila = mysql_fetch_assoc($resultado));
$pdf->SetFont('Arial','B',10);
$pdf->SetWidths(array(150,30));
$pdf->SetAligns(array('C','R'));
$pdf->Row(array(utf8_decode("TOTAL"),number_format($vtotal)));

$pdf->SetFont('Arial','B',11);
$pdf->Cell(180,6,utf8_decode("Certificación y Firma del Empleado"),1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(180,4,utf8_decode("Acepto que el valor del anticipo de gastos de viaje, tiketes y/o cualquier otro valor que se me entregue mediante la firma del presente comprobante no constituye salario para ninguen efecto legal o extralegal, conforme a lo establecido en el Art 15 de la ley 50 de 1990. Los anticipos y tiketes que me entreguen por el presente documento me comprometo a legalizarlo totalmente dentro de los 48 horas siguentes a  la terminación del viaje, de lo contrario los dineros objeto del anticipo entregados se descontarán de mi salario o liquidación   del contrato de prestaciones de servicios firmado con ustedes o cualquier pago que se me haga en mi liquidación; lo que expresamente autorizo con la firma del presenta documento. "),1,'C');

$pdf->ln(10);
$linea=$pdf->GetY();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,4,utf8_decode("Nombre del Viajero:"),0,0,'L');
$pdf->MultiCell(50,4,utf8_decode($fila2['beneficiario']),0,'L');

$pdf->SetY($linea);
$pdf->SetX(110);
$pdf->Cell(40,4,utf8_decode("Firma del Viajero:"),0,0,'L');

$pdf->line(150,$linea+5,200,$linea+5);

$pdf->ln(10);
$linea=$pdf->GetY();
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(40,4,utf8_decode("Autorizado / Rechazado por: "),0,'L');

$pdf->SetY($linea);
$pdf->SetX(60);
$pdf->MultiCell(50,4,utf8_decode($fila2['nombrea']." ".$fila2['apellidoa']),0,'L');

$pdf->SetY($linea);
$pdf->SetX(110);
$pdf->Cell(40,4,utf8_decode("Cargo:"),0,0,'L');
$pdf->MultiCell(50,4,utf8_decode($fila2['cargoa']),0,'L');

$pdf->ln(8);
$linea=$pdf->GetY();
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(40,4,utf8_decode("Fecha de aprobación / rechazo: "),0,'L');
$pdf->SetY($linea);
$pdf->SetX(60);

if($fila2['fautorizacion']){
  $feap=fechaactual3($fila2['fautorizacion']);
}else{
  $feap="";
}
$pdf->Cell(50,4,utf8_decode($feap),0,0,'L');

if($fila2['rechazada']==1){
  $pdf->SetY($linea);
  $pdf->SetX(110);

  $pdf->SetTextColor(255, 0, 0);
  $pdf->Cell(40,4,utf8_decode("RECHAZADA"),0,0,'L');
  // Volvemos al color negro
  $pdf->SetTextColor(0, 0, 0);
    
}


$pdf->Output();











unlink($ruta_qr);


 

  

	



?>