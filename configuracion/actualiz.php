<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php');
?>
<?php 
$buscaAreas="SELECT IdArea, area, IdDirector, IdSubdirector, IdEmpresa, ccostos, nombre, apellido FROM areas left join usuarios on areas.IdDirector=usuarios.IdUsuario order by ccostos ";
$resultadoAr = mysql_query($buscaAreas, $datos) or die(mysql_error());
$row_resultadoAr = mysql_fetch_assoc($resultadoAr);
$totalRows_resultadoAr = mysql_num_rows($resultadoAr);

$buscaUsuarios="SELECT * FROM usuarios where nivel<>0 order by nombre,apellido";
$resultadoUsu = mysql_query($buscaUsuarios, $datos) or die(mysql_error());
$row_resultadoUsu = mysql_fetch_assoc($resultadoUsu);
$totalRows_resultadoUsu = mysql_num_rows($resultadoUsu);

$buscaBancos="SELECT * FROM bancos";
$resultadoBanc = mysql_query($buscaBancos, $datos) or die(mysql_error());
$row_resultadoBanc = mysql_fetch_assoc($resultadoBanc);
$totalRows_resultadoBanc = mysql_num_rows($resultadoBanc);

if($totalRows_resultadoAr>0){
	do{
		$tablaAreas[$row_resultadoAr['IdArea']]['ccostos']=$row_resultadoAr['ccostos'];
		$tablaAreas[$row_resultadoAr['IdArea']]['area']=$row_resultadoAr['area'];
		$tablaAreas[$row_resultadoAr['IdArea']]['director']=$row_resultadoAr['nombre']." ".$row_resultadoAr['apellido'];
		$tablaAreas[$row_resultadoAr['IdArea']]['IdDirector']=$row_resultadoAr['IdDirector'];
	}while ($row_resultadoAr = mysql_fetch_assoc($resultadoAr));
	$cadenaAreas=json_encode($tablaAreas,JSON_UNESCAPED_UNICODE);
}

