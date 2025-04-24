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
$query_Recordset1 = "SELECT * FROM clasproveedores";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$buscaCDoc = "SELECT 
                  *
              FROM
                  clasedocsi;  ";
$resultadoCDoc = mysql_query($buscaCDoc, $datos) or die(mysql_error());
$filaCDoc = mysql_fetch_assoc($resultadoCDoc);
$totalfilas_buscaCDoc = mysql_num_rows($resultadoCDoc);
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
            // document.location.replace ("regproveedorescomp1.php?id="+codigo)
					}
				}
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

function buscamun(IdDepartamento,id){
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
        if(id=="depto"){
          var fila = '<select name="municipio" class="campo-sm Arial12" required="required" >'+	
                     '<option value="">Seleccione Municipio</option>';
        }
        if(id=="depton"){
          var fila = '<select name="municipion" class="campo-sm Arial12" required="required" >'+	
                     '<option value="">Seleccione Municipio</option>';
        }


        
        Object.keys(arregloTabla).forEach(key => {
          console.log(key,arregloTabla[key] )
          fila=fila+'<option value="'+key+'">'+arregloTabla[key]+'</option>'
        });
        fila=fila+'</select>';
        if(id=="depto"){
           $('#midiv').html(fila);
        }
        if(id=="depton"){
           $('#midiv1').html(fila);
        }
      }
    });
}

	function asignaDocs(id){
		
		document.getElementById('docauto').style.display='none';
    document.getElementById('resacr').style.display='none';
    document.getElementById('fictecnica').style.display='none';
    document.getElementById('cercalidad').style.display='none';
    document.getElementById('cercalibra').style.display='none';
    document.getElementById('licsegur').style.display='none';
    document.getElementById('lislabora').style.display='none';
    document.getElementById('regedu').style.display='none';
    document.getElementById('ficdot').style.display='none';
    document.getElementById('licamb').style.display='none';
    document.getElementById('psev').style.display='none';
    document.getElementById('licfunci').style.display='none';
    document.getElementById('tarpropsi').style.display='none';

    if(id==2 || id==16 || id==18){
      document.getElementById('docauto').style.display='';
    }
    if(id==3 || id==9){
      document.getElementById('resacr').style.display='';
    }
    if(id==5){
      document.getElementById('docauto').style.display='';
      document.getElementById('resacr').style.display='';
    }
    if(id==6){
      document.getElementById('fictecnica').style.display='';
      document.getElementById('cercalidad').style.display='';
    }
    if(id==7){
      document.getElementById('cercalidad').style.display='';
    }
    if(id==8){
      document.getElementById('fictecnica').style.display='';
      document.getElementById('cercalibra').style.display='';
    }
    
    if(id==10 || id==12){
      document.getElementById('docauto').style.display='';
      document.getElementById('licsegur').style.display='';
    }
    if(id==11){
      document.getElementById('lislabora').style.display='';
    }
    
    if(id==13){
      document.getElementById('docauto').style.display='';
      document.getElementById('regedu').style.display='';
    }
    if(id==14 || id==15){
      document.getElementById('docauto').style.display='';
      document.getElementById('licamb').style.display='';
      document.getElementById('psev').style.display='';
    }
    
    if(id==17){
      document.getElementById('docauto').style.display='';
      document.getElementById('psev').style.display='';
    }
    
    if(id==19){
      document.getElementById('licfunci').style.display='';
    }
    if(id==20){
      document.getElementById('tarpropsi').style.display='';
    }
    if(id==21){
      document.getElementById('fictecnica').style.display='';
    }
    if(id==22){
      document.getElementById('ficdot').style.display='';
    }
		
	}
