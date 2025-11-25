<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
 
if(!$_POST['proyecto'] and !$_POST['contratista'] and !$_POST['IdClase'] and !$_POST['IdSubClase'] and !$_POST['dfinicio'] and !$_POST['hfinicio']){
	$buscador1="";
}else{
	$buscador1=" where ";

	if($_POST['proyecto']){
		$buscador.=" contrat.IdArea=".$_POST['proyecto']." and ";
	}
	if($_POST['contratista']){
		$buscador.=" contrat.IdProveedor=".$_POST['contratista']." and ";
	}
	if($_POST['IdClase']){
		$buscador.=" contrat.IdClase=".$_POST['IdClase']." and ";
	}
	if($_POST['IdSubClase']){
		$buscador.=" contrat.IdSubClase=".$_POST['IdSubClase']." and ";
	}
	if($_POST['dfinicio']){
		$buscador.=" contrat.finicio>='".$_POST['dfinicio']."' and ";
	}
	if($_POST['hfinicio']){
		$buscador.=" contrat.finicio<='".$_POST['hfinicio']."' and ";
	}
	

}
$buscador=substr($buscador, 0, -4);
// echo $buscador." ".$buscador1;
?>
<?php


$buscaCont = "SELECT 
									IdContrato,
									proveedor,
									IdProveedor,
									area,
									contrat.IdClase,
									contrat.IdSubClase,
									clase,
									subclase,
									objeto,
									finicio,
									ffin,
									ffinfin,
									iva,
									consec,
									contrato,
									valor,
									valorf,
									formaPago,
									anticipo,
									panticipo,
									anticipop,
									terminado,
									integral,
									incs,
									especialidad,
									grupo,
									centrofor,
									alcance,
									lugar,
									auxilio,
									cargo,
									contrato,
									anexo
							FROM
									(((((contrat
									LEFT JOIN contratistas ON contrat.IdProveedor = contratistas.IdContratista)
									LEFT JOIN areas ON contrat.IdArea = areas.IdArea)
									LEFT JOIN calsecontratos ON contrat.IdClase = calsecontratos.IdClaseContrato)
									LEFT JOIN subclasescontrat ON contrat.IdSubClase = subclasescontrat.IdSubClase)
									LEFT JOIN cargos ON contrat.IdCargo = cargos.IdCargo)  ".$buscador1.$buscador;
$resultadoCont = mysql_query($buscaCont, $datos) or die(mysql_error());
$filaCont = mysql_fetch_assoc($resultadoCont);
$totalfilas_buscaCont = mysql_num_rows($resultadoCont);

// echo $buscaCont;


mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT IdArea, area, ccostos from areas order by ccostos";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$buscaClase = " SELECT 
                    *
                FROM
                    calsecontratos";
