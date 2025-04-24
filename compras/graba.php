<?php require_once('../connections/datos.php'); ?>
<?php 

set_time_limit(0);
require("../smtptester/class.phpmailer.php");

session_start();
$usuario=$_SESSION['IdUsuario'];

$busca5="SELECT nombre, apellido, correo FROM usuarios WHERE IdUsuario=".$usuario."";
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila5 = mysql_fetch_assoc($resultado5);
?>

<?php 
include('encabezado.php');	
?>

<?php 
include('encabezado1.php');	
?>

<?php
if(isset($_POST['boton1'])){

//   echo "<pre>";
//   print_r($_POST);
//   echo "</pre>";

  if(empty($_POST['producto'])){
    ?>
    <script language="JavaScript" type="text/javascript">
      swal({
            //title: "Error al subir el archivo",
            text: "¡NO SE SOLICITARON PRODUCTOS, POR LO TANTO NO SE GENERO SOICITUD DE COMPRA!",
            type: "error",
            showConfirmButton: true,
            confirmButtonText: "¡Cerrar!"
        }).then(function(result){
          if (result.value) {
            window.location = "creaoc.php";
          }
        });
    </script>
    <?php
  }else{
		if(isset($_POST['critico'])){
			$critico=1;
		}else{
			$critico=0;
		}
    $graba1="INSERT INTO ordencompra (IdSolicitante, IdArea, fsolicitud, direnvio, critico) VALUES (".$_POST['solicita'].", ".$_POST['area'].", '".date("Y-m-d")."', '".$_POST['direnvio']."', ".$critico.")";
//     echo $graba1;

    if ($results=@mysql_query($graba1)){
      $last_id = mysql_insert_id($datos);
      
      $mensaje="<div class='container Arial12' align='left'>";
      $mensaje.="<div>SE CREO LA SOLICITUD DE COMPRA No. ".$last_id." </div>";
      $mensaje.="</div><br>";

      foreach($_POST['id'] as $j){
        if(($_POST['producto'][$j]<>"") AND ($_POST['cantidad'][$j]<>"")){
          $graba2="INSERT INTO itemoc (IdOrdencompra, PS, producto, unidad, cantidad, frequerido, especificacion, IdCalse) VALUES (".$last_id.", ".$_POST['ps'][$j].", '".$_POST['producto'][$j]."' , '".$_POST['unidad'][$j]."', ".$_POST['cantidad'][$j].", '".$_POST['requi'][$j]."', '".$_POST['observa'][$j]."', ".$_POST['clase'][$j].")";
//           echo $graba2;

          if ($results=@mysql_query($graba2)){
                        
            $mensaje.= "<div class='container Arial12' align='left'>";
            $mensaje.= "<div>SE GRABO LA SOLICITUD DE ".$_POST['producto'][$j]." </div>";
            $mensaje.= "</div>";
            
          }else{
            echo "<div class='container Arial14'>";
            echo "<div><strong>NO SE GRABO LA SOLICITUD DE ".$_POST['producto'][$j]."</strong> </div>";
            echo "</div>";
          }

        }else{       
        }
      }

    }else{ 
      echo ('NO GRABO SOLICITUD DE COMPRA');
    }
    ?>
    <script>
              document.location.replace ("corroc.php?orden=<?php echo $last_id?>&mensaje=<?php echo $mensaje?>");
    </script>
    <?php
  }
}

