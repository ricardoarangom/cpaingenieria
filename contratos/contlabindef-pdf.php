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
    $this->MultiCell(85,5,utf8_decode("CONTRATO INDIVIDUAL DE TRABAJO A TÉRMINO INDEFINIDO"),0,'C');

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

    $this->SetY(-14);
    $pagina='Página '.$this->PageNo().' de {nb}';
    $this->SetFont('Arial','',7);
    $this->Cell(120,3.5,utf8_decode("CONTRATO INDIVIDUAL DE TRABAJO A TÉRMINO INDEFINIDO"),0,0,'L');
    $this->Cell(60,3.5,utf8_decode($pagina),0,1,'R');

    $this->SetDrawColor(255,158,126);
    $this->SetLineWidth(0.1);
    $this->line(0,265,216,265);
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
$pdf->SetStyle("i","Arial","I",0,"0,0,0");
$pdf->SetStyle("li","Arial","N",0,"0,0,0",5,chr(149));
$pdf->SetStyle("place","arial","U",0,"153,0,0");
$pdf->SetStyle("vb","arial","",0,"153,0,0");
$pdf->SetStyle("neg","Arial","B",0,"0,0,0");

$pdf->SetMargins(20,10,20);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->ln(4);
$pdf->SetFont('Arial','IB',12);
$pdf->Cell(176,4.5,utf8_decode('CONTRATO INDIVIDUAL DE TRABAJO A TÉRMINO INDEFINIDO'),0,1,'C');

$pdf->ln(4);
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(70,106));
$pdf->SetAligns(array('L','L'));
$pdf->Row(array(utf8_decode('NUMERO DE CONTRATO'),utf8_decode('Variable')),0);

$pdf->Row(array(utf8_decode('Nombre del empleador:'),utf8_decode('COMPAÑÍA DE PROYECTOS AMBIENTALES SAS. "CPA INGENIERIA SAS"')),0);
$pdf->Row(array(utf8_decode('Domicilio del empleador:'),utf8_decode('BOGOTÁ D.C.')),0);
$pdf->Row(array(utf8_decode('Dirección del empleador:'),utf8_decode('CALLE 106 No 59 -21')),0);
$pdf->Row(array(utf8_decode('NIT del empleador:'),utf8_decode('830.042.614')),0);
$pdf->Row(array(utf8_decode('Representante legal Suplente:'),utf8_decode('LUIS HECTOR RUBIANO VERGARA')),0);
$pdf->Row(array(utf8_decode('Tipo y No. de Identificación:'),utf8_decode('79.315.619')),0);

