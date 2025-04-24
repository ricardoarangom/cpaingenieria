<?php require('../connections/datos.php');?>
<?php 
include('encabezado.php');

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(!$_POST['proyecto'] and !$_POST['solicitante'] and !$_POST['dsolicitud'] and !$_POST['hsolicitud'] and !$_POST['dcotizado'] and !$_POST['hcotizado'] and !$_POST['dcomprado'] and !$_POST['hcomprado']){
	$buscador1="";
}else{
	$buscador1="where ";

	if($_POST['proyecto']){
		$buscador.=" ordencompra.IdArea=".$_POST['proyecto']." and ";
	}
	if($_POST['solicitante']){
		$buscador.=" IdSolicitante=".$_POST['solicitante']." and ";
	}
	if($_POST['dsolicitud']){
		$buscador.=" fsolicitud>='".$_POST['dsolicitud']."' and ";
	}
	if($_POST['hsolicitud']){
		$buscador.=" fsolicitud<='".$_POST['hsolicitud']."' and ";
	}
	if($_POST['dcotizado']){
		$buscador.=" fcierre>='".$_POST['dcotizado']."' and ";
	}
	if($_POST['hcotizado']){
		$buscador.=" fcierre<='".$_POST['hcotizado']."' and ";
	}
	if($_POST['dcomprado']){
		$buscador.=" ordencompra.comprado>='".$_POST['dcomprado']."' and ";
	}
	if($_POST['hcomprado']){
		$buscador.=" ordencompra.comprado<='".$_POST['hcomprado']."' and ";
	}	

}
$buscador=substr($buscador, 0, -4);

?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>

