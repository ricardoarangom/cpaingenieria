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

$buscaClau = "SELECT * FROM borrclausulas";
$resultadoClau = mysql_query($buscaClau, $datos) or die(mysql_error());
$filaClau = mysql_fetch_assoc($resultadoClau);
$totalfilas_buscaClau = mysql_num_rows($resultadoClau);

?>
<?php
include('encabezado.php');
?>
<script>
	// Mapeo completo de variables
	var variablesMap = {
		// INFORMACIÓN DEL CONTRATO
		'TIPO_CONTRATO': function() {
			return $('#IdClase option:selected').text() || '';
		},
		'FECHA_FIRMA': function() {
			return formatearFecha(new Date()) || '';
		},
		'CIUDAD_FIRMA': function() {
			return 'Bogotá D.C.';
		},

		// INFORMACIÓN DEL CONTRATANTE/EMPLEADOR
		'CONTRATANTE_NOMBRE': function() {
			return 'LUIS HECTOR RUBIANO VERGARA';
		},
		'CONTRATANTE_CEDULA': function() {
			return '79.315.619';
		},
		'CONTRATANTE_DIRECCION': function() {
			return 'Calle 106 No. 59-21';
		},
		'CONTRATANTE_CIUDAD': function() {
			return 'Bogotá D.C.';
		},
		'EMPRESA_NOMBRE': function() {
			return 'COMPAÑÍA DE PROYECTOS AMBIENTALES E INGENIERÍA S.A.S. - CPA INGENIERÍA S.A.S.';
		},
		'EMPRESA_NOMBRE_CORTO': function() {
			return 'CPA INGENIERÍA S.A.S.';
		},
		'EMPRESA_NIT': function() {
			return '830.042.614-3';
		},
		'EMPRESA_DIRECCION': function() {
			return 'Calle 106 No. 59-21';
		},
		'EMPRESA_CIUDAD': function() {
			return 'Bogotá D.C.';
		},
		'EMPRESA_TELEFONO': function() {
			return '(601) 3229320';
		},

		// INFORMACIÓN DEL CONTRATISTA/TRABAJADOR
		'CONTRATISTA_NOMBRE': function() {
			return obtenerNombreContratista();
		},
		'CONTRATISTA_CEDULA': function() {
			return obtenerDocumentoContratista();
		},
		'CONTRATISTA_DIRECCION': function() {
			return obtenerDireccionContratista();
		},
		'CONTRATISTA_TELEFONO': function() {
			return obtenerTelefonoContratista();
		},

		// INFORMACIÓN LABORAL
		'CARGO_DESEMPENAR': function() {
			return $('#IdCargo option:selected').text() || '';
		},
		'SALARIO': function() {
			return formatearMoneda($('#valor').val()) || '';
		},
		'FECHA_INICIO': function() {
			return formatearFechaCompleta($('#finicio').val()) || '';
		},
		'FECHA_FIN': function() {
			return formatearFechaCompleta($('#ffin').val()) || '';
		},
		'PROYECTO_NOMBRE': function() {
			return $('#IdArea option:selected').text() || '';
		},

		// OBJETO Y ALCANCE DEL CONTRATO
		'OBJETO_CONTRATO': function() {
			return $('#objeto').val() || '';
		},
		'ALCANCE_CONTRATO': function() {
			return $('#alcance').val() || '';
		},
		'ACTIVIDADES': function() {
			return $('#actividades').val() || '';
		},
		'PRODUCTOS_ENTREGAR': function() {
			return $('#entregables').val() || '';
		},
		'ENTREGABLES': function() {
			return $('#entregables').val() || '';
		},
		'OBRA_LABOR_CONTRATADA': function() {
			return $('#objetoool').val() || '';
		},

		// PLAZOS Y DURACIÓN
		'FECHA_INICIO_PLAZO': function() {
			return formatearFechaEscrita($('#finicio').val()) || '';
		},
		'FECHA_FIN_PLAZO': function() {
			return formatearFechaEscrita($('#ffin').val()) || '';
		},
		'DURACION_CONTRATO': function() {
			return calcularDuracion($('#finicio').val(), $('#ffin').val()) || '';
		},

		// VALOR Y FORMA DE PAGO
		'VALOR_TOTAL': function() {
			return formatearMonedaCompleta($('#valor').val()) || '';
		},
		'VALOR_ANTES_IVA': function() {
			var valor = parseFloat($('#valor').val()) || 0;
			var conIva = $('input[name="iva"]:checked').val() == '1';
			return conIva ? formatearMonedaCompleta(valor / 1.19) : formatearMonedaCompleta(valor);
		},
		'VALOR_CON_IVA': function() {
			var valor = parseFloat($('#valor').val()) || 0;
			var conIva = $('input[name="iva"]:checked').val() == '1';
			return conIva ? formatearMonedaCompleta(valor) : formatearMonedaCompleta(valor * 1.19);
		},

		// DOMICILIOS Y NOTIFICACIONES
		'DIRECCION_NOTIFICACIONES_CONTRATANTE': function() {
			return 'Calle 106 No. 59-21';
		},
		'DIRECCION_NOTIFICACIONES_CONTRATISTA': function() {
			return obtenerDireccionContratista();
		},

		// FECHAS DE FIRMA
		'DIA_FIRMA': function() {
			return convertirNumeroATexto(new Date().getDate()) || '';
		},
		'MES_FIRMA': function() {
			return obtenerNombreMes(new Date().getMonth()) || '';
		},
		'ANO_FIRMA': function() {
			return new Date().getFullYear().toString() || '';
		}
	};

	// Array con numerales
	var numerales = [
		'PRIMERA', 'SEGUNDA', 'TERCERA', 'CUARTA', 'QUINTA',
		'SEXTA', 'SÉPTIMA', 'OCTAVA', 'NOVENA', 'DÉCIMA',
		'DÉCIMA PRIMERA', 'DÉCIMA SEGUNDA', 'DÉCIMA TERCERA', 'DÉCIMA CUARTA', 'DÉCIMA QUINTA',
		'DÉCIMA SEXTA', 'DÉCIMA SÉPTIMA', 'DÉCIMA OCTAVA', 'DÉCIMA NOVENA', 'VIGÉSIMA', 'VIGÉSIMA PRIMERA', 'VIGÉSIMA SEGUNDA', 'VIGÉSIMA TERCERA', 'VIGÉSIMA CUARTA', 'VIGÉSIMA QUINTA', 'VIGÉSIMA SEXTA', 'VIGÉSIMA SÉPTIMA', 'VIGÉSIMA OCTAVA', 'VIGÉSIMA NOVENA', 'TRIGÉSIMA', 'TRIGÉSIMA PRIMERA', 'TRIGÉSIMA SEGUNDA', 'TRIGÉSIMA TERCERA', 'TRIGÉSIMA CUARTA', 'TRIGÉSIMA QUINTA', 'TRIGÉSIMA SEXTA', 'TRIGÉSIMA SÉPTIMA', 'TRIGÉSIMA OCTAVA', 'TRIGÉSIMA NOVENA', 'CUADRAGÉSIMA', 'CUADRAGÉSIMA PRIMERA', 'CUADRAGÉSIMA SEGUNDA', 'CUADRAGÉSIMA TERCERA', 'CUADRAGÉSIMA CUARTA', 'CUADRAGÉSIMA QUINTA', 'CUADRAGÉSIMA SEXTA', 'CUADRAGÉSIMA SÉPTIMA', 'CUADRAGÉSIMA OCTAVA', 'CUADRAGÉSIMA NOVENA'
	];

	function buscaSubClase(IdClaseContrato) {
		var datos = new FormData();
		datos.append("IdClaseContrato", IdClaseContrato);
		datos.append("proced", 1);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				$('#midiv').html(respuesta);
				// Limpiar cláusulas cuando cambia la clase
				$('#clausulasContainer').html('<p style="color: #666; font-style: italic; text-align: center; padding: 20px;">Seleccione la subclase para cargar las cláusulas correspondientes</p>');
				$('#texto').val(''); // Limpiar texto final
			}
		});
	}

	// FUNCIÓN PRINCIPAL DE REEMPLAZO DE VARIABLES
	function reemplazarVariablesEnTiempo(texto) {
		if (!texto) return '';

		var textoResultado = texto;

		// Buscar todas las variables en el texto usando regex
		var regex = /\{\{([A-Z_]+)\}\}/g;
		var matches = textoResultado.match(regex);

		if (matches) {
			matches.forEach(function(match) {
				var nombreVariable = match.replace(/[\{\}]/g, '');

				if (variablesMap[nombreVariable]) {
					try {
						var valor = variablesMap[nombreVariable]();
						textoResultado = textoResultado.replace(new RegExp('\\{\\{' + nombreVariable + '\\}\\}', 'g'), valor);
					} catch (error) {
						console.error('Error al procesar variable ' + nombreVariable + ':', error);
						// Mantener la variable sin reemplazar en caso de error
					}
				}
			});
		}

		return textoResultado;
	}

	// Función para obtener el nombre del contratista seleccionado
	function obtenerNombreContratista() {
		var textoContratista = $('#tdprov-1').text().trim();
		// Limpiar el texto del contratista (remover elementos HTML)
		var $temp = $('<div>').html(textoContratista);
		return $temp.text().trim() || '';
	}

	function obtenerDocumentoContratista() {
		var textoDocumento = $('#tdnit-1').text().trim();
		var $temp = $('<div>').html(textoDocumento);
		return $temp.text().trim() || '';
	}

	function obtenerDireccionContratista() {
		var direccion = $('#direccionContratista1').val();
		if (!direccion) {
			direccion = 'Dirección no especificada';
		}
		return direccion;
	}

	function obtenerTelefonoContratista() {
		var telefono = $('#telefonoContratista1').val();
		if (!telefono) {
			telefono = 'Teléfono no especificado';
		}
		return telefono;
	}

	//Funcion para mostrar los campos segun contrato
	function muestraCampos(id){

		document.getElementById('div-v0').style.display='';
		document.getElementById('div-v1').style.display='';
		document.getElementById('div-v2').style.display='';
		document.getElementById('div-v3').style.display='';
		document.getElementById('div-boton').style.display='';
				
		// aprendizaje
		if(id==1){

			document.getElementById('div-ffin').style.display='';
			document.getElementById('div-IdCargo').style.display='';
			document.getElementById('div-incs').style.display='';
			document.getElementById('div-especialidad').style.display='';
			document.getElementById('div-grupo').style.display='';
			document.getElementById('div-centrofor').style.display='';
			document.getElementById('div-objeto').style.display='none';
			document.getElementById('div-alcance').style.display='none';
			document.getElementById('div-integral').style.display='none';
			document.getElementById('div-iva').style.display='none';

			document.getElementById('div-ffinfin').style.display='';
			document.getElementById('div-auxilio').style.display='';
			document.getElementById('div-deptol').style.display='none';
			document.getElementById('div-lugar').style.display='none';

			document.getElementById('ffin').setAttribute('required', 'required');
			document.getElementById('ffinfin').setAttribute('required', 'required');
			document.getElementById('IdCargo').setAttribute('required', 'required');
			document.getElementById('especialidad').setAttribute('required', 'required');
			document.getElementById('grupo').setAttribute('required', 'required');
			document.getElementById('centrofor').setAttribute('required', 'required');
			document.getElementById('objeto').removeAttribute('required');
			document.getElementById('alcance').removeAttribute('required');

			document.getElementById('lugar').removeAttribute('required');

			
			document.getElementById('finicio').value='';
			document.getElementById('ffin').value='';
			document.getElementById('ffinfin').value='';
			document.getElementById('valor').value='';
			document.getElementById('IdCargo').value='';
			document.getElementById('especialidad').value='';
			document.getElementById('grupo').value='';
			document.getElementById('centrofor').value='';
			document.getElementById('objeto').value='';
			document.getElementById('alcance').value='';


			document.getElementById('integral-no').checked=true;
			document.getElementById('iva-no').checked=true;

			$('#div-funciones').html('');
			$('#div-responsabilidades').html('');
			$('#div-actividades').html('');
			$('#div-productos').html('');
			$('#div-formapago').html('');

		}
		//obra o labor
		if(id==2){
			
			document.getElementById('div-ffin').style.display='none';
			document.getElementById('div-IdCargo').style.display='';
			document.getElementById('div-incs').style.display='';
			document.getElementById('div-especialidad').style.display='none';
			document.getElementById('div-grupo').style.display='none';
			document.getElementById('div-centrofor').style.display='none';
			document.getElementById('div-objeto').style.display='';
			document.getElementById('div-alcance').style.display='';
			document.getElementById('div-integral').style.display='';
			document.getElementById('div-iva').style.display='none';

			document.getElementById('div-ffinfin').style.display='none';
			document.getElementById('div-auxilio').style.display='';
			document.getElementById('div-deptol').style.display='';
			document.getElementById('div-lugar').style.display='';

			document.getElementById('ffin').removeAttribute('required');
			document.getElementById('ffinfin').removeAttribute('required');
			document.getElementById('IdCargo').setAttribute('required', 'required');
			document.getElementById('especialidad').removeAttribute('required');
			document.getElementById('grupo').removeAttribute('required');
			document.getElementById('centrofor').removeAttribute('required');
			document.getElementById('objeto').setAttribute('required', 'required');
			document.getElementById('alcance').setAttribute('required', 'required');

			document.getElementById('lugar').setAttribute('required', 'required');

			document.getElementById('finicio').value='';
			document.getElementById('ffin').value='';
			document.getElementById('ffinfin').value='';
			document.getElementById('valor').value='';
			document.getElementById('IdCargo').value='';
			document.getElementById('especialidad').value='';
			document.getElementById('grupo').value='';
			document.getElementById('centrofor').value='';
			document.getElementById('objeto').value='';
			document.getElementById('alcance').value='';
			
			document.getElementById('label-objeto').innerHTML='Objeto obra o labor contratada'

			document.getElementById('integral-no').checked=true;
			document.getElementById('iva-no').checked=true;

			$('#div-funciones').html('');
			$('#div-responsabilidades').html('');
			$('#div-actividades').html('Actividades: <span id="nactividades" style="display:none">1</span>'+
																 '<table class="tablita Arial12" width="50%" id="actividades"><col width="95%"><col width="5%">'+
																 		'<tr><td colspan="2"><input type="text" name="actividad[1]" id="actividad-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 actividades" ></td></tr></table>'+
																		'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaActividad()" >Agregar actividad</button>');
			$('#div-productos').html('');
			$('#div-formapago').html('');
		}

		//termino fijo
		if(id==3){

			document.getElementById('div-ffin').style.display='';
			document.getElementById('div-IdCargo').style.display='';
			document.getElementById('div-incs').style.display='';
			document.getElementById('div-especialidad').style.display='none';
			document.getElementById('div-grupo').style.display='none';
			document.getElementById('div-centrofor').style.display='none';
			document.getElementById('div-objeto').style.display='none';
			document.getElementById('div-alcance').style.display='';
			document.getElementById('div-integral').style.display='';
			document.getElementById('div-iva').style.display='none';

			document.getElementById('div-ffinfin').style.display='none';
			document.getElementById('div-auxilio').style.display='';
			document.getElementById('div-deptol').style.display='';
			document.getElementById('div-lugar').style.display='';

			document.getElementById('ffin').setAttribute('required', 'required');
			document.getElementById('ffinfin').removeAttribute('required');
			document.getElementById('IdCargo').setAttribute('required', 'required');
			document.getElementById('especialidad').removeAttribute('required');
			document.getElementById('grupo').removeAttribute('required');
			document.getElementById('centrofor').removeAttribute('required');
			document.getElementById('objeto').removeAttribute('required');
			document.getElementById('alcance').setAttribute('required', 'required');

			document.getElementById('lugar').setAttribute('required', 'required');

			document.getElementById('finicio').value='';
			document.getElementById('ffin').value='';
			document.getElementById('ffinfin').value='';
			document.getElementById('valor').value='';
			document.getElementById('IdCargo').value='';
			document.getElementById('especialidad').value='';
			document.getElementById('grupo').value='';
			document.getElementById('centrofor').value='';
			document.getElementById('objeto').value='';
			document.getElementById('alcance').value='';

			
			document.getElementById('integral-no').checked=true;
			document.getElementById('iva-no').checked=true;

			$('#div-funciones').html('');
			$('#div-responsabilidades').html('');

			$('#div-actividades').html('Actividades: <span id="nactividades" style="display:none">1</span>'+
																 '<table class="tablita Arial12" width="50%" id="actividades"><col width="95%"><col width="5%">'+
																 		'<tr><td colspan="2"><input type="text" name="actividad[1]" id="actividad-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 actividades" ></td></tr></table>'+
																		'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaActividad()" >Agregar actividad</button>');

			$('#div-productos').html('Productos: <span id="nproductos" style="display:none">1</span>'+
																'<table class="tablita Arial12" width="50%" id="productos"><col width="95%"><col width="5%">'+
																	'<tr><td colspan="2"><input type="text" name="producto[1]" id="producto-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 productos" ></td></tr></table>'+
																	'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaProducto()" >Agregar producto</button>');

			$('#div-formapago').html('');
			
		}

		//indefinido
		if(id==4){

			document.getElementById('div-ffin').style.display='none';
			document.getElementById('div-IdCargo').style.display='';
			document.getElementById('div-incs').style.display='';
			document.getElementById('div-especialidad').style.display='none';
			document.getElementById('div-grupo').style.display='none';
			document.getElementById('div-centrofor').style.display='none';
			document.getElementById('div-objeto').style.display='none';
			document.getElementById('div-alcance').style.display='none';
			document.getElementById('div-integral').style.display='';
			document.getElementById('div-iva').style.display='none';

			document.getElementById('div-ffinfin').style.display='none';
			document.getElementById('div-auxilio').style.display='';
			document.getElementById('div-deptol').style.display='';
			document.getElementById('div-lugar').style.display='';

			document.getElementById('ffin').removeAttribute('required');
			document.getElementById('ffinfin').removeAttribute('required');
			document.getElementById('IdCargo').setAttribute('required', 'required');
			document.getElementById('especialidad').removeAttribute('required');
			document.getElementById('grupo').removeAttribute('required');
			document.getElementById('centrofor').removeAttribute('required');
			document.getElementById('objeto').removeAttribute('required');
			document.getElementById('alcance').removeAttribute('required');

			document.getElementById('lugar').setAttribute('required', 'required');

			document.getElementById('finicio').value='';
			document.getElementById('ffin').value='';
			document.getElementById('ffinfin').value='';
			document.getElementById('valor').value='';
			document.getElementById('IdCargo').value='';
			document.getElementById('especialidad').value='';
			document.getElementById('grupo').value='';
			document.getElementById('centrofor').value='';
			document.getElementById('objeto').value='';
			document.getElementById('alcance').value='';

			
			document.getElementById('integral-no').checked=true;
			document.getElementById('iva-no').checked=true;

			$('#div-funciones').html('Funciones: <span id="nfunciones" style="display:none">1</span>'+
																'<table class="tablita Arial12" width="50%" id="funciones"><col width="95%"><col width="5%">'+
																'<tr><td colspan="2"><input type="text" name="funcion[1]" id="funcion-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 funciones"></td></tr></table>'+
																'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaFuncion()" >Agregar función</button>');

			$('#div-responsabilidades').html('Responsabilidades: <span id="nresponsabilidades" style="display:none">1</span>'+
																				'<table class="tablita Arial12" width="50%" id="responsabilidades"><col width="95%"><col width="5%">'+
																				'<tr><td colspan="2"><input type="text" name="responsabilidad[1]" id="responsabilidad-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 responsabilidades"></td></tr></table>'+
																				'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaResponsabilidad()">Agregar responsabilidad</button>');

			$('#div-actividades').html('');
			$('#div-productos').html('');
			$('#div-formapago').html('');
			
		}

		//ps personas
		if(id==5){

			document.getElementById('div-ffin').style.display='';
			document.getElementById('div-IdCargo').style.display='none';
			document.getElementById('div-incs').style.display='none';
			document.getElementById('div-especialidad').style.display='none';
			document.getElementById('div-grupo').style.display='none';
			document.getElementById('div-centrofor').style.display='none';
			document.getElementById('div-objeto').style.display='';
			document.getElementById('div-alcance').style.display='';
			document.getElementById('div-integral').style.display='none';
			document.getElementById('div-iva').style.display='';

			document.getElementById('div-ffinfin').style.display='none';
			document.getElementById('div-auxilio').style.display='none';
			document.getElementById('div-deptol').style.display='none';
			document.getElementById('div-lugar').style.display='none';

			document.getElementById('ffin').setAttribute('required', 'required');
			document.getElementById('ffinfin').removeAttribute('required');
			document.getElementById('IdCargo').removeAttribute('required');
			document.getElementById('especialidad').removeAttribute('required');
			document.getElementById('grupo').removeAttribute('required');
			document.getElementById('centrofor').removeAttribute('required');
			document.getElementById('objeto').setAttribute('required', 'required');
			document.getElementById('alcance').setAttribute('required', 'required');

			document.getElementById('finicio').value='';
			document.getElementById('ffin').value='';
			document.getElementById('ffinfin').value='';
			document.getElementById('valor').value='';
			document.getElementById('IdCargo').value='';
			document.getElementById('especialidad').value='';
			document.getElementById('grupo').value='';
			document.getElementById('centrofor').value='';
			document.getElementById('objeto').value='';
			document.getElementById('alcance').value='';

			document.getElementById('lugar').removeAttribute('required');

			
			document.getElementById('label-objeto').innerHTML='Objeto:'

			document.getElementById('integral-no').checked=true;
			document.getElementById('iva-no').checked=true;

			$('#div-funciones').html('');
			$('#div-responsabilidades').html('');

			$('#div-actividades').html('Actividades: <span id="nactividades" style="display:none">1</span>'+
																 '<table class="tablita Arial12" width="50%" id="actividades"><col width="95%"><col width="5%">'+
																 		'<tr><td colspan="2"><input type="text" name="actividad[1]" id="actividad-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 actividades" ></td></tr></table>'+
																		'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaActividad()" >Agregar actividad</button>');

			$('#div-productos').html('Productos: <span id="nproductos" style="display:none">1</span>'+
																'<table class="tablita Arial12" width="50%" id="productos"><col width="95%"><col width="5%">'+
																	'<tr><td colspan="2"><input type="text" name="producto[1]" id="producto-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 productos" ></td></tr></table>'+
																	'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaProducto()" >Agregar producto</button>');

			$('#div-formapago').html('Forma de pago: <span id="numpagos" style="display:none">1</span>'+
																'<table class="tablita Arial12" width="50%" id="pagos"><col width="15%"><col width="80%"><col width="5%">'+
																'<tr class="titulos" ><td>%</td><td colspan="2">Condición</td></tr>'+
																'<tr><td><input type="number" name="porpago[1]" id="porpago-1" class="campo-xs Arial12 porpago"></td>'+
																'<td colspan="2"><input type="text" name="concepto[1]" id="concepto-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 concepto"></td></tr></table>'+
																'<button type="button" class="btn btn-verde btn-xs1" onClick=agregaPago() >Agregar pago</button>');
			
		}
		//ps empresas
		if(id==6){
			
			document.getElementById('div-ffin').style.display='';
			document.getElementById('div-IdCargo').style.display='none';
			document.getElementById('div-incs').style.display='none';
			document.getElementById('div-especialidad').style.display='none';
			document.getElementById('div-grupo').style.display='none';
			document.getElementById('div-centrofor').style.display='none';
			document.getElementById('div-objeto').style.display='';
			document.getElementById('div-alcance').style.display='';
			document.getElementById('div-integral').style.display='none';
			document.getElementById('div-iva').style.display='';

			document.getElementById('div-ffinfin').style.display='none';
			document.getElementById('div-auxilio').style.display='none';
			document.getElementById('div-deptol').style.display='none';
			document.getElementById('div-lugar').style.display='none';

			document.getElementById('ffin').setAttribute('required', 'required');
			document.getElementById('ffinfin').removeAttribute('required');
			document.getElementById('IdCargo').removeAttribute('required');
			document.getElementById('especialidad').removeAttribute('required');
			document.getElementById('grupo').removeAttribute('required');
			document.getElementById('centrofor').removeAttribute('required');
			document.getElementById('objeto').setAttribute('required', 'required');
			document.getElementById('alcance').setAttribute('required', 'required');

			document.getElementById('finicio').value='';
			document.getElementById('ffin').value='';
			document.getElementById('ffinfin').value='';
			document.getElementById('valor').value='';
			document.getElementById('IdCargo').value='';
			document.getElementById('especialidad').value='';
			document.getElementById('grupo').value='';
			document.getElementById('centrofor').value='';
			document.getElementById('objeto').value='';
			document.getElementById('alcance').value='';

			document.getElementById('lugar').removeAttribute('required');
			
			document.getElementById('label-objeto').innerHTML='Objeto:'

			document.getElementById('integral-no').checked=true;
			document.getElementById('iva-no').checked=true;

			$('#div-funciones').html('');
			$('#div-responsabilidades').html('');

			$('#div-actividades').html('Actividades: <span id="nactividades" style="display:none">1</span>'+
																 '<table class="tablita Arial12" width="50%" id="actividades"><col width="95%"><col width="5%">'+
																 		'<tr><td colspan="2"><input type="text" name="actividad[1]" id="actividad-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 actividades" ></td></tr></table>'+
																		'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaActividad()" >Agregar actividad</button>');

			$('#div-productos').html('Productos: <span id="nproductos" style="display:none">1</span>'+
																'<table class="tablita Arial12" width="50%" id="productos"><col width="95%"><col width="5%">'+
																	'<tr><td colspan="2"><input type="text" name="producto[1]" id="producto-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 productos" ></td></tr></table>'+
																	'<button type="button" class="btn btn-verde btn-xs1" onClick="agregaProducto()" >Agregar producto</button>');

			$('#div-formapago').html('Forma de pago: <span id="numpagos" style="display:none">1</span>'+
																'<table class="tablita Arial12" width="50%" id="pagos"><col width="15%"><col width="80%"><col width="5%">'+
																'<tr class="titulos" ><td>%</td><td colspan="2">Condición</td></tr>'+
																'<tr><td><input type="number" name="porpago[1]" id="porpago-1" class="campo-xs Arial12 porpago"></td>'+
																'<td colspan="2"><input type="text" name="concepto[1]" id="concepto-1" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 concepto"></td></tr></table>'+
																'<button type="button" class="btn btn-verde btn-xs1" onClick=agregaPago() >Agregar pago</button>');
		}
	}

	// FUNCIONES DE FORMATEO
	function formatearMoneda(valor) {
		if (!valor) return '';
		var numero = parseFloat(valor);
		return new Intl.NumberFormat('es-CO', {
			style: 'currency',
			currency: 'COP',
			minimumFractionDigits: 0
		}).format(numero);
	}

	function formatearMonedaCompleta(valor) {
		if (!valor) return '';
		var numero = parseFloat(valor);
		var formato = formatearMoneda(numero);
		return ' (' + formato + ') ' + numeroALetras(numero);
	}

	function formatearFecha(fecha) {
		if (!fecha) return '';
		var f = new Date(fecha);
		return f.toLocaleDateString('es-CO');
	}

	function formatearFechaCompleta(fecha) {
		if (!fecha) return '';
		var f = new Date(fecha);
		var dia = f.getDate();
		var mes = f.getMonth();
		var anio = f.getFullYear();

		return dia + ' de ' + obtenerNombreMes(mes) + ' de ' + anio;
	}

	function formatearFechaEscrita(fecha) {
		if (!fecha) return '';
		var f = new Date(fecha);
		var dia = convertirNumeroATexto(f.getDate());
		var mes = obtenerNombreMes(f.getMonth());
		var anio = f.getFullYear();

		return 'día ' + dia + ' (' + f.getDate() + ') de ' + mes + ' del año ' + anio;
	}

	function obtenerNombreMes(numeroMes) {
		var meses = [
			'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
			'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
		];
		return meses[numeroMes] || '';
	}

	function convertirNumeroATexto(numero) {
		var numeros = {
			1: 'uno',
			2: 'dos',
			3: 'tres',
			4: 'cuatro',
			5: 'cinco',
			6: 'seis',
			7: 'siete',
			8: 'ocho',
			9: 'nueve',
			10: 'diez',
			11: 'once',
			12: 'doce',
			13: 'trece',
			14: 'catorce',
			15: 'quince',
			16: 'dieciséis',
			17: 'diecisiete',
			18: 'dieciocho',
			19: 'diecinueve',
			20: 'veinte',
			21: 'veintiuno',
			22: 'veintidós',
			23: 'veintitrés',
			24: 'veinticuatro',
			25: 'veinticinco',
			26: 'veintiséis',
			27: 'veintisiete',
			28: 'veintiocho',
			29: 'veintinueve',
			30: 'treinta',
			31: 'treinta y uno'
		};
		return numeros[numero] || numero.toString();
	}

	function calcularDuracion(fechaInicio, fechaFin) {
		if (!fechaInicio || !fechaFin) return '';

		var inicio = new Date(fechaInicio);
		var fin = new Date(fechaFin);
		var diferencia = fin - inicio;
		var dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

		if (dias <= 0) return '';

		var meses = Math.floor(dias / 30);
		var diasRestantes = dias % 30;

		var resultado = '';
		if (meses > 0) {
			resultado += meses + (meses === 1 ? ' mes' : ' meses');
			if (diasRestantes > 0) {
				resultado += ' y ' + diasRestantes + (diasRestantes === 1 ? ' día' : ' días');
			}
		} else {
			resultado = diasRestantes + (diasRestantes === 1 ? ' día' : ' días');
		}

		return resultado;
	}

	// FUNCIÓN PARA ACTUALIZAR TODAS LAS CLÁUSULAS CON VARIABLES
	function actualizarTodasLasClausulasConVariables() {
		var clausulasActualizadas = 0;

		$('.clausula-textarea').each(function() {
			var $textarea = $(this);
			var textoOriginal = $textarea.data('texto-original');

			if (textoOriginal) {
				var textoActualizado = reemplazarVariablesEnTiempo(textoOriginal);
				$textarea.val(textoActualizado);
				clausulasActualizadas++;
			}
		});

		// Actualizar el texto final
		actualizarTextoFinal();

		// Mostrar mensaje de confirmación
		if (clausulasActualizadas == 0) {
			mostrarMensajeAdvertencia('No se encontraron cláusulas para actualizar');
		}
	}

	// FUNCIÓN PARA MOSTRAR INFORMACIÓN DE VARIABLES DISPONIBLES
	function mostrarVariablesDisponibles() {
		var variablesDisponibles = Object.keys(variablesMap);
		var mensaje = 'Variables disponibles para usar en las cláusulas:\n\n';

		variablesDisponibles.forEach(function(variable) {
			mensaje += '{{' + variable + '}}<br>';
		});

		mensaje += '<br>Ejemplo de uso: El contratista {{CONTRATISTA_NOMBRE}} se compromete a...';

		if (typeof swal !== 'undefined') {
			swal({
				html: mensaje,
				type: "info",
				confirmButtonText: "¡Entendido!"
			});
		} else {
			alert(mensaje);
		}
	}

	// FUNCIONES DE MENSAJES
	function mostrarMensajeAdvertencia(mensaje) {
		if (typeof swal !== 'undefined') {
			swal({
				text: mensaje,
				type: "warning",
				confirmButtonText: "¡Entendido!"
			});
		} else {
			alert(mensaje);
		}
	}

	// FUNCIÓN PARA CREAR EL BOTÓN DE ACTUALIZACIÓN DE VARIABLES
	function crearBotonActualizarVariables() {
		var botonHtml = `
        <div class="variables-controls" style="margin: 10px 0; text-align: center; border-top: 1px solid #ddd; padding-top: 15px;">
            <button type="button" class="btn-actualizar-variables" onclick="actualizarTodasLasClausulasConVariables()" 
                    style="background: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; margin-right: 10px; cursor: pointer;">
                🔄 Actualizar Variables
            </button>
            <button type="button" class="btn-mostrar-variables" onclick="mostrarVariablesDisponibles()" 
                    style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                📋 Ver Variables Disponibles
            </button>
        </div>
    `;

		return botonHtml;
	}

	// function cargarClausulasConVariables() {
	// 	var IdClaseContrato = document.getElementById('IdClase').value;
	// 	var IdSubClase = document.getElementById('IdSubClase').value;

	// 	if (IdClaseContrato == '' || IdSubClase == '') {
	// 		$('#clausulasContainer').html('<p style="color: #666; font-style: italic; text-align: center; padding: 20px;">Seleccione clase y subclase para cargar las cláusulas</p>');
	// 		$('#texto').val('');
	// 		return;
	// 	}

	// 	$('#clausulasContainer').html('<p style="color: #666; text-align: center; padding: 20px;">Cargando cláusulas...</p>');

	// 	var datos = new FormData();
	// 	datos.append("IdClaseContrato", IdClaseContrato);
	// 	datos.append("IdSubClase", IdSubClase);
	// 	datos.append("proced", 8);

	// 	$.ajax({
	// 		url: "ajax.php",
	// 		method: "POST",
	// 		data: datos,
	// 		cache: false,
	// 		contentType: false,
	// 		processData: false,
	// 		success: function(respuesta) {
	// 			// Agregar el botón de actualizar variables al final de la respuesta
	// 			var respuestaConBotones = respuesta + crearBotonActualizarVariables();
	// 			$('#clausulasContainer').html(respuestaConBotones);

	// 			// Actualizar automáticamente las variables al cargar
	// 			setTimeout(function() {
	// 				actualizarTodasLasClausulasConVariables();
	// 			}, 200);
	// 		},
	// 		error: function() {
	// 			$('#clausulasContainer').html('<p style="color: red; text-align: center; padding: 20px;">Error al cargar las cláusulas</p>');
	// 		}
	// 	});
	// }

	// function actualizarTextoFinal() {
	// 	var textoFinal = '';
	// 	var textoFinalHTML = '';

	// 	$('.clausula-item textarea').each(function() {
	// 		var numeral = $(this).data('numeral');
	// 		var contenido = $(this).val().trim();

	// 		if (contenido != '') {
	// 			// Para el campo oculto (mantener formato original)
	// 			textoFinal += numeral + '. ' + contenido + '\n\n';

	// 			// Para visualización: convertir saltos de línea a HTML
	// 			var contenidoHTML = contenido
	// 				.replace(/\n\n+/g, '<br><br>') // Párrafos
	// 				.replace(/\n/g, '<br>') // Saltos simples
	// 				.replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;'); // Tabs

	// 			textoFinalHTML += `<strong>${numeral}.</strong> ${contenidoHTML}<br><br>`;
	// 		}
	// 	});

	// 	// Actualizar ambos campos
	// 	$('#texto').val(textoFinal);

	// 	if ($('#textoVisible').length) {
	// 		$('#textoVisible').html(textoFinalHTML);
	// 	}
	// }

	// NUEVA FUNCIÓN: Crear nueva cláusula
	// function crearNuevaClausula() {
	// 	var totalClausulas = $('.clausula-item').length;
	// 	var siguienteNumeral = numerales[totalClausulas] || 'CLÁUSULA ' + (totalClausulas + 1);

	// 	var nuevaClausulaHtml = `
  //       <div class="clausula-item clausula-nueva" data-original-numeral="${siguienteNumeral}">
  //           <div class="clausula-header">
  //               <span class="numeral-display">${siguienteNumeral}</span>
  //               <div class="clausula-actions">
  //                   <button type="button" class="btn-mini btn-rojo" onclick="eliminarClausula(this)" title="Eliminar cláusula">
  //                       ×
  //                   </button>
  //               </div>
  //           </div>
  //           <div class="clausula-content">
  //               <textarea class="clausula-textarea" 
  //                         name="clausula_texto[]"
  //                         data-numeral="${siguienteNumeral}"
  //                         placeholder="Escriba el contenido de esta nueva cláusula..."></textarea>
  //               <input type="hidden" name="clausula_numeral[]" value="${siguienteNumeral}">
  //           </div>
  //       </div>
  //   `;

	// 	// Si no hay cláusulas, reemplazar todo el contenedor
	// 	if (totalClausulas === 0) {
	// 		$('#clausulasContainer').html(nuevaClausulaHtml +
	// 			'<div class="nueva-clausula-container">' +
	// 			'<button type="button" class="btn-crear-clausula" onclick="crearNuevaClausula()">' +
	// 			'+ Agregar Otra Cláusula' +
	// 			'</button>' +
	// 			'</div>');
	// 	} else {
	// 		// Insertar antes del botón de crear
	// 		$('.nueva-clausula-container').before(nuevaClausulaHtml);
	// 	}

	// 	// Reorganizar numerales
	// 	reorganizarClausulas();

	// 	// Enfocar en el nuevo textarea
	// 	setTimeout(function() {
	// 		$('.clausula-nueva textarea').focus();
	// 		$('.clausula-nueva textarea').get(0).setSelectionRange(0, 0); // Cursor al inicio
	// 		$('.clausula-nueva').removeClass('clausula-nueva'); // Remover clase temporal
	// 	}, 100);

	// 	// Actualizar texto final
	// 	actualizarTextoFinal();
	// }

	// Eliminar cláusula
	// function eliminarClausula(boton) {
	// 	var clausulaItem = $(boton).closest('.clausula-item');
	// 	var numeral = clausulaItem.find('.numeral-display').text();

	// 	// Confirmación
	// 	swal({
	// 		text: '¿Está seguro de que desea eliminar la cláusula "' + numeral + '"?',
	// 		type: "warning",
	// 		showCancelButton: true,
	// 		confirmButtonColor: '#28a745',
	// 		cancelButtonColor: '#d33',
	// 		confirmButtonText: "¡Si!",
	// 		cancelButtonText: "¡No!",
	// 	}).then((result) => {
	// 		if (!result.isConfirmed) return;
	// 		// Eliminar la cláusula
	// 		clausulaItem.remove();

	// 		// Reorganizar las cláusulas restantes
	// 		reorganizarClausulas();

	// 		// Actualizar texto final
	// 		actualizarTextoFinal();

	// 		// Si no quedan cláusulas, mostrar mensaje y botón para crear
	// 		if ($('.clausula-item').length === 0) {
	// 			$('#clausulasContainer').html(
	// 				'<div class="sin-clausulas">' +
	// 				'<div style="text-align: center; padding: 20px; color: #666;">' +
	// 				'<p>No hay cláusulas. Puede crear una nueva cláusula usando el botón de abajo.</p>' +
	// 				'</div>' +
	// 				'<div class="nueva-clausula-container">' +
	// 				'<button type="button" class="btn-crear-clausula" onclick="crearNuevaClausula()">' +
	// 				'+ Crear Primera Cláusula' +
	// 				'</button>' +
	// 				'</div>' +
	// 				'</div>'
	// 			);
	// 		}
	// 	});
	// }

	// NUEVA FUNCIÓN: Reorganizar cláusulas automáticamente
	// function reorganizarClausulas() {
	// 	var clausulas = $('.clausula-item');

	// 	clausulas.each(function(index) {
	// 		var nuevoNumeral = numerales[index] || 'CLÁUSULA ' + (index + 1);
	// 		var clausulaItem = $(this);

	// 		// Actualizar el numeral mostrado
	// 		clausulaItem.find('.numeral-display').text(nuevoNumeral);

	// 		// Actualizar el data-numeral del textarea
	// 		clausulaItem.find('textarea').attr('data-numeral', nuevoNumeral);

	// 		// Actualizar el input hidden
	// 		clausulaItem.find('input[name="clausula_numeral[]"]').val(nuevoNumeral);

	// 		// Actualizar el texto del textarea si empieza con el numeral anterior
	// 		var textarea = clausulaItem.find('textarea');
	// 		var contenidoActual = textarea.val();

	// 		// Si el contenido empieza con un numeral, reemplazarlo
	// 		var regex = /^(PRIMERA|SEGUNDA|TERCERA|CUARTA|QUINTA|SEXTA|SÉPTIMA|OCTAVA|NOVENA|DÉCIMA|DÉCIMA \w+|VIGÉSIMA|CLÁUSULA \d+)\./;
	// 		if (regex.test(contenidoActual)) {
	// 			contenidoActual = contenidoActual.replace(regex, nuevoNumeral + '.');
	// 			textarea.val(contenidoActual);
	// 		}
	// 	});
	// }

	function buscaContratista(obj, valor, id) {
		// console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


		if (arrayId[0] == 'contratista') {
			if ($('#ch-' + arrayId[1]).is(':visible')) {

			} else {
				$('#ch-' + arrayId[1]).slideToggle();
			}
		} else {
			if ($('#cch-' + arrayId[1]).is(':visible')) {

			} else {
				$('#cch-' + arrayId[1]).slideToggle();
			}
		}


		var datos = new FormData();
		datos.append("valor", valor);
		datos.append("item", arrayId[1]);
		datos.append("proced", 6);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				//console.log(respuesta)
				if (arrayId[0] == 'contratista') {
					document.getElementById('ch-' + arrayId[1]).innerHTML = respuesta
				} else {
					document.getElementById('cch-' + arrayId[1]).innerHTML = respuesta
				}
			}
		})
	}

	function buscaContratistan(obj, valor, id) {
		// console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


		if (arrayId[0] == 'contratistan') {
			if ($('#chn-' + arrayId[1]).is(':visible')) {

			} else {
				$('#chn-' + arrayId[1]).slideToggle();
			}
		} else {
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
				if (arrayId[0] == 'contratistan') {
					document.getElementById('chn-' + arrayId[1]).innerHTML = respuesta
				} else {
					document.getElementById('cchn-' + arrayId[1]).innerHTML = respuesta
				}
			}
		})
	}

	function llenar(id, nombre, item, documento, telefono, direccion) {
		$('#cambiaContratista').modal('hide');
		// console.log(id, nombre, item,documento)
		var item1 = "'" + item + "'"
		$('#tdprov-' + item).html(
			'<div style="width: 320px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratista(' + item1 + ')">' + nombre + '</div>' +
			'<input type="hidden" name="contratista" id="contratista' + item + '" value="' + id + '">' +
			'<input type="hidden" name="telefonoContratista" id="telefonoContratista' + item + '" value="' + telefono + '">' +
			'<input type="hidden" name="direccionContratista" id="direccionContratista' + item + '" value="' + direccion + '">'
		);
		$('#tdnit-' + item).html(
			'<div style="width:160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratistan(' + item1 + ')">' + documento + '</div>'
		);
	}

	function modal(item, id) {
		const miDiv = document.getElementById('ch-' + item);
		const miDiv1 = document.getElementById('chn-' + item);
		if (miDiv) {
			document.getElementById('ch-' + item).style.display = 'none';
		}
		if (miDiv1) {
			document.getElementById('chn-' + item).style.display = 'none';
		}
		document.getElementById('itemp').value = item;
		$('#cambiaContratista').modal('hide');
		$('#creacargo').modal({
			backdrop: 'static',
			keyboard: false
		});

	}

	function cambiaContratista(item) {
		$('#divCambContratista').html(
			'<input type="text" class="campo-xs" id="contratis-' + item + '" onKeyUp="buscaContratista(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdContratista" value="0">' +
			'<div class="drop"><ul class="hijos" id="cch-' + item + '"></ul></div>'
		);
		$('#cambiaContratista').modal({
			backdrop: 'static',
			keyboard: false
		});
	}

	function cambiaContratistan(item) {
		$('#divCambContratista').html(
			'<input type="text" class="campo-xs" id="contratis-' + item + '" onKeyUp="buscaContratistan(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdContratista" value="0">' +
			'<div class="drop"><ul class="hijos" id="cchn-' + item + '"></ul></div>'
		);
		$('#cambiaContratista').modal({
			backdrop: 'static',
			keyboard: false
		});
	}

	function buscamun(IdDepartamento, id) {
		var datos = new FormData();
		datos.append("IdDepartamento", IdDepartamento);
		datos.append("proced", 4);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				var res = respuesta.trim();
				var arregloTabla = JSON.parse(respuesta);
				if (id == "depto") {
					var fila = '<select name="municipio" id="municipio" class="campo-xs Arial12" required="required" >' +
						'<option value="">Seleccione</option>';
				}
				if (id == "depton") {
					var fila = '<select name="municipion" id="municipion" class="campo-xs Arial12" required="required" >' +
						'<option value="">Seleccione</option>';
				}
				if (id == "deptoe") {
					var fila = '<select name="municipioe" id="municipioe" class="campo-xs Arial12">' +
						'<option value="">Seleccione</option>';
				}
				if (id == "deptol") {
					var fila = '<select name="lugar" id="lugar" class="campo-sm Arial12" required="required">' +
						'<option value="">Seleccione</option>';
				}



				Object.keys(arregloTabla).forEach(key => {
					// console.log(key,arregloTabla[key] )
					fila = fila + '<option value="' + key + '">' + arregloTabla[key] + '</option>'
				});
				fila = fila + '</select>';
				if (id == "depto") {
					$('#midiv2').html(fila);
				}
				if (id == "depton") {
					$('#midiv1').html(fila);
				}
				if (id == "deptoe") {
					$('#midiv0').html(fila);
				}
				if (id == "deptol") {
					$('#midiv4').html(fila);
				}
			}
		});
	}

	function graba() {
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
		var email = document.getElementById('email').value;

		var replegal = document.getElementById('replegal').value;
		var IdClasedocrep = document.getElementById('IdClasedocrep').value;
		var docrep = document.getElementById('docrep').value;
		var municipioe = document.getElementById('municipioe').value;

		if (proveedor == "") {
			document.getElementById('proveedor').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL PROVEEDOR!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (IdClasedoc == "") {
			document.getElementById('IdClasedoc').focus();
			swal({
				text: "¡DEBE SELECCIONAR LA CLASE DE DOCUMENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (nit == "") {
			document.getElementById('nit').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL NIT!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (fconstitucion == "") {
			document.getElementById('fconstitucion').focus();
			swal({
				text: "¡DEBE ESCRIBIR LA FECHA DE COSNTITUCION O DE NACIMIENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (depton == "") {
			document.getElementById('depton').focus();
			swal({
				text: "¡DEBE SELECCIONAR EL DEPARTAMENTO DE CONSTITUCION O DE NACIMIENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}


		if (municipion == "") {
			document.getElementById('municipion').focus();
			swal({
				text: "¡DEBE SELECCIONAR EL MUNICIPIO DE CONSTITUCION O DE NACIMIENTO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (direccion == "") {
			document.getElementById('direccion').focus();
			swal({
				text: "¡DEBE ESCRIBIR LA DIRECCION!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (telefono == "") {
			document.getElementById('telefono').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL TELEFONO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (email == "") {
			document.getElementById('email').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL EMAIL!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (depto == "") {
			document.getElementById('depto').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL DEPARTAMENTO DEL DOMICILIO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		if (municipio == "") {
			document.getElementById('municipio').focus();
			swal({
				text: "¡DEBE ESCRIBIR EL MUNICIPIO DEL DOMICILIO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});
			return;
		}

		var datos = new FormData();
		datos.append("proveedor", proveedor);
		datos.append("nit", nit);
		datos.append("IdClasedoc", IdClasedoc);
		datos.append("fconstitucion", fconstitucion);
		datos.append("depton", depton);
		datos.append("municipion", municipion);
		datos.append("direccion", direccion);
		datos.append("telefono", telefono);
		datos.append("depto", depto);
		datos.append("municipio", municipio);
		datos.append("email", email);

		datos.append("replegal", replegal);
		datos.append("IdClasedocrep", IdClasedocrep);
		datos.append("docrep", docrep);
		datos.append("municipioe", municipioe);

		datos.append("proced", 5);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				document.getElementById('formulario').reset();
				$("#creacargo").modal('hide');
				respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
				console.log(respuesta);
				var matriz = respuesta.split(",");
				if (matriz[0] == "ok") {
					swal({
						text: "¡EL CONTRATISTA FUE CREADO!",
						type: "success",
						confirmButtonText: "¡Cerrar!"
					});
					llenar(matriz[1], matriz[2], item, matriz[3], matriz[4], matriz[5]);

				}
				if (matriz[0] == "ya") {
					swal({

						html: '<div class="Arial16">EL DOCUMENTO DIGITADO YA ESTA EN LA BASE DE DATOS Y CORRESPONDE A:</div><div class="Arial16" style="font-weight: bold">' + matriz[2] + '</div><div class="Arial16">¿DESEA ASIGNARLO?</div>',
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#28a745',
						cancelButtonColor: '#d33',
						confirmButtonText: "¡Si!",
						cancelButtonText: "¡No!",
					}).then((result) => {
						if (!result.isConfirmed) return;

						llenar(matriz[1], matriz[2], item, matriz[3], matriz[4], matriz[5]);
					});

				}
			}
		});

	}

	function agregaPago(){
		var a=parseFloat(document.getElementById('numpagos').innerHTML);
  	a=a+1;

		var fila = '<td><input type="number" name="porpago['+a+']" id="porpago-'+a+'" class="campo-xs Arial12 porpago"></td>'+
							 '<td><input type="text" name="concepto['+a+']" id="concepto-'+a+'" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 concepto"></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deletePago(this)"></td>'

		document.getElementById("pagos").insertRow(-1).innerHTML = fila;
  	document.getElementById('numpagos').innerHTML=a;
	}

	function deletePago(btn) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('numpagos').innerHTML);
		a=a-1;
		document.getElementById('numpagos').innerHTML=a;

		recuentoPagos()
	}

	function recuentoPagos(){

		var porpago = document.querySelectorAll('.porpago');
		var concepto = document.querySelectorAll('.concepto');
		
		for(var i=0;i<porpago.length;i++){
			porpago[i].setAttribute("name", 'porpago['+(i+1)+"]");
			concepto[i].setAttribute("name", 'concepto['+(i+1)+"]");

			porpago[i].setAttribute("id", 'porpago-'+(i+1));
			concepto[i].setAttribute("id", 'concepto-'+(i+1));			
			
		}

	}

	function agregaProducto(){
		var a=parseFloat(document.getElementById('nproductos').innerHTML);
  	a=a+1;

		var fila = '<td><input type="text" name="producto['+a+']" id="producto-'+a+'" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 productos"></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteProducto(this)"></td>';

		document.getElementById("productos").insertRow(-1).innerHTML = fila;
  	document.getElementById('nproductos').innerHTML=a;
	}

	function deleteProducto(btn) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nproductos').innerHTML);
		a=a-1;
		document.getElementById('nproductos').innerHTML=a;

		recuentoProductos()
	}

	function recuentoProductos(){

		var productos = document.querySelectorAll('.productos');
				
		for(var i=0;i<productos.length;i++){
			productos[i].setAttribute("name", 'producto['+(i+1)+"]");			
			productos[i].setAttribute("id", 'producto-'+(i+1));
			
		}

	}

	function agregaActividad(){
		var a=parseFloat(document.getElementById('nactividades').innerHTML);
  	a=a+1;

		var fila = '<td><input type="text" name="actividad['+a+']" id="actividad-'+a+' "onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 actividades"></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteActividad(this)"></td>';

		document.getElementById("actividades").insertRow(-1).innerHTML = fila;
  	document.getElementById('nactividades').innerHTML=a;
	}

	function deleteActividad(btn) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nactividades').innerHTML);
		a=a-1;
		document.getElementById('nactividades').innerHTML=a;

		recuentoActividades()
	}

	function recuentoActividades(){

		var actividades = document.querySelectorAll('.actividades');
				
		for(var i=0;i<actividades.length;i++){
			actividades[i].setAttribute("name", 'actividad['+(i+1)+"]");			
			actividades[i].setAttribute("id", 'actividad-'+(i+1));
			
		}

	}

	function agregaResponsabilidad(){
		var a=parseFloat(document.getElementById('nresponsabilidades').innerHTML);
  	a=a+1;

		var fila = '<td><input type="text" name="responsabilidad['+a+']" id="responsabilidad-'+a+'" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 responsabilidades"></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteResponsabilidad(this)"></td>';

		document.getElementById("responsabilidades").insertRow(-1).innerHTML = fila;
  	document.getElementById('nresponsabilidades').innerHTML=a;
	}

	function deleteResponsabilidad(btn) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nresponsabilidades').innerHTML);
		a=a-1;
		document.getElementById('nresponsabilidades').innerHTML=a;

		recuentoResponsabilidades()
	}

	function recuentoResponsabilidades(){

		var responsabilidades = document.querySelectorAll('.responsabilidades');
				
		for(var i=0;i<responsabilidades.length;i++){
			responsabilidades[i].setAttribute("name", 'responsabilidad['+(i+1)+"]");			
			responsabilidades[i].setAttribute("id", 'responsabilidad-'+(i+1));
			
		}

	}

	function agregaFuncion(){
		var a=parseFloat(document.getElementById('nfunciones').innerHTML);
  	a=a+1;

		var fila = '<td><input type="text" name="funcion['+a+']" id="funcion-'+a+'" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 funciones"></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteFuncion(this)"></td>';

		document.getElementById("funciones").insertRow(-1).innerHTML = fila;
  	document.getElementById('nfunciones').innerHTML=a;
	}

	function deleteFuncion(btn) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nfunciones').innerHTML);
		a=a-1;
		document.getElementById('nfunciones').innerHTML=a;

		recuentoFunciones()
	}

	function recuentoFunciones(){

		var funciones = document.querySelectorAll('.funciones');
				
		for(var i=0;i<funciones.length;i++){
			funciones[i].setAttribute("name", 'funcion['+(i+1)+"]");			
			funciones[i].setAttribute("id", 'funcion-'+(i+1));
			
		}

	}

	// $(document).ready(function() {
	// 	// Actualizar texto cuando se modifiquen las cláusulas
	// 	$(document).on('input', '.clausula-item textarea', function() {
	// 		actualizarTextoFinal();
	// 	});

	// 	// Cargar cláusulas cuando cambie la subclase
	// 	$(document).on('change', '#IdSubClase', function() {
	// 		cargarClausulasConVariables();
	// 	});

	// 	// También cargar cuando cambie la clase (para limpiar)
	// 	$(document).on('change', '#IdClase', function() {
	// 		$('#clausulasContainer').html('<p style="color: #666; font-style: italic; text-align: center; padding: 20px;">Seleccione la subclase para cargar las cláusulas</p>');
	// 		$('#texto').val('');
	// 	});

	// 	// Prevenir envío accidental del formulario al presionar Enter en textareas
	// 	$(document).on('keydown', '.clausula-textarea', function(e) {
	// 		if (e.keyCode === 13 && e.ctrlKey) {
	// 			// Ctrl+Enter para nueva línea
	// 			return true;
	// 		}
	// 	});
	// });

	// Event listeners para actualizar variables en tiempo real
	$(document).ready(function() {
		// Campos que al cambiar deben actualizar las cláusulas
		var camposQueActualizanClausulas = '#objeto, #finicio, #ffin, #valor, #alcance, #actividades, #entregables';

		$(document).on('input change', camposQueActualizanClausulas, function() {
			// Retrasar un poco para evitar muchas actualizaciones
			clearTimeout(window.timeoutActualizacionMejorada);
			window.timeoutActualizacionMejorada = setTimeout(function() {
				// Solo actualizar si hay cláusulas cargadas
				if ($('.clausula-textarea').length > 0) {
					$('.clausula-textarea').each(function() {
						var $textarea = $(this);
						var textoOriginal = $textarea.data('texto-original');
						if (textoOriginal) {
							var textoActualizado = reemplazarVariablesEnTiempo(textoOriginal);
							$textarea.val(textoActualizado);
						}
					});
					actualizarTextoFinal();
				}
			}, 500);
		});

		// También actualizar cuando se seleccione un contratista
		var originalLlenar = window.llenar;
		window.llenar = function(id, nombre, item, documento, telefono, direccion) {
			if (typeof originalLlenar === 'function') {
				originalLlenar(id, nombre, item, documento, telefono, direccion);
			}

			// Actualizar cláusulas después de seleccionar contratista
			setTimeout(function() {
				if ($('.clausula-textarea').length > 0) {
					$('.clausula-textarea').each(function() {
						var $textarea = $(this);
						var textoOriginal = $textarea.data('texto-original');
						if (textoOriginal) {
							var textoActualizado = reemplazarVariablesEnTiempo(textoOriginal);
							$textarea.val(textoActualizado);
						}
					});
					actualizarTextoFinal();
				}
			}, 300);
		};

		// Actualizar automáticamente al cambiar radios de IVA e Integral
		$(document).on('change', 'input[name="iva"], input[name="integral"]', function() {
			setTimeout(function() {
				if ($('.clausula-textarea').length > 0) {
					$('.clausula-textarea').each(function() {
						var $textarea = $(this);
						var textoOriginal = $textarea.data('texto-original');
						if (textoOriginal) {
							var textoActualizado = reemplazarVariablesEnTiempo(textoOriginal);
							$textarea.val(textoActualizado);
						}
					});
					actualizarTextoFinal();
				}
			}, 100);
		});
	});

	// ESTILOS CSS MEJORADOS
	var estilosAdicionales = `
<style>
.btn-actualizar-variables:hover {
    background: #0056b3 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
}

.btn-mostrar-variables:hover {
    background: #545b62 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
}

.variables-controls button {
    transition: all 0.2s ease;
    font-size: 13px;
    font-weight: 500;
}

.clausula-textarea[data-texto-original] {
    border-left: 4px solid #28a745;
    background: linear-gradient(to right, #f8fff8 0%, #ffffff 10%);
}

.clausula-textarea[data-texto-original]:focus {
    border-left-color: #1e7e34;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.variables-controls {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.clausula-item.variable-actualizada {
    animation: highlightUpdate 0.5s ease-out;
}

@keyframes highlightUpdate {
    0% {
        background-color: #d4edda;
        border-color: #28a745;
    }
    100% {
        background-color: white;
        border-color: #ddd;
    }
}
</style>
`;

	// Agregar estilos al head del documento
	if (!document.getElementById('estilos-variables-mejorados')) {
		$('head').append(estilosAdicionales);
		$('head').append('<meta id="estilos-variables-mejorados">');
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

	.div-radio input[type="radio"] {
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

	.div-radio label:before {
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

	.div-radio input[type="radio"]:checked+label {
		background: #FF9E7E;
		padding: 0 0;
		display: flex;
		justify-content: center;

	}

	.div-radio input[type="radio"]:checked+label:before {
		/*background: #007bff;
    border: 1px solid #007bff;*/
		display: none;
	}

	.borde-div-g {
		border-radius: 10px;
		padding: 5px 10px;
		margin: 0 10px;

	}

	.clausulas-section {
		margin-top: 20px;
		border: 1px solid #ddd;
		border-radius: 5px;
		padding: 15px;
		background: #f8f9fa;
	}

	.clausulas-section h6 {
		margin-bottom: 10px;
		color: #495057;
	}

	.clausulas-info {
		color: #666;
		font-size: 12px;
		margin-bottom: 15px;
		line-height: 1.4;
	}

	.clausula-item {
		margin-bottom: 15px;
		border: 1px solid #ddd;
		border-radius: 3px;
		background: white;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
		transition: all 0.2s ease;
	}

	.clausula-item:hover {
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
	}

	.clausula-header {
		background: #e9ecef;
		padding: 10px 15px;
		border-bottom: 1px solid #ddd;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.numeral-display {
		font-weight: bold;
		color: #495057;
		font-size: 14px;
	}

	.clausula-actions {
		display: flex;
		gap: 5px;
	}

	.btn-mini {
		padding: 4px 8px;
		font-size: 12px;
		border: none;
		border-radius: 3px;
		cursor: pointer;
		font-weight: bold;
		transition: all 0.2s ease;
	}

	.btn-rojo {
		background: #dc3545;
		color: white;
	}

	.btn-rojo:hover {
		background: #c82333;
	}

	.clausula-content {
		padding: 10px;
	}

	.clausula-textarea {
		width: 100%;
		min-height: 100px;
		border: 1px solid #ccc;
		border-radius: 3px;
		padding: 10px;
		font-size: 13px;
		font-family: Arial, sans-serif;
		resize: vertical;
		line-height: 1.5;
		background: #fff;
		transition: border-color 0.2s ease;
	}

	.clausula-textarea:focus {
		border-color: #007bff;
		box-shadow: 0 0 5px rgba(0, 123, 255, .25);
		outline: none;
	}

	.clausula-textarea::placeholder {
		color: #999;
		font-style: italic;
	}

	.nueva-clausula-container {
		text-align: center;
		padding: 20px;
		border-top: 2px dashed #ddd;
		margin-top: 15px;
	}

	.btn-crear-clausula {
		background: #28a745;
		color: white;
		border: none;
		padding: 12px 24px;
		border-radius: 5px;
		font-size: 14px;
		font-weight: bold;
		cursor: pointer;
		transition: all 0.2s ease;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}

	.btn-crear-clausula:hover {
		background: #218838;
		box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
		transform: translateY(-1px);
	}

	.btn-crear-clausula:active {
		transform: translateY(0);
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
	}

	.sin-clausulas {
		text-align: center;
	}

	#clausulasContainer {
		min-height: 100px;
		border: 1px solid #ddd;
		border-radius: 3px;
		background: white;
	}

	/* Animación para nuevas cláusulas */
	.clausula-nueva {
		animation: slideIn 0.3s ease-out;
	}

	@keyframes slideIn {
		from {
			opacity: 0;
			transform: translateY(-10px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	/* Estilos para el contador de cláusulas */
	.clausulas-contador {
		background: #007bff;
		color: white;
		padding: 5px 10px;
		border-radius: 15px;
		font-size: 11px;
		margin-left: 10px;
	}

	/* estilo linea divisora */

	hr {
		background-color: #000000;
	}
</style>
<?php
include('encabezado1.php');
?>
<div class="contenedor" style="width:1000px">
	<h5 class="Century" align="center">CREACION DE CONTRATOS</h5>
	<form action="graba.php" method="post">
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
			<div class="span-4">
				Contratista:
				<table class="tablita Arial12" width="100%">
					<col width="66%">
					<col width="34%">
					<tr>
						<td id="tdprov-1">
							<input type="text"   class="campo-sm Arial12" id="contratista-1" onKeyUp="buscaContratista(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off" required>
							<div class="drop">
								<ul class="hijos" id="ch-1">
								</ul>
							</div>
						</td>
						<td id="tdnit-1">
							<input type="text" class="campo-sm Arial12" id="contratistan-1" onKeyUp="buscaContratistan(this,this.value,this.id)" placeholder="Buscar X nit" autocomplete="off" required>
							<div class="drop">
								<ul class="hijos" id="chn-1">
								</ul>
							</div>
						</td>
					</tr>
				</table>
			</div>		
			<div class="span-2">
				Clase de Contrtato:
				<select name="IdClase" id="IdClase" class="campo-sm Arial12" onChange="buscaSubClase(this.value)">
					<option value="">Seleccione</option>
					<?php
					do {
					?>
						<option value="<?php echo $filaClase['IdClaseContrato'] ?>"><?php echo  $filaClase['clase'] ?></option>
					<?php
					} while ($filaClase = mysql_fetch_assoc($resultadoClase));
					?>
				</select>
			</div>
			<div class="span-2" id="midiv">
				Sub Clase de Contrato:
				<select name="IdSubClase" id="IdSubClase" class="campo-sm Arial12">
					<option value="">Seleccione</option>
				</select>
			</div>
		</div>
		<br>
		<hr>
		<div class="grid columna-8 Arial14"  style="display:none" id=div-v0>	
			<div class="span-2">
				Inicio:
				<input type="date" class="campo-sm Arial12" name="finicio" id="finicio" required>
			</div>
			<div class="span-2" id="div-ffinfin">
				Inicio etapa productiva:
				<input type="date" class="campo-sm Arial12" name="ffinfin" id="ffinfin">
			</div>
			<div class="span-2" id="div-ffin">
				Terminación:
				<input type="date" class="campo-sm Arial12" name="ffin" id="ffin">
			</div>
			<div class="span-2">
				Valor:
				<input type="number" class="campo-sm Arial12" name="valor" id="valor" required>
			</div>
			<div class="span-2" id="div-auxilio">
				Auxilio Transporte:
				<input type="number" class="campo-sm Arial12" name="auxilio" id="auxilio" value="0">
			</div>
			<div class="span-2" id="div-IdCargo">
				Cargo:
				<select name="IdCargo" class="campo-sm Arial12" id="IdCargo">
					<option value="">Seleccione</option>
					<?php
					do {
					?>
						<option value="<?php echo $filaCargo['IdCargo'] ?>"><?php echo $filaCargo['cargo'] ?></option>
					<?php
					} while ($filaCargo = mysql_fetch_assoc($resultadoCargo));
					?>
				</select>
			</div>
			<div class="span-2" id="div-incs">
				INCS:
				<input type="number" class="campo-sm Arial12" name="incs" id="incs" value="0">
			</div>
			<div class="span-2" id="div-especialidad">
				Especialidad
				<input type="text" name="especialidad" id="especialidad" class="campo-sm Arial12" onBlur="aMayusculas(this.value,this.id)">
			</div>
			<div class="span-2" id="div-grupo">
				Grupo
				<input type="text" name="grupo" id="grupo" class="campo-sm Arial12" onBlur="aMayusculas(this.value,this.id)">	
			</div>
			<div class="span-2" id="div-centrofor">
				C Fromación
				<input type="text" name="centrofor" id="centrofor" class="campo-sm Arial12" onBlur="aMayusculas(this.value,this.id)">	
			</div>
			<div class="span-2" id="div-deptol">
				Depto donde desepmpeñara labores:
				<select name="deptol" id="deptol" class="campo-sm Arial12" onChange="buscamun(this.value,this.id)">
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
			<div class="span-2" id="div-lugar">
				Mcpio donde desepmpeñara labores:
				<div id='midiv4'>
					<select name="lugar" id="lugar"  class="campo-sm Arial12" >	
						<option value="">Seleccione</option>
					</select>
				</div>	
			</div>
		</div>
		<br>	
		<div class="grid columna-8 Arial14" style="display:none" id=div-v1>
			<div class="span-4" id="div-objeto">
				<span id="label-objeto">Objeto obra o labor contratada:</span>
				<textarea name="objeto" id="objeto" class="txtarea" onBlur="aMayusculas(this.value,this.id)"></textarea>
			</div>
			<div class="span-4" id="div-alcance">
				Alcance:
				<textarea name="alcance" id="alcance" class="txtarea" onBlur="aMayusculas(this.value,this.id)"></textarea>
			</div>
		</div>
		<br>	
		<div class="grid columna-8 Arial14" style="display:none" id=div-v2>
			<div class="span-2" id="div-integral">
				Salario Integral:
				<div class="grid columna-3">
					<div class="span-1 div-radio">
						<input type="radio" name="integral" id="integral-si" value="1">
						<label for="integral-si">Sí</label>
					</div>
					<div class="span-1 div-radio">
						<input type="radio" name="integral" id="integral-no" value="0" checked>
						<label for="integral-no">No</label>
					</div>
				</div>
			</div>
			<div class="span-2" id="div-iva">
				IVA:
				<div class="grid columna-3">
					<div class="span-1 div-radio">
						<input type="radio" name="iva" id="iva-si" value="1">
						<label for="iva-si">Sí</label>
					</div>
					<div class="span-1 div-radio">
						<input type="radio" name="iva" id="iva-no" value="0" checked>
						<label for="iva-no">No</label>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="grid columna-8 Arial14" style="display:none" id=div-v3>				
			<div class="span-8" id="div-funciones">
			</div>
			<div class="span-8" id="div-responsabilidades">		
			</div>
			<div class="span-8" id="div-actividades">	
			</div>
			<div class="span-8" id="div-productos">		
			</div>
			<div class="span-8" id="div-formapago">
		
			</div>
		</div>			













		<!-- <textarea class="txtarea"  name="texto" id="" ><?php echo $filaClau['clausula'] ?></textarea> -->

		<div class="span-8" style="display:none">
			<div class="clausulas-section">
				<h6 class="Century">
					Cláusulas del Contrato
					<span id="clausulasContador" class="clausulas-contador" style="display: none;">0 cláusulas</span>
				</h6>
				<div class="clausulas-info">
					Las cláusulas se cargan automáticamente según la <strong>clase</strong> y <strong>subclase de contrato</strong> seleccionadas.
					Puede <strong>editar</strong>, <strong>crear nuevas</strong> o <strong>eliminar</strong> cláusulas según las necesidades del contrato.
					Las cláusulas se reorganizan automáticamente.
				</div>

				<div id="clausulasContainer">
					<p style="color: #666; font-style: italic; text-align: center; padding: 20px;">
						Seleccione clase y subclase de contrato para cargar las cláusulas correspondientes
					</p>
				</div>
			</div>

			<!-- Campo oculto para el texto final del contrato (se actualiza automáticamente) -->
			<input type="hidden" name="texto" id="texto">

			<!-- Campo visible para ver el texto generado -->
			<div style="margin-top: 15px;">
				<label style="font-weight: bold;">Texto final del contrato (generado automáticamente):</label>
				<div id="textoVisible"
					style="width: 100%; height: 200px; background: #f9f9f9; border: 1px solid #ddd; padding: 10px; border-radius: 3px; font-size: 12px; line-height: 1.4; overflow-y:auto;"></div>
			</div>
		</div>


		<div class="contenedor" align="center" id="div-boton" style="display:none">
			<button type="submit" name="boton1" class="btn btn-verde btn-sm" >Graba</button>
		</div>		
	</form>
</div>

<div id="cambiaContratista" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 320px">
		<div class="modal-content">
			<div class="modal-header" style="background:#d8d8d8; color:black;padding: 10px">
				<h5 class="modal-title Century">Cambiar contratista</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body Arial12" id="divCambContratista">
			</div>
		</div>
	</div>
</div>

<div id="creacargo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
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
							Contratista:
							<input type="text" name="proveedor" id="proveedor" class="campo-xs Arial12" required="required" value="" onBlur="aMayusculas(this.value,this.id)">
							<input type="hidden" id="itemp">
						</div>
						<div class="span-1">
							<br><br>
							Clase documento:
							<select name="IdClasedoc" id="IdClasedoc" class="campo-xs Arial12" required="required">
								<option value="">Seleccione</option>
								<?php
								do {
								?>
									<option value="<?php echo $filaCDoc['IdClasedoc'] ?>"><?php echo $filaCDoc['nombre'] ?></option>
								<?php
								} while ($filaCDoc = mysql_fetch_assoc($resultadoCDoc));
								$rows = mysql_num_rows($resultadoCDoc);
								if($rows > 0) {
										mysql_data_seek($resultadoCDoc, 0);
									$filaCDoc = mysql_fetch_assoc($resultadoCDoc);
								}
								?>
							</select>
						</div>
						<div class="span-1">
							No. Documento: (sin puntos ni comas, ni digito de verificación)
							<input type="number" name="nit" id="nit" class="campo-xs Arial12" required="required" value="">
						</div>
						<div class="span-1">
							<br>
							Departamento (expedición):
							<select name="deptoe" id="deptoe" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
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
						<div class="span-1">
							<br>
							Municipio (expedición)
							<div id='midiv0'>
								<select name="municipioe" id="municipioe"  class="campo-xs Arial12" >	
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
						<div class="span-1">
							F. de constitución o de nacimiento:
							<input type="date" name="fconstitucion" id="fconstitucion" class="campo-xs Arial12" required="required">
						</div>
						<div class="span-1">
							Departamento (Origen)
							<select name="depton" id="depton" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
								<option value="">Seleccione</option>
								<?php
								do {
								?>
									<option value="<?php echo $filaDepto['IdDepartamento'] ?>"><?php echo $filaDepto['departamentos'] ?></option>
								<?php
								} while ($filaDepto = mysql_fetch_assoc($resultadoDepto));
								$rows = mysql_num_rows($resultadoDepto);
								if ($rows > 0) {
									mysql_data_seek($resultadoDepto, 0);
									$filaDepto = mysql_fetch_assoc($resultadoDepto);
								}
								?>
							</select>
						</div>
						<div class="span-1">
							<br>
							Municipio (Origen):
							<div id='midiv1'>
								<select name="municipion" id="municipion" class="campo-xs Arial12" required="required">
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
						<div class="span-2">
							<br>
							Dirección:
							<input type="text" name="direccion" id="direccion" class="campo-xs" required="required">
						</div>
						<div class="span-1">
							<br>
							Teléfono:
							<input type="text" name="telefono" id="telefono" class="campo-xs" required="required">
						</div>
						<div class="span-2">
							<br>
							E-mail:
							<input type="text" name="email" id="email" class="campo-xs" required="required">
						</div>		
						<div class="span-1">
							Departamento (Actual):
							<select name="depton" id="depto" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
								<option value="">Seleccione</option>
								<?php
								do {
								?>
									<option value="<?php echo $filaDepto['IdDepartamento'] ?>"><?php echo $filaDepto['departamentos'] ?></option>
								<?php
								} while ($filaDepto = mysql_fetch_assoc($resultadoDepto));
								$rows = mysql_num_rows($resultadoDepto);
								if ($rows > 0) {
									mysql_data_seek($resultadoDepto, 0);
									$filaDepto = mysql_fetch_assoc($resultadoDepto);
								}
								?>
							</select>
						</div>
						<div class="span-1">
							<br>
							Municipio (Actual):
							<div id='midiv2'>
								<select name="municipio" id="municipio" class="campo-xs Arial12" required="required">
									<option value="">Seleccione</option>
								</select>
							</div>
						</div>
						<div class="span-3">
							<br><br>
							Representante Legal:
							<input type="text" name="replegal" id="replegal" class="campo-xs" onBlur="aMayusculas(this.value,this.id)">
						</div>
						<div class="span-1">
							<br><br>
							Clase documento:
							<select name="IdClasedocrep" id="IdClasedocrep" class="campo-xs Arial12" required="required">
								<option value="">Seleccione</option>
								<?php
								do {
								?>
									<option value="<?php echo $filaCDoc['IdClasedoc'] ?>"><?php echo $filaCDoc['nombre'] ?></option>
								<?php
								} while ($filaCDoc = mysql_fetch_assoc($resultadoCDoc));
								?>
							</select>
						</div>
						<div class="span-1">
							No. Documento: (sin puntos ni comas, ni digito de verificación)
							<input type="number" name="docrep" id="docrep" class="campo-xs Arial12">
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

<script>
	$(document).ready(function() {
		// Función para actualizar contador de cláusulas
		function actualizarContador() {
			var totalClausulas = $('.clausula-item').length;
			var contador = $('#clausulasContador');

			if (totalClausulas > 0) {
				contador.text(totalClausulas + (totalClausulas === 1 ? ' cláusula' : ' cláusulas')).show();
			} else {
				contador.hide();
			}
		}

		// Mostrar el texto final en el textarea visible
		function mostrarTextoFinal() {
			var textoFinal = $('#texto').val();
			$('#textoVisible').val(textoFinal);
			actualizarContador();
		}

		// Actualizar vista cada vez que cambie el texto oculto
		$(document).on('input', '#texto', mostrarTextoFinal);

		// También actualizar cuando se modifiquen las cláusulas
		// $(document).on('input', '.clausula-item textarea', function() {
		// 	setTimeout(mostrarTextoFinal, 50);
		// });

		// Actualizar contador cuando se agreguen o eliminen cláusulas
		$(document).on('DOMNodeInserted DOMNodeRemoved', '#clausulasContainer', function() {
			setTimeout(actualizarContador, 100);
		});

		// Observer para cambios en el DOM (más moderno que DOMNodeInserted)
		if (window.MutationObserver) {
			var observer = new MutationObserver(function(mutations) {
				mutations.forEach(function(mutation) {
					if (mutation.type === 'childList') {
						actualizarContador();
					}
				});
			});

			observer.observe(document.getElementById('clausulasContainer'), {
				childList: true,
				subtree: true
			});
		}
	});
</script>

</body>

</html>