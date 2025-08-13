<?php 
require_once('../connections/datos.php');
include('encabezado.php');

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

<script>

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
          if(id=="deptoe"){
						var fila = '<select name="municipioe" id="municipioe" class="campo-xs Arial12" >'+	
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
          if(id=="deptoe"){
						$('#midiv0').html(fila);
					}
				}
			});
	}

</script>
<style>
  .div-form{
		padding-top: 4px;
		padding-bottom: 4px;
		padding-left: 10px;
		padding-right: 10px;
	}	
</style>
<?php 
include('encabezado1.php')
?>
<br>
<h5 align="center" class="Century" >INGRESO DE NUEVOS CONTRATISTAS</h5>
<div class="contenedor borde-div-g div-form" style="max-width:950px;border-radius: 5px">
  <form method="post" id="formulario" name="formulario" action="graba.php">
    <div class="grid columna-6 Arial12">
      <div class="span-3">
        <br><br>
        Contratista:
        <input type="text" name="proveedor" id="proveedor" class="campo-xs Arial12" required="required" value="" onBlur="aMayusculas(this.value,this.id)">
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
          $rows = mysql_num_rows($resultadoCDoc);
          if ($rows > 0) {
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
        <br>
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
      <div class="span-1">
        <br>
        Municipio (origen):
        <div id='midiv1'>
          <select name="municipion" id="municipion"  class="campo-xs Arial12" required="required" >	
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
        Teléfono:
        <input type="text" name="telefono" id="telefono" class="campo-xs" required="required">
      </div>
      <div class="span-2">
        E-mail:
        <input type="text" name="email" id="email" class="campo-xs" required="required">
      </div>
      <div class="span-1">
        Departamento (actual):
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
      <div class="span-1">
        Municipio (actual):
        <div id='midiv2'>
          <select name="municipio" id="municipio" class="campo-xs Arial12" required="required" >	
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
        <select name="IdClasedocrep" id="IdClasedocrep" class="campo-xs Arial12">
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
    <br>
    <div align="center">
      <button type="submit" name="boton2" class="btn btn-verde btn-sm" >Grabar</button>
    </div>
  </form> 
</div>
  
    
      
        
        
      
    

<?php 
include('footer.php')
?> 
</body>
</html>