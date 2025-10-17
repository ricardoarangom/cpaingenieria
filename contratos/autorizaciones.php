<?php require_once('../connections/datos.php'); ?>
<?php 
include('encabezado.php');

$buscaSol = " SELECT 
                  IdSolicitud,
                  solcontratos.IdContrato,
                  proveedor,
                  area,
                  contrat.IdClase,
                  contrat.IdSubClase,
                  clase,
                  subclase,
                  objeto,
                  consec,
                  cargos.cargo,
                  concat(nombre,' ',apellido) as solicitante
              FROM
                  (((((((solcontratos
                  LEFT JOIN contrat ON solcontratos.IdContrato = contrat.IdContrato)
                  LEFT JOIN contratistas ON contrat.IdProveedor = contratistas.IdContratista)
                  LEFT JOIN areas ON contrat.IdArea = areas.IdArea)
                  LEFT JOIN calsecontratos ON contrat.IdClase = calsecontratos.IdClaseContrato)
                  LEFT JOIN subclasescontrat ON contrat.IdSubClase = subclasescontrat.IdSubClase)
                  LEFT JOIN cargos ON contrat.IdCargo = cargos.IdCargo)
                  left join usuarios on solcontratos.IdUsuario=usuarios.IdUsuario)
              WHERE
                  autorizado = 0";
$resultadoSol = mysql_query($buscaSol, $datos) or die(mysql_error());
$filaSol = mysql_fetch_assoc($resultadoSol);
$totalfilas_buscaSol = mysql_num_rows($resultadoSol);
?>
<script>

  function autorizar(Id,accion,IdContrato){
    console.log(Id,accion,IdContrato);

    var datos = new FormData();
    datos.append("Id",Id);
		datos.append("accion",accion);
    datos.append("proced",16);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          var res = respuesta.trim();
					console.log(res);
          if(res=='ok'){
						$('#subirRadicado').modal('hide');
						swal({
							html: '¡La solicitud ha sido enviada!',
							type: "success",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
						if (result.value) {	
              window.open('correoautor.php?IdSolicitud='+Id, '_blank');
							window.location.reload();
						}
						});
            
          }
				}
			});
  }

</script>
<?php 
include('encabezado1.php');
?>
<div class="contenedor" align="center">
  <h4 align="center" class="Century">AUTORIZAR CONSULTA DE CONTRATOS</h4>
  <br>
  <table class="tablita Arial12" align="center" border="1">
    <col width="220">
    <col width="60">
    <col width="220">
    <col width="220">
    <col width="140">
    <col width="250">
    <col width="80">
    <tr class="titulos" >
      <td>SOLICITANTE</td>
      <td>CONSEC</td>
      <td>CONTRATISTA</td>
      <td>AREA</td>
      <td>CLASE</td>
      <td>CARGO / OBJETO</td>
      <td></td>
    </tr>
    <?php 
    do{
      if($filaSol['IdClase']==1){
        $consec='LAB '.sprintf("%03d",$filaSol['consec']);
      }
      if($filaSol['IdClase']==2){
        $consec='PS '.sprintf("%03d",$filaSol['consec']);
      }
      if($filaSol['cargo']){
        $cargo=$filaSol['cargo'];
      }else{
        $cargo=$filaSol['objeto'];
      }
      ?>
      <tr>
        <td valign="top"><?php echo $filaSol['solicitante'] ?></td>
        <td valign="top" align="center"><?php echo $consec ?></td>
        <td valign="top"><?php echo $filaSol['proveedor'] ?></td>
        <td valign="top"><?php echo $filaSol['area'] ?></td>
        <td valign="top"><?php echo $filaSol['clase']?><br><?php echo $filaSol['subclase']?></td>
        <td valign="top"><?php echo $cargo ?></td>
        <td valign="top">
          <button class="btn btn-verde btn-xs1 btn-block" onClick="autorizar(<?php echo $filaSol['IdSolicitud'] ?>,1,<?php echo $filaSol['IdContrato'] ?>)" >Autorizar</button>
          <button class="btn btn-rojo btn-xs1 btn-block" onClick="autorizar(<?php echo $filaSol['IdSolicitud'] ?>,2,<?php echo $filaSol['IdContrato'] ?>)" >Rechazar</button>
        </td>
      </tr>
      <?php

    } while ($filaSol = mysql_fetch_assoc($resultadoSol));
    ?>
    
  </table>

</div>
<?php 
include('footer.php');
?>

</body>
</html>
