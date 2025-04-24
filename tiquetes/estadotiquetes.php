<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php');
$hoy=date("Y-m-d");

if($nivel==0 or $nivel==1 or $nivel==4){
	$buscador="";
}else{
	$buscador= "IdSolicitante=".$usuario." and ";
}

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// ufecha>='".$hoy."' and
$query_Recordset1 = "SELECT IdTiquete, tiquetes.IdArea, area, ccostos, tiquetes.IdEmpresa, IdSolicitante, fecha, trayectos, pasajeros, fcotizacion, cotizacion, fautorizacion, IdAutorizador, IdCotizador, fcompra, tiquete, concat(usuarios.nombre,' ',usuarios.apellido) as nombres, concat(usuarios_1.nombre,' ',usuarios_1.apellido) as nombrea, concat(usuarios_2.nombre,' ',usuarios_2.apellido) as nombrec, observaciones, motivo FROM ((((tiquetes  left join usuarios on tiquetes.IdSolicitante=usuarios.IdUsuario) left join usuarios as usuarios_1 on tiquetes.IdAutorizador=usuarios_1.IdUsuario) left join usuarios as usuarios_2 on tiquetes.IdCotizador=usuarios_2.IdUsuario) ) left join areas on tiquetes.IdArea=areas.IdArea WHERE ".$buscador."  rechazado=0 and eliminado=0 ORDER BY IdTiquete";

$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


$buscaMunicipios="SELECT IdMunicipio, municipio, departamentos, municipios.IdDepartamento FROM municipios left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento";
$resultado1 = mysql_query($buscaMunicipios, $datos) or die(mysql_error());
$row_resultado1 = mysql_fetch_assoc($resultado1);
$totalRows_resultado1 = mysql_num_rows($resultado1);

do{
	
	$tablaMun[$row_resultado1['IdMunicipio']]['Id']=$row_resultado1['IdMunicipio'];
	$tablaMun[$row_resultado1['IdMunicipio']]['municipio']=$row_resultado1['municipio'];
	$tablaMun[$row_resultado1['IdMunicipio']]['departamento']=$row_resultado1['departamentos'];
	$tablaMun[$row_resultado1['IdMunicipio']]['IdDepartamento']=$row_resultado1['IdDepartamento'];
	
	$departamento[$row_resultado1['IdDepartamento']]=$row_resultado1['departamentos'];
		
} while($row_resultado1 = mysql_fetch_assoc($resultado1));
mysql_free_result($resultado1);

$tablamunicipios=json_encode($tablaMun);

if($totalRows_Recordset1>0){
	do{
    $nproyecto=$row_Recordset1['ccostos']." ".$nproyecto=$row_Recordset1['area'];;
		
		$tabla[$row_Recordset1['IdTiquete']]['proyecto']=$nproyecto;
		
		$tabla[$row_Recordset1['IdTiquete']]['fecha']=$row_Recordset1['fecha'];
		$tabla[$row_Recordset1['IdTiquete']]['solicitante']=$row_Recordset1['nombres'];
		
		$tabla[$row_Recordset1['IdTiquete']]['IdSolicitante']=$row_Recordset1['IdSolicitante'];
				
		$tabla[$row_Recordset1['IdTiquete']]['fcotizacion']=$row_Recordset1['fcotizacion'];
		$tabla[$row_Recordset1['IdTiquete']]['fautorizacion']=$row_Recordset1['fautorizacion'];
		$tabla[$row_Recordset1['IdTiquete']]['fcompra']=$row_Recordset1['fcompra'];
		
		$tabla[$row_Recordset1['IdTiquete']]['cotizado']=$row_Recordset1['nombrec'];
		$tabla[$row_Recordset1['IdTiquete']]['autorizado']=$row_Recordset1['nombrea'];
		
		$tabla[$row_Recordset1['IdTiquete']]['trayectos']=json_decode($row_Recordset1['trayectos'],true);
		$tabla[$row_Recordset1['IdTiquete']]['pasajeros']=json_decode($row_Recordset1['pasajeros'],true);
		
		$tabla[$row_Recordset1['IdTiquete']]['cotizacion']=$row_Recordset1['cotizacion'];
		$tabla[$row_Recordset1['IdTiquete']]['tiquete']=$row_Recordset1['tiquete'];
		
		$tabla[$row_Recordset1['IdTiquete']]['observaciones']=$row_Recordset1['observaciones'];

		$tabla[$row_Recordset1['IdTiquete']]['motivo']=$row_Recordset1['motivo'];
		
	} while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
}

