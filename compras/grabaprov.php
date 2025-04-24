<?php require_once('../connections/datos.php'); ?>
<?php require("../smtptester/class.phpmailer.php");
set_time_limit(0);
?>


<?php
include('encabezado.php');
?>
<?php
include('encabezado1.php');
?>
<?php 
function enviar($proveedor){ 

  $destinatario[0]='contabilidad@cpaingenieria.com';
  $destinatario[1]="ricardoarangom@gmail.com";

  $mail = new PHPMailer();  
 
  $mail->PluginDir = "../smtptester/";
  $mail->Timeout=120;
  $mail->IsSMTP();
  $mail->SMTPAuth = true;

  $mail->isHTML(true);
  include('../includes/infcorreo.php');
  $mail->FromName = "POST MASTER";
  for($i=0;$i<=2;$i++){
    if($destinatario[$i]<>""){
      $mail->AddAddress($destinatario[$i]);
    }
  }    
  $mail->Subject = utf8_decode("CREACION - ACTUALIZACION PROVEEDOR ".$proveedor);
  
  $body='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
							<br>
							<br>

						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
						
						
							<h3 style="font-weight:100; color:#999" align="center">REGISTRO DE PROVEEDORES</h3>

							<hr style="border:1px solid #ccc; width:100%">

              <p style="padding:0 20px" class="Arial16">Buen día:
              <br><br>
              Se acaba de crear y/o actualizar la informacion del proveedor '.$proveedor.' en la base de datos.</p>
							<br>							
              <p style="padding:0 20px" class="Arial16">Cordialmente,
							<br>
							CPA INGENIERIA S.A.S
							</p>
              <img style="padding:20px;height:80px" src="../imagenes/logofa.png">
              <hr style="border:1px solid #ccc; width:100%">
						</div>
					</div>';  

    $mail->msgHTML(utf8_decode($body));
    $mail->WordWrap = 200;
    $mail->IsHTML(true);
    
    // echo $body;
  
  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    echo "<br><BR>* Please double check the user name and password to confirm that both of them are correct. <br>";
  }else{
    echo $mensaje;
    echo "<div class='container Arial14'>";
    echo "<div>LA INFORMACION FUE GRABADA CORRECTAMENTE CORRECTAMENTE</div>";
    echo "</div><br>";
    ?>
    <script>        
      window.location = "inicio.php";            
    </script>
    <?php 
  }  
}    
    