</script>
<?php
include('encabezado1.php')
?> 
<div class="contenedor" style="width: 1050px">
	<h4 align="center" class="Century">REGISTRO DE PROVEEDORES</h4>
  <form action="grabaprov.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="bloquear('boton')">
		<strong>INFORMACION GENERAL</strong>
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
      <col width="75">
      <col width="37">
      <col width="37">
      <col width="75">
      <tr>
        <td colspan="5">NOMBRE O RAZON SOCIAL DE LA ORGANIZACIÓN</td>
        <td colspan="6"><input type="text" name="proveedor" id="proveedor" class="campo-sm" required="required" onblur="aMayusculas(this.value,this.id)" ></td>
        <td colspan="1">FECHA</td>
        <td colspan="3" align="center"><?php echo fechaactual3(date("Y-m-d")) ?></td>
      </tr>
      <tr>
        <td colspan="3">
          CLASE DOCUMENTO
        </td>
        <td colspan="4">
          <select name="IdClasedoc" id="" class="campo-sm" required="required">
            <option value="">Seleccione</option>
            <?php 
            do{
              ?>
              <option value="<?php echo $filaCDoc['IdClasedoc'] ?>"><?php echo $filaCDoc['nombre'] ?></option>
              <?php
            } while ($filaCDoc = mysql_fetch_assoc($resultadoCDoc));
            ?>
          </select>
        </td>
        <td colspan="3">No DOCUMENTO</td>
        <td colspan="5"><input type="text" 
                               name="nit" 
                               id="nit" 
                               class="campo-sm" 
                               required="required" 
                               data-trigger="hover"
                               data-toggle="popover"
                               data-content="Sin digito de verificación sin puntos ni comas"
                               title="ADVERTENCIA"
                               onBlur="siesta(this.value)"
                               ></td>				        
			</tr>
			<tr>
        <td colspan="3">EMAIL-1</td>
        <td colspan="4"><input type="email" name="correo" id="correo" class="campo-sm" required="required"></td>
				<td colspan="3">EMAIL-2</td>
        <td colspan="5"><input type="email" 
                               name="correo2" 
                               id="correo2" 
                               class="campo-sm" 
                               data-trigger="hover"
                               data-toggle="popover"
                               data-content="Correo alterno en caso que se requiera que las ordenes de compra lleguen a varios correos"
                               title="ADVERTENCIA"
                               ></td>							
			</tr>
			<tr>
        <td colspan="3">EMAIL-3</td>
        <td colspan="4"><input type="email" 
                               name="correo3" 
                               id="correo3" 
                               class="campo-sm" 
                               data-trigger="hover"
                               data-toggle="popover"
                               data-content="Correo alterno en caso que se requiera que las ordenes de compra lleguen a varios correos"
                               title="ADVERTENCIA"
                               ></td>
				<td colspan="3">TELÉFONOS</td>
        <td colspan="5"><input type="text" name="telefono" id="telefono" class="campo-sm" required="required"></td>			
			</tr>
      <tr>
				<td colspan="3">DIRECCIÓN</td>
        <td colspan="4"><input type="text" name="direccion" id="direccion" class="campo-sm" required="required"></td>				
        <td colspan="3">DEPARTAMENTO</td>
        <td colspan="5">
          <select name="depto" id="depto" class="campo-sm Arial12" onChange="buscamun(this.value,this.id)">
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
      </tr>
      <tr>
        <td colspan="3">MUNICIPIO</td>
        <td colspan="4">
          <div id='midiv'>
           <select name="municipio" class="campo-sm Arial12" required="required" >	
             <option value="">Seleccione Municipio</option>
          </select>
          </div>
        </td>
        <td colspan="3">CONTACTO</td>
        <td colspan="5"><input type="text" name="contacto" id="contacto" class="campo-sm" required="required" onblur="aMayusculas(this.value,this.id)"></td>        
      </tr>
      <tr>
        <td colspan="3">REPRESENTANTE LEGAL</td>
        <td colspan="4"><input type="text" name="replegal" id="replegal" class="campo-sm" onblur="aMayusculas(this.value,this.id)"></td>
      	<td colspan="3">CELULAR</td>
        <td colspan="5"><input type="tel" name="celular" id="celular" class="campo-sm" required="required"></td>
      </tr>
      <tr>
				<td colspan="3" class="Arial10" >F. DE CONSTITUCIÓN O DE NACIMIENTO</td>
        <td colspan="4"><input type="date" name="fconstitucion" id="fconstitucion" class="campo-sm Arial12" required="required" /></td>
        <td colspan="3">DEPARTAMENTO</td>
        <td colspan="5">
          <select name="depton" id="depton" class="campo-sm Arial12" onChange="buscamun(this.value,this.id)">
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
      </tr>
      <tr>
        <td colspan="3">MUNICIPIO</td>
        <td colspan="4">
          <div id='midiv1'>
            <select name="municipion" class="campo-sm Arial12" required="required" >	
              <option value="">Seleccione Municipio</option>
            </select>
          </div>
        </td>
				
        <td colspan="3">REGIMEN AL CUAL PERTENECE</td>
        <td colspan="5">
          <select class="campo-sm Arial12" name="regimen" required="required">
            <option value=''>Seleccione</option>
            <option value="1">Responsable de IVA (Comun)</option>
            <option value="2">NO Responsable de IVA (Simplificado)</option>
          </select>
				</td>
      </tr>
      <tr>
        <td colspan="3">DECLARANTE DE RENTA</td>
        <td colspan="2" align="center">SI&nbsp;&nbsp;<input type="radio" name="declarante" required="required" value="1" ></td>
        <td colspan="2" align="center">NO&nbsp;&nbsp;<input type="radio" name="declarante" required="required" value="0" ></td>
        <td colspan="3">GRAN CONTRIBUYENTE</td>
        <td colspan="2" align="center">SI&nbsp;&nbsp;&nbsp;<input type="radio" name="contribuyente" required="required" value="1"></td>
        <td colspan="3" align="center">NO&nbsp;&nbsp;&nbsp;<input type="radio" name="contribuyente" required="required" value="0"></td>
			</tr>
			<tr>        
        <td colspan="3">AUTORETENEDOR</td>
        <td colspan="2" align="center">SI&nbsp;&nbsp;&nbsp;<input type="radio" name="autoretenedor" required="required" value="1"></td>
        <td colspan="2" align="center">NO&nbsp;&nbsp;&nbsp;<input type="radio" name="autoretenedor" required="required" value="0"></td>
				<td colspan="3">CLASIFICACION PROVEEDOR</td>
				<td colspan="5">
					<select name="IdSegmento" class="campo-sm Arial12" required="required" onChange="asignaDocs(this.value)">
						<option value="">Seleccione</option>
					  <?php
						do {  
							?>
							<option value="<?php echo $row_Recordset1['IdClasificacion']?>"><?php echo $row_Recordset1['clasificacion']?></option>
							<?php
						} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
						$rows = mysql_num_rows($Recordset1);
						if($rows > 0) {
							mysql_data_seek($Recordset1, 0);
							$row_Recordset1 = mysql_fetch_assoc($Recordset1);
						}
						?>
          </select>
				</td>
			</tr>
      <tr>
        <td colspan="7" >
          <div class="grid columna-3">
            <div class="span-1">Proveedor <input type="checkbox" name="pro" ></div>
            <div class="span-1">Cliente <input type="checkbox" name="cli" ></div>
            <div class="span-1">Empleado <input type="checkbox" name="emp" ></div>
          </div>          
        </td>
      </tr>
    </table>
    <br>
    <strong>INFORMACION BANCARIA</strong>
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
      <col width="75">
      <col width="37">
      <col width="37">
      <col width="75">
      <tr>
        <td colspan="3">BANCO</td>
        <td colspan="4">
          <select name="banco" class="campo-sm Arial12" required="required">
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
        <td colspan="3">CLASE DE CUENTA</td>
        <td colspan="5">
          <select name="clasecuenta" class="campo-sm Arial12" required="required">
            <option value="">Seleccione</option>
            <option value="1">AHORROS</option>
            <option value="2">CORRIENTE</option>
            <option value="3">DEPOSITO ELECTRONICO</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="3">No de Cuenta</td>
        <td colspan="4"><input type="text" name="cuenta" class="campo-sm Arial12" required="required"></td>
        <td colspan="8"></td>
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
        <td colspan="8" align="center"><strong>DOCUMENTOS MINIMOS REQUERIDOS</strong> </td>
        <td colspan="6" align="center"><strong>ANEXAR </strong> </td>
      </tr>
      <tr id="rut">
        <td colspan="8">RUT</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="rut" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="fotced">
        <td colspan="8">Cédula de Ciudadanía de Personas Naturales/Representante Legal.</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="fotced" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="camcom">
        <td colspan="8">Certificado de Cámara de Comercio con Vigencia inferior a 30 días para Entes Jurídicos.</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="camcom" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="fotresfac">
        <td colspan="8">Resolución de Facturación para quien este obligado</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="fotresfac" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="certbanc">
        <td colspan="8">Certificación Bancaria </td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="certbanc" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="docauto" style="display:none">
        <td colspan="8">Documento de autoevaluación del SG SST emitido por la ARL</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="docauto" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="resacr" style="display:none">
        <td colspan="8">Resolución de acreditación NTC-ISO/IEC 17025 vigente.</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="resacr" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="fictecnica" style="display:none">
        <td colspan="8">Ficha tecnica o  de seguridad</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="fictecnica" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="cercalidad" style="display:none">
        <td colspan="8">Certificado de calidad</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="cercalidad" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="cercalibra" style="display:none">
        <td colspan="8">Certificado de calibración</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="cercalibra" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="licsegur" style="display:none">
        <td colspan="8">Licencia de Seguridad y Salud en el Trabajo de la IPS</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="licsegur" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="lislabora" style="display:none">
        <td colspan="8">Listado de Laboratorios Autorizados por el Instituto Nacional de Salud (INS).</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="lislabora" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="regedu" style="display:none">
        <td colspan="8">Registro educativo</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="regedu" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="ficdot" style="display:none">
        <td colspan="8">Fichas técnicas de las dotaciones y EPP.</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="ficdot" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="licamb" style="display:none">
        <td colspan="8">Licencia ambiental de funcionamiento</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="licamb" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="psev" style="display:none">
        <td colspan="8">Plan Estratégico de Seguridad Vial - PESV</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="psev" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="licfunci" style="display:none">
        <td colspan="8">Licencia de funcionamiento vigente</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="licfunci" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
      <tr id="tarpropsi" style="display:none">
        <td colspan="8">Tarjeta profesional en Psicología.</td>
        <td colspan="6">
          <input type="file" class="campo-sm Arial12" name="tarpropsi" onChange="validaArchivo(this.files,this.id)">
        </td>
      </tr>
    </table>
    <br>
    <div class="contaner" align="center">
      <button type="submit" name="boton1" class="btn btn-rosa" id="boton">Grabar</button>
      <div class="espera"></div>
    </div> 
  </form>
</div>
<br>  
<?php 
include('footer.php')	
?>
  
  
</body>
</html>
<?php
mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset1);
?>
