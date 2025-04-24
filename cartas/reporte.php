<?php require('../connections/datos.php');?>
<?php 
include('encabezado.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if(!$_POST['creador'] and !$_POST['firmante'] and !$_POST['asunto'] and !$_POST['desde'] and !$_POST['hasta'] and !$_POST['destinatario']){
	$buscador1="";
}else{
	$buscador1=" WHERE ";

	
	if($_POST['creador']){
		$buscador.=" usuarios.IdUsuario=".$_POST['creador']." and ";
	}
	if($_POST['firmante']){
		$buscador.=" firmante like '%".$_POST['firmante']."%' and ";
	}
	if($_POST['destinatario']){
		$buscador.=" (destinatario1 like '%".$_POST['destinatario']."%' or destinatario2 like '%".$_POST['destinatario']."%' or destinatario3 like '%".$_POST['destinatario']."%') and ";
	}
	
	if($_POST['asunto']){
		$buscador.=" asunto like '%".$_POST['asunto']."%' and ";
	}
	if($_POST['desde']){
		$buscador.=" fecha>='".$_POST['desde']."' and ";
	}
  
  if($_POST['hasta']){
    $buscador.=" fecha<='".$_POST['hasta']."' and ";
  }

}
$buscador=substr($buscador, 0, -4);
// echo $buscador;

$buscaCartas = "SELECT nombre, apellido, IdCarta, destinatario1, destinatario2, destinatario3, asunto, fecha, firmante, cartas.IdUsuario 
								FROM (cartas LEFT JOIN usuarios ON cartas.IdUsuario = usuarios.IdUsuario) ".$buscador1." ".$buscador."";
// echo $buscaCartas;
$resultadoCartas = mysql_query($buscaCartas, $datos) or die(mysql_error());

$filaCartas = mysql_fetch_assoc($resultadoCartas);
$totalfilas_buscaCartas = mysql_num_rows($resultadoCartas);

$buscaAnexos = "SELECT 
										IdAnexo, IdCarta, nombre, vinculo
								FROM
										anexoscartas  ";
$resultadoAnexos = mysql_query($buscaAnexos, $datos) or die(mysql_error());
$filaAnexos = mysql_fetch_assoc($resultadoAnexos);
$totalfilas_buscaAnexos = mysql_num_rows($resultadoAnexos);
?>
<?php
mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdUsuario, nombre, apellido from usuarios order by nombre, apellido";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

if($totalfilas_buscaCartas>0){
	do{

		$tablacartas[$filaCartas['IdCarta']]['creador']=$filaCartas['nombre']." ".$filaCartas['apellido'];
		$tablacartas[$filaCartas['IdCarta']]['destinatario']=$filaCartas['destinatario1']."<br>".$filaCartas['destinatario2']."<br>".$filaCartas['destinatario3'];
		$tablacartas[$filaCartas['IdCarta']]['firmante']=$filaCartas['firmante'];
		$tablacartas[$filaCartas['IdCarta']]['fecha']=$filaCartas['fecha'];
		$tablacartas[$filaCartas['IdCarta']]['asunto']=$filaCartas['asunto'];


	} while ($filaCartas = mysql_fetch_assoc($resultadoCartas));
}

do{

	if($tablacartas[$filaAnexos['IdCarta']]){
		$tablacartas[$filaAnexos['IdCarta']]['anexos'][$filaAnexos['IdAnexo']]['nombre']=$filaAnexos['nombre'];
		$tablacartas[$filaAnexos['IdCarta']]['anexos'][$filaAnexos['IdAnexo']]['vinculo']=$filaAnexos['vinculo'];
	}

} while ($filaAnexos = mysql_fetch_assoc($resultadoAnexos));

// echo "<pre>";
// print_r($tablacartas);
// echo "</pre>";

