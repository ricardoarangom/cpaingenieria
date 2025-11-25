<?php require('../connections/datos.php');?>
<?php 
include('encabezado.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if(!$_POST['creador'] and !$_POST['firmante'] and !$_POST['asunto'] and !$_POST['desde'] and !$_POST['hasta'] and !$_POST['destinatario'] and !$_POST['desdeEnv'] and !$_POST['hastaEnv'] and !$_POST['enviadas'] and !$_POST['radicadas'] and !$_POST['anuladas'] and !$_POST['ano'] and !$_POST['consAno']){
	$buscador1="";
}else{
	$buscador1=" WHERE ";

	
	if($_POST['creador']){
		$buscador.=" usuarios.IdUsuario=".$_POST['creador']." and ";
	}
	if($_POST['firmante']){
		$buscador.=" firmante like '%".$_POST['firmante']."%' and ";
	}
	if($_POST['destinatario']){
		$buscador.=" (destinatario1 like '%".$_POST['destinatario']."%' or destinatario2 like '%".$_POST['destinatario']."%' or destinatario3 like '%".$_POST['destinatario']."%') and ";
	}
	
	if($_POST['asunto']){
		$buscador.=" asunto like '%".$_POST['asunto']."%' and ";
	}
	if($_POST['desde']){
		$buscador.=" fecha>='".$_POST['desde']."' and ";
	}
  
  if($_POST['hasta']){
    $buscador.=" fecha<='".$_POST['hasta']."' and ";
  }

	if($_POST['desdeEnv']){
		$buscador.=" fenvio>='".$_POST['desdeEnv']."' and ";
	}
  
  if($_POST['hastaEnv']){
    $buscador.=" fenvio<='".$_POST['hastaEnv']."' and ";
  }

	if($_POST['enviadas']){
		if($_POST['enviadas']==1){
			$buscador.=" enviada=1 and ";
		}
		if($_POST['enviadas']==2){
			$buscador.=" enviada=0 and ";
		}
		if($_POST['enviadas']==3){
			$buscador.=" (enviada=0 or enviada=1) and ";
		}
	}

	if($_POST['radicadas']){
		if($_POST['radicadas']==1){
			$buscador.=" radicado is not null and ";
		}
		if($_POST['radicadas']==2){
			$buscador.=" radicado is null and ";
		}
		if($_POST['radicadas']==3){
			$buscador.=" (radicado is not null or radicado is null) and ";
		}
	}

	if($_POST['anuladas']){
		if($_POST['anuladas']==1){
			$buscador.=" anulada=0 and ";
		}
		if($_POST['anuladas']==2){
			$buscador.=" anulada=1 and ";
		}
		if($_POST['anuladas']==3){
			$buscador.=" (anulada=0 or anulada=1) and ";
		}
	}

	if($_POST['ano']){
    $buscador.=" ano='".$_POST['ano']."' and ";
  }

	if($_POST['consAno']){
    $buscador.=" consAno=".$_POST['consAno']." and ";
  }
}

$buscador=substr($buscador, 0, -4);

$buscaCartas = "SELECT 
									nombre,
									apellido,
									IdCarta,
									destinatario1,
									destinatario2,
									destinatario3,
									destinatario4,
									destinatario5,
									asunto,
									fecha,
									firmante,
									cartas.IdUsuario,
									enviada,
									cartas.cargo,
									fenvio,
									email,
									radicado,
									ano,
									consAno,
									anulada,
									carta,
									firmaAut			
							FROM
									(cartas
									LEFT JOIN usuarios ON cartas.IdUsuario = usuarios.IdUsuario)".$buscador1." ".$buscador."";
// echo $buscaCartas;
$resultadoCartas = mysql_query($buscaCartas, $datos) or die(mysql_error());

$filaCartas = mysql_fetch_assoc($resultadoCartas);
$totalfilas_buscaCartas = mysql_num_rows($resultadoCartas);

$buscaAnexos = "SELECT 
										IdAnexo, IdCarta, nombre, vinculo
								FROM
										anexoscartas  ";
