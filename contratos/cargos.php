<?php 
require_once('../connections/datos.php');

$buscaCargo = " SELECT 
                    IdCargo, cargo
                FROM
                    cargos
                ORDER BY cargo";
$resultadoCargo = mysql_query($buscaCargo, $datos) or die(mysql_error());
$filaCargo = mysql_fetch_assoc($resultadoCargo);
$totalfilas_buscaCargo = mysql_num_rows($resultadoCargo);

do{
  $tabla[$filaCargo['IdCargo']]=$filaCargo['cargo'];
} while($filaCargo = mysql_fetch_assoc($resultadoCargo));

$cadenaCargos=json_encode($tabla,JSON_UNESCAPED_UNICODE);

echo "<pre>";
print_r($tabla);
echo "</pre>";
?>
<?php 
include('encabezado.php');
?>
<script>
  function editaCargo(id){
    
    var tabla = '<?php echo $cadenaCargos ? $cadenaCargos : 0  ?>';
		var arregloTabla = JSON.parse(tabla);

		document.getElementById('cargo-e').value=arregloTabla[id];	
		document.getElementById('id-e').value=id;
		$('#editaCargoM').modal({backdrop: 'static', keyboard: false});
  }

  function grabaCargoE(){
		$('#editaAreaM').modal('hide');
		var IdCargo = document.getElementById('id-e').value;
		var cargo = document.getElementById('cargo-e').value;
		
		
		var datos = new FormData();
		datos.append("IdCargo",IdCargo);
		datos.append("cargo",cargo);
		datos.append("proced",13);

    
		$.ajax({
						url:"ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						success: function(respuesta){
							respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
							console.log(respuesta);
							if(respuesta=='ok'){
								swal({
									html: '<div class="Arila14">EL CARGO HA SIDO ACTUALIZADO CON EXITO</div><br>',
									type: "success",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
									if (result.value) {
										location.reload();
									}
								});
							}							
						}
			});
		
	}

  function creaCargo(){
    var cargo = document.getElementById('cargo').value;
			
		if(cargo==''){
			swal({
				text: "¡DEBE ESCRIBIR EL CARGO!",
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			}); 
			return;
		}
		var datos = new FormData();
		datos.append("cargo",cargo);
		datos.append("proced",14);

    $.ajax({
      url:"ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
        console.log(respuesta)
        if(respuesta=='ok'){
          swal({
            html: '<div class="Arila14">EL CARGO HA SIDO CREADO CON EXITO</div><br>',
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
              location.reload();
            }
          });
        }
        
      }
    });
  }
</script>
<style>
  .icono{
		cursor: pointer;
		font-size: 16px;
	}

	.icono:hover{
		color:#FF3F3F;
	}
</style>
<?php 
include('encabezado1.php');
?>
<br>
<h5 class="Century" align="center">EDICION Y CREACION DE CARGOS</h5>

<div class="contenedor">
  <table class="tablita Arial12" border="1" align="center">
    <col width="250px">
    <col width="25px">
    <tr class="titulos">
      <td>CARGO</td>
      <td></td>
    </tr>
    <?php
    foreach($tabla as $key=>$j){
      ?>
      <tr>
        <td><?php echo $j ?></td>
        <td align="center">
          <i class="icono icon-pencil" onClick="editaCargo(<?php echo $key ?>)"></i>
        </td>
      </tr> 
      <?php
    }
    ?>     
    <tr>
      <td>
        <input type="text" name="cargo" id="cargo" class="campo-xs" placeholder="Ingrese el nuevo cargo" onBlur="aMayusculas(this.value,this.id)">
      </td>
      <td>
        <i class="icono icon-disc-floppy-font" onClick="creaCargo()"></i>
      </td>
    </tr>
  </table>
</div>

<!-- modals -->
 <div id="editaCargoM" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="width: 390px">    
    <div class="modal-content">
      <div class="modal-header titulos" style="padding: 10px">
				<h6 class="modal-title">Editar Cargo</h6>					
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
      </div>			
      <div class="modal-body" style="padding: 5px">
        <div class="grid columna-6 contenedor" style="grid-row-gap:5px;">
          <div class="span-6 Arial14">
            Cargo
            <input type="text" id="cargo-e" class="campo-xs Arial12" onBlur="aMayusculas(this.value,this.id)">
          </div>			
        </div>
        <input type="hidden" id="id-e">
      </div>
      <div class="modal-footer" style="padding: 5px">
        <button type="button" id="valida" class="btn btn-rosa btn-xs" onClick="grabaCargoE()" >Grabar</button>
        <button type="button" class="btn btn-verde btn-xs" data-dismiss="modal">Cancelar</button>
      </div>			
		</div>
	</div>
</div>

<?php 
include('footer.php');
?>



</body>
</html>