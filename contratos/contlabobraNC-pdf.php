<?php 
require_once('../connections/datos.php');
?>
<?php 

set_time_limit(0);

require_once('../fpdf/fpdf.php');
require_once('../fpdf/WriteTag.php');
require_once('../funciones.php');

function get_letter_from_number($number) {
    // A -> 0, B -> 1, C -> 2, etc.
    return chr(97 + $number);
}

$contrato=$_GET['contrato'];

$buscaCont =   "SELECT 
                    proveedor,
                    documento,
                    telefono,
                    direccion,
                    departamento,
                    ciudad,
                    email,
                    fconstitucion,
                    departamenton,
                    ciudadn,
                    consec,
                    finicio,
                    ffin,
                    clasedocsi.codigo,
                    nombre,
                    munexp,
                    municipios.municipio,
                    lugar,
                    valor,
                    incs,
                    cargo,
                    alcance,
                    objeto,
                    auxilio,
                    IdFirmante
                    
                FROM
                    ((((contrat
                    LEFT JOIN contratistas ON contrat.IdProveedor = contratistas.IdContratista)
                    LEFT JOIN municipios ON contratistas.munexp = municipios.IdMunicipio)
                    LEFT JOIN clasedocsi ON contratistas.IdClasedoc = clasedocsi.IdClasedoc)
                    left join cargos on contrat.IdCargo=cargos.IdCargo)
                WHERE
                    IdContrato = ".$contrato;
$resultadoCont = mysql_query($buscaCont, $datos) or die(mysql_error());
$filaCont = mysql_fetch_assoc($resultadoCont);
$totalfilas_buscaCont = mysql_num_rows($resultadoCont);

$buscaAct = "   SELECT 
                    actividad
                FROM
                    actividadescont
                WHERE
                    IdContrato = ".$contrato;
$resultadoAct = mysql_query($buscaAct, $datos) or die(mysql_error());
$filaAct = mysql_fetch_assoc($resultadoAct);
$totalfilas_buscaAct = mysql_num_rows($resultadoAct);

$buscaPro = "SELECT 
                IdProducto, 
                producto 
            FROM 
                productoscont 
            WHERE 
                IdContrato = " . $contrato;
$resultadoPro = mysql_query($buscaPro, $datos) or die(mysql_error());
$filaPro = mysql_fetch_assoc($resultadoPro);
$totalfilas_buscaPro = mysql_num_rows($resultadoPro);

$arregloInicio=explode("-",$filaCont['finicio']);

$textoFirma=strtolower(convertir1($arregloInicio[2]))." (".$arregloInicio[2].") dias del mes de ".fechaactual7($arregloInicio[1])." del año ".$arregloInicio[0];

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
    $this->MultiCell(85,5,utf8_decode("CONTRATO INDIVIDUAL DE TRABAJO POR OBRA O LABOR DETERMINADA"),0,'C');

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

    $this->SetY(-22);
    $this->Image('../imagenes/banner.png',26,262,160);

    $this->SetX(18);

    $pagina='Página '.$this->PageNo().' de {nb}';
    $this->SetFont('Arial','',7);
    $this->Cell(120,3.7,utf8_decode("CONTRATO INDIVIDUAL DE TRABAJO POR LA DURACIÓN DE UNA OBRA O LABOR DETERMINADA"),0,0,'L');
    $this->Cell(60,3.7,utf8_decode($pagina),0,1,'R');
    $this->SetDrawColor(255,158,126);
    $this->SetLineWidth(0.1);
    $this->line(0,257,216,257);
    
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
$pdf->SetAutoPageBreak(true, 23);
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->ln(4);
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(70,106));
$pdf->SetAligns(array('L','L'));
$pdf->Row(array(utf8_decode('NUMERO DE CONTRATO'),utf8_decode('NM LAB '.sprintf("%03d",$filaCont['consec']))),0);

$pdf->Row(array(utf8_decode('Nombre del empleador:'),utf8_decode('COMPAÑÍA DE PROYECTOS AMBIENTALES SAS. "CPA INGENIERIA SAS"')),0);
$pdf->Row(array(utf8_decode('Domicilio del empleador:'),utf8_decode('BOGOTÁ D.C.')),0);
$pdf->Row(array(utf8_decode('Dirección del empleador:'),utf8_decode('CALLE 106 No 59 -21')),0);
$pdf->Row(array(utf8_decode('NIT del empleador:'),utf8_decode('830.042.614')),0);

