<?php 
set_time_limit(0);
require_once ('../excel/PHPExcel.php');
$tabla = ( unserialize(base64_decode($_POST['tabla'])) );
?>
<?php 
// echo count($tabla);
// echo "<pre>";
// print_r($tabla);
// echo "</pre>";

$objPHPExcel = new PHPExcel();



$objPHPExcel->getProperties()
        ->setCreator("Ricardo Arango M")
        ->setLastModifiedBy("Ricardo Arango M")
        ->setTitle("Ordenes de Compra")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado por CPA")
        ->setKeywords("Ordenes de Compra")
        ->setCategory("Ordenes de Compra");

$estiloTituloColumnas = array(
    'font' => array(
    'name'  => 'Calibri',
    'bold'  => true,
    'size' =>10,
    'color' => array(
    'rgb' => '000000'
    )
    ),
    'fill' => array(
	  'type' => PHPExcel_Style_Fill::FILL_SOLID,
	  'color' => array('rgb' => '92d050')
    ),
    'borders' => array(
	  'allborders' => array(
	  'style' => PHPExcel_Style_Border::BORDER_THIN
	  )
    ),
    'alignment' =>  array(
	  'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	  'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloCuerpo = array(
  'borders' => array(
    'allborders' => array(
    'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  ),
  
  'font' => array(
    'name'  => 'Calibri',
    'size' =>10,
  ),
  
  'alignment' =>  array(
	  'vertical'  => PHPExcel_Style_Alignment::VERTICAL_TOP
  )
);


$centradoH = array(
  'alignment' =>  array(
  'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
  )
);

$alineadoHL = array(
  'alignment' =>  array(
  'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT
  )
);

$estiloFondoAnulada = array(
    'fill' => array(
	  'type' => PHPExcel_Style_Fill::FILL_SOLID,
	  'color' => array('rgb' => 'ffebeb')
    )
);

$estiloFondoPagada = array(
    'fill' => array(
	  'type' => PHPExcel_Style_Fill::FILL_SOLID,
	  'color' => array('rgb' => 'dcffdc')
    )
);


$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('G-viaje');

$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($estiloTituloColumnas);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(42.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(41.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(46.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(46.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(26.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15.71);

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(16.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(16.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.71);


$fila=1;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'No. Sol.');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 'FECHA SOLICITUD');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, 'SOLICITANTE');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, 'QUIEN VIAJA');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, 'AREA/PROYECTO');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, 'ACTIVIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'FECHA SALIDA');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, 'FECHA REGRESO');
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, 'DESTINO');
$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, 'TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, 'FECHA AUTORIZ.');
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, 'FECHA DE PAGO');
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, 'APROB.');
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, 'LEGAL.');

$fila++;

foreach($tabla as $key=>$j){
  
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $key);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fsolicitud']));
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $j['solicitante']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $j['beneficiario']);
  $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $j['area']);
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $j['actividad']);
  $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fsalida']));
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fregreso']));

  $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $j['municipio']." - ".$j['departamento']);
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $j['total']);

  if($j['fautorizacion']){
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fautorizacion']));
  }
  if($j['fpago']){
   $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fpago'])); 
  }  	
		
  $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $j['aprob']);
  $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $j['legal']);

  $fila++;
}

$fila--;

$objPHPExcel->getActiveSheet()->getStyle('B2:B'.($fila))->applyFromArray($centradoH);
$objPHPExcel->getActiveSheet()->getStyle('G2:H'.($fila))->applyFromArray($centradoH);
$objPHPExcel->getActiveSheet()->getStyle('K2:N'.($fila))->applyFromArray($centradoH);

$objPHPExcel->getActiveSheet()->getStyle('B2:B'.$fila)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');
$objPHPExcel->getActiveSheet()->getStyle('G2:H'.$fila)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');
$objPHPExcel->getActiveSheet()->getStyle('K2:L'.$fila)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');

$objPHPExcel->getActiveSheet()->getStyle('J2:J'.$fila)->getNumberFormat()->setFormatCode('#,##0');

$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$fila)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('IF2:I'.$fila)->getAlignment()->setWrapText(true);


$objPHPExcel->getActiveSheet()->getStyle('A2:N'.($fila))->applyFromArray($estiloCuerpo);



$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$filename = "G-viaje.xls";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('php://output');

$writer->save('php://output');