mysql_free_result($Recordset1);

asort($departamento);

//echo "<pre>";
//print_r($departamento);
//echo "</pre>";
?>
<script>
	

	function verPlan(id){
		var planes = document.querySelectorAll('.planes');
		for(var i = 0;i<planes.length;i++){
			document.getElementById(planes[i]['id']).style.display='none';
		}
		document.getElementById('plan-'+id).style.display='';
		$('#plan').modal({backdrop: 'static', keyboard: false});
	}

	function comprar(id){
		document.getElementById('idCom').value=id;
		$('#comprar').modal({backdrop: 'static', keyboard: false});
	}
	
	function comprar1(){
				
		var usuario = <?php echo $usuario ?>;
		var tiquete = document.getElementById('tiquete').files[0];
		var IdTiquete = document.getElementById('idCom').value;
    var mpago = document.getElementById('mpago').value;
		
		if(!tiquete){
			swal({
				 html: '¡El documento de cotización es obligatorio!',
				 type: "error",
				 showConfirmButton: true,
				 confirmButtonText: "Cerrar"
				 }).then(function(result){
				 if (result.value) {					 
				 }
			 });
			return
		}
		
		$('#comprar').modal('hide');

		var datos = new FormData();
		
		datos.append("usuario",usuario);
		datos.append("tiquete",tiquete);
		datos.append("IdTiquete",IdTiquete);
    datos.append("mpago",mpago);

		datos.append("proced",3);

		$.ajax({
          url:"ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
//					respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
            var res = respuesta.trim();
						console.log(res)
            if(res=='ok'){
							swal({
								 html: '¡El tiquete se ha subido correctamente!',
								 type: "success",
								 showConfirmButton: true,
								 confirmButtonText: "Cerrar"
								 }).then(function(result){
								 if (result.value) {
									 window.open('correotiquetes2.php?IdTiquete='+IdTiquete, '_blank');
									 location.reload();
								 }
							 });              
            }else{
              
            }
          
          }
    })
		
	}
		
	function cotizar(id){
		document.getElementById('idCot').value=id;
		$('#cotizar').modal({backdrop: 'static', keyboard: false});
	}
	
	function cotizar1(){
				
		var usuario = <?php echo $usuario ?>;
		var cotizacion = document.getElementById('cotizacion').files[0];
		var IdTiquete = document.getElementById('idCot').value;		
		
		if(!cotizacion){
			swal({
				 html: '¡El documento de cotización es obligatorio!',
				 type: "error",
				 showConfirmButton: true,
				 confirmButtonText: "Cerrar"
				 }).then(function(result){
				 if (result.value) {					 
				 }
			 });
			return
		}
		
		$('#cotizar').modal('hide');

		var datos = new FormData();
		
		datos.append("usuario",usuario);
		datos.append("cotizacion",cotizacion);
		datos.append("IdTiquete",IdTiquete);

		datos.append("proced",2);

		$.ajax({
          url:"ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
//					respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
            var res = respuesta.trim();
						console.log(res)
            if(res=='ok'){
							swal({
								 html: '¡La cotización se ha subido correctamente!',
								 type: "success",
								 showConfirmButton: true,
								 confirmButtonText: "Cerrar"
								 }).then(function(result){
								 if (result.value) {
									 window.open('correotiquetes4.php?IdTiquete='+IdTiquete, '_blank');
									 location.reload();
								 }
							 });              
            }else{
              
            }
          
          }
    })
		
	}
	
	function validarArchivo(archivo,id){
    if((archivo[0]["size"] > 2100000) || (archivo[0]["type"]!="application/pdf") ){

      $("#"+id).val("");

      swal({
          title: "Error al cargar el archivo",
          text: "¡El archivo no debe pesar más de 2.000K y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
      });
    }    
  }
	
	function quitaArchivo(doc){
		$("#"+doc).val("");
	}
	
	function rechazar(id){		
		document.getElementById('idRec').value=id;
		
		var info = document.querySelectorAll('.info');
		for(var i = 0;i<info.length;i++){
			document.getElementById(info[i]['id']).style.display='none';
		}
		document.getElementById('info-'+id).style.display='';
		
		$('#rechazar').modal({backdrop: 'static', keyboard: false});
	}
	
	function rechazar1(){

		$('#rechazar').modal('hide');
		var IdTiquete = document.getElementById('idRec').value;		
		var observacion = document.getElementById('observacion').value;
		
		var datos = new FormData();

		datos.append("IdTiquete",IdTiquete);
		datos.append("observacion",observacion);
		datos.append("proced",4);


		$.ajax({
          url:"ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
//					respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
            var res = respuesta.trim();
						console.log(res)
            if(res=='ok'){
							swal({
								 html: '¡La solicitud de tiquetes aereos ha sido rechazada correctamente!',
								 type: "success",
								 showConfirmButton: true,
								 confirmButtonText: "Cerrar"
								 }).then(function(result){
								 if (result.value) {
								 	 window.open('correotiquetes3.php?IdTiquete='+IdTiquete, '_blank');
									 location.reload();
								 }
							 });              
            }else{
              
            }
          
          }
    })
	}
	
	function aprobar(id){
		document.getElementById('idRec1').value=id;
		
		var info = document.querySelectorAll('.info1');
		for(var i = 0;i<info.length;i++){
			document.getElementById(info[i]['id']).style.display='none';
		}
		document.getElementById('info1-'+id).style.display='';
		$('#aprobar').modal({backdrop: 'static', keyboard: false});
	}
	
	function aprobar1(){
		console.log('hola');
		
		var IdTiquete = document.getElementById('idRec1').value;		
		var observacion = document.getElementById('observacion1').value;
		
		
		var usuario = <?php echo $usuario ?>;
		var datos = new FormData();

		datos.append("IdTiquete",IdTiquete);
		datos.append("observacion",observacion);
		datos.append("usuario",usuario);
		datos.append("proced",5);
		
		$.ajax({
          url:"ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
//					respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
            var res = respuesta.trim();
						console.log(res)
            if(res=='ok'){
							swal({
								 html: '¡La solicitud de tiquetes aereos ha sido aprobada correctamente!',
								 type: "success",
								 showConfirmButton: true,
								 confirmButtonText: "Cerrar"
								 }).then(function(result){
								 if (result.value) {
                   window.open('correotiquetes5.php?IdTiquete='+IdTiquete, '_blank')
									 location.reload();
								 }
							 });              
            }else{
              
            }
          
          }
    })
		
	}
	
	function eliminar(id){
		
		var usuario = <?php echo $usuario ?>;
		var datos = new FormData();

		datos.append("IdTiquete",id);
		datos.append("usuario",usuario);
		datos.append("proced",6);
		
		$.ajax({
          url:"ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
//					respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
            var res = respuesta.trim();
//						console.log(res)
            if(res=='ok'){
							swal({
								 html: '¡La solicitud de tiquetes aereos ha sido eliminada correctamente!',
								 type: "success",
								 showConfirmButton: true,
								 confirmButtonText: "Cerrar"
								 }).then(function(result){
								 if (result.value) {
									 location.reload();
								 }
							 });              
            }else{
              
            }
          
          }
    })
		
	}
	
	function buscamun(valor,id){
				
		var arregoId = id.split("-");
		var cadena = '<?php echo $tablamunicipios ?>';
		var arreglo = JSON.parse(cadena);
		var fila = '';
				
		fila = fila + '<select name="'+arregoId[1]+'" id="mun-'+arregoId[1]+'" class="campo-sm Arial12">';
		fila = fila + '<option value="">Seleccione el Mpio</option>';
		Object.keys(arreglo).forEach(key => {
			if(valor==arreglo[key]['IdDepartamento']){
				fila = fila + '<option value="'+arreglo[key]['Id']+'">'+arreglo[key]['municipio']+'</option>'; 
			}
				
		});
		fila = fila + '</select>';

		$('#m-'+arregoId[1]).html(fila)
	}
	
	function verificaDpto(id){
		
		var arregloId = id.split("-");
		var deptoId = 'd-'+arregloId[1];
		var depto = document.getElementById(deptoId).value;
		
		if(depto){
			
		}else{
			document.getElementById(deptoId).focus();
			swal({
					title: "Error",
					text: "¡Debe seleccionar primero el departamento!",
					type: "error",
					confirmButtonText: "¡Cerrar!"
			});
		}
	}
	
