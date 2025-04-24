<?php require_once('../connections/datos.php'); ?>
<?php

$solicitud=$_GET['sol'];

include('encabezado.php');

$buscaSolicitud="SELECT IdGviaje, nombre, apellido, area, ccostos, gviaje.IdMunicipio, municipios.IdDepartamento, municipio, departamentos, fsalida, fregreso, actividad, beneficiario, gviaje.cedula, banco, gviaje.cuenta, gviaje.IdBanco, clasecuenta FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join bancos on gviaje.IdBanco=bancos.IdBanco  where IdGviaje=".$solicitud;
$resultado = mysql_query($buscaSolicitud, $datos) or die(mysql_error()); 
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);

$buscaItems="SELECT IdItem, rubro, cantidad, vunitario FROM itemgviaje where IdGviaje=".$solicitud;
$resultado1 = mysql_query($buscaItems, $datos) or die(mysql_error());
$row_resultado1 = mysql_fetch_assoc($resultado1);
$totalRows_resultado1 = mysql_num_rows($resultado1);

$buscaGastos="SELECT IdDepertamento, IdMunicipio, alojamiento, alimentacion, hidratacion, taeropuerto FROM tablagastos";
$resultado3 = mysql_query($buscaGastos, $datos) or die(mysql_error());
$row_resultado3 = mysql_fetch_assoc($resultado3);

$buscaBancos="SELECT IdBanco, banco FROM bancos order by banco";
$resultado4 = mysql_query($buscaBancos, $datos) or die(mysql_error());
$row_resultado4 = mysql_fetch_assoc($resultado4);

do{
		
	if($row_resultado3['IdMunicipio']<>0){
		
		$tablaGastos[$row_resultado3['IdMunicipio']]['departamento']=$row_resultado3['IdMunicipio'];		
		$tablaGastos[$row_resultado3['IdMunicipio']]['alojamiento']=$row_resultado3['alojamiento'];
		$tablaGastos[$row_resultado3['IdMunicipio']]['alimentacion']=$row_resultado3['alimentacion'];
		$tablaGastos[$row_resultado3['IdMunicipio']]['hidratacion']=$row_resultado3['hidratacion'];
		$tablaGastos[$row_resultado3['IdMunicipio']]['taeropuerto']=$row_resultado3['taeropuerto'];
		
	}else{
		
		$tablaGastos[$row_resultado3['IdDepertamento']]['departamento']=$row_resultado3['IdDepertamento'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['alojamiento']=$row_resultado3['alojamiento'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['alimentacion']=$row_resultado3['alimentacion'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['hidratacion']=$row_resultado3['hidratacion'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['taeropuerto']=$row_resultado3['taeropuerto'];
		
	}
		
}while($row_resultado3 = mysql_fetch_assoc($resultado3));

$cadenaTablaGastos=json_encode($tablaGastos,JSON_UNESCAPED_UNICODE);

?>
<script>

  window.addEventListener("keypress", function(event){
		 if (event.keyCode == 13){
		 		event.preventDefault();
		 }
    
   
	}, false);
  
  document.addEventListener('DOMContentLoaded', function() {
    
    var banco = <?php echo $row_resultado['IdBanco'] ?>;
    var clasecuenta = <?php echo $row_resultado['clasecuenta'] ?>;
    
    console.log(banco)
    
    $('#IdBanco').val(banco);
    $('#clasecuenta').val(clasecuenta);
		
  });
  
  function validaArchivo(archivo,id){
		if((archivo[0]["size"] > 600000) || (archivo[0]["type"]!="application/pdf") ){
			document.getElementById(id).value='';
			document.getElementById(id).focus();
			swal({
					title: "Error al subir el archivo",
					text: "¡El archivo no debe pesar más de 500K y ser en formato PDF!",
					type: "error",
					confirmButtonText: "¡Cerrar!"
			});
			return;
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
				Nombre:
				<input type="text" class="campo-sm Arial12" name="beneficiario" value="<?php echo $row_resultado['beneficiario']?>" required>
			</div>
			<div class="span-2">
				Cedula:
				<input type="text" class="campo-sm Arial12" name="cedula" value="<?php echo $row_resultado['cedula'] ?>" required>
			</div>
			<div class="span-2">
				Banco
				<select name="IdBanco" id="IdBanco" class="campo-sm Arial12" required>
					<option value="">Seleccione</option>
					<?php 
					do{
						?>
						<option value="<?php echo $row_resultado4['IdBanco'] ?>"><?php echo $row_resultado4['banco'] ?></option>
						<?php
					} while($row_resultado4 = mysql_fetch_assoc($resultado4));
					?>
				</select>
			</div>
			<div class="span-2">
				Clase cuenta:
				<select name="clasecuenta" id="clasecuenta" class="campo-sm Arial12" required>
					<option value="">Seleccione</option>
					<option value="1">Ahorros</option>
					<option value="2">Corriente</option>
					<option value="3">Deposito electronico</option>
				</select>
			</div>
			<div class="span-2">
				No de Cuenta
				<input type="text" name="cuenta" class="campo-sm Arial12" value="<?php echo $row_resultado['cuenta'] ?>" required>
			</div>
			<div class="span-4"></div>
			<div class="span-4">
				Certificación bancaria
				<input type="file" name="certificacion" id="certificacion" class="campo-sm Arial12" onChange="validaArchivo(this.files,this.id)" required>
			</div>
			<div class="span-4"></div>      
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
			<input type="hidden" name="solicitud" value="<?php echo $solicitud ?>">
			<button type="submit" class="btn btn-rosa btn-sm" name="boton6">Grabar</button>
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