<?php 
require_once('../connections/datos.php'); 

$buscaClase = " SELECT 
                    *
                FROM
                    calsecontratos";
$resultadoClase = mysql_query($buscaClase, $datos) or die(mysql_error());
$filaClase = mysql_fetch_assoc($resultadoClase);
$totalfilas_buscaClase = mysql_num_rows($resultadoClase);

$buscaArea = "SELECT 
									*
							FROM
									areas  ";
$resultadoArea = mysql_query($buscaArea, $datos) or die(mysql_error());
$filaArea = mysql_fetch_assoc($resultadoArea);
$totalfilas_buscaArea = mysql_num_rows($resultadoArea);

$buscaCDoc = "SELECT 
                  *
              FROM
                  clasedocsi;  ";
$resultadoCDoc = mysql_query($buscaCDoc, $datos) or die(mysql_error());
$filaCDoc = mysql_fetch_assoc($resultadoCDoc);
$totalfilas_buscaCDoc = mysql_num_rows($resultadoCDoc);

$buscaDepto = "	SELECT 
										*
								FROM
										departamentos";
$resultadoDepto = mysql_query($buscaDepto, $datos) or die(mysql_error());
$filaDepto = mysql_fetch_assoc($resultadoDepto);
$totalfilas_buscaDepto = mysql_num_rows($resultadoDepto);

$buscaCargo =  "SELECT 
										*
								FROM
										cargos";
$resultadoCargo = mysql_query($buscaCargo, $datos) or die(mysql_error());
$filaCargo = mysql_fetch_assoc($resultadoCargo);
$totalfilas_buscaCargo = mysql_num_rows($resultadoCargo);

