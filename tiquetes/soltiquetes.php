<?php require_once('../connections/datos.php'); ?>
<?php 
session_start();
$usuario=$_SESSION['IdUsuario'];
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

$var1_Recordset1 = "0";
if (isset($usuario)) {
  $var1_Recordset1 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT IdUsuario, nombre, apellido FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "-1";
if (isset($usuario)) {
  $var1_Recordset2 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT area, IdArea, IdEmpresa, ccostos FROM areas WHERE IdDirector=%s UNION ALL SELECT area, IdArea, IdEmpresa, ccostos FROM areas WHERE IdSubdirector=%s ORDER BY ccostos", GetSQLValueString($var1_Recordset2, "int"),GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT area, IdArea, IdEmpresa, ccostos FROM areas WHERE IdArea<>0 ORDER BY ccostos";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset5 = "SELECT IdDepartamento, departamentos FROM departamentos order by departamentos";
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_datos, $datos);
$query_Recordset6 = "SELECT IdMunicipio, municipio, IdDepartamento  FROM municipios";
$Recordset6 = mysql_query($query_Recordset6, $datos) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

do{
	$municipios[$row_Recordset6['IdMunicipio']]['Id']=$row_Recordset6['IdMunicipio'];
	$municipios[$row_Recordset6['IdMunicipio']]['municipio']=$row_Recordset6['municipio'];
	$municipios[$row_Recordset6['IdMunicipio']]['IdDepartamento']=$row_Recordset6['IdDepartamento'];
} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));
mysql_free_result($Recordset6);

do{
	$departamento[$row_Recordset5['IdDepartamento']]=$row_Recordset5['departamentos'];
} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
mysql_free_result($Recordset5);