$pdf->Row(array(utf8_decode('Nombre del trabajador:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Lugar, Fecha De Nacimiento Y Nacionalidad'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Tipo y No. de Identificación:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Domicilio del trabajador:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Teléfono:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Cargo u oficio para desempeñar:'),utf8_decode('Variable')),0);

$pdf->Row(array(utf8_decode('Salario:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Pagos sin carácter salarial:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Períodos de pago:'),utf8_decode('MENSUAL')),0);
$pdf->Row(array(utf8_decode('Ciudad donde ha sido contratado el trabajador'),utf8_decode('BOGOTA D.C')),0);
$pdf->Row(array(utf8_decode('Domicilio contractual:'),utf8_decode('Calle 106 N°59-21, Bogotá')),0);
$pdf->Row(array(utf8_decode('Jornada Laboral'),utf8_decode('TIEMPO COMPLETO')),0);

$pdf->Row(array(utf8_decode('Fecha de inicio de la labor:'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Lugar Donde Desempeñara Las Labores'),utf8_decode('Variable')),0);
$pdf->Row(array(utf8_decode('Tipo de contrato:'),utf8_decode('CONTRATO DE TRABAJO A TERMINO INDEFINIDO')),0);

$pdf->ln(5);

$pdf->SetFont('Arial','',7);

$txt=utf8_decode('
<p><neg>RESPONSABILIDADES:</neg><vb>[variable respomsabilidades]</vb></p>
<p><neg>FUNCIONES:</neg><vb>[variable funciones]</vb></p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);
$pdf->ln(3);


$txt=utf8_decode('
<p>Entre el empleador y el trabajador, de las condiciones ya dichas, identificados como aparece al pie de sus correspondientes firmas, se ha celebrado el presente contrato Individual de Trabajo a Término indefinido , regido por las siguientes cláusulas: <neg>PRIMERA:</neg> El empleador contrata los servicios personales del trabajador, y éste se obliga: a). Poner al servicio del empleador toda su capacidad normal de trabajo, de manera exclusiva, en el desempeño de las funciones propias del cargo contratado y en las labores conexas y complementarias del mismo, en consideración con las órdenes e instrucciones que le imparta al empleador o sus representantes; b). No prestar directa ni indirectamente servicios laborales a otros empleadores, ni trabajar por cuenta propia en el mismo oficio, durante la vigencia del presente contrato; c). Laborar la jornada ordinaria en los turnos y dentro del horario señalado en este contrato, pudiendo el empleador efectuar ajustes o cambios de horario cuando lo estime conveniente y d). Las demás consagradas en el artículo 58 del Código Sustantivo del Trabajo. <neg>SEGUNDA:</neg> Como contraprestación por su labor, el empleador pagará al Trabajador el salario estipulado, el cual deberá cancelar en la fecha y lugar indicado, quedando establecido que en dicho pago se halla incluida la remuneración correspondiente a los descansos dominicales y festivos de que tratan los capítulos I y II del Título VII del Código Sustantivo del Trabajo. Se aclara y se conviene que en los casos en los que el trabajador devengue comisiones o cualquiera otra modalidad de salario variable, el 82.5% de dichos ingresos, constituye remuneración ordinaria, y el 17.5% restante está destinado a remunerar el descanso en los días dominicales y festivos de que tratan los capítulos I y II del Título VII del Código Sustantivo del Trabajo. <neg>TERCERA:</neg> Se considera el trabajador como personal de Manejo y Confianza por sus funciones y representación de la empresa frente al cliente en el lugar donde desarrolla sus labores, se deja estipulado que según el artículo 162 de la norma laboral, el personal de manejo y confianza queda excluido de la regulación sobre la jornada máxima legal de trabajo, pues su labor es la de estar dispuestos en cualquier momento por las labores propias de su cargo dentro de los días de trabajo asignados por el cliente. <neg>CUARTA:</neg> Son justas causas para dar por terminado unilateralmente el presente contrato, por cualquiera de las partes, las expresadas en los artículos 62 y 63 del Código Sustantivo del Trabajo, en concordancia con las modificaciones introducidas por el artículo 7° del Decreto 2351 de 1965; y, además, por parte del empleador, las faltas que para el efecto se califiquen como graves en el espacio reservado para cláusulas adicionales en el presente contrato. <neg>QUINTA:</neg> Aunque el lugar de trabajo es el indicado en este contrato, las partes pueden acordar que el mismo se preste en sitio diferente, siempre que las condiciones laborales del trabajador no se desmejoren o se disminuya su remuneración o le cause perjuicio. De todos modos, corren por cuenta del empleador los gastos que ocasione dicho traslado. El trabajador desde ahora acepta los cambios de oficio que decida el empleador, siempre que sus condiciones laborales se mantengan, se respeten sus derechos y no le causen perjuicios. <neg>SEXTA:</neg> El trabajador se obliga a laborar la jornada ordinaria en los turnos y dentro de las horas señaladas por el empleador. Por el acuerdo expreso o tácito de las partes, podrán repartirse las horas de la jornada ordinaria en la forma permitida por el artículo 164 del Código Sustantivo del Trabajo, teniendo en cuenta que las secciones de descanso entre las jornadas de trabajo no se computan dentro de la misma, conforme lo prescribe el artículo 167 del mismo código. <neg>SEPTIMA:</neg> La quinta parte de la duración estimada del presente contrato se considera como periodo de prueba, sin que exceda de dos (2) meses contados a partir de la fecha de inicio, y, por consiguiente, cualquiera de las partes podrá terminar el contrato unilateralmente, en cualquier momento durante dicho periodo y sin previo aviso, sin que se cause pago de indemnización alguna. <neg>OCTAVA:</neg> Este contrato ha sido redactado estrictamente de acuerdo con la Ley y Jurisprudencia y será interpretado de buena fe y en consonancia con el Código Sustantivo del Trabajo cuyo objeto, definido en su artículo 1º, es lograr la justicia en las relaciones entre empleadores y trabajadores dentro de un espíritu de coordinación económica y equilibrio social. <neg>NOVENA:</neg> El presente contrato reemplaza y deja sin efecto cualquier otro contrato verbal o escrito, que se hubiera celebrado entre las partes con anterioridad. Cualquier modificación al presente contrato debe efectuarse por escrito y anotarse a continuación de su texto.
</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);

$pdf->ln(0);
$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(19);
$pdf->ln(0);
$pdf->Cell(176,4.5,utf8_decode('CLAUSULAS ADICIONALES:'),0,1,'L');
$pdf->Cell(10,4.5,utf8_decode('1.'),0,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(167,4.5,utf8_decode('Las partes expresamente acuerdan que ninguno de los pagos enumerados en el artículo 128 del Código Sustantivo del Trabajo (modificado por la Ley 50 de 1990, art. 15) tiene carácter de salario. Igualmente se acuerda que lo que reciba el trabajador o llegue a recibir en el futuro, adicional a su salario ordinario, ya sean beneficios o auxilios habituales u ocasionales, tales como alimentación, gastos de representación, habitación o vestuario, medios de transporte, elementos de trabajo, propinas,  auxilio de rodamiento, bonificaciones ocasionales o cualquier otra que reciba, durante la vigencia del contrato de trabajo en dinero o en especie, no tendrán naturaleza salarial para ningún efecto.'),0,'J');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,4.5,utf8_decode('2.'),0,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(167,4.5,utf8_decode('Es obligación del trabajador no divulgar aquella información que se le haya confiado en virtud del secreto profesional o aquella que deba ser mantenida en reserva por su carácter de confidencial, de la cual haya tenido noticia por cualquier circunstancia, excepción hecha de aquello que el Trabajador deba informar por razones de ley o providencias judiciales. Entiéndase por información confidencial aquella información societaria, técnica, financiera, jurídica, comercial y estratégica de los negocios del Empleador, presentes o futuros.'),0,'J');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,4.5,utf8_decode('3.'),0,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(167,4.5,utf8_decode('Horario de Trabajo oficina Bogotá: Lunes a Jueves de 7:30 a.m. - 5:30 p.m. Viernes 7:30 a.m. - 4:30 p.m. con una hora de almuerzo. Sábados: en caso de requerirse, previa solicitud del empleador; teniendo en cuenta que en el horario de lunes a viernes no se cumplen las 47 horas semanales legales.'),0,'J');

$pdf->ln(4);




$txt=utf8_decode('
<p>Para constancia se firma por las partes que han intervenido, en dos (2) ejemplares del mismo tenor y valor, ante testigos en la ciudad de Bogotá, a <vb>[los Diecinueve (19) días del mes de enero del año 2024.]</vb>. 
</p>
');

$pdf->WriteTag(0,5,$txt,0,"J",0);

$pdf->SetLeftMargin(19);
$pdf->ln(20); 

$pdf->SetFont('Arial','B',0);

$linea=$pdf->GetY();

$pdf->Line(20, $linea, 80, $linea);
$pdf->Line(108, $linea, 168, $linea);

$pdf->Cell(88,4.5,utf8_decode(''),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode(''),0,1,'L');

$pdf->Cell(88,4.5,utf8_decode('EMPLEADOR'),0,0,'L');
$pdf->Cell(88,4.5,utf8_decode('TRABAJADOR'),0,1,'L');


// $pdf->Cell(88,4.5,utf8_decode('CPA INGENIERIA S.A.S.'),0,0,'L');
// $pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');

// $pdf->Cell(88,4.5,utf8_decode('NIT. 830.042.614-3 '),0,0,'L');
// $pdf->Cell(88,4.5,utf8_decode('VARIABLE'),0,1,'L');


  
$pdf->Output();

  







	