if($filaCont['IdFirmante']==1){
    $pdf->Row(array(utf8_decode('Representante legal:'),utf8_decode('LUIS HECTOR RUBIANO VERGARA')),0);
    $pdf->Row(array(utf8_decode('Tipo y No. de Identificación:'),utf8_decode('79.315.619')),0);
}else{
    $pdf->Row(array(utf8_decode('Representante legal suplente:'),utf8_decode('MARTHA GABRIELA BOTERO SERNA')),0);
    $pdf->Row(array(utf8_decode('Tipo y No. de Identificación:'),utf8_decode('24.434.581')),0);
}

$pdf->Row(array(utf8_decode('Nombre del trabajador:'),utf8_decode($filaCont['proveedor'])),0);
$pdf->Row(array(utf8_decode('Fecha De Nacimiento'),utf8_decode(fechaactual3($filaCont['fconstitucion']))),0);
$pdf->Row(array(utf8_decode('Tipo y No. de Identificación:'),$filaCont['codigo']." ".colocapuntos($filaCont['documento'])),0);
$pdf->Row(array(utf8_decode('Domicilio del trabajador:'),utf8_decode($filaCont['direccion'])),0);
$pdf->Row(array(utf8_decode('Teléfono:'),utf8_decode($filaCont['telefono'])),0);
$pdf->Row(array(utf8_decode('Cargo u oficio para desempeñar:'),utf8_decode($filaCont['cargo'])),0);

$pdf->Row(array(utf8_decode('Salario:'),number_format($filaCont['valor'])),0);
$pdf->Row(array(utf8_decode('Auxilio de transporte (MLV):'),number_format($filaCont['auxilio'])),0);
$pdf->Row(array(utf8_decode('Períodos de pago:'),utf8_decode('MENSUAL')),0);
$pdf->Row(array(utf8_decode('Ciudad donde ha sido contratado el trabajador'),utf8_decode('BOGOTA D.C')),0);
$pdf->Row(array(utf8_decode('Domicilio contractual:'),utf8_decode('Calle 106 N°59-21, Bogotá')),0);
$pdf->Row(array(utf8_decode('Jornada Laboral'),utf8_decode('TIEMPO COMPLETO')),0);

$pdf->Row(array(utf8_decode('Fecha de inicio de la labor:'),fechaactual3($filaCont['finicio'])),0);
$pdf->Row(array(utf8_decode('Fecha de fin de la labor:'),utf8_decode('HASTA FINALIZAR LABORES')),0);
$pdf->Row(array(utf8_decode('Tipo de contrato:'),utf8_decode('CONTRATO INDIVIDUAL DE TRABAJO POR OBRA O LABOR')),0);
$pdf->Row(array(utf8_decode('Lugar Donde Desempeñara Las Labores'),utf8_decode($filaCont['lugar'])),0);
$pdf->Row(array(utf8_decode('Obra o labor contratada:'),utf8_decode($filaCont['objeto'])),0);

$pdf->ln(5);

if($totalfilas_buscaAct>0){

    $txt=utf8_decode('
    <p><neg>ACTIVIDADES.</neg> Se desarrollarán las siguientes actividades:
    </p>
    ');

    $pdf->WriteTag(0,4.5,$txt,0,"J",0);

    $pdf->SetLeftMargin(25);
    $pdf->ln(2);

    $pdf->SetFont('Arial','',10);
    $itemAc=0;
    do{
        $letter = get_letter_from_number($itemAc);
        $itemAc++;
        $pdf->Cell(6,4.5,utf8_decode($letter.')'),0,0,'L');
        $pdf->MultiCell(165,4.5,utf8_decode($filaAct['actividad']),0,'J');

    } while ($filaAct = mysql_fetch_assoc($resultadoAct));

    $pdf->SetLeftMargin(20);
    $pdf->ln(2);
}

if($totalfilas_buscaPro>0){

    $txt=utf8_decode('
    <p><neg>ENTREGABLES:</neg>
    </p>
    ');

    $pdf->WriteTag(0,4.5,$txt,0,"J",0);

    $pdf->SetLeftMargin(25);
    $pdf->ln(2);

    $pdf->SetFont('Arial','',10);
    $itemPr=0;
    do{
        
        $itemPr++;
        $pdf->Cell(7,4.5,utf8_decode($itemPr.'.'),0,0,'L');
        $pdf->MultiCell(164,4.5,utf8_decode($filaPro['producto']),0,'J');

    } while ($filaPro = mysql_fetch_assoc($resultadoPro));

    $pdf->SetLeftMargin(20);
    $pdf->ln(2);
}

$txt=utf8_decode('
<p>Entre EL EMPLEADOR y EL TRABAJADOR, de las condiciones ya dichas, identificados como aparece al pie de sus firmas, se ha celebrado el presente contrato individual de trabajo, regido además por las siguientes clausulas:
</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>PRIMERA: OBJETO.</neg> EL EMPLEADOR contrata los servicios personales de EL TRABAJADOR y éste obliga: a). A poner al servicio de EL EMPLEADOR toda su capacidad normal de trabajo en el desempeño de las funciones propias del oficio mencionado y en las labores anexas y complementarias del mismo, de conformidad con las órdenes e instrucciones que le imparta EL EMPLEADOR directamente o a través de sus representantes; b). A prestar sus servicios en forma exclusiva al empleador; es decir, a no prestar directa ni indirectamente servicios laborales a otros empleadores, ni a trabajar por cuenta propia en el mismo oficio durante la vigencia de este contrato; y c). A guardar absoluta reserva sobre los hechos, documentos físicos y/o electrónicos, información y en general, sobre todos los asuntos y materias que lleguen a su conocimiento por causa o con ocasión de su contrato de trabajo.
</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);


