<?php 
require_once('../connections/datos.php');

$contrato=$_GET['contrato'];

$buscaClase = " SELECT 
                    *
                FROM
                    calsecontratos";
$resultadoClase = mysql_query($buscaClase, $datos) or die(mysql_error());
$filaClase = mysql_fetch_assoc($resultadoClase);
$totalfilas_buscaClase = mysql_num_rows($resultadoClase);

$buscaArea = "SELECT 
									*
							FROM
									areas  ";
$resultadoArea = mysql_query($buscaArea, $datos) or die(mysql_error());
$filaArea = mysql_fetch_assoc($resultadoArea);
$totalfilas_buscaArea = mysql_num_rows($resultadoArea);

$buscaCDoc = "SELECT 
                  *
              FROM
                  clasedocsi;  ";
$resultadoCDoc = mysql_query($buscaCDoc, $datos) or die(mysql_error());
$filaCDoc = mysql_fetch_assoc($resultadoCDoc);
$totalfilas_buscaCDoc = mysql_num_rows($resultadoCDoc);

$buscaDepto = "	SELECT 
										*
								FROM
										departamentos";
$resultadoDepto = mysql_query($buscaDepto, $datos) or die(mysql_error());
$filaDepto = mysql_fetch_assoc($resultadoDepto);
$totalfilas_buscaDepto = mysql_num_rows($resultadoDepto);

$buscaCargo =  "SELECT 
										*
								FROM
										cargos";
$resultadoCargo = mysql_query($buscaCargo, $datos) or die(mysql_error());
$filaCargo = mysql_fetch_assoc($resultadoCargo);
$totalfilas_buscaCargo = mysql_num_rows($resultadoCargo);

$buscaContra = " SELECT 
    IdContrato,
    IdProveedor,
    IdEmpresa,
    IdArea,
    IdSolicitante,
    IdClase,
    IdSubClase,
    objeto,
    finicio,
    ffin,
    ffinfin,
    iva,
    consec,
    contrato,
    valor,
    valorf,
    formaPago,
    anticipo,
    panticipo,
    anticipop,
    terminado,
    integral,
    IdCargo,
    incs,
    especialidad,
    grupo,
    centrofor,
    alcance,
    lugar,
    auxilio,
    IdFirmante,
    anexo,
    proveedor,
    documento
FROM
    (contrat
    LEFT JOIN contratistas ON contrat.IdProveedor = contratistas.IdContratista)
WHERE
    IdContrato = ".$contrato;
$resultadoContra = mysql_query($buscaContra, $datos) or die(mysql_error());
$filaContra = mysql_fetch_assoc($resultadoContra);
$totalfilas_buscaContra = mysql_num_rows($resultadoContra);

?>
<?php 
include('encabezado.php');
?>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var clase = <?php echo $filaContra['IdClase'] ?>;
    var area = <?php echo $filaContra['IdArea'] ?>;
    var subclase = <?php echo $filaContra['IdSubClase'] ?>;
    var firmante = <?php echo $filaContra['IdFirmante'] ?>;

    console.log(clase,area)
    
    buscaSubClase(clase);
    $('#IdClase').val(clase);
    $('#IdArea').val(area);
    $('#IdFirmante').val(firmante);

    setTimeout(() => {
        $('#IdSubClase').val(subclase);
    }, "100");


  });


  function buscaSubClase(IdClaseContrato) {
		var datos = new FormData();
		datos.append("IdClaseContrato", IdClaseContrato);
		datos.append("proced", 1);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				$('#midiv').html(respuesta);
			}
		});
	}

  function cambiaContratista(item) {
		$('#divCambContratista').html(
			'<input type="text" class="campo-xs" id="contratis-' + item + '" onKeyUp="buscaContratista(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdContratista" value="0">' +
			'<div class="drop"><ul class="hijos" id="cch-' + item + '"></ul></div>'
		);
		$('#cambiaContratista').modal({
			backdrop: 'static',
			keyboard: false
		});
	}

	function cambiaContratistan(item) {
		$('#divCambContratista').html(
			'<input type="text" class="campo-xs" id="contratis-' + item + '" onKeyUp="buscaContratistan(this,this.value,this.id)" placeholder="Buscar por nombre" autocomplete="off">' +
			'<input type="hidden" name="IdContratista" value="0">' +
			'<div class="drop"><ul class="hijos" id="cchn-' + item + '"></ul></div>'
		);
		$('#cambiaContratista').modal({
			backdrop: 'static',
			keyboard: false
		});
	}

  function buscaContratista(obj, valor, id) {
		// console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


		if (arrayId[0] == 'contratista') {
			if ($('#ch-' + arrayId[1]).is(':visible')) {

			} else {
				$('#ch-' + arrayId[1]).slideToggle();
			}
		} else {
			if ($('#cch-' + arrayId[1]).is(':visible')) {

			} else {
				$('#cch-' + arrayId[1]).slideToggle();
			}
		}


		var datos = new FormData();
		datos.append("valor", valor);
		datos.append("item", arrayId[1]);
		datos.append("proced", 6);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				//console.log(respuesta)
				if (arrayId[0] == 'contratista') {
					document.getElementById('ch-' + arrayId[1]).innerHTML = respuesta
				} else {
					document.getElementById('cch-' + arrayId[1]).innerHTML = respuesta
				}
			}
		})
	}

	function buscaContratistan(obj, valor, id) {
		// console.log(obj,valor,id)
		var arrayId = id.split("-");
		var strLength = obj.value.length;


		if (arrayId[0] == 'contratistan') {
			if ($('#chn-' + arrayId[1]).is(':visible')) {

			} else {
				$('#chn-' + arrayId[1]).slideToggle();
			}
		} else {
			if ($('#cchn-' + arrayId[1]).is(':visible')) {

			} else {
				$('#cchn-' + arrayId[1]).slideToggle();
			}
		}


		var datos = new FormData();
		datos.append("valor", valor);
		datos.append("item", arrayId[1]);
		datos.append("proced", 3);

		$.ajax({
			url: "ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				console.log(respuesta)
				if (arrayId[0] == 'contratistan') {
					document.getElementById('chn-' + arrayId[1]).innerHTML = respuesta
				} else {
					document.getElementById('cchn-' + arrayId[1]).innerHTML = respuesta
				}
			}
		})
	}

  function llenar(id, nombre, item, documento) {
		$('#cambiaContratista').modal('hide');
		// console.log(id, nombre, item,documento)
		var item1 = "'" + item + "'"
		$('#tdprov-' + item).html(
			'<div style="width: 320px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratista(' + item1 + ')">' + nombre + '</div>' +
			'<input type="hidden" name="contratista" id="contratista' + item + '" value="' + id + '">' 
		);
		$('#tdnit-' + item).html(
			'<div style="width:160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratistan(' + item1 + ')">' + documento + '</div>'
		);
	}
