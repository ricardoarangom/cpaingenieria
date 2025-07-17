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
    
  
  function Row($data,$bold_column_index) 
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
          if ($i === $bold_column_index) {
              $this->SetFont('', 'B'); // Establecer negrita para la columna específica
              // $this->Cell($w[$i], 6, $row[$i],1, 0, 'L');
              $this->MultiCell($w,4.5,$data[$i],$m,$a,$f);
              $this->SetFont('');      // Restaurar fuente normal
          } else {
              // $this->Cell($w[$i], 6, $row[$i], 1, 0, 'L');
              $this->MultiCell($w,4.5,$data[$i],$m,$a,$f);
          }
          //Print the text 
          // $this->MultiCell($w,4.5,$data[$i],$m,$a,$f); 
          //Put the position to the right of the cell 
          $this->SetXY($x+$w,$y); 
      } 
      //Go to the next line 
      $this->Ln($h); 
  } 
  
  function FancyTable($data, $bold_column_index)
  {
      // Colores, ancho de línea y fuente en negrita
      $this->SetFillColor(255, 0, 0);
      $this->SetTextColor(255);
      $this->SetDrawColor(0, 0, 0);
      $this->SetLineWidth(.1);
      $this->SetFont('', 'B');

      // Cabecera
      $w = array(40, 35); // Ancho de las columnas (ajusta según tus necesidades)
      // for ($i = 0; $i < count($header); $i++)
      //     // $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
      // $this->Ln();

      // Restaurar colores y fuente
      $this->SetFillColor(224, 235, 255);
      $this->SetTextColor(0);
      $this->SetFont('');

      // Datos
      $fill = false;
      foreach ($data as $row) {
          for ($i = 0; $i < count($row); $i++) {
              if ($i === $bold_column_index) {
                  $this->SetFont('', 'B'); // Establecer negrita para la columna específica
                  $this->Cell($w[$i], 6, $row[$i],1, 0, 'L');
                  $this->SetFont('');      // Restaurar fuente normal
              } else {
                  $this->Cell($w[$i], 6, $row[$i], 1, 0, 'L');
              }
          }
          $this->Ln();
          $fill = !$fill;
      }
      // $this->Cell(array_sum($w), 0, '', 'T');
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
    
    $this->SetFont('Arial','B',11);
    $this->SetY(18);
    $this->SetX(55);
    $this->MultiCell(85,5,utf8_decode("CONTRATO DE APRENDIZAJE"),0,'C');

    $this->SetFont('Arial','',8);
  
    $this->SetY(10);
    $this->SetX(140);
    $this->Cell(59,3.5,utf8_decode("Calle 106 # 59-21 - PBX: (57-1) 3229320"),0,1,'R');
    $this->SetX(140);   
    $this->Cell(59,3.5,utf8_decode("Bogotá D.C. / Colombia"),0,1,'R');
    $this->ln(2);
    $this->SetX(140);
    $this->Cell(59,3.5,utf8_decode("Calle Germán Schreiber 276 - San Isidro"),0,1,'R');
    $this->SetX(140);   
    $this->Cell(59,3.5,utf8_decode("PBX: +51 (1) 480 0114"),0,1,'R');
    $this->SetX(140);   
    $this->Cell(59,3.5,utf8_decode("Lima - Perú"),0,1,'R');
    $this->ln(2);
    $this->SetTextColor(0,80,180);
    $this->SetX(140);   
    $this->Cell(59,3.5,utf8_decode("www.cpaingenieria.com"),0,1,'R');

    $this->SetLineWidth(0.1);	
        
    $this->Image('../imagenes/logo1.png',21.5,9.5,30,25);
    $this->ln(2);

    $this->Rect(140, 7, 60, 31);
    $this->Rect(55, 7, 85, 31);
    $this->Rect(17, 7, 38, 31);
    $this->ln(5);    
  }
  function Footer()
  { 

    global $textoPie;

    $this->SetY(-14);
    $pagina='Página '.$this->PageNo().' de {nb}';
    $this->SetFont('Arial','',7);
    $this->Cell(120,3.5,utf8_decode($textoPie),0,0,'L');
    $this->Cell(60,3.5,utf8_decode($pagina),0,1,'R');
    $this->SetDrawColor(255,158,126);
    $this->SetLineWidth(0.1);
    $this->line(0,265,216,265);
    
  }
}

?>
<?php

$ancho=210;
$textoPie = 'Contrato No. NM Variable';

$pdf = new PDF('P','mm',Letter);

