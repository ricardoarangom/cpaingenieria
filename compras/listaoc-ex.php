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
$objPHPExcel->getActiveSheet()->setTitle('Ordenes-de-Compra');

$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setWrapText(true);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(37.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(42.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12.71);

$fila=1;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'OC');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 'SC');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, 'SOLICITANTE');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, 'AREA');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, 'SOLICITADO');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, 'COMPRADO');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'RECIBIDO');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, 'PROVEEDOR');
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, 'EVALUACION');

$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, 'CALIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, 'PRECIO');
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, 'CONDICIONES DE PAGO');
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, 'CUMPLIMIENTO');
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, 'ASPECTOS HIIGIENE Y SEGURIDAD INDUSTRIAL');
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, 'ASPECTOS DE GESTION AMBIENTAL');
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, 'ASPECTOS DE RSE');
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, 'TOTAL ORDEN');


$fila++;

foreach($tabla as $key=>$j){

  if($j['evaluacion']>0){
    $evaluacion=$j['evaluacion'];
  }else{
    $evaluacion="S. E.";
  }

  $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $key);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $j['sc']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $j['solicitante']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $j['area']);

  if($j['fsolicitud']){
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fsolicitud']));
  }
  if($j['comprado']){
   $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['comprado'])); 
  }
  if($j['recibido']){
   $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['recibido'])); 
  }	
	
	
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $j['proveedor']);
  $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $evaluacion);

  $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $j['calpro']);
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $j['precio']);
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $j['condpago']);
  $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $j['cumplimiento']);
  $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $j['higsegind']);
  $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $j['gesamb']);
  $objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $j['rse']);
  $objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $j['total']);

  $fila++;
}

// PHPExcel_Shared_Date::PHPToExcel($j['fsolicitud'])
// PHPExcel_Shared_Date::PHPToExcel($j['comprado'])
// PHPExcel_Shared_Date::PHPToExcel($j['recibido'])

$fila--;

$objPHPExcel->getActiveSheet()->getStyle('E2:G'.($fila))->applyFromArray($centradoH);
$objPHPExcel->getActiveSheet()->getStyle('I2:I'.($fila))->applyFromArray($centradoH);

$objPHPExcel->getActiveSheet()->getStyle('E2:G'.$fila)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');

$objPHPExcel->getActiveSheet()->getStyle('Q2:Q'.$fila)->getNumberFormat()->setFormatCode('#,##0');

$objPHPExcel->getActiveSheet()->getStyle('A2:Q'.($fila))->applyFromArray($estiloCuerpo);



$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$filename = "Ordenes-de-Compra.xls";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('php://output');

$writer->save('php://output');