if(isset($_POST['boton2'])){
		  
  //  echo('<pre>');
  //  print_r($_POST);
  //  echo('</pre>');
  
  //  echo('<pre>');
  //  print_r($_FILES);
  //  echo('</pre>');
  
  if($_FILES['archivo']['tmp_name']){

    $tipo=$_FILES['archivo']['type'];
    $tamano=$_FILES['archivo']['size'];
    $mensaje="";
		$mensaje1="";
    $fecha1=date("YmdHis");
    $ruta="cotizaciones/".$fecha1."-".$_POST['item']."-cotizacion.pdf";

    if ($tamano<=2000000){
      if($tipo=="application/pdf" OR $tipo==""){			
        move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta);
                            
        $graba="INSERT INTO cotizaciones (IdItem, IdProveedor, precio, iva, fecha, cotizacion, observaciones, IdOrdencompra, IdFpago, descuento, IdMpago) VALUES (".$_POST['item'].", ".$_POST['proveedor'].", ".$_POST['precio'].", ".($_POST['iva']/100).", '".date("Y-m-d")."', '".$ruta."', '".$_POST['observa']."', ".$_POST['orden'].", ".$_POST['fpago'].", ".($_POST['desc']/100).", ".$_POST['mpago']." )";
         
      }else{
        ?>
        <script>
            swal({
                title: "Error al subir el archivo",
                text: "¡El archivo no tiene en formato permitido!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
              });
        </script>
        <?php
      }
    }else{
      ?>
			<script>
					swal({
							title: "Error al subir el archivo",
							text: "¡El archivo no tiene en tamaño permitido!",
							type: "error",
							confirmButtonText: "¡Cerrar!"
						});
			</script>
			<?php
    } 
  }else{

    $graba="INSERT INTO cotizaciones (IdItem, IdProveedor, precio, iva, fecha, cotizacion, observaciones, IdOrdencompra, IdFpago, descuento, IdMpago) VALUES (".$_POST['item'].", ".$_POST['proveedor'].", ".$_POST['precio'].", ".($_POST['iva']/100).", '".date("Y-m-d")."', NULL, '".$_POST['observa']."', ".$_POST['orden'].", ".$_POST['fpago'].", ".($_POST['desc']/100).", ".$_POST['mpago']." )";

  }

  if ($results=@mysql_query($graba)){
    $mensaje1="¡LA COTIZACION SE GRABO CORRECTAMENTE!";
    ?>
     <script>
         swal({
             html: '<div style="font-size:18px">¡LA COTIZACION SE GRABO CORRECTAMENTE!</div>',
             // title: "Error al subir el archivo",
             // text: "¡LA COTIZACION SE GRABO CORRECTAMENTE!",
             type: "success",
             confirmButtonText: "¡Cerrar!"
           });
     </script>
     <?php	
   
 }else{
   echo "NO GRABO";
 }

  echo "<br><br><br><br>";
  $busca1="SELECT IdItem FROM cotizaciones WHERE IdItem=".$_POST['item']."";
  $resultado1 = mysql_query($busca1, $datos) or die(mysql_error());
  $fila1 = mysql_fetch_assoc($resultado1);
  $totalfilas1 = mysql_num_rows($resultado1);
  
  if($totalfilas1==3){
    $graba1="UPDATE itemoc SET cotizado='".date("Y-m-d")."' WHERE IdItem=".$_POST['item']."";
    if ($results=@mysql_query($graba1)){
      echo "<div class='Arial14'>";
      echo "<div class='container'>ESTE ITEM COMPLETO LAS 3 COTIZACIONES POR LO TANTO QUEDA CERRADO</div>";
      echo "</div>";
    }
    $busca="SELECT IdOrdencompra, IdItem FROM itemoc WHERE isnull(cotizado) AND IdOrdencompra=".$_POST['orden']."";
    $resultado = mysql_query($busca, $datos) or die(mysql_error());
    $fila = mysql_fetch_assoc($resultado);
    $totalfilas = mysql_num_rows($resultado);
    if($totalfilas==0){
      $graba2="UPDATE ordencompra SET fcierre='".date("Y-m-d")."' WHERE IdOrdencompra=".$_POST['orden']."";
      if ($results=@mysql_query($graba2)){
        echo "<div class='Arial14'>";
        echo "<div class='container'>TODOS LOS ITEMS DE LA SOLICTUD DE COMPRA No. ".$_POST['orden']." YA ESTAN COTIZADOS</div>";
        echo "</div>";
        ?>
        <script>
            document.location.replace ("corrcot.php?orden=<?php echo $_POST['orden'] ?>");
        </script>
        <?php 
      }
    }
  }
