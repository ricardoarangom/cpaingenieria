<?php 
//require_once('/fpdf/fpdf.php');


class PDF extends FPDF{

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
  global $title;
  global $subtitulo;
  global $ancho;
  global $subtitulo1;
  
	
  $this->SetFont('Arial','B',10);
 
  $this->SetY(20);
   $this->SetX(110);
  $this->Cell(90,5,$title,0,1,'C');
  $this->SetX(110);
  $this->Cell(90,5,"No ".$subtitulo,0,1,'C'); 
  
  	
   
  $this->Image('../imagenes/logofa.png',35,11.5,60);
  $this->SetXY(20,10);
  $this->Cell(90,28," ",1,0,'C');
  $this->Cell(90,28," ",1,1,'C'); 
  
//	$this->Ln(10);
	
}
function Footer()
{
	global $ancho;
    global $ruta_qr;
	
	$this->SetY(-17);
    $this->Image($ruta_qr,177,237,25,25);
    $this->Line(20,262,200,262);
    $this->SetFont('Arial','',8);
    $this->SetX(20);
    $this->Cell(180,4,utf8_decode('Calle 106 N° 59-21  PBX (57) 1 2265544 Bogotá D.C / Colombia Correo electrónico: recepcion@cpaingenieria.com'),0,1,'C');
	// 
  
}

}
?>