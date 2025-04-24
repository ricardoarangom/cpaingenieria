<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php');
	
$buscaGastos="SELECT IdTG, IdRegion, IdDepertamento, tablagastos.IdMunicipio, alojamiento, alimentacion, hidratacion, taeropuerto, departamentos, municipio FROM (tablagastos left join departamentos on tablagastos.IdDepertamento=departamentos.IdDepartamento) left join municipios on tablagastos.IdMunicipio=municipios.IdMunicipio order by IdTG";	
$resultado1 = mysql_query($buscaGastos, $datos) or die(mysql_error());
$row_resultado1 = mysql_fetch_assoc($resultado1);

do{
	
	if($row_resultado1['IdRegion']==1){
		$tablaGastos['CARIBE'][$row_resultado1['IdTG']]['departamento']=$row_resultado1['departamentos'];
		$tablaGastos['CARIBE'][$row_resultado1['IdTG']]['alojamiento']=$row_resultado1['alojamiento'];
		$tablaGastos['CARIBE'][$row_resultado1['IdTG']]['alimentacion']=$row_resultado1['alimentacion'];
		$tablaGastos['CARIBE'][$row_resultado1['IdTG']]['hidratacion']=$row_resultado1['hidratacion'];
		$tablaGastos['CARIBE'][$row_resultado1['IdTG']]['taeropuerto']=$row_resultado1['taeropuerto'];		
		
	}else if($row_resultado1['IdRegion']==2){
				
		$tablaGastos['ANDINA'][$row_resultado1['IdTG']]['departamento']=$row_resultado1['departamentos'];
		$tablaGastos['ANDINA'][$row_resultado1['IdTG']]['alojamiento']=$row_resultado1['alojamiento'];
		$tablaGastos['ANDINA'][$row_resultado1['IdTG']]['alimentacion']=$row_resultado1['alimentacion'];
		$tablaGastos['ANDINA'][$row_resultado1['IdTG']]['hidratacion']=$row_resultado1['hidratacion'];
		$tablaGastos['ANDINA'][$row_resultado1['IdTG']]['taeropuerto']=$row_resultado1['taeropuerto'];
		
	}else if($row_resultado1['IdRegion']==3){
		
		$tablaGastos['PACIFICO'][$row_resultado1['IdTG']]['departamento']=$row_resultado1['departamentos'];
		$tablaGastos['PACIFICO'][$row_resultado1['IdTG']]['alojamiento']=$row_resultado1['alojamiento'];
		$tablaGastos['PACIFICO'][$row_resultado1['IdTG']]['alimentacion']=$row_resultado1['alimentacion'];
		$tablaGastos['PACIFICO'][$row_resultado1['IdTG']]['hidratacion']=$row_resultado1['hidratacion'];
		$tablaGastos['PACIFICO'][$row_resultado1['IdTG']]['taeropuerto']=$row_resultado1['taeropuerto'];
		
	}else if($row_resultado1['IdRegion']==4){

		$tablaGastos['ORINOQUIA'][$row_resultado1['IdTG']]['departamento']=$row_resultado1['departamentos'];
		$tablaGastos['ORINOQUIA'][$row_resultado1['IdTG']]['alojamiento']=$row_resultado1['alojamiento'];
		$tablaGastos['ORINOQUIA'][$row_resultado1['IdTG']]['alimentacion']=$row_resultado1['alimentacion'];
		$tablaGastos['ORINOQUIA'][$row_resultado1['IdTG']]['hidratacion']=$row_resultado1['hidratacion'];
		$tablaGastos['ORINOQUIA'][$row_resultado1['IdTG']]['taeropuerto']=$row_resultado1['taeropuerto'];
		
	}else if($row_resultado1['IdRegion']==5){
		
		$tablaGastos['AMAZONIA'][$row_resultado1['IdTG']]['departamento']=$row_resultado1['departamentos'];
		$tablaGastos['AMAZONIA'][$row_resultado1['IdTG']]['alojamiento']=$row_resultado1['alojamiento'];
		$tablaGastos['AMAZONIA'][$row_resultado1['IdTG']]['alimentacion']=$row_resultado1['alimentacion'];
		$tablaGastos['AMAZONIA'][$row_resultado1['IdTG']]['hidratacion']=$row_resultado1['hidratacion'];
		$tablaGastos['AMAZONIA'][$row_resultado1['IdTG']]['taeropuerto']=$row_resultado1['taeropuerto'];
		
	}else if($row_resultado1['IdRegion']==6){
		
		$tablaGastos['INSULAR'][$row_resultado1['IdTG']]['departamento']=$row_resultado1['municipio'];
		$tablaGastos['INSULAR'][$row_resultado1['IdTG']]['alojamiento']=$row_resultado1['alojamiento'];
		$tablaGastos['INSULAR'][$row_resultado1['IdTG']]['alimentacion']=$row_resultado1['alimentacion'];
		$tablaGastos['INSULAR'][$row_resultado1['IdTG']]['hidratacion']=$row_resultado1['hidratacion'];
		$tablaGastos['INSULAR'][$row_resultado1['IdTG']]['taeropuerto']=$row_resultado1['taeropuerto'];
	}
	
} while ($row_resultado1 = mysql_fetch_assoc($resultado1));

