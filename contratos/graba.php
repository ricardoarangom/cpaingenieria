<?php 
require_once('../connections/datos.php');

include('encabezado.php');
include('encabezado1.php');

  
if(isset($_POST['boton1'])){
  
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // echo $usuario;

  $buscaCont = "SELECT 
                    MAX(consec) AS maximo
                FROM
                    contrat
                WHERE
                    IdClase = ".$_POST['IdClase'];
  $resultadoCont = mysql_query($buscaCont, $datos) or die(mysql_error());
  $filaCont = mysql_fetch_assoc($resultadoCont);
  $totalfilas_buscaCont = mysql_num_rows($resultadoCont);

  $consec= $filaCont['maximo']+1;

  if($_POST['objeto']){
    $objeto=$_POST['objeto'];
  }else{
    $objeto=NULL;
  }

  if($_POST['ffin']){
    $ffin=$_POST['ffin'];
  }else{
    $ffin=NULL;
  }

  if($_POST['iva']==1){
    $iva=0.19;
  }else{
    $iva=0;
  }

  if($_POST['IdCargo']){
    $cargo=$_POST['IdCargo'];
  }else{
    $cargo=0;
  }

  if($_POST['especialidad']){
    $especialidad=$_POST['especialidad'];
  }else{
    $especialidad=NULL;
  }

  if($_POST['grupo']){
    $grupo=$_POST['grupo'];
  }else{
    $grupo=NULL;
  }

  if($_POST['centrofor']){
    $centrofor=$_POST['centrofor'];
  }else{
    $centrofor=NULL;
  }

  if($_POST['alcance']){
    $alcance=$_POST['alcance'];
  }else{
    $alcance=NULL;
  }

  if($_POST['ffinfin']){
    $ffinfin=$_POST['ffinfin'];
  }else{
    $ffinfin=NULL;
  }

   if($_POST['lugar']){
    $lugar=$_POST['lugar'];
  }else{
    $lugar=0;
  }


  $inserta="INSERT INTO contrat (IdProveedor, IdEmpresa, IdArea, IdSolicitante, IdClase, IdSubClase, objeto, finicio, ffin, iva, consec, valor, integral, IdCargo, incs, especialidad, grupo, centrofor, alcance, ffinfin, lugar, auxilio) VALUES (".$_POST['contratista'].", 1, ".$_POST['IdArea'].", ".$usuario.", ".$_POST['IdClase'].", ".$_POST['IdSubClase'].", ".($objeto == NULL ? "NULL" : "'$objeto'").", '".$_POST['finicio']."', ".($ffin == NULL ? "NULL" : "'$ffin'").", ".$iva.", ".$consec.", ".$_POST['valor'].", ".$_POST['integral'].", ".$cargo.", ".$_POST['incs'].", ".($especialidad == NULL ? "NULL" : "'$especialidad'").", ".($grupo == NULL ? "NULL" : "'$grupo'").", ".($centrofor == NULL ? "NULL" : "'$centrofor'").", ".($alcance == NULL ? "NULL" : "'$alcance'").", ".($ffinfin == NULL ? "NULL" : "'$ffinfin'").", ".$lugar.", ".$_POST['auxilio'].")";
  // echo $inserta."<br>";
  $nfunciones=0;
  $nproductos=0;
  $npagos=0;
  $nactividades=0;
  $nresponsabilidades=0;
  if ($results=@mysql_query($inserta)){
    $last_id = mysql_insert_id($datos);

    if($_POST['actividad']){
      foreach($_POST['actividad'] as $key=>$j){
        if($j){
          $insertaActividad="INSERT INTO actividadescont (IdContrato, actividad) VALUES(".$last_id.", '".$j."')";
          // echo $insertaActividad."<br>";
          if ($results=@mysql_query($insertaActividad)){
            $nactividades++;
          }

        }
      }

    }

    if($_POST['producto']){
      foreach($_POST['producto'] as $key=>$j){
        if($j){
          $insertaProducto="INSERT INTO productoscont (IdContrato, producto) VALUES(".$last_id.", '".$j."')";
          // echo $insertaProducto."<br>";
          if ($results=@mysql_query($insertaProducto)){
            $nproductos++;
          }
        }
      }
      
    }

    if($_POST['porpago']){
      foreach($_POST['porpago'] as $key=>$j){
        if($j){
          $insertaPago="INSERT INTO formapagocont (IdContrato, porpago, concepto) VALUES (".$last_id.", ".($j/100).", '".$_POST['concepto'][$key]."')";
          if ($results=@mysql_query($insertaPago)){
            $npagos++;
          }
          // echo $insertaPago."<br>";
        }
      }
      
    }

    if($_POST['funcion']){
      foreach($_POST['funcion'] as $key=>$j){
        if($j){
          $insertaFuncion="INSERT INTO funcionescont (IdContrato, funcion) VALUES(".$last_id.", '".$j."')";
          if ($results=@mysql_query($insertaFuncion)){
            $nfunciones++;
          }
          // echo $insertaFuncion."<br>";

        }
      }
      
    }

    if($_POST['responsabilidad']){
      foreach($_POST['responsabilidad'] as $key=>$j){
        if($j){
          $insertaResponsabilidad="INSERT INTO resposabilidadescont (IdContrato, responsabilidad) VALUES(".$last_id.", '".$j."')";
          if ($results=@mysql_query($insertaResponsabilidad)){
            $nresponsabilidades++;
          }
          // echo $insertaResponsabilidad."<br>";
        }
      }
    }
    $mensaje="<div>CONTRATO GRABADO CON EXITO</div>";
    if($_POST['IdSubClase']<>1){
      $mensaje.="<div>SE GRABARON:</div>";
      if($nfunciones<>0){
        $mensaje.="<div>".$nfunciones." FUNCIONES</div>";
      };
      if($nproductos<>0){
        $mensaje.="<div>".$nproductos." PRODUCTOS</div>";
      };
      if($npagos<>0){
        $mensaje.="<div>".$npagos." PAGOS</div>";
      };
      if($nactividades<>0){
        $mensaje.="<div>".$nactividades." ACTIVIDADES</div>";
      };
      if($nresponsabilidades<>0){
        $mensaje.="<div>".$nresponsabilidades." RESPONSABILIDADES</div>";
      };
    }

    ?>
    <script language="JavaScript" type="text/javascript">
      swal({
          html: "<?php echo $mensaje ?>",
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
    if($_POST['IdClasedocrep']){
      $IdClasedocrep=$_POST['IdClasedocrep'];
    }else{
      $IdClasedocrep=0;
    }
    if($_POST['municipioe']){
      $municipioe=$_POST['municipioe'];
    }else{
      $municipioe=0;
    }
    $graba="INSERT INTO contratistas (proveedor, documento, IdClasedoc, telefono, direccion, departamento, ciudad, fconstitucion, departamenton, ciudadn, email, replegal, IdClasedocrep, docrep, munexp) VALUES('".$_POST['proveedor']."', ".$_POST['nit'].", ".$_POST['IdClasedoc'].", '".$_POST['telefono']."', '".$_POST['direccion']."', ".$_POST['depto'].", ".$_POST['municipio'].", '".$_POST['fconstitucion']."', ".$_POST['depton'].", ".$_POST['municipion'].", '".$_POST['email']."', '".$_POST['replegal']."', ".$IdClasedocrep.", '".$_POST['docrep']."', ".$municipioe.")";
    // echo $graba;
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

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  if($_POST['IdClasedocrep']){
    $IdClasedocrep=$_POST['IdClasedocrep'];
  }else{
    $IdClasedocrep=0;
  }

  $actualiza="UPDATE contratistas SET proveedor='".$_POST['proveedor']."', IdClasedoc=".$_POST['IdClasedoc'].", documento='".$_POST['nit']."', telefono='".$_POST['telefono']."', direccion='".$_POST['direccion']."', departamento=".$_POST['depto'].", ciudad=".$_POST['municipio'].", fconstitucion='".$_POST['fconstitucion']."', departamenton=".$_POST['depton'].", ciudadn=".$_POST['municipion'].", email='".$_POST['email']."', replegal='".$_POST['replegal']."', docrep='".$_POST['docrep']."', IdClasedocrep=".$IdClasedocrep.", munexp=".$_POST['municipioe']."   WHERE IdContratista=".$_POST['IdContratista'];

  // echo $actualiza;

  

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