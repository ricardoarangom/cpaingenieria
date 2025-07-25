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
    global $anulada;
    
    
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
    $this->ln(10);
        
    $this->SetFont('Arial','B',60);
    $this->SetTextColor(255,220,220);
    if($anulada==1){
      $this->TextWithRotation(45,260,'C A R T A    A N U L A D A',60,0);
    }
    
    $this->SetTextColor(0,0,0);
  }
  function Footer()
  {
    global $ancho;    
    $this->SetY(-17);
    $this->Image('../imagenes/banner.png',28,260,160);
    
    
  }

  function TextWithDirection($x, $y, $txt, $direction='R')
  {
    if ($direction=='R')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    elseif ($direction=='L')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    elseif ($direction=='U')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    elseif ($direction=='D')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    else
        $s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
  }

  function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
  {
    $font_angle+=90+$txt_angle;
    $txt_angle*=M_PI/180;
    $font_angle*=M_PI/180;

    $txt_dx=cos($txt_angle);
    $txt_dy=sin($txt_angle);
    $font_dx=cos($font_angle);
    $font_dy=sin($font_angle);

    $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
  }
}

?>
<?php

$ancho=210;
$anulada=$filaCarta['anulada'];

$pdf = new PDF('P','mm',Letter);

$pdf->SetStyle("p","Arial","N",10,"0,0,0",0);
$pdf->SetMargins(20,10,20);
$pdf->AddPage();

$pdf->SetFont('Arial','',10);
if($filaCarta['fenvio']){
  $pdf->Cell(90,4.5,utf8_decode('Bogotá D.C., '.fechaactual6($filaCarta['fenvio'])),0,0,'L');
}else if($filaCarta['anulada']==0){
  $pdf->Cell(90,4.5,utf8_decode('Bogotá D.C., '.fechaactual6(date("Y-m-d"))),0,0,'L');
}else{
  $pdf->Cell(90,4.5,utf8_decode('Bogotá D.C., '.fechaactual6($filaCarta['fecha'])),0,0,'L');
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(85,4.5,utf8_decode('CPA-'.sprintf("%03d",$filaCarta['consAno']))."-".$filaCarta['ano'],0,1,'R');



$pdf->ln(8);
$pdf->SetFont('Arial','',10);

$pdf->Cell(90,4.5,utf8_decode('Señores'),0,1,'L');
$pdf->Cell(90,4.5,utf8_decode($filaCarta['destinatario1']),0,1,'L');
if($filaCarta['destinatario2']){
  $pdf->Cell(90,4.5,utf8_decode($filaCarta['destinatario2']),0,1,'L');
}
if($filaCarta['destinatario3']){
  $pdf->Cell(90,4.5,utf8_decode($filaCarta['destinatario3']),0,1,'L');
}
if($filaCarta['destinatario4']){
  $pdf->Cell(90,4.5,utf8_decode($filaCarta['destinatario4']),0,1,'L');
}

 
$pdf->ln(8);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(23,4.5,utf8_decode('Referencia: '),0,0,'L');

$pdf->MultiCell(152,4.5,utf8_decode($filaCarta['asunto']),0,'J');

$pdf->ln(4);
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,4.5,utf8_decode($filaCarta['destinatario5'].","),0,1,'L');
$pdf->ln(4);

$pdf->SetLeftMargin(20);
do{
  if($filaParrafos['titulo']){
    $pdf->SetFont('Arial','B',11);
    $pdf->MultiCell(175,4.5,utf8_decode($filaParrafos['titulo']),0,'C');
  }  
  $pdf->SetFont('Arial','',10);
  $pdf->MultiCell(175,4.5,utf8_decode($filaParrafos['parrafo']),0,'J');
  
  $pdf->Ln(3);
} while ($filaParrafos = mysql_fetch_assoc($resultadoParrafos));
$rows = mysql_num_rows($resultadoParrafos);
if($rows > 0) {
    mysql_data_seek($resultadoParrafos, 0);
  $filaParrafos = mysql_fetch_assoc($resultadoParrafos);
}

$pdf->SetLeftMargin(20);
$pdf->Ln(1);
$pdf->Cell(23,4.5,utf8_decode('Agradecemos su atención.'),0,1,'L');
$pdf->Ln(5);
$linea=$pdf->GetY();
if($linea>238){
  $pdf->AddPage();
}
$pdf->Cell(23,4.5,utf8_decode('Atentamente,'),0,1,'L');
$linea=$pdf->GetY();
if($filaCarta['firma']){
  $pdf->Image($filaCarta['firma'],18,$linea,0,25);
}
if($filaCarta['consello']==1){
  $pdf->Image('../imagenes/sello.png',80,$linea,0,25);
}
$pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(23,4.5,utf8_decode($filaCarta['firmante']),0,1,'L');
$pdf->Cell(23,4.5,utf8_decode($filaCarta['cargo']),0,1,'L');
$pdf->Cell(23,4.5,utf8_decode('CPA INGENIERIA S.A.S.'),0,1,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(23,3,utf8_decode(''),0,1,'L');
if($totalfilas_buscaAnexos>0){
  $pdf->Cell(15,3,utf8_decode('ANEXOS:'),0,0,'L');
  $anexos='';
  do{
    $anexos.=$filaAnexos['nombre']."\n";
  } while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));
  $rows = mysql_num_rows($resultadoAnexos);
  if($rows > 0) {
      mysql_data_seek($resultadoAnexos, 0);
    $filaAnexos = mysql_fetch_assoc($resultadoAnexos);
  }

  $pdf->MultiCell(50,3,utf8_decode($anexos),0,'L');
}


if($envia==1){
  $documento = 'carta.pdf';
  $doc = $pdf->Output('S', $documento);
}else{
  $pdf->Output();
}


	