</script>
<style>
  .drop .hijos {
		display: none;
		background: #ffffff;
		position: absolute;
		z-index: 1000;
		width: max-content;
		padding: 0;
		margin-top: 8px;
		border: 1px solid rgba(0, 0, 0, 0.3);
		border-radius: 4px;

	}

	.drop .hijos li {
		display: block;
		text-align: left;
	}

	.drop .hijos li:hover {
		background: #e3e3f7;
	}

	::placeholder {
		color: #ccc;
		font-size: 12px;
	}

	.item {
		display: block;
		cursor: pointer;
		padding: 1px 5px;
		color: #000000;
	}
</style>
<?php 
include('encabezado1.php');
?>
<div class="contenedor" style="width:1000px">
	<h5 class="Century" align="center">EDICION DE CONTRATOS</h5>
	<form action="graba.php" method="post" enctype="multipart/form-data" onSubmit="bloquear('boton')">
    <div class="grid columna-8 Arial14">
			<div class="span-4">
				Proyecto / Area:
				<select name="IdArea" id="IdArea" class="campo-sm Arial12" required>
					<option value="">Seleccione</option>
					<?php
					do {
					?>
						<option value="<?php echo $filaArea['IdArea'] ?>"><?php echo $filaArea['area'] ?></option>
					<?php
					} while ($filaArea = mysql_fetch_assoc($resultadoArea));
					?>

				</select>
			</div>
			<div class="span-4">
				Contratista:
				<table class="tablita Arial12" width="100%">
					<col width="66%">
					<col width="34%">
					<tr>
						<td id="tdprov-1">
              <div style="width: 320px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratista('1')"><?php echo $filaContra['proveedor'] ?></div>
			        <input type="hidden" name="contratista" id="contratista1" value="<?php echo $filaContra['IdProveedor'] ?>">
						</td>
						<td id="tdnit-1">
							<div style="width:160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor:pointer" onClick="cambiaContratistan('1')"><?php echo colocapuntos($filaContra['documento']) ?></div>
						</td>
					</tr>
				</table>
			</div>		
			<div class="span-2">
				Clase de Contrato:
				<select name="IdClase" id="IdClase" class="campo-sm Arial12" onChange="buscaSubClase(this.value)">
					<option value="">Seleccione</option>
					<?php
					do {
					?>
						<option value="<?php echo $filaClase['IdClaseContrato'] ?>"><?php echo  $filaClase['clase'] ?></option>
					<?php
					} while ($filaClase = mysql_fetch_assoc($resultadoClase));
					?>
				</select>
			</div>
			<div class="span-2" id="midiv">
				Sub Clase de Contrato:
				<select name="IdSubClase" id="IdSubClase" class="campo-sm Arial12">
					<option value="">Seleccione</option>
				</select>
			</div>
			<div class="span-2">
				Firmante:
				<select name="IdFirmante" id="IdFirmante" class="campo-sm Arial12">
					<option value="1">LUIS HECTOR RUBIANO VERGARA</option>
					<option value="2">MARTHA GABRIELA	BOTERO SERNA</option>
				</select>	
			</div>
			<div class="span-2">
			</div>
			<div class="span-3">
				Terminos de referencia: (Formato PDF max 1MB)
				<input type="file" name="anexo" id="anexo" class="campo-sm Arial12" onChange="validarArchivo(this.files,this.id)">
			</div>
      <?php 
      if($filaContra['anexo']){
        ?>
        <div class="span-2">
          <br>
          <a href="<?php echo $filaContra['anexo']?>" class="btn btn-rosa btn-xs btn-block"  target="_blank" style="margin-top:4px">Ver Terminos de referencia</a>
        </div>
        <?php
      }
      ?>
		</div>  


  </form>

</div>

<div id="cambiaContratista" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 320px">
		<div class="modal-content">
			<div class="modal-header" style="background:#d8d8d8; color:black;padding: 10px">
				<h5 class="modal-title Century">Cambiar contratista</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body Arial12" id="divCambContratista">
			</div>
		</div>
	</div>
</div>
<?php 
include('footer.php');
?>

  
</body>
</html>