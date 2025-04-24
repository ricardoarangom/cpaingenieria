<?php require_once('../connections/datos.php'); ?>
<?php 

$solicitud=$_GET['orden'];

$busca="SELECT IdSolicitante, IdArea, fsolicitud, direnvio, critico FROM ordencompra WHERE IdOrdencompra=".$solicitud."";
$resultado = mysql_query($busca, $datos) or die(mysql_error());
$fila = mysql_fetch_assoc($resultado);

$usuario=$fila['IdSolicitante'];
$area=$fila['IdArea'];
//echo $usuario;


$minrequ=(strtotime ( '+'.(10).' day' , strtotime ( date("Y-m-d")  )));
$minrequ=date("Y-m-d",$minrequ);

session_start();


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

$var1_Recordset2 = "0";
if (isset($area)) {
  $var1_Recordset2 = $area;
}
mysql_select_db($database_datos, $datos);
$query_Recordset2 = sprintf("SELECT area, IdArea, IdEmpresa FROM areas WHERE IdArea=%s", GetSQLValueString($var1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset3 = "0";
if (isset($solicitud)) {
  $var1_Recordset3 = $solicitud;
}
mysql_select_db($database_datos, $datos);
$query_Recordset3 = sprintf("SELECT * FROM itemoc WHERE IdOrdencompra=%s", GetSQLValueString($var1_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<?php 
include('encabezado.php');
?>
	
<script type="text/javascript" language="JavaScript" src="../js/ajax.js"></script>
<script language="JavaScript" type="text/javascript">
	function agregarFila(){
		var a=parseFloat(document.getElementById('nf').innerHTML);
		a=a+1;

		var fila1 ='<td align="center" class="item">'+a+'</td>';
		var fila2 ='<td><textarea rows="1" cols="7" name="producton['+a+']" class="txtarea Arial12 producto" required="required" ></textarea></td>';
		var fila3 ='<td><input type="text" class="campo-sm Arial12 unidad" name="unidadn['+a+']" required="required" /></td>';
		var fila4 ='<td><input type="text" class="campo-sm Arial12 cantidad" name="cantidadn['+a+']" required="required" /></td>';
		var fila5 ='<td><input type="date" class="campo-sm Arial12 requi" name="requin['+a+']" required="required"/></td>';
		var fila6 ='<td align="center"><textarea rows="1" cols="5" name="observan['+a+']" class="txtarea Arial12 observa" ></textarea></td>';
		var fila7 ='<td align="center"><input type="radio" name="psn['+a+']" class="form-control Arial12 ps" value="1" checked /></td>';
		var fila8 ='<td align="center"><input type="radio" name="psn['+a+']" class="form-control Arial12 ps1" value="0"><input type="hidden" name="idn['+a+']"  class="id"  value="'+a+'"></td>';
		var fila9 ='<td align="center"><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer;margin-top: 5px" onclick="deleteRow(this)"></td>';

		var filacom=fila1+fila2+fila3+fila4+fila5+fila6+fila7+fila8+fila9;     

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
	
 	function recuento(){
		
		var inicio = <?php echo $totalRows_Recordset3 ?>;
		var item = document.querySelectorAll('.item');
		var producto = document.querySelectorAll('.producto');
		var unidad = document.querySelectorAll('.unidad');
		var cantidad = document.querySelectorAll('.cantidad');
		var requi = document.querySelectorAll('.requi');
		var observa = document.querySelectorAll('.observa');
		var ps = document.querySelectorAll('.ps');
		var ps1 = document.querySelectorAll('.ps1');
		var id = document.querySelectorAll('.id');
		
		for(var i=(inicio);i<id.length;i++){
			
			producto[i].setAttribute("name", 'producton['+(i+1)+"]");
			unidad[i].setAttribute("name", 'unidadn['+(i+1)+"]");
			cantidad[i].setAttribute("name", 'cantidadn['+(i+1)+"]");

			requi[i].setAttribute("name", 'requin['+(i+1)+"]");
			observa[i].setAttribute("name", 'observan['+(i+1)+"]");
			ps[i].setAttribute("name", 'psn['+(i+1)+"]");
			ps1[i].setAttribute("name", 'psn['+(i+1)+"]");


			id[i].setAttribute("name", 'idn['+(i+1)+"]");
			id[i].value=i+1;
			item[i].innerHTML=i+1;
		
  	}

	}
</script>


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
<form method="post" action="graba.php" name="form1" >
	
  <div class="contenedor" style="width: 1200px;" >
		<div class="grid columna-16">
			<div class="span-3 Century18">
					PROYECTO/AREA 
			</div>
			<div class="span-3" style="font-weight:bold;font-size: 16px">
				<?php echo $row_Recordset2['area']?>
			</div>
			<div class="span-3 Century18" align="center" >
				FECHA DE SOLICITUD
			</div>
			<div class="span-2" align="right" style="font-weight:bold;font-size: 16px">
				<?php echo fechaactual3($fila['fsolicitud']) ?>				
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
			<div class="span-4" style="font-weight:bold;font-size: 16px">
				<?php echo $fila['direnvio'] ?>
			</div>
			<div class="span-2 Century18">
				CRITICO
			</div>
			<div class="span-1" style="font-weight:bold;font-size: 16px">
				<?php 
				if($fila['critico']==1){
					echo 'SI';
				}else{
					echo 'NO';
				}
				?>
			</div>	
		</div>
		<br>
    <table>
      <tr>
        <td width="75" >No Prod</td>
        <td width="25" id="nf"><?php echo $totalRows_Recordset3?></td>
        <td width="125"><button type="button" class="btn btn-rosa btn-xs1" onclick="agregarFila()">Agregar Producto</button></td>
        </tr>
      </table>
    <table width="100%" border="1" class="Arial12" id="productos">
      <tbody>
        <tr class="titulos">
          
					
					<td width="30">No.</td>
          <td width="300">PRODUCTO O SERVICIO</td>
          <td width="90">UND.</td>
          <td width="90">CANT.</td>
          <td width="140">FECHA PARA LA CUAL SE REQUIERE</td>
          <td width="280">OBSERVACIONES Y REQUISTOS ESPECIFICOS SEGURIDAD, SALUD, AMBIENTE O CALIDAD </td>
          <td width="90">PROD</td>
          <td width="90">SERV</td>
					<td width="40">ELIM</td>
        </tr>
        <?php 
        $j=1;
        do{
        ?>
          <tr class="Arial12">
            <td align="center" class="item"><?php echo $j ?></td>
            <td><textarea rows="1" cols="7" name="producto[<?php echo $j ?>]" class="txtarea Arial12 producto" ><?php echo $row_Recordset3['producto'] ?></textarea></td>
            <td><input type="text" class="campo-sm Arial12 unidad" name="unidad[<?php echo $j ?>]" value="<?php echo $row_Recordset3['unidad'] ?>" /></td>
            <td><input type="text" class="campo-sm Arial12 cantidad" name="cantidad[<?php echo $j ?>]" value="<?php echo $row_Recordset3['cantidad'] ?>"/></td>
            <td><input type="date" class="campo-sm Arial12 requi" name="requi[<?php echo $j ?>]" value="<?php echo $row_Recordset3['frequerido'] ?>"  /></td>
            <td align="center"><textarea rows="1" cols="5" name="observa[<?php echo $j ?>]" class="txtarea Arial12 observa" ><?php echo $row_Recordset3['especificacion'] ?></textarea></td>
            <td align="center">
              <input type="radio" name="ps[<?php echo $j ?>]" class="form-control Arial12 ps" value="1" <?php if($row_Recordset3['PS']==1){echo "checked";}  ?>></td>
            <td align="center">
              <input type="radio" name="ps[<?php echo $j ?>]" class="form-control Arial12 ps1" value="0" <?php if($row_Recordset3['PS']==0){echo "checked";}  ?>/>
              <input type="hidden" class="id" name="id[<?php echo $j ?>]" value="<?php echo $j ?>">
              <input type="hidden" name="IdItem[<?php echo $j ?>]" value="<?php echo $row_Recordset3['IdItem'] ?>">
            </td>
						<td align="center">
							<input type="checkbox" name="borra[<?php echo $j ?>]">
						</td>
					</tr>
          <?php 
          $j++;
        } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
        ?>
        </tbody>
      </table>
    <br>
    <div class="container" align="center">
      <input type="hidden" value="<?php echo $solicitud?>" name="solicitud">
      <button type="submit" name="boton14" class="btn btn-rosa btn-sm">Grabar</button>
      </div>  
    </div>  
</form> 
<br>

</div>

<?php 
	mysql_close($datos);

include('footer.php')
?>



</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
                  
?>
