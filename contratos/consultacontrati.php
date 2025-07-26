<?php require_once('../connections/datos.php'); ?>
<?php 
$IdContratista=$_GET['id'];
?>
<?php

$buscaContrati = "SELECT 
                    IdContratista,
                    proveedor,
                    clasedocsi.codigo,
                    documento,
                    telefono,
                    direccion,
                    departamentos.departamentos as departamento,
                    municipios.municipio as ciudad,
                    email,
                    replegal,
                    celular,
                    fconstitucion,
                    IdBanco,
                    clasecuenta,
                    cuenta,
                    departamentos_1.departamentos as departamenton,
                    municipios_1.municipio as ciudadn
                  FROM
                    (((((contratistas left join clasedocsi on contratistas.IdClasedoc=clasedocsi.IdClasedoc)
                    left join departamentos on contratistas.departamento=departamentos.IdDepartamento)
                    left join municipios on contratistas.ciudad=municipios.IdMunicipio)
                    left join departamentos as departamentos_1 on contratistas.departamenton=departamentos_1.IdDepartamento)
                    left join municipios as municipios_1 on contratistas.ciudadn=municipios_1.IdMunicipio)
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
<div class="contenedor" style="width: 800px">
	<h4 align="center" class="Century">EDICION Y/O CONSULTA DE CONTRATISTAS</h4>
    <div class="grid columna-6 Arial14">
      <div class="span-3">
        <br>
        Contratista:
        <div><strong><?php echo $filaContrati['proveedor'] ?></strong></div>
      </div>
      <div class="span-1">
        <br>
        Clase documento:
        <div><strong><?php echo $filaContrati['codigo'] ?></strong></div>
      </div>
      <div class="span-1">
        <br>
        No. Documento:
        <div><strong>
          <?php
          if($filaContrati['codigo']=='NIT'){
            echo nitcompleto(colocapuntos($filaContrati['documento']));
          }else{
            echo colocapuntos($filaContrati['documento']);
          }          
          ?>
          </strong></div>					
      </div>
      <div class="span-1">
        F. de constitución o de nacimiento:
        <div><strong><?php echo fechaactual3($filaContrati['fconstitucion']) ?></strong></div>
      </div>
      <div class="span-2">
        Departamento (origen):
        <div><strong><?php echo $filaContrati['departamenton'] ?></strong></div>
      </div>
      <div class="span-2">
        Municipio (origen):
        <div><strong><?php echo $filaContrati['ciudadn'] ?></strong></div>
      </div>		
      <div class="span-2">
        Dirección:
        <div><strong><?php echo $filaContrati['direccion'] ?></strong></div>
      </div>
      <div class="span-1">
        Teléfono:
        <div><strong><?php echo $filaContrati['telefono'] ?></strong></div>
      </div>      
      <div class="span-2">
        Departamento (actual) :
        <div><strong><?php echo $filaContrati['departamento'] ?></strong></div>	
      </div>
      <div class="span-2">
        Municipio (actual):
        <div><strong><?php echo $filaContrati['ciudad'] ?></strong></div>	
      </div>
    </div>
    <br>    
    <br>
	<br>		
	
</div>
<?php
include('footer.php')
?>
