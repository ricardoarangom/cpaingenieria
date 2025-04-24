<?php require_once('../connections/datos.php'); ?>
<?php

$solicitud=$_GET['solicitud'];

include('encabezado.php');

$buscaSolicitud="SELECT IdGviaje, nombre, apellido, area, municipio, departamentos, fsalida, fregreso, actividad, beneficiario, banco FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join bancos on gviaje.IdBanco=bancos.IdBanco where IdGviaje=".$solicitud;
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
		if (event.keyCode == 13){
				event.preventDefault();
		}
		
	}, false);
	
	document.addEventListener('DOMContentLoaded', function(){
    calculaSubTotal();    
  })
	
	function calcula(id){
		
		var arregloId = id.split("-");
		var cantidad = parseFloat(document.getElementById('cantidad-'+arregloId[1]).value);
		var vunitario = document.getElementById('vunitario-'+arregloId[1]).value;
		var formatter = new Intl.NumberFormat('en-US');
		var cambios = parseInt(document.getElementById('cambios').value);
				
		vunitario = parseFloat(vunitario.replace(",", ""));		
		var vtotal = cantidad*vunitario;		
		$('#vtotal-'+arregloId[1]).val(formatter.format((vtotal).toFixed(0)));

		document.getElementById('cambios').value=cambios+1;
		
		calculaSubTotal()
	}
	
	function calculaSubTotal(){
		var subtotales = document.querySelectorAll('.vtotal');
		var formatter = new Intl.NumberFormat('en-US');
		var suma = 0;
		for(var i=0;i<subtotales.length;i++){			
			suma = suma + parseFloat(subtotales[i]['value'].replace(/,/g, ""));
		}		
		
		$('#total').html(formatter.format((suma).toFixed(0)));
	}
	
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
	
	function rechaza1(){
		var formulario = document.getElementById('formulario');
		
		swal({
			html: "¿Desea rechazar la solicitud de gastos de viaje?",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Sí",
			cancelButtonText: "No",
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			}).then(function(result){
			if (result.value) {
				const nuevoCampo = document.createElement('input');
				nuevoCampo.setAttribute('name', 'boton4');
				nuevoCampo.setAttribute('value', 1);
				nuevoCampo.setAttribute('type', 'hidden');

				formulario.appendChild(nuevoCampo);

				// formulario.submit()			
				
			}else{
				return
			}
		});
	}
  
  function rechaza(){
  $('#rechazo').modal({backdrop: 'static', keyboard: false});  
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
	<form action="graba.php" method="post" id="formulario1">
		<div class="grid columna-12 Arial14">
			<div class="span-4" align="left">
				SOLICITANTE <br>
				<strong><?php echo $row_resultado['nombre']." ".$row_resultado['apellido'] ?></strong>
			</div>
			<div class="span-4" align="left">
				PROYECTO <br>
				<strong><?php echo $row_resultado['area'] ?></strong>
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
      <div class="span-4">
				BANCO<br>
				<strong><?php echo $row_resultado['banco'] ?></strong>
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
					<td>
						<input type="text" class="campo-xs cantidad" value="<?php echo $row_resultado1['cantidad']?>" name="arreglo[<?php echo $item?>][cantidad]" id="cantidad-<?php echo $item?>" onChange="calcula(this.id)">
					</td>
					<td>
						<input type="text" class="campo-xs vunitario" value="<?php echo number_format($row_resultado1['vunitario'],0)?>" name="arreglo[<?php echo $item?>][vunitario]" id="vunitario-<?php echo $item?>" onChange="calcula(this.id)" onKeyUp="separador(this.id)">
					</td>
					<td>
						<input type="text" class="campo-xs vtotal" value="<?php echo number_format(($row_resultado1['vunitario']*$row_resultado1['cantidad']),0)?>" name="arreglo[<?php echo $item?>][vtotal]" id="vtotal-<?php echo $item?>" readonly>
						<input type="hidden" value="<?php echo $row_resultado1['IdItem']?>" name="arreglo[<?php echo $item?>][IdItem]" id="IdItem-<?php echo $item?>">
					</td>
				</tr>
				<?php
				$item++;
			} while($row_resultado1 = mysql_fetch_assoc($resultado1));
			?>
			<tr class="Arial14">
				<td colspan="3" align="center" style="font-weight: bold">TOTAL</td>
				<td id="total" align="right"></td>		
			</tr>
		</table>
		<br>
		<div align="center">
			<input type="hidden" name="autorizador" value="<?php echo $usuario ?>">
			<input type="hidden" name="solicitud" value="<?php echo $solicitud ?>">
			<input type="hidden" name="cambios" id="cambios"  value="0">
			<button type="submit" class="btn btn-verde btn-sm" name="boton3">Autorizar</button>
			<button type="button" class="btn btn-rosa btn-sm" name="boton4" onClick="rechaza()">Rechazar</button>
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
<div id="rechazo" class="modal fade" role="dialog">
  <div class="modal-dialog">    
    <div class="modal-content">
      <form method="post" id="formulario" name="formulario" action="graba.php">
        <div class="modal-header" style="background:#d8d8d8; color:black">
            <h5 class="modal-title">Rechazo solicitud gastos de viajes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <h6 class="Cemtury" align="center">SE VA A RECHAZAR LA SOLICITUD DE GASTOS DE VIAJE</h6>
          Motivo:
          <textarea name="motivo" id="" rows="2" class="txtarea" required></textarea>
          <input type="hidden" name="autorizador" value="<?php echo $usuario ?>">
			    <input type="hidden" name="solicitud" value="<?php echo $solicitud ?>">
          <br>
        </div>
        <div class="modal-footer">
          <button type="submit" name="boton4" class="btn btn-rosa btn-sm">Rechazar</button>
          <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include('footer.php');
?>

</body>
</html>