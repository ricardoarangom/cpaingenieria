<?php
require_once('../fpdf/fpdf.php');
require_once('../phpqrcode/qrlib.php');
include('../includes/formatopdf.php');






$title="ORDEN DE COMPRA";
$ancho=210;
$codigo="FC-CO-10";
$version="01";
$fecha="24/08/2020";
$ruta_qr = 'qr/prueba.png';

$level = "Q";
$tamano = 10;
$framSize =3;

QRcode::png('prueba',$ruta_qr,$level,$tamano,$framSize);


$pdf = new PDF('P','mm',Letter);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(20);
$pdf->SetAutoPageBreak(1,40);
$pdf->AddPage();


for($i=1;$i<100;$i++){
  $pdf->Cell(170,5,utf8_decode('ELABORÓ:'),1,1,'C');
}



// Agregar más contenido al PDF (opcional)


// Salida del PDF

$pdf->Output(); // 'D' para descargar automáticamente