<?php require_once('../connections/datos.php'); ?>
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

mysql_select_db($database_datos, $datos);
$query_Recordset2 = "SELECT * FROM fpago where IdFpago<=4";
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT * FROM departamentos";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT * FROM bancos ORDER BY banco";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset5 = "SELECT IdProveedor, documento FROM proveedores";
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
?>
<?php 
include('encabezado.php');
?>


<script language="JavaScript" type="text/javascript">
  
  function siesta(obj){
   if(obj==""){ 
   }else{
    let numeroPatron = /\D+/g;
    let contieneNumeros = numeroPatron.test(obj);
    let cp = obj.match(numeroPatron);
    if(contieneNumeros){
     alert('Este campo solo admite numeros'); 
     document.getElementById('nit').value=null;
     document.getElementById('nit').focus(); 
    } 
    var datos = new FormData();
		datos.append("obj",obj);
		datos.append("proced",34);
		
		$.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
					var res = respuesta.trim();
					var arregloRes=res.split(";");
					if(arregloRes[0]=='si'){
						
						alert('El documento digitado corresponde a '+arregloRes[1]+', proveedor ya registrado en la base de datos'); 
						document.getElementById('nit').value=null;
						document.getElementById('nit').focus();
					}
				}
			});
		 
		 
		 
		 
   }
  }

function aMayusculas(obj,id){
    obj = obj.toUpperCase();
    document.getElementById(id).value = obj;
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

	function buscamun(IdDepartamento){
		var datos = new FormData();
		datos.append("IdDepartamento",IdDepartamento);
		datos.append("proced",33);
		
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
					var fila = '<select name="municipio" class="campo-sm Arial12" required="required" >'+	
										 	'<option value="">Seleccione Municipio</option>';
					Object.keys(arregloTabla).forEach(key => {
						console.log(key,arregloTabla[key] )
						fila=fila+'<option value="'+key+'">'+arregloTabla[key]+'</option>'
					});
          fila=fila+'</select>';
					$('#midiv').html(fila);
				}
			});
	}
	
  function validaArchivo(archivo,id){
    if((archivo[0]["size"] > 3000000) || (archivo[0]["type"]!="application/pdf") ){
      document.getElementById(id).value='';
      document.getElementById(id).focus();
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 2.500K y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
      });
      return;
    }
  }
</script>
<?php 
include('encabezado1.php');
?>
<div class="container" style="width: 970px">
	<h4 align="center" class="Century">REGISTRO DE PROVEEDORES</h4>
  <form action="graba.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="bloquear('boton')">
    <table border="1" class="tablita Arial14" align="center">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="37">
      <col width="37">
      <col width="75">
      <tr>
        <td colspan="5">NOMBRE O RAZON SOCIAL DE LA ORGANIZACIÓN</td>
        <td colspan="5"><input type="text" name="proveedor" id="proveedor" class="campo-sm" required="required" onblur="aMayusculas(this.value,this.id)" /></td>
        <td colspan="1">FECHA</td>
        <td colspan="3" align="center"><?php echo fechaactual3(date("Y-m-d")) ?></td>
      </tr>
      <tr>
        <td colspan="3">NIT/CEDULA</td>
        <td colspan="4"><input type="text" 
                               name="nit" 
                               id="nit" 
                               class="campo-sm" 
                               required="required" 
                               data-trigger="hover"
                               data-toggle="popover"
                               data-content="Sin digito de verificación y sin puntos"
                               title="ADVERTENCIA"
                               onBlur="siesta(this.value)"
                               /></td>
        <td colspan="2">EMAIL-1</td>
        <td colspan="5"><input type="email" name="correo" id="correo" class="campo-sm" required="required" /></td>
      </tr>
      <tr>
        <td colspan="3">EMAIL-2</td>
        <td colspan="4"><input type="email" 
                               name="correo2" 
                               id="correo2" 
                               class="campo-sm" 
                               data-trigger="hover"
                               data-toggle="popover"
                               data-content="Correo alterno en caso que se requiera que las ordenes de compra lleguen varios correos"
                               title="ADVERTENCIA"
                               /></td>
        <td colspan="2">EMAIL-3</td>
        <td colspan="5"><input type="email" 
                               name="correo3" 
                               id="correo3" 
                               class="campo-sm" 
                               data-trigger="hover"
                               data-toggle="popover"
                               data-content="Correo alterno en caso que se requiera que las ordenes de compra lleguen varios correos"
                               title="ADVERTENCIA"
                               /></td>
      </tr>
      <tr>
        <td colspan="3">TELÉFONOS</td>
        <td colspan="4"><input type="text" name="telefono" id="telefono" class="campo-sm" required="required" />
        <td colspan="2">DIRECCIÓN</td>
        <td colspan="5"><input type="text" name="direccion" id="direccion" class="campo-sm" /></td>
      </tr>
      <tr>
        <td colspan="3">DEPARTAMENTO</td>
        <td colspan="4">
          <select name="depto" id="depto" class="campo-sm Arial12" onChange="buscamun(this.value)">
            <option value="">Seleccione</option>
            <?php
            do {  
            ?>
              <option value="<?php echo $row_Recordset3['IdDepartamento']?>"><?php echo $row_Recordset3['departamentos']?></option>
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
        <td colspan="2">MUNICIPIO</td>
        <td colspan="5">
          <div id='midiv'>
           <select name="municipio" class="campo-sm Arial12" required="required" >	
             <option value="">Seleccione Municipio</option>
          	</select>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="3">BANCO</td>
        <td colspan="4">
          <select name="banco" class="campo-sm Arial12">
            <option value="">Seleccione el Banco</option>
              <?php
              do {  
              ?>
                <option value="<?php echo $row_Recordset4['IdBanco']?>"><?php echo $row_Recordset4['banco']?></option>
              <?php
              } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
              $rows = mysql_num_rows($Recordset4);
              if($rows > 0) {
                mysql_data_seek($Recordset4, 0);
                $row_Recordset4 = mysql_fetch_assoc($Recordset4);
              }
              ?>
          </select>
        </td>
				<td colspan="2">CLASE DE CUENTA</td>
        <td colspan="5">
          <select name="clasecuenta" class="campo-sm Arial12">
            <option value="">Seleccione</option>
            <option value="1">AHORROS</option>
            <option value="2">CORRIENTE</option>
            <option value="3">DEPOSITO ELECTRONICO</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="3">No de Cuenta</td>
        <td colspan="4"><input type="text" name="cuenta" class="campo-sm Arial12"></td>
      </tr>
    </table>
    <br>
    <strong>DOCUMENTOS (Los documentos deben estar en formato PDF y con un tamaño máximo de 2500 Kb)</strong>
    <table cellspacing="0" cellpadding="0" class="tablita Arial14" border="1">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
			<col width="75">
      <col width="75">
      <col width="75">
      <tr>
        <td colspan="8" align="center"><strong>DOCUMENTOS</strong> </td>
        <td colspan="6" align="center"><strong>ANEXAR </strong> </td>
      </tr>
      <tr>
        <td colspan="8">Fotocopia del RUT</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="rut" id="rut" onChange="validaArchivo(this.files,this.id)" required="required">
        </td>
      </tr>
      <tr>
        <td colspan="8">Certificación Bancaria </td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="certbanc" onChange="validaArchivo(this.files,this.id)" required="required">
        </td>
      </tr>
    </table>
    <br>
    <div class="container" align="center">
      <button type="submit" name="boton11" class="btn btn-rosa" id="boton" >Grabar</button>
      <div class="espera"></div>
    </div> 
  </form> 
</div>
<?php 
include('footer.php')
?>  
   
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