?>
  <div class='container' >
    <div class="row">
      <div class="col-2">
        <form action="cotizar1.php" method="post">
          <input type="hidden" name="orden" value="<?php echo $_POST['orden']?>" />
          <input type="hidden" name="item" value="<?php echo $_POST['item']?>" />
          <button type="submit" class='btn btn-rosa btn-sm' >VOLVER AL PRODUCTO</button>
        </form>
      </div>
      <div class="col-2">
        <form action="cotizar2.php" method="get">
          <input type="hidden" name="orden" value="<?php echo $_POST['orden']?>">
          <button type="submit" class='btn btn-rosa btn-sm' >VOLVER A LA SOLICITUD</button>
        </form>
      </div>  
    </div>
  </div>
<?php 
}

if(isset($_POST['boton3'])){
  
	$string = str_replace(PHP_EOL," ", $_POST['producto']);  
	$busca1="SELECT IdItem FROM cotizaciones WHERE IdItem=".$_POST['item']."";
	$resultado1 = mysql_query($busca1, $datos) or die(mysql_error());
	$fila1 = mysql_fetch_assoc($resultado1);
	$totalfilas1 = mysql_num_rows($resultado1);
  
if($totalfilas1==0){
  echo "<div class='Arial14'>";
  echo "<div class='container'>ESTE PRODUCTO NO TIENE COTIZACIONES</div>";
  echo "</div>"; 
  
}else{
 $mensaje="";  
 $graba="UPDATE itemoc SET cotizado='".date("Y-m-d")."' WHERE IdItem=".$_POST['item'].""; 
 if ($results=@mysql_query($graba)){
    echo "<div class='Arial14'>";
    echo "<div class='container'>LA INFORMACION SE GRABO CORRECTAMENTE</div>";
    echo "</div>";
    $mensaje.= "<div class='container'><strong>¡LA INFORMACION SE GRABO CORRECTAMENTE!</strong></div>";
    $mensaje.= "<br>";
    $mensaje.="EL PRODUCTO ".$string." YA COMPLETO LAS COTIZACIONES";
    ?>
    <?php
  }else{
    echo "NO GRABO";
  } 
 
  $busca="SELECT IdOrdencompra, IdItem FROM itemoc WHERE isnull(cotizado) AND IdOrdencompra=".$_POST['orden']."";
  $resultado = mysql_query($busca, $datos) or die(mysql_error());
  $fila = mysql_fetch_assoc($resultado);
  $totalfilas = mysql_num_rows($resultado);
  
  if($totalfilas==0){
    $graba1="UPDATE ordencompra SET fcierre='".date("Y-m-d")."' WHERE IdOrdencompra=".$_POST['orden']."";
    if ($results=@mysql_query($graba1)){
        echo "<div class='Arial14'>";
        echo "<div class='container'>TODOS LOS ITEMS DE LA SOLICTUD DE COMPRA No. ".$_POST['orden']." YA ESTAN COTIZADOS</div>";
        echo "</div>";
        $mensaje.= "<br><div class='container'>TODOS LOS ITEMS DE LA SOLICTUD DE COMPRA No. ".$_POST['orden']." YA ESTAN COTIZADOS</div>";
        ?>
        <script>
            document.location.replace ("corrcot.php?orden=<?php echo $_POST['orden'] ?>&mensaje=<?php echo $mensaje?>");
        </script>
        <?php
      }
  }
  ?>
    <script>
        swal({
            html: "<?php echo $mensaje ?>",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
              window.location = "cotizar2.php?orden=<?php echo $_POST['orden'] ?>";
            }
          });
    </script>
    <?php
  
}  
}