$pdf->SetStyle("p","Arial","N",10,"0,0,0",0);
$pdf->SetStyle("h1","times","B",12,"0,0,0",0);
$pdf->SetStyle("a","times","BU",8,"0,0,0");
$pdf->SetStyle("sub","Arial","U",0,"0,0,0");
$pdf->SetStyle("i","Arial","I",0,"0,0,0");
$pdf->SetStyle("li","Arial","N",0,"0,0,0",5,chr(149));
$pdf->SetStyle("place","arial","U",0,"153,0,0");
$pdf->SetStyle("vb","arial","",0,"153,0,0");
$pdf->SetStyle("neg","Arial","B",0,"0,0,0");

$pdf->SetMargins(20,10,20);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ln(4);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(176,4.5,utf8_decode('CONTRATO DE APRENDIZAJE'),0,1,'C');
$pdf->Cell(176,4.5,utf8_decode('NM variable'),0,1,'C');


$pdf->ln(4);
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(70,106));
$pdf->SetAligns(array('L','L'));

$pdf->Row(array(utf8_decode('EMPRESA'),utf8_decode('COMPAÑÍA DE PROYECTOS AMBIENTALES SAS. "CPA INGENIERIA SAS"')),0);
$pdf->Row(array(utf8_decode('NIT'),utf8_decode('830.042.614')),0);

$pdf->Row(array(utf8_decode('DIRECCIÓN'),utf8_decode('CALLE 106 No 59 -21')),0);
$pdf->Row(array(utf8_decode('TELEFONO'),utf8_decode('(601) 3229320')),0);

$pdf->Row(array(utf8_decode('REPRESENTANTE LEGAL'),utf8_decode('LUIS HECTOR RUBIANO VERGARA')),0);
$pdf->Row(array(utf8_decode('CARGO'),utf8_decode('GERENTE GENERAL')),0);
$pdf->Row(array(utf8_decode('CEDULA NO.'),utf8_decode('79.315.619')),0);

$pdf->ln(5);

