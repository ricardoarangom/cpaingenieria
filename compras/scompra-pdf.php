<?php  require_once('../connections/datos.php');?>
<?php

set_time_limit(0);

require_once('../fpdf/fpdf.php');
require_once('../funciones.php');
require_once('../phpqrcode/qrlib.php');
// include('../includes/formatopdf.php');
?>

<?php

if(isset($_POST['oc'])){
 $solicitud=$_POST['oc'];
}
if(isset($_GET['oc'])){
 $solicitud=$_GET['oc']; 
}

// echo $solicitud;


//$ordenc=1;

$buscaOC =  " SELECT 
                  IdOrdencompra,
                  IdSolicitante,
                  ordencompra.IdArea,
                  ordencompra.IdEmpresa,
                  fsolicitud,
                  area,
                  CONCAT(nombre, ' ', apellido) AS solicitante,
                  critico
              FROM
                  (ordencompra
                  INNER JOIN areas ON ordencompra.IdArea = areas.IdArea)
                      INNER JOIN
                  usuarios ON ordencompra.IdSolicitante = usuarios.IdUsuario
              WHERE
                  IdOrdencompra =  " .$solicitud;
$resultadoOC = mysql_query($buscaOC, $datos) or die(mysql_error());
$filaOC = mysql_fetch_assoc($resultadoOC);
$totalfilas_buscaOC = mysql_num_rows($resultadoOC);

$buscaItem = "SELECT 
                  IdItem,
                  IdOrdencompra,
                  PS,
                  producto,
                  especificacion,
                  unidad,
                  cantidad,
                  frequerido,
                  clase
              FROM
                  itemoc
                      LEFT JOIN
                  clasesisc ON itemoc.IdCalse = clasesisc.IdClase
              WHERE
                  IdOrdencompra =   ".$solicitud;
$resultadoItem = mysql_query($buscaItem, $datos) or die(mysql_error());
$filaItem = mysql_fetch_assoc($resultadoItem);
$totalfilas_buscaItem = mysql_num_rows($resultadoItem);

// exit();

class PDF extends FPDF{

  var $widths; 
  var $aligns;
  var $borde;
  var $fill;
  var $alto;

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
  function SetAlto($a){
    
  }
  function Row($data,$q) 
  { 
    
      //Calculate the height of the row 
      $nb=0; 
      for($i=0;$i<count($data);$i++) 
          $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
      $h=$q*$nb; 
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
          $this->MultiCell($w,$q,$data[$i],$m,$a,$f); 
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
    global $codigo;
    global $version;
    global $fecha; 
    
    $this->SetFont('Arial','B',13);
    $this->SetX(60);
    $this->Cell(95,15,$title,1,0,'C'); 
    $this->SetFont('Arial','',8);
    $this->Cell(45,5,utf8_decode('CÓDIGO: MF07'),1,1,'C');
    
    $this->SetX(155);
    $this->Cell(45,5,utf8_decode('VERSIÓN: 02'),1,1,'C');

    $this->SetX(155);
    
    $this->Cell(45,5,'Hoja '.$this->PageNo().' de {nb}',1,1,'C'); 
    $this->Image('../imagenes/logofa.png',20,11.5,39,12);
    $this->SetXY(20,10);
    $this->Cell(40,15," ",1,1,'C');  
    
  //	$this->Ln(10);
    
  }
  function Footer()
  {
    global $ancho;
      global $ruta_qr;
    
    
    $this->SetY(-17);
      // $this->Image($ruta_qr,177,237,25,25);
      $this->Line(20,262,200,262);
      $this->Cell(180,4,utf8_decode('Calle 106 N° 59-21  PBX (57) 1 2265544 Bogotá D.C / Colombia Correo electrónico: recepcion@cpaingenieria.com'),0,1,'C');
    $pagina='Pagina '.$this->PageNo().'/{nb}';
    $t=$this->GetStringWidth($pagina)+6;
    $this->SetX(($ancho-$t));
    $this->SetFont('Arial','',8);
    
  }

}



$title="SOLICITUD DE COTIZACION";
$ancho=210;

// $ruta_qr = 'qr/qr-'.$solicitud.'.png';

// $texto='https://compras.cpaingenieria.com/compras/orcompra-pdf-con.php?oc='.$solicitud;
// $level = "Q";
// $tamano = 10;
// $framSize =3;

// QRcode::png($texto,$ruta_qr,$level,$tamano,$framSize);



$pdf = new PDF('P','mm',Letter);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(20);
$pdf->SetAutoPageBreak(1,40);
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

if($filaOC['critico']==1){
  $critico="SI";
}else{
  $critico="NO";
}


$pdf->Cell(180,6,"SOLICITUD DE COTIZACION No. ".$solicitud,1,1,'C');
$pdf->Cell(75,6,utf8_decode("CIUDAD: Bogotá D. C. "),1,0,'L');
$pdf->Cell(105,6,utf8_decode("FECHA: ").fechaactual3($filaOC['fsolicitud']),1,1,'L');
$pdf->Cell(180,6,utf8_decode("PROYECTO: ").utf8_decode($filaOC['area']),1,1,'L');
$pdf->Cell(125,6,utf8_decode("SOLICITANTE: ").utf8_decode($filaOC['solicitante']),1,0,'L');
$pdf->Cell(55,6,utf8_decode("CRITICO: ").utf8_decode($critico),1,1,'L');

$pdf->Ln(10);

$pdf->SetFont('Arial','B',8);
$pdf->SetWidths(array(10,39,12,12,32,18,39,9,9));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C'));
//$pdf->SetFillColor(216,216,216);
//$pdf->fill(array(1,1,1,1,1,1,1));
$pdf->Row(array('ITEM','PRODUCTO O SERVICIO','UND','CANT.','CLASE','FECHA PARA LA CUAL SE REQUIERE','OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD','PRO','SER'),5);
$pdf->SetFont('Arial','',8);

$item=1;
do{
  if($filaItem['PS']==1){
    $servicio="";
    $producto="X";
  }else{
    $servicio="X";
    $producto="";
  }

  $pdf->SetAligns(array('C','L','C','R','L','C','L','C','C'));
  $pdf->fill(array(0,0,0,0,0,0,0));
  
  $pdf->Row(array($item,utf8_decode($filaItem['producto']),utf8_decode($filaItem['unidad']),number_format($filaItem['cantidad'],2),utf8_decode($filaItem['clase']),fechaactual3($filaItem['frequerido']),utf8_decode($filaItem['especificacion']),$producto,$servicio),5);

  $item++;
} while ($filaItem = mysql_fetch_assoc($resultadoItem));


$pdf->SetFont('Arial','',8);

$pdf->Output();

// unlink($ruta_qr);



	



?>