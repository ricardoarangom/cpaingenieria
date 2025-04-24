<?php require_once('../connections/datos.php'); ?>
<?php

$solicitud=$_GET['solicitud'];

include('encabezado.php');

$buscaSolicitud="SELECT IdGviaje, nombre, apellido, area, ccostos, municipio, departamentos, fsalida, fregreso, actividad, beneficiario, gviaje.cedula, banco, gviaje.cuenta, clasecuenta FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join bancos on gviaje.IdBanco=bancos.IdBanco  where IdGviaje=".$solicitud;
$resultado = mysql_query($buscaSolicitud, $datos) or die(mysql_error());
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);

$buscaItems="SELECT IdItem, rubro, cantidad, vunitario FROM itemgviaje where IdGviaje=".$solicitud;
$resultado1 = mysql_query($buscaItems, $datos) or die(mysql_error());
$row_resultado1 = mysql_fetch_assoc($resultado1);
$totalRows_resultado1 = mysql_num_rows($resultado1);

?>
<script>
	
	window.addEventListener("keypress", function(event){
		// if (event.keyCode == 13){
		// 		event.preventDefault();
		// }
		
	}, false);
	
	function validarArchivo(archivo,item){
        
    if((archivo[0]["size"] > 510000) || (archivo[0]["type"]!="application/pdf") ){
          
      $("#"+item).val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 500K y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
    }
  } 
	
	
	
		
</script>
<style>

	.cantidad {
		text-align: right;
	}
	
	.vunitario {
		text-align: right;
	}
	
	.vtotal {
		text-align: right;
	}
</style>
<?php
include('encabezado1.php');

?>
<div class="contenedor" style="width: 1000px">
  <table width="100%" border="1">
    <tbody>
      <tr>
        <td width="37.5%" align="center"><img src="../imagenes/logofa.png" width="200" alt=""/></td>
        <td width="62.5%" align="center"><h4>IDENTIFICACIÓN DE RECURSOS Y COSTOS</h4></td>
      </tr>
    </tbody>
  </table>
	<br>
	<form action="graba.php" method="post" id="formulario" enctype="multipart/form-data" >
		<div class="grid columna-12 Arial14">
			<div class="span-4" align="left">
				SOLICITANTE <br>
				<strong><?php echo $row_resultado['nombre']." ".$row_resultado['apellido'] ?></strong>
			</div>
			<div class="span-4" align="left">
				PROYECTO <br>
				<strong><?php echo $row_resultado['ccostos']." - ".$row_resultado['area'] ?></strong>
			</div>
			<div class="span-4" align="left">
				LUGAR DEL VIAJE <br>
				<strong><?php echo $row_resultado['municipio'] ?> / <?php echo $row_resultado['departamentos'] ?></strong>
			</div>
			<div class="span-2">
				SALIDA <br>
				<strong><?php echo fechaactual3($row_resultado['fsalida']) ?></strong>
			</div>			
			<div class="span-2" align="left">
				REGRESO <br>
				<strong><?php echo fechaactual3($row_resultado['fregreso']) ?></strong>
			</div>
			<div class="span-8">
				ACTIVIDAD A DESARROLLAR EN EL VIAJE<br>
				<strong><?php echo $row_resultado['actividad'] ?></strong>	
			</div>
			<div class="span-4">
				QUIEN VIAJA<br>
				<strong><?php echo $row_resultado['beneficiario'] ?></strong>
			</div>
      <div class="span-12 Century20" align="center">
				A QUIEN SE LE CONSIGNA
			</div>
      <div class="span-4">
				Nombre<br>
				<strong><?php echo $row_resultado['beneficiario'] ?></strong>
			</div>
			<div class="span-2">
				Cedula<br>
        <strong><?php echo colocapuntos($row_resultado['cedula']) ?></strong>
			</div>
			<div class="span-2">
				Banco<br>
        <strong><?php echo $row_resultado['banco'] ?></strong>
			</div>
			<div class="span-2">
				Clase cuenta:<br>
        <?php
        if($row_resultado['clasecuenta']==1){
          echo "<strong>AHORROS</strong>";
        }else if($row_resultado['clasecuenta']==2){
          echo "<strong>CORRIENTE</strong>";
        }else if($row_resultado['clasecuenta']==3){
          echo "<strong>DEPOSITO ELECTRONICO</strong>";
        }
        ?>
			</div>
			<div class="span-2">
				No de Cuenta<br>
        <strong><?php echo $row_resultado['cuenta'] ?></strong>
			</div>
		</div>
		<br>
		<br>
		<h4 class="Century22" align="center">DESCRIPCION ESTIMADA DEL ANTICIPO</h4>
		<br>	
		<table class="tablita Arial12" border="1" id="productos" align="center">
			<col width="375px">
			<col width="150px">
			<col width="150px">
			<col width="150px">
			<tr class="titulos">
				<td>DESCRIPCIÓN</td>
				<td>CANTIDAD</td>
				<td>VALOR UNITARIO</td>
				<td>VALOR TOTAL</td>
			</tr>
			<?php
			$item=1;
      $total=0;
			do{
				?>
				<tr>
					<td>
						<?php 
						if($row_resultado1['rubro']=='taeropuerto'){
							echo 'TRANSPORTES AEROPUERTO';
						}else{
							echo strtoupper($row_resultado1['rubro']);
						}
						?>
					</td>
					<td align="right">
            <?php echo $row_resultado1['cantidad']?>
					</td>
					<td align="right">
            <?php echo number_format($row_resultado1['vunitario'],0)?>
					</td>
					<td align="right">
            <?php echo number_format(($row_resultado1['vunitario']*$row_resultado1['cantidad']),0)?>
					</td>
				</tr>
				<?php
				$item++;
        $total=$total+($row_resultado1['vunitario']*$row_resultado1['cantidad']);
			} while($row_resultado1 = mysql_fetch_assoc($resultado1));
			?>
			<tr class="Arial14">
				<td colspan="3" align="center" style="font-weight: bold">TOTAL</td>
				<td id="total" align="right">
          <strong><?php echo number_format(($total),0)?></strong>
        </td>		
			</tr>
		</table>
		<br>
    <div align="center">
      <div class="grid columna-3" style="width:390px">
        <div class="span-1">
          Soporte de Pago
        </div>
        <div class="span-2">
          <input type="file" name="soporte" id="soporte" class="campo-sm Arial10" onChange="validarArchivo(this.files,this.id)" required>
        </div>        
      </div>
    </div>
    <br>    
		<div align="center">
			<input type="hidden" name="solicitud" value="<?php echo $solicitud ?>">
			<button type="submit" class="btn btn-rosa btn-sm" name="boton5">Grabar</button>
		</div>
	</form>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
include('footer.php');
?>

</body>
</html>