$resultadoAnexos = mysql_query($buscaAnexos, $datos) or die(mysql_error());
$filaAnexos = mysql_fetch_assoc($resultadoAnexos);
$totalfilas_buscaAnexos = mysql_num_rows($resultadoAnexos);

$buscaAnos = "SELECT 
									ano
							FROM
									cartas
							GROUP BY ano";
$resultadoAnos = mysql_query($buscaAnos, $datos) or die(mysql_error());
$filaAnos = mysql_fetch_assoc($resultadoAnos);
$totalfilas_buscaAnos = mysql_num_rows($resultadoAnos);
?>
<?php
mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdUsuario, nombre, apellido from usuarios order by nombre, apellido";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

if($totalfilas_buscaCartas>0){
	do{

		$tablacartas[$filaCartas['IdCarta']]['creador']=$filaCartas['nombre']." ".$filaCartas['apellido'];
		$tablacartas[$filaCartas['IdCarta']]['destinatario']=$filaCartas['destinatario1']."<br>".$filaCartas['destinatario2']."<br>".$filaCartas['destinatario3']."<br>".$filaCartas['destinatario4'];
		$tablacartas[$filaCartas['IdCarta']]['firmante']=$filaCartas['firmante']."<br>".$filaCartas['cargo'];
		$tablacartas[$filaCartas['IdCarta']]['fecha']=$filaCartas['fecha'];
		$tablacartas[$filaCartas['IdCarta']]['asunto']=$filaCartas['asunto'];
		$tablacartas[$filaCartas['IdCarta']]['enviada']=$filaCartas['enviada'];
		$tablacartas[$filaCartas['IdCarta']]['fenvio']=$filaCartas['fenvio'];
		$tablacartas[$filaCartas['IdCarta']]['email']=$filaCartas['email'];
		$tablacartas[$filaCartas['IdCarta']]['radicado']=$filaCartas['radicado'];
		$tablacartas[$filaCartas['IdCarta']]['consecutivo']="CPA-".sprintf("%03d",$filaCartas['consAno'])."-".$filaCartas['ano'];
		$tablacartas[$filaCartas['IdCarta']]['anulada']=$filaCartas['anulada'];
		$tablacartas[$filaCartas['IdCarta']]['carta']=$filaCartas['carta'];

		$tablacartas[$filaCartas['IdCarta']]['firmaAut']=$filaCartas['firmaAut'];

		

	} while ($filaCartas = mysql_fetch_assoc($resultadoCartas));
}

do{

	if($tablacartas[$filaAnexos['IdCarta']]){
		$tablacartas[$filaAnexos['IdCarta']]['anexos'][$filaAnexos['IdAnexo']]['nombre']=$filaAnexos['nombre'];
		$tablacartas[$filaAnexos['IdCarta']]['anexos'][$filaAnexos['IdAnexo']]['vinculo']=$filaAnexos['vinculo'];
	}

} while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));

// echo "<pre>";
// print_r($tablacartas);
// echo "</pre>";

