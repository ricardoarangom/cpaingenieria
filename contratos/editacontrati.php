<?php require_once('../connections/datos.php'); ?>
<?php 
$IdContratista=$_GET['id'];
?>
<?php

$buscaContrati = "SELECT 
                      IdContratista,
                      proveedor,
                      IdClasedoc,
                      documento,
                      telefono,
                      direccion,
                      departamento,
                      ciudad,
                      email,
                      replegal,
                      celular,
                      fconstitucion,
                      IdBanco,
                      clasecuenta,
                      cuenta,
                      departamenton,
                      ciudadn
                  FROM
                      contratistas
                  WHERE
                      IdContratista = ".$IdContratista;
$resultadoContrati = mysql_query($buscaContrati, $datos) or die(mysql_error());
$filaContrati = mysql_fetch_assoc($resultadoContrati);
$totalfilas_buscaContrati = mysql_num_rows($resultadoContrati);

$buscaDepto = "	SELECT 
										*
								FROM
										departamentos";
$resultadoDepto = mysql_query($buscaDepto, $datos) or die(mysql_error());
$filaDepto = mysql_fetch_assoc($resultadoDepto);
$totalfilas_buscaDepto = mysql_num_rows($resultadoDepto);

$buscaCDoc = "SELECT 
                  *
              FROM
                  clasedocsi;  ";
$resultadoCDoc = mysql_query($buscaCDoc, $datos) or die(mysql_error());
$filaCDoc = mysql_fetch_assoc($resultadoCDoc);
$totalfilas_buscaCDoc = mysql_num_rows($resultadoCDoc);

?>
<?php
include('encabezado.php')
?>
<script>

</script>
<?php
include('encabezado1.php')
?>
<div class="contenedor" style="width: 1050px">
	<h4 align="center" class="Century">EDICION Y/O CONSULTA DE CONTRATISTAS</h4>
  <br>
  <form action="graba.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="bloquear('boton')">
    <div class="grid columna-6 Arial12">
      <div class="span-3">
        <br><br>
        Contratista:
        <input type="text" name="proveedor" id="proveedor" class="campo-xs Arial12" required="required" value="<?php echo $filaContrati['proveedor'] ?>" onBlur="aMayusculas(this.value,this.id)">
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
        <input type="number" name="nit" id="nit" class="campo-xs Arial12" required="required" value="<?php echo $filaContrati['documento'] ?>">
      </div>
      <div class="span-1">
        <br>
        F. de constitución o de nacimiento:
        <input type="date" name="fconstitucion" id="fconstitucion" class="campo-xs Arial12" value="<?php echo $filaContrati['fconstitucion'] ?>" required="required">
      </div>
      <div class="span-2">
        Departamento (origen):
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
        Municipio (origen):
        <div id='midiv1'>
          <select name="municipion" id="municipion"  class="campo-xs Arial12" required="required" >	
            <option value="">Seleccione</option>
          </select>
        </div>
      </div>		
      <div class="span-2">
        Dirección:
        <input type="text" name="direccion" id="direccion" class="campo-xs" value="<?php echo $filaContrati['direccion'] ?>" required="required">		
      </div>
      <div class="span-1">
        Teléfono:
        <input type="text" name="telefono" id="telefono" class="campo-xs" value="<?php echo $filaContrati['telefono'] ?>" required="required">
      </div>
      
      <div class="span-2">
        Departamento (actual) :
        <select name="depto" id="depto" class="campo-xs Arial12" onChange="buscamun(this.value,this.id)">
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
        Municipio (actual):
        <div id='midiv2'>
          <select name="municipio" id="municipio" class="campo-xs Arial12" required="required" >	
            <option value="0">Seleccione</option>
          </select>
        </div>	
      </div>
    </div>
    <br>    
    <br>
		<input type="hidden" name="IdContratista" value="<?php echo $IdContratista ?>">
		<div class="contaner" align="center">
      <button type="submit" name="boton3" class="btn btn-rosa" id="boton">Grabar</button>
      <div class="espera"></div>
    </div>
  </form>
	<br>		
	
</div>
<?php
include('footer.php')
?>
<script>
  	window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
	}, false);

  document.addEventListener('DOMContentLoaded', () => { 

    var IdClasedoc = <?php echo $filaContrati['IdClasedoc'] ? $filaContrati['IdClasedoc'] :0 ?>;
    var depton = <?php echo $filaContrati['departamenton'] ? $filaContrati['departamenton'] :0 ?>;
    var depto = <?php echo $filaContrati['departamento'] ? $filaContrati['departamento'] :0 ?>;
    var municipio = <?php echo $filaContrati['ciudad'] ? $filaContrati['ciudad'] :0 ?>;
    var municipion = <?php echo $filaContrati['ciudadn'] ? $filaContrati['ciudadn'] :0 ?>;

    document.getElementById('depto').value=depto;
    document.getElementById('depton').value=depton;

    buscamun(depto,'depto');
    buscamun(depton,'depton');


    setTimeout(() => {
        $('#municipio').val(municipio);
        $('#municipion').val(municipion)
      }, "100");

    console.log(municipio)
    
    document.getElementById('IdClasedoc').value=IdClasedoc;
    
		       		
	})

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
	
	function bloquear(id){
		document.getElementById(id).style.display='none'
		$(".espera").html(`
				<center>
					<img src="../imagenes/status.gif" id="status" />
					<br>
				</center>
								`);
		}
</script>

