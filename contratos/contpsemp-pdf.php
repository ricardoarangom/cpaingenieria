<?php 
require_once('../connections/datos.php');
?>
<?php 

set_time_limit(0);

require_once('../fpdf/fpdf.php');
require_once('../fpdf/WriteTag.php');
require_once('../funciones.php');
?>
<?php



class PDF extends PDF_WriteTag {

  var $widths; 
  var $aligns;
  var $borde;
  var $fill;
    
  function SetWidths($w) 
  { 
      //Set the array of column widths 
      $this->widths=$w; 
  } 
  
  function SetAligns($a) 
  { 
      //Set the array of column alignments 
      $this->aligns=$a; 
  } 
  
  function fill($f)
  {
      //juego de arreglos de relleno
      $this->fill=$f;
  }
  
  function SetBorde($m)
  {
      $this->borde=$m;
  }
    
    
    
  function Row($data) 
  { 
      //Calculate the height of the row 
      $nb=0; 
      for($i=0;$i<count($data);$i++) 
          $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
      $h=5*$nb; 
      //Issue a page break first if needed 
      $this->CheckPageBreak($h); 
      //Draw the cells of the row 
      for($i=0;$i<count($data);$i++) 
      { 
          $f=$this->fill[$i];
          $m=$this->borde[$i];
          $w=$this->widths[$i]; 
          $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
          //Save the current position 
          $x=$this->GetX(); 
          $y=$this->GetY(); 
          //Draw the border 
          $this->Rect($x,$y,$w,$h,$style); 
          //Print the text 
          $this->MultiCell($w,4.5,$data[$i],$m,$a,$f); 
          //Put the position to the right of the cell 
          $this->SetXY($x+$w,$y); 
      } 
      //Go to the next line 
      $this->Ln($h); 
  } 
  

  function CheckPageBreak($h) 
  { 
      //If the height h would cause an overflow, add a new page immediately 
      if($this->GetY()+$h>$this->PageBreakTrigger) 
          $this->AddPage($this->CurOrientation); 
  } 

  function NbLines($w,$txt) 
  { 
    //Computes the number of lines a MultiCell of width w will take 
    $cw=&$this->CurrentFont['cw']; 
    if($w==0) 
        $w=$this->w-$this->rMargin-$this->x; 
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
    $s=str_replace("\r",'',$txt); 
    $nb=strlen($s); 
    if($nb>0 and $s[$nb-1]=="\n") 
        $nb--; 
    $sep=-1; 
    $i=0; 
    $j=0; 
    $l=0; 
    $nl=1; 
    while($i<$nb) 
    { 
        $c=$s[$i]; 
        if($c=="\n") 
        { 
            $i++; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
            continue; 
        } 
        if($c==' ') 
            $sep=$i; 
        $l+=$cw[$c]; 
        if($l>$wmax) 
        { 
            if($sep==-1) 
            { 
                if($i==$j) 
                    $i++; 
            } 
            else 
                $i=$sep+1; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
        } 
        else 
            $i++; 
    } 
    return $nl; 
  } 

  function Header()
  {
    // global $title;
    // global $subtitulo;
    global $ancho;
    // global $subtitulo1;
    
    
    $this->SetFont('Arial','',8);
  
    $this->SetY(10);
    $this->SetX(100);
    $this->Cell(90,3.5,utf8_decode("Calle 106 # 59-21 - PBX: (57-1) 3229320"),0,1,'R');
    $this->SetX(100);   
    $this->Cell(90,3.5,utf8_decode("Bogotá D.C. / Colombia"),0,1,'R');
    $this->ln(2);
    $this->SetX(100);
    $this->Cell(90,3.5,utf8_decode("Calle Germán Schreiber 276 - San Isidro"),0,1,'R');
    $this->SetX(100);   
    $this->Cell(90,3.5,utf8_decode("PBX: +51 (1) 480 0114"),0,1,'R');
    $this->SetX(100);   
    $this->Cell(90,3.5,utf8_decode("Lima - Perú"),0,1,'R');
    $this->ln(2);
    $this->SetTextColor(0,80,180);
    $this->SetX(100);   
    $this->Cell(90,3.5,utf8_decode("www.cpaingenieria.com"),0,1,'R');

    $this->SetDrawColor(255,158,126);
    $this->SetLineWidth(0.1);	
    $this->Line(113, 10, 113, 32);
  
    
    $this->Image('../imagenes/logofa.png',23,7,70);
    $this->ln(2);
        
  }
  function Footer()
  {
    // global $ancho;    
    // $this->SetY(-17);
    // $this->Image('../imagenes/banner.png',28,260,160);
    
    
  }
}

