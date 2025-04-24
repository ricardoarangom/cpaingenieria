<?php require_once('../connections/datos.php'); ?>
<?php
include('encabezado.php');

$buscaUsuario="SELECT nombre, apellido, cargo, cedula, banco, cuenta from usuarios left join bancos on usuarios.IdBanco=bancos.IdBanco where IdUsuario=".$usuario;
$resultado = mysql_query($buscaUsuario, $datos) or die(mysql_error());
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);

$buscaArea="SELECT area, IdArea, ccostos FROM areas WHERE IdArea<>0 ORDER BY ccostos";
$resultado1 = mysql_query($buscaArea, $datos) or die(mysql_error());
$row_resultado1 = mysql_fetch_assoc($resultado1);
$totalRows_resultado1 = mysql_num_rows($resultado1);

$buscaDptos="SELECT * FROM departamentos;";
$resultado2 = mysql_query($buscaDptos, $datos) or die(mysql_error());
$row_resultado2 = mysql_fetch_assoc($resultado2);
$totalRows_resultado2 = mysql_num_rows($resultado2);

$buscaGastos="SELECT IdDepertamento, IdMunicipio, alojamiento, alimentacion, hidratacion, taeropuerto FROM tablagastos";
$resultado3 = mysql_query($buscaGastos, $datos) or die(mysql_error());
$row_resultado3 = mysql_fetch_assoc($resultado3);

$buscaBancos="SELECT IdBanco, banco FROM bancos order by banco";
$resultado4 = mysql_query($buscaBancos, $datos) or die(mysql_error());
$row_resultado4 = mysql_fetch_assoc($resultado4);

do{
	$tablaAreas[$row_resultado1['IdArea']]['area']=$row_resultado1['area'];
	$tablaAreas[$row_resultado1['IdArea']]['ccostos']=$row_resultado1['ccostos'];
	
}while($row_resultado1 = mysql_fetch_assoc($resultado1));

$cadenaTablaAreas=json_encode($tablaAreas,JSON_UNESCAPED_UNICODE);

do{
	$tablaDptos[$row_resultado2['IdDepartamento']]=$row_resultado2['departamentos'];
}while($row_resultado2 = mysql_fetch_assoc($resultado2));

