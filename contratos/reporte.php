<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if(!$_POST['proyecto'] and !$_POST['solicitante'] and !$_POST['proveedor'] and !$_POST['dsolicitud'] and !$_POST['hsolicitud'] and !$_POST['drecibido'] and !$_POST['hrecibido'] and !$_POST['dcomprado'] and !$_POST['hcomprado']){
	$buscador1="";
}else{
	$buscador1=" where ";

	if($_POST['proyecto']){
		$buscador.=" ordencompra.IdArea=".$_POST['proyecto']." and ";
	}
	if($_POST['solicitante']){
		$buscador.=" ordencompra.IdSolicitante=".$_POST['solicitante']." and ";
	}
	if($_POST['proveedor']){
		$buscador.=" compras.IdProveedor=".$_POST['proveedor']." and ";
	}
	if($_POST['dsolicitud']){
		$buscador.=" fsolicitud>='".$_POST['dsolicitud']."' and ";
	}
	if($_POST['hsolicitud']){
		$buscador.=" fsolicitud<='".$_POST['hsolicitud']."' and ";
	}
	if($_POST['drecibido']){
		$buscador.=" compras.recibido>='".$_POST['drecibido']."' and ";
	}
	if($_POST['hrecibido']){
		$buscador.=" compras.recibido<='".$_POST['hrecibido']."' and ";
	}
	if($_POST['dcomprado']){
		$buscador.=" ordencompra.comprado>='".$_POST['dcomprado']."' and ";
	}
	if($_POST['hcomprado']){
		$buscador.=" ordencompra.comprado<='".$_POST['hcomprado']."' and ";
	}	

}
$buscador=substr($buscador, 0, -4);
// echo $buscador;
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

mysql_select_db($database_datos, $datos);
$query_Recordset1 = "SELECT compras.IdCompra, compras.IdOrdencompra, fecha, compras.comprado, compras.recibido, proveedor, fsolicitud, nombre, apellido, area, factura, evaluacion, calpro, compras.precio, condpago, cumplimiento, higsegind, gesamb, rse, total FROM ((((compras inner join proveedores ON compras.IdProveedor=proveedores.IdProveedor) inner join ordencompra On compras.IdOrdencompra=ordencompra.IdOrdencompra) inner join usuarios On ordencompra.IdSolicitante=usuarios.IdUsuario) inner join areas on ordencompra.IdArea=areas.IdArea) left join totcompras on compras.IdCompra=totcompras.IdCompra".$buscador1.$buscador;

// echo $query_Recordset1;
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT IdArea, area, ccostos from areas order by ccostos";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$buscaClase = " SELECT 
                    *
                FROM
                    calsecontratos";
$resultadoClase = mysql_query($buscaClase, $datos) or die(mysql_error());
$filaClase = mysql_fetch_assoc($resultadoClase);
$totalfilas_buscaClase = mysql_num_rows($resultadoClase);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT IdUsuario, nombre, apellido from usuarios";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset2 = "select IdContratista, proveedor from contratistas order by proveedor";
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if($totalRows_Recordset1>0){
  do { 
    $tabla[$row_Recordset1['IdCompra']]['sc']=$row_Recordset1['IdOrdencompra'];
		$tabla[$row_Recordset1['IdCompra']]['solicitante']=$row_Recordset1['nombre']." ".$row_Recordset1['apellido'];
		$tabla[$row_Recordset1['IdCompra']]['area']=$row_Recordset1['area'];
		$tabla[$row_Recordset1['IdCompra']]['fsolicitud']=$row_Recordset1['fsolicitud'];
		$tabla[$row_Recordset1['IdCompra']]['comprado']=$row_Recordset1['comprado'];
		$tabla[$row_Recordset1['IdCompra']]['recibido']=$row_Recordset1['recibido'];
		$tabla[$row_Recordset1['IdCompra']]['proveedor']=$row_Recordset1['proveedor'];
		$tabla[$row_Recordset1['IdCompra']]['evaluacion']=$row_Recordset1['evaluacion'];
		$tabla[$row_Recordset1['IdCompra']]['factura']=$row_Recordset1['factura'];

		$tabla[$row_Recordset1['IdCompra']]['calpro']=$row_Recordset1['calpro'];
		$tabla[$row_Recordset1['IdCompra']]['precio']=$row_Recordset1['precio'];
		$tabla[$row_Recordset1['IdCompra']]['condpago']=$row_Recordset1['condpago'];
		$tabla[$row_Recordset1['IdCompra']]['cumplimiento']=$row_Recordset1['cumplimiento'];
		$tabla[$row_Recordset1['IdCompra']]['higsegind']=$row_Recordset1['higsegind'];
		$tabla[$row_Recordset1['IdCompra']]['gesamb']=$row_Recordset1['gesamb'];
		$tabla[$row_Recordset1['IdCompra']]['rse']=$row_Recordset1['rse'];
		$tabla[$row_Recordset1['IdCompra']]['total']=$row_Recordset1['total'];
    
  } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
}