if(isset($_POST['boton4'])){
	
//	 echo "<pre>";
//	 print_r($_POST);
//	 echo "</pre>";
	
	
  foreach($_POST['item'] AS $i){
    // echo $_POST['autoriza'][$i]."<br>";
    
    if($_POST['autoriza'][$i]>=0){
      if($_POST['autoriza'][$i]==0){
        $graba6="UPDATE itemoc SET observaciones='".$_POST['observa'][$i]."', derogada=1, autorizado='".date("Y-m-d")."', comprado='".date("Y-m-d")."', entregado='".date("Y-m-d")."' WHERE IdItem=".$i."";
        //echo $graba6."<br>";
        if ($results=@mysql_query($graba6)){
            echo "<div class='Arial14'>";
            echo "<div class='container'>Las cotizaciones no ha sido autorizadas</div>";
            echo "</div>";
        }

      }else{
        $busca="SELECT IdProveedor, IdItem FROM cotizaciones WHERE IdCotizacion=".$_POST['autoriza'][$i]."";
        $resultado = mysql_query($busca, $datos) or die(mysql_error());
        $fila = mysql_fetch_assoc($resultado);
        $totalfilas = mysql_num_rows($resultado);
        $compra[$fila['IdProveedor']]['proveedor']=$fila['IdProveedor'];
        
        
        $item[$i]['item']=$i;
        $item[$i]['proveedor']=$fila['IdProveedor'];;
        $item[$i]['cotizacion']=$_POST['autoriza'][$i];

        $graba="UPDATE cotizaciones SET autorizada=1 WHERE IdCotizacion=".$_POST['autoriza'][$i]."";
        //echo $graba."<br>";
        if ($results=@mysql_query($graba)){
            echo "<div class='Arial14'>";
            echo "<div class='container'>Las cotizaciones han sido autorizadas</div>";
            echo "</div>";
        }
        
        $graba1="UPDATE itemoc SET autorizado='".date("Y-m-d")."'  WHERE IdItem=".$i."";
        //echo $graba1."<br>";
        if ($results=@mysql_query($graba1)){
            echo "<div class='Arial14'>";
            echo "</div>";
        }
        
      }
    }else{
      $graba1="UPDATE itemoc SET observaciones='".$_POST['observa'][$i]."' WHERE IdItem=".$i."";
        //echo $graba1."<br>";
        if ($results=@mysql_query($graba1)){
            echo "<div class='Arial14'>";
            echo "</div>";
        }  
      
      
    }
  }
  
  $busca6="SELECT IdItem FROM itemoc WHERE autorizado is null and IdOrdencompra=".$_POST['orden']."";
   //echo $busca6."<br>";
  $resultado6 = mysql_query($busca6, $datos) or die(mysql_error());
  $fila6 = mysql_fetch_assoc($resultado6);
  $totalfilas6 = mysql_num_rows($resultado6);
  
  $busca7="SELECT IdItem FROM itemoc WHERE derogada=0 and IdOrdencompra=".$_POST['orden']."";
   //echo $busca7."<br>";
  $resultado7 = mysql_query($busca7, $datos) or die(mysql_error());
  $fila7 = mysql_fetch_assoc($resultado7);
  $totalfilas7 = mysql_num_rows($resultado7);
  
   //echo $totalfilas6." ".$totalfilas7."<br>";
  
  if($totalfilas6==0 and $totalfilas7==0){
    $graba8="UPDATE ordencompra SET fautorizado='".date("Y-m-d")."', autorizada=".$usuario.", comprado='".date("Y-m-d")."', recibido='".date("Y-m-d")."', derogada=1 WHERE IdOrdencompra=".$_POST['orden']."";
    //echo $graba8."<br>";
    if ($results=@mysql_query($graba8)){
          echo "<div class='Arial14'>";
          echo "<div class='container'>LA SOLICITUD DE COMPRA HA SIDO ACTUALIZADA</div>";
          echo "</div>";
    }
    
  }else{
    if($totalfilas7>0 and $totalfilas6==0){
      $graba9="UPDATE ordencompra SET fautorizado='".date("Y-m-d")."', autorizada=".$usuario."  WHERE IdOrdencompra=".$_POST['orden']."";
//      echo $graba9."<br>";
      if ($results=@mysql_query($graba9)){
          echo "<div class='Arial14'>";
          echo "<div class='container'>LA SOLICITUD DE COMPRA HA SIDO ACTUALIZADA</div>";
          echo "</div>";
      }
      
      
    }
    
  }
  
  //  echo('<pre>');
  //  print_r($compra);
  //  echo('</pre>'); 
 
  //  echo('<pre>');
  //  print_r($item);
  //  echo('</pre>');
  
    
    
    if(!empty($compra)){ 
      foreach($compra AS $k){
				$graba2="INSERT INTO compras (IdProveedor, IdOrdencompra, fecha) VALUES (".$k['proveedor'].", ".$_POST['orden'].", '".date("Y-m-d")."')";
          //echo $graba2."<br>";
				if ($results=@mysql_query($graba2)){
					echo "<div class='Arial14'>";
					echo "<div class='container'>Las Ordenes de Compra han sido creadas</div>";
					echo "</div>";

					$busca9="SELECT max(IdCompra) AS compr FROM compras";
					$resultado9 = mysql_query($busca9, $datos) or die(mysql_error());
					$fila9 = mysql_fetch_assoc($resultado9);
					$compra[$k['proveedor']]['compra']=$fila9['compr'];
					$cadenaCompra.=$fila9['compr'].",";

				}			
				
        
      } 
			$cadenaCompra=substr($cadenaCompra,0,-1);
      
			// echo $cadenaCompra;
      // echo('<pre>');
      // print_r($compra);
      // echo('</pre>'); 
      foreach($item as $j){
        foreach($compra as $k){
          if($j['proveedor']==$k['proveedor']){
						$graba5="INSERT INTO itemcompra (IdCompra, IdCotizacion, IdItem) VALUES (".$k['compra'].", ".$j['cotizacion'].", ".$j['item']." )";
						//echo $graba5;
						if ($results=@mysql_query($graba5)){
							echo "<div class='Arial14'>";
							echo "<div class='container'>Los Items fueron grabados</div>";
							echo "</div>";
						}
          }

        }

      }
      
    }
  ?>
	<script>
		document.location.replace ("corrautor.php?orden=<?php echo $_POST['orden']?>");
	</script>		
	<?PHP
}

