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
    <select name="IdSubClase" id="IdSubClase" class="campo-sm Arial12" onChange="muestraCampos(this.value)">
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

		$buscaContratista="SELECT IdContratista, proveedor, documento, telefono, CONCAT(direccion, ', ', municipios.municipio, ', ', departamentos.departamentos) AS direccion 
							FROM contratistas 
								INNER JOIN departamentos ON contratistas.departamento = departamentos.IdDepartamento
								INNER JOIN municipios ON contratistas.ciudad = municipios.IdMunicipio
							where documento=".$_POST['nit'];
		$resultadoContratista = mysql_query($buscaContratista, $datos) or die(mysql_error());
		$row_ResultadoContratista = mysql_fetch_assoc($resultadoContratista);
		$totalFilasContratista = mysql_num_rows($resultadoContratista);
		if($totalFilasContratista>0){
			echo "ya,".$row_ResultadoContratista['IdContratista'].",".$row_ResultadoContratista['proveedor'].",".colocapuntos($row_ResultadoContratista['documento']) .",".$row_ResultadoContratista['telefono'].",".$row_ResultadoContratista['direccion'];
		}else{
			$graba="INSERT INTO contratistas (proveedor, documento, IdClasedoc, telefono, direccion, departamento, ciudad, fconstitucion, departamenton, ciudadn, email, replegal, IdClasedocrep, docrep) VALUES('".$_POST['proveedor']."', ".$_POST['nit'].", ".$_POST['IdClasedoc'].", '".$_POST['telefono']."', '".$_POST['direccion']."', ".$_POST['depto'].", ".$_POST['municipio'].", '".$_POST['fconstitucion']."', ".$_POST['depton'].", ".$_POST['municipion'].", '".$_POST['email']."', '".$_POST['replegal']."', ".$_POST['IdClasedocrep'].", '".$_POST['docrep']."')";
			if ($results=@mysql_query($graba)){
				$last_id = mysql_insert_id($datos);
				 echo "ok,".$last_id.",".$_POST['proveedor'].",".colocapuntos($_POST['nit']) .",".$_POST['telefono'].",".$_POST['direccion'];
			}	
		}
				
	}

if(($_POST['proced']==6)){
	
	$buscaContratista="SELECT IdContratista, proveedor, documento, telefono, CONCAT(direccion, ', ', municipios.municipio, ', ', departamentos.departamentos) AS direccion 
						FROM contratistas 
							INNER JOIN departamentos ON contratistas.departamento = departamentos.IdDepartamento
							INNER JOIN municipios ON contratistas.ciudad = municipios.IdMunicipio
						where proveedor like '%".$_POST['valor']."%' order by proveedor";
	$resultadoContratista = mysql_query($buscaContratista, $datos) or die(mysql_error());
  $row_ResultadoContratista = mysql_fetch_assoc($resultadoContratista);
	$totalFilasContratista = mysql_num_rows($resultadoContratista);
	
	if($totalFilasContratista>0){
		do{
			?>
			<li class="item" onClick="llenar(<?php echo $row_ResultadoContratista['IdContratista'] ?>,'<?php echo $row_ResultadoContratista['proveedor'];?>','<?php echo $_POST['item'];?>','<?php echo colocapuntos($row_ResultadoContratista['documento']) ?>','<?php echo $row_ResultadoContratista['telefono'];?>','<?php echo $row_ResultadoContratista['direccion'];?>')"><?php echo $row_ResultadoContratista['proveedor'];?></li>
			<?php		
		} while ($row_ResultadoContratista = mysql_fetch_assoc($resultadoContratista));
	}else{
		?>
		<li class="item" onClick="modal('<?php echo $_POST['item'];?>')">NO HAY REGISTROS QUE COINCIDAN (Dar click para crear el contratista)</li>
		<?php
	}
	
}

