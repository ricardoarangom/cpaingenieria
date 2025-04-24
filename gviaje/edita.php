<?php require('../connections/datos.php');?>
<?php 
include ('encabezado.php');

$buscaSol="SELECT gviaje.IdGviaje, nombre, apellido, area, ccostos, municipio, departamentos, fsalida, fregreso, actividad, fsolicitud, fautorizacion, fpago, rechazada, total, certificacion, beneficiario, soporte, legalizado  FROM ((((gviaje left join usuarios on gviaje.IdSolicitante=usuarios.IdUsuario) left join areas on gviaje.IdArea=areas.IdArea) left join municipios on gviaje.IdMunicipio=municipios.IdMunicipio) left join departamentos on municipios.IdDepartamento=departamentos.IdDepartamento) left join totgviaje on gviaje.IdGviaje=totgviaje.IdGviaje where fpago is null order by IdGviaje";
$resultado = mysql_query($buscaSol, $datos) or die(mysql_error());
$row_resultado = mysql_fetch_assoc($resultado);
$totalRows_resultado = mysql_num_rows($resultado);
?>

<?php 
include ('encabezado1.php');
?>
<div class="contenedor" align="center">
  <h4 align="center" class="Century">EDICION DE SOLICITUDES</h4>
  <br>
  <table class="tablita Arial12" border="1" align="center">
    <col width="35px">
    <col width="80px">
    <col width="210px">
    <col width="205px">
    <col width="230px">
    <col width="250px">
    <col width="80px">
    <col width="80px">
    <col width="130px">
    <col width="80px">
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
      <td></td>
    </tr>
    <?php 
    if($totalRows_resultado>0){
      do{
        ?>
        <tr  class="Arial12">
          <td align="right" valign="top"><?php echo $row_resultado['IdGviaje']; ?></td>
          <td align="center" valign="top"><?php echo fechaactual3($row_resultado['fsolicitud']); ?></td>
          <td valign="top"><?php echo $row_resultado['nombre']." ".$row_resultado['apellido']; ?></td>
          <td valign="top"><?php echo $row_resultado['beneficiario'] ?></td>
          <td valign="top"><?php echo $row_resultado['ccostos']." - ".$row_resultado['area']; ?></td>
          <td valign="top"><?php echo $row_resultado['actividad']; ?></td>
          <td align="center" valign="top"><?php echo fechaactual3($row_resultado['fsalida']); ?></td>
          <td align="center" valign="top"><?php echo fechaactual3($row_resultado['fregreso']); ?></td>
          <td valign="top"><?php echo $row_resultado['municipio']; ?><br><?php echo $row_resultado['departamentos']; ?></td>
          <td>
            <a href="edita1.php?sol=<?php echo $row_resultado['IdGviaje']; ?>" class="btn btn-rosa btn-xs1 btn-block">Editar</a>
          </td>
        </tr>
        <?php
      } while ($row_resultado = mysql_fetch_assoc($resultado));
    }else{
      ?>
      <tr class="Arial14">
        <td align="center" colspan="10">NO HAY SOLICITUDES PARA EDITAR</td>
      </tr>
      <?php
    }
    ?>
    
  </table>
  <?php 
  
  ?>
</div>
<?php 
include ('footer.php');
?>

</body>
</html>