?>
<script>
	
	document.addEventListener('DOMContentLoaded', function() {
    
    var resultado = <?php
                    if(isset($_POST['boton'])){
                      echo 1;
                    }else{
                      echo 0;
                    }
                    ?>;
    if(resultado==1){
    	prueba();
    } 
  });
 
	function prueba(){
        
    var creador ="<?php 
    if($_POST){
      echo $_POST['creador'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('creador').value=creador;
    
    var firmante ="<?php 
    if($_POST){
      echo $_POST['firmante'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('firmante').value=firmante;
       
    var destinatario ="<?php 
    if($_POST){
      echo $_POST['destinatario'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('destinatario').value=destinatario;
             
    var asunto="<?php 
    if($_POST){
      echo $_POST['asunto'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('asunto').value=asunto;
		
		var desde="<?php 
    if($_POST){
      echo $_POST['desde'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('desde').value=desde;
    
    var hasta="<?php 
    if($_POST){
      echo $_POST['hasta'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('hasta').value=hasta;

		var desdeEnv="<?php 
    if($_POST){
      echo $_POST['desdeEnv'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('desdeEnv').value=desdeEnv;
    
    var hastaEnv="<?php 
    if($_POST){
      echo $_POST['hastaEnv'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('hastaEnv').value=hastaEnv;

		var enviadas="<?php
		if($_POST['enviadas']){
			echo $_POST['enviadas'];
		}
		?>";
		if(enviadas==1){
			document.getElementById('env-1').checked=true;
		}
		if(enviadas==2){
			document.getElementById('env-2').checked=true;
		}
		if(enviadas==3){
			document.getElementById('env-3').checked=true;
		}

		var radicadas="<?php
		if($_POST['radicadas']){
			echo $_POST['radicadas'];
		}
		?>";
		if(radicadas==1){
			document.getElementById('rad-1').checked=true;
		}
		if(radicadas==2){
			document.getElementById('rad-2').checked=true;
		}
		if(radicadas==3){
			document.getElementById('rad-3').checked=true;
		}

		var anuladas="<?php
		if($_POST['anuladas']){
			echo $_POST['anuladas'];
		}
		?>";
		if(anuladas==1){
			document.getElementById('anu-1').checked=true;
		}
		if(anuladas==2){
			document.getElementById('anu-2').checked=true;
		}
		if(anuladas==3){
			document.getElementById('anu-3').checked=true;
		}

		var ano="<?php 
    if($_POST){
      echo $_POST['ano'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('ano').value=ano;

		var consAno="<?php 
    if($_POST){
      echo $_POST['consAno'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('consAno').value=consAno;
		
  }
  
	function subeRadicado1(){
		var radicado = document.getElementById('m-radicado').files[0];
		var opcion = document.getElementById('m-opcion').value;
		var id = document.getElementById('m-id').value;
		var fradicado = document.getElementById('m-fradicado').value;

		if(opcion==2 && !fradicado){
			document.getElementById('m-fradicado').focus();
			swal({
				 html: '¡Debe seleccionar la fecha del radicado!',
				 type: "error",
				 showConfirmButton: true,
				 confirmButtonText: "Cerrar"
				 }).then(function(result){
				 if (result.value) {					 
				 }
			 });
			return
		}

    if(!radicado){
			document.getElementById('m-radicado').focus();
			swal({
				 html: '¡Debe seleccionar el radicado!',
				 type: "error",
				 showConfirmButton: true,
				 confirmButtonText: "Cerrar"
				 }).then(function(result){
				 if (result.value) {					 
				 }
			 });
			return
		}

		var datos = new FormData();
    datos.append("radicado",radicado);
		datos.append("opcion",opcion);
		datos.append("id",id);
		datos.append("fradicado",fradicado);
    datos.append("proced",3);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          var res = respuesta.trim();
          if(res=='ok'){
						$('#subirRadicado').modal('hide');
						swal({
							html: '¡Radicado subido con exito!',
							type: "success",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
						if (result.value) {	
							window.location.reload();
						}
						});
            
          }
				}
			});
	}

	function subeRadicado(opcion,id){

		document.getElementById('m-radicado').value='';
		document.getElementById('m-fradicado').value='';
		document.getElementById('m-opcion').value=opcion;
		document.getElementById('m-id').value=id;

		document.getElementById('div-radicado').classList.remove('span-1', 'span-2');

		if(opcion==1){
			document.getElementById('div-fecRad').style.display='none'
			document.getElementById('div-radicado').classList.add('span-2')
		}
		if(opcion==2){
			document.getElementById('div-fecRad').style.display=''
			document.getElementById('div-radicado').classList.add('span-1')

		}

		

		$('#subirRadicado').modal({backdrop: 'static', keyboard: false});

	}


  function validarArchivo1(archivo){
          
    if((archivo[0]["size"] > 1100000) || (archivo[0]["type"]!="application/pdf") ){
          
      $("#m-radicado").val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1000B y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
    }
  }

	function eliminar(cons,id){
		$('#m-consec').html(cons)
		$('#m-id2').val(id)
		$('#confEliminacion').modal({backdrop: 'static', keyboard: false});		
	}

	function eliminar2(){
		var IdCarta = document.getElementById('m-id2').value;

		var datos = new FormData();
    datos.append("IdCarta",IdCarta);
    datos.append("proced",4);

		$.ajax({
			url:"ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){
				var res = respuesta.trim();
				// console.log(res)
				if(res=='ok'){
					$('#confEliminacion').modal('hide');
					swal({
						html: '¡La carta ha sido eliminada!',
						type: "success",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
					if (result.value) {	
						window.location.reload();
					}
					});
					
				}
			}
		});
	}

</script>
<style>
	.div-form{
		padding-top: 4px;
		padding-bottom: 4px;
		padding-left: 10px;
		padding-right: 10px;
	}	
</style>
<?php 
include('encabezado1.php');	
?>
<div class="contenedor" align="center">
	<h4 align="center" class="Century">CONSULTA DE CARTAS</h4>
	<br>
	<form action="reporte.php" method="post">
		<div class="grid columna-6" style="width: 800px" align="left">					
			<div class="span-1">
				Creador:
			</div>
			<div class="span-2">
				<select name="creador" id="creador" class="campo-xs Arial12">
					<option value="">Seleccione</option>
					<?php
					do {  
						?>
						<option value="<?php echo $row_Recordset4['IdUsuario']?>"><?php echo $row_Recordset4['nombre']." ".$row_Recordset4['apellido']?></option>
						<?php
					} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
					$rows = mysql_num_rows($Recordset4);
					if($rows > 0) {
						mysql_data_seek($Recordset4, 0);
						$row_Recordset4 = mysql_fetch_assoc($Recordset4);
					}
					?>
				</select>
			</div>	
			<div class="span-1">
				Firmante:
			</div>
			<div class="span-2">
				<input type="text" name="firmante" id="firmante" class="campo-xs Arial12">
			</div>			
			<div class="span-1">
				Destinatario:
			</div>
			<div class="span-2">
				<input type="text" name="destinatario" id="destinatario" class="campo-xs Arial12">
			</div>	
			<div class="span-1">
				Asunto:
			</div>
			<div class="span-2">
				<input type="text" name="asunto" id="asunto" class="campo-xs Arial12">
			</div>
		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 800px">
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de creación
					</div>
					<div class="span-1">
						Desde:
						<input type="date" name="desde" id="desde" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hasta" id="hasta" class="campo-xs Arial12">
					</div>
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de envio
					</div>
					<div class="span-1">
						Desde
						<input type="date" name="desdeEnv" id="desdeEnv" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta
						<input type="date" name="hastaEnv" id="hastaEnv" class="campo-xs Arial12">
					</div>							
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Consecutivo
					</div>
					<div class="span-1">
						Año
						<select name="ano" id="ano" class="campo-xs Arial12">
							<option value="">Seleccione</option>
							<?php 
							do{
								?>
								<option value="<?php echo $filaAnos['ano'] ?>"><?php echo $filaAnos['ano'] ?></option>
								<?php
							} while ($filaAnos = mysql_fetch_assoc($resultadoAnos));
							?>
						</select>
					</div>
					<div class="span-1">
						Numero
						<input type="number" name="consAno" id="consAno" class="campo-xs Arial12">
					</div>							
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-4" align="left" style="grid-row-gap: 3px">
					<div class="span-3">
						Enviadas
					</div>
					<div class="span-1">
						<input type="radio" name="enviadas" id="env-1" value="1">
					</div>
					<div class="span-3">
						Sin Enviar
					</div>
					<div class="span-1">
						<input type="radio" name="enviadas" id="env-2" value="2" >
					</div>
					<div class="span-3">
						Todas
					</div>
					<div class="span-1">
						<input type="radio" name="enviadas" id="env-3" value="3" >
					</div>
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-4" align="left" style="grid-row-gap: 3px">
					<div class="span-3">
						Con Radicado
					</div>
					<div class="span-1">
						<input type="radio" name="radicadas" id="rad-1" value="1" >
					</div>
					<div class="span-3">
						Sin Radicar
					</div>
					<div class="span-1">
						<input type="radio" name="radicadas" id="rad-2" value="2" >
					</div>
					<div class="span-3">
						Todas
					</div>
					<div class="span-1">
						<input type="radio" name="radicadas" id="rad-3" value="3" >
					</div>
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-4" align="left" style="grid-row-gap: 3px">
					<div class="span-3">
						Sin eliminar
					</div>
					<div class="span-1">
						<input type="radio" name="anuladas" id="anu-1" value="1" checked>
					</div>
					<div class="span-3">
						Eliminadas
					</div>
					<div class="span-1">
						<input type="radio" name="anuladas" id="anu-2" value="2" >
					</div>
					<div class="span-3">
						Todas
					</div>
					<div class="span-1">
						<input type="radio" name="anuladas" id="anu-3" value="3" >
					</div>
				</div>
			</div>
			<div class="span-6" align="right">
				<button type="submit" name="boton" class="btn btn-verde btn-xs">Buscar</button>
				<button type="reset" class="btn btn-rojo btn-xs pull-left">Limpiar Filtro</button>
			</div>
		</div>
	</form>
</div>
<div class="contenedor" align="center">
<?php 
if(isset($_POST['boton'])){
	?>
	<div class="contenedor" style="width: 1200px">
		<table class="tablita" align="center" border="1" width="100%">
			<!-- <col width="220px">
			<col width="300px">
			<col width="100px">
			<col width="100px">
			<col width="100px">
			<col width="70px"> -->
			<tbody>
				<tr class="Arial14 titulos">
					<td>CONSECUTIVO</td>
					<td>CREADOR</td>
					<td>FIRMANTE</td>
					<td>DESTINATARIO</td>
					<td width="100px">FECHA CREACION</td>
					<td width="100px">FECHA ENVIO</td>
          <td>ASUNTO</td>
					<td width="95px">ANEXOS</td>
					<td width="95px">ACCIONES</td>
					<td width="95px">VER</td>
				</tr>
				<?php
					if($tablacartas){
						foreach($tablacartas as $key=>$j){
							?>
							<tr class="Arial12">
								<td valign="top"><?php echo $j['consecutivo']; ?></td>
								<td valign="top"><?php echo $j['creador']; ?></td>
								<td valign="top"><?php echo $j['firmante']; ?></td>
								<td valign="top"><?php echo $j['destinatario']; ?></td>								
								<td valign="top" align="center"><?php echo fechaactual3($j['fecha']); ?></td>
								<td valign="top" align="center"><?php echo $j['fenvio'] ? fechaactual3($j['fenvio']) : "Sin enviar"; ?></td>
                <td valign="top"><?php echo $j['asunto']; ?></td>
								<td valign="top">
									<?php
									if($tablacartas[$key]['anexos']){
										foreach($tablacartas[$key]['anexos'] as $llave=>$i){
											echo $i['nombre'];
											?>
											<a href="<?php echo $i['vinculo'] ?>" class="btn btn-rosa btn-xs1 btn-block" target="_blank" style="margin:0">Ver anexo</a>
											<?php
										}
									}else{
										echo "SIN ANEXOS";
									}
									?>
								</td>
								<td valign="top" align="center">
									
									<?php 
									if($j['enviada']==0 and $j['anulada']==0){
										if($j['firmaAut']==0){
											?>
											<a href="editaCarta.php?carta=<?php echo $key?>" class="btn btn-verde btn-xs1 btn-block" target="_blank" style="margin-top:2px">Editar carta</a>
											<?php
										}
										if($j['firmaAut']==1){
											if($j['email']){
												?>
												<a href="enviaCarta.php?carta=<?php echo $key?>" class="btn btn-verde btn-xs1 btn-block" target="_blank" style="margin-top:2px">Enviar carta</a>
												<?php
											}
										}
										
									}
									if($j['enviada']==1 and !$j['radicado'] and $j['anulada']==0){
										?>
										<button type="button" class="btn btn-verde btn-xs1 btn-block" onClick="subeRadicado(1,<?php echo $key?>)" style="margin-top:2px">Subir Radicado</button>
										<?php
									}
									if(!$j['email'] and !$j['radicado'] and $j['anulada']==0){
										?>
										<button type="button" class="btn btn-verde btn-xs1 btn-block" onClick="subeRadicado(2,<?php echo $key?>)"style="margin-top:2px">Subir Radicado</button>
										<?php
									}
									if($j['anulada']==0 and $j['enviada']==0){
										?>
										<button type="button" class="btn btn-rojo btn-xs1 btn-block" onClick="eliminar('<?php echo $j['consecutivo']?>',<?php echo $key?>)"style="margin-top:2px">Eliminar</button>
										<?php
									}
									?>
								</td>
								<td valign="top" align="center">
									<?php 
									if($j['carta']){
										?>
										<a href="<?php echo $j['carta']?>" class="btn btn-rosa btn-xs1 btn-block" target="_blank" style="margin-top:2px">Ver carta</a>
										<?php
									} 
									if($j['radicado']){
										?>
										<a href="<?php echo $j['radicado'] ?>" class="btn btn-rosa btn-xs1 btn-block" target="_blank" style="margin-top:2px">Ver radicado</a>
										<?php
									}
									?>
								</td>   
							</tr>	
							<?php
						}
					}else{
						?>
						<tr>
							<td colspan="9" align="center">NO HAY SOLICITUDES QUE COINCIDAN CON LOS PARAMETROS DE BUSQUEDA</td>
						</tr>
						<?php
					}
					?>        
				</tbody>
			</table>
	</div>	
	<?php
}	
?>

<br><br>
  
</div>

<div id="subirRadicado" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">SUBIR RADICADO</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
			<div class="modal-body">
        <div>
					<input type="hidden" id="m-opcion">
					<input type="hidden" id="m-id">
					<div class="grid columna-2">
						<div class="span-1" id="div-fecRad" style="display:none">
							Fecha del Radicado
							<input type="date" class="campo-xs" id="m-fradicado">
						</div>
						<div class="span-1" id="div-radicado">
							Formato PDF max 1000B
          		<input type="file" name="m-radicado" id="m-radicado"  class="campo-xs Arial12" onChange="validarArchivo1(this.files)" >
						</div>
					</div>
					<br>
					<div align="center">
						<button type="button" class="btn btn-rosa btn-sm"  onClick="subeRadicado1()">Subir</button>
					</div>
          
        </div>	
			</div>
			<div class="modal-footer">					
				<button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cerrar</button>
			</div>
    </div>
  </div>
</div>

<div id="confEliminacion" class="modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" style="width: 500px">
		<div class="modal-content">
			<!-- <div class="modal-header" style="background:#d8d8d8; color:black;padding: 10px">
				<h5 class="modal-title Century">Cambiar Entidad</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div> -->
			<div class="modal-body" align="center">
        <img src="../imagenes/Icono-Alerta.png" width="100px">
        <br><br>
        <h5 align="center">¡VA A ELIMINAR LA CARTA CON CONSECUTIVO!</h5>
				<h5 align="center" id="m-consec" class="rojo" ></h5>
				<input type="hidden" id="m-id2">
        <br>
        <div class="grid columna-2" style="width: 300px" id="seleccion">
          <div class="span-1">
            <button type="button" class="btn btn-azul btn-sm btn-block" data-dismiss="modal" >NO</button>
          </div>
          <div class="span-1">
            <button type="button" class="btn btn-rojo btn-sm btn-block" onClick="eliminar2()" >SI</button>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>

<?php 
	mysql_close($datos);
						 
include('footer.php');
?>


</body>
</html>
<?php

mysql_free_result($Recordset4);

?>