if(($_POST['proced']==7)){
	
	$buscaContratista="SELECT IdContratista, proveedor, documento, telefono, CONCAT(direccion, ', ', municipios.municipio, ', ', departamentos.departamentos) AS direccion 
						FROM contratistas 
							INNER JOIN departamentos ON contratistas.departamento = departamentos.IdDepartamento
							INNER JOIN municipios ON contratistas.ciudad = municipios.IdMunicipio
						where documento like '%".$_POST['valor']."%' order by proveedor";
	$resultadoContratista = mysql_query($buscaContratista, $datos) or die(mysql_error());
  $row_ResultadoContratista = mysql_fetch_assoc($resultadoContratista);
	$totalFilasContratista = mysql_num_rows($resultadoContratista);
	
	if($totalFilasContratista>0){
		do{
			?>
			<li class="item" onClick="llenar(<?php echo $row_ResultadoContratista['IdContratista'] ?>,'<?php echo $row_ResultadoContratista['proveedor'];?>','<?php echo $_POST['item'];?>','<?php echo colocapuntos($row_ResultadoContratista['documento']) ?>','<?php echo $row_ResultadoContratista['telefono'];?>','<?php echo $row_ResultadoContratista['direccion'];?>')"><?php echo colocapuntos($row_ResultadoContratista['documento'])." - ".$row_ResultadoContratista['proveedor'];?></li>
			<?php		
		} while ($row_ResultadoContratista = mysql_fetch_assoc($resultadoContratista));
	}else{
		?>
		<li class="item" onClick="modal('<?php echo $_POST['item'];?>')">NO HAY REGISTROS QUE COINCIDAN (Dar click para crear el contratista)</li>
		<?php
	}
	
}

if(($_POST['proced']==8)){
	$IdClaseContrato = (int)$_POST['IdClaseContrato'];
    $IdSubClase = (int)$_POST['IdSubClase'];
    
    $query = "SELECT * FROM borrclausulas 
              WHERE IdClaseContrato = $IdClaseContrato 
              AND IdSubClase = $IdSubClase 
              ORDER BY nnumeral";
    
    $resultado = mysql_query($query, $datos);
    
    if (mysql_num_rows($resultado) > 0) {
        $contador = 0;
        while ($fila = mysql_fetch_assoc($resultado)) {
            $contador++;
            
            echo '<div class="clausula-item" data-original-numeral="'.htmlspecialchars($fila['numeral']).'">
                    <div class="clausula-header">
                        <span class="numeral-display">'.htmlspecialchars($fila['numeral']).'</span>
                        <div class="clausula-actions">
                            <button type="button" class="btn-mini btn-rojo" onclick="eliminarClausula(this)" title="Eliminar cláusula">×</button>
                        </div>
                    </div>
                    <div class="clausula-content">
                        <textarea class="clausula-textarea" 
                                  name="clausula_texto[]"
                                  data-numeral="'.htmlspecialchars($fila['numeral']).'"
                                  data-texto-original="'.htmlspecialchars($fila['clausula']).'"
                                  placeholder="Escriba el contenido de esta cláusula...">'.htmlspecialchars($fila['clausula']).'</textarea>
                        <input type="hidden" name="clausula_numeral[]" value="'.htmlspecialchars($fila['numeral']).'">
                    </div>
                  </div>';
        }
        
        echo '<div class="nueva-clausula-container">
                <button type="button" class="btn-crear-clausula" onclick="crearNuevaClausula()">
                    + Agregar Nueva Cláusula
                </button>
              </div>';
        
    } else {
        echo '<div class="sin-clausulas">
                <div style="text-align: center; padding: 20px; color: #666;">
                    <p><strong>No hay cláusulas definidas para esta clase/subclase de contrato.</strong></p>
                </div>
                <div class="nueva-clausula-container">
                    <button type="button" class="btn-crear-clausula" onclick="crearNuevaClausula()">
                        + Crear Primera Cláusula
                    </button>
                </div>
              </div>';
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