?>
<script>
	
	document.addEventListener('DOMContentLoaded', function() {
    
    var resultado = <?php
                    if(isset($_POST['boton'])){
                      echo 1;
                    }else{
                      echo 0;
                    }
                    ?>;
    if(resultado==1){
    	prueba();
    } 
  });

	function prueba(){
        
    var creador ="<?php 
    if($_POST){
      echo $_POST['creador'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('creador').value=creador;
    
    var firmante ="<?php 
    if($_POST){
      echo $_POST['firmante'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('firmante').value=firmante;
       
    var destinatario ="<?php 
    if($_POST){
      echo $_POST['destinatario'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('destinatario').value=destinatario;
             
    var asunto="<?php 
    if($_POST){
      echo $_POST['asunto'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('asunto').value=asunto;
		
		var desde="<?php 
    if($_POST){
      echo $_POST['desde'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('desde').value=desde;
    
    var hasta="<?php 
    if($_POST){
      echo $_POST['hasta'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('hasta').value=hasta;   
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
include('encabezado1.php');	
?>
<div class="contenedor" align="center">
	<h4 align="center" class="Century">CONSULTA DE CARTAS</h4>
	<br>
	<form action="reporte.php" method="post">
		<div class="grid columna-6" style="width: 800px" align="left">					
			<div class="span-1">
				Creador:
			</div>
			<div class="span-2">
				<select name="creador" id="creador" class="campo-xs Arial12">
					<option value="">Seleccione</option>
					<?php
					do {  
						?>
						<option value="<?php echo $row_Recordset4['IdUsuario']?>"><?php echo $row_Recordset4['nombre']." ".$row_Recordset4['apellido']?></option>
						<?php
					} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
					$rows = mysql_num_rows($Recordset4);
					if($rows > 0) {
						mysql_data_seek($Recordset4, 0);
						$row_Recordset4 = mysql_fetch_assoc($Recordset4);
					}
					?>
				</select>
			</div>	
			<div class="span-1">
				Firmante:
			</div>
			<div class="span-2">
				<input type="text" name="firmante" id="firmante" class="campo-xs Arial12">
			</div>			
			<div class="span-1">
				Destinatario:
			</div>
			<div class="span-2">
				<input type="text" name="destinatario" id="destinatario" class="campo-xs Arial12">
			</div>	
			<div class="span-1">
				Asunto:
			</div>
			<div class="span-2">
				<input type="text" name="asunto" id="asunto" class="campo-xs Arial12">
			</div>
			<div class="span-1">
				Desde:
			</div>
			<div class="span-2">
				<input type="date" name="desde" id="desde" class="campo-xs Arial12">
			</div>
			<div class="span-1">
				Hasta:
			</div>
			<div class="span-2">
				<input type="date" name="hasta" id="hasta" class="campo-xs Arial12">
			</div>	

		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 800px">
			<div class="span-6" align="right">
				<button type="submit" name="boton" class="btn btn-verde btn-xs">Buscar</button>
				<button type="reset" class="btn btn-rojo btn-xs pull-left">Limpiar Filtro</button>
			</div>
		</div>
	</form>
</div>
<div class="contenedor" align="center">
<?php 
if(isset($_POST['boton'])){
	?>
	<div class="contenedor" style="width: 1200px">
		<table class="tablita" align="center" border="1" width="100%">
			<!-- <col width="220px">
			<col width="300px">
			<col width="100px">
			<col width="100px">
			<col width="100px">
			<col width="70px"> -->
			<tbody>
				<tr class="Arial14 titulos">
					<td>CREADOR</td>
					<td>FIRMANTE</td>
					<td>DESTINATARIO</td>
					<td>FECHA</td>
          <td>ASUNTO</td>
					<td>ANEXOS</td>
					<td>&nbsp;</td> 
					</tr>
				<?php
					if($tablacartas){
						foreach($tablacartas as $key=>$j){
							?>
							<tr class="Arial12">
								<td valign="top"><?php echo $j['creador']; ?></td>
								<td valign="top"><?php echo $j['firmante']; ?></td>
								<td valign="top"><?php echo $j['destinatario']; ?></td>								
								<td valign="top" align="center"><?php echo $j['fecha']; ?></td>
                <td valign="top"><?php echo $j['asunto']; ?></td>
								<td valign="top">
									<?php
									if($tablacartas[$key]['anexos']){
										foreach($tablacartas[$key]['anexos'] as $llave=>$i){
											echo $i['nombre'];
											?>
											<br>
											<a href="<?php echo $i['vinculo'] ?>" class="btn btn-rosa btn-xs1" target="_blank" >Ver anexo</a>
											<br>
											<?php
										}
									}else{
										echo "SIN ANEXOS";
									}
									?>
								</td>
								<td valign="top" align="center">
									<a href="carta-pdf.php?carta=<?php echo $key?>" class="btn btn-rosa btn-xs1" target="_blank">Ver carta</a>
								</td>   
							</tr>	
							<?php
						}
					}else{
						?>
						<tr>
							<td colspan="7" align="center">NO HAY SOLICITUDES QUE COINCIDAN CON LOS PARAMETROS DE BUSQUEDA</td>
						</tr>
						<?php
					}
					?>        
				</tbody>
			</table>
	</div>	
	<?php
}	
?>

<br><br>
  
</div>

<?php 
	mysql_close($datos);
						 
include('footer.php');
?>


</body>
</html>
<?php

mysql_free_result($Recordset4);

?>