$resultadoClase = mysql_query($buscaClase, $datos) or die(mysql_error());
$filaClase = mysql_fetch_assoc($resultadoClase);
$totalfilas_buscaClase = mysql_num_rows($resultadoClase);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdUsuario, nombre, apellido from usuarios";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset2 = "select IdContratista, proveedor from contratistas order by proveedor";
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);


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
    
    var contratista ="<?php 
    if($_POST){
      echo $_POST['contratista'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('contratista').value=contratista;
		
		var IdClase ="<?php 
    if($_POST){
      echo $_POST['IdClase'];
    }else{
      echo "";
    }
    ?>";
		if(IdClase){
			buscaSubClase(IdClase)
		}
		
    document.getElementById('IdClase').value=IdClase;
    
    var IdSubClase ="<?php 
    if($_POST){
      echo $_POST['IdSubClase'];
    }else{
      echo "";
    }
    ?>";

		setTimeout(() => {
        document.getElementById('IdSubClase').value=IdSubClase;
      }, "100");
    
       
    var dfinicio ="<?php 
    if($_POST){
      echo $_POST['dfinicio'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('dfinicio').value=dfinicio;
    
    var hfinicio ="<?php 
    if($_POST){
      echo $_POST['hfinicio'];
    }else{
      echo "";
    }
    ?>";
		
    document.getElementById('hfinicio').value=hfinicio;
    
         
  }

	function buscaSubClase(IdClaseContrato){

    var datos = new FormData();
		datos.append("IdClaseContrato",IdClaseContrato);
		datos.append("proced",11);

    $.ajax({
      url:"ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        // console.log(respuesta)
        $('#midiv').html(respuesta)
        // var res = respuesta.trim();
        // console.log(res)
        // if(res='ok'){
        //   location.reload();
        // }
      }
    });
  }

	function subeRadicado(id,consec){

		document.getElementById('m-id').value=id;
		document.getElementById('m-consec').value=consec;

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

	function subeRadicado1(){
		var radicado = document.getElementById('m-radicado').files[0];
		var id = document.getElementById('m-id').value;
		var consec = document.getElementById('m-consec').value

    if(!radicado){
			document.getElementById('m-radicado').focus();
			swal({
				 html: '¡Debe seleccionar el archivo con el contrato!',
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
		datos.append("id",id);
		datos.append("consec",consec);
    datos.append("proced",12);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          var res = respuesta.trim();
					console.log(respuesta);
          if(res=='ok'){
						$('#subirRadicado').modal('hide');
						swal({
							html: '¡Contrato subido con exito!',
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

	function solicitar(IdContrato,IdUsuario){
		console.log(IdContrato,IdUsuario)
		var datos = new FormData();
    datos.append("IdContrato",IdContrato);
		datos.append("IdUsuario",IdUsuario);
    datos.append("proced",15);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          var res = respuesta.trim();
					console.log(res);
          if(res=='ok'){
						$('#subirRadicado').modal('hide');
						swal({
							html: '¡La solicitud ha sido enviada!',
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

	#relleno-sm {
		min-width:1700px;
	}

	body{		
		/* background-color: lightgray;  */
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
  <h4 align="center" class="Century">CONSULTA DE CONTRATOS</h4>
	<br>
	<form action="reporte.php" method="post">
		<div class="grid columna-6" style="width: 850px" align="left">
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
			<div class="span-1">
				Contratista
			</div>
			<div class="span-2">
				<select name="contratista" id="contratista" class="campo-xs Arial12">
				  <option value="">Seleccione</option>
				  <?php
					do {  
						?>
						<option value="<?php echo $row_Recordset2['IdContratista']?>"><?php echo $row_Recordset2['proveedor']?></option>
						<?php
					} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
					$rows = mysql_num_rows($Recordset2);
					if($rows > 0) {
						mysql_data_seek($Recordset2, 0);
						$row_Recordset2 = mysql_fetch_assoc($Recordset2);
					}
					?>
        </select>
			</div>
			<div class="span-1">
				Clase de contrato
			</div>
			<div class="span-2">
				<select name="IdClase" id="IdClase" class="campo-xs Arial12" onChange="buscaSubClase(this.value)" >
          <option value="">Seleccione</option>
          <?php 
          do{
            ?>
            <option value="<?php echo $filaClase['IdClaseContrato'] ?>"><?php echo  $filaClase['clase']?></option>
            <?php
          }while ($filaClase = mysql_fetch_assoc($resultadoClase));
          ?>
        </select>
			</div>
			<div class="span-1">
				Sub clase de cont.
			</div>
			<div class="span-2" id="midiv">
				<select name="IdSubClase" id="IdSubClase" class="campo-xs Arial12" >
          <option value="">Seleccione</option>
        </select>
			</div>
		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 850px">
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha del Contrato
					</div>
					<div class="span-1">
						Desde:
						<input type="date" name="dfinicio" id="dfinicio" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hfinicio" id="hfinicio" class="campo-xs Arial12">
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
	<div align="center" style="width:1700px">
		<table border="1" align="center"  class="tablita">
			<col width="60">
			<col width="220">
			<col width="220">
			<col width="140">
			<col width="250">
			<col width="250">
			<col width="70">
			<col width="65">
			<col width="65">
			<col width="75">
			<col width="75">
			<col width="93">
			<col width="80">
			<!-- 
			
		
			<col width="80">
			<col width="250">
			<col width="70">
			<col width="80">
			<col width="80">
			<col width="107"> -->
			<tr class="Arial14 titulos">
				<td align="center">CONSEC</td>				
				<td align="center">CONTRATISTA</td>
				<td align="center">AREA</td>
				<td align="center">CLASE</td>
				<td align="center">CARGO / OBJETO</td>
				<td align="center">LABOR CONTRATADA</td>
				<td align="center">VALOR</td>	
				<td align="center">INCS</td>
				<td align="center">AUXILIO</td>			
				<td align="center">INICIO</td>
				<td align="center">FIN</td>

				<td align="center">ACCIONES</td>
				<td align="center">VER</td>
			</tr>
			<?php

			if($totalfilas_buscaCont>0){
				do{
					if($filaCont['IdClase']==1){
						$consec='LAB '.sprintf("%03d",$filaCont['consec']);
					}
					if($filaCont['IdClase']==2){
						$consec='PS '.sprintf("%03d",$filaCont['consec']);
					}

					if($filaCont['cargo']){
						$cargo=$filaCont['cargo'];
					}else{
						$cargo=$filaCont['objeto'];
					}

					if($filaCont['IdSubClase']==2){
						$labor=$filaCont['objeto'];
					}else{
						$labor='';
					}

					?>
					<tr class="Arial10" >
						<td align="center"><?php echo $consec ?></td>
						<td><?php echo $filaCont['proveedor']?></td>
						<td><?php echo $filaCont['area']?></td>
						<td><?php echo $filaCont['clase']?><br><?php echo $filaCont['subclase']?></td>
						<td class="Arial10" ><?php echo $cargo?></td>
						<td class="Arial10" ><?php echo $labor?></td>
						<td align="right"><?php echo number_format($filaCont['valor'])?></td>
						<td align="right"><?php echo number_format($filaCont['incs'])?></td>
						<td align="right"><?php echo number_format($filaCont['auxilio'])?></td>
						<td align="center"><?php echo fechaactual3($filaCont['finicio'])?></td>
						<td align="center"><?php echo $filaCont['ffin'] ? fechaactual3($filaCont['ffin']) : ""?></td>
						<td>
							<?php 
							if(($nivel<=1 or $usuario==16 or $usuario==45) and $usuario<>23){
								if(!$filaCont['contrato']){
									?>
									<button class="btn btn-verde btn-xs1 btn-block" onClick="subeRadicado(<?php echo $filaCont['IdContrato']?>,'<?php echo $consec?>')" >Subir contrato<br>firmado</button>
									<a href="editacontrato.php?contrato=<?php echo $filaCont['IdContrato']?>" class="btn btn-verde btn-xs1 btn-block">Editar contrato</a>
									<?php
								}
							}
							?>
						</td>
						<td>
							<?php
							if($nivel<=1){
								if($filaCont['contrato']){
									?>
									<a href="<?php echo $filaCont['contrato']?>" class="btn btn-rosa btn-xs1 btn-block"  target="_blank">Ver Contrato</a>
									<?php
								}else if($filaCont['IdClase']==1){
									?>
									<a href="contratolab-pdf.php?contrato=<?php echo $filaCont['IdContrato']?>" class="btn btn-rosa btn-xs1 btn-block"  target="_blank" >Ver Contrato</a> 
									<?php
								}else if($filaCont['IdClase']==2){
									?>
									<a href="contratolab-pdf.php?contrato=<?php echo $filaCont['IdContrato']?>" class="btn btn-rosa btn-xs1 btn-block"  target="_blank" >Ver Contrato<br>borrador de<br>word</a> 
									<?php
								}
								if($filaCont['anexo']){
									?>
									<a href="<?php echo $filaCont['anexo']?>" class="btn btn-rosa btn-xs1 btn-block"  target="_blank" style="margin-top:4px">Ver Terminos<br>de referencia</a>
									<?php
								}
							}else{
								if($filaCont['contrato']){
									?>
									<button class="btn btn-rosa btn-xs1 btn-block" onClick="solicitar(<?php echo $filaCont['IdContrato']?>,<?php echo $usuario?>)">Solicitar</button>
									<?php
								}
							}
							?>
						</td>
					</tr>
					<?php

				} while ($filaCont = mysql_fetch_assoc($resultadoCont));

			}else{

			}
			?>
			
		</table>
	</div>	
	<?php
}
?>
<br><br><br><br><br>

<!-- modal -->
<div id="subirRadicado" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">SUBIR CONTRATO</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
			<div class="modal-body">
        <div>
					<input type="hidden" id="m-id">
					<input type="hidden" id="m-consec">
					<div class="grid columna-2">
						<div class="span-2" id="div-radicado">
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


<?php 
	mysql_close($datos);
include('footer.php')
?>




</body>
</html>
<?php


mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset2);
?>
