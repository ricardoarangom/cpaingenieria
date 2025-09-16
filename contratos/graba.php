<?php 
require_once('../connections/datos.php');

include('encabezado.php');
include('encabezado1.php');

  
if(isset($_POST['boton1'])){
  
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // // echo $usuario;

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";


  // exit();

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
    $lugar=NULL;
  } 


  $inserta="INSERT INTO contrat (IdProveedor, IdEmpresa, IdArea, IdSolicitante, IdClase, IdSubClase, objeto, finicio, ffin, iva, consec, valor, integral, IdCargo, incs, especialidad, grupo, centrofor, alcance, ffinfin, lugar, auxilio, IdFirmante) VALUES (".$_POST['contratista'].", 1, ".$_POST['IdArea'].", ".$usuario.", ".$_POST['IdClase'].", ".$_POST['IdSubClase'].", ".($objeto == NULL ? "NULL" : "'$objeto'").", '".$_POST['finicio']."', ".($ffin == NULL ? "NULL" : "'$ffin'").", ".$iva.", ".$consec.", ".$_POST['valor'].", ".$_POST['integral'].", ".$cargo.", ".$_POST['incs'].", ".($especialidad == NULL ? "NULL" : "'$especialidad'").", ".($grupo == NULL ? "NULL" : "'$grupo'").", ".($centrofor == NULL ? "NULL" : "'$centrofor'").", ".($alcance == NULL ? "NULL" : "'$alcance'").", ".($ffinfin == NULL ? "NULL" : "'$ffinfin'").", ".($lugar == NULL ? "NULL" : "'$lugar'").", ".$_POST['auxilio'].", ".$_POST['IdFirmante'].")";
  // echo $inserta."<br>";
  $nfunciones=0;
  $nproductos=0;
  $npagos=0;
  $nactividades=0;
  $nresponsabilidades=0;
  if ($results=@mysql_query($inserta)){
    $last_id = mysql_insert_id($datos);

    if(isset($_POST['actividad'])){
      foreach($_POST['actividad'] as $key=>$j){
        if($j){
          $insertaActividad="INSERT INTO actividadescont (IdContrato, actividad) VALUES(".$last_id.", '".$j."')";
          echo $insertaActividad."<br>";
          if ($results=@mysql_query($insertaActividad)){
            $nactividades++;
          }

        }
      }

    }

    if(isset($_POST['producto'])){
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

    if(isset($_POST['porpago'])){
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

    if(isset($_POST['funcion'])){
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

    if(isset($_POST['responsabilidad'])){
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
    if($nfunciones<>0 or $nproductos<>0 or $npagos<>0 or $nactividades<>0 or $nresponsabilidades<>0){
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

    if($_FILES['anexo']['tmp_name']){
        
      $tipo=$_FILES['anexo']['type'];
      $tamano=$_FILES['anexo']['size'];

      $fecha1=date("YmdHis");
      $ruta="anexos/anexo-".$last_id.".pdf";
      if ($tamano<=2000000){
        if($tipo=="application/pdf" OR $tipo==""){			
          move_uploaded_file($_FILES['anexo']['tmp_name'],$ruta);
          $insertaAnexo="UPDATE contrat SET anexo='".$ruta."' WHERE IdContrato=".$last_id;
          if ($results=@mysql_query($insertaAnexo)){
            $mensaje.="<div>TERMINOS DE REFERENCIA GRABADOS</div>";
          }
        }
      }
    }

    ?>
    <script language="JavaScript" type="text/javascript">
      var laboral = <?php echo $_POST['IdClase'] ?>;
      var subClase = <?php echo $_POST['IdSubClase'] ?>;
      var contrato = <?php echo $last_id ?: 0 ?>;
      swal({
          html: "<?php echo $mensaje ?>",
          type: "success",
          showConfirmButton: true,
          confirmButtonText: "¡Cerrar!"
      }).then(function(result){
        if (result.value) {
          if(laboral == 1){
            window.open('contratolab-pdf.php?contrato='+contrato, '_blank');
          } else if(laboral == 2){
            if(subClase == 5){
              window.open('contrato-prestacion-servicio-persona-word.php?contrato='+contrato, '_blank');
            } else {
              window.open('contrato-prestacion-servicio-empresa-word.php?contrato='+contrato, '_blank');
            }
          }
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

if(isset($_POST['boton4'])){

  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";  

  // echo "<pre>";
  // print_r($_FILES);
  // echo "</pre>";

  if($_FILES['anexo']['tmp_name']){
    $tipo=$_FILES['anexo']['type'];
    $tamano=$_FILES['anexo']['size'];

    $fecha1=date("YmdHis");
    $ruta="anexos/anexo-".$_POST['IdContrato'].".pdf";
    if ($tamano<=2000000){
      if($tipo=="application/pdf" OR $tipo==""){			
        move_uploaded_file($_FILES['anexo']['tmp_name'],$ruta);
      }
    }
  }else{
    if($_POST['anexoA']){
      $ruta=$_POST['anexoA'];
    }else{
      $ruta=NULL;
    }
  }
    

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
    if(is_numeric($_POST['lugar'])){
      $lugar=NULL;
    }else{
      $lugar=$_POST['lugar'];
    }    
  }else{
    $lugar=NULL;
  } 

  $grabado=0;
  $actualiza="UPDATE contrat SET IdProveedor=".$_POST['contratista'].", IdArea=".$_POST['IdArea'].", IdClase=".$_POST['IdClase'].", IdSubClase=".$_POST['IdSubClase'].", objeto=".($objeto == NULL ? "NULL" : "'$objeto'").", finicio='".$_POST['finicio']."', ffin=".($ffin == NULL ? "NULL" : "'$ffin'").", ffinfin=".($ffinfin == NULL ? "NULL" : "'$ffinfin'").", iva=".$iva.", valor=".$_POST['valor'].", integral=".$_POST['integral'].", IdCargo=".$_POST['IdCargo'].", incs=".$_POST['incs'].", especialidad=".($especialidad == NULL ? "NULL" : "'$especialidad'").", grupo=".($grupo == NULL ? "NULL" : "'$grupo'").", centrofor=".($centrofor == NULL ? "NULL" : "'$centrofor'").", alcance=".($alcance == NULL ? "NULL" : "'$alcance'").", lugar=".($lugar == NULL ? "NULL" : "'$lugar'").", auxilio=".$_POST['auxilio'].", IdFirmante=".$_POST['IdFirmante'].", anexo=".($ruta == NULL ? "NULL" : "'$ruta'")." WHERE IdContrato=".$_POST['IdContrato'];
  if ($results=@mysql_query($actualiza)){
    $grabado=1;
  }
  // echo $actualiza;

  if($_POST['funcion']){
    foreach($_POST['funcion'] as $key=>$j){
      if($_POST['IdFuncion'][$key]){
        $actualizaFun="UPDATE funcionescont SET funcion='".$j."' WHERE IdFuncion=".$_POST['IdFuncion'][$key];
        if ($results=@mysql_query($actualizaFun)){    
        }
      }else{
        $insertaFun="INSERT INTO funcionescont (IdContrato, funcion) VALUES(".$_POST['IdContrato'].", '".$j."')";
        if ($results=@mysql_query($insertaFun)){    
        }
      }
    }
  }

  if($_POST['responsabilidad']){
    foreach($_POST['responsabilidad'] as $key=>$j){
      if($_POST['IdResponsabilidad'][$key]){
        $actualizaRes="UPDATE resposabilidadescont SET responsabilidad='".$j."' WHERE IdResponsabilidad=".$_POST['IdResponsabilidad'][$key];
        if ($results=@mysql_query($actualizaRes)){    
        }
      }else{
        $insertaRes="INSERT INTO resposabilidadescont (IdContrato, responsabilidad) VALUES(".$_POST['IdContrato'].", '".$j."')";
       if ($results=@mysql_query($insertaRes)){    
       }
      }
    }
  }

  if($_POST['actividad']){
    foreach($_POST['actividad'] as $key=>$j){
      if($_POST['IdActividad'][$key]){
        $actualizaAct="UPDATE actividadescont SET actividad='".$j."' WHERE IdActividad=".$_POST['IdActividad'][$key];
        if ($results=@mysql_query($actualizaAct)){    
        }
      }else{
        $insertaAct="INSERT INTO actividadescont (IdContrato, actividad) VALUES(".$_POST['IdContrato'].", '".$j."')";
        if ($results=@mysql_query($insertaAct)){    
        }
      }
    }
  }

  if($_POST['producto']){
    foreach($_POST['producto'] as $key=>$j){
      if($_POST['IdProducto'][$key]){
        $actualizaPro="UPDATE productoscont SET producto='".$j."' WHERE IdProducto=".$_POST['IdProducto'][$key];
        if ($results=@mysql_query($actualizaPro)){    
        }
      }else{
        $insertaPro="INSERT INTO productoscont (IdContrato, producto) VALUES(".$_POST['IdContrato'].", '".$j."')";
        if ($results=@mysql_query($insertaPro)){    
        }
      }
    }
  }

  if($_POST['porpago']){
    foreach($_POST['porpago'] as $key=>$j){
      if($_POST['IdFroma'][$key]){
        $actualizaFor="UPDATE formapagocont SET porpago=".($j/100).", concepto='".$_POST['concepto'][$key]."' WHERE IdFroma=".$_POST['IdFroma'][$key];
        if ($results=@mysql_query($actualizaFor)){    
        }
      }else{
        $insertaFor="INSERT INTO formapagocont (IdContrato, porpago, concepto) VALUES(".$_POST['IdContrato'].", ".($j/100).", '".$_POST['concepto'][$key]."')";
        if ($results=@mysql_query($insertaFor)){    
        }
      }
    }

  }

  if($_POST['borraFunciones']){
    $eliminaFun="DELETE FROM funcionescont WHERE IdFuncion  (".$_POST['borraFunciones'].")";
    if ($results=@mysql_query($eliminaFun)){    
    }
  }
  if($_POST['borraResponsabilidades']){
    $eliminaRes="DELETE FROM resposabilidadescont WHERE IdResponsabilidad  (".$_POST['borraResponsabilidades'].")";
    if ($results=@mysql_query($eliminaRes)){    
    }
    
  }
  if($_POST['borraActividades']){
    $eliminaAct="DELETE FROM actividadescont WHERE IdActividad  (".$_POST['borraActividades'].")";
    if ($results=@mysql_query($eliminaAct)){    
    }
    
  }
  if($_POST['borraProductos']){
    $eliminaPro="DELETE FROM productoscont WHERE IdProducto  (".$_POST['borraProductos'].")";
    if ($results=@mysql_query($eliminaPro)){    
    }
    
  }
  if($_POST['borraPagos']){
    $eliminaPag="DELETE FROM formapagocont WHERE IdFroma IN (".$_POST['borraPagos'].")";
    if ($results=@mysql_query($eliminaPag)){    
    }
  }

  if($grabado==1){
    ?>
    <script language="JavaScript" type="text/javascript">
      swal({
          //title: "Error al subir el archivo",
          text: "¡EL CONTRATO HA SIDO ACTUALIZADO!",
          type: "success",
          showConfirmButton: true,
          confirmButtonText: "¡Cerrar!"
      }).then(function(result){
        if (result.value) {
          // window.location = "inicio.php";
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