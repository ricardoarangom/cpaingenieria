<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php')
?>
<?php 
session_start();

?>
<script language="JavaScript" type="text/javascript"> 
  function promediar(){
    var calpro = document.getElementById('calpro').value;
    
    var cumplimiento = document.getElementById('cumplimiento').value;
    var higsegind = document.getElementById('higsegind').value;
    var gesamb = document.getElementById('gesamb').value;
		
    var suma = 0;
    var cantidad = 0;

    if(calpro && calpro!=0){
      suma = suma+parseFloat(calpro);
      cantidad++;
    }
    
    if(cumplimiento && cumplimiento!=0){
      suma = suma+parseFloat(cumplimiento);
      cantidad++;
    }
    if(higsegind && higsegind!=0){
      suma = suma+parseFloat(higsegind);
      cantidad++;
    }
    if(gesamb && gesamb!=0){
      suma = suma+parseFloat(gesamb);
      cantidad++;
    }
		
    
    console.log(suma)
		document.getElementById('evaluacion').value=(parseFloat((suma)));
  }

  function validarArchivo(archivo,item){
        
    if((archivo[0]["size"] > 2000000) || (archivo[0]["type"]!="application/pdf") ){
          
  		$("#arch"+item).val("");
      
      swal({
		      title: "Error al subir el archivo",
		      text: "¡El archivo no debe pesar más de 2000K y ser en formato PDF!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });
  	}
  }
</script>

<?php 
include('encabezado1.php');	
?>

<br>
<?php
if(isset($_POST['boton'])){
//  echo('<pre>');
//  print_r($_POST);
//  echo('</pre>');
//  
//  echo('<pre>');
//  print_r($_FILES);
//  echo('</pre>');
  
  if($_FILES['factura']){
    $ruta="facturas/factura-".$_POST['IdOrden'].".pdf";
    move_uploaded_file($_FILES['factura']['tmp_name'],$ruta);
  }else{
    $ruta=NULL;
  }
  
	
	$graba="UPDATE compras set recibido='".$_POST['recibido']."',  calpro=".$_POST['calpro'].", cumplimiento=".$_POST['cumplimiento'].",  higsegind=".$_POST['higsegind'].",  gesamb=".$_POST['gesamb'].", evaluacion=".$_POST['evaluacion'].", factura=".($ruta==NULL ? "NULL" : "'$ruta'")." where IdCompra=".$_POST['IdOrden'];
  // echo $graba;
  if($results=@mysql_query($graba)){
    ?>
    <script>
        swal({
            title: "",
            text: "¡LA ORDEN DE COMPRA HA SIDO ACTUALIZADA CORRECTAMENTE!",
            type: "success",
            confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {
              window.location = "inicio.php";
            }
          });    
    </script>
  <?php
  }else{
    // echo 'hola';
  }

}else{
$orden=$_GET['orden']; 

$busca5="select IdCompra, compras.IdOrdencompra, fsolicitud, compras.comprado, nombre, apellido, area, proveedor, critico from (((compras left join ordencompra on compras.IdOrdencompra=ordencompra.IdOrdencompra) left join usuarios on ordencompra.IdSolicitante=usuarios.IdUsuario) left join areas on ordencompra.IdArea=areas.IdArea) left join proveedores on compras.IdProveedor=proveedores.IdProveedor WHERE IdCompra=".$orden."";  
$resultado5 = mysql_query($busca5, $datos) or die(mysql_error());
$fila5 = mysql_fetch_assoc($resultado5);

$busca6="select itemcompra.IdItem, producto, unidad, cantidad, precio, descuento, iva from (itemcompra left join itemoc on itemcompra.IdItem=itemoc.IdItem) left join cotizaciones on itemcompra.IdItem=cotizaciones.IdItem where autorizada=1 and IdCompra=".$orden."";  
$resultado6 = mysql_query($busca6, $datos) or die(mysql_error());
$fila6 = mysql_fetch_assoc($resultado6);
?>  
<div class="contenedor" align="center" style="width: 1000px">
	<h4 align="center" class="Century">RECIBO Y EVALUACION DE ORDENES DE COMPRA</h4>
  <br>
	<div class="grid columna-15" align="left">
		<div class="span-3 Century18">
			ORDEN DE COMPRA
		</div>
		<div class="span-1">
			<strong><?php echo $fila5['IdCompra'] ?></strong>
		</div>
		<div class="span-4 Century18" align="right">
			SOLICITUD DE COMPRA
		</div>
		<div class="span-1">
			<strong><?php echo $fila5['IdOrdencompra'] ?></strong>
		</div>
		<div class="span-3 Century18" align="right">
			PROYECTO/AREA
		</div>
		<div class="span-3" align="left">
			<strong><?php echo $fila5['area'] ?></strong>
		</div>
		<div class="span-2 Century18">
			PROVEEDOR
		</div>
		<div class="span-5">
			<strong><?php echo $fila5['proveedor'] ?></strong>
		</div>
		<div class="span-2 Century18">
			SOLICITANTE
		</div>
		<div class="span-5">
			<strong><?php echo $fila5['nombre']." ".$fila5['apellido'] ?></strong>
		</div>
		<div class="span-2 Century18">
			F SOLICITUD
		</div>
		<div class="span-2">
			<strong><?php echo fechaactual3($fila5['fsolicitud']) ?></strong>
		</div>
		<div class="span-2 Century18">
			F COMPRA
		</div>
		<div class="span-2">
			<strong><?php echo fechaactual3($fila5['comprado']) ?></strong>
		</div>
		<div class="span-2 Century18">
			CRITICO
		</div>
		<div class="span-2">
			<strong>
				<?php 
				if($fila5['critico']==1){
					echo 'SI';
				}else{
					echo 'NO';
				}
				?>
			</strong>
		</div>
	</div>
	<br>
  <table class="tablita Arial14" align="center" border="1">
		<col width="300px">
		<col width="60px">
		<col width="100px">
		<col width="60px">
		<col width="60px">
		<col width="60px">
		<col width="100px">
		<tr class="titulos">
			<td>
				DESCRIPCIÓN
			</td>
			<td>
				UN
			</td>
			<td>
				VR UNI.
			</td>
			<td>
				CANT.
			</td>
			<td>
				DESC.
			</td>
			<td>
				IVA
			</td>
			<td>
				TOTAL
			</td>
		</tr>
		<?php 
		do{
			?>
			<tr>
				<td>
					<?php echo $fila6['producto'] ?>
				</td>
				<td align="center">
					<?php echo $fila6['unidad'] ?>
				</td>
				<td align="right">
					<?php echo number_format($fila6['precio']) ?>
				</td>
				<td align="right">
					<?php echo number_format($fila6['cantidad']) ?>
				</td>
				<td align="right">
					<?php echo $fila6['descuento']*100 ?>%
				</td>
				<td align="right">
					<?php echo $fila6['iva']*100 ?>%
				</td>
				<td align="right">
					<?php 
						$total=(($fila6['cantidad']*$fila6['precio'])*(1-$fila6['descuento']))*(1+($fila6['iva']));
						echo number_format($total)
					?>
				</td>
			</tr>
			<?php
		}while($fila6 = mysql_fetch_assoc($resultado6));
		?>
	</table>
</div>
<br>
<div class="contenedor" style="width: 780px">
	<h5 align="center" class="Century">EVALUAR</h5>
	<form action="recibir1.php" method="post" enctype="multipart/form-data">
		<div class="grid columna-2" style="width: 250px">
			<div class="span-1">
				Fecha de Recibo
			</div>
			<div class="span-1">
				<input type="date" name="recibido" class="campo-xs Arial12" value="<?php echo date("Y-m-d") ?>" max="<?php echo date("Y-m-d") ?>">
			</div>
		</div>		
		<table class="tablita" border="1">
			<col width="174px">
			<col width="174px">
			<col width="174px">
			<col width="174px">
			<col width="80px">
			<tr class="titulos">
				<td>Calidad del Producto o Servicio</td>
				<td>Cumplimiento</td>
				<td>Aspectos Higiene y Seguridad Industrial</td>
				<td>Aspectos de Gestión ambiental</td>
				<td>Puntaje</td>
			</tr>

			<tr><td>
					<select name="calpro" id="calpro" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="22.5">Bueno</option>
						<option value="13.5">Regular</option>
						<option value="2.25">Malo</option>
					</select>
				</td>
				<td>
					<select name="cumplimiento" id="cumplimiento" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="22.5">Bueno</option>
						<option value="13.5">Regular</option>
						<option value="2.25">Malo</option>
					</select>
				</td>
				<td>
					<select name="higsegind" id="higsegind" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="30">Sin Incidentes</option>
						<option value="3">Con Incidentes</option>
					</select>
				</td>
				<td>
					<select name="gesamb" id="gesamb" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="25">Sin Incidentes</option>
						<option value="2.5">Con Incidentes</option>
					</select>
				</td>
				<td>
					<input name="evaluacion" id="evaluacion" type="text" class="campo-xs" readonly>
				</td>
			</tr>
		</table>
		<br>

    <div class="contenedor" align="center" style="width: 300px">
      <input type="file" name="factura" class="campo-sm Arial12" onChange="validarArchivo(this.files,this.id)">
			<input name="IdOrden" type="hidden" value="<?php echo $orden ?>">
      <br>
      <button type="submit" name="boton" class="btn btn-rosa btn-sm" id="boton" >GRABAR</button>
    </div>
	</form>
</div>
<?php 
}
?>  
  

<?php 
	mysql_close($datos);
include('footer.php')
?>

</body>
</html>

