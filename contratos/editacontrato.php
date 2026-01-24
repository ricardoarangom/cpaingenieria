<?php 
require_once('../connections/datos.php');

$contrato=$_GET['contrato'];

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

$buscaContra = " SELECT 
    IdContrato,
    IdProveedor,
    IdEmpresa,
    IdArea,
    IdSolicitante,
    IdClase,
    IdSubClase,
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
    IdCargo,
    incs,
    especialidad,
    grupo,
    centrofor,
    alcance,
    lugar,
    auxilio,
    IdFirmante,
    anexo,
    proveedor,
    documento
FROM
    (contrat
    LEFT JOIN contratistas ON contrat.IdProveedor = contratistas.IdContratista)
WHERE
    IdContrato = ".$contrato;
$resultadoContra = mysql_query($buscaContra, $datos) or die(mysql_error());
$filaContra = mysql_fetch_assoc($resultadoContra);
$totalfilas_buscaContra = mysql_num_rows($resultadoContra);

$buscaAct = " SELECT 
								IdActividad,
								actividad
							FROM 
								actividadescont 
							WHERE IdContrato = ".$contrato;
$resultadoAct = mysql_query($buscaAct, $datos) or die(mysql_error());
$filaAct = mysql_fetch_assoc($resultadoAct);
$totalfilas_buscaAct = mysql_num_rows($resultadoAct);

$buscaFun = " SELECT 
								IdFuncion,
                funcion
							FROM
									funcionescont
							WHERE
									IdContrato = ".$contrato;
$resultadoFun = mysql_query($buscaFun, $datos) or die(mysql_error());
$filaFun = mysql_fetch_assoc($resultadoFun);
$totalfilas_buscaFun = mysql_num_rows($resultadoFun);

$buscaResp = "SELECT
								IdResponsabilidad,
                responsabilidad
							FROM
									resposabilidadescont
							WHERE
									IdContrato =   ".$contrato;
$resultadoResp = mysql_query($buscaResp, $datos) or die(mysql_error());
$filaResp = mysql_fetch_assoc($resultadoResp);
$totalfilas_buscaResp = mysql_num_rows($resultadoResp);

$buscaProd = "SELECT 
								IdProducto,
								producto 
							FROM 
								productoscont 
							WHERE IdContrato = ".$contrato;
$resultadoProd = mysql_query($buscaProd, $datos) or die(mysql_error());
$filaProd = mysql_fetch_assoc($resultadoProd);
$totalfilas_buscaProd = mysql_num_rows($resultadoProd);

$buscaForm = "SELECT 
								IdFroma,
								porpago,
								concepto 
							FROM 
								formapagocont 
							WHERE 
								IdContrato = ".$contrato;
$resultadoForm = mysql_query($buscaForm, $datos) or die(mysql_error());
$filaForm = mysql_fetch_assoc($resultadoForm);
$totalfilas_buscaForm = mysql_num_rows($resultadoForm);

