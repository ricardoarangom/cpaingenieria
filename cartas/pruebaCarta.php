<?php
require_once('../connections/datos.php');
require_once '../phpword/src/PhpWord/Autoloader.php';

session_start();
$usuario=$_SESSION['IdUsuario'];

if($_GET['carta']){
  $IdCarta=$_GET['carta'];
}else{
  $IdCarta=1;
}

// echo $IdCarta;
// exit();

$buscaCarta = "SELECT 
                    IdCarta,
                    destinatario1,
                    destinatario2,
                    destinatario3,
                    destinatario4,
                    destinatario5,
                    asunto,
                    fecha,
                    cartas.IdUsuario,
                    firmante,
                    cargo,
                    firma,
                    email,
                    fenvio,
                    ano,
                    consAno,
                    consello,
                    anulada
                FROM
                    cartas left join firmas on cartas.IdFirma=firmas.IdFirma
                WHERE
                    IdCarta = ".$IdCarta."  ";
$resultadoCarta = mysql_query($buscaCarta, $datos) or die(mysql_error());
$filaCarta = mysql_fetch_assoc($resultadoCarta);
$totalfilas_buscaCarta = mysql_num_rows($resultadoCarta);


$buscaAnexos = "SELECT 
                    nombre,
                    vinculo
                FROM
                    anexoscartas
                WHERE
                    IdCarta = ".$IdCarta."  ";
$resultadoAnexos = mysql_query($buscaAnexos, $datos) or die(mysql_error());
$filaAnexos = mysql_fetch_assoc($resultadoAnexos);
$totalfilas_buscaAnexos = mysql_num_rows($resultadoAnexos);

function fechaactual6($fecha){
switch (date("n",strtotime($fecha))){
	case 1:
	 $mes="Enero";
	 break;
	case 2:
	 $mes="Febrero";
	 break;
	case 3:
	 $mes="Marzo";
	 break;
	case 4:
	 $mes="Abril";
	 break;
	case 5:
	 $mes="Mayo";
	 break;
	case 6:
	 $mes="Junio";
	 break;
	case 7:
	 $mes="Julio";
	 break;
	case 8:
	 $mes="Agosto";
	 break;
	case 9:
	 $mes="Septiembre";
	 break;
	case 10:
	 $mes="Octubre";
	 break;
	case 11:
	 $mes="Noviembre";
	 break;
	case 12:
	 $mes="Diciembre";
	break;
}


$linea=date("d",strtotime($fecha)) . " de " . $mes . " de " . date("Y",strtotime($fecha));
return $linea;	
	
}



// \PhpOffice\PhpWord\Autoloader::register();

// use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\Style\Font;
// use PhpOffice\PhpWord\SimpleType\Jc;
// use PhpOffice\PhpWord\Shared\Converter;
// use PhpOffice\PhpWord\Style\Tab;
// use PhpOffice\PhpWord\Settings;

\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;

use PhpOffice\PhpWord\Style\Tab;

// Crear nuevo documento
$documento = new PhpWord();

$documento->addParagraphStyle('NoSpaceAfter', [
    'spaceAfter' => 0,          // Espaciado posterior a 0 twips
    'spaceBefore' => 0,         // Opcional: también puedes poner el espacio anterior a 0
    'lineHeight' => 1.0       // Opcional: altura de línea estándar
    
]);

// Configurar sección con márgenes
$seccion = $documento->addSection([
    'headerHeight' => Converter::cmToTwip(0.8),
    'footerHeight' => Converter::cmToTwip(0.5),
    'marginTop'    => Converter::cmToTwip(2.5),
    'marginBottom' => Converter::cmToTwip(2.5),
    'marginLeft'   => Converter::cmToTwip(2.5),
    'marginRight'  => Converter::cmToTwip(2.5)
]);


// Agregar encabezado y pie de página si existen las imágenes
$header = $seccion->addHeader();
if (file_exists('../imagenes/encabezado.png')) {
    $header->addImage('../imagenes/encabezado.png', ['width' => 600, 'height' => 100, 'alignment' => 'center']);
}

$footer = $seccion->addFooter();
if (file_exists('../imagenes/pie.png')) {
    $footer->addImage('../imagenes/pie.png', ['width' => 600, 'height' => 50, 'alignment' => 'center']);
}


// Estilos de fuente
$estiloTitulo = ['bold' => true, 'size' => 11, 'name' => 'Arial', 'smallCaps' => true];
$estiloNormal = ['size' => 11, 'name' => 'Arial'];
$estiloNegrita = ['bold' => true, 'size' => 11, 'name' => 'Arial'];
$estiloResaltado = ['size' => 11, 'name' => 'Arial'];
$estilorojoNegrita = ['color' => 'FF0000', 'bold' => true, 'size' => 12];