?>
<?php

$ancho=210;

$pdf = new PDF('P','mm',Letter);

$pdf->SetStyle("p","Arial","N",10,"0,0,0",0);
$pdf->SetStyle("h1","times","B",12,"0,0,0",0);
$pdf->SetStyle("a","times","BU",8,"0,0,0");
$pdf->SetStyle("sub","Arial","U",0,"0,0,0");
$pdf->SetStyle("li","times","N",0,"0,0,0",5,chr(149));
$pdf->SetStyle("place","arial","U",0,"153,0,0");
$pdf->SetStyle("vb","arial","",0,"153,0,0");
$pdf->SetStyle("neg","Arial","B",0,"0,0,0");

$pdf->SetMargins(20,10,20);
$pdf->AddPage();


$pdf->ln(4);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(176,4.5,utf8_decode('CONTRATO POR PRESTACIÓN DE SERVICIOS'),0,1,'C');
$pdf->Cell(176,4.5,utf8_decode('NO. XXX-2025'),0,1,'C');
$pdf->ln(4);

$txt=utf8_decode('
<p>Entre los suscritos <neg>LUIS HECTOR RUBIANO VERGARA</neg> identificado con la cédula de ciudadanía No. 79.315.619 expedida en Bogotá D.C., domiciliado en la calle 106 No. 59-21 en la ciudad de Bogotá D.C., actuando en nombre y representación de <neg>COMPAÑÍA DE PROYECTOS AMBIENTALES E INGENIERÍA S.A.S. - CPA INGENIERÍA S.A.S.</neg> con NIT 830.042.614-3, sociedad domiciliada en la ciudad de Bogotá D.C., y quien en adelante se denominará EL CONTRATANTE, por la otra, <neg><vb>[NOMBRES Y APELLIDOS]</vb></neg> identificado con la cédula de ciudadanía No. <vb>[variable cedula]</vb>, con domicilio en la <vb>[Carrera 19 #31C-32 Sur en la ciudad de Bogotá D.C.]</vb>, actuando en nombre y representación de <neg><vb>[FUNDACIÓN PATRIMONIO MIXTO]</vb></neg> identificada con <vb>[NIT 901051199-3]</vb> quien para efectos del presente documento se denominará EL CONTRATISTA, acuerdan celebrar el presente contrato de Prestación de Servicios Profesionales, el cual se regirá por las disposiciones del Código de Comercio y en especial por las siguientes cláusulas: </p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);


$txt=utf8_decode('
<p><neg>Primera. - OBJETO:</neg><vb>[variable objeto]</vb></p>
<p><neg>ALCANCE:</neg><vb>[variable alcance]</vb></p>
<p><neg>ACTIVIDADES:</neg><vb>[variable actividades]</vb></p>
<p><neg>PRODUCTOS:</neg><vb>[variable productos]</vb></p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);
  
$txt=utf8_decode('
<p><neg>Segunda. - Plazo.</neg> <vb>[El plazo para la ejecución del presente contrato será desde el día diez (10) de marzo del año 2025 hasta el día veintidós (22) de abril del año 2025]</vb>.</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Tercera. - Valor.</neg> <vb>[El valor total del presente contrato es de: (COP$1.713.600) Un Millón Setecientos Trece Mil Seiscientos Pesos Moneda Corriente, IVA incluido.]</vb>.</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Cuarta. - Forma de Pago.:</neg> Se realizará un único pago por valor de: <vb>[(COP$1.713.600) Un Millón Setecientos Trece Mil Seiscientos Pesos Moneda Corriente, IVA incluido.]</vb> Correspondientes al 100% del valor total del contrato; a la entrega de los productos acordados; previa aprobación por parte de la coordinación del proyecto; 30 días posteriores a la radicación de la factura o cuenta de cobro. Parágrafo: La factura o cuenta de cobro deberá ser radicada antes del 25 de cada mes, adjuntando la planilla de seguridad social correspondiente</vb>.</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Quinta. - Obligaciones de EL CONTRATANTE.</neg> Este deberá facilitar acceso a la información que sea necesaria, de manera oportuna, para la debida ejecución del objeto del contrato y estará obligado a cumplir con lo estipulado en las demás cláusulas y condiciones previstas en este documento.
</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Sexta. - Obligaciones de EL CONTRATISTA.</neg> EL CONTRATISTA deberá cumplir en forma eficiente y oportuna los trabajos encomendados y aquellas obligaciones que se generen en la reunión de planificación o de seguimiento cumpliendo las fechas de entrega programadas. <neg>Parágrafo:</neg> El contratista deberá cumplir cabalmente con sus obligaciones frente al sistema de seguridad social integral de acuerdo a las leyes vigentes.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Séptima. - Vigilancia del contrato.</neg>  EL CONTRATANTE o su representante supervisarán la ejecución del servicio profesional encomendado, y podrá formular las observaciones del caso con el fin de ser analizadas conjuntamente con EL CONTRATISTA y efectuar por parte de éste las modificaciones o correcciones a que hubiere lugar.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4); 

$txt=utf8_decode('
<p><neg>Octava. - Cláusula penal.</neg> En caso de incumplimiento por parte de EL CONTRATISTA de cualquiera de las obligaciones previstas en este contrato no se cancelará el pago final de acuerdo a lo establecido en la Cláusula Cuarta y deberá pagar una indemnización del 50% del presente Contrato más gastos jurídicos.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);  

$txt=utf8_decode('
<p><neg>Novena. - Terminación.</neg> El presente contrato podrá darse por terminado por mutuo acuerdo entre las dos partes, o en forma unilateral por el incumplimiento de las obligaciones derivadas del contrato por cualquiera de ellas y/o por EL CONTRATANTE cuando por razones externas, el proyecto se suspenda o se cancele antes de la fecha pactada.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);  

$txt=utf8_decode('
<p><neg>Décima. Independencia de EL CONTRATISTA.</neg> EL CONTRATISTA actuará por su propia cuenta, con absoluta autonomía y no estará sometido a subordinación laboral con EL CONTRATANTE y sus derechos se limitarán, de acuerdo con la naturaleza del contrato, a exigir el cumplimiento de las obligaciones de EL CONTRATANTE y al pago de los honorarios estipulados por la prestación del servicio.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4); 

$txt=utf8_decode('
<p><neg>Décima primera. - Exclusión de la relación laboral.</neg> Queda claramente entendido que no existirá relación laboral alguna entre EL CONTRATANTE Y CONTRATISTA, o el personal que éste utilice en la ejecución del objeto del presente contrato.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4); 

$txt=utf8_decode('
<p><neg>Décima segunda. - Cesión del contrato.</neg> EL CONTRATISTA no podrá ceder parcial ni totalmente la ejecución del presente contrato a un tercero salvo previa autorización expresa y escrita de EL CONTRATANTE.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Décima tercera. - Domicilio contractual.</neg> Para todos los efectos legales, el domicilio contractual será la ciudad de Bogotá y las notificaciones serán recibidas por las partes en las siguientes direcciones: por EL CONTRATANTE en la calle 106 No.59-21 en la ciudad de Bogotá D.C.; EL CONTRATISTA en la <vb>[Carrera 19 #31C-32 Sur en la ciudad de Bogotá D.C.]</vb>
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

$txt=utf8_decode('
<p><neg>Cláusula compromisoria.</neg> Todas las dudas, cuestiones, discrepancias o reclamaciones que puedan surgir en la interpretación, ejecución o cumplimiento de este acuerdo, o relacionada con él, directa o indirectamente, se resolverán en primer lugar de forma amistosa en la medida de lo posible, mediante negociación directa de las partes, dentro del plazo de quince (15) días a partir de la fecha en que cualquiera de las partes informe a la otra sobre la existencia de una controversia o desavenencia, a falta de un acuerdo en el plazo de un (1) mes o dentro de la prórroga otorgada al mismo, acordada entre las partes, la controversia se resolverá definitivamente mediante arbitraje de derecho ante un Centro de Conciliación, de acuerdo con su reglamento, cuyas disposiciones se entienden incorporadas por referencia de esta cláusula.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4);

  

$txt=utf8_decode('
<p><neg>Decima Cuarta: Protección De Datos Personales:</neg> En atención de lo previsto en la normatividad vigente sobre Tratamiento de Datos Personales (Constitución Política de Colombia, Ley Estatutaria 1581 de 2012, Decreto 1377 de 2013 y las demás disposiciones que en el futuro las adicionen, modifiquen o complementen), tanto EL CONTRATANTE como EL CONTRATISTA declaran que dan estricto cumplimiento a la normatividad citada y en concordancia, LAS PARTES cuentan con políticas, procedimientos y controles propios para el tratamiento de datos personales. EL CONTRATISTA autoriza a EL CONTRATANTE para que lleve a cabo la recolección, almacenamiento, uso, circulación, supresión, transferencia y transmisión (en adelante el “Tratamiento”) de los datos personales (teléfono fijo, celular, e-mail, dirección y ciudad, entre otros), incluidos los datos biométricos y de imagen obtenidos y registrados que se obtengan y/o se suministren con ocasión del presente contrato de sus  empleados, consultores, asesores, socios, encargados y administradores (en adelante, colaboradores). EL CONTRATISTA autoriza a EL CONTRATANTE a Consultar y Reportar, en cualquier tiempo, en Data Crédito o en cualquier otra base de datos manejada por un operador de información financiera y crediticia, toda la información relevante para conocer su desempeño como deudor, su capacidad de pago sobre el cumplimiento o incumplimiento de sus obligaciones crediticias, la viabilidad para entablar o mantener una relación contractual. EL CONTRATISTA, en virtud de la presente relación contractual, otorga Autorización expresa a EL CONTRATANTE para que lleve a cabo el tratamiento de los datos personales de sus colaboradores para efectos del cumplimiento del objeto contractual, sean tratados de acuerdo a las finalidades, procedimientos y en general, las disposiciones de la Política de Privacidad para el Tratamiento de Datos Personales de EL CONTRATANTE. Los datos que sean recolectados por EL CONTRATANTE podrán ser comunicados por su cuenta a otros miembros de la Organización. Durante la vigencia de la relación contractual y mientras exista el deber legal, los datos recolectados permanecerán en nuestra base de datos de conformidad con lo previsto en la Política de Privacidad para el Tratamiento de Datos Personales de EL CONTRATANTE. De la misma manera, EL CONTRATANTE podrá llevar a cabo el tratamiento de la información personal de EL CONTRATISTA con la finalidad de enviarles información comercial que pueda ser de su interés; así como, invitarlos a eventos, remitir boletines, informes sectoriales o publicaciones y en general, utilizar los datos para el desarrollo de las actividades comprendidas en el objeto social de SIMPLE. Tanto EL CONTRATANTE como EL CONTRATISTA serán responsables por cualquier perjuicio que se cause a la otra parte como consecuencia directa o indirecta del incumplimiento de cualquiera de las obligaciones que se desprenden de la presente cláusula.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4); 

$txt=utf8_decode('
<p><neg>Decima Quinta: CLAUSULAS ADICIONALES:</neg> Es obligación del CONTRATISTA no divulgar aquella información que se le haya confiado en virtud del secreto profesional o aquella que deba ser mantenida en reserva por su carácter de confidencial, lo cual haya tenido noticia por cualquier circunstancia, excepción hecha de aquello que el Trabajador deba informar por razones de ley o providencias judiciales. Entiéndase por información confidencial aquella información societaria, técnica, financiera, jurídica, comercial y estratégica de los negocios del Empleador, presentes o futuros.
</p>
'); 

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4); 

$txt=utf8_decode('
<p>Una vez leído, entendido y aprobado por las partes el presente contrato, se firma sin que adolezca de error, fuerza o dolo.
</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(4); 

$txt=utf8_decode('
<p>Para constancia del pleno acuerdo sobre los términos referidos en este contrato, se firma en dos (2) ejemplares del mismo tenor y valor a <vb>[los cinco (05) días del mes de marzo del año 2025 en la ciudad de Bogotá D.C.]</vb>. 
</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);

$pdf->SetLeftMargin(19);
$pdf->ln(20); 
$pdf->SetFont('Arial','B',10);


$linea=$pdf->GetY();

$pdf->Line(20, $linea, 80, $linea);
$pdf->Line(108, $linea, 168, $linea);

$pdf->Cell(88,4.5,utf8_decode('EL CONTRATANTE'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('EL CONTRATISTA'),0,1,'L');

$pdf->Cell(88,4.5,utf8_decode('LUIS HECTOR RUBIANO VERGARA'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');

$pdf->Cell(88,4.5,utf8_decode('C.C. 79.315.619 de Bogotá D.C.'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');

$pdf->Cell(88,4.5,utf8_decode('CPA INGENIERIA S.A.S.'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');

$pdf->Cell(88,4.5,utf8_decode('NIT. 830.042.614-3 '),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');


// ______________________________                                 ___________________________
// EL CONTRATANTE                                                                  EL CONTRATISTA	
// LUIS HECTOR RUBIANO VERGARA                                RAFAEL RICARDO GALINDO CRUZ
// C.C. 79.315.619 de Bogotá D.C.                                  C.C. 1.013.586.423 de Bogotá D.C.
// CPA INGENIERIA S.A.S.                                              FUNDACIÓN PATRIMONIO MIXTO
// NIT. 830.042.614-3                                                                     NIT. 901.051.199-3

  
$pdf->Output();

  







	