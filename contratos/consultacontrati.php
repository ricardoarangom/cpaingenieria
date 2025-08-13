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
                      departamentos.departamentos AS departamento,
                      municipios.municipio AS ciudad,
                      email,
                      celular,
                      fconstitucion,
                      IdBanco,
                      clasecuenta,
                      cuenta,
                      departamentos_1.departamentos AS departamenton,
                      municipios_1.municipio AS ciudadn,
                      replegal,
                      IdClasedocrep,
                      docrep,
                      municipios_2.municipio AS ciudade,
                      munexp,
                      clasedocsi_1.codigo as codigoRep
                  FROM
                      (((((((contratistas
                      LEFT JOIN clasedocsi ON contratistas.IdClasedoc = clasedocsi.IdClasedoc)
                      LEFT JOIN departamentos ON contratistas.departamento = departamentos.IdDepartamento)
                      LEFT JOIN municipios ON contratistas.ciudad = municipios.IdMunicipio)
                      LEFT JOIN departamentos AS departamentos_1 ON contratistas.departamenton = departamentos_1.IdDepartamento)
                      LEFT JOIN municipios AS municipios_1 ON contratistas.ciudadn = municipios_1.IdMunicipio)
                      LEFT JOIN municipios AS municipios_2 ON contratistas.munexp = municipios_2.IdMunicipio)
                      LEFT JOIN clasedocsi as clasedocsi_1  ON contratistas.IdClasedocrep = clasedocsi_1.IdClasedoc)
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

</script>,
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
<h5 align="center" class="Century">CONSULTA DE CONTRATISTAS</h5>
<div class="contenedor borde-div-g div-form" style="max-width:950px;border-radius: 5px">
	
    <div class="grid columna-6 Arial14">
      <div class="span-3">
        Contratista:
        <div><strong><?php echo $filaContrati['proveedor'] ?></strong></div>
      </div>
      <div class="span-1">
        Clase documento:
        <div><strong><?php echo $filaContrati['codigo'] ?></strong></div>
      </div>
      <div class="span-1">
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
        Expedida en:
        <div><strong><?php echo $filaContrati['ciudade'] ?></strong></div>
      </div>
      <div class="span-1">
        F. de constitución o de nacimiento:
        <div><strong><?php echo fechaactual3($filaContrati['fconstitucion']) ?></strong></div>
      </div>
      <div class="span-1">
        <br>
        Departamento (origen):
        <div><strong><?php echo $filaContrati['departamenton'] ?></strong></div>
      </div>
      <div class="span-1">
        <br>
        Municipio (origen):
        <div><strong><?php echo $filaContrati['ciudadn'] ?></strong></div>
      </div>		
      <div class="span-2">
        <br>
        Dirección:
        <div><strong><?php echo $filaContrati['direccion'] ?></strong></div>
      </div>
      <div class="span-1">
        <br>
        Teléfono:
        <div><strong><?php echo $filaContrati['telefono'] ?></strong></div>
      </div>
      <div class="span-2">
        E-mail:
        <div><strong><?php echo $filaContrati['email'] ?></strong></div>
      </div>      
      <div class="span-1">
        Departamento (actual):
        <div><strong><?php echo $filaContrati['departamento'] ?></strong></div>	
      </div>
      <div class="span-1">
        Municipio (actual):
        <div><strong><?php echo $filaContrati['ciudad'] ?></strong></div>	
      </div>
      <div class="span-3">
        Representante Legal:
        <div><strong><?php echo $filaContrati['replegal'] ?></strong></div>
      </div>
      <div class="span-1">
        Clase documento:
        <div><strong><?php echo $filaContrati['codigoRep'] ?></strong></div>
      </div>
      <div class="span-1">
        No. Documento:
        <div><strong><?php echo colocapuntos($filaContrati['docrep']) ?></strong></div>
      </div>
    </div>
    <br>    
    <br>
	<br>		
	
</div>
<?php
include('footer.php')
?>
