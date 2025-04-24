<?php require_once('connections/datos.php'); ?>
	<?php 
//echo('<pre>');
//print_r($_GET);
//echo('</pre>');

$datosd=explode(",",$_GET['id']);

//echo('<pre>');
//print_r($datosd);
//echo('</pre>');

$sql="SELECT municipios.IdMunicipio, municipios.municipio FROM municipios WHERE municipios.IdDepartamento=".$datosd[0]." ORDER BY  municipios.municipio";
$res=mysql_query($sql);
		
		/*while ($fila=mysql_fetch_array($res)){
		echo $fila['nombre'];
		}*/
	

if($datosd[1]==1){
  ?>
  Municipio:
  <select name="IdMunicipion" id="IdMunicipion" class="form-control form-control-sm Arial12" required="required" >	
       <option value="">Seleccione el Municipio</option>
    <?php while ($fila=mysql_fetch_array($res)){ ?>
    <option value="<?php echo $fila['IdMunicipio']?>"><?php echo $fila['municipio']?></option>
  <?php }?>
  </select>
  <?php
}
if($datosd[1]==2){
  ?>
  Municipio:
  <select name="IdCiudad" id="IdCiudad" class="form-control form-control-sm Arial12" required="required" >	
       <option value="">Seleccione el Municipio</option>
    <?php while ($fila=mysql_fetch_array($res)){ ?>
    <option value="<?php echo $fila['IdMunicipio']?>"><?php echo $fila['municipio']?></option>
  <?php }?>
  </select>
  <?php
}