?>
<?php 
include('encabezado.php');
?>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var clase = <?php echo $filaContra['IdClase'] ?>;
    var area = <?php echo $filaContra['IdArea'] ?>;
    var subclase = <?php echo $filaContra['IdSubClase'] ?>;
    var firmante = <?php echo $filaContra['IdFirmante'] ?>;
		var IdCargo = <?php echo $filaContra['IdCargo'] ?>;
		var integral = <?php echo $filaContra['integral'] ?>;
		var iva = <?php echo $filaContra['iva'] ?>;

    
    buscaSubClase(clase);
		muestraCampos(subclase);
    $('#IdClase').val(clase);
    $('#IdArea').val(area);
    $('#IdFirmante').val(firmante);
    $('#IdCargo').val(IdCargo);

		if(integral==1){
			document.getElementById('integral-si').checked=true;	
		}else{
			document.getElementById('integral-no').checked=true;	
		}

		if(iva!=0){
			document.getElementById('iva-si').checked=true;
		}else{
			document.getElementById('iva-no').checked=true;		
		}

    setTimeout(() => {
        $('#IdSubClase').val(subclase);
    }, "100");

  });

	function muestraCampos(id){
		if(id==1 || id==5 || id==6){
			document.getElementById('label-objeto').innerHTML='Objeto:'
		}
		if(id==2 || id==7){
			document.getElementById('label-objeto').innerHTML='Objeto obra o labor contratada'
		}
		if(id==3 || id==4 || id==8){
			document.getElementById('label-objeto').innerHTML='Objetivo del Contrato:'
		}
	}



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
			}
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

  function llenar(id, nombre, item, documento) {
		$('#cambiaContratista').modal('hide');
		console.log(id, nombre, item,documento)
		var item1 = "'" + item + "'"
		$('#tdprov-' + item).html(
			'<div style="width: 320px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratista(' + item1 + ')">' + nombre + '</div>' +
			'<input type="hidden" name="contratista" id="contratista' + item + '" value="' + id + '">' 
		);
		$('#tdnit-' + item).html(
			'<div style="width:160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratistan(' + item1 + ')">' + documento + '</div>'
		);
	}

	function agregaFuncion(){
		var a=parseFloat(document.getElementById('nfunciones').innerHTML);
  	a=a+1;

		var fila = '<td><textarea class="txtarea funciones" name="funcion['+a+']" id="funcion-'+a+'" onBlur="aMayusculas(this.value,this.id)"></textarea></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteFuncion(this,0)"></td>';

		document.getElementById("funciones").insertRow(-1).innerHTML = fila;
  	document.getElementById('nfunciones').innerHTML=a;
	}

	function deleteFuncion(btn,IdFuncion) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nfunciones').innerHTML);
		a=a-1;
		document.getElementById('nfunciones').innerHTML=a;

		if(IdFuncion!=0){
			var borraFunciones = document.getElementById('borraFunciones').value;
			if(borraFunciones){
				borraFunciones=borraFunciones+','+IdFuncion;
			}else{
				borraFunciones=IdFuncion;
			}
			document.getElementById('borraFunciones').value=borraFunciones;
		}

		recuentoFunciones()
	}

	function recuentoFunciones(){

		var funciones = document.querySelectorAll('.funciones');
		var IdFunciones = document.querySelectorAll('.IdFunciones');
				
		for(var i=0;i<funciones.length;i++){
			funciones[i].setAttribute("name", 'funcion['+(i+1)+"]");			
			funciones[i].setAttribute("id", 'funcion-'+(i+1));
			
		}
		for(var i=0;i<IdFunciones.length;i++){
			IdFunciones[i].setAttribute("name", 'IdFuncion['+(i+1)+"]");			
			IdFunciones[i].setAttribute("id", 'IdFuncion-'+(i+1));
			
		}
	}

	function agregaResponsabilidad(){
		var a=parseFloat(document.getElementById('nresponsabilidades').innerHTML);
  	a=a+1;

		var fila = '<td><textarea class="txtarea responsabilidades" name="responsabilidad['+a+']" id="responsabilidad-'+a+'" onBlur="aMayusculas(this.value,this.id)"></textarea></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteResponsabilidad(this,0)"></td>';

		document.getElementById("responsabilidades").insertRow(-1).innerHTML = fila;
  	document.getElementById('nresponsabilidades').innerHTML=a;
	}

	function deleteResponsabilidad(btn,IdResponsabilidad) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nresponsabilidades').innerHTML);
		a=a-1;
		document.getElementById('nresponsabilidades').innerHTML=a;

		if(IdResponsabilidad!=0){
			var borraResponsabilidades = document.getElementById('borraResponsabilidades').value;
			if(borraResponsabilidades){
				borraResponsabilidades=borraResponsabilidades+','+IdResponsabilidad;
			}else{
				borraResponsabilidades=IdResponsabilidad;
			}
			document.getElementById('borraResponsabilidades').value=borraResponsabilidades;
		}

		recuentoResponsabilidades()
	}

	function recuentoResponsabilidades(){

		var responsabilidades = document.querySelectorAll('.responsabilidades');
		var IdResponsabilidades = document.querySelectorAll('.IdResponsabilidades');
				
		for(var i=0;i<responsabilidades.length;i++){
			responsabilidades[i].setAttribute("name", 'responsabilidad['+(i+1)+"]");			
			responsabilidades[i].setAttribute("id", 'responsabilidad-'+(i+1));			
		}
		for(var i=0;i<IdResponsabilidades.length;i++){
			IdResponsabilidades[i].setAttribute("name", 'IdResponsabilidad['+(i+1)+"]");			
			IdResponsabilidades[i].setAttribute("id", 'IdResponsabilidad-'+(i+1));			
		}

	}

	function agregaActividad(){
		var a=parseFloat(document.getElementById('nactividades').innerHTML);
  	a=a+1;

		var fila = '<td><textarea class="txtarea actividades" name="actividad['+a+']" id="actividad-'+a+'" onBlur="aMayusculas(this.value,this.id)"></textarea></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteActividad(this,0)"></td>';

		document.getElementById("actividades").insertRow(-1).innerHTML = fila;
  	document.getElementById('nactividades').innerHTML=a;
	}

	function deleteActividad(btn,IdActividad) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nactividades').innerHTML);
		a=a-1;
		document.getElementById('nactividades').innerHTML=a;

		if(IdActividad!=0){
			var borraActividades = document.getElementById('borraActividades').value;
			if(borraActividades){
				borraActividades=borraActividades+','+IdActividad;
			}else{
				borraActividades=IdActividad;
			}
			document.getElementById('borraActividades').value=borraActividades;
		}

		recuentoActividades()
	}

	function recuentoActividades(){

		var actividades = document.querySelectorAll('.actividades');
		var IdActividades = document.querySelectorAll('.IdActividades');
				
		for(var i=0;i<actividades.length;i++){
			actividades[i].setAttribute("name", 'actividad['+(i+1)+"]");			
			actividades[i].setAttribute("id", 'actividad-'+(i+1));			
		}
		for(var i=0;i<IdActividades.length;i++){
			IdActividades[i].setAttribute("name", 'IdActividad['+(i+1)+"]");			
			IdActividades[i].setAttribute("id", 'IdActividad-'+(i+1));			
		}

	}

	function agregaProducto(){
		var a=parseFloat(document.getElementById('nproductos').innerHTML);
  	a=a+1;

		var fila = '<td><textarea class="txtarea productos" name="producto['+a+']" id="producto-'+a+'" onBlur="aMayusculas(this.value,this.id)"></textarea></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteProducto(this,0)"></td>';

		document.getElementById("productos").insertRow(-1).innerHTML = fila;
  	document.getElementById('nproductos').innerHTML=a;
	}

	function deleteProducto(btn,IdProducto) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('nproductos').innerHTML);
		a=a-1;
		document.getElementById('nproductos').innerHTML=a;

		if(IdProducto!=0){
			var borraProductos = document.getElementById('borraProductos').value;
			if(borraProductos){
				borraProductos=borraProductos+','+IdProducto;
			}else{
				borraProductos=IdProducto;
			}
			document.getElementById('borraProductos').value=borraProductos;
		}

		recuentoProductos()
	}

	function recuentoProductos(){

		var productos = document.querySelectorAll('.productos');
		var IdProductos = document.querySelectorAll('.IdProductos');
				
		for(var i=0;i<productos.length;i++){
			productos[i].setAttribute("name", 'producto['+(i+1)+"]");			
			productos[i].setAttribute("id", 'producto-'+(i+1));			
		}

		for(var i=0;i<IdProductos.length;i++){
			IdProductos[i].setAttribute("name", 'IdProducto['+(i+1)+"]");			
			IdProductos[i].setAttribute("id", 'IdProducto-'+(i+1));			
		}
	}

	function agregaPago(){
		var a=parseFloat(document.getElementById('numpagos').innerHTML);
  	a=a+1;

		var fila = '<td><input type="number" name="porpago['+a+']" id="porpago-'+a+'" class="campo-xs Arial12 porpago"></td>'+
							 '<td><input type="text" name="concepto['+a+']" id="concepto-'+a+'" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 concepto"></td>'+
							 '<td><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deletePago(this,0)"></td>'

		document.getElementById("pagos").insertRow(-1).innerHTML = fila;
  	document.getElementById('numpagos').innerHTML=a;
	}

	function deletePago(btn,IdFroma) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);
		var a=parseFloat(document.getElementById('numpagos').innerHTML);
		a=a-1;
		document.getElementById('numpagos').innerHTML=a;

		if(IdFroma!=0){
			var borraPagos = document.getElementById('borraPagos').value;
			if(borraPagos){
				borraPagos=borraPagos+','+IdFroma;
			}else{
				borraPagos=IdFroma;
			}
			document.getElementById('borraPagos').value=borraPagos;
		}

		recuentoPagos()
	}

	function recuentoPagos(){

		var porpago = document.querySelectorAll('.porpago');
		var concepto = document.querySelectorAll('.concepto');
		var IdFromas = document.querySelectorAll('.IdFromas');
		
		for(var i=0;i<porpago.length;i++){
			porpago[i].setAttribute("name", 'porpago['+(i+1)+"]");
			concepto[i].setAttribute("name", 'concepto['+(i+1)+"]");			

			porpago[i].setAttribute("id", 'porpago-'+(i+1));
			concepto[i].setAttribute("id", 'concepto-'+(i+1));					
			
		}

		for(var i=0;i<IdFromas.length;i++){
			IdFromas[i].setAttribute("name", 'IdFroma['+(i+1)+"]");
			IdFromas[i].setAttribute("id", 'IdFroma-'+(i+1));	
		}
				


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
						if (result.value) {
							llenar(matriz[1], matriz[2], item, matriz[3], matriz[4], matriz[5]);
						} 

						
					});

				}
			}
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

	hr {
		background-color: #000000;
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
</style>
<?php 
include('encabezado1.php');
?>
<div class="contenedor" style="width:1000px">
	<h5 class="Century" align="center">EDICION DE CONTRATOS</h5>
	<form action="graba.php" method="post" enctype="multipart/form-data" onSubmit="bloquear('boton')">
		<input type="hidden" name="IdContrato" value="<?php echo $filaContra['IdContrato']  ?>" >
    <div class="grid columna-8 Arial14">
			<div class="span-4">
				Proyecto / Area:
				<select name="IdArea" id="IdArea" class="campo-sm Arial12" required>
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
              <div style="width: 320px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratista('1')"><?php echo $filaContra['proveedor'] ?></div>
			        <input type="hidden" name="contratista" id="contratista1" value="<?php echo $filaContra['IdProveedor'] ?>">
						</td>
						<td id="tdnit-1">
							<div style="width:160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratistan('1')"><?php echo colocapuntos($filaContra['documento']) ?></div>
						</td>
					</tr>
				</table>
			</div>		
			<div class="span-2">
				Clase de Contrato:
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
			<div class="span-2">
				Firmante:
				<select name="IdFirmante" id="IdFirmante" class="campo-sm Arial12">
					<option value="1">LUIS HECTOR RUBIANO VERGARA</option>
					<option value="2">MARTHA GABRIELA	BOTERO SERNA</option>
				</select>	
			</div>
			<div class="span-2">
			</div>
			<div class="span-3">
				Terminos de referencia: (Formato PDF max 1MB)
				<input type="file" name="anexo" id="anexo" class="campo-sm Arial12" onChange="validarArchivo(this.files,this.id)">
			</div>
      <?php 
      if($filaContra['anexo']){
        ?>
        <div class="span-2">
          <br>
					<input type="hidden" name="anexoA"  value="<?php echo $filaContra['anexo']?>">
          <a href="<?php echo $filaContra['anexo']?>" class="btn btn-rosa btn-xs btn-block"  target="_blank" style="margin-top:4px">Ver Terminos de referencia</a>
        </div>
        <?php
      }
      ?>
		</div>  
		<br>
		<hr>	
		<div class="grid columna-8 Arial14"  style="display:" id=div-v0>	
			<div class="span-2">
				Inicio:
				<input type="date" class="campo-sm Arial12" name="finicio" id="finicio" required value="<?php echo $filaContra['finicio'] ?>">
			</div>
			<div class="span-2" id="div-ffinfin">
				Inicio etapa productiva:
				<input type="date" class="campo-sm Arial12" name="ffinfin" id="ffinfin" value="<?php echo $filaContra['ffinfin'] ?>">
			</div>
			<div class="span-2" id="div-ffin">
				Terminación:
				<input type="date" class="campo-sm Arial12" name="ffin" id="ffin" value="<?php echo $filaContra['ffin'] ?>">
			</div>
			<div class="span-2">
				Valor:
				<input type="number" class="campo-sm Arial12" name="valor" id="valor" required value="<?php echo $filaContra['valor'] ?>">
			</div>
			<div class="span-2" id="div-auxilio">
				Auxilio Transporte:
				<input type="number" class="campo-sm Arial12" name="auxilio" id="auxilio" value="<?php echo $filaContra['auxilio'] ?>">
			</div>
			<div class="span-2" id="div-IdCargo">
				Cargo:
				<select name="IdCargo" class="campo-sm Arial12" id="IdCargo">
					<option value="0">Seleccione</option>
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
				<input type="number" class="campo-sm Arial12" name="incs" id="incs" value="<?php echo $filaContra['incs'] ?>">
			</div>
			<div class="span-2" id="div-especialidad">
				Especialidad
				<input type="text" name="especialidad" id="especialidad" class="campo-sm Arial12" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaContra['especialidad'] ?>">
			</div>
			<div class="span-2" id="div-grupo">
				Grupo
				<input type="text" name="grupo" id="grupo" class="campo-sm Arial12" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaContra['grupo'] ?>">	
			</div>
			<div class="span-2" id="div-centrofor">
				C Fromación
				<input type="text" name="centrofor" id="centrofor" class="campo-sm Arial12" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaContra['centrofor'] ?>">	
			</div>
			<div class="span-3" id="div-lugar">
				Lugar donde desepmpeñara labores:
				<input type="text" name="lugar" id="lugar" class="campo-sm Arial12" value="<?php echo $filaContra['lugar'] ?>">					
			</div>
		</div>
		<br>	
		<div class="grid columna-8 Arial14" style="display:" id=div-v1>
			<div class="span-4" id="div-objeto">
				<span id="label-objeto">Objeto obra o labor contratada:</span>
				<textarea name="objeto" id="objeto" class="txtarea" onBlur="aMayusculas(this.value,this.id)"><?php echo $filaContra['objeto'] ?></textarea>
			</div>
			<div class="span-4" id="div-alcance">
				Alcance:
				<textarea name="alcance" id="alcance" class="txtarea" onBlur="aMayusculas(this.value,this.id)"><?php echo $filaContra['alcance'] ?></textarea>
			</div>
		</div>
		<br>	
		<div class="grid columna-8 Arial14" style="display:" id=div-v2>
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
			<div class="span-6"></div>
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
		<hr>
		<div class="grid columna-8 Arial14" style="display:" id=div-v3>				
			<div class="span-8" id="div-funciones">
				Funciones: <span id="nfunciones" style="display:none"><?php echo $totalfilas_buscaFun?></span>
				<table class="tablita Arial12" width="80%" id="funciones"><col width="97%"><col width="3%">				
					<?php 
					if($totalfilas_buscaFun>0){
						$cuentaFunciones=1;
						do{
							?>
							<tr>
								<td>
									<textarea class="txtarea funciones" name="funcion[<?php echo $cuentaFunciones ?>]" id="funcion-<?php echo $cuentaFunciones ?>" onBlur="aMayusculas(this.value,this.id)"><?php echo $filaFun['funcion'] ?></textarea>
									<input type="hidden" class="IdFunciones" name="IdFuncion[<?php echo $cuentaFunciones ?>]" id="IdFuncion-<?php echo $cuentaFunciones ?>" value="<?php echo $filaFun['IdFuncion'] ?>">
								</td>
								<td>
									<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteFuncion(this,<?php echo $filaFun['IdFuncion'] ?>)">
								</td>
							</tr>
							<?php
							$cuentaFunciones++;
						}while($filaFun = mysql_fetch_assoc($resultadoFun));
					}	
					?>
				</table>
				<button type="button" class="btn btn-verde btn-xs1" onClick="agregaFuncion()" >Agregar función</button>
				<input type="hidden" name="borraFunciones" id="borraFunciones">
			</div>
			<div class="span-8" id="div-responsabilidades">
				Responsabilidades: <span id="nresponsabilidades" style="display:none"><?php echo $totalfilas_buscaResp ?></span>
				<table class="tablita Arial12" width="80%" id="responsabilidades"><col width="97%"><col width="3%">
					<?php
					if($totalfilas_buscaResp>0){
						$cuentaResp=1;
						do{
							?>
							<tr>
								<td>
									<textarea class="txtarea responsabilidades" name="responsabilidad[<?php echo $cuentaResp ?>]" id="responsabilidad-<?php echo $cuentaResp ?>" onBlur="aMayusculas(this.value,this.id)"><?php echo $filaResp['responsabilidad'] ?></textarea>
									<input type="hidden" class="IdResponsabilidades" name="IdResponsabilidad[<?php echo $cuentaResp ?>]" id="IdResponsabilidad-<?php echo $cuentaResp ?>" value="<?php echo $filaResp['IdResponsabilidad'] ?>">
								</td>
								<td>
									<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteResponsabilidad(this,<?php echo $filaResp['IdResponsabilidad'] ?>)">
								</td>
							</tr>
							<?php
							$cuentaResp++;
						}while($filaResp = mysql_fetch_assoc($resultadoResp)); 
					}
					?>
				</table>
				<button type="button" class="btn btn-verde btn-xs1" onClick="agregaResponsabilidad()">Agregar responsabilidad</button>
				<input type="hidden" name="borraResponsabilidades" id="borraResponsabilidades">	
			</div>
			<div class="span-8" id="div-actividades">
				Actividades: <span id="nactividades" style="display:none"><?php echo $totalfilas_buscaAct ?></span>
				<table class="tablita Arial12" width="80%" id="actividades"><col width="97%"><col width="3%">
					<?php
					if($totalfilas_buscaAct>0){
						$cuentaActividades=1;
						do{
							?>
							<tr>
								<td>
									<textarea class="txtarea actividades" name="actividad[<?php echo $cuentaActividades ?>]" id="actividad-<?php echo $cuentaActividades ?>" onBlur="aMayusculas(this.value,this.id)"><?php echo $filaAct['actividad'] ?></textarea>
									<input type="hidden" class="IdActividades" name="IdActividad[<?php echo $cuentaActividades ?>]" id="IdActividad-<?php echo $cuentaActividades ?>" value="<?php echo $filaAct['IdActividad'] ?>">
								</td>
								<td>
									<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteActividad(this,<?php echo $filaAct['IdActividad'] ?>)">
								</td>
							</tr>
							<?php
							$cuentaActividades++;
						}while($filaAct = mysql_fetch_assoc($resultadoAct)); 
					}
					?>
				</table>
				<button type="button" class="btn btn-verde btn-xs1" onClick="agregaActividad()" >Agregar actividad</button>
				<input type="hidden" name="borraActividades" id="borraActividades">		
			</div>
			<div class="span-8" id="div-productos">
				Productos y/o entregables: <span id="nproductos" style="display:none"><?php echo $totalfilas_buscaProd ?></span>
				<table class="tablita Arial12" width="80%" id="productos"><col width="97%"><col width="3%">
					<?php
					if($totalfilas_buscaProd>0){
						$cuentaProductos=1;
						do{
							?>
							<tr>
								<td>
									<textarea class="txtarea productos" name="producto[<?php echo $cuentaProductos ?>]" id="producto-<?php echo $cuentaProductos ?>" onBlur="aMayusculas(this.value,this.id)"><?php echo $filaProd['producto'] ?></textarea>
									<input type="hidden" class="IdProductos"  name="IdProducto[<?php echo $cuentaProductos ?>]" id="IdProducto-<?php echo $cuentaProductos ?>" value="<?php echo $filaProd['IdProducto'] ?>"  >
								</td>
								<td>
									<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteProducto(this,<?php echo $filaProd['IdProducto'] ?>)">
								</td>
							</tr>
							<?php
							$cuentaProductos++;
						}while($filaProd = mysql_fetch_assoc($resultadoProd));
					}
					?>
				</table>
				<button type="button" class="btn btn-verde btn-xs1" onClick="agregaProducto()" >Agregar producto</button>
				<input type="hidden" name="borraProductos" id="borraProductos">						
			</div>
			<div class="span-8" id="div-formapago">
				Forma de pago: <span id="numpagos" style="display:none"><?php echo $totalfilas_buscaForm ?></span>
				<table class="tablita Arial12" width="80%" id="pagos"><col width="13%"><col width="83%"><col width="5%">
					<tr class="titulos" >
						<td>%</td>
						<td colspan="2">Condición</td>
					</tr>		
					<?php
					if($totalfilas_buscaForm>0){
						$cuentaPagos=1;
						do{
							?>
							<tr>
								<td>
									<input type="number" name="porpago[<?php echo $cuentaPagos ?>]" id="porpago-<?php echo $cuentaPagos ?>" class="campo-xs Arial12 porpago" value="<?php echo $filaForm['porpago']*100 ?>">
								</td>
								<td>
									<input type="text" name="concepto[<?php echo $cuentaPagos ?>]" id="concepto-<?php echo $cuentaPagos ?>" onBlur="aMayusculas(this.value,this.id)" class="campo-xs Arial12 concepto" value="<?php echo $filaForm['concepto'] ?>">
									<input type="hidden" class="IdFromas" name="IdFroma[<?php echo $cuentaPagos ?>]" id="IdFroma-<?php echo $cuentaPagos ?>" value="<?php echo $filaForm['IdFroma'] ?>" >
								</td>
								<td>
									<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deletePago(this,<?php echo $filaForm['IdFroma'] ?>)">
								</td>
							</tr>
							<?php
						$cuentaPagos++;
						}while($filaForm = mysql_fetch_assoc($resultadoForm));
					}
					?>
				</table>
				<button type="button" class="btn btn-verde btn-xs1" onClick=agregaPago() >Agregar pago</button>
				<input type="hidden" name="borraPagos" id="borraPagos" >
			</div>
		</div>
		<div class="contenedor" align="center" id="div-boton" style="display:">
			<button type="submit" name="boton4" class="btn btn-verde btn-sm" >Graba</button>
		</div>
		<div class="espera"></div>	
  </form>
	<br><br><br><br><br>
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

  
</body>
</html>