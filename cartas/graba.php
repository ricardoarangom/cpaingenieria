<?php require_once('../connections/datos.php'); ?>
<?php 

set_time_limit(0);
require("../smtptester/class.phpmailer.php");

session_start();
$usuario=$_SESSION['IdUsuario'];

?>

<?php 
include('encabezado.php');	
?>

<?php 
include('encabezado1.php');	
?>

<?php
// $path="anexos/";
// if (!file_exists($path)) {
//   mkdir($path, 0777, true);
// }

if(isset($_POST['boton1'])){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";

  $ano=date("Y");

  $buscaCartas = "SELECT 
                    MAX(consAno) as ultimo
                FROM
                    cartas
                where ano=".$ano;
  $resultadoCartas = mysql_query($buscaCartas, $datos) or die(mysql_error());
  $filaCartas = mysql_fetch_assoc($resultadoCartas);
  $totalfilas_buscaCartas = mysql_num_rows($resultadoCartas);

  

  
  $insertaCarta="INSERT INTO cartas (destinatario1, destinatario2, destinatario3, destinatario4, destinatario5, asunto, fecha, IdUsuario, firmante, cargo, IdFirma, email, ano, consAno) 
                 VALUES('".$_POST['destinatario1']."','".$_POST['destinatario2']."','".$_POST['destinatario3']."','".$_POST['destinatario4']."','".$_POST['destinatario5']."','".$_POST['asunto']."','".date("Y-m-d")."',".$usuario.",'".$_POST['firmante']."','".$_POST['cargo']."', ".$_POST['IdFirma'].", '".$_POST['email']."', ".$ano.", ".($filaCartas['ultimo']+1).")";
  // echo $insertaCarta."<br>";

  // exit();

  if ($results=@mysql_query($insertaCarta)){
    $last_id = mysql_insert_id($datos);
    $nparrafos = 0;
    foreach($_POST['parrafo'] as $key=>$j){
      if($j){
        $insertaParrafos="INSERT INTO parrafoscartas (IdCarta, parrafo) VALUES(".$last_id.",'".$j."')";
        // echo $insertaParrafos."<br>";
        if ($results=@mysql_query($insertaParrafos)){
          $nparrafos++;
        }
      }
      
    }
    
    $ndocumentos=0;
    foreach($_FILES['anexo']['tmp_name'] as $key=>$j){
      if($j){
        
        $tipo=$_FILES['anexo']['type'][$key];
        $tamano=$_FILES['anexo']['size'][$key];

        $fecha1=date("YmdHis");
        $ruta="anexos/anexo-".$key."-".$_POST['nombre'][$key]."-".$fecha1."-".$last_id.".pdf";
        if ($tamano<=2000000){
          if($tipo=="application/pdf" OR $tipo==""){			
            move_uploaded_file($_FILES['anexo']['tmp_name'][$key],$ruta);
            $insertaAnexo="INSERT INTO anexoscartas (IdCarta, vinculo, nombre) VALUES (".$last_id.", '".$ruta."','".$_POST['nombre'][$key]."')";
            if ($results=@mysql_query($insertaAnexo)){
              $ndocumentos++;
            }
          }
        }
      }
    }

    $mensaje='<div>LA CARTA FUE GRABADA CON EXITO</div><div>SE GRABARON '.$nparrafos.' PARRAFOS</div><div>SE SUBIERON '.$ndocumentos.' ARCHIVOS</div>';
    ?>
    <script>
        swal({
            html: "<?php echo $mensaje ?>",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {              
              window.open("carta-pdf.php?carta=<?php echo $last_id ?>", "_blank");
              window.location = "inicio.php";
            }
          });
    </script>
    <?php

  }

  
}

if(isset($_POST['boton2'])){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";

  $grabado=0;
  $actualiza="UPDATE cartas set destinatario1='" . $_POST['destinatario1'] . "', destinatario2='" . $_POST['destinatario2'] . "', destinatario3='" . $_POST['destinatario3'] . "', destinatario4='" . $_POST['destinatario4'] . "', destinatario5='" . $_POST['destinatario5'] . "', asunto='" . $_POST['asunto'] . "', firmante='" . $_POST['firmante'] . "', cargo='" . $_POST['cargo'] . "', IdFirma=" . $_POST['IdFirma'] . ", email='" . $_POST['email'] . "' where IdCarta=" . $_POST['IdCarta'];
  if ($results=@mysql_query($actualiza)){
    $grabado=1;
  }

  // echo $actualiza."<br>";

  foreach($_POST['parrafog'] as $key=>$j){
    $actualizaPar="UPDATE parrafoscartas set parrafo='" . $j . "' where IdParrafo=".$key;
    if ($results=@mysql_query($actualizaPar)){
    }

  }

  if($_POST['parrafo']){
    foreach($_POST['parrafo'] as $key=>$j){
      if($j){
        $insertaParrafos="INSERT INTO parrafoscartas (IdCarta, parrafo) VALUES(".$_POST['IdCarta'].",'".$j."')";
        echo $insertaParrafos."<br>";
        if ($results=@mysql_query($insertaParrafos)){
          $nparrafos++;
        }
      }
      
    }
  }

  foreach($_FILES['anexo']['tmp_name'] as $key=>$j){
    if($j){
      
      $tipo=$_FILES['anexo']['type'][$key];
      $tamano=$_FILES['anexo']['size'][$key];

      $fecha1=date("YmdHis");
      $ruta="anexos/anexo-".$key."-".$_POST['nombre'][$key]."-".$fecha1."-".$_POST['IdCarta'].".pdf";
      if ($tamano<=2000000){
        if($tipo=="application/pdf" OR $tipo==""){			
          move_uploaded_file($_FILES['anexo']['tmp_name'][$key],$ruta);
          $insertaAnexo="INSERT INTO anexoscartas (IdCarta, vinculo, nombre) VALUES (".$_POST['IdCarta'].", '".$ruta."','".$_POST['nombre'][$key]."')";
          if ($results=@mysql_query($insertaAnexo)){
            $ndocumentos++;
          }
        }
      }
    }
  }
  if($grabado==1){
    $mensaje='<div>LA CARTA FUE ACTUALIZADA CON EXITO</div><div></div>';
    ?>
    <script>
        swal({
            html: "<?php echo $mensaje ?>",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {              
              window.open("carta-pdf.php?carta=<?php echo $_POST['IdCarta'] ?>", "_blank");
              window.close()
            }
          });
    </script>
    <?php
  }
}
?>



</body>
</html>