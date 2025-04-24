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

  
  $insertaCarta="INSERT INTO cartas (destinatario1, destinatario2, destinatario3, asunto, fecha, IdUsuario, firmante) 
                 VALUES('".$_POST['destinatario1']."','".$_POST['destinatario2']."','".$_POST['destinatario3']."','".$_POST['asunto']."','".date("Y-m-d")."',".$usuario.",'".$_POST['firmante']."')";
  // echo $insertaCarta."<br>";

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

?>



</body>
</html>