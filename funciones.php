<?php 
function cambiafecha ($fechaold){
	if($fechaold==NULL){
	$Fecha=NULL;
	}else{
	$fec = explode("-",$fechaold);
	$Fecha = $fec[2]."-".$fec[1]."-".$fec[0];
	return $Fecha;
}
}

function cambiafecha2 ($fechaold){
	if($fechaold==NULL){
	$newDate=NULL;
	}else{
	$originalDate = $fechaold;
	$newDate = date("d-m-Y", strtotime($originalDate));	
	return $newDate;
	}
}

function cambiafecha3 ($fechaold){
	if($fechaold==NULL){
	$newDate=NULL;
	}else{
	$originalDate = $fechaold;
	$newDate = date("d-m-y", strtotime($originalDate));	
	return $newDate;
	}
}


function fechaactual(){
switch (date("n")){
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

switch (date("w")){
	case 0:
	 $dia="Domingo";
	 break;
	case 1:
	 $dia="Lunes";
	 break;
	case 2:
	 $dia="Martes";
	 break;
	case 3:
	 $dia="Miercoles";
	 break;
	case 4:
	 $dia="Jueves";
	 break;
	case 5:
	 $dia="Viernes";
	 break;
	case 6:
	 $dia="Sabado";
	break;
}

$linea=$dia." ". date("d") . " de " . $mes . " de " . date("Y");
return $linea;	
	
}

function fechaactual1($fecha){
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

switch (date("w",strtotime($fecha))){
	case 0:
	 $dia="Domingo";
	 break;
	case 1:
	 $dia="Lunes";
	 break;
	case 2:
	 $dia="Martes";
	 break;
	case 3:
	 $dia="Miercoles";
	 break;
	case 4:
	 $dia="Jueves";
	 break;
	case 5:
	 $dia="Viernes";
	 break;
	case 6:
	 $dia="Sabado";
	break;
}

$linea=$dia." ". date("d",strtotime($fecha)) . " de " . $mes . " de " . date("Y",strtotime($fecha));
return $linea;	
	
}

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

function es_negativo($num) {
  return (is_numeric($num) and $num<0) ? true : false;
}

function fechaactual2($fecha){
switch (date("n",strtotime($fecha))){
	case 1:
	 $mes="ENERO";
	 break;
	case 2:
	 $mes="FEBRERO";
	 break;
	case 3:
	 $mes="MARZO";
	 break;
	case 4:
	 $mes="ABRIL";
	 break;
	case 5:
	 $mes="MAYO";
	 break;
	case 6:
	 $mes="JUNIO";
	 break;
	case 7:
	 $mes="JULIO";
	 break;
	case 8:
	 $mes="AGOSTO";
	 break;
	case 9:
	 $mes="SEPTIEMBRE";
	 break;
	case 10:
	 $mes="OCTUBRE";
	 break;
	case 11:
	 $mes="NOVIEMBRE";
	 break;
	case 12:
	 $mes="DICIEMBRE";
	break;
}



$linea=$mes . " DE " . date("Y",strtotime($fecha));
return $linea;	
	
}

function fechaactual3($fecha){
switch (date("n",strtotime($fecha))){
	case 1:
	 $mes="Ene";
	 break;
	case 2:
	 $mes="Feb";
	 break;
	case 3:
	 $mes="Mar";
	 break;
	case 4:
	 $mes="Abr";
	 break;
	case 5:
	 $mes="May";
	 break;
	case 6:
	 $mes="Jun";
	 break;
	case 7:
	 $mes="Jul";
	 break;
	case 8:
	 $mes="Ago";
	 break;
	case 9:
	 $mes="Sep";
	 break;
	case 10:
	 $mes="Oct";
	 break;
	case 11:
	 $mes="Nov";
	 break;
	case 12:
	 $mes="Dic";
	break;
}



$linea=date("d",strtotime($fecha))."-".$mes . "-" . date("Y",strtotime($fecha));
return $linea;	
	
}

function fechaactual4($fecha){
switch (date("n",strtotime($fecha))){
	case 1:
	 $mes="Ene";
	 break;
	case 2:
	 $mes="Feb";
	 break;
	case 3:
	 $mes="Mar";
	 break;
	case 4:
	 $mes="Abr";
	 break;
	case 5:
	 $mes="May";
	 break;
	case 6:
	 $mes="Jun";
	 break;
	case 7:
	 $mes="Jul";
	 break;
	case 8:
	 $mes="Ago";
	 break;
	case 9:
	 $mes="Sep";
	 break;
	case 10:
	 $mes="Oct";
	 break;
	case 11:
	 $mes="Nov";
	 break;
	case 12:
	 $mes="Dic";
	break;
}



$linea=$mes . "-" . date("y",strtotime($fecha));
return $linea;	
	
}


function fechaactual5($fecha){
switch (date("n",strtotime($fecha))){
	case 1:
	 $mes="Ene";
	 break;
	case 2:
	 $mes="Feb";
	 break;
	case 3:
	 $mes="Mar";
	 break;
	case 4:
	 $mes="Abr";
	 break;
	case 5:
	 $mes="May";
	 break;
	case 6:
	 $mes="Jun";
	 break;
	case 7:
	 $mes="Jul";
	 break;
	case 8:
	 $mes="Ago";
	 break;
	case 9:
	 $mes="Sep";
	 break;
	case 10:
	 $mes="Oct";
	 break;
	case 11:
	 $mes="Nov";
	 break;
	case 12:
	 $mes="Dic";
	break;
}



$linea=date("d",strtotime($fecha))."-".$mes . "-" . date("Y",strtotime($fecha))." ".date("H:i",strtotime($fecha));
return $linea;	
	
}

function fechaactual7($fecha){
switch ($fecha){
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


$linea=$mes;
return $linea;	
	
}

function fechaactual9($fecha){
	switch (date("n",strtotime($fecha))){
		case 1:
		 $mes="Ene";
		 break;
		case 2:
		 $mes="Feb";
		 break;
		case 3:
		 $mes="Mar";
		 break;
		case 4:
		 $mes="Abr";
		 break;
		case 5:
		 $mes="May";
		 break;
		case 6:
		 $mes="Jun";
		 break;
		case 7:
		 $mes="Jul";
		 break;
		case 8:
		 $mes="Ago";
		 break;
		case 9:
		 $mes="Sep";
		 break;
		case 10:
		 $mes="Oct";
		 break;
		case 11:
		 $mes="Nov";
		 break;
		case 12:
		 $mes="Dic";
		break;
	}


$linea=$mes;
return $linea;	
	
}

function fechaactual8($fecha){
switch ($fecha){
	case 1:
	 $mes="Ene-Mar";
	 break;
	case 2:
	 $mes="Abr-Jun";
	 break;
	case 3:
	 $mes="Jul-Sep";
	 break;
	case 4:
	 $mes="Oct-Dic";
	 break;
}

$linea=$mes;
return $linea;	
	
}

//function fechaactual10($fecha){
//	
//	$linea=date("d",strtotime($fecha))."-".$mes . "-" . date("Y",strtotime($fecha))." ".date("H:i",strtotime($fecha));
//return $linea;	
//	
//	
//}


function unidad($numuero){
switch ($numuero)
{
case 9:
{
$numu = "NUEVE";
break;
}
case 8:
{
$numu = "OCHO";
break;
}
case 7:
{
$numu = "SIETE";
break;
}
case 6:
{
$numu = "SEIS";
break;
}
case 5:
{
$numu = "CINCO";
break;
}
case 4:
{
$numu = "CUATRO";
break;
}
case 3:
{
$numu = "TRES";
break;
}
case 2:
{
$numu = "DOS";
break;
}
case 1:
{
$numu = "UNO";
break;
}
case 0:
{
$numu = "";
break;
}
}
return $numu;
}

function decena($numdero){

if ($numdero >= 90 && $numdero <= 99)
{
$numd = "NOVENTA ";
if ($numdero > 90)
$numd = $numd."Y ".(unidad($numdero - 90));
}
else if ($numdero >= 80 && $numdero <= 89)
{
$numd = "OCHENTA ";
if ($numdero > 80)
$numd = $numd."Y ".(unidad($numdero - 80));
}
else if ($numdero >= 70 && $numdero <= 79)
{
$numd = "SETENTA ";
if ($numdero > 70)
$numd = $numd."Y ".(unidad($numdero - 70));
}
else if ($numdero >= 60 && $numdero <= 69)
{
$numd = "SESENTA ";
if ($numdero > 60)
$numd = $numd."Y ".(unidad($numdero - 60));
}
else if ($numdero >= 50 && $numdero <= 59)
{
$numd = "CINCUENTA ";
if ($numdero > 50)
$numd = $numd."Y ".(unidad($numdero - 50));
}
else if ($numdero >= 40 && $numdero <= 49)
{
$numd = "CUARENTA ";
if ($numdero > 40)
$numd = $numd."Y ".(unidad($numdero - 40));
}
else if ($numdero >= 30 && $numdero <= 39)
{
$numd = "TREINTA ";
if ($numdero > 30)
$numd = $numd."Y ".(unidad($numdero - 30));
}
else if ($numdero >= 20 && $numdero <= 29)
{
if ($numdero == 20)
$numd = "VEINTE ";
else
$numd = "VEINTI".(unidad($numdero - 20));
}
else if ($numdero >= 10 && $numdero <= 19)
{
switch ($numdero){
case 10:
{
$numd = "DIEZ ";
break;
}
case 11:
{
$numd = "ONCE ";
break;
}
case 12:
{
$numd = "DOCE ";
break;
}
case 13:
{
$numd = "TRECE ";
break;
}
case 14:
{
$numd = "CATORCE ";
break;
}
case 15:
{
$numd = "QUINCE ";
break;
}
case 16:
{
$numd = "DIECISEIS ";
break;
}
case 17:
{
$numd = "DIECISIETE ";
break;
}
case 18:
{
$numd = "DIECIOCHO ";
break;
}
case 19:
{
$numd = "DIECINUEVE ";
break;
}
}
}
else
$numd = unidad($numdero);
return $numd;
}

function centena($numc){
if ($numc >= 100)
{
if ($numc >= 900 && $numc <= 999)
{
$numce = "NOVECIENTOS ";
if ($numc > 900)
$numce = $numce.(decena($numc - 900));
}
else if ($numc >= 800 && $numc <= 899)
{
$numce = "OCHOCIENTOS ";
if ($numc > 800)
$numce = $numce.(decena($numc - 800));
}
else if ($numc >= 700 && $numc <= 799)
{
$numce = "SETECIENTOS ";
if ($numc > 700)
$numce = $numce.(decena($numc - 700));
}
else if ($numc >= 600 && $numc <= 699)
{
$numce = "SEISCIENTOS ";
if ($numc > 600)
$numce = $numce.(decena($numc - 600));
}
else if ($numc >= 500 && $numc <= 599)
{
$numce = "QUINIENTOS ";
if ($numc > 500)
$numce = $numce.(decena($numc - 500));
}
else if ($numc >= 400 && $numc <= 499)
{
$numce = "CUATROCIENTOS ";
if ($numc > 400)
$numce = $numce.(decena($numc - 400));
}
else if ($numc >= 300 && $numc <= 399)
{
$numce = "TRESCIENTOS ";
if ($numc > 300)
$numce = $numce.(decena($numc - 300));
}
else if ($numc >= 200 && $numc <= 299)
{
$numce = "DOSCIENTOS ";
if ($numc > 200)
$numce = $numce.(decena($numc - 200));
}
else if ($numc >= 100 && $numc <= 199)
{
if ($numc == 100)
$numce = "CIEN ";
else
$numce = "CIENTO ".(decena($numc - 100));
}
}
else
$numce = decena($numc);

return $numce;
}

function miles($nummero){
if ($nummero >= 1000 && $nummero < 2000){
$numm = "MIL ".(centena($nummero%1000));
}
if ($nummero >= 2000 && $nummero <10000){
$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
}
if ($nummero < 1000)
$numm = centena($nummero);

return $numm;
}

function decmiles($numdmero){
if ($numdmero == 10000)
$numde = "DIEZ MIL";
if ($numdmero > 10000 && $numdmero <20000){
$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
}
if ($numdmero >= 20000 && $numdmero <100000){
$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
}
if ($numdmero < 10000)
$numde = miles($numdmero);

return $numde;
}

function cienmiles($numcmero){
if ($numcmero == 100000)
$num_letracm = "CIEN MIL";
if ($numcmero >= 100000 && $numcmero <1000000){
$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
}
if ($numcmero < 100000)
$num_letracm = decmiles($numcmero);
return $num_letracm;
}

function millon($nummiero){
if ($nummiero >= 1000000 && $nummiero <2000000){
$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
}
if ($nummiero >= 2000000 && $nummiero <10000000){
$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
}
if ($nummiero < 1000000)
$num_letramm = cienmiles($nummiero);

return $num_letramm;
}

function decmillon($numerodm){
if ($numerodm == 10000000)
$num_letradmm = "DIEZ MILLONES";
if ($numerodm > 10000000 && $numerodm <20000000){
$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
}
if ($numerodm >= 20000000 && $numerodm <100000000){
$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
}
if ($numerodm < 10000000)
$num_letradmm = millon($numerodm);

return $num_letradmm;
}

function cienmillon($numcmeros){
if ($numcmeros == 100000000)
$num_letracms = "CIEN MILLONES";
if ($numcmeros >= 100000000 && $numcmeros <1000000000){
$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
}
if ($numcmeros < 100000000)
$num_letracms = decmillon($numcmeros);
return $num_letracms;
}

function milmillon($nummierod){
if ($nummierod >= 1000000000 && $nummierod <2000000000){
$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod >= 2000000000 && $nummierod <10000000000){
$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod < 1000000000)
$num_letrammd = cienmillon($nummierod);

return $num_letrammd;
}


function convertir($numero){
  $num = str_replace(",","",$numero);
  $num = number_format($num,2,'.','');
  $cents = substr($num,strlen($num)-2,strlen($num)-1);
  $num = (int)$num;

  $numf = milmillon($num);

  return $numf." PESOS  CON ".$cents."/100";
}

function convertir1($numero){
  $num = str_replace(",","",$numero);
  $num = number_format($num,2,'.','');
  $cents = substr($num,strlen($num)-2,strlen($num)-1);
  $num = (int)$num;

  $numf = milmillon($num);

  return $numf;
}

//echo convertir($numero);

function numAletras($numero){
  
  $entero=intval($numero);
  $decimales=$numero-$entero;
  $decimales=intval($decimales*100);

  $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

  $enteroletras=$formatterES->format($entero);
	

  if($decimales>0){
    $decimalesletras=" con ".$formatterES->format($decimales)." centavos";
  }else{
    $decimalesletras="";
  }

  $numeroletras=(($enteroletras.$decimalesletras));
  return $numeroletras;

}

function nitcompleto($nit1){
  
  $vowels = array(".");
  $sinpuntos = str_replace($vowels, "", $nit1);
	$va1=sprintf("%15d",$sinpuntos); 
	$arr1 = str_split($va1);

  $sumad=0;

  for($i=0;$i<=count($arr1);$i++){
    switch ($i) {				
			case 0:
        $sumad=$sumad+$arr1[$i]*71;
        break;			case 1:
				$sumad=$sumad+$arr1[$i]*67;
				break;					
			case 2:
        $sumad=$sumad+$arr1[$i]*59;
        break;					
			case 3:
        $sumad=$sumad+$arr1[$i]*53;
        break;					
			case 4:
        $sumad=$sumad+$arr1[$i]*47;
        break;					
			case 5:
        $sumad=$sumad+$arr1[$i]*43;
        break;
      case 6:
        $sumad=$sumad+$arr1[$i]*41;
        break;
      case 7:
        $sumad=$sumad+$arr1[$i]*37;
        break;
      case 8:
        $sumad=$sumad+$arr1[$i]*29;
        break;
      case 9:
        $sumad=$sumad+$arr1[$i]*23;
        break;
      case 10:
        $sumad=$sumad+$arr1[$i]*19;
        break;
      case 11:
        $sumad=$sumad+$arr1[$i]*17;
        break;
      case 12:
        $sumad=$sumad+$arr1[$i]*13;
        break;
      case 13:
        $sumad=$sumad+$arr1[$i]*7;
        break;
      case 14:
        $sumad=$sumad+$arr1[$i]*3;
        break;
    }
  }


  $dv=$sumad%11;

  if($dv<>0 and $dv<>1){
    $dv=11-$dv;
  }

  $nit=$nit1."-".$dv;
  
  return $nit;
}

function digitoverificacion($numero){
	$va1=sprintf("%15d",$numero);
	$arr1 = str_split($va1);

	
	$sumad=0;

  for($i=0;$i<=count($arr1);$i++){
    switch ($i) {				
			case 0:
        $sumad=$sumad+$arr1[$i]*71;
        break;			case 1:
				$sumad=$sumad+$arr1[$i]*67;
				break;					
			case 2:
        $sumad=$sumad+$arr1[$i]*59;
        break;					
			case 3:
        $sumad=$sumad+$arr1[$i]*53;
        break;					
			case 4:
        $sumad=$sumad+$arr1[$i]*47;
        break;					
			case 5:
        $sumad=$sumad+$arr1[$i]*43;
        break;
      case 6:
        $sumad=$sumad+$arr1[$i]*41;
        break;
      case 7:
        $sumad=$sumad+$arr1[$i]*37;
        break;
      case 8:
        $sumad=$sumad+$arr1[$i]*29;
        break;
      case 9:
        $sumad=$sumad+$arr1[$i]*23;
        break;
      case 10:
        $sumad=$sumad+$arr1[$i]*19;
        break;
      case 11:
        $sumad=$sumad+$arr1[$i]*17;
        break;
      case 12:
        $sumad=$sumad+$arr1[$i]*13;
        break;
      case 13:
        $sumad=$sumad+$arr1[$i]*7;
        break;
      case 14:
        $sumad=$sumad+$arr1[$i]*3;
        break;
    }
  }

  $dv=$sumad%11;

  if($dv<>0 and $dv<>1){
    $dv=11-$dv;
  }
	
	return $dv;
}

function colocapuntos($numero,$posicion=3) {
  
  $cadena1 = strval($numero);
    
  $nueva = '';
  $l=1;
  for( $n=strlen($cadena1);$n>0;$n-- ) {

      if( $l % $posicion == 0 and $n<>1 ) {
        $l=0;
        $letra = ".";
      }else{
        $letra="";
      }
      
      $l++;
      
      $scad= substr($cadena1,($n-strlen($cadena1)-1),1);
      $nueva=$letra.$scad.$nueva;
    
  }
  return $nueva;

}

function diaspfiscales($nit){
  $nitn=substr($nit,-2);
  if($nitn==0){
    $dia=2;
  }else{
    $l=0;
    for($i=1;$i<=15;$i++){
      if($i<=9){
        if($nitn<=($i*7) and $nitn>(($i-1)*7)){
          $dia=$i+1;
        }        
      }else{
        if($nitn<=(($i*7)-($l+1)) and $nitn>((($i-1)*7)-$l)){
          $dia=$i+1;
        } 
        $l++;
      }
      
      
       
    }
    
  }
  $j=2;
  $k=2;
  $mes=date("m");
  $ano=date("Y");
  //return $ano;
  while($j<=$dia){
    $fecha=$ano."-".$mes."-".$k;
    $fecha1=strtotime($fecha);
    if(date("N",$fecha1)==6 or date("N",$fecha1)==7){
      $k++;
    }else{
      $ffin=$ano."-".$mes."-".$k;
      $k++;
      $j++;
    }   
    
  }
  return $ffin;
}

function esFecha($cadena){
	$valores=explode("-",$cadena);

	if(count($valores)==3){
		if(checkdate($valores[1], $valores[2], $valores[0])){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}

function calculaTiempo($inicio,$fin){
	
	$arrayInicio=explode("-",$inicio);
	$arrayFin=explode("-",$fin);
	
	$cantAnos=$arrayFin[0]-$arrayInicio[0];
	
	$cantMeses=$arrayFin[1]-$arrayInicio[1]+($cantAnos*12);	 
	
	if($arrayInicio[2]>$arrayFin[2]){
		if($arrayInicio[1]==2 and $arrayInicio[2]==28){
			$cantDias=$arrayFin[2]-$arrayInicio[2]+29;
			if($cantDias>=28){
				$cantDias=0;				
			}
		}else{
			$cantDias=$arrayFin[2]-$arrayInicio[2]+31;
			if($cantDias>=30){
				$cantDias=0;
			}else{
				$cantMeses--;
			}
		}				
		if($arrayFin[1]==2 and $cantDias==28){
			$cantDias=0;
			$cantMeses++;
		}	
		
	}
	if($arrayInicio[2]<$arrayFin[2] ){
		$cantDias=$arrayFin[2]-$arrayInicio[2]+1;
		if($cantDias>=30){
			$cantDias=0;
			$cantMeses++;
		}
		if($arrayFin[1]==2 and $cantDias==28){
			$cantDias=0;
			$cantMeses++;
		}
	}	
	if($arrayInicio[2]==$arrayFin[2]){
		$cantDias=1;
	}
	
	return $cantMeses.",".$cantDias;
	
}
?>




