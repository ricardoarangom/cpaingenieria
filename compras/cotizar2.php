<?php require_once('../connections/datos.php'); ?>
<?php 

$ordenc=$_GET['orden'];

if($_GET['mostrar']==1){
	$mostrar=1;
}else{
	$mostrar=0;
}

session_start();
 $autor=$_SESSION['IdUsuario'];

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
if (isset($ordenc)) {
  $var1_Recordset1 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("Select ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido from (ordencompra  LEFT JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) LEFT JOIN areas ON ordencompra.IdArea=areas.IdArea where IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($ordenc)) {
  $var1_Recordset2 = $ordenc;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT IdItem, IdOrdencompra, PS, producto, especificacion, itemoc.unidad, cantidad, frequerido, cotizado, autorizado, comprado, entregado, observaciones, derogada, observarecibo, inspec, cument, cumreq, muestreo, recibidopor, conforme, cantrreci FROM itemoc WHERE IdOrdencompra=%s ORDER BY producto", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdProveedor, proveedor FROM proveedores ORDER BY proveedor";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset5 = "Select IdFpago, fpago from fpago";
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT IdMpago, medio FROM mediosp";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<?php 
include('encabezado.php');
?>
<script language="JavaScript" type="text/javascript">
  
function valida(item){
  
  var precio = document.getElementById('precio'+item).value;
  var proveedor = document.getElementById('proveedor'+item).value;
  var fpago = document.getElementById('fpago'+item).value;
  var mpago = document.getElementById('mpago'+item).value;
  console.log(proveedor);
  
  if(precio==0 || proveedor==0 || fpago==0 || mpago==0){
    if(proveedor==0){
      alert('DEBE SELECCIONAR UN PROVEEDOR');
//      document.getElementById('proveedor'+item).focus();
      return false;
    }
    if(precio==0){
      alert('DEBE INGRESAR EL PRECIO UNITARIO');
      document.getElementById('precio'+item).focus();
      return false;
    }
    if(fpago==0){
      alert('DEBE SELECCIONAR LA FORMA DE PAGO');
      document.getElementById('fpago'+item).focus();
      return false;
    }
		
		if(mpago==0){
      alert('DEBE SELECCIONAR EL MEDIO DE PAGO');
      document.getElementById('mpago'+item).focus();
      return false;
    }
    
    return false;
  } 
  
   //form.submit();
}  
  
function validarArchivo(archivo,item){
        
    if((archivo[0]["size"] > 2000000) || (archivo[0]["type"]!="application/pdf") ){
          
  		$("#arch"+item).val("");
      
      swal({
		      title: "Error al subir el archivo",
		      text: "¡El archivo no debe pesar más de 2000K y ser en formato PDF!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });
  	}
  }  

function calcula(cantidad,item){
  var precio = document.getElementById('precio'+item).value;
  var subt = document.getElementById('subt'+item).value;
  var desc = (document.getElementById('desc'+item).value)/100;
  var subtcd = document.getElementById('subtcd'+item).value;
  var iva = (document.getElementById('iva'+item).value)/100;
	var impoconsumo = (document.getElementById('impoconsumo'+item).value)/100;

  var tot = document.getElementById('tot'+item).value;
  
  document.getElementById('subt'+item).value=precio*cantidad;
  document.getElementById('subtcd'+item).value=(precio*cantidad)*(1-desc);
  document.getElementById('tot'+item).value=(((precio*cantidad)*(1-desc))*(1+iva+impoconsumo)).toFixed(2);
  
}

	function buscaProv(obj, valor, id) {
		console.log(obj,valor,id)
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
		datos.append("proced", 29);

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
		console.log(obj,valor,id)
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
		datos.append("proced", 36);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				//console.log(respuesta)
        if(arrayId[0]=='proveedorn'){
          document.getElementById('chn-' + arrayId[1]).innerHTML = respuesta
        }else{
          document.getElementById('cchn-' + arrayId[1]).innerHTML = respuesta
        }
			}
		})
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
		
		document.getElementById('itemp').value=item
		$('#cambiaProveedor').modal('hide');
		$('#creacargo').modal({backdrop: 'static', keyboard: false});
		
	}
	
	
	function llenar(id, nombre, item,documento) {
		$('#cambiaProveedor').modal('hide');
		console.log(id, nombre, item,documento)
		var item1="'"+item+"'"
		document.getElementById('proveedor'+item).value=id;
		$('#tdprov-' + item).html(
			'<div style="width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaProv('+ item1 + ')">' + nombre + '</div>'+
			'<input type="hidden" name="proveedor" id="proveedor'+item+'" value="'+id+'">'
		);
    $('#tdnit-' + item).html(
			'<div style="width: 75px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaProvn('+ item1 + ')">' + documento + '</div>'
		);
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
  
	function graba(){
		var proveedor = document.getElementById('proveedor').value;		
    var item = document.getElementById('itemp').value;
		var nit = document.getElementById('nit').value;
		if(proveedor==""){
			swal({
				text: "¡DEBE ESCRIBIR EL PROVEEDOR!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
		
		if(nit==""){
			swal({
				text: "¡DEBE ESCRIBIR EL NIT!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
        
		var datos = new FormData();
		datos.append("proveedor",proveedor);
		datos.append("nit",nit);
		datos.append("proced",24);
    
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
                text: "¡EL PROVEEDOR FUE CREADO!",
                type: "success",
                confirmButtonText: "¡Cerrar!"                
              }); 
							llenar(matriz[1], matriz[2], item, matriz[3])
              
            }
						if(matriz[0]=="ya"){
							swal({
								
                html: '<div class="Arial16">EL NIT DIGITADO YA ESTA EN LA BASE DE DATOS Y CORRESPONDE A:</div><div class="Arial16" style="font-weight: bold">'+matriz[2]+'</div><div class="Arial16">¿DESEA ASIGNARLO?</div>',
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


</style>
<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center">
  <h4 class="Century">COTIZAR SOLICITUD DE COMPRA No <?php echo $ordenc ?></h4> 
  <br>
</div>
<div class="contenedor" style="width:1200px;">
	<div class="grid columna-15">
		<div class="span-3 Century18">
			PROYECTO/AREA
		</div>
		<div class="span-3">
			<strong><?php echo $row_Recordset1['area'] ?></strong> 
		</div>
		<div class="span-3 Century18">
			FECHA DE SOLICITUD
		</div>
		<div class="span-2">
			<strong><?php echo fechaactual3($row_Recordset1['fsolicitud']) ?></strong>
		</div>
		<div class="span-1 Century18">
			SOLICITANTE
		</div>
		<div class="span-3">
			<strong><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido'] ?></strong>
		</div>
	</div>
  <br>
</div>  
<div class="contenedor" style="width: 1200px">  
  <table width="100%" border="0">
    <tr>
      <td width="80%">
				<?php 
				if($mostrar==0){
					?>
					<a href="editasc.php?orden=<?php echo $ordenc ?>" class="btn btn-rosa btn-xs1" target="_blank">EDITAR SOLICITUD</a>&nbsp;
        	<a href="autorizarsc2.php?orden=<?php echo $ordenc ?>" class="btn btn-rosa btn-xs1" target="_blank">VER CUADRO COMPARATIVO</a>&nbsp;
        	<a href="anularsc.php?orden=<?php echo $ordenc ?>" class="btn btn-rojo btn-xs1" >ANULAR SOLICITUD</a>&nbsp;
					<?php
				}else{
					?>
					<a href="autorizarsc2.php?orden=<?php echo $ordenc ?>" class="btn btn-rosa btn-xs1" target="_blank">VER CUADRO COMPARATIVO</a>
					<?php
				}
				?>
        
			</td>
      <td align="right">
       
      </td>
    </tr>
  </table>
  <table width="100%" border="1" class="Arial14 tablita">
    <tbody>
      <tr class="titulos">
        <td width="249" align="center">PRODUCTO O SERVICIO</td>
        <td width="65" align="center">UND.</td>
        <td width="65" align="center">CANT.</td>
        <td width="160" align="center">FECHA PARA LA CUAL SE REQUIERE</td>
        <td width="249" align="center">OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD </td>
        <td width="65" align="center">PROD</td>
        <td width="65" align="center">SERV</td>						
        <td width="75" align="center"></td>
        <td width="75" align="center"></td>
        </tr>
      <?php 
      do{
        if($row_Recordset2['PS']==1){
          $prod="X";
          $serv="";
        }
        if($row_Recordset2['PS']==0){
          $prod="";
          $serv="X";
        }
      	?>
				<tr>
					<td valign="top"><?php echo $row_Recordset2['producto']; ?></td>
					<td align="center" valign="top"><?php echo $row_Recordset2['unidad']; ?></td>
					<td align="right" valign="top"><?php echo ($row_Recordset2['cantidad']); ?></td>
					<td align="center" valign="top"><?php echo $row_Recordset2['frequerido']; ?></td>
					<td valign="top"><?php echo $row_Recordset2['especificacion']; ?></td>
					<td align="center" valign="top"><?php echo $prod ?></td>
					<td align="center" valign="top"><?php echo $serv ?></td>

					
					<?php 
					if(is_null($row_Recordset2['cotizado'])){
						?>
						<td colspan="2" align="center" valign="top" class="Arial11">COTIZACIONES SIN COMPLETAR</td>
						<?php 
					}else{
						?>
						<td colspan="2" align="center" valign="top">COTIZADO</td>
						<?php
					}  
					?>  
				</tr>
      	<?php 
      }while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
      $rows = mysql_num_rows($Recordset2);
      if($rows > 0) {
          mysql_data_seek($Recordset2, 0);
        $row_Recordset2 = mysql_fetch_assoc($Recordset2);
      }
      ?>
		</tbody>
	</table>
</div>
<br>
<div class="container-fluid" style="width: 1500px">
  <div class="container" align="center">
    <h5 class="Century22">COTIZACIONES</h5>
    </div>
  <br>
  <?php 
  do{
    $buscaCot="SELECT proveedor, documento, cotizaciones.precio, iva, cotizacion, observaciones, fpago, medio, descuento, IdCotizacion, cotizaciones.IdProveedor, impoconsumo FROM ((cotizaciones INNER join proveedores On cotizaciones.IdProveedor=proveedores.IdProveedor) left JOIN fpago ON cotizaciones.IdFpago=fpago.IdFpago) left join mediosp on cotizaciones.IdMpago=mediosp.IdMpago WHERE IdItem=".$row_Recordset2['IdItem']."";
    $resultadoCot = mysql_query($buscaCot, $datos) or die(mysql_error());
    $fila_Cot = mysql_fetch_assoc($resultadoCot);
    $totalfila_Cot = mysql_num_rows($resultadoCot);
    ?>
  	<h6 class="Arial16" style="margin-bottom: 0"><strong><?php echo $row_Recordset2['producto']; ?></strong></h6>
		<?php 
    if($totalfila_Cot>0){
			if($mostrar==0){
				?>
  			<a class="btn btn-rosa btn-xs1" href="cotizar1.php?orden=<?php echo $row_Recordset2['IdOrdencompra']?>&item=<?php echo $row_Recordset2['IdItem']?>&rubro=<?php echo $row_Recordset2['IdRubro']?>" role="button">Editar Cotización</a>
				<?php
			}
		}
		?>
		<table width="100%" border="1" class="Arial12 tablita <?php echo $row_Recordset2['IdItem']?>">
			<tbody>
				<tr class="titulos">
					<td colspan="2" align="center">PROVEEDOR</td>
					<td width="85" rowspan="2" align="center">VALOR U</td>
					<td width="85" rowspan="2" align="center">SUB TOTAL</td>
					<td width="45" rowspan="2" align="center">DESC.</td>
					<td width="95" rowspan="2" align="center">TOTAL</td>
					<td width="55" rowspan="2" align="center">IVA</td>
					<td width="70"rowspan="2" align="center">IMPO CONSUMO</td>
					<td width="95" rowspan="2" align="center">TOTAL</td>
					<td width="95" rowspan="2" align="center">F PAGO</td>
					<td width="95" rowspan="2" align="center">M PAGO</td>
					<td width="170" rowspan="2" align="center">OBSERVACIONES</td>
					<td width="200" rowspan="2" align="center">SUBIR COTIZACION</td>
					<td width="47" rowspan="2" align="center">&nbsp;</td>
        </tr>
        <tr class="titulos">
          <td width="205" >Nombre</td>
          <td width="85" >Documento</td>
        </tr>
					<?php 
					if($totalfila_Cot>0){
						$i=1;
						do{
							$subtot=$fila_Cot['precio']*$row_Recordset2['cantidad'];
							$subtotcd=$subtot*(1-$fila_Cot['descuento']);  
							$totac=$subtotcd*(1+$fila_Cot['iva']+$fila_Cot['impoconsumo']);
							?>            
							<tr>
								<td valign="top"><?php echo $fila_Cot['proveedor']?></td>
                <td align="right" valign="top"><?php echo colocapuntos($fila_Cot['documento'])?></td>
								<td align="right" valign="top"><?php echo number_format($fila_Cot['precio'],0) ?></td>
								<td align="right" valign="top"><?php echo number_format($subtot,0) ?></td>
								<td align="right" valign="top"><?php echo $fila_Cot['descuento']*100?>%</td>
								<td align="right" valign="top"><?php echo number_format($subtotcd,0) ?></td>
								<td align="right" valign="top"><?php echo $fila_Cot['iva']*100?>%</td>
								<td align="right" valign="top"><?php echo $fila_Cot['impoconsumo']*100?>%</td>
								<td align="right" valign="top"><?php echo number_format($totac,0) ?></td>
								<td valign="top"><?php echo $fila_Cot['fpago'] ?></td>
								<td valign="top"><?php echo $fila_Cot['medio'] ?></td>
								<td valign="top"><?php echo $fila_Cot['observaciones']?></td>
								<td align="center" valign="top">
									<?php 
									if(is_null($fila_Cot['cotizacion']) OR $fila_Cot['cotizacion']=="" ){

									}else{  
										?>  
										<a href="<?php echo $fila_Cot['cotizacion'] ?>" target="_blank" class="btn btn-rosa btn-xs1">Ver cotizacion</a>&nbsp;
										<?php 
									}
									?>
								</td>
								<td valign="top"></td>
							</tr>
							<?php
							$i++;
						}while ($fila_Cot = mysql_fetch_assoc($resultadoCot));
						$rows = mysql_num_rows($resultadoCot);
						if($rows > 0) {
							mysql_data_seek($resultadoCot, 0);
							$fila_Cot = mysql_fetch_assoc($resultadoCot);
						}
					}
					$k=$totalfila_Cot+1;
					if(is_null($row_Recordset2['cotizado'])){
						for($j=($k);$j<=3;$j++){
							$item=$row_Recordset2['IdItem']."_".$j;
							?>
							<form name="form<?php echo $j ?>"  method="post" action="graba.php" enctype="multipart/form-data" onsubmit="return valida('<?php echo $item?>')" >
								<tr>
									<td id="tdprov-<?php echo $item ?>">
										<input type="text" class="campo-xs" id="proveedor-<?php echo $item ?>" onKeyUp="buscaProv(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off" rerquired>
										<div class="drop">
											<ul class="hijos" id="ch-<?php echo $item ?>">
											</ul>
										</div>
									</td>
                  <td align="right" id="tdnit-<?php echo $item ?>">
                    <input type="text" class="campo-xs" id="proveedorn-<?php echo $item ?>" onKeyUp="buscaProvn(this,this.value,this.id)" placeholder="Buscar X nit" autocomplete="off" rerquired>
										<div class="drop">
											<ul class="hijos" id="chn-<?php echo $item ?>">
											</ul>
										</div>
                  </td>
									<td><input type="text" class="campo-sm Arial12" name="precio" id="precio<?php echo $item?>" value="0" onBlur="calcula(<?php echo $row_Recordset2['cantidad']?>,'<?php echo $item?>')"></td>
									<td><input type="text" class="campo-sm Arial12" name="subt" id="subt<?php echo $item?>" readonly value="0" ></td>
									<td><input type="text" class="campo-sm Arial12" name="desc" id="desc<?php echo $item?>" value="0" onBlur="calcula(<?php echo $row_Recordset2['cantidad']?>,'<?php echo $item?>')"></td>
									<td><input type="text" class="campo-sm Arial12" name="subtcd" id="subtcd<?php echo $item?>" readonly value="0" ></td>
									<td>
										<select class="campo-sm Arial12" name="iva" id="iva<?php echo $item?>"  onChange="calcula(<?php echo $row_Recordset2['cantidad']?>,'<?php echo $item?>')">
											<option value="0">0</option>
											<option value="5">5</option>
											<option value="19">19</option>
										</select>
										
									</td>
									<td><input type="text" class="campo-sm Arial12" name="impoconsumo" id="impoconsumo<?php echo $item?>" onChange="calcula(<?php echo $row_Recordset2['cantidad']?>,'<?php echo $item?>')" value="0"></td>
									<td><input type="text" class="campo-sm Arial12" name="tot" id="tot<?php echo $item?>" readonly value="0" ></td>
									<td>
										<select class="campo-sm Arial12" name="fpago" id="fpago<?php echo $item?>" required="required" >
											<option value="0">Seleccione</option>
											<?php
											do {  
												?>
												<option value="<?php echo $row_Recordset5['IdFpago']?>"><?php echo $row_Recordset5['fpago']?></option>
												<?php
											} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
											$rows = mysql_num_rows($Recordset5);
											if($rows > 0) {
													mysql_data_seek($Recordset5, 0);
												$row_Recordset5 = mysql_fetch_assoc($Recordset5);
											}
											?>
										</select>
									</td>
									<td>
										<select class="campo-sm Arial12" name="mpago" id="mpago<?php echo $item?>" required="required" >
										  <option value="0">Seleccione</option>
										  <?php
											do {  
												?>
												<option value="<?php echo $row_Recordset3['IdMpago']?>"><?php echo $row_Recordset3['medio']?></option>
												<?php
											} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
											$rows = mysql_num_rows($Recordset3);
											if($rows > 0) {
												mysql_data_seek($Recordset3, 0);
												$row_Recordset3 = mysql_fetch_assoc($Recordset3);
											}
											?>
                    </select>
									</td>
									<td align="center"><textarea name="observa" cols="25" rows="1" class="txtarea Arial12"></textarea></td>
									<td><input type="file" name="archivo" id="arch<?php echo $item?>" class="campo-sm Arial12" onChange="validarArchivo(this.files,'<?php echo $item?>')" style="width: 200px"></td>
									<td>
										<input type="hidden" name="orden" id="orden"  value="<?php echo $ordenc ?>" />
										<input type="hidden" name="item" id="item<?php echo $row_Recordset2['IdItem'] ?>" value="<?php echo $row_Recordset2['IdItem'] ?>" />
										<input type="hidden" name="proveedor" id="proveedor<?php echo $item?>" value="0">
										<button type="submit" class="btn btn-rosa btn-xs1"  name="boton26" >Grabar</button>
									</td>
								</tr>
							</form>
							<?php
						}
					}
					?>
			</tbody>
		</table> 
  	<?php 
    if(is_null($row_Recordset2['cotizado']) and $totalfila_Cot>0){
      ?>
  		<br>
			<div class="container" align="center">
				<form method="post" action="graba.php">
					<input type="hidden" name="item" value="<?php echo $row_Recordset2['IdItem'] ?>">
					<input type="hidden" name="producto" value="<?php echo $row_Recordset2['producto']; ?>">
					<input type="hidden" name="orden" value="<?php echo $ordenc ?>">
					<button 
											type="submit" 
											name="boton3" 
											class="btn btn-outline-danger"
											data-trigger="hover"
											data-toggle="popover"
											data-content="Si oprime este boton no podra ingresar mas cotizaciones para este item"
											title="ADVERTENCIA"


											>Cerrar Cotizaciones</button>
				</form>
			</div>
  	<?php
		}?>
  	<br><br>
  	<?php 
  }while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  ?>  
</div>
<br>

<br>
</div>

<div id="creacargo" class="modal fade" role="dialog" >
  <div class="modal-dialog" >    
    <div class="modal-content">
      <form method="post" id="formulario" name="formulario" action="">
        <div class="modal-header" style="background:#d8d8d8; color:black">
            <h5 class="modal-title">Ingrese el nuevo proveedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
					<div>
						Preveedor:
						<input type="text" name="proveedor" id="proveedor" class="campo-sm" required="required" value="" onBlur="aMayusculas(this.value,this.id)">
						<input type="hidden" id="itemp">
					</div>
					<div>
						NIT/Cedula: (sin puntos ni comas, ni digito de verificación)
						<input type="number" name="nit" id="nit" class="campo-sm" required="required" value="" onBlur="aMayusculas(this.value,this.id)">
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
<?php 
include('footer.php');
?>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset3);
?>