?>
<?php 
include('encabezado.php');
?>
<script>

  function buscaSubClase(IdClaseContrato){

    var datos = new FormData();
		datos.append("IdClaseContrato",IdClaseContrato);
		datos.append("proced",1);

    $.ajax({
      url:"ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta)
        $('#midiv').html(respuesta)
        // var res = respuesta.trim();
        // console.log(res)
        // if(res='ok'){
        //   location.reload();
        // }
      }
    });
  }

  function buscaProv(obj, valor, id) {
		// console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


    if(arrayId[0]=='proveedor'){
      if ($('#ch-' + arrayId[1]).is(':visible')) {

		  } else {
			 $('#ch-' + arrayId[1]).slideToggle();
		  }
    }else{
      if ($('#cch-' + arrayId[1]).is(':visible')) {

		  } else {
			 $('#cch-' + arrayId[1]).slideToggle();
		  }
    }
		

		var datos = new FormData();
		datos.append("valor", valor);
		datos.append("item", arrayId[1]);
		datos.append("proced", 2);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				//console.log(respuesta)
        if(arrayId[0]=='proveedor'){
          document.getElementById('ch-' + arrayId[1]).innerHTML = respuesta
        }else{
          document.getElementById('cch-' + arrayId[1]).innerHTML = respuesta
        }
			}
		})
	}

  function buscaProvn(obj, valor, id) {
		// console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


    if(arrayId[0]=='proveedorn'){
      if ($('#chn-' + arrayId[1]).is(':visible')) {

		  } else {
			 $('#chn-' + arrayId[1]).slideToggle();
		  }
    }else{
      if ($('#cchn-' + arrayId[1]).is(':visible')) {

		  } else {
			 $('#cchn-' + arrayId[1]).slideToggle();
		  }
    }
		

		var datos = new FormData();
		datos.append("valor", valor);
		datos.append("item", arrayId[1]);
		datos.append("proced", 3);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				console.log(respuesta)
        if(arrayId[0]=='proveedorn'){
          document.getElementById('chn-' + arrayId[1]).innerHTML = respuesta
        }else{
          document.getElementById('cchn-' + arrayId[1]).innerHTML = respuesta
        }
			}
		})
	}

  function llenar(id, nombre, item,documento) {
		$('#cambiaProveedor').modal('hide');
		// console.log(id, nombre, item,documento)
		var item1="'"+item+"'"
		$('#tdprov-' + item).html(
			'<div style="width: 320px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaProv('+ item1 + ')">' + nombre + '</div>'+
			'<input type="hidden" name="proveedor" id="proveedor'+item+'" value="'+id+'">'
		);
    $('#tdnit-' + item).html(
			'<div style="width:160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaProvn('+ item1 + ')">' + documento + '</div>'
		);
	}

  function modal(item,id){ 
		const miDiv = document.getElementById('ch-'+item);
		const miDiv1 = document.getElementById('chn-'+item);
		if(miDiv){
			document.getElementById('ch-'+item).style.display='none';
		}
		if(miDiv1){
			document.getElementById('chn-'+item).style.display='none';
		}
		document.getElementById('itemp').value=item;
		$('#cambiaProveedor').modal('hide');
		$('#creacargo').modal({backdrop: 'static', keyboard: false});
		
	}

  function cambiaProv(item) {
		$('#divCambProv').html(
			'<input type="text" class="campo-xs" id="prov-' + item + '" onKeyUp="buscaProv(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdProveedor" value="0">' +
			'<div class="drop"><ul class="hijos" id="cch-' + item + '"></ul></div>'
		);
		$('#cambiaProveedor').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
	
  function cambiaProvn(item) {
		$('#divCambProv').html(
			'<input type="text" class="campo-xs" id="prov-' + item + '" onKeyUp="buscaProvn(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdProveedor" value="0">' +
			'<div class="drop"><ul class="hijos" id="cchn-' + item + '"></ul></div>'
		);
		$('#cambiaProveedor').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
  
	function buscamun(IdDepartamento,id){
		var datos = new FormData();
		datos.append("IdDepartamento",IdDepartamento);
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
					var arregloTabla = JSON.parse(respuesta);
					if(id=="depto"){
						var fila = '<select name="municipio" id="municipio" class="campo-xs Arial12" required="required" >'+	
											'<option value="">Seleccione</option>';
					}
					if(id=="depton"){
						var fila = '<select name="municipion" id="municipion" class="campo-xs Arial12" required="required" >'+	
											'<option value="">Seleccione</option>';
					}


					
					Object.keys(arregloTabla).forEach(key => {
						// console.log(key,arregloTabla[key] )
						fila=fila+'<option value="'+key+'">'+arregloTabla[key]+'</option>'
					});
					fila=fila+'</select>';
					if(id=="depto"){
						$('#midiv2').html(fila);
					}
					if(id=="depton"){
						$('#midiv1').html(fila);
					}
				}
			});
	}

	function graba(){
		var proveedor = document.getElementById('proveedor').value;		
    var item = document.getElementById('itemp').value;
		var nit = document.getElementById('nit').value;

		var IdClasedoc = document.getElementById('IdClasedoc').value;
		var fconstitucion = document.getElementById('fconstitucion').value;
		var depton = document.getElementById('depton').value;
		var municipion = document.getElementById('municipion').value;
		var direccion = document.getElementById('direccion').value;
		var telefono = document.getElementById('telefono').value;
		var depto = document.getElementById('depto').value;
		var municipio = document.getElementById('municipio').value;

		if(proveedor==""){
			document.getElementById('proveedor').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL PROVEEDOR!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(IdClasedoc==""){
			document.getElementById('IdClasedoc').focus();
			swal({
				text: "¡DEBE SELECCIONAR LA CLASE DE DOCUMENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(nit==""){
			document.getElementById('nit').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL NIT!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
		
		if(fconstitucion==""){
			document.getElementById('fconstitucion').focus();
			swal({
				text: "¡DEBE ESCRIBIR LA FECHA DE COSNTITUCION O DE NACIMIENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(depton==""){
			document.getElementById('depton').focus();
			swal({
				text: "¡DEBE SELECCIONAR EL DEPARTAMENTO DE CONSTITUCION O DE NACIMIENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}


		if(municipion==""){
			document.getElementById('municipion').focus();
			swal({
				text: "¡DEBE SELECCIONAR EL MUNICIPIO DE CONSTITUCION O DE NACIMIENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(direccion==""){
			document.getElementById('direccion').focus();
			swal({
				text: "¡DEBE ESCRIBIR LA DIRECCION!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(telefono==""){
			document.getElementById('telefono').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL TELEFONO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(depto==""){
			document.getElementById('depto').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL DEPARTAMENTO DEL DOMICILIO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}

		if(municipio==""){
			document.getElementById('municipio').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL MUNICIPIO DEL DOMICILIO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
        
		var datos = new FormData();
		datos.append("proveedor",proveedor);
		datos.append("nit",nit);
		datos.append("IdClasedoc",IdClasedoc);
		datos.append("fconstitucion",fconstitucion);
		datos.append("depton",depton);
		datos.append("municipion",municipion);
		datos.append("direccion",direccion);
		datos.append("telefono",telefono);
		datos.append("depto",depto);
		datos.append("municipio",municipio);
		datos.append("proced",5);	
    
    $.ajax({
          url:"ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta){
            document.getElementById('formulario').reset();
						$("#creacargo").modal('hide');
            respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
						console.log(respuesta);
            var matriz = respuesta.split(",");
            if(matriz[0]=="ok"){
              swal({
                text: "¡EL CONTRATISTA FUE CREADO!",
                type: "success",
                confirmButtonText: "¡Cerrar!"                
              }); 
							llenar(matriz[1], matriz[2], item, matriz[3])
              
            }
						if(matriz[0]=="ya"){
							swal({
								
                html: '<div class="Arial16">EL DOCUMENTO DIGITADO YA ESTA EN LA BASE DE DATOS Y CORRESPONDE A:</div><div class="Arial16" style="font-weight: bold">'+matriz[2]+'</div><div class="Arial16">¿DESEA ASIGNARLO?</div>',
                type: "warning",
								showCancelButton: true,
								confirmButtonColor: '#28a745',
								cancelButtonColor: '#d33',
								confirmButtonText: "¡Si!",
								cancelButtonText: "¡No!",               
              }).then((result) =>{
								
								if(result.value==true){
									llenar(matriz[1], matriz[2], item, matriz[3])
								}else{
									
								}
							});
	
						}
          }
    });
    
  }
</script>
<style>
	.drop .hijos {
		display: none;
		background: #ffffff;
		position: absolute;
		z-index: 1000;
		width: max-content;
		padding: 0;
		margin-top: 8px;
		border: 1px solid rgba(0, 0, 0, 0.3);
		border-radius: 4px;

	}

	.drop .hijos li {
		display: block;
    text-align: left;
	}

	.drop .hijos li:hover {
		background: #e3e3f7;
	}

	::placeholder {
		color: #ccc;
		font-size: 12px;
	}

	.item {
		display: block;
		cursor: pointer;
		padding: 1px 5px;
		color: #000000;
	}

	.div-radio input[type="radio"]{
    display: none
  }

  .div-radio label {
    font-family: Arial;
    font-size: 14px;
    margin: 0;
    width: 100%;
    /* background: rgba(0,0,0,.1); */
    /* padding: 0 10px 0 24px;
    display: inline-block; */
    position: relative;
    border-radius: 3px;
    cursor: pointer;
		padding: 0 0; 
    display: flex;
    justify-content: center;
    -webkit-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
		
  }

	.div-radio label:before{
    /* content: "";
    width: 14px;
    height: 14px;
    display: inline-block;
    background: none;
    border: 1px solid #000;
    border-radius: 50%;
    position: absolute;
    left: 5px;
    top: 3px; */
  }
  
  .div-radio input[type="radio"]:checked + label{
    background: #FF9E7E;
    padding: 0 0; 
    display: flex;
    justify-content: center;
    
  }
  
  .div-radio input[type="radio"]:checked + label:before{
    /*background: #007bff;
    border: 1px solid #007bff;*/
    display: none;
  }
  
  .borde-div-g{
    border-radius: 10px;
    padding: 5px 10px;
    margin: 0 10px;
    
  }

</style>
<?php 
include('encabezado1.php');
?>
consec, contrato, formaPago, anticipo, panticipo, anticipop, terminado
<div class="contenedor" style="width:1000px">
  <h5 class="Century" align="center" >CREACION DE CONTRATOS</h5>
  <form action="graba.php">
    <div class="grid columna-8 Arial14">
			<div class="span-4">
				Proyecto / Area:
				<select name="IdArea" class="campo-sm Arial12" required>
					<option value="">Seleccione</option>
					<?php 
					do {
						?>
						<option value="<?php echo $filaArea['IdArea'] ?>"><?php echo $filaArea['area'] ?></option>
						<?php
					} while ($filaArea = mysql_fetch_assoc($resultadoArea));
					?>
					
				</select>
			</div>
      <div class="span-2">
        Clase de Contrtato:
        <select name="IdClase" id="IdClase" class="campo-sm Arial12" onChange="buscaSubClase(this.value)" >
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
      <div class="span-2" id="midiv">
        Sub Clase de Contrato:
        <select name="IdSubClase" id="IdSubClase" class="campo-sm Arial12" >
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="span-4">
        Contratista:
        <table class="tablita Arial12" width="100%">
					<col width="66%">
					<col width="34%">
          <tr>
            <td id="tdprov-1">
              <input type="text" class="campo-sm Arial12" id="proveedor-1" onKeyUp="buscaProv(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off" rerquired>
              <div class="drop">
                <ul class="hijos" id="ch-1">
                </ul>
              </div>
            </td>
            <td id="tdnit-1">
              <input type="text" class="campo-sm Arial12" id="proveedorn-1" onKeyUp="buscaProvn(this,this.value,this.id)" placeholder="Buscar X nit" autocomplete="off" rerquired>
              <div class="drop">
                <ul class="hijos" id="chn-1">
                </ul>
              </div>
            </td>
          </tr>
        </table>
      </div>
			<div class="span-1">
				Inicio:
				<input type="date" class="campo-sm Arial12" name="finicio"  >
			</div>
			<div class="span-1">
				Terminación:
				<input type="date" class="campo-sm Arial12" name="ffin"  >	
			</div>
			<div class="span-1">
				Valor:
				<input type="number" class="campo-sm Arial12" name="valor" >
			</div>
			<div class="span-1">
				Cargo:
				<select name="IdCargo" class="campo-sm Arial12" id="">
					<option value="">Seleccione</option>
					<?php 
					do{
						?>
						<option value="<?php echo $filaCargo['IdCargo'] ?>"><?php echo $filaCargo['cargo'] ?></option>
						<?php
					} while ($filaCargo = mysql_fetch_assoc($resultadoCargo));
					?>
					
				</select>
			</div>
			<div class="span-4">
				Objeto:
				<textarea name="objeto" id="" class="txtarea" ></textarea>
			</div>
			<div class="span-4">
				Objeto obra o labor contratada:
				<textarea name="objetoool" id="" class="txtarea" ></textarea>
			</div>

			<div class="span-4">
				Alcance:
				<textarea name="alcance" id="" class="txtarea" ></textarea>
			</div>
			<div class="span-4">
				Actividades:
				<textarea name="actividades" id="" class="txtarea" ></textarea>
			</div>
			<div class="span-4">
				Entregables:
				<textarea name="entregables" id="" class="txtarea" ></textarea>
			</div>
			<div class="span-2">
				Salario Integral:
				<div class="grid columna-3">
					<div class="span-1 div-radio">
						<input type="radio" name="integral" id="integral-si" value="1" >
						<label for="integral-si">Sí</label>
					</div>
					<div class="span-1 div-radio">
						<input type="radio" name="integral" id="integral-no" value="0" checked >
						<label for="integral-no">No</label>
					</div>
				</div>
			</div>
			<div class="span-2">
				IVA:
				<div class="grid columna-3">
					<div class="span-1 div-radio">
						<input type="radio" name="iva" id="iva-si" value="1" >
						<label for="iva-si">Sí</label>
					</div>
					<div class="span-1 div-radio">
						<input type="radio" name="iva" id="iva-no" value="0" checked >
						<label for="iva-no">No</label>
					</div>
				</div>
			</div>
    </div>
    
  </form>
</div>

<div id="cambiaProveedor" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 320px">
		<div class="modal-content">
			<div class="modal-header" style="background:#d8d8d8; color:black;padding: 10px">
				<h5 class="modal-title Century">Cambiar proveedor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body Arial12" id="divCambProv">
			</div>
		</div>
	</div>
</div>

<div id="creacargo" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg" >    
    <div class="modal-content">
      <form method="post" id="formulario" name="formulario" action="">
        <div class="modal-header" style="background:#d8d8d8; color:black">
            <h5 class="modal-title">Ingrese el nuevo contratista</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
					<div class="grid columna-6 Arial12">
						<div class="span-3">
							<br><br>
							Preveedor:
							<input type="text" name="proveedor" id="proveedor" class="campo-xs Arial12" required="required" value="" onBlur="aMayusculas(this.value,this.id)">
							<input type="hidden" id="itemp">
						</div>
						<div class="span-1">
							<br><br>
							Clase documento:
							<select name="IdClasedoc" id="IdClasedoc" class="campo-xs Arial12" required="required">
								<option value="">Seleccione</option>
								<?php 
								do{
									?>
									<option value="<?php echo $filaCDoc['IdClasedoc'] ?>"><?php echo $filaCDoc['nombre'] ?></option>
									<?php
								} while ($filaCDoc = mysql_fetch_assoc($resultadoCDoc));
								?>
							</select>
						</div>
						<div class="span-1">
							No. Documento: (sin puntos ni comas, ni digito de verificación)						
							<input type="number" name="nit" id="nit" class="campo-xs Arial12" required="required" value="">
						</div>
						<div class="span-1">
							<br>
							F. de constitución o de nacimiento:
							<input type="date" name="fconstitucion" id="fconstitucion" class="campo-xs Arial12" required="required">
						</div>
						<div class="span-2">
							Departamento:
							<select name="depton" id="depton" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
								<option value="">Seleccione</option>
								<?php
								do {  
									?>
									<option value="<?php echo $filaDepto['IdDepartamento']?>"><?php echo $filaDepto['departamentos']?></option>
									<?php
								} while ($filaDepto = mysql_fetch_assoc($resultadoDepto));
								$rows = mysql_num_rows($resultadoDepto);
								if($rows > 0) {
									mysql_data_seek($resultadoDepto, 0);
									$filaDepto = mysql_fetch_assoc($resultadoDepto);
								}
								?>
							</select>
						</div>
						<div class="span-2">
							Municipio:
							<div id='midiv1'>
								<select name="municipion" id="municipion"  class="campo-xs Arial12" required="required" >	
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>		
						<div class="span-2">
							Dirección:
							<input type="text" name="direccion" id="direccion" class="campo-xs" required="required">		
						</div>
						<div class="span-1">
							Teléfono:
							<input type="text" name="telefono" id="telefono" class="campo-xs" required="required">
						</div>
						
						<div class="span-2">
							Departamento:
							<select name="depton" id="depto" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
								<option value="">Seleccione</option>
								<?php
								do {  
									?>
									<option value="<?php echo $filaDepto['IdDepartamento']?>"><?php echo $filaDepto['departamentos']?></option>
									<?php
								} while ($filaDepto = mysql_fetch_assoc($resultadoDepto));
								$rows = mysql_num_rows($resultadoDepto);
								if($rows > 0) {
									mysql_data_seek($resultadoDepto, 0);
									$filaDepto = mysql_fetch_assoc($resultadoDepto);
								}
								?>
							</select>		
						</div>
						<div class="span-2">
							Municipio:
							<div id='midiv2'>
								<select name="municipio" id="municipio" class="campo-xs Arial12" required="required" >	
									<option value="">Seleccione</option>
								</select>
							</div>	
						</div>
					</div>
        </div>
        <div class="modal-footer">
          <button type="button" name="boton" class="btn btn-verde btn-sm" onClick="graba()">Grabar</button>
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