</script>
<style>
	hr {
    margin-bottom: 0;
    margin-top: 0;
    border-top: 1px solid rgb(100,100,100);
  }

	.sticky {
    position: sticky;
    top: 0;
    right: auto    
  }
</style>

<?php 
include('encabezado1.php')
?>
<h4 align="center" style="font-family: Century-G;font-size: 24px;margin: 0;padding: 0">TRAMITE DE TIQUETES AEREOS</h4>
<br>
<br>
<div align="center">
	<table class="tablita Arial11" border="1">
		<thead class="sticky">
			<tr class="titulos">
				<td width="200px" align="center"><strong>Proyecto / Area</strong></td>
				<td width="100px" align="center"><strong>Motivo</strong></td>				
				<td width="140px" align="center"><strong>Origen</strong></td>
				<td width="140px" align="center"><strong>Destino</strong></td>
				<td width="70px" align="center"><strong>Fecha</strong></td>

				<td width="7px" style="background: #FFFFFF;border-bottom-color: #ffffff;border-top-color: #ffffff "></td>
				<td colspan="2" align="center"><strong>Solicitud</strong></td>
				<td colspan="2" align="center"><strong>Cotización</strong></td>
				<td colspan="2" align="center"><strong>Aprobación</strong></td>
				<td  width="80px" align="center"><strong>Comprado</strong></td>
				<td width="100px" align="center"><strong>Observaciones</strong></td>
				<td width="106px" align="center"><strong>Acciones</strong></td>
				<td width="106px" align="center"><strong>Archivos</strong></td>
			</tr>
		</thead>
		<?php 
		if($tabla){
			foreach($tabla as $key=>$j){
				?>
				<tr>
					<td valign="top" bgcolor="#bdbdbd" class="proyecto Arial10" ><?php echo $j['proyecto'] ?></td>
					<td valign="top" bgcolor="#bdbdbd" class="motivo Arial10" ><?php echo $j['motivo'] ?></td>
					<td colspan="3" valign="top" bgcolor="#bdbdbd" style="margin: 0;padding: 0">
						<?php 
						foreach($j['trayectos'] as $llave=>$i){
							?>	
							<div class="grid columna-5" style="grid-row-gap: 0px;grid-column-gap: 0px">
								<div class="span-2 Arial10" style="padding-left: 3px;padding-right: 2px"><?php echo $tablaMun[$i['muno']]['municipio']?></div>
								<div class="span-2 Arial10" style="padding-left: 3px;padding-right: 2px;border-left-color: #00000;border-left-style: solid;border-left-width: thin;border-right-color: #00000;border-right-style:  solid;border-right-width: thin"><?php echo $tablaMun[$i['mund']]['municipio'] ?></div>
								<div class="span-1" style="padding-left: 3px;padding-right: 2px" align="center"><?php echo fechaactual3($i['fecha'])?></div>
						 	</div>
							<hr>
							<?php
						}
						?>
						<strong>PASAJEROS:</strong>
						<hr>
						<?php
						foreach($j['pasajeros'] as $llave=>$i){
							?>
							<div class="grid columna-5" style="grid-row-gap: 0px;grid-column-gap: 0px">
								<div class="span-4 Arial10" style="padding-left: 3px;padding-right: 2px"><?php echo $i['nombre'] ?></div>
								<div class="span-1 Arial10" style="padding-left: 3px;padding-right: 2px">
									<a href="<?php echo $i['link']?>" class="btn btn-verde btn-xs1" target="_blank">Ver Cedula</a>
								</div>
							</div>
							<hr>							
							<?php
						}
						?>
					</td>
					
					<td valign="top" style="border-bottom-color: #ffffff;"></td>
					<td width="70px" align="center" valign="top"><?php echo fechaactual3($j['fecha']) ?></td>
					<td width="80px" valign="top"><?php echo $j['solicitante'] ?></td>
					<?php 
					if($j['fcotizacion']){
						?>
						<td width="70px" align="center" valign="top"><?php echo fechaactual3($j['fcotizacion']) ?></td>
						<td width="80px" valign="top"><?php echo $j['cotizado'] ?></td>
						<?php
					}else{
						?>
						<td width="70px" align="center" valign="top"></td>
						<td width="80px" align="center" bgcolor="#FF9E7E">PENDIENTE	</td>
						<?php
					}
					
					if($j['fautorizacion']){
						?>
						<td width="70px" align="center" valign="top"><?php echo fechaactual3($j['fautorizacion']) ?></td>
						<td width="80px" valign="top"><?php echo $j['autorizado'] ?></td>
						<?php
					}else{
						if($j['fcotizacion']){
							?>
							<td width="70px" align="center" valign="top"></td>
							<td width="80px" align="center" bgcolor="#FF9E7E">PENDIENTE	</td>
							<?php
						}else{
							?>
							<td width="70px" align="center" valign="top"></td>
							<td width="80px" align="center"></td>
							<?php
						}
					}
					if($j['fcompra']){
						?>
						<td width="80px" align="center" valign="top"><?php echo fechaactual3($j['fcompra']) ?></td>
						<?php
					}else{
						if($j['fautorizacion']){
							?>
							<td width="80px" align="center" bgcolor="#FF9E7E">PENDIENTE</td>
							<?php
						}else{
							?>
							<td width="80px" align="center"></td>
							<?php
							}
					}
					?>
					<td valign="top">
						<?php echo $j['observaciones'] ?>
					</td>
					<td valign="top">
						<?php 
						if(($nivel==0 or $nivel==4) and !$j['fcotizacion']){
							?>
							<button type="button" class="btn btn-verde btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="cotizar(<?php echo $key ?>)">Cargar Cotización</button>
							<button type="button" class="btn btn-gris btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="rechazar(<?php echo $key ?>)">Rechazar</button>
							<?php
						}
						if(($nivel==0 or $nivel==4) and !$j['fcompra'] and $j['fautorizacion']){
							?>
							<button type="button" class="btn btn-verde btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="comprar(<?php echo $key ?>)">Cargar Tiquete</button>
							<button type="button" class="btn btn-gris btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="rechazar(<?php echo $key ?>)">Rechazar</button>
							<?php
						}
						if(($nivel==0 or $nivel==1) and $j['fcotizacion'] and !$j['fautorizacion']){
							?>
							<button type="button" class="btn btn-verde btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="aprobar(<?php echo $key ?>)">Aprobar</button>
							<button type="button" class="btn btn-gris btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="rechazar(<?php echo $key ?>)">Rechazar</button>
							<?php
						}
						if($usuario==$j['IdSolicitante'] and !$j['fcompra']){
							?>
							<button type="button" class="btn btn-gris btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="eliminar(<?php echo $key ?>)">Eliminar solicitud</button>
							<?php
						}
						?>			
					</td>
					<td valign="top">
						<button type="button" class="btn btn-azul btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" onClick="verPlan(<?php echo $key ?>)">Detalles del viaje</button>
						<?php 
						if($j['cotizacion']){
							?>
							<a href="<?php echo $j['cotizacion'] ?>" class="btn btn-azul btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" target="_blank">Ver cotización</a>
							<?php
						}
						if($j['tiquete']){
							?>
							<a href="<?php echo $j['tiquete']?>" class="btn btn-azul btn-xs1 btn-block" style="margin-bottom: 2px;margin-top: 1px" target="_blank">Ver tiquetes</a>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<br><br>
</div>

<!--modal-->
<div id="plan" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg">    
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Detalles del viaje</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>	
			<div class="modal-body">
				<?php 
				foreach($tabla as $key=>$j){
					?>
					<div class="planes" id="plan-<?php echo $key ?>" style="display: none">
						<h5 class="Century" style="margin-bottom: 0px;margin-top: 8px">Trayectos</h5>
						<table class="tablita Arial12" border="1" cellspacing="0">
							<col width="235px">
							<col width="235px">
							<col width="123px">
							<col width="173px">
							<tr>
								<td align="center" bgcolor="#d8d8d8">Origen</td>
								<td align="center" bgcolor="#d8d8d8">Destino</td>
								<td align="center" bgcolor="#d8d8d8">Fecha</td>
								<td align="center" bgcolor="#d8d8d8">Jornada</td>
							</tr>
							<?php 
							foreach($tabla[$key]['trayectos'] as $llave=>$i){
								?>
								<tr>
									<td><?php echo $tablaMun[$i['muno']]['municipio'] ?></td>
									<td><?php echo $tablaMun[$i['mund']]['municipio'] ?></td>
									<td align="center"><?php echo fechaactual3($i['fecha']) ?></td>
									<td>
										<?php 
										if($i['jornada']==0){
											echo 'Madrugrada';
										}else if($i['jornada']==1){
											echo 'Mañana';
										}else if($i['jornada']==2){
											echo 'Tarde';
										}else if($i['jornada']==3){
											echo 'Noche';
										}										
										?>
									</td>
								</tr>
								<?php
							}
							?>
						</table>
						<h5 class="Century" style="margin-bottom: 0px;margin-top: 8px">Pasajeros</h5>
						<table class="tablita Arial12" border="1" cellspacing="0" width="100%">
							<col width="232px">
							<col width="85px">
							<col width="80px">
							<col width="172px">
							<col width="75x">
							<col width="72px">
							<tr>
								<td align="center" bgcolor="#d8d8d8">Nombre</td>
								<td align="center" bgcolor="#d8d8d8">Cedula</td>
								<td align="center" bgcolor="#d8d8d8">Telefono</td>
								<td align="center" bgcolor="#d8d8d8">E-mail</td>
								<td align="center" bgcolor="#d8d8d8">Equipaje</td>
								<td align="center" bgcolor="#d8d8d8"></td>
							</tr>
							<?php 
							foreach($tabla[$key]['pasajeros'] as $llave=>$i){
								?>
								<tr>
									<td><?php echo $i['nombre'] ?></td>
									<td align="right"><?php echo colocapuntos($i['cedula']) ?></td>
									<td align="center"><?php echo $i['telefono'] ?></td>
									<td><?php echo $i['email'] ?></td>
									<td>
										<?php 
										if($i['equipaje']==1){
											echo "De mano";
										}else if($i['equipaje']==2){
											echo "De Cabina";
										}else if($i['equipaje']==3){
											echo "De bodega";
										}
										?>
									</td>
									<td>
										<a href="<?php echo $i['link']?>" class="btn btn-verde btn-xs1" target="_blank">Ver Cedula</a>
									</td>
								</tr>
								<?php
							}
					
							?>
						</table>				
					</div>
				 	<?php	
				}
				
				?>					
			</div>
			<div class="modal-footer" align="right">
				<button type="button" class="btn btn-gris btn-sm" data-dismiss="modal">Cerrar</button>
			</div>
			
    </div>
  </div>
</div>

<div id="cotizar" class="modal fade" role="dialog" >
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Cargar cotización</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>	
			<div class="modal-body">
				<input type="hidden" id="idCot">
				<div class="grid columna-15">
					<div class="span-14">
						Documento en PDF y máximo 2MB
						<input type="file" name="cotizacion" id="cotizacion" class="campo-xs Arial12" onChange="validarArchivo(this.files,this.id)" required>
					</div>
					<div class="span-1">
						<br>
						<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onClick="quitaArchivo('cotizacion')">
					</div>
				</div>
				
			</div>
			<div class="modal-footer grid columna-5">
				<div class="span-3"></div>
				<div class="span-1">
					<button type="button" class="btn btn-verde btn-sm btn-block" onClick="cotizar1()">Grabar</button>
				</div>
				<div class="span-1">
					<button type="button" class="btn btn-gris btn-sm btn-block" data-dismiss="modal">Cancelar</button>
				</div>
				
			</div>
			
    </div>
  </div>
</div>

<div id="comprar" class="modal fade" role="dialog" >
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Cargar tiquetes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>	
			<div class="modal-body">
				<input type="hidden" id="idCom">
				<div class="grid columna-15">
					<div class="span-14">
						Documento en PDF y máximo 2MB
						<input type="file" name="tiquete" id="tiquete" class="campo-xs Arial12" onChange="validarArchivo(this.files,this.id)" required>
					</div>
					<div class="span-1">
						<br>
						<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onClick="quitaArchivo('tiquete')">
					</div>
          <div class="span-6">
            Medio de pago:
            <input type="text" name="mpago" id="mpago" class="campo-xs Arial12">
          </div>
				</div>
				
			</div>
			<div class="modal-footer grid columna-5">
				<div class="span-3"></div>
				<div class="span-1">
					<button type="button" class="btn btn-verde btn-sm btn-block" onClick="comprar1()">Grabar</button>
				</div>
				<div class="span-1">
					<button type="button" class="btn btn-gris btn-sm btn-block" data-dismiss="modal">Cancelar</button>
				</div>				
			</div>			
    </div>
  </div>
</div>

<div id="rechazar" class="modal fade" role="dialog" >
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Rechazar solicitud de tiquetes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
		
      	<div class="modal-body">
					<input type="hidden" name="idRec" id="idRec">
					<div>
						Se va a rechazar la solicitud de tiquetes con la siguiente información:
					</div>
					<?php 
					foreach($tabla as $key=>$j){
						?>
						<div class="info" id="info-<?php echo $key ?>" style="display: none">
							<h6 style="margin: 0">Proyecto/Area: <?php echo $j['proyecto'] ?></h6>
							<h6 style="margin: 0">Solicitante: <?php echo $j['solicitante'] ?></h6>
							<h6 style="margin: 0">Pasajeros: </h6>
							<table class="Arial12">
								<?php 
								foreach($tabla[$key]['pasajeros'] as $llave=>$i){
									?>
									<tr height="16px">
										<td><?php echo $i['nombre'] ?></td>
									</tr>
									<?php
								}
								?>
							</table>
							<h6 style="margin: 0">Trayectos: </h6>
							<table width="80%" class="Arial12">
								<col width="50%">
								<col width="50%">
								<tr>
									<td><strong>Origen</strong></td>
									<td><strong>Destino</strong></td>
								</tr>
								<?php 
								foreach($tabla[$key]['trayectos'] as $llave=>$i){
									?>
									<tr>
										<td><?php echo $tablaMun[$i['muno']]['municipio'] ?></td>
										<td><?php echo $tablaMun[$i['mund']]['municipio'] ?></td>
									</tr>
									<?php									
								}
								?>								
							</table>
						</div>
						<?php
					}
					?>
					<div>
						Motivo del Rechazo:
						<textarea class="txtarea Arial12" id="observacion" rows="3" maxlength="100" name="observaciones" onBlur="aMayusculas(this.value,this.id)" ></textarea>
					</div>					
      	</div>
      	<div class="modal-footer grid columna-5">
					<div class="span-1">
						<button type="button" class="btn btn-verde btn-sm btn-block" name="boton32" onClick="rechazar1()">Grabar</button>
					</div>
					<div class="span-1">
						<button type="button" class="btn btn-gris btn-sm btn-block" data-dismiss="modal">Cancelar</button>
					</div>
					<div class="span-3"></div>
      	</div>
		
    </div>
  </div>
</div>

<div id="aprobar" class="modal fade" role="dialog" >
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Rechazar solicitud de tiquetes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
		
      	<div class="modal-body">
					<input type="hidden" name="idRec" id="idRec1">
					<div>
						Se va a aprobar la solicitud de tiquetes con la siguiente información:
					</div>
					<?php 
					foreach($tabla as $key=>$j){
						?>
						<div class="info1" id="info1-<?php echo $key ?>" style="display: none ">
							<h6 style="margin: 0">Proyecto/Area: <?php echo $j['proyecto'] ?></h6>
							<h6 style="margin: 0">Solicitante: <?php echo $j['solicitante'] ?></h6>
							<h6 style="margin: 0">Pasajeros: </h6>
							<table class="Arial12">
								<?php 
								foreach($tabla[$key]['pasajeros'] as $llave=>$i){
									?>
									<tr height="16px">
										<td><?php echo $i['nombre'] ?></td>
									</tr>
									<?php
								}
								?>
							</table>
							<h6 style="margin: 0">Trayectos: </h6>
							<table width="80%" class="Arial12">
								<col width="50%">
								<col width="50%">
								<tr>
									<td><strong>Origen</strong></td>
									<td><strong>Destino</strong></td>
								</tr>
								<?php 
								foreach($tabla[$key]['trayectos'] as $llave=>$i){
									?>
									<tr>
										<td><?php echo $tablaMun[$i['muno']]['municipio'] ?></td>
										<td><?php echo $tablaMun[$i['mund']]['municipio'] ?></td>
									</tr>
									<?php									
								}
								?>								
							</table>
						</div>
						<?php
					}
					?>
					<div>
						Indique que cotización se aprueba:
						<textarea class="txtarea Arial12" id="observacion1" rows="3" maxlength="100" name="observaciones" onBlur="aMayusculas(this.value,this.id)" ></textarea>
					</div>					
      	</div>
      	<div class="modal-footer grid columna-5">
					<div class="span-1">
						<button type="button" class="btn btn-verde btn-sm btn-block" name="boton32" onClick="aprobar1()">Grabar</button>
					</div>
					<div class="span-1">
						<button type="button" class="btn btn-gris btn-sm btn-block" data-dismiss="modal">Cancelar</button>
					</div>
					<div class="span-3"></div>
      	</div>
		
    </div>
  </div>
</div>

<?php 
include('footer.php')
?>
</body>
</html>