$txt=utf8_decode('
<p><neg>SEGUNDA: REMUNERACION.</neg> EL EMPLEADOR pagará a EL TRABAJADOR por la prestación de sus servicios el salario indicado en el encabezado del presente documento, pagadero en las oportunidades también señaladas arriba. <neg>PARÁGRAFO PRIMERO: SALARIO ORDINARIO.</neg> Dentro del salario ordinario se encuentra incluida la remuneración de los descansos dominicales y festivos de que tratan los capítulos I, II y III del título VII del C.S.T. De igual manera, se aclara y se conviene en que los casos en los que EL TRABAJADOR devengue comisiones o cualquier otra modalidad del salario variable, el 82.5% de dichos ingresos constituye remuneración de la labor realizada, y el 17.5% restante está destinado a remunerar el descanso en los días dominicales y festivos de que tratan los capítulos I y II del Título VIII del C.S.T. <neg>PARÁGRAFO SEGUNDO: SALARIO INTEGRAL.</neg> En la eventualidad en que EL TRABAJADOR devengue salario integral se entiende de conformidad con el numeral 2 del artículo 132 del C.S.T., subrogado por el artículo 18 de la ley 50/90, que dentro del salario integral convenido se encuentra incorporado el factor prestacional de EL TRABAJADOR, el cual no será INFERIOR AL 30% del salario antes mencionado. De igual manera, se conviene y aclara que en los casos en los que EL TRABAJADOR devengue comisiones o cualquier otra modalidad de salario antes mencionado. El salario integral acordado, además de retribuir la remuneración ordinaria, remunera y compensa todo recargo por trabajo extraordinario, nocturno dominical o festivo, primas de servicios legales o extralegales, cesantías e intereses a la cesantías, subsidios y suministros en especie, incidencia prestacional de eventuales viáticos y en general toda prestación o acreencia legal o extralegal derivada del contrato, con excepción de las vacaciones. <neg>PARÁGRAFO TERCERO:</neg> Las partes acuerdan que en los casos en que se le reconozcan a EL TRABAJADOR beneficios por concepto de alimentación, comunicaciones, habitación o vivienda, transporte, vestuario, auxilios en dinero o en especie o bonificaciones ocasionales, se considerarán tales beneficios o reconocimientos como no salariales, y por tanto, no se tendrán en cuenta como factor salarial para liquidación de acreencias laborales y para el pago de aportes parafiscales y cotizaciones a la seguridad social, de conformidad con los Arts. 15 y 16 de la ley 50/90, en concordancia con el Art. 17 de la 344/96.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>TERCERA: DURACIÓN DEL CONTRATO.</neg> El presente contrato se celebra por un término obra o labor, tal y como se ha indicado en el encabezado. <neg>PARÁGRAFO:</neg> La duración estará asociada al requerimiento de personal que se necesitará en el desarrollo del proyecto, sin que haya necesidad de avisos o requerimientos para anunciar la terminación de la labor o las obligaciones del contratante.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>CUARTA: TRABAJO NOCTURNO, SUPLEMENTARIO, DOMINICAL Y/O FESTIVO.</neg> Todo trabajo nocturno, suplementario o en horas extras, y todo trabajo en domingo o festivo en los que legalmente debe concederse descanso, se remunerará conforme a la ley. Para el reconocimiento y pago del trabajo suplementario, nocturno, dominical o festivo, EL EMPLEADOR o sus representantes deberán haberlo autorizado previamente y por escrito. Cuando la necesidad de este trabajo se presenta de manera imprevista o inaplazable, deberá ejecutarse y darse cuenta de él por escrito y a la mayor brevedad a EL EMPLEADOR o a sus representantes para su aprobación. EL EMPLEADOR, en consecuencia, no reconocerá ningún trabajo suplementario, trabajo nocturno o en días de descanso legalmente obligatorio que no haya sido autorizado previamente o que, habiendo sido avisado inmediatamente, no haya sido aprobado como queda dicho. Tratándose de trabajadores de dirección, confianza o manejo, no habría lugar al pago de horas extras.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>QUINTA: JORNADA DE TRABAJO.</neg> EL TRABAJADOR se obliga a laborar la jornada máxima legal, salvo de acuerdo especial, en los turnos y dentro de las horas señaladas por EL EMPLEADOR, pudiendo hacer este ajuste o cambios de horario cuando lo estime conveniente, sin que ello se considere como una desmejora en las condiciones laborales de EL TRABAJADOR. Por el acuerdo expreso o tácito de las partes, podrán modificar total o parcialmente las horas de jornada ordinaria, con base en lo dispuesto por el Art. 164 del C.S.T., modificado por el Art. 23 de la ley 50/90, teniendo en cuenta que los tiempos de descanso entre las secciones de la jornada no se computan dentro de las misma, según el Art.167 ibídem.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>SEXTA: PERIODO DE PRUEBA.</neg> La quinta parte de la duración estimada del presente contrato se considera como periodo de prueba, sin que exceda de dos (2) meses contados a partir de la fecha de inicio y, por consiguiente, cualquiera de las partes podrá terminar el contrato unilateralmente en cualquier momento durante dicho periodo y sin previo aviso, sin que se cause el pago de indemnización alguna.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>SÉPTIMA: TERMINACIÓN UNILATERAL.</neg> Son justas causas para dar por terminado unilateralmente este contrato, por cualquiera de las partes, las enumeradas en el Art. 62 C.S.T., modificado por el Art. 7° del Decreto 2351/65 y además, por parte de EL EMPLEADOR, las faltas que para el efecto se cualifiquen como graves en reglamentos, manuales, instructivos y demás documentos que contengan reglamentaciones, órdenes, instrucciones o prohibiciones de carácter general o particular , pactos, convenciones colectivas, laudos arbitrales y las que expresamente convengan calificar así en escritos que formarán parte integral del presente contrato. Expresamente, se califica en este acto como falta grave; la violación a las obligaciones y prohibiciones contenidas en la cláusula primera del presente contrato.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>OCTAVA: PROPIEDAD INTELECTUAL.</neg> Las partes acuerdan que todas las invenciones, descubrimientos y trabajos originales concebidos o hechos por EL TRABAJADOR en vigencia del presente contrato pertenecerán a EL EMPLEADOR, por lo cual EL TRABAJADOR se obliga a informar a EL EMPLEADOR de forma inmediata sobre la existencia de dichas invenciones y/o trabajos originales. EL TRABAJADOR accederá a facilitar el cumplimiento oportuno de las correspondientes formalidades y dará su firma, extenderá los poderes y documentos necesarios para transferir la propiedad intelectual a EL EMPLEADOR cuando así se lo solicite. Teniendo en cuenta lo dispuesto en la normatividad de derechos de autor y lo estipulado anteriormente, las partes acuerdan que el salario devengado contiene la remuneración por la transferencia de todo tipo de propiedad intelectual, razón por la cual no se causara ninguna compensación adicional.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>NOVENA: MODIFICACIONES DE LAS CONDICIONES LABORALES.</neg> EL TRABAJADOR  acepta desde ahora expresamente todas las modificaciones de sus condiciones laborales determinadas por EL EMPLEADOR en ejercicio de su poder subordinante, tales como el horario de trabajo, el lugar de prestación del servicio y el cargo u oficio y/o funciones, siempre que tales modificaciones no afecten su honor, dignidad o sus derechos mínimos, ni impliquen desmejoras sustanciales o graves perjuicios para él, de conformidad con lo dispuesto por el Art 23 de C.S.T. modificado por el Art. 1° de la ley 50/90.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);