$documento->addParagraphStyle('tabSecillo', [
    'tabs' => [
        // Tabulación izquierda a 1550 twips (aprox. 2.7 cm)
        new Tab(Tab::TAB_STOP_LEFT, 7600)
        // Tabulación centrada a 3200 twips (aprox. 5.6 cm)
        // new Tab(Tab::TAB_STOP_CENTER, 3200),
        // Tabulación derecha a 5300 twips (aprox. 9.3 cm) con relleno de puntos
        // new Tab(Tab::TAB_STOP_RIGHT, 5300, Tab::TAB_LEADER_DOT),
    ]
]);

$documento->addParagraphStyle('indentado', [
    'indentation' => [
        'left' => 1200,  
        'firstLine' => -1200,
    ]
]);

// Fecha de la carta

$seccion->addTextBreak(0.5);

$textRun1 = $seccion->addTextRun('tabSecillo');
$textRun1->addText('Bogotá D.C., '.fechaactual6($filaCarta['fecha']));
$textRun1->addText("\t");
$textRun1->addText('CPA-'.sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano'], ['bold' => true,]);

$seccion->addTextBreak(1);

// Destinatario

$seccion->addText( 
 		'Señores',
    null,
    'NoSpaceAfter' 
);
$seccion->addText( 
  $filaCarta['destinatario1'],
  null,
  'NoSpaceAfter' 
);
if($filaCarta['destinatario2']){
  $seccion->addText(  
    $filaCarta['destinatario2'],
    null,
    'NoSpaceAfter'  
  );
}
if($filaCarta['destinatario3']){
  $seccion->addText(  
    $filaCarta['destinatario3'],
    null,
    'NoSpaceAfter'  
  );  
}
if($filaCarta['destinatario4']){  
  $seccion->addText( 
    $filaCarta['destinatario4'],
    null,
    'NoSpaceAfter'  
  );
}

$seccion->addTextBreak(1);

$textRun2 = $seccion->addTextRun('indentado');
$textRun2->addText('Referencia:   ');
$textRun2->addText($filaCarta['asunto'], ['bold' => true]);

$seccion->addTextBreak(1);

$seccion->addText("PEGUE ACA EL CONTENIDO DEL COMUNICADO", $estilorojoNegrita);

$seccion->addTextBreak(1);

$seccion->addText( 
  'Agradecemos su atención.'
);

$seccion->addText( 
  'Atentamente,',
  null,
  'NoSpaceAfter'  
);

$tabla = $seccion->addTable();
$tabla->addRow();
if($filaCarta['firma']){
  $tabla->addCell(1200)->addImage($filaCarta['firma'], ['width' => 150]);
}else{
  $tabla->addCell(1200)->addText(
    ''
  );
}
if($filaCarta['consello']==1){
  $tabla->addCell(1200)->addImage('../imagenes/sello.png', ['width' => 180]);
}else{
  $tabla->addCell(1200)->addText(
    ''
  );
}

$seccion->addText(  
  $filaCarta['firmante'],
  null,
  'NoSpaceAfter' 
);


$seccion->addText(  
  $filaCarta['cargo'],
  null,
  'NoSpaceAfter'  
);
$seccion->addText(  
  'CPA INGENIERIA S.A.S.'  
);

if($totalfilas_buscaAnexos>0){
  $tabla = $seccion->addTable();
  $tabla->addRow();
  $tabla->addCell(850)->addText(
    htmlspecialchars(
      'ANEXOS:'
    ),
    array('name' => 'Arial', 'size' => '8')
  );

  $cell1_2 = $tabla->addCell(6000);
  do{
    $cell1_2->addText(
      $filaAnexos['nombre'],
      array('name' => 'Arial', 'size' => '8'),
      'NoSpaceAfter'
      // array('name' => 'Arial', 'size' => '8')
    );
  } while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));
  $rows = mysql_num_rows($resultadoAnexos);
  if($rows > 0) {
      mysql_data_seek($resultadoAnexos, 0);
    $filaAnexos = mysql_fetch_assoc($resultadoAnexos);
  }

}

$seccion->addTextBreak(1);




$nombreArchivo = 'CPA-'.sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano'].'.docx';;

header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

$objWriter = IOFactory::createWriter($documento, 'Word2007');
$objWriter->save('php://output');
exit();