if($totalRows_resultadoUsu>0){
	do{
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['nombre']=$row_resultadoUsu['nombre'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['apellido']=$row_resultadoUsu['apellido'];		
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['usuario']=$row_resultadoUsu['usuario'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['cargo']=$row_resultadoUsu['cargo'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['nivel']=$row_resultadoUsu['nivel'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['IdBanco']=$row_resultadoUsu['IdBanco'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['cuenta']=$row_resultadoUsu['cuenta'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['activado']=$row_resultadoUsu['activado'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['cedula']=$row_resultadoUsu['cedula'];
		$tablaUsuarios[$row_resultadoUsu['IdUsuario']]['correo']=$row_resultadoUsu['correo'];		
	}while ($row_resultadoUsu = mysql_fetch_assoc($resultadoUsu));
	$cadenaUsuarios=json_encode($tablaUsuarios,JSON_UNESCAPED_UNICODE);
}


?>
<style>
	.icono{
		cursor: pointer;
		font-size: 16px;
	}

	.icono:hover{
		color:#FF3F3F;
	}
	
	.check{
		position: relative;
		width:30px;
		
	}
	
	.check:before{
		content:'';
		position:absolute;
		width:30px;
		height:15px;
		background:#F00;
		border-radius: 15px;
	}

	.check:after{
		content:'';
		position:absolute;
		width:15px;
		height:15px;
		background:#fff;
		border-radius:15px;
		transition:0.25s;
		border: 1px solid #F00;
		box-sizing:border-box;
	}

	.check:checked:after{
		left:15px;
		border:1px solid #00a1ff;
	}

	.check:checked:before{
		background: #00a1ff;
	}
</style>
<?php 
include('encabezado1.php');
?>
<br>
<br>
<h4 align="center" class="Century">ACTUALIZACION DE INFORMACION</h4>
<br>
<div class="contenedor grid columna-9" style="width: 1500px">
	<div class="span-5">
		<h5 align="center" class="Century">AREAS / PROYECTO</h5>
		<br>
		<table class="tablita Arial12" border="1" align="center">
			<col width="80px">
			<col width="400px">
			<col width="300px">
			<col width="40px">
			<tr class="titulos">
				<td>Centro de Costos</td>
				<td>Area/Proyecto</td>
				<td>Director</td>
				<td></td>
			</tr>
			<?php
			if($tablaAreas){
				foreach($tablaAreas as $key=>$j){
					?>
					<tr>
						<td>
							<?php echo $j['ccostos'] ?>
						</td>
						<td>
							<?php echo $j['area'] ?>
						</td>
						<td>
							<?php echo $j['director'] ?>
						</td>
						<td align="center">
							<i class="icono icon-pencil" onClick="editaArea(<?php echo $key ?>)"></i>
						</td>
					</tr>
					<?php
				}
			}
			?>
			<tr>
				<td>
					<input type="text" class="campo-xs" id="ccostos-g" onBlur="aMayusculas(this.value,this.id)">
				</td>
				<td>
					<input type="text" class="campo-xs" id="area-g" onBlur="aMayusculas(this.value,this.id)">
				</td>
				<td>
					<select name="" id="director-g" class="campo-xs">
						<option value="0">Seleccione</option>
						<?php 
						if($tablaUsuarios){
							foreach($tablaUsuarios as $key=>$j){
								?>
								<option value="<?php echo $key ?>"><?php echo $j['nombre']." ".$j['apellido']?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
				<td align="center">
					<i class="icono icon-disc-floppy-font" onClick="creaArea()"></i>				
				</td>
			</tr>
		</table>
	</div>
	<div class="span-4">
		<h5 align="center" class="Century">USUARIOS</h5>
		<br>
		<table class="tablita Arial12" border="1" align="center">
			<col width="300px">
			<col width="300px">
			<col width="40px">
			<tr class="titulos">
				<td>NOMBRE</td>
				<td>CARGO</td>
				<td></td>
			</tr>
			<?php 
			foreach($tablaUsuarios as $key=>$j){
				?>
				<tr>
					<td>
						<?php echo $j['nombre']." ".$j['apellido'] ?>
					</td>
					<td>
						<?php echo $j['cargo'] ?>
					</td>
					<td align="center">
						<i class="icono icon-pencil" onClick="editaUsuario(<?php echo $key ?>)"></i>
					</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="3">
					<button type="button" class="btn btn-verde btn-xs1 btn-block" onClick="creauUsuario()">Agregar Usuario</button>
				</td>
			</tr>
		</table>
	</div>
</div>

<!--modals-->
<div id="editaAreaM" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="width: 390px">    
    <div class="modal-content">
      <div class="modal-header titulos" style="padding: 10px">
				<h6 class="modal-title">Editar Area/Proyecto</h6>					
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
      </div>
			
				<div class="modal-body" style="padding: 5px">
					<div class="grid columna-6 contenedor" style="grid-row-gap:5px;">
						<div class="span-6 Arial14">
							Area/Proyecto
							<input type="text" id="area-e" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-6">
							Centro de Costos
							<input type="text" id="ccostos-e" class="campo-xs Arial12">
						</div>
						<div class="span-6 Arial14">
							Director
							<select name="" id="director-e" class="campo-xs">
								<?php 
								if($tablaUsuarios){
									foreach($tablaUsuarios as $key=>$j){
										?>
										<option value="<?php echo $key ?>"><?php echo $j['nombre']." ".$j['apellido']?></option>
										<?php
									}
								}
								?>
							</select>
						</div>						
					</div>
					<input type="hidden" id="id-e">
				</div>
				<div class="modal-footer" style="padding: 5px">
					<button type="button" id="valida" class="btn btn-rosa btn-xs" onClick="grabaAreaE()" >Grabar</button>
					<button type="button" class="btn btn-verde btn-xs" data-dismiss="modal">Cancelar</button>
				</div>			
		</div>
	</div>
</div>

<div id="editaUsuarioM" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="width: 600px">    
    <div class="modal-content">
      <div class="modal-header titulos" style="padding: 10px">
				<h6 class="modal-title">Editar Usuario</h6>					
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
      </div>			
				<div class="modal-body" style="padding: 5px">
					<div class="grid columna-6 contenedor" style="grid-row-gap:5px;">
						<div class="span-3 Arial14">
							Nombre:
							<input type="text" id="nombreU-e" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-3 Arial14">
							Apellido:
							<input type="text" id="apellidoU-e" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-3 Arial14">
							Correo:
							<input type="text" id="correoU-e" class="campo-xs Arial12">
						</div>
						<div class="span-3 Arial14">
							Cargo:
							<input type="text" id="cargoU-e" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-3">
							Usuario:
							<input type="text" id="usuarioU-e" class="campo-xs Arial12">
						</div>
						<div class="span-3">
							Nivel:
							<input type="number" id="nivelU-e" class="campo-xs Arial12">
						</div>
						<div class="span-3">
							Cedula:
							<input type="text" id="cedulaU-e" class="campo-xs Arial12" data-trigger="hover"
                               data-toggle="popover"
                               data-content="Sin puntos ni comas"
                               title="ADVERTENCIA"
                               onkeyup="formatea(this.value,this.id)">
						</div>
						<div class="span-3">
							Activado:<br>
							NO&nbsp;&nbsp;&nbsp;<input type="checkbox" id="activadoU-e" class="check">&nbsp;&nbsp;&nbsp;SI
						</div>						
					</div>
					<input type="hidden" id="IdUsuario-e">
				</div>
				<div class="modal-footer" style="padding: 5px">
					<button type="button" id="valida" class="btn btn-rosa btn-xs" onClick="grabaUsuarioE()" >Grabar</button>
					<button type="button" class="btn btn-verde btn-xs" data-dismiss="modal">Cancelar</button>
				</div>			
		</div>
	</div>
</div>

<div id="creaUsuarioM" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="width: 600px">    
    <div class="modal-content">
      <div class="modal-header titulos" style="padding: 10px">
				<h6 class="modal-title">Editar Usuario</h6>					
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
      </div>			
				<div class="modal-body" style="padding: 5px">
					<div class="grid columna-6 contenedor" style="grid-row-gap:5px;">
						<div class="span-3 Arial14">
							Nombre:
							<input type="text" id="nombreU-g" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-3 Arial14">
							Apellido:
							<input type="text" id="apellidoU-g" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-3 Arial14">
							Correo:
							<input type="text" id="correoU-g" class="campo-xs Arial12">
						</div>
						<div class="span-3 Arial14">
							Cargo:
							<input type="text" id="cargoU-g" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-3">
							Usuario:
							<input type="text" id="usuarioU-g" class="campo-xs Arial12">
						</div>
						<div class="span-3">
							Nivel:
							<input type="number" id="nivelU-g" class="campo-xs Arial12">
						</div>
						<div class="span-3">
							Cedula:
							<input type="text" id="cedulaU-g" class="campo-xs Arial12" data-trigger="hover"
                               data-toggle="popover"
                               data-content="Sin puntos ni comas"
                               title="ADVERTENCIA"
                               onkeyup="formatea(this.value,this.id)">
						</div>
						<div class="span-3">
							Activado:<br>
							NO&nbsp;&nbsp;&nbsp;<input type="checkbox" id="activadoU-g" class="check">&nbsp;&nbsp;&nbsp;SI
						</div>						
					</div>
				</div>
				<div class="modal-footer" style="padding: 5px">
					<button type="button" id="valida" class="btn btn-rosa btn-xs" onClick="grabaUsuarioG()" >Grabar</button>
					<button type="button" class="btn btn-verde btn-xs" data-dismiss="modal">Cancelar</button>
				</div>			
		</div>
	</div>
</div>

<script>
	
	function creauUsuario(){
		$('#creaUsuarioM').modal({backdrop: 'static', keyboard: false});
	}
	
	function grabaUsuarioG(){
		
		

		var nombre  = document.getElementById('nombreU-g').value
		var apellido  = document.getElementById('apellidoU-g').value
		var correo  = document.getElementById('correoU-g').value
		var cargo  = document.getElementById('cargoU-g').value
		var usuario  = document.getElementById('usuarioU-g').value
		var nivel  = document.getElementById('nivelU-g').value
		var cedula  = document.getElementById('cedulaU-g').value
		var activado  = document.getElementById('activadoU-g')
		
		if(nombre=='' || apellido=='' || correo=='' || cargo=='' || usuario=='' || nivel==''){
			swal({
				text: '¡LOS CAMPOS "NOMBRE", "APELLIDO", "CORREO", "CARGO", "USUARIO" Y "NIVEL", SON OBLIGATORIOS!',
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
		
		$('#creaUsuarioM').modal('hide');
		
		var datos = new FormData();
		datos.append("nombre",nombre);
		datos.append("apellido",apellido);
		
		datos.append("cargo",cargo);
		datos.append("correo",correo);
		datos.append("usuario",usuario);
		datos.append("nivel",nivel);
		datos.append("cedula",cedula);
		if (activado.checked) {
			datos.append("activado",1);
		} else {
			datos.append("activado",0);
		}
		
		datos.append("proced",4);		
		
		$.ajax({
						url:"ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						success: function(respuesta){
							respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
							console.log(respuesta)
							if(respuesta=='ok'){
								swal({
											html: '<div class="Arila14">EL USUARIO HA SIDO CREADO CON EXITO</div><br>',
											type: "success",
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
											}).then(function(result){
											if (result.value) {
											 location.reload();
											}
									 });
							}
							
						}
			});

	}
	
	function formatea(valor,id){
		valor = valor.replace(/(\r\n|\n|\r)/gm, "");
		valor = valor.replace(/[.,]/g, '');
		valor = valor.replace(/[^0-9 ]/g, '');
		document.getElementById(id).value=valor
	}
	
	function grabaUsuarioE(){

		$('#editaUsuarioM').modal('hide');

		var IdUsuario  = document.getElementById('IdUsuario-e').value
		var nombre  = document.getElementById('nombreU-e').value
		var apellido  = document.getElementById('apellidoU-e').value
		var correo  = document.getElementById('correoU-e').value
		var cargo  = document.getElementById('cargoU-e').value
		var usuario  = document.getElementById('usuarioU-e').value
		var nivel  = document.getElementById('nivelU-e').value
		var cedula  = document.getElementById('cedulaU-e').value
		var activado  = document.getElementById('activadoU-e')
			
		
		if(nombre=='' || apellido=='' || correo=='' || cargo=='' || usuario=='' || nivel==''){
			swal({
				text: '¡LOS CAMPOS "NOMBRE", "APELLIDO", "CORREO", "CARGO", "USUARIO" Y "NIVEL", SON OBLIGATORIOS!',
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
		
		var datos = new FormData();
		datos.append("nombre",nombre);
		datos.append("apellido",apellido);
		
		datos.append("cargo",cargo);
		datos.append("correo",correo);
		datos.append("usuario",usuario);
		datos.append("nivel",nivel);
		datos.append("cedula",cedula);
		if (activado.checked) {
			datos.append("activado",1);
		} else {
			datos.append("activado",0);
		}

		datos.append("IdUsuario",IdUsuario);
		
		datos.append("proced",3);

		$.ajax({
						url:"ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						success: function(respuesta){
							respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
							console.log(respuesta)
							if(respuesta=='ok'){
								swal({
											html: '<div class="Arila14">EL USUARIO HA SIDO ACTUALIZADO CON EXITO</div><br>',
											type: "success",
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
											}).then(function(result){
											if (result.value) {
											 location.reload();
											}
									 });
							}
							
						}
			});

	}
	
	function editaUsuario(id){
		var tabla = '<?php echo $cadenaUsuarios ? $cadenaUsuarios : 0  ?>';
		var arregloTabla = JSON.parse(tabla);
				
		document.getElementById('nombreU-e').value=arregloTabla[id]['nombre']
		document.getElementById('apellidoU-e').value=arregloTabla[id]['apellido']
		document.getElementById('correoU-e').value=arregloTabla[id]['correo']
		document.getElementById('cargoU-e').value=arregloTabla[id]['cargo']
		document.getElementById('usuarioU-e').value=arregloTabla[id]['usuario']
		document.getElementById('nivelU-e').value=arregloTabla[id]['nivel']
		if(arregloTabla[id]['cedula']){
			document.getElementById('cedulaU-e').value=parseInt(arregloTabla[id]['cedula'])
		}else{
			document.getElementById('cedulaU-e').value='';
		}		
		
		if(arregloTabla[id]['activado']==1){
			document.getElementById('activadoU-e').checked=true
			
		}else{
			document.getElementById('activadoU-e').checked=false
			
		}
		
		document.getElementById('IdUsuario-e').value=id	
		
		$('#editaUsuarioM').modal({backdrop: 'static', keyboard: false});
	}
	
	function creaArea(){
		var ccostos = document.getElementById('ccostos-g').value;
		var area = document.getElementById('area-g').value;
		var IdDirector = document.getElementById('director-g').value;
		
		if(area=='' || ccostos==''){
			swal({
				text: "¡TODOS LOS CAMPOS SON OBLIGATORIOS!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
		var datos = new FormData();
		datos.append("ccostos",ccostos);
		datos.append("area",area);
		datos.append("IdDirector",IdDirector);
		datos.append("proced",2);
		
		$.ajax({
						url:"ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						success: function(respuesta){
							respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
							console.log(respuesta)
							if(respuesta=='ok'){
								swal({
									html: '<div class="Arila14">EL AREA / PROYECTO HA SIDO CREADO CON EXITO</div><br>',
									type: "success",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
									if (result.value) {
										location.reload();
									}
								});
							}else if(respuesta=='ya'){
								swal({
									html: '<div class="Arila14">EL CENTRO DE COSTOS YA EXISTE EN LA BASE DE DATOS</div><br>',
									type: "success",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
									if (result.value) {
										document.getElementById('ccostos-g').value='';
									}
								});
							}
							
						}
			});
		
		
	}
	
	function editaArea(id){
		var tabla = '<?php echo $cadenaAreas ? $cadenaAreas : 0  ?>';
		var arregloTabla = JSON.parse(tabla);
		document.getElementById('ccostos-e').value=arregloTabla[id]['ccostos'];	
		document.getElementById('area-e').value=arregloTabla[id]['area'];
		document.getElementById('director-e').value=arregloTabla[id]['IdDirector'];
		document.getElementById('id-e').value=id;
		$('#editaAreaM').modal({backdrop: 'static', keyboard: false});
	}
	
	function grabaAreaE(){
		$('#editaAreaM').modal('hide');
		var IdArea = document.getElementById('id-e').value;
		var area = document.getElementById('area-e').value;
		var ccostos = document.getElementById('ccostos-e').value;
		var IdDirector = document.getElementById('director-e').value;
		
		var datos = new FormData();
		datos.append("IdArea",IdArea);
		datos.append("area",area);
		datos.append("ccostos",ccostos);
		datos.append("IdDirector",IdDirector);
		datos.append("proced",1);
		
		$.ajax({
						url:"ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						success: function(respuesta){
							respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
							// console.log(respuesta);
							if(respuesta=='ok'){
								swal({
									html: '<div class="Arila14">EL AREA / PROYECTO HA SIDO ACTUALIZADO CON EXITO</div><br>',
									type: "success",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
									if (result.value) {
										location.reload();
									}
								});
							}else if(respuesta=='ya'){
								swal({
									html: '<div class="Arila14">EL CENTRO DE COSTOS YA EXISTE CON OTRA AREA/PROYECTO</div><br>',
									type: "success",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
									if (result.value) {
										editaArea(IdArea);
									}
								});
							}
							
						}
			});
		
	}

</script>
<?php 
include('footer.php');
?>


<body>
</body>
</html>