//echo "<pre>";
//print_r($tablaGastos);
//echo "</pre>";

?>
<script>
	
	window.addEventListener("keypress", function(event){
		if (event.keyCode == 13){
				event.preventDefault();
		}
	}, false);
	
	function separador(id) {
		$('#' + id).on({
			"focus": function(event) {
				$(event.target).select();
			},
			"keyup": function(event) {
				$(event.target).val(function(index, value) {
					return value.replace(/\D/g, "")
						.replace(/([0-9])([0-9]{0})$/, '$1')
						.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
				});
			}
		});
	}
</script>
<style>

	.campo-xs {
		text-align: right;
	}
</style>
<?php 
include('encabezado1.php')
?>
<br>
<h4 align="center" class="Century">MODIFICAR TABLA DE GASTOS</h4>
<br>
<div class="contenedor">
	<form action="graba.php" method="post">
		<table class="arial14" align="center" border="1">
			<col width="150px">
			<col width="180px">
			<col width="116px">
			<col width="116px">
			<col width="116px">
			<col width="116px">
			<tr class="titulos">
				<td>REGION</td>
				<td>DEPARTAMENTO</td>
				<td>ALOJAMIENTO</td>
				<td>ALIMENTACION</td>
				<td>HIDRTACION</td>
				<td>TRANSPORTE AEROPUERTO - HOTEL - AEROPUERTO</td>

			</tr>
			<?php
			foreach($tablaGastos as $key=>$j){
				?>
				<tr>
					<td align="center"><?php echo $key ?></td>
					<td  colspan="5">
						<table class="tablita Arial14 table-striped" >
							<col width="180px">
							<col width="116px">
							<col width="116px">
							<col width="116px">
							<col width="116px">
							<?php 
							foreach($j as $llave=>$i){
								?>
								<tr>
									<td><?php echo $i['departamento'] ?></td>
									<td>
										<input type="text" name="arreglo[<?php echo $llave ?>][alojamiento]" id="alojamiento-<?php echo $llave ?>" class="campo-xs" value="<?php echo number_format($i['alojamiento']) ?>" onKeyUp="separador(this.id)">
									</td>
									<td>
										<input type="text" name="arreglo[<?php echo $llave ?>][alimentacion]" id="alimentacion-<?php echo $llave ?>" class="campo-xs" value="<?php echo number_format($i['alimentacion']) ?>" onKeyUp="separador(this.id)">
									</td>
									<td>
										<input type="text" name="arreglo[<?php echo $llave ?>][hidratacion]" id="hidratacion-<?php echo $llave ?>" class="campo-xs" value="<?php echo number_format($i['hidratacion']) ?>" onKeyUp="separador(this.id)">
									</td>
									<td>
										<input type="text" name="arreglo[<?php echo $llave ?>][taeropuerto]" id="taeropuerto-<?php echo $llave ?>" class="campo-xs" value="<?php echo number_format($i['taeropuerto']) ?>" onKeyUp="separador(this.id)">
									</td>
								</tr>
								<?php
							}
							?>
						</table>				
					</td>
				</tr>
				<?php	
			}
			?>    
		</table>
		<br>
		<div align="center">
			<button type="submit" name="boton1" class="btn btn-rosa btn-sm">Grabar</button>
		</div>
	</form>
</div>
<?php 
include('footer.php')
?>
</body>
</html>