<?php
mysql_select_db($database_datos, $datos);
$query_Recordset1 = "SELECT ordencompra.IdOrdencompra, IdSolicitante, ordencompra.IdArea, fsolicitud, area, nombre, apellido, cotizado, autorizado, itemoc.comprado, recibido, count(IdItem) as cantItem FROM ((ordencompra INNER JOIN itemoc ON ordencompra.IdOrdencompra=itemoc.IdOrdencompra) INNER JOIN usuarios ON ordencompra.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON ordencompra.IdArea=areas.IdArea ".$buscador1.$buscador." GROUP BY ordencompra.IdOrdencompra";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "%";
if (isset($usuario)) {
  $var1_Recordset2 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("select cotizaciones.IdOrdencompra from cotizaciones left join ordencompra on cotizaciones.IdOrdencompra=ordencompra.IdOrdencompra where CAST(IdSolicitante AS CHAR) like %s group by IdOrdencompra", GetSQLValueString($var1_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT IdArea, area, ccostos from areas order by ccostos";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdUsuario, nombre, apellido from usuarios";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset5 = "select  IdOrdencompra, autorizado, derogada, comprado, case when autorizado is not null and derogada=0 then 'AUTORIZADO' when autorizado is null and derogada=0 then 'POR AUTORIZAR' when autorizado is not null and derogada=1 then 'RECHAZADA' end as estado, count(IdItem) as cantidad from itemoc GROUP BY IdOrdencompra, estado";
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

if($totalRows_Recordset1>0){
	do{
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['IdOrdencompra']=$row_Recordset1['IdOrdencompra'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['solicitante']=$row_Recordset1['nombre']." ".$row_Recordset1['apellido'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['area']=$row_Recordset1['area'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['fsolicitud']=$row_Recordset1['fsolicitud'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['cotizado']=$row_Recordset1['cotizado'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['autorizado']=$row_Recordset1['autorizado'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['comprado']=$row_Recordset1['comprado'];
		$tablaOrdenes[$row_Recordset1['IdOrdencompra']]['concoti']='no';
    $tablaOrdenes[$row_Recordset1['IdOrdencompra']]['cantItem']=$row_Recordset1['cantItem'];

	}while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
}

if($tablaOrdenes){
	if($totalRows_Recordset2>0){
		do{
			if($tablaOrdenes[$row_Recordset2['IdOrdencompra']]){
				$tablaOrdenes[$row_Recordset2['IdOrdencompra']]['concoti']='si';
			}
			
		}while($row_Recordset2 = mysql_fetch_assoc($Recordset2));
	}
}

do{
  
  if($tablaOrdenes[$row_Recordset5['IdOrdencompra']]){
    // echo $row_Recordset5['IdOrdencompra']." ".$row_Recordset5['estado']." ".$row_Recordset5['cantidad']." ".$row_Recordset5['comprado']."<br>";
    if($row_Recordset5['estado']=='AUTORIZADO'){
      $tablaOrdenes[$row_Recordset5['IdOrdencompra']]['autorizada']=$row_Recordset5['cantidad'];
      if($row_Recordset5['comprado']){
        
      }else{
        // echo $row_Recordset5['comprado']."<br>";
        $tablaOrdenes[$row_Recordset5['IdOrdencompra']]['comprado']=$row_Recordset5['comprado'];
      }
    }
    if($row_Recordset5['estado']=='RECHAZADA'){
      $tablaOrdenes[$row_Recordset5['IdOrdencompra']]['rechazada']=$row_Recordset5['cantidad'];
    }
    if($row_Recordset5['estado']=='POR AUTORIZAR'){
      $tablaOrdenes[$row_Recordset5['IdOrdencompra']]['espera']=$row_Recordset5['cantidad'];
    }
  }
  
}while($row_Recordset5 = mysql_fetch_assoc($Recordset5));


//echo "<pre>";
//print_r($tablaOrdenes);
//echo "</pre>";

//echo "<pre>";
//print_r($tabla);
//echo "</pre>";
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
    var proyecto ="<?php 
    if($_POST){
      echo $_POST['proyecto'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('proyecto').value=proyecto;
    
    var solicitante ="<?php 
    if($_POST){
      echo $_POST['solicitante'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('solicitante').value=solicitante;
    
    var dsolicitud ="<?php 
    if($_POST){
      echo $_POST['dsolicitud'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('dsolicitud').value=dsolicitud;
       
    var hsolicitud ="<?php 
    if($_POST){
      echo $_POST['hsolicitud'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('hsolicitud').value=hsolicitud;
    
    var dcotizado ="<?php 
    if($_POST){
      echo $_POST['dcotizado'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('dcotizado').value=dcotizado;
    
    var hcotizado ="<?php 
    if($_POST){
      echo $_POST['hcotizado'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('hcotizado').value=hcotizado;
     
    var dcomprado="<?php 
    if($_POST){
      echo $_POST['dcomprado'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('dcomprado').value=dcomprado;
		
		var hcomprado="<?php 
    if($_POST){
      echo $_POST['hcomprado'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('hcomprado').value=hcomprado;
        
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
	<h4 align="center" class="Century">CONSULTA SOLICITUDES DE COMPRA</h4>
	<br>
	<form action="estcotoc1.php" method="post">
		<div class="grid columna-6" style="width: 800px" align="left">
			<div class="span-1">
				Proyecto/Area
			</div>
			<div class="span-2">
				<select name="proyecto" id="proyecto" class="campo-xs Arial12" >
					<option value="">Seleccione</option>
					<?php
					do {  
						?>
						<option value="<?php echo $row_Recordset3['IdArea']?>"><?php echo $row_Recordset3['ccostos']?> - <?php echo $row_Recordset3['area']?></option>
													<?php
					} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
					$rows = mysql_num_rows($Recordset3);
					if($rows > 0) {
						mysql_data_seek($Recordset3, 0);
						$row_Recordset3 = mysql_fetch_assoc($Recordset3);
					}
					?>							
				</select>
			</div>
			
				<?php 
				if($nivel==2){
					?>
					<div class="span-1">
						<input type="hidden" name="solicitante" id="solicitante" value="<?php echo $usuario ?>" >
					</div>	
					<?php
				}else{
					?>
					<div class="span-1">
						Solicitante:
					</div>
					<div class="span-2">
						<select name="solicitante" id="solicitante"  class="campo-xs Arial12">
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
					<?php
				}
				?>
				
				
		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 800px">
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de solicitud
					</div>
					<div class="span-1">
						Desde:
						<input type="date" name="dsolicitud" id="dsolicitud" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hsolicitud" id="hsolicitud" class="campo-xs Arial12">
					</div>
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha Cierre Cotizaciones
					</div>
					<div class="span-1">
						Desde
						<input type="date" name="dcotizado" id="dcotizado" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta
						<input type="date" name="hcotizado" id="hcotizado" class="campo-xs Arial12">
					</div>							
				</div>
			</div>
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de Compra
					</div>
					<div class="span-1">
						Desde
						<input type="date" name="dcomprado" id="dcomprado" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta
						<input type="date" name="hcomprado" id="hcomprado" class="campo-xs Arial12">
					</div>
				</div>
			</div>
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
		<table class="tablita" align="center" border="1">
			<col width="30px">
			<col width="220px">
			<col width="300px">
			<col width="100px">
			<col width="100px">
			<col width="100px">
			<col width="70px">
      <col width="100px">
			<tbody>
				<tr class="Arial14 titulos">
					<td width="30">No SC</td>
					<td>SOLICITANTE</td>
					<td>AREA</td>
					<td>SOLICITADO</td>
					<td>COTIZADO</td>
					<td>COMPRADO</td>
					<td>&nbsp;</td>
          <td>ESTADO</td>
				</tr>
				<?php
					if($tablaOrdenes){
						foreach($tablaOrdenes as $key=>$j){
							?>
							<tr class="Arial12">
								<td align="right" valign="top"><?php echo $j['IdOrdencompra']; ?></td>
								<td valign="top"><?php echo $j['solicitante']; ?></td>
								<td valign="top"><?php echo $j['area']; ?></td>
								<td align="center" valign="top"><?php echo $j['fsolicitud']; ?></td>
								<td align="center" valign="top"><?php echo $j['cotizado']; ?></td>
								<td align="center" valign="top">
                  <?php
                  if($j['cantItem']==$j['rechazada']){
                    
                  }else{
                    echo $j['comprado'];
                  }                   
                  ?>
                </td>
								<td align="center" valign="top"><a href="consulsc.php?oc=<?php echo $j['IdOrdencompra'] ?>" target="_blank" class="btn btn-rosa btn-xs1">Ver Solicitud</a></td>
                <td valign="top">
                  <?php 
                  if($j['cantItem']==$j['autorizada']){
                    echo "AUTORIZADA";
                  }
                  if($j['cantItem']==$j['rechazada']){
                    echo "RECHAZADA";
                  }
                  if($j['cantItem']==$j['espera']){
                    echo "EN ESPERA";
                  }
                  if($j['autorizada'] and $j['rechazada']){
                    echo "AUTORIZADA PARCIALMENTE";
                  }
                  ?>
                </td>
				</tr>
              
							<?php
						}
            ?>
            <tr>
              <td align="right" colspan="8" style="border-bottom-color: #ffffff;border-left-color: #ffffff;border-right-color: #FFFFFF">
                <form action="estcotoc1-ex.php" method="post" target="_blank">
                  <input type="hidden" name="tabla" value="<?php echo  base64_encode(serialize($tablaOrdenes)); ?>">
                  <button type="submit" class="btn btn-verde btn-xs1">Generar Excel</button>            
                </form>
              </td>
            </tr>
            <?php
					}else{
						?>
						<tr>
							<td colspan="7" align="center">NO HAY SOLICITUDES QUE COINCIDAN CON LOS PARAMETRO DE BUSQUEDA</td>
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
