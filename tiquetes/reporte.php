<?php require('../connections/datos.php');?>
<?php 
include('encabezado.php');

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(!$_POST['proyecto'] and !$_POST['solicitante'] and !$_POST['dsolicitud'] and !$_POST['hsolicitud'] and !$_POST['mpago'] and !$_POST['dcomprado'] and !$_POST['hcomprado']){
	$buscador1="";
}else{
	$buscador1="where ";

	if($_POST['proyecto']){
		$buscador.=" tiquetes.IdArea=".$_POST['proyecto']." and ";
	}
	if($_POST['solicitante']){
		$buscador.=" IdSolicitante=".$_POST['solicitante']." and ";
	}
	if($_POST['dsolicitud']){
		$buscador.=" fecha>='".$_POST['dsolicitud']."' and ";
	}
	if($_POST['hsolicitud']){
		$buscador.=" fecha<='".$_POST['hsolicitud']."' and ";
	}
	
	if($_POST['dcomprado']){
		$buscador.=" fcompra>='".$_POST['dcomprado']."' and ";
	}
	if($_POST['hcomprado']){
		$buscador.=" fcompra<='".$_POST['hcomprado']."' and ";
	}
  
  if($_POST['mpago']){
    $buscador.=" mpago='".$_POST['mpago']."' and ";
  }

}
$buscador=substr($buscador, 0, -4);
//echo $buscador;

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
$query_Recordset1 = "SELECT IdTiquete, IdSolicitante, tiquetes.IdArea, fecha, area, nombre, apellido, fcompra, mpago FROM (tiquetes LEFT JOIN usuarios ON tiquetes.IdSolicitante=usuarios.IdUsuario) INNER JOIN areas ON tiquetes.IdArea=areas.IdArea ".$buscador1.$buscador;

$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
$query_Recordset5 = "select mpago from tiquetes group by mpago";
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$buscaMunicipios="SELECT IdMunicipio, municipio from municipios";
$resultado=mysql_query($buscaMunicipios, $datos);
$fila_Municipio=mysql_fetch_assoc($resultado);

do{
  $tablaMun[$fila_Municipio['IdMunicipio']]=$fila_Municipio['municipio'];
} while ($fila_Municipio=mysql_fetch_assoc($resultado));

$cadenaTabla=json_encode($tablaMun,JSON_UNESCAPED_UNICODE);

if($totalRows_Recordset1>0){
	do{
		$tablatiquetes[$row_Recordset1['IdTiquete']]['IdTiquete']=$row_Recordset1['IdTiquete'];
		$tablatiquetes[$row_Recordset1['IdTiquete']]['solicitante']=$row_Recordset1['nombre']." ".$row_Recordset1['apellido'];
		$tablatiquetes[$row_Recordset1['IdTiquete']]['area']=$row_Recordset1['area'];
		$tablatiquetes[$row_Recordset1['IdTiquete']]['fsolicitud']=$row_Recordset1['fecha'];
		$tablatiquetes[$row_Recordset1['IdTiquete']]['fcompra']=$row_Recordset1['fcompra'];
		$tablatiquetes[$row_Recordset1['IdTiquete']]['mpago']=$row_Recordset1['mpago'];

	}while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
}

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
    
    var mpago="<?php 
    if($_POST){
      echo $_POST['mpago'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('mpago').value=mpago;   
  }
  
  function detalles(id){
    var tabla ='<?php echo $cadenaTabla ?>';
    var arregloMun = JSON.parse(tabla);
    
    var datos = new FormData();
    datos.append("IdTiquete",id);
    datos.append("proced",7);
    
    
  $.ajax({

    url:"ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta){
      var res = respuesta.trim();
    
      var arregloDetalles = res.split(";");
      var trayectos = JSON.parse(arregloDetalles[0]);
      var pasajeros = JSON.parse(arregloDetalles[1]);
      
      var fila = '<table class="tablita Arial12">';
      const keys = Object.keys(pasajeros);
      keys.forEach(key => {
        fila = fila + '<tr><td>'+pasajeros[key]['nombre']+'</td></tr>';
      });
      fila=fila+'</table>';
      
      var fila1 = '<table class="tablita Arial12"><tr><td>Desde</td><td>Hasta</td><td>Fecha</td></tr>';
      const llaves = Object.keys(trayectos);
      llaves.forEach(key => {
        fila1 = fila1 + '<tr><td>'+arregloMun[trayectos[key]['muno']]+'</td><td>'+arregloMun[trayectos[key]['mund']]+'</td><td>'+trayectos[key]['fecha']+'</td></tr>';
      });
      fila1=fila1+'</table>';
      
      
      $('#pasajeros').html(fila);
      $('#trayectos').html(fila1);
    }
  })
    
    
    
    
  $('#detalles').modal({backdrop: 'static', keyboard: false});
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
	<h4 align="center" class="Century">CONSULTA COMPRA DE TIQUETES</h4>
	<br>
	<form action="reporte.php" method="post">
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
						<select name="solicitante" id="solicitante" class="campo-xs Arial12">
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
      <div class="span-2 div-form borde-div-g" style="border-radius: 5px">
        <div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
          <div class="span-2">
						Medio de pago
					</div>
          <div class="span-1">
						<br>
            <select name="mpago" id="mpago" class="campo-xs Arial12">
              <option value="">Seleccione</option>
              <?php 
              do{
                ?>
                <option value="<?php echo $row_Recordset5['mpago'] ?>"><?php echo $row_Recordset5['mpago'] ?></option>
                <?php
              } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
              ?>
            </select>
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
			<col width="220px">
			<col width="300px">
			<col width="100px">
			<col width="100px">
			<col width="100px">
			<col width="70px">
			<tbody>
				<tr class="Arial14 titulos">
					<td>SOLICITANTE</td>
					<td>AREA</td>
					<td>SOLICITADO</td>
					<td>COMPRADO</td>
          <td>M PAGO</td>
					<td>&nbsp;</td> 
					</tr>
				<?php
					if($tablatiquetes){
						foreach($tablatiquetes as $key=>$j){
							?>
							<tr class="Arial12">
								<td valign="top"><?php echo $j['solicitante']; ?></td>
								<td valign="top"><?php echo $j['area']; ?></td>
								<td valign="top" align="center"><?php echo $j['fsolicitud']; ?></td>								
								<td valign="top" align="center"><?php echo $j['fcompra']; ?></td>
                <td valign="top"><?php echo $j['mpago']; ?></td>
								<td valign="top" align="center">
                  <button class="btn btn-rosa btn-xs1" onClick="detalles(<?php echo $j['IdTiquete'] ?>)">Ver detalles</button>   
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


<div id="detalles" class="modal fade" role="dialog" >
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Detalles solicitud de tiquetes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>		
      	<div class="modal-body">
          <h6>Pasajeros:</h6>
				  <div id="pasajeros"></div>
          <br>
          <h6>Trayectos:</h6>
          <div id="trayectos"></div>
      	</div>
      	<div class="modal-footer grid columna-5">
          <div class="span-4"></div>
					<div class="span-1">
						<button type="button" class="btn btn-gris btn-sm btn-block" data-dismiss="modal">Cerrar</button>
					</div>
					
      	</div>
		
    </div>
  </div>
</div>
<?php 
	mysql_close($datos);
						 
include('footer.php');
?>


</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