$txt=utf8_decode('
<p><neg>DÉCIMA: DIRECCIÓN DEL TRABAJADOR.</neg> EL TRABAJADOR para todos los efectos legales, y en especial para aplicación del parágrafo 1 del Art. 29 de la ley 798/02, norma que modificó el Art. 65 del C.S.T., se compromete a informar por escrito y de manera inmediata a EL EMPLEADOR cualquier cambio en su dirección de residencia, teniéndose en todo caso como suya, la última dirección registrada en su hoja de vida.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>DÉCIMA PRIMERA: EFECTOS.</neg> El presente contrato reemplaza en su integridad y deja sin efecto cualquier otro contrato, verbal o escrito, celebrado entre las partes con anterioridad, pudiendo las partes convenir por escrito modificaciones al mismo, las que formarán parte integral de este contrato.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p><neg>DÉCIMA SEGUNDA:</neg> - Las partes expresamente acuerdan que ninguno de los pagos enumerados en el artículo 128 del Código Sustantivo del Trabajo (modificado por la Ley 50 de 1990, art. 15) tiene carácter de salario. Igualmente, se acuerda que lo que reciba el trabajador o llegue a recibir en el futuro, adicional a su salario ordinario, ya sean beneficios o auxilios habituales u ocasionales, tales como alimentación, gastos de representación, habitación o vestuario, medios de transporte, elementos de trabajo, propinas,  auxilio de rodamiento, bonificaciones ocasionales o cualquier otra que reciba durante la vigencia del contrato de trabajo en dinero o en especie, no tendrán naturaleza salarial para ningún efecto. - Es obligación del trabajador no divulgar aquella información que se le haya confiado en virtud del secreto profesional o aquella que deba ser mantenida en reserva por su carácter de confidencial, de la cual haya tenido noticia por cualquier circunstancia, excepción hecha de aquello que el Trabajador deba informar por razones de ley o providencias judiciales. Entiéndase por información confidencial aquella información societaria, técnica, financiera, jurídica, comercial y estratégica de los negocios de EL EMPLEADOR, presentes o futuros. - Se requiere que el trabajador tenga disponibilidad en su tiempo de descanso para cualquier solicitud por parte del cliente. - Se da por iniciado el contrato laboral desde la fecha de inicio de actividades en campo, según lo establecido en el sitio de trabajo para el cual fue contratado.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p>Una vez leído, entendido y aprobado por las partes el presente contrato, se firma sin que adolezca de error, fuerza o dolo.</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(2);

$txt=utf8_decode('
<p>Para constancia del pleno acuerdo sobre los términos referidos en este contrato, se firma en dos (2) ejemplares del mismo tenor y valor a lof '.$textoFirma.' en la ciudad de Bogotá D.C.
</p>
');

$pdf->WriteTag(0,4.5,$txt,0,"J",0);
$pdf->ln(5);


$pdf->SetLeftMargin(19);
$linea=$pdf->GetY();
$pdf->SetFont('Arial','B',10);
if($linea>221){
  $pdf->AddPage();
  $linea=60;
  
  $pdf->Cell(88,4.5,utf8_decode('EMPLEADOR'),0,0,'L');
  $pdf->Cell(88,4.5,utf8_decode('TRABAJADOR'),0,1,'L');
  $pdf->SetY($linea);
}else{
  $pdf->ln(5);
  $linea=$linea+20;
  
  $pdf->Cell(88,4.5,utf8_decode('EMPLEADOR'),0,0,'L');
  $pdf->Cell(88,4.5,utf8_decode('TRABAJADOR'),0,1,'L');
  $pdf->SetY($linea);
}


$pdf->Line(20, $linea, 80, $linea);
$pdf->Line(108, $linea, 168, $linea);


if($filaCont['IdFirmante']==1){
    $pdf->Cell(88,4.5,utf8_decode('LUIS HECTOR RUBIANO VERGARA'),0,0,'L');
}else{
    $pdf->Cell(88,4.5,utf8_decode('MARTHA GABRIELA BOTERO SERNA'),0,0,'L');
}

$pdf->Cell(88,4.5,utf8_decode($filaCont['proveedor']),0,1,'L');

if($filaCont['IdFirmante']==1){
    $pdf->Cell(88,4.5,utf8_decode('CC 79.315.619 de BOGOTA D.C.'),0,0,'L');
}else{
    $pdf->Cell(88,4.5,utf8_decode('CC 24.434.581 de ARANZAZU'),0,0,'L');
}


$pdf->Cell(88,4.5,$filaCont['codigo']." ".colocapuntos($filaCont['documento'])." de ".utf8_decode($filaCont['municipio']),0,1,'L');

if($filaCont['IdFirmante']==1){
    $pdf->Cell(88,4.5,utf8_decode('Representante Legal'),0,1,'L');
}else{
    $pdf->Cell(88,4.5,utf8_decode('Representante Legal Suplente'),0,1,'L');
}

$pdf->ln(2); 

$pdf->Cell(88,4.5,utf8_decode('Testigo.'),0,1,'L');
  
$pdf->Output();

  







	