do{
		
	if($row_resultado3['IdMunicipio']<>0){
		
		$tablaGastos[$row_resultado3['IdMunicipio']]['departamento']=$row_resultado3['IdMunicipio'];		
		$tablaGastos[$row_resultado3['IdMunicipio']]['alojamiento']=$row_resultado3['alojamiento'];
		$tablaGastos[$row_resultado3['IdMunicipio']]['alimentacion']=$row_resultado3['alimentacion'];
		$tablaGastos[$row_resultado3['IdMunicipio']]['hidratacion']=$row_resultado3['hidratacion'];
		$tablaGastos[$row_resultado3['IdMunicipio']]['taeropuerto']=$row_resultado3['taeropuerto'];
		
	}else{
		
		$tablaGastos[$row_resultado3['IdDepertamento']]['departamento']=$row_resultado3['IdDepertamento'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['alojamiento']=$row_resultado3['alojamiento'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['alimentacion']=$row_resultado3['alimentacion'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['hidratacion']=$row_resultado3['hidratacion'];
		$tablaGastos[$row_resultado3['IdDepertamento']]['taeropuerto']=$row_resultado3['taeropuerto'];
		
	}
		
}while($row_resultado3 = mysql_fetch_assoc($resultado3));

$cadenaTablaGastos=json_encode($tablaGastos,JSON_UNESCAPED_UNICODE);

//echo "<pre>";
//print_r($tablaGastos);
//echo "</pre>";
?>
<script>
	
	window.addEventListener("keypress", function(event){
		if (event.keyCode == 13){
				event.preventDefault();
		}
	}, false);
	
	
	function buscaCostos(valor){
		var tabla = '<?php echo $cadenaTablaAreas ?>';
		var arreglotabla = JSON.parse(tabla);
		document.getElementById('ccostos').innerHTML='<strong>'+arreglotabla[valor]['ccostos']+'</strong>'
	}
	
	function buscamun(IdDepartamento){
		var datos = new FormData();
		datos.append("IdDepartamento",IdDepartamento);
		datos.append("proced",1);

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
					var fila = '<select name="IdMunicipio" id="IdMunicipio" class="campo-sm Arial12" required>'+	
											'<option value="">Selecccione el Mpio</option>';
					Object.keys(arregloTabla).forEach(key => {
						fila=fila+'<option value="'+key+'">'+arregloTabla[key]+'</option>'
					});
					fila=fila+'</select>';
					$('#midiv').html(fila);
				}
			});
	}
	
	function buscamun1(IdDepartamento){
		var datos = new FormData();
		datos.append("IdDepartamento",IdDepartamento);
		datos.append("proced",1);

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
					var fila = '<select name="traorigen" class="campo-sm Arial12" required>'+	
											'<option value="">Selecccione el Mpio</option>';
					Object.keys(arregloTabla).forEach(key => {
						console.log(key,arregloTabla[key] )
						fila=fila+'<option value="'+key+'">'+arregloTabla[key]+'</option>'
					});
					fila=fila+'</select>';
					$('#midiv1').html(fila);
				}
			});
	}
	
	function buscamun2(IdDepartamento){
		var datos = new FormData();
		datos.append("IdDepartamento",IdDepartamento);
		datos.append("proced",1);

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
					var fila = '<select name="tradest" class="campo-sm Arial12" required>'+	
											'<option value="">Selecccione el Mpio</option>';
					Object.keys(arregloTabla).forEach(key => {
						console.log(key,arregloTabla[key] )
						fila=fila+'<option value="'+key+'">'+arregloTabla[key]+'</option>'
					});
					fila=fila+'</select>';
					$('#midiv2').html(fila);
				}
			});
	}
	
	function agregarFila(){
 		var a=parseFloat(document.getElementById('nf').innerHTML);
  	
  
		var fila1 ='<td align="center" class="item">'+a+'</td>';
		var fila2 ='<td>'+
									'<select name="arreglo['+a+'][rubro]" id="rubro-'+a+'" class="campo-xs rubro" onClick="validaDestino()" onChange="traeGasto(this.id,this.value)">'+
										'<option value="">Seleccione</option>'+
										'<option value="alojamiento">Alojamiento</option>'+
										'<option value="alimentacion">Alimentacion</option>'+
										'<option value="hidratacion">Hidratacion</option>'+
										'<option value="taeropuerto">Transporte Aeropuerto</option>'+        
                    '<option value="papeleria">Papeleria</option>'+
                    '<option value="Alquiler de equipos">Alquiler de equipos</option>'+
                    '<option value="combustible">Combustible</option>'+
                    '<option value="peajes">Peajes</option>'+
                    '<option value="Transportes Internos">Transportes Internos</option>'+
                    '<option value="refrigerios">Regrigerios</option>'+        
									'</select>'+
								'</td>'
		var fila3 ='<td><input type="text" class="campo-xs cantidad" value="1" name="arreglo['+a+'][cantidad]" id="cantidad-'+a+'" onChange="calcula(this.id)"></td>';
		var fila4 ='<td><input type="text" class="campo-xs vunitario" value="0" name="arreglo['+a+'][vunitario]" id="vunitario-'+a+'" readonly onChange="calcula(this.id)"  onKeyUp="separador(this.id)"></td>';
		var fila5 ='<td><input type="text" class="campo-xs vtotal" value="0" name="arreglo['+a+'][vtotal]" id="vtotal-'+a+'" readonly></td>';
		var fila6 ='<td align="center"><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteRow(this)"><input type="hidden" name="id['+a+']" value="'+a+'" class="id"></td>';
   
  	var filacom=fila1+fila2+fila3+fila4+fila5+fila6;
		
		a=a+1;
  
		document.getElementById("productos").insertRow(-1).innerHTML = filacom;
		document.getElementById('nf').innerHTML=a;
		// document.getElementById('impre').innerHTML=a;

		recuento()
	} 

	function agregarFilaVacia(){
 		var a=parseFloat(document.getElementById('nf').innerHTML);
		 a=a+1;
  
		var fila1 ='<td align="center" class="item">'+a+'</td>';
		var fila2 ='<td>'+
									'<input type="text" class="campo-xs rubro" name="arreglo['+a+'][rubro]" id="rubro-'+a+'" placeholder="Ingrese aca un concepto diferente a los de la seleccion">'+
								'</td>'
		var fila3 ='<td><input type="text" class="campo-xs cantidad" value="0" name="arreglo['+a+'][cantidad]" id="cantidad-'+a+'" onChange="calcula(this.id)"></td>';
		var fila4 ='<td><input type="text" class="campo-xs vunitario" value="0" name="arreglo['+a+'][vunitario]" id="vunitario-'+a+'" onChange="calcula(this.id)"  onKeyUp="separador(this.id)"></td>';
		var fila5 ='<td><input type="text" class="campo-xs vtotal" value="0" name="arreglo['+a+'][vtotal]" id="vtotal-'+a+'" readonly></td>';
		var fila6 ='<td align="center"><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteRow(this)"><input type="hidden" name="id['+a+']" value="'+a+'" class="id"></td>';
   
  	var filacom=fila1+fila2+fila3+fila4+fila5+fila6;
		
		// a=a+1;
  
		document.getElementById("productosVac").insertRow(-1).innerHTML = filacom;
		document.getElementById('nf').innerHTML=a;
		// document.getElementById('impre').innerHTML=a;

		recuento()
	}
	
	function deleteRow(btn) { 
		var row = btn.parentNode.parentNode; 
		row.parentNode.removeChild(row);

		var a=parseFloat(document.getElementById('nf').innerHTML);
		a=a-1;
		document.getElementById('nf').innerHTML=a;
		// document.getElementById('impre').innerHTML=a;
		
		calculaSubTotal()
		recuento()
	}
	
	function recuento(){

		var item = document.querySelectorAll('.item');
		var rubro = document.querySelectorAll('.rubro');
		var cantidad = document.querySelectorAll('.cantidad');
		var vunitario = document.querySelectorAll('.vunitario');
		var vtotal = document.querySelectorAll('.vtotal');
		var id = document.querySelectorAll('.id');
				
		console.log(item)

		for(var i=0;i<id.length;i++){
			
			rubro[i].setAttribute("name", 'arreglo['+(i+1)+'][rubro]');
			cantidad[i].setAttribute("name", 'arreglo['+(i+1)+'][cantidad]');
			vunitario[i].setAttribute("name", 'arreglo['+(i+1)+'][vunitario]');
			vtotal[i].setAttribute("name", 'arreglo['+(i+1)+'][vtotal]');
			
			rubro[i].setAttribute("id", 'rubro-'+(i+1));
			cantidad[i].setAttribute("id", 'cantidad-'+(i+1));
			vunitario[i].setAttribute("id", 'vunitario-'+(i+1));
			vtotal[i].setAttribute("id", 'vtotal-'+(i+1));
			
			id[i].setAttribute("name", 'id['+(i+1)+"]");
			id[i].value=i+1;
//			if(i!=(id.length-1)){
				item[i].innerHTML=i+1;
//			}
		}

	}
	
	function validaDestino(){
		var depto = document.getElementById('IdDepartamento').value;
		var mcpio = document.getElementById('IdMunicipio').value;
    
    var fsalida = document.getElementById('fsalida').value;
		var fregreso = document.getElementById('fregreso').value;
		
		if(depto && mcpio && fsalida && fregreso){			
		}else{
			swal({
				text: "¡Debe seleccionar primero el destino y las fechas del viaje!",
				type: "warning",
				confirmButtonText: "¡Cerrar!"
			}).then(function(result){
				if (result.value) {
					document.getElementById('IdDepartamento').focus();
					return;
				}
			});
			
		}
    
    
	}
	
	function validaDepto(){
		var depto = document.getElementById('IdDepartamento').value;
		
		if(depto){			
		}else{
			swal({
				text: "¡Debe seleccionar primero el departamento!",
				type: "warning",
				confirmButtonText: "¡Cerrar!"
			}).then(function(result){
				if (result.value) {
					document.getElementById('IdDepartamento').focus();
					return;
				}
			});
		}
	}
	
	function traeGasto(id,valor){
		
		var arregloId = id.split("-");
    
		var depto = document.getElementById('IdDepartamento').value;
		var mcpio = document.getElementById('IdMunicipio').value;
    var fsalida = document.getElementById('fsalida').value;
		var fregreso = document.getElementById('fregreso').value;
		var tabla = '<?php echo $cadenaTablaGastos ?>';
		var arregloTabla = JSON.parse(tabla);	
    
		var formatter = new Intl.NumberFormat('en-US');
    
    if(valor=='alojamiento' || valor=='alimentacion' || valor=='hidratacion' || valor=='taeropuerto'){
      if(depto!=28){
        var parametro = depto;
      }else{
        var parametro = mcpio;
      }
		
		  $('#vunitario-'+arregloId[1]).val(formatter.format(parseInt(arregloTabla[parametro][valor]).toFixed(0)))
      
      let fechaInicio = new Date($("#fsalida").val());
      let fechaFin = new Date($("#fregreso").val());

      let diferenciaMilisegundos = fechaFin - fechaInicio;      
      let diferenciaDias = Math.round(diferenciaMilisegundos / (1000 * 60 * 60 * 24));
      
      if(valor=='alojamiento'){
        $('#cantidad-'+arregloId[1]).val(diferenciaDias);
      }
      
      if(valor=='alimentacion' || valor=='hidratacion'){
        $('#cantidad-'+arregloId[1]).val(diferenciaDias+1);
      }
      
    }else{
      $('#vunitario-'+arregloId[1]).removeAttr("readonly");
    }

		calcula(id)
	}
	
	function calcula(id){
		
		var arregloId = id.split("-");
		var cantidad = parseFloat(document.getElementById('cantidad-'+arregloId[1]).value);
		var vunitario = document.getElementById('vunitario-'+arregloId[1]).value;
		var formatter = new Intl.NumberFormat('en-US');
				
		vunitario = parseFloat(vunitario.replace(",", ""));		
		var vtotal = cantidad*vunitario;		
		$('#vtotal-'+arregloId[1]).val(formatter.format((vtotal).toFixed(0)));
		
		calculaSubTotal()
	}
	
	function calculaSubTotal(){
		var subtotales = document.querySelectorAll('.vtotal');
		var formatter = new Intl.NumberFormat('en-US');
		var suma = 0;
		for(var i=0;i<subtotales.length;i++){			
			suma = suma + parseFloat(subtotales[i]['value'].replace(/,/g, ""));
		}		
		$('#subtotal').html(formatter.format((suma).toFixed(0)));
	}
  
  function separador(id){
		$('#'+id).on({
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
  
  function acepta(){
   var valor = $("#chkacpt").attr("valor");
    
    if(valor==0){
      $("#chkacpt").attr("valor","1");
      document.getElementById('div-boton').style.display='';
    }
    if(valor==1){
      $("#chkacpt").attr("valor","0");
      document.getElementById('div-boton').style.display='none';
    }
    
  }

	function validaArchivo(archivo,id){
		if((archivo[0]["size"] > 600000) || (archivo[0]["type"]!="application/pdf") ){
			document.getElementById(id).value='';
			document.getElementById(id).focus();
			swal({
					title: "Error al subir el archivo",
					text: "¡El archivo no debe pesar más de 500K y ser en formato PDF!",
					type: "error",
					confirmButtonText: "¡Cerrar!"
			});
			return;
		}
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
<div class="contenedor" style="width: 900px">
  <table width="100%" border="1">
    <tbody>
      <tr>
        <td width="37.5%" align="center"><img src="../imagenes/logofa.png" width="200" alt=""/></td>
        <td width="62.5%" align="center"><h4>SOLICITUD DE ANTICIPO DE GASTOS DE VIAJE</h4></td>
      </tr>
    </tbody>
  </table>
	<br>
	<form action="graba.php" method="post" enctype="multipart/form-data" >
		<div class="grid columna-12">
			<div class="span-2 Century18" align="left">
				SOLICITANTE
			</div>
			<div class="span-4" align="left">
				<strong><?php echo $row_resultado['nombre']." ".$row_resultado['apellido'] ?></strong>
			</div>
			<div class="span-2 Century18" align="left">
				CEDULA
			</div>
			<div class="span-4" align="left">
				<strong><?php echo colocapuntos($row_resultado['cedula'])?></strong>
			</div>
			<div class="span-2 Century18" align="left">
				CARGO
			</div>
			<div class="span-4" align="left">
				<strong><?php echo $row_resultado['cargo']?></strong>
			</div>
			<div class="span-2 Century18" align="left">
				PROYECTO
			</div>
			<div class="span-4">
				<select name="IdArea" id="IdArea" class="campo-sm Arial14" style="font-weight:bold" required onChange="buscaCostos(this.value)">
					<option value="">Seleccione</option>
					<?php 
					foreach($tablaAreas as $key=>$j){
						?>
						<option value="<?php echo $key ?>"><?php echo $j['ccostos']." - ".$j['area'] ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="span-3 Century18" align="left">
				No CENTRO DE COSTOS
			</div>
			<div class="span-3" align="left" id="ccostos">
			</div>
			<div class="span-2 Century16" align="left">
				LUGAR DEL VIAJE
			</div>
			<div class="span-2">
				<select class="campo-sm Arial12" id="IdDepartamento" name="IdDepartamento" onChange="buscamun(this.value)">
					<option value="">Seleccione el Dpto</option>
					<?php
					foreach($tablaDptos as $key=>$j){
						?>
						<option value="<?php echo $key ?>"><?php echo $j ?></option>
						<?php
					}
					?>
				</select>	
			</div>
			<div class="span-2" id="midiv">
				<select name="IdMunicipio" id="IdMunicipio" class="campo-sm Arial12" required onClick="validaDepto()">
					<option value="">Selecccione el Mpio</option>
				</select>
			</div>
			<div class="span-2 Century18" align="left">
				FECHA SALIDA
			</div>
			<div class="span-2">
				<input type="date" class="campo-sm Arial12" name="fsalida" id="fsalida" required>
			</div>
			<div class="span-2"></div>
			<div class="span-2 Century16" align="left">
				FECHA REGRESO
			</div>
			<div class="span-2">
				<input type="date" class="campo-sm Arial12" name="fregreso" id="fregreso" required>
			</div>
			<div class="span-2"></div>			
			<div class="span-5 Century18" align="left">
				ACTIVIDAD A DESARROLLAR EN EL VIAJE
			</div>
			<div class="span-7">
				<textarea name="actividad" rows="1" class="txtarea" required></textarea>
			</div>
			<div class="span-12 Century20" align="center">
				A QUIEN SE LE CONSIGNA
			</div>
			<div class="span-4">
				Nombre:
				<input type="text" class="campo-sm Arial12" name="beneficiario" value="<?php echo $row_resultado['nombre']." ".$row_resultado['apellido'] ?>" required>
			</div>
			<div class="span-2">
				Cedula:
				<input type="text" class="campo-sm Arial12" name="cedula" value="<?php echo $row_resultado['cedula'] ?>" required>
			</div>
			<div class="span-2">
				Banco
				<select name="IdBanco" class="campo-sm Arial12" required>
					<option value="">Seleccion</option>
					<?php 
					do{
						?>
						<option value="<?php echo $row_resultado4['IdBanco'] ?>"><?php echo $row_resultado4['banco'] ?></option>
						<?php
					} while($row_resultado4 = mysql_fetch_assoc($resultado4));
					?>
				</select>
			</div>
			<div class="span-2">
				Clase cuenta:
				<select name="clasecuenta" class="campo-sm Arial12" required>
					<option value="">Seleccion</option>
					<option value="1">Ahorros</option>
					<option value="2">Corriente</option>
					<option value="3">Deposito electronico</option>
				</select>
			</div>
			<div class="span-2">
				No de Cuenta
				<input type="text" name="cuenta" class="campo-sm Arial12" required>
			</div>
			<div class="span-4"></div>
			<div class="span-4">
				Certificación bancaria
				<input type="file" name="certificacion" id="certificacion" class="campo-sm Arial12" onChange="validaArchivo(this.files,this.id)" required>
			</div>
			<div class="span-4"></div>
		</div>
		<br>
		<br>
		<h4 class="Century22" align="center">DESCRIPCION ESTIMADA DEL ANTICIPO</h4>
		<br>
		<table class="tablita" align="center">
      <tr>
        <td width="75" >No Items</td>
        <td width="25" id="nf">2</td>
        <td width="80"><button type="button" class="btn btn-rosa btn-xs1" onclick="agregarFila()">Agregar Item</button></td>
				<td width="110"><button type="button" class="btn btn-rosa btn-xs1" onclick="agregarFilaVacia()">Agregar Item vacio</button></td>
				<td width="585"></td>
			</tr>
		</table>	
		<table class="tablita Arial12" border="1" id="productos" align="center">
			<col width="50px">
			<col width="325px">
			<col width="150px">
			<col width="150px">
			<col width="150px">
			<col width="50px">
			<tr class="titulos">
				<td>ITEM</td>
				<td>DESCRIPCIÓN</td>
				<td>CANTIDAD</td>
				<td>VALOR UNITARIO</td>
				<td>VALOR TOTAL</td>
				<td></td>
			</tr>
			
			<tr>
				<td align="center" class="item">1</td>
				<td>
					<select name="arreglo[1][rubro]" id="rubro-1" class="campo-xs rubro" onClick="validaDestino()" onChange="traeGasto(this.id,this.value)">
						<option value="">Seleccione</option>
						<option value="alojamiento">Alojamiento</option>
						<option value="alimentacion">Alimentacion</option>
						<option value="hidratacion">Hidratacion</option>
						<option value="taeropuerto">Transporte Aeropuerto</option>            
            <option value="papeleria">Papeleria</option>
            <option value="Alquiler de equipos">Alquiler de equipos</option>
            <option value="combustible">Combustible</option>
            <option value="peajes">Peajes</option>
            <option value="Transportes Internos">Transportes Internos</option>
            <option value="refrigerios">Regrigerios</option>
            
					</select>
				</td>
				<td>
					<input type="text" class="campo-xs cantidad" value="1" name="arreglo[1][cantidad]" id="cantidad-1" onChange="calcula(this.id)">
				</td>
				<td>
					<input type="text" class="campo-xs vunitario" value="0" name="arreglo[1][vunitario]" id="vunitario-1" readonly onChange="calcula(this.id)" onKeyUp="separador(this.id)">
				</td>
				<td>
					<input type="text" class="campo-xs vtotal" value="0" name="arreglo[1][vtotal]" id="vtotal-1" readonly>
				</td>
				<td align="center">
					<!-- <img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteRow(this)"> -->
					<input type="hidden" name="id[1]" value="1" class="id">
				</td>
			</tr>
		</table>
		<table class="tablita Arial12" border="1" id="productosVac" align="center">
			<col width="50px">
			<col width="325px">
			<col width="150px">
			<col width="150px">
			<col width="150px">
			<col width="50px">
      <tr>
				<td align="center" class="item">2</td>
				<td>
          <input type="text" class="campo-xs rubro" name="arreglo[2][rubro]" id="rubro-2" placeholder="Ingrese aca un concepto diferente a los de la seleccion">
        </td>
        <td>
          <input type="text" class="campo-xs cantidad" value="0" name="arreglo[2][cantidad]" id="cantidad-2" onChange="calcula(this.id)">
        </td>
        <td>
          <input type="text" class="campo-xs vunitario" value="0" name="arreglo[2][vunitario]" id="vunitario-2" onChange="calcula(this.id)" onKeyUp="separador(this.id)">
        </td>
				<td>
          <input type="text" class="campo-xs vtotal" value="0" name="arreglo[2][vtotal]" id="vtotal-2" readonly>
        </td>
				<td>
				<input type="hidden" name="id[1]" value="1" class="id">
				</td>
			</tr>			
		</table>
		<table class="tablita Arial12"  border="1" align="center">
			<col width="50px">
			<col width="325px">
			<col width="150px">
			<col width="150px">
			<col width="150px">
			<col width="50px">
			<tr class="Arial14">
				<td colspan="4" align="center" style="font-weight: bold">TOTAL</td>
				<td id="subtotal" align="right"></td>
				<td></td>
			</tr>
		</table>
		<br>
		<h6>Certificación</h6>
		<p class="Arial14" align="justify">Acepto que el valor del anticipo de gastos de viaje, tiquetes y/o cualquier otro valor que se me entregue mediante la aceptación del presente comprobante no constituye salario para ningún efecto legal o extralegal, conforme a lo establecido en el Art 15 de la ley 50 de 1990. Los anticipos y tiquetes que me entreguen por el presente documento me comprometo a legalizarlo totalmente dentro de los 48 horas siguentes a la terminación del viaje, de lo contrario los dineros objeto del anticipo entregados se descontarán de mi salario o liquidación del contrato de prestaciones de servicios firmado con ustedes o cualquier pago que se me haga en mi liquidación; lo que expresamente autorizo con la aceptación del presente documento.</p>
		<br>
    <div align="center">
      Acepto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="chkacpt" valor="0" onClick="acepta()">
    </div>
    <br>
		<div align="center" id="div-boton" style="display: none">
			<p class="rojo">
				ANTES DE GRABAR REVISE TODOS LOS ITEMS, YA QUE DESPUES DE GRABADO NO SE PODRAN ADICIONAR ITEMS, Y SOLO SE AUTORIZARAN LOS QUE QUEDEN GRABADOS
			</p>
			<input type="hidden" name="IdSolicitante" value="<?php echo $usuario ?>">
			<button type="submit" class="btn btn-rosa btn-sm" name="boton2">Grabar</button>
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
<?php
include('footer.php');
?>

</body>
</html>