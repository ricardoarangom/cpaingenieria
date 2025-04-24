<?php require_once('connections/datos.php'); ?>
	<?php 
$sql="SELECT municipios.IdMunicipio, municipios.municipio FROM municipios WHERE municipios.IdDepartamento=".$_GET['id']." ORDER BY  municipios.municipio";
$res=mysql_query($sql);
		
		/*while ($fila=mysql_fetch_array($res)){
		echo $fila['nombre'];
		}*/
	?>

<select name="municipio" class="form-control Arial12" required="required" >	
	   <option value="">Seleccione Municipio</option>
	<?php while ($fila=mysql_fetch_array($res)){ ?>
	<option value="<?php echo $fila['IdMunicipio']?>"><?php echo $fila['municipio']?></option>
<?php }?>
</select>



