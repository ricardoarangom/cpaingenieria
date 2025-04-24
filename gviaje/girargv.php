<?php require_once('../connections/datos.php'); ?>
<?php 
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

mysql_select_db($database_datos, $datos);
$query_Recordset1 = "SELECT gviaje.IdGviaje, nombre, apellido, area, ccostos, municipio, departamentos, fsalida, fregreso, actividad, fsolicitud, total, certificacion, beneficiario, fpago  FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join totgviaje on gviaje.IdGviaje=totgviaje.IdGviaje where legalizado=0 and rechazada=0 and fautorizacion is not null order by gviaje.IdGviaje";
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?> 
<?php
include('encabezado.php')
?>
<script>

 function eliminar(id){
   console.log(id)
   
   var datos = new FormData();
   datos.append("IdGviaje",id);
   datos.append("proced",2);
    
    $.ajax({

      url:"ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta)
        var res = respuesta.trim()
        
        if(res == "ok"){
          
          swal({
            title: "",
            text: "¡La solicitud ha sido eliminada!",
            type: "success",
            confirmButtonText: "¡Cerrar!"
          }).then(function(isConfirm){
            if(isConfirm){
              location.reload();
            }
          });

        }
      }
    })
 }

  function legalizar(id){
    var datos = new FormData();
    datos.append("IdGviaje",id);
    datos.append("proced",3);

    $.ajax({

        url:"ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
          console.log(respuesta)
          var res = respuesta.trim()
  
        if(res == "ok"){
          
          swal({
            title: "",
            text: "¡Se ha confirmado la legalización!",
            type: "success",
            confirmButtonText: "¡Cerrar!"
          }).then(function(isConfirm){
            if(isConfirm){
              location.reload();
            }
          });

      }
    }
})

  }
</script>
<style>
  body {
    min-width: 1660px;
  }
</style>
<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center">
  <h4 class="Century24">GASTOS DE VIAJE PENDIENTES DE PAGO</h4>
</div>
<br />
  <?php //echo $usuario  ?>
<div class="contenedor-ancho" style="width: 1660px">
  <?php 
  if($totalRows_Recordset1>0){
  ?>
  <table border="1" class="tablita Arial13" align="center">
		<col width="35px">
		<col width="80px">
		<col width="210px">
		<col width="205px">
		<col width="230px">
		<col width="250px">
		<col width="80px">
		<col width="80px">
		<col width="130px">
    <col width="75px">
    <col width="80px">
    <col width="65px">
    <col width="60px">
    <tbody>
      <tr class="Arial13 titulos" >
        <td align="center">No. Sol.</td>
				<td align="center">FECHA SOLICITUD</td>
        <td align="center">SOLICITANTE</td>
        <td align="center">QUIEN VIAJA</td>
        <td align="center">AREA/PROYECTO</td>
				<td align="center">ACTIVIDAD</td>
        <td align="center">FECHA SALIDA</td>
				<td align="center">FECHA REGRESO</td>
				<td align="center">DESTINO</td>
        <td align="center">TOTAL</td>
        <td align="center">PAGADO</td>
        <td align="center">CERTIFICACION</td>
        <td align="center">ELIMINAR</td>
        </tr>
      <?php 
        do{
        ?>
        <tr class="Arial12">
          <td align="right" valign="top"><?php echo $row_Recordset1['IdGviaje']; ?></td>
					<td align="center" valign="top"><?php echo fechaactual3($row_Recordset1['fsolicitud']); ?></td>
          <td valign="top"><?php echo $row_Recordset1['nombre']." ".$row_Recordset1['apellido']; ?></td>
          <td valign="top"><?php echo $row_Recordset1['beneficiario'] ?></td>
          <td valign="top"><?php echo $row_Recordset1['ccostos']." - ".$row_Recordset1['area']; ?></td>
          <td valign="top"><?php echo $row_Recordset1['actividad']; ?></td>
					<td align="center" valign="top"><?php echo fechaactual3($row_Recordset1['fsalida']); ?></td>
					<td align="center" valign="top"><?php echo fechaactual3($row_Recordset1['fregreso']); ?></td>
					<td valign="top"><?php echo $row_Recordset1['municipio']; ?><br><?php echo $row_Recordset1['departamentos']; ?></td>
          <td valign="top" align="right"><?php echo number_format($row_Recordset1['total']) ?></td>
          <td align="center" valign="top">
            <?php
            if($row_Recordset1['fpago']){
              ?>
              <button type="button" class="btn btn-verde btn-xs1 btn-block Arial10" onClick="legalizar(<?php echo $row_Recordset1['IdGviaje']; ?>)">Confirmar<br>Legalización</button>
              <?php
            }else{
              ?>
              <a href="girargv1.php?solicitud=<?php echo $row_Recordset1['IdGviaje'] ?>" target="_blank" class="btn btn-rosa btn-xs1 btn-block Arial10">Pagar</a>
              <?php
            }
            ?>
            
          </td>
          <td align="center" valign="top">
            <?php
            if($row_Recordset1['certificacion']){
              ?>
              <a href="<?php echo $row_Recordset1['certificacion'] ?>" target="_blank" class="btn btn-rosa btn-xs1">Ver Cert. bancaria</a>
              <?php
            }
            ?>            
          </td>
          <td align="center" valign="top">
            <?php
            if($row_Recordset1['fpago']){
            }else{
              ?>
              <button type="button" class="btn btn-rojo btn-xs1 btn-block" onClick="eliminar(<?php echo $row_Recordset1['IdGviaje']; ?>)">Eliminar</button>
              <?php
            }
            ?>            
          </td>
          </tr>
        <?php 
        }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
        ?>
      </tbody>
    </table>
  <?php 
  }else{
    ?>
</div>
    <div class="container" align="center">
      <h5>NO HAY GASTOS DE VIAJE POR PAGAR</h5>
    </div>
    <div> 
      <?php     }
  ?>
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
?>
