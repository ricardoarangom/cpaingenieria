<?php 
require_once('../connections/datos.php');
require_once '../phpword/src/PhpWord/Autoloader.php';

set_time_limit(0);
require_once('../funciones.php');
?>
<?php
session_start();
$usuario=$_SESSION['IdUsuario'];

if($_GET['carta']){
  $IdCarta=$_GET['carta'];
}else{
  $IdCarta=1;
}


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

$buscaParrafos = "SELECT 
                      IdParrafo, IdCarta, parrafo, titulo
                  FROM
                      parrafoscartas
                  WHERE
                      IdCarta = ".$IdCarta."  ";
$resultadoParrafos = mysql_query($buscaParrafos, $datos) or die(mysql_error());
$filaParrafos = mysql_fetch_assoc($resultadoParrafos);
$totalfilas_buscaParrafos = mysql_num_rows($resultadoParrafos);

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


\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

$documento = new PhpWord();

$seccion = $documento->addSection([
    'headerHeight' => Converter::cmToTwip(0.8),  // 1 cm desde el borde superior al encabezado
    'footerHeight' => Converter::cmToTwip(0.5), // 1.2 cm desde el borde inferior al pie de página
    'marginTop'    => Converter::cmToTwip(2.5), // Margen superior del contenido principal
    'marginBottom' => Converter::cmToTwip(2.5), // Margen inferior del contenido principal
    'marginLeft'   => Converter::cmToTwip(2.5),   // Margen izquierdo del contenido principal
    'marginRight'  => Converter::cmToTwip(2.5)    // Margen derecho del contenido principal
]);

// $seccion = $documento->addSection();

$header = $seccion->addHeader();
$header->addImage('../imagenes/encabezado.png', ['width' => 600, 'height' => 100]);

$footer = $seccion->addFooter();
$footer->addImage('../imagenes/pie.png', ['width' => 600, 'height' => 50]);

$fuente = new Font();
$fuente->setBold(true);
$fuente->setName('Arial');
$fuente->setSize(10);

$documento->addParagraphStyle('NoSpaceAfter', [
    'spaceAfter' => 0,          // Espaciado posterior a 0 twips
    'spaceBefore' => 0,         // Opcional: también puedes poner el espacio anterior a 0
    'lineHeight' => 1.0       // Opcional: altura de línea estándar
    
]);

$documento->addParagraphStyle('medioEspacio', [
    'spaceAfter' => 0.5,          // Espaciado posterior a 0 twips
    'spaceBefore' => 0,         // Opcional: también puedes poner el espacio anterior a 0
    'lineHeight' => 1.0       // Opcional: altura de línea estándar
    
]);


$seccion->addTextBreak(0.5);

$tabla = $seccion->addTable();
$tabla->addRow();

if($filaCarta['fenvio']){
  $tabla->addCell(8500)->addText(
    htmlspecialchars(
        ('Bogotá D.C., '.fechaactual6($filaCarta['fenvio']))
    )
  );
}else if($filaCarta['anulada']==0){
  $tabla->addCell(8500)->addText(
    htmlspecialchars(
        ('Bogotá D.C., '.fechaactual6(date("Y-m-d")))
    )
  );
}else{
  $tabla->addCell(8500)->addText(
    htmlspecialchars(
        ('Bogotá D.C., '.fechaactual6($filaCarta['fecha']))
    )
  );
}


$texto = $tabla->addCell(1500)->addText(
  htmlspecialchars(
    'CPA-'.sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano']
  )
);
$texto->setFontStyle($fuente);

$seccion->addTextBreak(1);


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

$tabla = $seccion->addTable();
$tabla->addRow();
$tabla->addCell(1300)->addText(
  htmlspecialchars(
      'Referencia: '
  )
);
$texto = $tabla->addCell(8700)->addText(
  htmlspecialchars(
    $filaCarta['asunto']
  )
);
$texto->setFontStyle($fuente);



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

//Guardando documento
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($documento, 'Word2007');
$archivo='CPA-'.sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano'].'.docx';
$objWriter->save($archivo);

header("Content-Disposition: attachment; filename=$archivo");
echo file_get_contents($archivo);
unlink($archivo);
?>
<?php 

