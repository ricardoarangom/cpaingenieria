<?php 
require_once('../connections/datos.php');
require_once('../funciones.php');

if(($_POST['proced']==24)){
//		echo "<pre>";
//	  print_r($_POST);
//	  echo "</pre>";
	
	$buscaProve="SELECT IdProveedor, proveedor, documento FROM proveedores where documento=".$_POST['nit'];
	$resultadoProve = mysql_query($buscaProve, $datos) or die(mysql_error());
	$row_ResultadoProve = mysql_fetch_assoc($resultadoProve);
	$totalFilasProve = mysql_num_rows($resultadoProve);
		
	if($totalFilasProve>0){
		echo "ya,".$row_ResultadoProve['IdProveedor'].",".$row_ResultadoProve['proveedor'].",".colocapuntos($row_ResultadoProve['documento']);
	}else{
		$graba="INSERT INTO proveedores (proveedor, documento) VALUES('".$_POST['proveedor']."', ".$_POST['nit'].")";
		if ($results=@mysql_query($graba)){
			$last_id = mysql_insert_id($datos);
			 echo "ok,".$last_id.",".$_POST['proveedor'].",".colocapuntos($_POST['nit']);
		}	
	}
			
}

if(($_POST['proced']==29)){
	
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
		<li class="item" onClick="modal('<?php echo $_POST['item'];?>')">NO HAY REGISTROS QUE COINCIDAN (Dar click para crear el proveedor)</li>
		<?php
	}
	
}

if(($_POST['proced']==33)){
	
	$busca="select IdMunicipio, municipio from municipios where IdDepartamento=".$_POST['IdDepartamento'];	
	$resultado = mysql_query($busca, $datos) or die(mysql_error());
	$row_resultado = mysql_fetch_assoc($resultado);

	do{
		$tabla[$row_resultado['IdMunicipio']]=$row_resultado['municipio'];
	}while ($row_resultado = mysql_fetch_assoc($resultado));

	$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);
	
	echo $cadenaTabla;
}

if(($_POST['proced']==34)){
	
	$buscaPro="SELECT IdProveedor,proveedor from proveedores where documento=".$_POST['obj'];
	$resultado = mysql_query($buscaPro, $datos) or die(mysql_error());
	$row_resultado = mysql_fetch_assoc($resultado);
	$totalfilas_resultado = mysql_num_rows($resultado);
	
	if($totalfilas_resultado>0){
		echo 'si;'.$row_resultado['proveedor'].";".$row_resultado['IdProveedor'];
	}else{
		echo 'no';
	}
}

if(($_POST['proced']==35)){

	if($_POST['mod']==1){
		$busca="SELECT IdProveedor, proveedor from proveedores where documento like '%".$_POST['valor']."%'";
	}else{
		$busca="SELECT IdProveedor, proveedor from proveedores where proveedor like '%".$_POST['valor']."%'";
	}
	$resultado = mysql_query($busca, $datos) or die(mysql_error());
	$row_resultado = mysql_fetch_assoc($resultado);
	$totalfilas_resultado = mysql_num_rows($resultado);

	if($totalfilas_resultado>0){
		do{
			$tabla[$row_resultado['IdProveedor']]=$row_resultado['proveedor'];
		} while($row_resultado = mysql_fetch_assoc($resultado));
		$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);
		$conReg='ok';
	}else{
		$conReg='no';
	}

	echo $conReg.";".$cadenaTabla;

}

if(($_POST['proced']==36)){
	
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
		<li class="item" onClick="modal('<?php echo $_POST['item'];?>',this.id)">NO HAY REGISTROS QUE COINCIDAN (Dar click para crear el proveedor)</li>
		<?php
	}
	
}

if(($_POST['proced']==37)){

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

	$edita="UPDATE itemoc SET cantidad=".$_POST['valor']." WHERE IdItem=".$_POST['id'];
	// echo $edita;
	if ($results=@mysql_query($edita)){
		echo "ok";
	}


}
?>





