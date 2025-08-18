<?php 
require_once('../connections/datos.php');
$contrato=$_GET['contrato'];


$buscaCont = "SELECT 
                  IdSubclase
              FROM
                  contrat
              WHERE
                  IdContrato =  ". $contrato;
$resultadoCont = mysql_query($buscaCont, $datos) or die(mysql_error());
$filaCont = mysql_fetch_assoc($resultadoCont);
$totalfilas_buscaCont = mysql_num_rows($resultadoCont);

if($filaCont['IdSubclase']==1){
  header('Location: contlabaprendiz-pdf.php?contrato=' . $contrato);
  exit; // Importante para detener la ejecución del script.
}

if($filaCont['IdSubclase']==2){
  header('Location: contlabobra-pdf.php?contrato=' . $contrato);
  exit; // Importante para detener la ejecución del script.
}

if($filaCont['IdSubclase']==3){
  header('Location: contlabfijo-pdf.php?contrato=' . $contrato);
  exit; // Importante para detener la ejecución del script.
}

if($filaCont['IdSubclase']==4){
  header('Location: contlabindef-pdf.php?contrato=' . $contrato);
  exit; // Importante para detener la ejecución del script.
}

if($filaCont['IdSubclase']==5){
  header('Location: contrato-prestacion-servicio-persona-word.php?contrato=' . $contrato);
  exit; // Importante para detener la ejecución del script.

}

if($filaCont['IdSubclase']==6){
  header('Location: contrato-prestacion-servicio-empresa-word.php?contrato=' . $contrato);
  exit; // Importante para detener la ejecución del script.

  
}


?>