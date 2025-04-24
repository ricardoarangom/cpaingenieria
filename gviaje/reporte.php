<?php require('../connections/datos.php');?>
<?php 
include('encabezado.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// echo $nivel." ".$snivel;

if(!$_POST['proyecto'] and !$_POST['solicitante'] and !$_POST['dsolicitud'] and !$_POST['hsolicitud'] and !$_POST['dpago'] and !$_POST['hpago'] and !$_POST['dautorizado'] and !$_POST['hautorizado'] and $_POST['rechazada']==2){
	$buscador1="";
}else{
	$buscador1="where ";

	if($_POST['proyecto']){
		$buscador.=" gviaje.IdArea=".$_POST['proyecto']." and ";
	}
	if($_POST['solicitante']){
		$buscador.=" IdSolicitante=".$_POST['solicitante']." and ";
	}
	if($_POST['dsolicitud']){
		$buscador.=" fsolicitud>='".$_POST['dsolicitud']."' and ";
	}
	if($_POST['hsolicitud']){
		$buscador.=" fsolicitud<='".$_POST['hsolicitud']."' and ";
	}
	
	if($_POST['dautorizado']){
		$buscador.=" fautorizacion>='".$_POST['dautorizado']."' and ";
	}
	if($_POST['hautorizado']){
		$buscador.=" fautorizacion<='".$_POST['hautorizado']."' and ";
	}
  
  if($_POST['dpago']){
    $buscador.=" fpago>='".$_POST['dpago']."' and ";
  }
	if($_POST['hpago']){
    $buscador.=" fpago<='".$_POST['hpago']."' and ";
  }

	if($_POST['rechazada']==0){
		$buscador.=" fautorizacion is not null and rechazada=0 and ";
	}

	if($_POST['rechazada']==1){
		$buscador.=" fautorizacion is not null and rechazada=1 and ";
	}
}
$buscador=substr($buscador, 0, -4);
// echo $buscador;

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
?>
<?php
mysql_select_db($database_datos, $datos);
$query_Recordset1 = "SELECT gviaje.IdGviaje, nombre, apellido, area, ccostos, municipio, departamentos, fsalida, fregreso, actividad, fsolicitud, fautorizacion, fpago, rechazada, total, certificacion, beneficiario, soporte, legalizado  FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join totgviaje on gviaje.IdGviaje=totgviaje.IdGviaje ".$buscador1.$buscador." order by IdGviaje";
// echo $query_Recordset1;
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT IdArea, area, ccostos from areas order by ccostos";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdUsuario, nombre, apellido from usuarios";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$buscaMunicipios="SELECT IdMunicipio, municipio from municipios";
$resultado=mysql_query($buscaMunicipios, $datos);
$fila_Municipio=mysql_fetch_assoc($resultado);

if($totalRows_Recordset1>0){
	do{
		if($row_Recordset1['fautorizacion']){
			if($row_Recordset1['rechazada']==1){
				$aprob="NO";
			}else{
				$aprob="SI";
			}
		}else{
			$aprob="";
		}
		if($row_Recordset1['fpago']){
			if($row_Recordset1['legalizado']==0){
				$legal="NO";
			}else{
				$legal="SI";
			}
		}else{
			$legal="";
		}

		$tabla[$row_Recordset1['IdGviaje']]['fsolicitud']=$row_Recordset1['fsolicitud'];
		$tabla[$row_Recordset1['IdGviaje']]['solicitante']=$row_Recordset1['nombre']." ".$row_Recordset1['apellido'];
		$tabla[$row_Recordset1['IdGviaje']]['beneficiario']=$row_Recordset1['beneficiario'];
		$tabla[$row_Recordset1['IdGviaje']]['area']=$row_Recordset1['ccostos']." - ".$row_Recordset1['area'];
		$tabla[$row_Recordset1['IdGviaje']]['actividad']=$row_Recordset1['actividad'];
		$tabla[$row_Recordset1['IdGviaje']]['fsalida']=$row_Recordset1['fsalida'];
		$tabla[$row_Recordset1['IdGviaje']]['fregreso']=$row_Recordset1['fregreso'];
		$tabla[$row_Recordset1['IdGviaje']]['municipio']=$row_Recordset1['municipio'];
		$tabla[$row_Recordset1['IdGviaje']]['departamento']=$row_Recordset1['departamentos'];
		$tabla[$row_Recordset1['IdGviaje']]['total']=$row_Recordset1['total'];
		$tabla[$row_Recordset1['IdGviaje']]['fautorizacion']=$row_Recordset1['fautorizacion'];
		$tabla[$row_Recordset1['IdGviaje']]['fpago']=$row_Recordset1['fpago'];
		$tabla[$row_Recordset1['IdGviaje']]['aprob']=$aprob;
		$tabla[$row_Recordset1['IdGviaje']]['legal']=$legal;
		$tabla[$row_Recordset1['IdGviaje']]['soporte']=$row_Recordset1['soporte'];
    $tabla[$row_Recordset1['IdGviaje']]['total']=$row_Recordset1['total'];

	}while($row_Recordset1 = mysql_fetch_assoc($Recordset1));

}


do{
  $tablaMun[$fila_Municipio['IdMunicipio']]=$fila_Municipio['municipio'];
} while ($fila_Municipio=mysql_fetch_assoc($resultado));

$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);

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
    var proyecto ="<?php 
    if($_POST){
      echo $_POST['proyecto'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('proyecto').value=proyecto;
    
    var solicitante ="<?php 
    if($_POST){
      echo $_POST['solicitante'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('solicitante').value=solicitante;
    
    var dsolicitud ="<?php 
    if($_POST){
      echo $_POST['dsolicitud'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('dsolicitud').value=dsolicitud;
       
    var hsolicitud ="<?php 
    if($_POST){
      echo $_POST['hsolicitud'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('hsolicitud').value=hsolicitud;
             
    var dautorizado="<?php 
    if($_POST){
      echo $_POST['dautorizado'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('dautorizado').value=dautorizado;
		
		var hautorizado="<?php 
    if($_POST){
      echo $_POST['hautorizado'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('hautorizado').value=hautorizado;
    
    var dpago="<?php 
    if($_POST){
      echo $_POST['dpago'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('dpago').value=dpago;

		var hpago="<?php 
    if($_POST){
      echo $_POST['hpago'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('hpago').value=hpago;

		var rechazada = <?php echo $_POST['rechazada'] ?>;
     
		$('#recha-'+rechazada).prop("checked", true);
		
  }
  
  function revLeg(id){
		var tabla = '<?php echo $cadenaTabla?>';
		var arregloTabla = JSON.parse(tabla);

		var arregloFecha = arregloTabla[id]['fpago'].split("-");

		let fecha = new Date(arregloFecha[0], arregloFecha[1]-1, arregloFecha[2]);
		let opciones = { year: 'numeric', month: 'short', day: 'numeric' };
		let fechaFormateada = fecha.toLocaleDateString('es-ES', opciones);

		$('#mod-IdSolicitud').html(id)
		$('#mod-solicitante').html(arregloTabla[id]['solicitante'])
		$('#mod-area').html(arregloTabla[id]['area'])
		$('#mod-actividad').html(arregloTabla[id]['actividad'])
		$('#mod-beneficiario').html(arregloTabla[id]['beneficiario'])
		$('#mod-destino').html(arregloTabla[id]['municipio']+' - '+arregloTabla[id]['departamento'])
		$('#mod-fpago').html(fechaFormateada)
		$('#mod-IdSolicitud1').val(id)

		$('#reversarLeg').modal({backdrop: 'static', keyboard: false}); 
	}

	function reversar(){
		var id = document.getElementById('mod-IdSolicitud1').value;

		var datos = new FormData();
		datos.append("IdGviaje",id);
		datos.append("proced",4);

		$.ajax({

url:"ajax.php",
method: "POST",
data: datos,
cache: false,
contentType: false,
processData: false,
success: function(respuesta){
	console.log(respuesta)
	var res = respuesta.trim()
	
	if(res == "ok"){
		
		swal({
			title: "",
			text: "¡La legalización ha sido reversada!",
			type: "success",
			confirmButtonText: "¡Cerrar!"
		}).then(function(isConfirm){
			if(isConfirm){
				location.reload();
			}
		});

	}
}
})
	}
</script>
<style>
	body {
    min-width: 1840px;
  }
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
	<h4 align="center" class="Century">CONSULTA SOLICITUDES DE GASTOS DE VIAJE</h4>
	<br>
	<form action="reporte.php" method="post">
		<div class="grid columna-6" style="width: 800px" align="left">
			<div class="span-1">
				Proyecto/Area
			</div>
			<div class="span-2">
				<select name="proyecto" id="proyecto" class="campo-xs Arial12" >
					<option value="">Seleccione</option>
					<?php
					do {  
						?>
						<option value="<?php echo $row_Recordset3['IdArea']?>"><?php echo $row_Recordset3['ccostos']?> - <?php echo $row_Recordset3['area']?></option>
													<?php
					} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
					$rows = mysql_num_rows($Recordset3);
					if($rows > 0) {
						mysql_data_seek($Recordset3, 0);
						$row_Recordset3 = mysql_fetch_assoc($Recordset3);
					}
					?>							
				</select>
			</div>
			
				<?php 
				if($nivel==2){
					?>
					<div class="span-1">
						<input type="hidden" name="solicitante" id="solicitante" value="<?php echo $usuario ?>" >
					</div>	
					<?php
				}else{
					?>
					<div class="span-1">
						Solicitante:
					</div>
					<div class="span-2">
						<select name="solicitante" id="solicitante" class="campo-xs Arial12">
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
					<?php
				}
				?>			
		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 800px">
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de solicitud
					</div>
					<div class="span-1">
						Desde:
						<input type="date" name="dsolicitud" id="dsolicitud" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hsolicitud" id="hsolicitud" class="campo-xs Arial12">
					</div>
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de Autorización
					</div>
					<div class="span-1">
						Desde
						<input type="date" name="dautorizado" id="dautorizado" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta
						<input type="date" name="hautorizado" id="hautorizado" class="campo-xs Arial12">
					</div>
				</div>
			</div>
      <div class="span-2 div-form borde-div-g" style="border-radius: 5px">
        <div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
          <div class="span-2">
						Fecha de Pago
					</div>
          <div class="span-1">
						Desde:
						<input type="date" name="dpago" id="dpago" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hpago" id="hpago" class="campo-xs Arial12">
					</div>
        </div>
      </div>
			<div class="span-6">
				<div class="grid columna-3">
					<div class="span-1">
						Aprobadas&nbsp;&nbsp;
            <input type="radio" name="rechazada" id="recha-0" value="0">
					</div>
					<div class="span-1">
						Rechazadas&nbsp;&nbsp;
            <input type="radio" name="rechazada" id="recha-1" value="1">
					</div>
					<div class="span-1">
						Todas&nbsp;&nbsp;
            <input type="radio" name="rechazada" id="recha-2" value="2" checked>
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
<br>
<?php 
if(isset($_POST['boton'])){
	?>
	<div class="contenedor-ancho" style="width: 1840px" align="center">
		Registros encontrados&nbsp;<?php echo $totalRows_Recordset1 ?>
		<table border="1" class="tablita Arial13" align="center">
			<col width="35px">
			<col width="80px">
			<col width="210px">
			<col width="205px">
			<col width="230px">
			<col width="250px">
			<col width="80px">
			<col width="80px">
			<col width="130px">
			<col width="75px">
			<col width="80px">
			<col width="80px">
			<col width="60px">
			<col width="60px">
			<col width="60px">
			<col width="80px">
			<tbody>
				<tr class="Arial13 titulos" >
					<td align="center">No. Sol.</td>
					<td align="center">FECHA SOLICITUD</td>
					<td align="center">SOLICITANTE</td>
					<td align="center">QUIEN VIAJA</td>
					<td align="center">AREA/PROYECTO</td>
					<td align="center">ACTIVIDAD</td>
					<td align="center">FECHA SALIDA</td>
					<td align="center">FECHA REGRESO</td>
					<td align="center">DESTINO</td>
					<td align="center">TOTAL</td>
					<td align="center">FECHA AUTORIZ.</td>
					<td align="center">FECHA DE PAGO</td>
					<td align="center">APROB.</td>
					<td align="center">LEGAL.</td>
					<td align="center">ANT</td>
					<td align="center">Soporte PG</td>
				</tr>
				<?php
				if($tabla){
					foreach($tabla as $key=>$j){
						?>
						<tr class="Arial12">
							<td align="right" valign="top"><?php echo $key ?></td>
							<td align="center" valign="top"><?php echo fechaactual3($j['fsolicitud']); ?></td>
							<td valign="top"><?php echo $j['solicitante'] ?></td>
							<td valign="top"><?php echo $j['beneficiario'] ?></td>
							<td valign="top"><?php echo $j['area']?></td>
							<td valign="top"><?php echo $j['actividad']; ?></td>
							<td align="center" valign="top"><?php echo fechaactual3($j['fsalida']); ?></td>
							<td align="center" valign="top"><?php echo fechaactual3($j['fregreso']); ?></td>
							<td valign="top"><?php echo $j['municipio']; ?><br><?php echo $j['departamento']; ?></td>
							<td valign="top" align="right"><?php echo number_format($j['total']) ?></td>
							<td align="center" valign="top"><?php echo $j['fautorizacion'] ? fechaactual3($j['fautorizacion']) : ""; ?></td>
							<td align="center" valign="top"><?php echo $j['fpago'] ? fechaactual3($j['fpago']) : ""; ?></td>
							<td align="center" valign="top"><?php echo $j['aprob']  ?></td>
							<?php
							if(($nivel == 3 and $snivel==1) or $nivel==0){
								if($j['legal']=='SI'){
									?>
									<td align="center" valign="top" style="cursor:pointer" onClick="revLeg(<?php echo $key ?>)"><?php echo $j['legal']  ?></td>
									<?php
								}else{
									?>
									<td align="center" valign="top"><?php echo $j['legal']  ?></td>
									<?php
								}								
							}else{
								?>
								<td align="center" valign="top"><?php echo $j['legal']  ?></td>
								<?php
							}
							?>							
							<td>
								<a href="gviaje-pdf.php?gviaje=<?php echo $key ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver PDF</a>
							</td>
							<td>
								<?php
								if($j['soporte']){
									?>
									<a href="<?php echo $j['soporte']?>" class="btn btn-rosa btn-xs1" target="_blank">Ver Soporte</a>
									<?php
								}
								?>								
							</td>
						</tr>
						<?php						
					}
					?>
					<tr>
						<td align="right" colspan="16" style="border-bottom-color: #ffffff;border-left-color: #ffffff;border-right-color: #FFFFFF">
							<form action="reporte-ex.php" method="post" target="_blank">
								<input type="hidden" name="tabla" value="<?php echo  base64_encode(serialize($tabla)); ?>">
								<button type="submit" class="btn btn-verde btn-xs1">Generar Excel</button>            
							</form>
						</td>
					</tr>
					<?php
				}else{
					?>
					<tr>
						<td colspan="16" align="center">NO HAY SOLICITUDES QUE COINCIDAN CON LOS PARAMETROS DE BUSQUEDA</td>
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

<?php 
	mysql_close($datos);
						 
include('footer.php');
?>

<div id="reversarLeg" class="modal fade" role="dialog">
  <div class="modal-dialog">    
    <div class="modal-content">
        <div class="modal-header" style="background:#d8d8d8; color:black">
            <h5 class="modal-title">Rechazo solicitud gastos de viajes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <h6 class="Cemtury" align="center">SE VA A REVERSAR LA LEGALIZACION DE LA SOLICITUD DE GASTOS DE VIAJE</h6>
					<table class="tablita Arial12">
						<tr>
							<td>Sol No:</td>
							<td id="mod-IdSolicitud"></td>
						</tr>
						<tr>
							<td>Solicitante:</td>
							<td id="mod-solicitante"></td>
						</tr>
						<tr>
							<td>Area:</td>
							<td id="mod-area"></td>
						</tr>
						<tr>
							<td>Actividad:</td>
							<td id="mod-actividad"></td>
						</tr>
						<tr>
							<td>Quien viaja:</td>
							<td id="mod-beneficiario"></td>
						</tr>
						<tr>
							<td>Destino</td>
							<td id="mod-destino"></td>
						</tr>
						<tr>
							<td>Fecha de Pago</td>
							<td id="mod-fpago"></td>
						</tr>
					</table>
			    <input type="hidden" name="solicitud"  id="mod-IdSolicitud1" value="">
          <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-rosa btn-xs" onClick="reversar()">Reversar</button>
          <button type="button" class="btn btn-default btn-xs pull-left" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
  </div>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
