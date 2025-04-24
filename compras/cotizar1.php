<?php require_once('../connections/datos.php'); ?>
<?php 

if(isset($_POST['orden'])){
  $ordenc=$_POST['orden'];
  $item=$_POST['item'];
  $rubro=$_POST['rubro'];
}
if(isset($_GET['orden'])){
  $ordenc=$_GET['orden'];
  $item=$_GET['item'];
  $rubro=$_GET['rubro'];
}

$graba="UPDATE itemoc SET IdRubro=".$rubro." WHERE IdItem=".$item."";
mysql_query($graba,$datos);

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
$query_Recordset1 = sprintf("SELECT ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido FROM (ordencompra  INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "0";
if (isset($item)) {
  $var1_Recordset2 = $item;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT * FROM itemoc WHERE IdItem=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT IdProveedor, proveedor from proveedores";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$var1_Recordset4 = "0";
if (isset($item)) {
  $var1_Recordset4 = $item;
}
mysql_select_db($database_datos, $datos);
$query_Recordset4 = sprintf("SELECT proveedor, documento, cotizaciones.precio, iva, impoconsumo, cotizacion, observaciones, fpago, medio, descuento, IdCotizacion, cotizaciones.IdProveedor, cotizaciones.IdFpago, cotizaciones.IdMpago FROM ((cotizaciones INNER join proveedores On cotizaciones.IdProveedor=proveedores.IdProveedor) left JOIN fpago ON cotizaciones.IdFpago=fpago.IdFpago) left join mediosp on cotizaciones.IdMpago=mediosp.IdMpago WHERE IdItem=%s", GetSQLValueString($var1_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset5 = "Select IdFpago, fpago from fpago";
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_datos, $datos);
$query_Recordset6 = "SELECT IdMpago, medio FROM mediosp";
$Recordset6 = mysql_query($query_Recordset6, $datos) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);
?>
<?php 
include('encabezado.php');	
?>
<script language="JavaScript" type="text/javascript">


function Valida(form)
{
   if (form.proveedor.value == 0)
   {
      alert("Debes seleccionar Un proveedor");
      form.proveedor.focus();
	  return false;
   }
	 if (form.precio.value == "")
   {
      alert("Debes Ingresar el Precio Unitario");
      form.precio.focus();
	  return false;
   }
   if (form.desc.value == "")
   {
     alert("Debes Ingresar el Descuento, si no tiene escriba 0");
      form.desc.focus();
	  return false;
     
   }
   if (form.iva.value == "")
   {
     alert("Debes Ingresar el IVA, si no tiene escriba 0");
      form.iva.focus();
	  return false;
     
   }
	 if (form.fpago.value == "")
   {
     alert("Debes Ingresar la forma de pago");
      form.fpago.focus();
	  return false;
     
   }
   if (form.mpago.value == "")
   {
     alert("Debes Ingresar el medio de pago");
      form.mpago.focus();
	  return false;
     
   }
   form.submit();
}

function calcula(id){
  const cantidad=<?php echo $row_Recordset2['cantidad']?>;
  console.log(id)
	var precio = document.getElementById('precio'+id).value;
  var subt = document.getElementById('subt'+id).value;
  var desc = (document.getElementById('desc'+id).value)/100;
  var subtcd = document.getElementById('subtcd'+id).value;
  var iva = (document.getElementById('iva'+id).value)/100;
	var impoconsumo = (document.getElementById('impoconsumo'+id).value)/100;
  var tot = document.getElementById('tot'+id).value;

	console.log(precio,subt,desc,subtcd,iva,tot)

	document.getElementById('subt'+id).value=precio*cantidad;
  document.getElementById('subtcd'+id).value=(precio*cantidad)*(1-desc);
  document.getElementById('tot'+id).value=(((precio*cantidad)*(1-desc))*(1+iva+impoconsumo)).toFixed(2);
  
}
  
function descuento(obj,id,val){
  const valor=document.getElementById(val).value;
  const desc=(obj/100);
  const sub=1-desc;
  const tot=valor*sub;
  document.getElementById(id).value=Math.round(tot*100)/100;
  
}

function total(obj,id,val){
  const valor=document.getElementById(val).value;
  const iva=(obj/100);
  const sub=1+iva;
  const tot=valor*sub;
  document.getElementById(id).value=Math.round(tot*100)/100;
  
}
function obligar(obj){
  
  var diva=document.getElementById('arch');
  
  if(obj==1){
    diva.removeAttribute("required");   
  }else{
    //alert (obj);
    diva.setAttribute("required","required")
  }
    
}
  
  
function obligan(obj){
  if(obj==3){
    document.getElementById("arch").innerHTML='';
  }else{
    document.getElementById("arch").innerHTML='<input type="file" name="archivo" class="campo-sm Arial12"  required="required" />';
  }
}

window.onload=function() {
  var items=<?php echo $totalRows_Recordset4 ?>;
  for (var i = 1; i <= items; i++){
    calcula(i);
    // descuento(desc,idstcd,idst);
    // total(iva,idto,idstcd);
  }
  
}
 
function validarArchivo(archivo,item){
        
    if((archivo[0]["size"] > 2000000) || (archivo[0]["type"]!="application/pdf") ){
          
  		$("#"+item).val("");
      
      swal({
		      title: "Error al subir el archivo",
		      text: "¡El archivo no debe pesar más de 2000K y ser en formato PDF!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });
  	}
  } 
  
	function cambiaProv(item) {
		$('#divCambProv').html(
			'<input type="text" class="campo-xs" id="prov-' + item + '" onKeyUp="buscaProv(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdProveedor" value="0">' +
			'<div class="drop"><ul class="hijos" id="ch-' + item + '"></ul></div>'
		);
		$('#cambiaProveedor').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
	
	function buscaProv(obj, valor, id) {
		//console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


		if ($('#ch-' + arrayId[1]).is(':visible')) {

		} else {
			$('#ch-' + arrayId[1]).slideToggle();
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
				document.getElementById('ch-' + arrayId[1]).innerHTML = respuesta
			}
		})
	}
 
	function modal(item,id){ 
		$('#ch-'+item).slideToggle();
		document.getElementById('itemp').value=item
		$('#cambiaProveedor').modal('hide');
		$('#creacargo').modal({backdrop: 'static', keyboard: false});
		
	}
	
	
	function llenar(id, nombre, item) {
		$('#cambiaProveedor').modal('hide');
		//console.log(id, nombre, item)
		var item1="'"+item+"'"
		document.getElementById('proveedor'+item).value=id;
		$('#tdprov-' + item).html(
			'<div style="width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaProv('+ item1 + ')">' + nombre + '</div>'+
			'<input type="hidden" name="proveedor" id="proveedor'+item+'" value="'+id+'">'
		);
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
						//console.log(respuesta);
            var matriz = respuesta.split(",");
            if(matriz[0]=="ok"){
              swal({
                text: "¡EL PROVEEDOR FUE CREADO!",
                type: "success",
                confirmButtonText: "¡Cerrar!"                
              }); 
							llenar(matriz[1], matriz[2], item)
              
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
									llenar(matriz[1], matriz[2], item)
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
<div class="contenedor" align="center">
  <h4 class="Century">COTIZAR SOLICITUD DE COMPRA No <?php echo $ordenc ?></h4> 
  <br><br>
</div>
<div class="contenedor" style="width: 900px">
	<div class="grid columna-4">
		<div class="span-1 Century18">
			PROYECTO/AREA 
		</div>
		<div class="span-1">
			<strong><?php echo $row_Recordset1['area'] ?></strong>
		</div>
		<div class="span-1 Century18">
			FECHA DE SOLICITUD 
		</div>
		<div class="span-1">
			<strong><?php echo fechaactual3($row_Recordset1['fsolicitud']) ?></strong>
		</div>
		<div class="span-1 Century18">
			SOLICITANTE
		</div>
		<div class="span-1">
			<strong><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido'] ?></strong>
		</div>
	</div>
  <br>
  <table width="100%" border="1" class="tablita Arial14">
    <tbody>
      <tr class="titulos">
        <td width="230">PRODUCTO O SERVICIO</td>
        <td>UND.</td>
        <td>CANT.</td>
        <td>FECHA PARA LA CUAL SE REQUIERE</td>
        <td width="230">OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD </td>
        <td>PROD</td>
        <td>SERV</td>
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
      <tr class="Arial14">
        <td><?php echo $row_Recordset2['producto']; ?></td>
        <td align="center"><?php echo $row_Recordset2['unidad']; ?></td>
        <td align="right"><?php echo $row_Recordset2['cantidad']; ?></td>
        <td align="center"><?php echo $row_Recordset2['frequerido']; ?></td>
        <td><?php echo $row_Recordset2['especificacion']; ?></td>
        <td align="center"><?php echo $prod ?></td>
        <td align="center"><?php echo $serv ?></td>
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
  <br>
  
  
</div>
  
<div class="container-fluid" style="width: 1400px"> 
  <div class="container" align="center">
    <h5 class="Century22">COTIZACIONES</h5> 
    <br>
    </div>
  	
		<table width="100%" border="1" class="tablita Arial12">
			<tbody>
				<tr class="titulos">
					<td width="291px" colspan="2">PROVEEDOR</td>
					<td width="85px" rowspan="2">VALOR U</td>
					<td width="85px" rowspan="2">SUB TOTAL</td>
					<td width="45px" rowspan="2">DESC.</td>
					<td width="95px" rowspan="2">TOTAL</td>
					<td width="55px" rowspan="2">IVA</td>
					<td width="70"rowspan="2">IMPO CONSUMO</td>
					<td width="95px" rowspan="2">TOTAL</td>
					<td width="95px" rowspan="2">F PAGO</td>
					<td width="95px" rowspan="2">M PAGO</td>
					<td width="170px" rowspan="2">OBSERVACIONES</td>
					<td width="200px" rowspan="2">SUBIR COTIZACION</td>
					<td width="47px" rowspan="2"></td>
        </tr>
        <tr class="titulos">
          <td width="205px" >Nombre</td>
          <td width="85px" >Documento</td>
        </tr>
				<?php
			if($totalRows_Recordset4>0){
				$i=1;
				do{
					$subtot=$row_Recordset4['precio']*$row_Recordset2['cantidad'];
					$subtotcd=$subtot*(1-$row_Recordset4['descuento']);  
					$totac=$subtotcd*(1+$row_Recordset4['iva']+$row_Recordset4['impoconsumo']);
					?>
					<form action="graba.php" method="post" enctype="multipart/form-data" >
						<tr>
							<td valign="top" id="tdprov-<?php echo $i?>">
								<div style="width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis"><?php echo $row_Recordset4['proveedor']?></div>
              </td>
              <td align="right" valign="top"><?php echo colocapuntos($row_Recordset4['documento'])?></td>
							<td align="right" valign="top"><input type="text" name="precio" id="precio<?php echo $i ?>"  class="campo-sm Arial12" style="width: 85px" value="<?php echo $row_Recordset4['precio'] ?>"  onblur="calcula(<?php echo $i ?>)"/></td>
							<td align="right" valign="top"><input type="text" name="subt" id="subt<?php echo $i ?>" class="campo-sm Arial12" style="width: 85px" readonly /></td>
							<td align="right" valign="top"><input type="text" name="desc" id="desc<?php echo $i ?>" class="campo-sm Arial12" style="width: 45px" value="<?php echo $row_Recordset4['descuento']*100  ?>" onblur="calcula(<?php echo $i ?>)" /></td>
							<td align="right" valign="top"><input type="text" name="subtcd" id="subtcd<?php echo $i ?>" class="campo-sm Arial12" style="width: 95px" readonly /></td>
							<td align="right" valign="top">
								<select class="campo-sm Arial12" name="iva" id="iva<?php echo $i ?>"  onChange="calcula(<?php echo $i ?>)">
									<option value="<?php echo $row_Recordset4['iva']*100?>"><?php echo $row_Recordset4['iva']*100 ?></option>
									<option value="0">0</option>
									<option value="5">5</option>
									<option value="19">19</option>
								</select>
							</td>
							<td align="right" valign="top"><input type="text" name="impoconsumo" id="impoconsumo<?php echo $i?>" class="campo-sm Arial12" style="width: 70px" value="<?php echo $row_Recordset4['impoconsumo']*100  ?>" onblur="calcula(<?php echo $i ?>)"></td>
							<td align="right" valign="top"><input type="text" name="tot<?php echo $i ?>" id="tot<?php echo $i ?>" class="campo-sm Arial12" style="width: 95px" readonly  /></td>
							<td valign="top">
								<select class="campo-sm Arial12" name="fpago" required="required">
									<option value="<?php echo $row_Recordset4['IdFpago'] ?>"><?php echo $row_Recordset4['fpago'] ?></option>
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
							<td valign="top">
								<select class="campo-sm Arial12" name="mpago" required="required">
									<option value="<?php echo $row_Recordset4['IdMpago'] ?>"><?php echo $row_Recordset4['medio'] ?></option>
									<?php
									do {  
										?>
										<option value="<?php echo $row_Recordset6['IdMpago']?>"><?php echo $row_Recordset6['medio']?></option>
										<?php
									} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));
									$rows = mysql_num_rows($Recordset6);
									if($rows > 0) {
											mysql_data_seek($Recordset6, 0);
										$row_Recordset6 = mysql_fetch_assoc($Recordset6);
									}
									?>
								</select>
							</td>
							<td align="center" valign="top"><?php echo $row_Recordset4['observaciones']?></td>
							<td align="center" valign="top">
								<input type="file" name="archivo" id="arch<?php echo $i ?>" class="campo-sm Arial10" onChange="validarArchivo(this.files,this.id)" >
								<?php 
									if(is_null($row_Recordset4['cotizacion']) OR $row_Recordset4['cotizacion']=="" ){

									}else{  
									?>  
								<a href="<?php echo $row_Recordset4['cotizacion'] ?>" target="_blank" class="btn btn-rosa btn-xs1" style="margin: 3px">Ver cotizacion</a>
								<?php 
									}
									?>
								</td>
							<td valign="top">
								<input type="hidden" name="orden" value="<?php echo $ordenc ?>" />
								<input type="hidden" name="item" value="<?php echo $row_Recordset2['IdItem'] ?>" />
								<input type="hidden" name="id" value="<?php echo $row_Recordset4['IdCotizacion'] ?>">
								<input type="hidden" name="cotizacion" value="<?php echo $row_Recordset4['cotizacion'] ?>">
								<input type="hidden" name="proveedor" id="proveedor<?php echo $i?>" value="<?php echo $row_Recordset4['IdProveedor'] ?>">
								<button type="submit" class="btn btn-rosa btn-xs1"  name="boton15">Actualizar</button></td>
						</tr>
					</form>
					<?php
					$i++;
				}while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
				$rows = mysql_num_rows($Recordset4);
				if($rows > 0) {
						mysql_data_seek($Recordset4, 0);
					$row_Recordset4 = mysql_fetch_assoc($Recordset4);
				}
			}
			?>
			</tbody>
		</table>
  <br>  
</div> 
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
	mysql_close($datos);
						 
include('footer.php')
						

?>



</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);
?>