if(isset($_POST['boton11'])){
  //  echo('<pre>');
  //  print_r($_POST);
  //  echo('</pre>');
    
  //  echo('<pre>');
  //  print_r($_FILES);
  //  echo('</pre>');
  if($_POST['claespe']==""){
    $claespe="";
  }else{
    $claespe=$_POST['claespe'];
  }
  if(isset($_POST['correo2'])){
    $correo2=$_POST['correo2'];
  }else{
    $correo2="";
  }
  if(isset($_POST['correo3'])){
    $correo3=$_POST['correo3'];
  }else{
    $correo3="";
  }
  
  if(isset($_POST['direccion'])){
    $direccion=$_POST['direccion'];
  }else{
    $direccion="";
  }
  if(isset($_POST['cuenta'])){
    $cuenta=$_POST['cuenta'];
  }else{
    $cuenta=NULL;
  }
  if(isset($_POST['banco'])){
    $banco=$_POST['banco'];
  }else{
    $banco=NULL;
  }
  if(isset($_POST['clasecuenta'])){
    $clasecuenta=$_POST['clasecuenta'];
  }else{
    $clasecuenta=NULL;
  }
 
  $graba="INSERT INTO proveedores (proveedor, documento, email, departamento, ciudad, finscrip, email2, email3, direccion, telefono, IdBanco, clasecuenta, cuenta) VALUES ('".$_POST['proveedor']."', '".$_POST['nit']."', '".$_POST['correo']."', ".$_POST['depto'].", ".$_POST['municipio'].", '".date("Y-m-d")."', '".$correo2."', '".$correo3."', '".$direccion."', '".$_POST['telefono']."', '$banco', '$clasecuenta', '$cuenta')";
  //  echo $graba;	
  // 	echo $usuario;
  if ($results=@mysql_query($graba)){ 
    $last_id = mysql_insert_id($datos);
    $ndocs=0;
    $mensaje="<div class='Arial14'><div class='container'>EL PROVEEDOR FUE GRABADO CORRECTAMENTE</div></div>";
    foreach($_FILES as $key=>$j){
      if($_FILES[$key]['name']){
        $tipo=$_FILES[$key]['type'];
        $tamano=$_FILES[$key]['size'];
        $fecha1=date("YmdHis");
        $arrayTipo=explode("/",$tipo);
        $ruta="documentos/".$fecha1."-".$key."-".$last_id.".".$arrayTipo[1];

        move_uploaded_file($_FILES[$key]['tmp_name'],$ruta);

        $graba3="UPDATE proveedores SET ".$key."='".$ruta."' WHERE IdProveedor=".$last_id." ";

        if ($results=@mysql_query($graba3)){
          
          $ndocs++;
        }else{
          echo "NO GRABO";
        }
      }
    }
  
    if($ndocs>0){
      $mensaje.="<div class='Arial14'><div class='container'>¡".$ndocs." archivos grabados con exito!</div></div>";
    }

    $destinatario[4]="contabilidad@cpaingenieria.com";
    $destinatario[5]=$fila5['correo'];
    $destinatario[6]="ricardoarangom@gmail.com";

    $mail = new PHPMailer();  

    $mail->PluginDir = "../smtptester/";
    $mail->Timeout=120;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    
    $mail->isHTML(true);
    include('../includes/infcorreo.php');
    $mail->FromName =$fila5['nombre']." ".$fila5['apellido'];
    for($i=0;$i<=6;$i++){
      if($destinatario[$i]<>""){
        $mail->AddAddress($destinatario[$i]);
      }
    }

    $mail->Subject = utf8_decode("INSCRIPCION DE NUEVO PROVEEDOR EN LA BASE DE DATOS");
	
		$body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:700px; background:white; padding:20px">
						
						
							<h3 style="font-weight:100; color:#999" align="center">REGISTRO DE PROVEEDOR</h3>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px;font-size:14px">Cordial saludo:
              <br>
							<br>
							Se acaba de registrar a '.$_POST['proveedor'].' como proveedor en la base de datos.
							<br>							
              <p style="padding:0 20px" class="Arial16">Cordialmente,
							<br>
							CPA INGENIERIA S.A.S
							</p>
              <img style="padding:20px;height:80px" src="../imagenes/logofa.png">
              <hr style="border:1px solid #ccc; width:100%">
						</div>

					</div>';
	
	
    $mail->Body =$body;
    $mail->WordWrap = 200;
    $mail->IsHTML(true);

		// echo $body;
    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
      echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
    }else{
      ?>
      <script>
          swal({
              html: "<?php echo $mensaje ?>",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {
              window.close()
            }
		      });
      </script>
      <?php
    }  
  }else{
    echo "no grabo";
  }
  
  
}



