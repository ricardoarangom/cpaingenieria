<?php 
require_once('../connections/datos.php');
require_once('../funciones.php');

if(($_POST['proced']==1)){
    $buscaSubClase = "SELECT 
                          *
                      FROM
                          subclasescontrat
                      WHERE
                          IdClase = ".$_POST['IdClaseContrato']."";
    $resultadoSubClase = mysql_query($buscaSubClase, $datos) or die(mysql_error());
    $filaSubClase = mysql_fetch_assoc($resultadoSubClase);
    $totalfilas_buscaSubClase = mysql_num_rows($resultadoSubClase);

    ?>
    Sub Clase de Contrato
    <select name="IdSubClase" id="IdSubClase" class="campo-sm Arial14" >
      <option value="">Seleccione</option>
      <?php 
      do{
        ?>
        <option value="<?php echo $filaSubClase['IdSubClase'] ?>"><?php echo $filaSubClase['subclase'] ?></option>
        <?php
      } while ($filaSubClase = mysql_fetch_assoc($resultadoSubClase))
      ?>
    </select>
    <?php


}

if(($_POST['proced']==2)){
	
	$buscaProve="SELECT IdProveedor, proveedor, documento FROM proveedores where proveedor like '%".$_POST['valor']."%' order by proveedor";
	$resultadoProve = mysql_query($buscaProve, $datos) or die(mysql_error());
  $row_ResultadoProve = mysql_fetch_assoc($resultadoProve);
	$totalFilasProve = mysql_num_rows($resultadoProve);
	
	if($totalFilasProve>0){
		do{
			?>
			<li class="item" onClick="llenar(<?php echo $row_ResultadoProve['IdProveedor'] ?>,'<?php echo $row_ResultadoProve['proveedor'];?>','<?php echo $_POST['item'];?>','<?php echo colocapuntos($row_ResultadoProve['documento']) ?>')"><?php echo $row_ResultadoProve['proveedor'];?></li>
			<?php		
		} while ($row_ResultadoProve = mysql_fetch_assoc($resultadoProve));
	}else{
		?>
		<li class="item" onClick="modal('<?php echo $_POST['item'];?>')">NO HAY REGISTROS QUE COINCIDAN (Dar click para crear el contratista)</li>
		<?php
	}
	
}

if(($_POST['proced']==3)){
	
	$buscaProve="SELECT IdProveedor, proveedor, documento FROM proveedores where documento like '%".$_POST['valor']."%' order by proveedor";
	$resultadoProve = mysql_query($buscaProve, $datos) or die(mysql_error());
  $row_ResultadoProve = mysql_fetch_assoc($resultadoProve);
	$totalFilasProve = mysql_num_rows($resultadoProve);
	
	if($totalFilasProve>0){
		do{
			?>
			<li class="item" onClick="llenar(<?php echo $row_ResultadoProve['IdProveedor'] ?>,'<?php echo $row_ResultadoProve['proveedor'];?>','<?php echo $_POST['item'];?>','<?php echo colocapuntos($row_ResultadoProve['documento']) ?>')"><?php echo colocapuntos($row_ResultadoProve['documento'])." - ".$row_ResultadoProve['proveedor'];?></li>
			<?php		
		} while ($row_ResultadoProve = mysql_fetch_assoc($resultadoProve));
	}else{
		?>
		<li class="item" onClick="modal('<?php echo $_POST['item'];?>')">NO HAY REGISTROS QUE COINCIDAN (Dar click para crear el contratista)</li>
		<?php
	}
	
}

if(($_POST['proced']==4)){
	
	$busca="select IdMunicipio, municipio from municipios where IdDepartamento=".$_POST['IdDepartamento'];	
	$resultado = mysql_query($busca, $datos) or die(mysql_error());
	$row_resultado = mysql_fetch_assoc($resultado);

	do{
		$tabla[$row_resultado['IdMunicipio']]=$row_resultado['municipio'];
	}while ($row_resultado = mysql_fetch_assoc($resultado));

	$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);
	
	echo $cadenaTabla;
}

if(($_POST['proced']==5)){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";

		// exit();

	$buscaProve="SELECT IdProveedor, proveedor, documento FROM proveedores where documento=".$_POST['nit'];
	$resultadoProve = mysql_query($buscaProve, $datos) or die(mysql_error());
	$row_ResultadoProve = mysql_fetch_assoc($resultadoProve);
	$totalFilasProve = mysql_num_rows($resultadoProve);
	if($totalFilasProve>0){
		echo "ya,".$row_ResultadoProve['IdProveedor'].",".$row_ResultadoProve['proveedor'].",".colocapuntos($row_ResultadoProve['documento']);
	}else{
		$graba="INSERT INTO proveedores (proveedor, documento, IdClasedoc, telefono, direccion, departamento, ciudad, fconstitucion, departamenton, ciudadn) VALUES('".$_POST['proveedor']."', ".$_POST['nit'].", ".$_POST['IdClasedoc'].", '".$_POST['telefono']."', '".$_POST['direccion']."', ".$_POST['depto'].", ".$_POST['municipio'].", '".$_POST['fconstitucion']."', ".$_POST['depton'].", ".$_POST['municipion'].")";
		if ($results=@mysql_query($graba)){
			$last_id = mysql_insert_id($datos);
				echo "ok,".$last_id.",".$_POST['proveedor'].",".colocapuntos($_POST['nit']);
		}	
	}
			
}

if(($_POST['proced']==10)){

	if($_POST['mod']==1){
		$busca="SELECT IdContratista, proveedor from contratistas where documento like '%".$_POST['valor']."%'";
	}else{
		$busca="SELECT IdContratista, proveedor from contratistas where proveedor like '%".$_POST['valor']."%'";
	}
	$resultado = mysql_query($busca, $datos) or die(mysql_error());
	$row_resultado = mysql_fetch_assoc($resultado);
	$totalfilas_resultado = mysql_num_rows($resultado);

	if($totalfilas_resultado>0){
		do{
			$tabla[$row_resultado['IdContratista']]=$row_resultado['proveedor'];
		} while($row_resultado = mysql_fetch_assoc($resultado));
		$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);
		$conReg='ok';
	}else{
		$conReg='no';
	}

	echo $conReg.";".$cadenaTabla;
}

if(($_POST['proced']==11)){
    $buscaSubClase = "SELECT 
                          *
                      FROM
                          subclasescontrat
                      WHERE
                          IdClase = ".$_POST['IdClaseContrato']."";
    $resultadoSubClase = mysql_query($buscaSubClase, $datos) or die(mysql_error());
    $filaSubClase = mysql_fetch_assoc($resultadoSubClase);
    $totalfilas_buscaSubClase = mysql_num_rows($resultadoSubClase);

    ?>
    <select name="IdSubClase" id="IdSubClase" class="campo-xs Arial12" >
      <option value="">Seleccione</option>
      <?php 
      do{
        ?>
        <option value="<?php echo $filaSubClase['IdSubClase'] ?>"><?php echo $filaSubClase['subclase'] ?></option>
        <?php
      } while ($filaSubClase = mysql_fetch_assoc($resultadoSubClase))
      ?>
    </select>
    <?php


}