//echo "<pre>";
//print_r($municipios);
//echo "</pre>";
$tablamunicipios=json_encode($municipios);
?>
<?php 
include('encabezado.php')
?>
<script>

	function buscaEmpresa(area){
		
		var datos = new FormData();
		datos.append("area",area);
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
					document.getElementById('empresa').value=respuesta;
				}
		});
	}

	function aMayusculas(obj,id){
    obj = obj.toUpperCase();
    document.getElementById(id).value = obj;
	}
	
	function muestraPeso(valor,id){
		var arregloId = id.split("-");
		if(valor==3){
			document.getElementById('divkgst-'+arregloId[1]).style.display='';
			document.getElementById('divkgsc-'+arregloId[1]).style.display='';
		}else{
			document.getElementById('divkgst-'+arregloId[1]).style.display='none';
			document.getElementById('divkgsc-'+arregloId[1]).style.display='none';
		}
	}
	
	function buscamun(valor,id){
		var arregoId = id.split("-");
		var cadena = '<?php echo $tablamunicipios ?>';
		var arreglo = JSON.parse(cadena);
		var fila = '';
				
		fila = fila + '<select name="trayecto['+arregoId[2]+'][mun'+arregoId[1]+']" id="mun-'+arregoId[1]+'-'+arregoId[2]+'" class="campo-xs Arial12">';
		fila = fila + '<option value="">Seleccione</option>';
		Object.keys(arreglo).forEach(key => {
			if(valor==arreglo[key]['IdDepartamento']){
				fila = fila + '<option value="'+arreglo[key]['Id']+'">'+arreglo[key]['municipio']+'</option>'; 
			}
				
		});
		fila = fila + '</select>';
		$('#divm-'+arregoId[1]+'-'+arregoId[2]).html(fila)
	}
	
	function selTipo(valor){
		var fila = '';
		console.log(valor)
		if(valor==0){
			$('#cuerpo').html(fila);
			document.getElementById('cuerpo1').style.display='none';
			document.getElementById('contador').value=1;
		}
		if(valor==1){
			document.getElementById('cuerpo1').style.display='none';
			document.getElementById('contador').value=1
			fila = fila + '<div class="grid columna-2 peq-columna-1" id="regreso" style=" grid-row-gap:5px;">'+
											'<div class="span-2 peq-span-1" align="center">'+
												'<strong>Información del Regreso</strong> </div>'+
												'<input type="hidden" name="trayecto[2][muno]" class="campo-xs Arial12" value="0">'+
												'<input type="hidden" name="trayecto[2][mund]" class="campo-xs Arial12" value="0">'+
												'<div class="span-1 peq-span-1">'+
													'Fecha'+
												'</div>'+
												'<div class="span-1 peq-span-1">'+
													'<input type="date" name="trayecto[2][fecha]" class="campo-xs Arial12" required>'+
												'</div>'+
												'<div class="span-1 peq-span-1">'+
													'Jornada'+
												'</div>'+
												'<div class="span-1 peq-span-1">'+													
													'<select name="trayecto[2][jornada]" id="" class="campo-xs Arial12" required>'+
														'<option value="">Seleccione</option>'+
														'<option value="0">Madrugada</option>'+
														'<option value="1">Mañana</option>'+
														'<option value="2">Tarde</option>'+
														'<option value="3">Noche</option>'+
													'</select>'+
												'</div>'+
													
											'</div>';
			$('#cuerpo').html(fila);
		}
		
		if(valor==2){
			document.getElementById('cuerpo1').style.display='';
			
			$('#cuerpo').html(fila);
		}
	}
	
	function agregaTrayecto(){
		var contador = document.getElementById('contador').value;
		var a = parseFloat(contador) + 1;
		var fila = '';	
		
		fila = fila + '<h6>Trayecto '+a+'</h6>'+
									'<div class="grid columna-2 peq-columna-1" style=" grid-row-gap:5px;">'+ 	
										'<div class="span-1 peq-span-1">'+
											'Depto Origen'+
										'</div>'+			
										'<div class="span-1 peq-span-1">'+											
											'<select name="" id="dep-o-'+a+'" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">'+
												'<option value="">Seleccione</option>'+
													<?php
													foreach($departamento as $key=>$j){
														?>
														'<option value="<?php echo $key?>"><?php echo $j ?></option>'+
														<?php
													}
													?>
											'</select>'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'Municipio Origen'+
										'</div>'+
										'<div class="span-1 peq-span-1" id="divm-o-'+a+'">'+											
											'<select name="trayecto['+a+'][muno]" id="mun-o-'+a+'" class="campo-xs Arial12" onClick=verificaDpto(this.id) required>'+
												'<option value="">Seleccione</option>'+
											'</select>'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'Depto Destino'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+											
											'<select name="" id="dep-d-'+a+'" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">'+
												'<option value="">Seleccione</option>'+
												<?php
												foreach($departamento as $key=>$j){
													?>
														'<option value="<?php echo $key?>"><?php echo $j ?></option>'+
													<?php
												}
												?>
											'</select>'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'Municipio Destino'+
										'</div>'+
										'<div class="span-1 peq-span-1" id="divm-d-'+a+'">'+											
											'<select name="mund['+a+']" id="mun-d-'+a+'" class="campo-xs Arial12" onClick=verificaDpto(this.id) required>'+
												'<option value="">Seleccione</option>'+
											'</select>'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'Fecha'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'<input type="date" name="trayecto['+a+'][fecha]" class="campo-xs Arial12" required>'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'Jornada'+
										'</div>'+
										'<div class="span-1 peq-span-1">'+
											'<select name="trayecto['+a+'][jornada]" id="" class="campo-xs Arial12" required>'+
												'<option value="">Seleccione</option>'+
												'<option value="0">Madrugada</option>'+
												'<option value="1">Mañana</option>'+
												'<option value="2">Tarde</option>'+
												'<option value="3">Noche</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<br>'
			
			$('#cuerpo').append(fila);
			document.getElementById('contador').value=a;		
	}
	
	function agregaPasajero(){
		var contador = document.getElementById('contador2').value;
		var a = parseFloat(contador) + 1;
		var fila = '';
		
		fila = fila + '<h6>Pasajero '+a+'</h6>'+
									'<div class="grid columna-2 peq-columna-1" style=" grid-row-gap:5px;">'+
										'<div class="span-1">'+
											'Nombre'+
										'</div>'+
										'<div class="span-1">'+
												'<input type="text" class="campo-xs Arial12" name="pasajero['+a+'][nombre]" id="nombrep-'+a+'" onBlur="aMayusculas(this.value,this.id)" required>'+
										'</div>'+
										'<div class="span-1">'+
											'No cédula'+
										'</div>'+
										'<div class="span-1">'+
											'<input type="number" class="campo-xs Arial12" name="pasajero['+a+'][cedula]" required>'+
										'</div>'+
										'<div class="span-1">'+
											'Telefono'+
										'</div>'+
										'<div class="span-1">'+
											'<input type="number" class="campo-xs Arial12" name="pasajero['+a+'][telefono]" required>'+
										'</div>'+
										'<div class="span-1">'+
											'E-mail'+
										'</div>'+
										'<div class="span-1">'+
											'<input type="text" class="campo-xs Arial12" name="pasajero['+a+'][email]" required>'+
										'</div>'+
										'<div class="span-1">'+
											'Equipaje'+
										'</div>'+
										'<div class="span-1">'+
											'<select name="pasajero['+a+'][equipaje]" id="equipaje-'+a+'"  class="campo-xs Arial12" required>'+
												'<option value="">Seleccione</option>'+
												'<option value="1">De mano</option>'+
												'<option value="2">De cabina</option>'+
												'<option value="3">De bodega</option>'+
											'</select>'+
										'</div>'+
										'<div class="span-1">'+
											'Subir cédula (PDF max 1MB)'+
										'</div>'+
										'<div class="span-1">'+
											'<input type="file" name="cedula['+a+']" id="cedula-'+a+'" class="campo-xs Arial12" onChange="validarArchivo(this.files,this.id)" required>'+
										'</div>'+
									'</div>'+									
									'<br>'
		
		
		$('#cuerpo2').append(fila);
		document.getElementById('contador2').value=a;	
		
	}
	
	function verificaDpto(id){
		console.log(id);
		var arregloId = id.split("-");
		var deptoId = 'dep-'+arregloId[1]+'-'+arregloId[2];
		var depto = document.getElementById(deptoId).value;
		console.log(depto);
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
	
	function bloquear(id){
		document.getElementById(id).style.display='none'
		$(".espera").html(`
				<center>
					<img src="../imagenes/status.gif" id="status" />
					<br>
				</center>
								`);
	}
	
	function validarArchivo(archivo,id){
    if((archivo[0]["size"] > 1100000) || (archivo[0]["type"]!="application/pdf") ){

      $("#"+id).val("");

      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1.000K y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
      });
    }    
  }