$pdf->Row(array(utf8_decode('NOMBRE APRENDIZ'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('CEDULA O TARJETA IDENTIDAD'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('FECHA NACIMIENTO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('DIRECCION'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('TELEFONO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('CORREO ELECTRONICO'),utf8_decode('Variable')),0);

$pdf->Row(array(utf8_decode('ESTRATO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('FECHA INICIACIÓN CONTRATO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('FECHA TERMINACIÓN CONTRATO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('ESPECIALIDAD O CURSO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('No. DE GRUPO'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('EPS DEL APRENDIZ'),utf8_decode('Variable')),0);

$pdf->Row(array(utf8_decode('ARL DEL APRENDIZ'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('INSTITUCIÓN DE FORMACION:'),utf8_decode('SENA')),0);
$pdf->Row(array(utf8_decode('NIT:'),utf8_decode('1')),0);
$pdf->Row(array(utf8_decode('SI ES SENA, CENTRO DE FORMACION'),utf8_decode('Variable')),0);

$pdf->ln(5);

$txt=utf8_decode('
<p>Entre los suscritos a saber <neg>LUIS HECTOR RUBIANO VERGARA</neg>, identificado con la cédula de ciudadanía No. 79.315.619 de Bogotá D.C., actuando como Representante Legal de la Empresa COMPAÑIA DE PROYECTOS AMBIENTALES E INGENIERIA S.A.S. - CPA INGENIERIA S.A.S. NIT 830.042.614-3 quien para los efectos del presente Contrato se denominará EMPRESA y <vb>[NOMBRES Y APELLIDOS]</vb> identificado(a) con cédula de ciudadanía No. <vb>[XXXXXXXXX]</vb> expedida en  <vb>[Bogotá D.C.]</vb>, quien para los efectos del presente contrato se denominará el APRENDIZ, se suscribe el presente Contrato de Aprendizaje, conforme a lo preceptuado por la Ley 789 de 2002 y de acuerdo a las siguientes cláusulas:
</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>PRIMERA.-</sub></neg> Objeto. El presente contrato tiene como objeto garantizar al APRENDIZ la formación profesional integral en la especialidad de <vb>[TECNÓLOGO EN GESTIÓN ADMINISTRATIVA]</vb> Grupo <vb>[2774940]</vb>, la cual se impartirá en su etapa lectiva por el  <vb>[(SENA - Centro de Gestión Administrativa - Regional Distrito Capital)]</vb> mientras su etapa práctica se desarrollará en la EMPRESA; <neg>para el caso de los aprendices que pertenecen a Instituciones distintas al SENA se debe tener en cuenta su fase de patrocinio.</neg>
</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>SEGUNDA.</sub></neg> El contrato tiene un término de duración de: <vb>[(9) meses y (2) días]</vb>, comprendidos entre el Día <vb>[(08) Mes (01) Año 2025]</vb> fecha de iniciación del Contrato; y el Día <vb>[(9) Mes (10) Año 2025]</vb> fecha de terminación del mismo. (No podrá excederse el término máximo de dos años contenido en el Artículo 30 de la Ley 789/02) y previa revisión de la normatividad para cada una de las modalidades de patrocinio, el contrato se encuentra distribuido por la siguientes etapas: Etapa Lectiva: Inicio <vb>[Día (08) Mes (01) Año 2025]</vb> Etapa Productiva: <vb>[Inicio Día (11) Mes (04) Año (2025)]</vb> Finalización <vb>[Día (9) Mes (10) Año (2025)]</vb>.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>TERCERA.-</sub></neg> Obligaciones.  1) POR PARTE DE LA EMPRESA.- En virtud del presente contrato la EMPRESA deberá: a) Facilitar al APRENDIZ los medios para que tanto en las fases Lectiva y Práctica, reciba Formación Profesional Integral, metódica y completa en la ocupación u oficio materia del presente contrato.  b) Diligenciar y reportar al respectivo Centro de Formación Profesional Integral del SENA (o por la Institución Educativa donde el aprendiz adelanta sus estudios) las evaluaciones y certificaciones del APRENDIZ en su fase práctica del aprendizaje.  C) Reconocer mensualmente al APRENDIZ, por concepto de apoyo económico para el aprendizaje, durante la etapa lectiva, en el SENA el equivalente al 50% de 1 SMLMV y durante la etapa práctica de su formación el equivalente al 75% de 1 SMLMV y/o al 100% cuando la tasa de desempleo promedio del año inmediatamente anterior sea de un solo digito, para la vigencia 2016 este apoyo será del 100%. (Artículo 30 de la Ley 789 de 2002 y Decreto 451 de 2008) <neg>PARAGRAFO</neg>.- Este apoyo de sostenimiento no constituye salario en forma alguna, ni podrá  ser regulado a través de convenios o contratos colectivos o fallos arbítrales que recaigan sobre estos últimos.  d) Afiliar al APRENDIZ, durante la etapa práctica de su formación, a la Aseguradora de Riesgos Laborales COLMENA RIESGOS PROFESIONALES (<sub>ARL manejada por la empresa para su planta de personal</sub>), de conformidad con lo dispuesto por el artículo 30 de la Ley 789 de 2002.   E) Afiliar al APRENDIZ y efectuar, durante las fases lectiva y práctica de la formación, el pago mensual del aporte al régimen de Seguridad Social correspondiente al APRENDIZ en <vb>[NUEVA EPS]</vb>, conforme al régimen de trabajadores independientes, tal y como lo establece el Artículo 30 de la Ley 789 de 2002. Los pagos a la seguridad social (A.R.L. y E.P.S.) están a cargo en su totalidad por el empleador f) Dar al aprendiz la dotación de seguridad industrial, cuando el desarrollo de la etapa práctica así lo requiera, para la protección contra accidentes y enfermedades profesionales. 2) POR PARTE DEL APRENDIZ.- Por su parte se compromete en virtud del presente contrato a:  a) Concurrir puntualmente a las clases durante los periodos de enseñanza para así recibir la Formación Profesional Integral a que se refiere el presente Contrato, someterse a los reglamentos y normas establecidas por el respectivo Centro de Formación del SENA ( o de la Institución Educativa  donde el aprendiz adelante sus estudios), y poner toda diligencia y aplicación para lograr el mayor rendimiento en su Formación.  B) <sub>Concurrir puntualmente al lugar asignado por la Empresa para desarrollar su formación en la fase práctica, durante el periodo establecido para el mismo</sub>, en las actividades que se le encomiende y que guarde relación con la Formación, cumpliendo con las indicaciones que le señale la EMPRESA.  En todo caso la intensidad horaria que debe cumplir el APRENDIZ durante la etapa práctica en la EMPRESA, <sub>no podrá exceder de 8 horas diarias y 48 horas Semanales</sub>. (según el acuerdo 000023 de 2.005) c) Proporcionar la información necesaria para que el Empleador lo afilie como trabajador aprendiz al sistema de seguridad social en salud en la E.P.S., que elija.</p>
');