if(isset($_POST['boton14'])){
//  echo('<pre>');
//  print_r($_POST);
//  echo('</pre>');
  
  echo "<div class='container'>";
  if(isset($_POST['idn'])){
    foreach($_POST['idn'] as $k){
      //echo $_POST['producton'][$k]."<br>";
      $graba1="INSERT INTO itemoc (IdOrdencompra, PS, producto, unidad, cantidad, frequerido, especificacion) VALUES (".$_POST['solicitud'].", ".$_POST['psn'][$k].", '".$_POST['producton'][$k]."' , '".$_POST['unidadn'][$k]."', ".$_POST['cantidadn'][$k].", '".$_POST['requin'][$k]."', '".$_POST['observan'][$k]."')";
      //echo $graba1;
      if ($results=@mysql_query($graba1)){
        echo "EL PRODUCTO ".$_POST['producton'][$k]." FUE AGREGADO A LA SOLICITUD DE COMPRA<BR>";
      }
      
    }
  }
  foreach($_POST['id'] as $j){
    if(!isset($_POST['borra'][$j])){
      //echo $j,"<br>";
      $graba="UPDATE itemoc SET  PS=".$_POST['ps'][$j].", producto='".$_POST['producto'][$j]."', especificacion='".$_POST['observa'][$j]."', unidad='".$_POST['unidad'][$j]."', cantidad=".$_POST['cantidad'][$j].", frequerido='".$_POST['requi'][$j]."'  WHERE IdItem=".$_POST['IdItem'][$j]."";
      //echo $graba."<br>";
      if ($results=@mysql_query($graba)){ 
        echo "EL PRODUCTO ".$_POST['producto'][$j]." SE HA ACTUALIZADO CORRECTAMENTE<br>";
      }
    }else{
      //echo $j."<br>";
      $graba2="DELETE FROM itemoc WHERE IdItem=".$_POST['IdItem'][$j];
      //echo $graba2."<br>";
      if ($results=@mysql_query($graba2)){ 
        echo "EL PRODUCTO ".$_POST['producto'][$j]." SE HA ELIMINADO CORRECTAMENTE<br>";
      }
    }
  } 
  ?>
  <button name="button" class="btn btn-rosa btn-sm"  type="button" onclick="window.close();">Cerrar esta ventana</button>
  <br><br>
  <?php
  echo "</div>";
}