$cadenaTabla=json_encode($tabla,JSON_UNESCAPED_UNICODE);

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
		
		var proveedor ="<?php 
    if($_POST){
      echo $_POST['proveedor'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('proveedor').value=proveedor;
    
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
    
    var drecibido ="<?php 
    if($_POST){
      echo $_POST['drecibido'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('drecibido').value=drecibido;
    
    var hrecibido ="<?php 
    if($_POST){
      echo $_POST['hrecibido'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('hrecibido').value=hrecibido;
     
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

	function buscaSubClase(IdClaseContrato){

    var datos = new FormData();
		datos.append("IdClaseContrato",IdClaseContrato);
		datos.append("proced",11);

    $.ajax({
      url:"ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        // console.log(respuesta)
        $('#midiv').html(respuesta)
        // var res = respuesta.trim();
        // console.log(res)
        // if(res='ok'){
        //   location.reload();
        // }
      }
    });
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
  <h4 align="center" class="Century">CONSULTA DE CONTRATOS</h4>
	<br>
	<form action="reporte.php" method="post">
		<div class="grid columna-6" style="width: 850px" align="left">
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
			<div class="span-1">
				Contratista
			</div>
			<div class="span-2">
				<select name="contratista" id="contratista" class="campo-xs Arial12">
				  <option value="">Seleccione</option>
				  <?php
					do {  
						?>
						<option value="<?php echo $row_Recordset2['IdContratista']?>"><?php echo $row_Recordset2['proveedor']?></option>
						<?php
					} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
					$rows = mysql_num_rows($Recordset2);
					if($rows > 0) {
						mysql_data_seek($Recordset2, 0);
						$row_Recordset2 = mysql_fetch_assoc($Recordset2);
					}
					?>
        </select>
			</div>
			<div class="span-1">
				Clase de contrato
			</div>
			<div class="span-2">
				<select name="IdClase" id="IdClase" class="campo-xs Arial12" onChange="buscaSubClase(this.value)" >
          <option value="">Seleccione</option>
          <?php 
          do{
            ?>
            <option value="<?php echo $filaClase['IdClaseContrato'] ?>"><?php echo  $filaClase['clase']?></option>
            <?php
          }while ($filaClase = mysql_fetch_assoc($resultadoClase));
          ?>
        </select>
			</div>
			<div class="span-1">
				Sub clase de cont.
			</div>
			<div class="span-2" id="midiv">
				<select name="IdSubClase" id="IdSubClase" class="campo-xs Arial12" >
          <option value="">Seleccione</option>
        </select>
			</div>
		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 850px">
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha del Contrato
					</div>
					<div class="span-1">
						Desde:
						<input type="date" name="dfinicio" id="dfinicio" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hfinicio" id="hfinicio" class="campo-xs Arial12">
					</div>
				</div>
			</div>
			<!-- <div class="span-2 div-form borde-div-g" style="border-radius: 5px">
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
			</div> -->
			<!-- <div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div  class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de recibido
					</div>
					<div class="span-1">
						Desde
						<input type="date" name="drecibido" id="drecibido" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta
						<input type="date" name="hrecibido" id="hrecibido" class="campo-xs Arial12">
					</div>							
				</div>
			</div> -->
			
			<div class="span-6" align="right">
				<button type="submit" name="boton" class="btn btn-verde btn-xs">Buscar</button>
				<button type="reset" class="btn btn-rojo btn-xs pull-left">Limpiar Filtro</button>
			</div>
		</div>
	</form>
</div>
<div class="contenedor" align="center">
  <br>
	<?php 
	if(isset($_POST['boton'])){
		?>
	<table border="1" width="1300" class="tablita">
			<col width="30">
			<col width="30">
			<col width="220">
			<col width="300">
			<col width="80">
			<col width="80">
			<col width="80">
			<col width="250">
			<col width="70">
			<col width="80">
      <col width="80">
			<col width="107">
			<tr class="Arial13 titulos">
				<td align="center">OC</td>
				<td align="center">SC</td>
				<td align="center">SOLICITANTE</td>
				<td align="center">AREA</td>
				<td align="center">SOLICITADO</td>
				<td align="center">COMPRADO</td>
				<td align="center">RECIBIDO</td>
				<td align="center">PROVEEDOR</td>
				<td align="center">EVAL</td>
				<td align="center"></td>
        <td align="center"></td>
				<td align="center"></td>
			</tr>
			<?php
			
			?>
			
	</table>
	<?php
	}
	?>
</div>
  <br><br>
    
</div>

<!-- modal -->

<div id="detalleEval" class="modal fade" role="dialog" >
  <div class="modal-dialog" >    
    <div class="modal-content">
			<div class="modal-header" style="background:#d8d8d8; color:black">
            <h5 class="modal-title">Detalle de la evaluación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
			<div class="modal-body">

				<table class="tablita Arial12" border="1" align="center">
					<col width="250px">
					<col width="100px">
					<tr class="titulos">
						<td>Criterio</td>
						<td>Evaluación</td>
					</tr>
					<tr>
						<td>Calidad del Producto o Servicio</td>
						<td id="calpro" align="right"></td>
					</tr>
					<tr>
						<td>Precio</td>
						<td id="precio" align="right"></td>
					</tr>
					<tr>
						<td>Condiciones de pago</td>
						<td id="condpago" align="right"></td>
					</tr>
					<tr>
						<td>Cumplimiento</td>
						<td id="cumplimiento" align="right"></td>
					</tr>
					<tr>
						<td>Aspectos Higiene y Seguridad Industrial</td>
						<td id="higsegind" align="right"></td>
					</tr>
					<tr>
						<td>Aspectos de Gestión ambiental</td>
						<td id="gesamb" align="right"></td>
					</tr>
					<tr>
						<td>Aspectos de RSE</td>
						<td id="rse" align="right"></td>
					</tr>
					<tr>
						<td><strong>Total</strong></td>
						<td id="evaluacion" align="right"></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<?php 
	mysql_close($datos);
include('footer.php')
?>




</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset2);
?>