$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>CUARTA.</sub></neg> - Supervisión.  La EMPRESA podrá supervisar al APRENDIZ en el respectivo Centro de Formación del SENA (o en el Centro Educativo donde estuviere adelantando los estudios el aprendiz), la asistencia, como el rendimiento académico, a efectos de verificar y asegurar la real y efectiva utilización del tiempo en la etapa lectiva por parte de este.  El SENA supervisará al APRENDIZ  en la EMPRESA para que sus actividades en cada periodo práctico correspondan al programa de la especialidad para la cual se está formando.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>QUINTA.</sub></neg> - Suspensión.  El presente contrato se podrá suspender temporalmente en los siguientes casos: a) Licencia de maternidad. b) Incapacidades debidamente certificadas. c) Caso fortuito o fuerza mayor debidamente certificada o constatada d) Vacaciones por parte del empleador, siempre y cuando el aprendiz se encuentre desarrollando la etapa práctica. Parágrafo 1º. Esta suspensión debe constar por escrito. Parágrafo 2º Durante la suspensión el contrato se encuentra vigente, por lo tanto, la relación de aprendizaje está vigente para las partes (Empresa y Aprendiz).</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>SEXTA.</sub></neg> - Terminación.  El presente contrato podrá darse por terminado en los siguientes casos: a) Por mutuo acuerdo entre las partes.  B) Por el vencimiento del termino de duración del presente Contrato.  C) La cancelación de la matrícula por parte del SENA de acuerdo con el reglamento previsto para los alumnos.  D) El bajo rendimiento o las faltas disciplinarias cometidas en los periodos de Formación Profesional Integral en el SENA o en la EMPRESA, cuando a pesar de los requerimientos de la Empresa o del SENA, no se corrijan en un plazo razonable.  Cuando la decisión la tome la Empresa, esta deberá obtener previo concepto favorable del SENA.  E) El incumplimiento de las obligaciones previstas para cada una de las partes.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>SEPTIMA.-</sub></neg> Relación Laboral.  El presente Contrato no implica relación laboral alguna entre las partes, y se regirá en todas sus partes por el artículo 30 y s.s. de la ley 789 de 2002.  Declaración Juramentada.  El APRENDIZ declara bajo la gravedad de juramento que no se encuentra ni ha estado vinculado con la EMPRESA o con otras EMPRESAS en una relación de aprendizaje.  Así mismo, declara que no se encuentra ni ha estado vinculado mediante una relación laboral con la EMPRESA.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg><sub>OCTAVA.</sub></neg> El presente contrato de aprendizaje rige a partir de <vb>[D (08) de M (01) del A 2025]</vb> y termina el <vb>[D (9) de M (10) de A 2025]</vb> fecha prevista como terminación de la etapa productiva que se describe en la cláusula segunda de este contrato. Para efectos de lo anterior, firman a los <vb>[D (08) de M (01) de A 2025]</vb>.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);


$pdf->SetLeftMargin(19);
$linea=$pdf->GetY();
$pdf->SetFont('Arial','B',10);
if($linea>218){
  $pdf->AddPage();
  $linea=65;
  
  $pdf->Cell(88,4.5,utf8_decode('LA EMPRESA'),0,0,'L');
  $pdf->Cell(88,4.5,utf8_decode('EL APRENDIZ'),0,1,'L');
  $pdf->SetY($linea);
}else{
  $pdf->ln(5);
  $linea=$linea+23;
  
  $pdf->Cell(88,4.5,utf8_decode('LA EMPRESA'),0,0,'L');
  $pdf->Cell(88,4.5,utf8_decode('EL APRENDIZ'),0,1,'L');
  $pdf->SetY($linea);
}


// $pdf->Line(20, $linea, 80, $linea);
// $pdf->Line(108, $linea, 168, $linea);


$pdf->Cell(88,4.5,utf8_decode('LUIS HECTOR RUBIANO VERGARA'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');

$pdf->Cell(88,4.5,utf8_decode('Representante Legal'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('Aprendiz'),0,1,'L');


$pdf->SetLeftMargin(20);
$pdf->ln(15); 

$txt=utf8_decode('
<p><neg>Señor empresario: Recuerde que todos los contratos de aprendizaje y pagos de monetización deben ser registrados por parte de la empresa patrocinadora; en el Aplicativo SISTEMA GESTION VIRTUAL DE APRENDICES; así como deben ser registradas todas las suspensiones y/o terminaciones de Contratos de Aprendizaje (Acuerdo 11 de Noviembre 2.008)</neg></p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);



  
$pdf->Output();

  







	