if(isset($_POST['boton15'])){

  //  echo('<pre>');
  //  print_r($_POST);
  //  echo('</pre>');
  //  
  //  echo('<pre>');
  //  print_r($_FILES);
  //  echo('</pre>');
  
  if($_FILES['archivo']['name']<>""){

    $tipo=$_FILES['archivo']['type'];
    $tamano=$_FILES['archivo']['size'];
    $fecha1=date("YmdHis");
    $ruta="cotizaciones/".$fecha1."-".$_POST['item']."-cotizacion.pdf";
    if ($tamano<=2000000){
        if($tipo=="application/pdf"){

          move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta);

          $graba="UPDATE cotizaciones SET precio=".$_POST['precio'].", descuento=".($_POST['desc']/100).", iva=".($_POST['iva']/100).", cotizacion='".$ruta."', IdProveedor=".$_POST['proveedor'].", IdFpago=".$_POST['fpago'].", IdMpago=".$_POST['mpago'].", impoconsumo=".($_POST['impoconsumo']/100)." WHERE IdCotizacion=".$_POST['id']."";
			            
          if($_POST['cotizacion']<>""){
            unlink($_POST['cotizacion']);            
          }

        }else{
          ?>
          <script>
              swal({
                  title: "Error al subir el archivo",
                  text: "¡El archivo no tiene en formato permitido!",
                  type: "error",
                  confirmButtonText: "¡Cerrar!"
                });
          </script>
        <?php
        }
    }else{
      ?>
			<script>
					swal({
							title: "Error al subir el archivo",
							text: "¡El archivo no tiene en tamaño permitido!",
							type: "error",
							confirmButtonText: "¡Cerrar!"
						});
			</script>
			<?php
    }   
  }else{
    $graba="UPDATE cotizaciones SET precio=".$_POST['precio'].", descuento=".($_POST['desc']/100).", iva=".($_POST['iva']/100).", IdProveedor=".$_POST['proveedor'].", IdFpago=".$_POST['fpago'].", IdMpago=".$_POST['mpago'].", impoconsumo=".($_POST['impoconsumo']/100)." WHERE IdCotizacion=".$_POST['id']."";
  }
  
  //echo $graba;
  if ($results=@mysql_query($graba)){ 
    echo "<div class='Arial14'>";
    echo "<div class='container'>LA COTIZACION FUE ACTUALIZADA CORRECTAMENTE</div>";
    echo "</div>";
    ?>
    <script>
      swal({
		      title: "LA COTIZACION FUE ACTUALIZADA CORRECTAMENTE",
		      type: "success",
          showConfirmButton: true,
				  confirmButtonText: "Cerrar"
          }).then(function(result){
          if (result.value) {
            window.location = "cotizar2.php?orden=<?php echo $_POST['orden'] ?>";
          }
		    });
    </script>
    <?php
  }
      
}