if(isset($_POST['boton1'])){
  // echo('<pre>');
  // print_r($_POST);
  // echo('</pre>');

  // echo('<pre>');
  // print_r($_FILES);
  // echo('</pre>');
  
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

  if(isset($_POST['pro'])){
    $pro=1;
  }else{
    $pro=0;
  }

  if(isset($_POST['cli'])){
    $cli=1;
  }else{
    $cli=0;
  }

  if(isset($_POST['emp'])){
    $emp=1;
  }else{
    $emp=0;
  }

    
  $graba="INSERT INTO proveedores (proveedor, documento, telefono, direccion, departamento, ciudad, contacto, email, email2, email3, finscrip, replegal, regimen, celular, fconstitucion, granc, autoret, declarante,  IdBanco, clasecuenta, cuenta, IdSegmento, departamenton, ciudadn, esprov, esclien, esemple, IdClasedoc) VALUES ('".$_POST['proveedor']."', '".$_POST['nit']."', '".$_POST['telefono']."', '".$_POST['direccion']."', ".$_POST['depto'].", ".$_POST['municipio'].",'".$_POST['contacto']."', '".$_POST['correo']."', '".$correo2."', '".$correo3."', '".date("Y-m-d")."','".$_POST['replegal']."', ".$_POST['regimen'].", '".$_POST['celular']."', '".$_POST['fconstitucion']."', ".$_POST['contribuyente'].", ".$_POST['autoretenedor'].", ".$_POST['declarante'].", ".$_POST['banco'].", ".$_POST['clasecuenta'].", '".$_POST['cuenta']."', ".$_POST['IdSegmento'].", ".$_POST['depton'].", ".$_POST['municipion'].", ".$pro.", ".$cli.", ".$emp.", ".$_POST['IdClasedoc'].")";
  
  // echo $graba;

  if ($results=@mysql_query($graba)){
    echo "<div class='container Arial14'>";
    echo "<div>SE GRABO LA INFORMACION DEL PROVEEDOR ".$_POST['proveedor']." </div>";
    echo "</div><br>";
    
    $busca="select max(IdProveedor) AS uproveedor from proveedores";
    $resultado = mysql_query($busca, $datos) or die(mysql_error());
    $fila = mysql_fetch_assoc($resultado);
    $proveedor=$fila['uproveedor'];
    
    $ndocs=0;
    foreach(array_keys($_FILES)  as $k){
      // echo $k." ".$_FILES[$k]['type']."<br>";

      if($_FILES[$k]['name']){
        $tipo=$_FILES[$k]['type'];
        $tamano=$_FILES[$k]['size'];
        $fecha1=date("YmdHis");
        $arrayTipo=explode("/",$tipo);
        $ruta="documentos/".$fecha1."-".$k."-".$proveedor.".".$arrayTipo[1]; 

        if ($tamano<=6000000){
          if($tipo=="application/pdf"){
            move_uploaded_file($_FILES[$k]['tmp_name'],$ruta);

            $graba3="UPDATE proveedores SET ".$k."='".$ruta."' WHERE IdProveedor=".$proveedor." ";

            // echo $graba3;

            if ($results=@mysql_query($graba3)){
              echo "<div class='Arial14'>";
              echo "<div class='container'>EL DOCUMENTO FUE GRABADO CORRECTAMENTE</div>";
              echo "</div>";
              $ndocs++;
            }else{
              echo "NO GRABO";
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

      }

      if($ndocs>0){
        ?>
        <script>
            swal({
                // title: "Error al subir el archivo",
                text: "¡<?php echo $ndocs ?> archivos grabados con exito!",
                type: "success",
                confirmButtonText: "¡Cerrar!"
              });
        </script>
        <?php
      }
      
    }
    enviar($_POST['proveedor']);
  }
} 

if(isset($_POST['boton2'])){
	
//	  echo('<pre>');
//    print_r($_POST);
//    echo('</pre>');
    
	//  echo('<pre>');
	//  print_r($_FILES);
	//  echo('</pre>');
   
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

   $proveedor=$_POST['IdProveedor'];

   $actualiza="UPDATE proveedores SET proveedor='".$_POST['proveedor']."', documento='".$_POST['nit']."', telefono='".$_POST['telefono']."', direccion='".$_POST['direccion']."', departamento=".$_POST['depto'].", ciudad=".$_POST['municipio'].", contacto='".$_POST['contacto']."', email='".$_POST['correo']."',  replegal='".$_POST['replegal']."', regimen=".$_POST['regimen'].", celular='".$_POST['celular']."', fconstitucion='".$_POST['fconstitucion']."', granc=".$_POST['contribuyente'].", autoret=".$_POST['autoretenedor'].", declarante=".$_POST['declarante'].",  email2='".$_POST['correo2']."', email3='".$_POST['correo3']."', IdBanco=".$_POST['banco'].", clasecuenta=".$_POST['clasecuenta'].", cuenta='".$_POST['cuenta']."', IdSegmento=".$_POST['IdSegmento']." WHERE IdProveedor=".$_POST['IdProveedor']."";

		
//	echo $actualiza;
  if ($results=@mysql_query($actualiza)){
    echo "<div class='container Arial14'>";
    echo "<div>SE ACTUALIZO LA INFORMACION DEL PROVEEDOR ".$_POST['proveedor']." </div>";
    echo "</div><br>";
  }
   
  $ndocs=0;
  foreach(array_keys($_FILES) as $k){
    if($_FILES[$k]['name']){
      
      $tipo=$_FILES[$k]['type'];
      $tamano=$_FILES[$k]['size'];
      $fecha1=date("YmdHis");
      $arrayTipo=explode("/",$tipo);
      $ruta="documentos/".$fecha1."-".$k."-".$proveedor.".".$arrayTipo[1]; 

      move_uploaded_file($_FILES[$k]['tmp_name'],$ruta);

      $graba3="UPDATE proveedores SET ".$k."='".$ruta."' WHERE IdProveedor=".$proveedor." ";
      if ($results=@mysql_query($graba3)){
        $ndocs++;
      }

      $ndoc=$k."A";
      if($_POST[$ndoc]){
        unlink($_POST[$ndoc]);        
      }
    }
  }

  if($ndocs>0){
    echo "<div class='container Arial14'>";
    echo "<div>".$ndocs." DOCUMENTOS GRABADOS</div>";
    echo "</div><br>";
    ?>
    <script>
      swal({
        // title: "Error al subir el archivo",
        text: "¡<?php echo $ndocs ?> archivos grabados con exito!",
        type: "success",
        confirmButtonText: "¡Cerrar!"
      });
    </script>
    <?php
  }
  
	enviar($_POST['proveedor']);
}

  
?>  
<BR></BR>
 <BR></BR>   
</body>
</html>
