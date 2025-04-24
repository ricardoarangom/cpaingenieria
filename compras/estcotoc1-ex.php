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
$objPHPExcel->getActiveSheet()->setTitle('Solicitudes-de-Compra');

$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(37.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14.71);

$fila=1;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'SC');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 'SOLICITANTE');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, 'AREA');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, 'SOLICITADO');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, 'COTIZADO');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, 'COMPRADO');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'ESTADO');

$fila++;

foreach($tabla as $key=>$j){
  
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $key);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $j['solicitante']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $j['area']);

  if($j['fsolicitud']){
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['fsolicitud']));
  }
  if($j['cotizado']){
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['cotizado'])); 
  }
  if($j['comprado']){
    if($j['cantItem']==$j['rechazada']){                    
    }else{
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, PHPExcel_Shared_Date::PHPToExcel($j['comprado'])); 
    }    
  }	
  
  if($j['cantItem']==$j['autorizada']){
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'AUTORIZADA');
  }
  if($j['cantItem']==$j['rechazada']){
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'RECHAZADA');
  }
  if($j['cantItem']==$j['espera']){
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'EN ESPERA');
  }
  if($j['autorizada'] and $j['rechazada']){
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'AUTORIZADA PARCIALMENTE');
  }
  
  $fila++;
}

$fila--;

$objPHPExcel->getActiveSheet()->getStyle('D2:F'.($fila))->applyFromArray($centradoH);

$objPHPExcel->getActiveSheet()->getStyle('D2:F'.$fila)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');

$objPHPExcel->getActiveSheet()->getStyle('A2:G'.($fila))->applyFromArray($estiloCuerpo);

$objPHPExcel->getActiveSheet()->getStyle('G2:G'.$fila)->getAlignment()->setWrapText(true);



$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$filename = "Solicitudes-de-Compra.xls";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('php://output');

$writer->save('php://output');



