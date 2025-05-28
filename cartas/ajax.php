<?php 
require_once('../connections/datos.php');
require_once('../funciones.php');

if(($_POST['proced']==1)){

  $buscaFirmas  = "SELECT * FROM firmas where IdUsuario=".$_POST['usuario'];
  $resultadoFirmas = mysql_query($buscaFirmas, $datos) or die(mysql_error());
  $filaFirmas = mysql_fetch_assoc($resultadoFirmas);
  $totalfilas_buscaFirmas = mysql_num_rows($resultadoFirmas);

  if($totalfilas_buscaFirmas>0){
    do{
      ?>
      <div class="span-1">        
        <img src="<?php echo $filaFirmas['firma'] ?>" width="180px" alt="" style="cursor: pointer" onClick="seleccionaFirma(<?php echo $filaFirmas['IdFirma']?>)">
      </div>
      <?php
    } while ($filaFirmas = mysql_fetch_assoc($resultadoFirmas));
  }else{
    ?>
    <div class="span-4">
      <h5 align="center">NO HAY FIRMAS REGISTRADAS</h5>
    </div>  
    <?php
  }
  

}

if(($_POST['proced']==2)){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";

  $busca = " select max(IdFirma) as ultimo from firmas ";
  $resultado = mysql_query($busca, $datos) or die(mysql_error());
  $fila = mysql_fetch_assoc($resultado);
  $totalfilas_busca = mysql_num_rows($resultado);

  $ultimo = $fila['ultimo']+1;

  $ruta="../firmas/firma-".$ultimo.".png";
  move_uploaded_file($_FILES['firma']['tmp_name'],$ruta);

  $inserta = "INSERT INTO firmas (firma, IdUsuario) values ('".$ruta."', ".$_POST['usuario'].")";

  if ($results=@mysql_query($inserta)){
		echo "ok";
	}

}

if(($_POST['proced']==3)){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";

  $ruta="radicados/radicado-".$_POST['id'].".pdf";
  move_uploaded_file($_FILES['radicado']['tmp_name'],$ruta);

  if($_POST['opcion']==1){
    $actualiza="UPDATE cartas set radicado='" . $ruta . "' where IdCarta=" . $_POST['id'];
  }
  if($_POST['opcion']==2){
    $actualiza="UPDATE cartas set radicado='" . $ruta . "', fenvio='" . $_POST['fradicado'] . "', enviada=1 where IdCarta=" . $_POST['id'];
  }

  if ($results=@mysql_query($actualiza)){
		echo "ok";
	}

}

if(($_POST['proced']==4)){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  $actualiza="UPDATE cartas set anulada=1  where IdCarta=" . $_POST['IdCarta'];

  if ($results=@mysql_query($actualiza)){
		echo "ok";
	}
}
?>