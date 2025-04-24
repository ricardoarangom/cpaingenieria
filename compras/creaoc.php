<?php require_once('../connections/datos.php'); ?>
<?php 
$minrequ=(strtotime ( '+'.(4).' day' , strtotime ( date("Y-m-d")  )));
$minrequ=date("Y-m-d",$minrequ);

session_start();
$usuario=$_SESSION['IdUsuario'];

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

$var1_Recordset1 = "0";
if (isset($usuario)) {
  $var1_Recordset1 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT IdUsuario, nombre, apellido FROM usuarios WHERE IdUsuario=%s", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_Recordset2 = "-1";
if (isset($usuario)) {
  $var1_Recordset2 = $usuario;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT area, IdArea FROM areas WHERE IdDirector=%s UNION ALL SELECT area, IdArea FROM areas WHERE IdSubdirector=%s ORDER BY area", GetSQLValueString($var1_Recordset2, "int"),GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT area, IdArea, ccostos FROM areas WHERE IdArea<>0 ORDER BY ccostos";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_datos, $datos);
$query_Recordset3 = "SELECT * FROM clasesisc";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

include('encabezado.php');
?>
<script type="text/javascript" language="JavaScript" src="../js/ajax.js"></script>
<script language="JavaScript" type="text/javascript">
 function agregarFila(){
  var a=parseFloat(document.getElementById('nf').innerHTML);
  a=a+1;
  
  var fila1 ='<td align="center" class="item">'+a+'</td>';
  var fila2 ='<td><textarea rows="1" cols="7" name="producto['+a+']" class="txtarea Arial12 producto" required="required" ></textarea></td>';
  var fila3 ='<td><input type="text" class="campo-sm Arial12 unidad" name="unidad['+a+']" required="required" /></td>';
  var fila4 ='<td><input type="number" class="campo-sm Arial12 cantidad" name="cantidad['+a+']" required="required" step="0.01"  /></td>';
	 
	var fila5 ='<td>'+
							'<select name="clase['+a+']" id="" class="campo-sm Arial12 clase" required="required">'+
							  '<option value="">Seleccione</option>'+
							  <?php
									do {  
										?>
										'<option value="<?php echo $row_Recordset3['IdClase']?>"><?php echo $row_Recordset3['clase']?></option>'+
										<?php
									} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
									$rows = mysql_num_rows($Recordset3);
									if($rows > 0) {
										mysql_data_seek($Recordset3, 0);
										$row_Recordset3 = mysql_fetch_assoc($Recordset3);
									}
									?>
              '</select>'+
						'</td>'; 
	 
  var fila6 ='<td><input type="date" class="campo-sm Arial12 requi" name="requi['+a+']" required="required" min="<?php echo $minrequ ?>"/></td>';
  var fila7 ='<td align="center"><textarea rows="1" cols="5" name="observa['+a+']" class="txtarea Arial12 observa" ></textarea></td>';
  var fila8 ='<td align="center"><input type="radio" name="ps['+a+']" class="Arial12 ps" value="1" checked></td>';
  var fila9 ='<td align="center"><input type="radio" name="ps['+a+']" class="Arial12 ps1" value="0"><input type="hidden" class="id" name="id['+a+']" value="'+a+'"></td>';
	var fila10 ='<td align="center"><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteRow(this)"></td>';
   
  var filacom=fila1+fila2+fila3+fila4+fila5+fila6+fila7+fila8+fila9+fila10;     
  
  document.getElementById("productos").insertRow(-1).innerHTML = filacom;
  document.getElementById('nf').innerHTML=a;
} 

function deleteRow(btn) { 
	var row = btn.parentNode.parentNode; 
	row.parentNode.removeChild(row);

	var a=parseFloat(document.getElementById('nf').innerHTML);
	a=a-1;
	document.getElementById('nf').innerHTML=a;

	recuento()
}
  
function bloquear(id){
  document.getElementById(id).style.display='none'
  $(".espera").html(`
  		<center>
        <img src="../imagenes/status.gif" id="status" />
        <br>
      </center>
							`);
} 
	
function recuento(){

  var item = document.querySelectorAll('.item');
  var producto = document.querySelectorAll('.producto');
  var unidad = document.querySelectorAll('.unidad');
  var cantidad = document.querySelectorAll('.cantidad');
  var requi = document.querySelectorAll('.requi');
  var observa = document.querySelectorAll('.observa');
  var ps = document.querySelectorAll('.ps');
  var ps1 = document.querySelectorAll('.ps1');
  var id = document.querySelectorAll('.id');

  for(var i=0;i<id.length;i++){
    producto[i].setAttribute("name", 'producto['+(i+1)+"]");
    unidad[i].setAttribute("name", 'unidad['+(i+1)+"]");
    cantidad[i].setAttribute("name", 'cantidad['+(i+1)+"]");
		
		requi[i].setAttribute("name", 'requi['+(i+1)+"]");
    observa[i].setAttribute("name", 'observa['+(i+1)+"]");
    ps[i].setAttribute("name", 'ps['+(i+1)+"]");
		ps1[i].setAttribute("name", 'ps['+(i+1)+"]");
		
		
    id[i].setAttribute("name", 'id['+(i+1)+"]");
    id[i].value=i+1;
		item[i].innerHTML=i+1;
		
		
  }

}

</script>
<style>
	.titulos {
		background: #84BE3F;
		color: #000000;
		text-align: center;
		border-bottom-color: #ffffff;
		border-top-color: #ffffff;
		border-right-color: #ffffff;
		border-left-color: #ffffff;
	}
	
	
	.check{
		position: relative;
		width:40px;
		
	}

	.check:before{
		content:'';
		position:absolute;
		width:40px;
		height:20px;
		background:#00a1ff;
		border-radius: 20px;
	}

	.check:after{
		content:'';
		position:absolute;
		width:20px;
		height:20px;
		background:#fff;
		border-radius:20px;
		transition:0.25s;
		border: 2px solid #00a1ff;
		box-sizing:border-box;
	}

	.check:checked:after{
		left:20px;
		border:2px solid #F00;
	}

	.check:checked:before{
		background: #F00;
	}
</style>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="contenedor" align="center" style="width: 1200px">
  <?php 
  include('encabsolcomp.html');
  ?>
  <br><br>
</div>
<div class="contenedor" style="width: 1200px;">
	<form method="post" action="graba.php" name="form1" onSubmit="bloquear('boton')" >
		<div class="grid columna-16">
			<div class="span-3 Century18">
				PROYECTO/AREA 
			</div>
			<div class="span-3">
				<select name="area" id="area" class="campo-sm Arial14" style="font-weight:bold" required>
					<option value="">Seleccione</option>
					<?php
					do {  
						?>
						<option value="<?php echo $row_Recordset4['IdArea']?>"><?php echo $row_Recordset4['ccostos']?> - <?php echo $row_Recordset4['area']?></option>
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
			<div class="span-3 Century18" align="center" >
				FECHA DE SOLICITUD
			</div>
			<div class="span-2">
				<strong><?php echo fechaactual3(date("Y-m-d")) ?></strong>
			</div>
			<div class="span-2 Century18" align="right">
				SOLICITANTE
			</div>
			<div class="span-3" align="right">
				<strong><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido'] ?></strong>
			</div>
			<div class="span-3  Century18">
				DIRECCION DE ENVIO
			</div>
			<div class="span-4">
				<input type="text" class="campo-sm" name="direnvio">
			</div>
			<div class="span-2" align="right">
				<span class="Century18">NO CRTICO</span>
			</div>
			<div class="span-1" align="center">
				<input type="checkbox" name="critico" class="check" value="0" id="switch">
			</div>
			<div class="span-2 Century18">
				CRITICO
			</div>
		</div>
		<div class="contenedor" style="width: 1200px;" > 
    <br>
    <table>
      <tr>
        <td width="75" >No Prod</td>
        <td width="25" id="nf">1</td>
        <td width="125"><button type="button" class="btn btn-rosa btn-xs1" onclick="agregarFila()">Agregar Producto</button></td>
			</tr>
		</table>
    <table width="100%" border="1" class="tablita Arial12" id="productos">
      <tbody>
        <tr class="titulos">
          <td width="30">No.</td>
          <td width="285">PRODUCTO O SERVICIO</td>
          <td width="90">UND.</td>
          <td width="90">CANT.</td>
					<td width="140">CLASE</td>
          <td width="120">FECHA PARA LA CUAL SE REQUIERE</td>
          <td width="270">OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD </td>
          <td width="70">PROD</td>
          <td width="70">SERV</td>
					<td width="30"></td>
         </tr>
        	<tr class="Arial12">
						<td align="center" class="item">1</td>
						<td><textarea rows="1" cols="7" name="producto[1]" class="txtarea Arial12 producto" required="required"></textarea></td>
						<td><input type="text" class="campo-sm Arial12 unidad" name="unidad[1]" required="required" /></td>
						<td><input type="number" class="campo-sm Arial12 cantidad" name="cantidad[1]" required="required" step="0.01" /></td>
						<td>
							<select name="clase[1]" id="" class="campo-sm Arial12 clase" required="required">
							  <option value="">Seleccione</option>
							  <?php
									do {  
										?>
										<option value="<?php echo $row_Recordset3['IdClase']?>"><?php echo $row_Recordset3['clase']?></option>
										<?php
									} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
									$rows = mysql_num_rows($Recordset3);
									if($rows > 0) {
										mysql_data_seek($Recordset3, 0);
										$row_Recordset3 = mysql_fetch_assoc($Recordset3);
									}
									?>
              </select>
						</td>
						<td><input type="date" class="campo-sm Arial12 requi" name="requi[1]" required="required" min="<?php echo $minrequ ?>" /></td>
						<td align="center"><textarea rows="1" cols="5" name="observa[1]" class="txtarea Arial12 observa" ></textarea></td>
						<td align="center"><input type="radio" name="ps[1]" class="Arial12 ps" value="1" checked /></td>
						<td align="center">
							<input type="radio" name="ps[1]" class="Arial12 ps1" value="0">
							<input type="hidden" name="id[1]" value="1" class="id">
            </td>
						<td align="center">
							<img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer;" onclick="deleteRow(this)">						
						</td>
          </tr>
        </tbody>
      </table>
    <br>
    <input type="hidden" name="solicita" value="<?php echo $row_Recordset1['IdUsuario']  ?>">
    <div class="container" align="center">
      <button type="submit" name="boton1" id="boton" class="btn btn-rosa btn-sm">Grabar</button>
      <div class="espera"></div>
      </div>
    
    </div>
		
	</form>
</div>

<br>

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

mysql_free_result($Recordset4);

mysql_free_result($Recordset3);
                                      
?>