if(isset($_POST['boton26'])){
	
	
	// echo "<pre>";
	// print_r($_FILES);
	// echo "</pre>";
	
		//  echo "<pre>";
		//  print_r($_POST);
		//  echo "</pre>";
	
	
	if($_FILES['archivo']['tmp_name']){		
    
		$tipo=$_FILES['archivo']['type'];
		$tamano=$_FILES['archivo']['size'];
		$mensaje="";
		$mensaje1="";
    $fecha1=date("YmdHis");
    $ruta="cotizaciones/".$fecha1."-".$_POST['item']."-cotizacion.pdf";
		
		if ($tamano<=2000000){
      if($tipo=="application/pdf"){	   
        
        move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta);
      
        $graba="INSERT INTO cotizaciones (IdItem, IdProveedor, precio, iva, fecha, cotizacion, observaciones, IdOrdencompra, IdFpago, descuento, IdMpago, impoconsumo) VALUES (".$_POST['item'].", ".$_POST['proveedor'].", ".$_POST['precio'].", ".($_POST['iva']/100).", '".date("Y-m-d")."', '".$ruta."', '".$_POST['observa']."', ".$_POST['orden'].", ".$_POST['fpago'].", ".($_POST['desc']/100).", ".$_POST['mpago'].", ".($_POST['impoconsumo']/100)." )";
        // echo $graba;
      }else{
        ?>
        <script>
            swal({
                title: "Error al subir el archivo",
                text: "¡El archivo no tiene en formato permitido!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
              });
        </script>
        <?php
        
      }			
		}else{
			?>
			<script>
					swal({
							title: "Error al subir el archivo",
							text: "¡El archivo no tiene en tamaño permitido!",
							type: "error",
							confirmButtonText: "¡Cerrar!"
						});
			</script>
			<?php
		}
		
	}else{
				
		$graba="INSERT INTO cotizaciones (IdItem, IdProveedor, precio, iva, fecha, cotizacion, observaciones, IdOrdencompra, IdFpago, descuento, IdMpago, impoconsumo) VALUES (".$_POST['item'].", ".$_POST['proveedor'].", ".$_POST['precio'].", ".($_POST['iva']/100).", '".date("Y-m-d")."', NULL, '".$_POST['observa']."', ".$_POST['orden'].", ".$_POST['fpago'].", ".($_POST['desc']/100).", ".$_POST['mpago'].", ".($_POST['impoconsumo']/100)." )";

//    echo $graba;
			
	}
		
	if ($results=@mysql_query($graba)){
     $mensaje1="¡LA COTIZACION SE GRABO CORRECTAMENTE!";
		 ?>
			<script>
					swal({
							html: '<div style="font-size:18px">¡LA COTIZACION SE GRABO CORRECTAMENTE!</div>',
							// title: "Error al subir el archivo",
							// text: "¡LA COTIZACION SE GRABO CORRECTAMENTE!",
							type: "success",
							confirmButtonText: "¡Cerrar!"
						});
			</script>
			<?php	
		
	}else{
		echo "NO GRABO";
	}	
		

  
  $busca1="SELECT IdItem FROM cotizaciones WHERE IdItem=".$_POST['item']."";
  $resultado1 = mysql_query($busca1, $datos) or die(mysql_error());
  $fila1 = mysql_fetch_assoc($resultado1);
  $totalfilas1 = mysql_num_rows($resultado1);
  
  if($totalfilas1==3){
    $graba1="UPDATE itemoc SET cotizado='".date("Y-m-d")."' WHERE IdItem=".$_POST['item']."";
    if ($results=@mysql_query($graba1)){
      $mensaje.="ESTE ITEM COMPLETO LAS 3 COTIZACIONES POR LO TANTO QUEDA CERRADO<br><br>";
    }
    $busca="SELECT IdOrdencompra, IdItem FROM itemoc WHERE isnull(cotizado) AND IdOrdencompra=".$_POST['orden']."";
    $resultado = mysql_query($busca, $datos) or die(mysql_error());
    $fila = mysql_fetch_assoc($resultado);
    $totalfilas = mysql_num_rows($resultado);
    if($totalfilas==0){
      $graba2="UPDATE ordencompra SET fcierre='".date("Y-m-d")."' WHERE IdOrdencompra=".$_POST['orden']."";
      if ($results=@mysql_query($graba2)){
        $mensaje.="TODOS LOS ITEMS DE LA SOLICTUD DE COMPRA No. ".$_POST['orden']." YA ESTAN COTIZADOS<br><br>";
        echo "</div>";
        ?>
        <script>
            document.location.replace ("corrcot.php?orden=<?php echo $_POST['orden']?>&mensaje=<?php echo $mensaje?>");
        </script>
        <?php 
      }
    }
  }
  ?>
  <script>
      swal({
		      title: "<?php echo $mensaje1 ?>",
		      html: "<?php echo $mensaje ?>",
		      type: "success",
          showConfirmButton: true,
				  confirmButtonText: "Cerrar"
          }).then(function(result){
          if (result.value) {
            window.location = "cotizar2.php?orden=<?php echo $_POST['orden'] ?>";
          }
		    });
  </script>
<?php 
}
?>




</body>
</html>
