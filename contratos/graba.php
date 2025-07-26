<?php 
require_once('../connections/datos.php');

include('encabezado.php');
include('encabezado1.php');

  
if(isset($_POST['boton1'])){
  echo 'hola';

  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  $inserta="INSERT INTO borrclausulas (clausula) VALUES('".$_POST['texto']."')";
  if ($results=@mysql_query($graba)){

  }
}

if(isset($_POST['boton2'])){
 
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // exit();

  $buscaProve="SELECT IdContratista, proveedor, documento FROM contratistas where documento=".$_POST['nit'];
  $resultadoProve = mysql_query($buscaProve, $datos) or die(mysql_error());
  $row_ResultadoProve = mysql_fetch_assoc($resultadoProve);
  $totalFilasProve = mysql_num_rows($resultadoProve);
  if($totalFilasProve>0){
    ?>
    <script language="JavaScript" type="text/javascript">
      swal({
          //title: "Error al subir el archivo",
          text: "¡EL DOCUMENTO INGRESADO YA SE ENCUENTRA EN LA BASE DE DATOS Y CORRESPONDE A <?php echo $row_ResultadoProve['proveedor'] ?>!",
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "¡Cerrar!"
      }).then(function(result){
        if (result.value) {
          window.location = "inicio.php";
        }
      });
    </script>
    <?php
  }else{
    $graba="INSERT INTO contratistas (proveedor, documento, IdClasedoc, telefono, direccion, departamento, ciudad, fconstitucion, departamenton, ciudadn) VALUES('".$_POST['proveedor']."', ".$_POST['nit'].", ".$_POST['IdClasedoc'].", '".$_POST['telefono']."', '".$_POST['direccion']."', ".$_POST['depto'].", ".$_POST['municipio'].", '".$_POST['fconstitucion']."', ".$_POST['depton'].", ".$_POST['municipion'].")";
    if ($results=@mysql_query($graba)){
      ?>
      <script language="JavaScript" type="text/javascript">
        swal({
            //title: "Error al subir el archivo",
            text: "¡EL CONTRATISTA HA SIDO GRABADO!",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "¡Cerrar!"
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

if(isset($_POST['boton3'])){

  $actualiza="UPDATE contratistas SET proveedor='".$_POST['proveedor']."', IdClasedoc=".$_POST['IdClasedoc'].", documento='".$_POST['nit']."', telefono='".$_POST['telefono']."', direccion='".$_POST['direccion']."', departamento=".$_POST['depto'].", ciudad=".$_POST['municipio'].", fconstitucion='".$_POST['fconstitucion']."', departamenton=".$_POST['depton'].", ciudadn=".$_POST['municipion']." WHERE IdContratista=".$_POST['IdContratista'];

  if ($results=@mysql_query($actualiza)){
      ?>
      <script language="JavaScript" type="text/javascript">
        swal({
            //title: "Error al subir el archivo",
            text: "¡EL CONTRATISTA HA SIDO ACTUALIZADO!",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "¡Cerrar!"
        }).then(function(result){
          if (result.value) {
            window.location = "inicio.php";
          }
        });
      </script>
      <?php
    }	


}

include('footer.php');
?>
</body>
</html>