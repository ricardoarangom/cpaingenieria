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

  // exit();

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

  if($_POST['IdFirma']){
    $IdFirma=$_POST['IdFirma'];
  }else{
    $IdFirma=0;
  }

  
  $insertaCarta="INSERT INTO cartas (destinatario1, destinatario2, destinatario3, destinatario4, destinatario5, asunto, fecha, IdUsuario, firmante, cargo, IdFirma, email, ano, consAno, consello, IdAutorfirma) 
                 VALUES('".$_POST['destinatario1']."','".$_POST['destinatario2']."','".$_POST['destinatario3']."','".$_POST['destinatario4']."','".$_POST['destinatario5']."','".$_POST['asunto']."','".date("Y-m-d")."',".$usuario.",'".$_POST['firmante']."','".$_POST['cargo']."', ".$IdFirma.", '".$_POST['email']."', ".$ano.", ".($filaCartas['ultimo']+1).", ".$_POST['consello']." , ".$_POST['IdAutorfirma'].")";
  // echo $insertaCarta."<br>";

  // exit();

  if ($results=@mysql_query($insertaCarta)){
    $last_id = mysql_insert_id($datos);
    $nparrafos = 0;
        
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
    ?>
    <script>
                    
      // window.open("carta-pdf.php?carta=<?php echo $last_id ?>", "_blank");
      window.open("carta-word.php?carta=<?php echo $last_id ?>", "_blank");
      window.location = "editaCarta.php?carta=<?php echo $last_id?>";
           
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

  

  $buscaCarta = " SELECT 
                      ano, consAno
                  FROM
                      cartas
                  WHERE
                      IdCarta = ".$_POST['IdCarta'];
  $resultadoCarta = mysql_query($buscaCarta, $datos) or die(mysql_error());
  $filaCarta = mysql_fetch_assoc($resultadoCarta);


  $arrayCarta=explode(".",$_FILES['carta']['name']);

  $cartaName='cartas/CPA-'.sprintf("%03d",$filaCarta['consAno'])."-".$filaCarta['ano'].".".$arrayCarta[1];

  $cartaName;

  move_uploaded_file($_FILES['carta']['tmp_name'],$cartaName);

  if($_POST['anexosEliminados']){
    $anexosEliminados=explode(",",$_POST['anexosEliminados']);
    
    foreach($anexosEliminados as $key=>$j){
      $buscaAmexos = "SELECT 
                          IdAnexo, vinculo
                      FROM
                          anexoscartas
                      WHERE
                          IdAnexo = ".$j;
      $resultadoAmexos = mysql_query($buscaAmexos, $datos) or die(mysql_error());
      $filaAmexos = mysql_fetch_assoc($resultadoAmexos);
      $totalfilas_buscaAmexos = mysql_num_rows($resultadoAmexos);
      unlink($filaAmexos['vinculo']);

      $borrarAnexo="DELETE FROM anexoscartas WHERE IdAnexo = ".$j;
      if ($results=@mysql_query($borrarAnexo)){
      }
    }
  }


  $grabado=0;
  $actualiza="UPDATE cartas set destinatario1='" . $_POST['destinatario1'] . "', destinatario2='" . $_POST['destinatario2'] . "', destinatario3='" . $_POST['destinatario3'] . "', destinatario4='" . $_POST['destinatario4'] . "', destinatario5='" . $_POST['destinatario5'] . "', asunto='" . $_POST['asunto'] . "', firmante='" . $_POST['firmante'] . "', cargo='" . $_POST['cargo'] . "', IdFirma=" . $_POST['IdFirma'] . ", email='" . $_POST['email'] . "', consello=".$_POST['consello'].", carta='".$cartaName."' where IdCarta=" . $_POST['IdCarta'];
  if ($results=@mysql_query($actualiza)){
    $grabado=1;
  }

  // echo $actualiza."<br>";

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

  // exit();
  if($grabado==1){
    $mensaje='<div>LA CARTA FUE GRABADA CON EXITO</div><div></div>';
    ?>
    <script>
        swal({
            html: "<?php echo $mensaje ?>",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {              
              // window.open("carta-pdf.php?carta=<?php echo $_POST['IdCarta'] ?>", "_blank");
              window.open("carta-word.php?carta=<?php echo $_POST['IdCarta'] ?>", "_blank");
              window.open("solautfirma.php?carta=<?php echo $_POST['IdCarta'] ?>", "_blank");
              window.close()
            }
          });
    </script>
    <?php
  }
}

if(isset($_POST['boton3'])){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";  

  $inserta="INSERT INTO correcibida (IdArea, remitente, destinatario, fecha, asunto) VALUES(".$_POST['IdArea'] .", '".$_POST['remitente'] ."', '".$_POST['destinatario']."', '".$_POST['fecha'] ."', '".$_POST['asunto'] ."' )";

  if($results=@mysql_query($inserta)){
    $last_id = mysql_insert_id($datos);

    $ruta="recibida/archivo-".$last_id.".pdf";

    if($_FILES['archivo']['tmp_name']){
      move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta);

      $actualiza="UPDATE correcibida SET archivo='".$ruta."' WHERE IdCorrespondencia=".$last_id;
      if($results=@mysql_query($actualiza)){
        ?>
        <script>
          swal({
            text: "LA CORRESPONDENCIA FUE GRABADA CORRECTAMENTE",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
              window.location = "inicio.php";
            }
          });
        </script>
        <?php
      }

      
    }
  }


}
?>



</body>
</html>