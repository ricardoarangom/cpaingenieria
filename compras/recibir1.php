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
    var precio = document.getElementById('precio').value;
    var condpago = document.getElementById('condpago').value;
    var cumplimiento = document.getElementById('cumplimiento').value;
    var higsegind = document.getElementById('higsegind').value;
    var gesamb = document.getElementById('gesamb').value;
		var rse = document.getElementById('rse').value;
    var suma = 0;
    var cantidad = 0;

    if(calpro && calpro!=0){
      suma = suma+parseInt(calpro);
      cantidad++;
    }
    if(precio && precio!=0){
      suma = suma+parseInt(precio);
      cantidad++;
    }
    if(condpago && condpago!=0){
      suma = suma+parseInt(condpago);
      cantidad++;
    }
    if(cumplimiento && cumplimiento!=0){
      suma = suma+parseInt(cumplimiento);
      cantidad++;
    }
    if(higsegind && higsegind!=0){
      suma = suma+parseInt(higsegind);
      cantidad++;
    }
    if(gesamb && gesamb!=0){
      suma = suma+parseInt(gesamb);
      cantidad++;
    }
		if(rse && rse!=0){
      suma = suma+parseInt(rse);
      cantidad++;
    } 
    
    console.log(suma)
		document.getElementById('evaluacion').value=(parseInt((suma)));
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
  
	
	$graba="UPDATE compras set recibido='".$_POST['recibido']."',  calpro=".$_POST['calpro'].",  precio=".$_POST['precio'].",  condpago=".$_POST['condpago'].",  cumplimiento=".$_POST['cumplimiento'].",  higsegind=".$_POST['higsegind'].",  gesamb=".$_POST['gesamb'].", rse=".$_POST['rse'].", evaluacion=".$_POST['evaluacion'].", factura=".($ruta==NULL ? "NULL" : "'$ruta'")." where IdCompra=".$_POST['IdOrden'];
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
<div class="contenedor" style="width: 1300px">
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
			<col width="174px">
			<col width="174px">
			<col width="174px">
			<col width="80px">
			<tr class="titulos">
				<td>Calidad del Producto o Servicio</td>
				<td>Precio</td>
				<td>Condiciones de pago</td>
				<td>Cumplimiento</td>
				<td>Aspectos Higiene y Seguridad Industrial</td>
				<td>Aspectos de Gestión ambiental</td>
				<td>Aspectos de RSE</td>
				<td>Puntaje</td>
			</tr>
			<tr><td>
					<select name="calpro" id="calpro" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="20">No presenta rechazo, devoluciones, retrabajos, no conformidades en todas las entregas o trabajos realizados adicionalmente entrega Certificados de Calidad y otros documentos requeridos</option>
						<option value="15">No presenta rechazo, devoluciones, retrabajos, no conformidades en todas las entregas o trabajos realizados, pero no presenta Certificados de Calidad del producto u otro documento clave.</option>
						<option value="10">Presenta quejas menores tales como empaque, embalaje</option>
						<option value="8">Presenta rechazos que ameritan devolución del producto o reproceso en los servicios de manera puntual, 1 única vez o menos del 10% de las veces.</option>
						<option value="3">Presenta rechazos que ameritan devolución del producto en mas del 10% de las oportunidades, se puede considerar también por impacto (valor de las compras)</option>
					</select>
				</td>
				<td>
					<select name="precio" id="precio" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="16">Sus ofertas se encuentran por debajo de los precios promedio establecido en el mercado</option>
						<option value="9">Sus ofertas están acorde a los precios promedio establecidos en el mercado</option>
						<option value="7">Sus ofertas están por encima de los precios promedios establecidos en el mercado</option>
						<option value="3">Sus ofertas están excesivamente por encima de los precios promedios establecidos en el mercado</option>
					</select>
				</td>
				<td>
					<select name="condpago" id="condpago" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="16">Crédito mayor a 30 días</option>
						<option value="9">Crédito 0 a 30 días</option>
						<option value="5">Exige pago contra entrega</option>
						<option value="3">Exige pago anticipado</option>
					</select>
				</td>
				<td>
					<select name="cumplimiento" id="cumplimiento" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="13">Entrega a tiempo del producto y/o servicio</option>
						<option value="9">Retraso leve en la entrega del producto y/o servicio (menor al 20% del tiempo ofertado, o en menos del 10 % de las entregas y sin afectación de las operaciones de la empresa)</option>
						<option value="3">Retraso mayor en la entrega del producto y/o servicio (mayor al 20% del tiempo ofertado, o el 10% o mas de las veces,  y/o con afectación de las operaciones de la empresa)</option>
					</select>
				</td>
				<td>
					<select name="higsegind" id="higsegind" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="16">Sin Incidentes en el período y excede las expectativas en cumplimiento de los requisitos de seguridad exigidos</option>
						<option value="9">Sin Incidentes en el período y cumplimiento básico de los requisitos de seguridad exigidos (USO correcto de EPP, concientización, controles operacionales fundamentales)</option>
						<option value="5">Registra Incidentes menores en el periodo reportado</option>
						<option value="3">Registra Incidentes con perdida de tiempo en el periodo reportado</option>
						<option value="16">NO APLICA</option>
					</select>
				</td>
				<td>
					<select name="gesamb" id="gesamb" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="10">Sin Incidentes en el período y excede las expectativas en cumplimiento de los requisitos de seguridad exigidos</option>
						<option value="7">Sin Incidentes en el período y cumplimiento básico de los requisitos de gestión ambiental exigidos (Disposición de residuos, orden y aseo)</option>
						<option value="5">Registra Incidentes menores en el periodo reportado</option>
						<option value="3">Registra Accidentes en el periodo reportado</option>
						<option value="10">NO APLICA</option>
					</select>
				</td>
				<td>
					<select name="rse" id="rse" class="campo-xs Arial12" onChange="promediar()" required>
						<option value="">Seleccione</option>
						<option value="9">El proveedor demuestra su interés y manifiesta con políticas en relación a derechos humanos, su compromiso con la no vulneración de los mismos.</option>
						<option value="5">Se puede percibir que no se violan derechos fundamentales como igualdad de genero, trabajo infantil, condiciones dignas de trabajo</option>
						<option value="3">Claramente evidente la vulneración de igualdad de genero y /o trabajo infantil y/o condiciones dignas de los trabajadores</option>

					</select>
				</td>
				<td>
					<input name="evaluacion" id="evaluacion" type="text" class="campo-xs" readonly>
				</td>
			</tr>
		</table>
		<br>
    
    <div class="contenedor" align="center" style="width: 300px">
      <input type="file" name="factura" class="campo-sm Arial12" required onChange="validarArchivo(this.files,this.id)">
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

