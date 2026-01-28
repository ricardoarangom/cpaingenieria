<?php 
require_once('../connections/datos.php');
?>
<?php 
include('encabezado.php');

$buscaCartas = "SELECT 
									nombre,
									apellido,
									IdCarta,
									destinatario1,
									destinatario2,
									destinatario3,
									destinatario4,
									destinatario5,
									asunto,
									fecha,
									firmante,
									cartas.IdUsuario,
									enviada,
									cartas.cargo,
									fenvio,
									email,
									radicado,
									ano,
									consAno,
									anulada,
									carta,
									firmaAut			
							FROM
									(cartas
									LEFT JOIN usuarios ON cartas.IdUsuario = usuarios.IdUsuario)
              WHERE
                  IdAutorfirma = ".$usuario." AND firmaAut = 0";
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

$buscaAnos = "SELECT 
									ano
							FROM
									cartas
							GROUP BY ano";
$resultadoAnos = mysql_query($buscaAnos, $datos) or die(mysql_error());
$filaAnos = mysql_fetch_assoc($resultadoAnos);
$totalfilas_buscaAnos = mysql_num_rows($resultadoAnos);

if($totalfilas_buscaCartas>0){
	do{

		$tablacartas[$filaCartas['IdCarta']]['creador']=$filaCartas['nombre']." ".$filaCartas['apellido'];
		$tablacartas[$filaCartas['IdCarta']]['destinatario']=$filaCartas['destinatario1']."<br>".$filaCartas['destinatario2']."<br>".$filaCartas['destinatario3']."<br>".$filaCartas['destinatario4'];
		$tablacartas[$filaCartas['IdCarta']]['firmante']=$filaCartas['firmante']."<br>".$filaCartas['cargo'];
		$tablacartas[$filaCartas['IdCarta']]['fecha']=$filaCartas['fecha'];
		$tablacartas[$filaCartas['IdCarta']]['asunto']=$filaCartas['asunto'];
		$tablacartas[$filaCartas['IdCarta']]['enviada']=$filaCartas['enviada'];
		$tablacartas[$filaCartas['IdCarta']]['fenvio']=$filaCartas['fenvio'];
		$tablacartas[$filaCartas['IdCarta']]['email']=$filaCartas['email'];
		$tablacartas[$filaCartas['IdCarta']]['radicado']=$filaCartas['radicado'];
		$tablacartas[$filaCartas['IdCarta']]['consecutivo']="CPA-".sprintf("%03d",$filaCartas['consAno'])."-".$filaCartas['ano'];
		$tablacartas[$filaCartas['IdCarta']]['anulada']=$filaCartas['anulada'];
		$tablacartas[$filaCartas['IdCarta']]['carta']=$filaCartas['carta'];

		$tablacartas[$filaCartas['IdCarta']]['firmaAut']=$filaCartas['firmaAut'];

		

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
  function subeCarta(id){

		document.getElementById('m-id').value=id;		

		$('#subirCarta').modal({backdrop: 'static', keyboard: false});

	}

  function validarArchivo1(archivo){
          
    if((archivo[0]["size"] > 1100000) || (archivo[0]["type"]!="application/pdf") ){
          
      $("#m-radicado").val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1000B y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
    }
  }

  function subeCarta1(){
		var carta = document.getElementById('m-carta').files[0];
		var id = document.getElementById('m-id').value;
		
    if(!carta){
			document.getElementById('m-carta').focus();
			swal({
				 html: '¡Debe seleccionar la carta!',
				 type: "error",
				 showConfirmButton: true,
				 confirmButtonText: "Cerrar"
				 }).then(function(result){
				 if (result.value) {					 
				 }
			 });
			return
		}

		var datos = new FormData();
    datos.append("carta",carta);
		datos.append("id",id);
    datos.append("proced",5);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          // console.log(respuesta)
          var res = respuesta.trim();
          if(res=='ok'){
						$('#subirCarta').modal('hide');
						swal({
							html: '¡Carta subida con exito!',
							type: "success",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
						if (result.value) {	
              window.open("notautfirma.php?carta="+id+"", "_blank");
							window.location.reload();
						}
						});
            
          }
				}
			});
	}
</script>
<?php 
include('encabezado1.php')
?>
<br>
<h5 class="Century" align="center">AUTORIZAR FIRMAS</h5>
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
        <td>CONSECUTIVO</td>
        <td>CREADOR</td>
        <td>DESTINATARIO</td>
        <td width="100px">FECHA CREACION</td>
        <td>ASUNTO</td>
        <td width="95px">ANEXOS</td>
        <td width="95px">ACCIONES</td>
      </tr>
      <?php
        if($tablacartas){
          foreach($tablacartas as $key=>$j){
            ?>
            <tr class="Arial12">
              <td valign="top"><?php echo $j['consecutivo']; ?></td>
              <td valign="top"><?php echo $j['creador']; ?></td>
              <td valign="top"><?php echo $j['destinatario']; ?></td>								
              <td valign="top" align="center"><?php echo fechaactual3($j['fecha']); ?></td>
              <td valign="top"><?php echo $j['asunto']; ?></td>
              <td valign="top">
                <?php
                if($tablacartas[$key]['anexos']){
                  foreach($tablacartas[$key]['anexos'] as $llave=>$i){
                    echo $i['nombre'];
                    ?>
                    <a href="<?php echo $i['vinculo'] ?>" class="btn btn-rosa btn-xs1 btn-block" target="_blank" style="margin:0">Ver anexo</a>
                    <?php
                  }
                }else{
                  echo "SIN ANEXOS";
                }
                ?>
              </td>
              <td valign="top" align="center">
                <?php 
                if($j['carta']){
                  ?>
                  <a href="<?php echo $j['carta']?>" class="btn btn-verde btn-xs1 btn-block" target="_blank" style="margin-top:2px">Descargar carta</a>
                  <button type="button" class="btn btn-rosa btn-xs1 btn-block" onClick="subeCarta(<?php echo $key?>)"style="margin-top:2px">Subir Carta</button>
                  <?php
                }else{
                  echo 'Aun no han subido el documento';
                }
                ?>
              </td>   
            </tr>	
            <?php
          }
        }else{
          ?>
          <tr>
            <td colspan="7" align="center">NO HAY SOLICITUDES DE AUTORIZACION DE FIRMAS PENDIENTES</td>
          </tr>
          <?php
        }
        ?>        
      </tbody>
    </table>
</div>

<div id="subirCarta" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">SUBIR CARTA FIRMADA</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
			<div class="modal-body">
        <div>
					<input type="hidden" id="m-id">
					<div class="grid columna-2">
						<div class="span-2" id="div-radicado">
							Formato PDF max 1000B
          		<input type="file" name="m-carta" id="m-carta"  class="campo-xs Arial12" onChange="validarArchivo1(this.files)" >
						</div>
					</div>
					<br>
					<div align="center">
						<button type="button" class="btn btn-rosa btn-sm"  onClick="subeCarta1()">Subir</button>
					</div>
          
        </div>	
			</div>
			<div class="modal-footer">					
				<button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cerrar</button>
			</div>
    </div>
  </div>
</div>
<?php 
include('footer.php');
?>