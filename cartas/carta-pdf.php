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
                    asunto,
                    fecha,
                    IdUsuario,
                    firmante
                FROM
                    cartas
                WHERE
                    IdCarta = ".$IdCarta."  ";
$resultadoCarta = mysql_query($buscaCarta, $datos) or die(mysql_error());
$filaCarta = mysql_fetch_assoc($resultadoCarta);
$totalfilas_buscaCarta = mysql_num_rows($resultadoCarta);

$buscaParrafos = "SELECT 
                      IdParrafo, IdCarta, parrafo
                  FROM
                      parrafoscartas
                  WHERE
                      IdCarta = ".$IdCarta."  ";
$resultadoParrafos = mysql_query($buscaParrafos, $datos) or die(mysql_error());
$filaParrafos = mysql_fetch_assoc($resultadoParrafos);
$totalfilas_buscaParrafos = mysql_num_rows($resultadoParrafos);

$buscaAnexos = "SELECT 
                    nombre
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
    global $ancho;    
    $this->SetY(-17);
    $this->Image('../imagenes/banner.png',28,260,160);
    
    
  }
}

?>
<?php

$ancho=210;

$pdf = new PDF('P','mm',Letter);

$pdf->SetStyle("p","Arial","N",10,"0,0,0",0);
$pdf->SetMargins(20,10,20);
$pdf->AddPage();

$pdf->SetFont('Arial','',10);
$pdf->Cell(90,4.5,utf8_decode('Bogotá D.C., '.fechaactual6($filaCarta['fecha'])),0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(85,4.5,utf8_decode('CPA-'.sprintf("%03d",$filaCarta['IdCarta']))."-".date("Y",strtotime($filaCarta['fecha'])),0,1,'R');



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

 
$pdf->ln(8);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(23,4.5,utf8_decode('Referencia: '),0,0,'L');

$pdf->MultiCell(90,5,utf8_decode($filaCarta['asunto']),0,'L');

$pdf->ln(4);
$pdf->SetFont('Arial','',10);
$pdf->Cell(23,4.5,utf8_decode('Respetados señores,'),0,1,'L');
$pdf->ln(4);

$pdf->SetLeftMargin(21);
do{
  $txt=utf8_decode('
  <p>'.$filaParrafos['parrafo'].'
  </p>');

  $pdf->WriteTag(0,4.5,$txt,0,"J",0);
  $pdf->Ln(3);
} while ($filaParrafos = mysql_fetch_assoc($resultadoParrafos));

$pdf->SetLeftMargin(20);
$pdf->Ln(1);
$pdf->Cell(23,4.5,utf8_decode('Agradecemos su atención.'),0,1,'L');
$pdf->Ln(5);
$pdf->Cell(23,4.5,utf8_decode('Atentamente,'),0,1,'L');

$pdf->Ln(13);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(23,4.5,utf8_decode($filaCarta['firmante']),0,1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(23,4.5,utf8_decode('CPA INGENIERIA S.A.S.'),0,1,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(23,3,utf8_decode('Responder:'),0,1,'L');
if($totalfilas_buscaAnexos>0){
  $pdf->Cell(15,3,utf8_decode('ANEXOS:'),0,0,'L');
  $anexos='';
  do{
    $anexos.=$filaAnexos['nombre']."\n";
  } while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));

  $pdf->MultiCell(23,3,utf8_decode($anexos),0,'L');
}



$pdf->Output();


	