</script>
<?php 
include('encabezado1.php')
?>
<br>
<h4 align="center" class="Century">SOLICITUD DE TIQUETES AEREOS</h4>
<br>
<div class="contenedor">
	<form method="post" action="graba.php" name="form1" onSubmit="bloquear('boton')" enctype="multipart/form-data" >
		<div class="contenedor grid columna-12 med-columna-6 peq-columna-1" style="max-width: 800px">
			<div class="span-3 peq-span-1">
				PROYECTO/AREA
			</div>
			<div class="span-6 med-span-3 peq-span-1">
				<?php 
          if($nivel==0 or $nivel==1 or $nivelo==3 or $nivel==2 or $nivel==4){
            ?>
            <select name="area" id="area" class="campo-sm Arial12" onChange="buscaEmpresa(this.value)" required>
              <option value="">Seleccione</option>
              <?php
              do {  
              ?>
                <option value="<?php echo $row_Recordset4['IdArea']?>"><?php echo $row_Recordset4['ccostos']?> - <?php echo $row_Recordset4['area']?></option>
                <?php
              } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
              $rows = mysql_num_rows($Recordset4);
              if($rows > 0) {
                mysql_data_seek($Recordset4, 0);
                $row_Recordset4 = mysql_fetch_assoc($Recordset4);
              }
              ?>
            </select>
            <?php
          }else{
          ?>
          <select name="area" id="area" class="campo-sm Arial12" onChange="buscaEmpresa(this.value)" required>
						<option value="">Seleccione</option>
            	<?php
            do {  
            	?>
              <option value="<?php echo $row_Recordset2['IdArea']?>"><?php echo $row_Recordset2['ccostos']?> - <?php echo $row_Recordset2['area']?></option>
              <?php
            } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
            $rows = mysql_num_rows($Recordset2);
            if($rows > 0) {
              mysql_data_seek($Recordset2, 0);
              $row_Recordset2 = mysql_fetch_assoc($Recordset2);
            }
            ?>
          </select>
          <?php 
          }
          ?>
			</div>
			<div class="span-3 med-span-0">
			
			</div>
			<div class="span-3 peq-span-1">
				SOLICITANTE
			</div>
			<div class="span-6 med-span-3 peq-span-1">
				<strong><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido'] ?></strong>
				<input type="hidden" name="IdSolicitante" value="<?php echo $usuario ?>">
			</div>
			<div class="span-3 med-span-0">
			
			</div>
			<div class="span-3 peq-span-1">
				MOTIVO DEL VIAJE
			</div>
			<div class="span-6 med-span-3 peq-span-1">
				<input type="text" class="campo-sm Arial12" name="motivo" required>	
			</div>
		</div>
		<div>
			<input type="hidden" id="empresa" name="empresa" value="0">
		</div>
    <div class="contenedor" style="max-width: 800px">
			<hr>
			<div class="grid columna-15 med-columna-9 peq-columna-1" style="max-width: 800px">
				<div class="span-5 med-span-3 peq-span-1">
          <table class="tablita">
						<tr>
							<td>Solo ida</td>
							<td align="center">
								<input type="radio" name="tipo" value="0" onClick="selTipo(this.value)" checked>
							</td>
						</tr>
					</table>
        </div>
        <div class="span-5 med-span-3 peq-span-1">
					<table class="tablita">
						<tr>
							<td>Ida y vuelta</td>
							<td align="center">
								<input type="radio" name="tipo" value="1" onClick="selTipo(this.value)"
							</td>
						</tr>
					</table>          
        </div>
        <div class="span-5 med-span-3 peq-span-1">          
					<table class="tablita">
						<tr>
							<td>Multidestino</td>
							<td align="center">
								<input type="radio" name="tipo" value="2"  onClick="selTipo(this.value)">
							</td>
						</tr>
					</table>
        </div>
			</div>			
			<hr>		
			<div class="grid columna-2 peq-columna-1 Arial14">
				<div class="span-1" style="padding-right: 7px">
					<h5 align="center" class="Century">DETALLES DEL VIAJE</h5>
					<div class="grid columna-2 peq-columna-1" style=" grid-row-gap:5px;">
						<div class="span-1 peq-span-1">
							Depto Origen
						</div>
						<div class="span-1 peq-span-1">
							<select name="" id="dep-o-1" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
								<option value="">Seleccione</option>
								<?php
								foreach($departamento as $key=>$j){
									?>
									<option value="<?php echo $key?>"><?php echo $j ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="span-1 peq-span-1">
							Municipio Origen
						</div>
						<div class="span-1 peq-span-1"  id="divm-o-1">
							<select name="trayecto[1][muno]" id="mun-o-1" class="campo-xs Arial12" onClick=verificaDpto(this.id) required>
								<option value="">Seleccione</option>
							</select>
						</div>
						<div class="span-1 peq-span-1">
							Depto Destino
						</div>
						<div class="span-1 peq-span-1">
							<select name="" id="dep-d-1" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
								<option value="">Seleccione</option>
								<?php
								foreach($departamento as $key=>$j){
									?>
									<option value="<?php echo $key?>"><?php echo $j ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="span-1 peq-span-1">
							Municipio Destino
						</div>
						<div class="span-1 peq-span-1" id="divm-d-1">
							<select name="trayecto[1][mund]" id="mun-d-1" class="campo-xs Arial12" onClick=verificaDpto(this.id) required>
								<option value="">Seleccione</option>
							</select>
						</div>
						<div class="span-1 peq-span-1">
							Fecha
						</div>
						<div class="span-1 peq-span-1">
							<input type="date" name="trayecto[1][fecha]" class="campo-xs Arial12" required>
						</div>
						<div class="span-1 peq-span-1">
							Jornada
						</div>
						<div class="span-1 peq-span-1">
							<select name="trayecto[1][jornada]" id="" class="campo-xs Arial12" required>
								<option value="">Seleccione</option>
								<option value="0">Madrugada</option>
								<option value="1">Mañana</option>
								<option value="2">Tarde</option>
								<option value="3">Noche</option>
							</select>
						</div>					
					</div>
					<br>
					<div id="cuerpo">				
					</div>
					<div id="cuerpo1" class="grid columna-2 peq-columna-1" style="display: none">
						<div class="span-2 peq-span-1" align="right">
							<button type="button" class="btn btn-verde btn-xs" onClick="agregaTrayecto()">Agregar trayecto</button>
						</div>
						<input type="hidden" value="1" id="contador">
					</div>
				</div>
				<div class="span-1" style="padding-left: 7px">
					<h5 align="center" class="Century">DETALLES DEL PASAJERO</h5>
					<div class="grid columna-2 peq-columna-1" style=" grid-row-gap:5px;">
						<div class="span-1">
								Nombre
						</div>
						<div class="span-1">
								<input type="text" class="campo-xs Arial12" name="pasajero[1][nombre]" id="nombrep-1" onBlur="aMayusculas(this.value,this.id)" required>
						</div>
						<div class="span-1">
								No cédula
						</div>
						<div class="span-1">
								<input type="number" class="campo-xs Arial12" name="pasajero[1][cedula]" required>
						</div>
						<div class="span-1">
								Telefono
						</div>
						<div class="span-1">
								<input type="number" class="campo-xs Arial12" name="pasajero[1][telefono]" required>
						</div>
						<div class="span-1">
								E-mail
						</div>
						<div class="span-1">
								<input type="text" class="campo-xs Arial12" name="pasajero[1][email]" required>
						</div>
						<div class="span-1">
								Equipaje
						</div>
						<div class="span-1">
								<select name="pasajero[1][equipaje]" id="equipaje-1"  class="campo-xs Arial12" required>
									<option value="">Seleccione</option>
									<option value="1">De mano</option>
									<option value="2">De cabina</option>
									<option value="3">De bodega</option>
								</select>
						</div>
						<div class="span-1">
							Subir cédula (PDF max 1MB)
						</div>
						<div class="span-1">
							<input type="file" name="cedula[1]" id="cedula-1" class="campo-xs Arial12" onChange="validarArchivo(this.files,this.id)" required>
						</div>	
					</div>
					<br>
					<div id="cuerpo2">				
					</div>
					<div class="grid columna-2 peq-columna-1">
						<div class="span-2 peq-span-1" align="right">
							<button type="button" class="btn btn-verde btn-xs" onClick="agregaPasajero()">Agregar pasajero</button>
						</div>
						<input type="hidden" value="1" id="contador2">
					</div>
				</div>
			</div>
    </div>
		<div align="center">
			<button type="submit" id="boton" class="btn btn-rosa btn-sm" name="boton32">Grabar</button>
		</div>
		<div class="espera" align="center">
		</div>
	</form>
</div>
<br>
<br>
<br>
<br>
<?php 
include('footer.php')
?>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset4);

?>
