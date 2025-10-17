<?php 
require_once('../connections/datos.php');


include('encabezado.php');
?>
<?php 
$buscaArea = "SELECT 
									*
							FROM
									areas  ORDER BY area";
$resultadoArea = mysql_query($buscaArea, $datos) or die(mysql_error());
$filaArea = mysql_fetch_assoc($resultadoArea);
$totalfilas_buscaArea = mysql_num_rows($resultadoArea);

$buscador='';

if($_POST['IdArea'] or $_POST['remitente'] or $_POST['destinatario'] or $_POST['asunto'] or $_POST['desde'] or $_POST['hasta']){
	$buscador=' WHERE ';

	if($_POST['IdArea']){
		$buscador.=" correcibida.IdArea=".$_POST['IdArea']." and ";
	}
	if($_POST['remitente']){
		$buscador.=" remitente like '%".$_POST['remitente']."%' and ";
	}
	if($_POST['destinatario']){
		$buscador.=" destinatario like '%".$_POST['destinatario']."%' and ";
	}
	if($_POST['asunto']){
		$buscador.=" asunto like '%".$_POST['asunto']."%' and ";
	}
	if($_POST['desde']){
		$buscador.=" fecha >= '".$_POST['desde']."' and ";
	}
	if($_POST['hasta']){
		$buscador.=" fecha <= '".$_POST['hasta']."' and ";
	}

	$buscador=substr($buscador, 0, -4);

}

$buscaCor = " SELECT 
									IdCorrespondencia,
									area,
									remitente,
									destinatario,
									fecha,
									archivo,
									asunto
							FROM
									(correcibida
									LEFT JOIN areas ON correcibida.IdArea = areas.IdArea)
              ".$buscador;  
$resultadoCor = mysql_query($buscaCor, $datos) or die(mysql_error());
$filaCor = mysql_fetch_assoc($resultadoCor);
$totalfilas_buscaCor = mysql_num_rows($resultadoCor);
?>
<script>

	document.addEventListener('DOMContentLoaded', function() {
    
    	prueba();

  });

	function prueba(){        
    var IdArea ="<?php 
    if($_POST){
      echo $_POST['IdArea'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('IdArea').value=IdArea;
    
    var remitente ="<?php 
    if($_POST){
      echo $_POST['remitente'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('remitente').value=remitente;
       
    var destinatario ="<?php 
    if($_POST){
      echo $_POST['destinatario'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('destinatario').value=destinatario;
             
    var asunto="<?php 
    if($_POST){
      echo $_POST['asunto'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('asunto').value=asunto;
		
		var desde="<?php 
    if($_POST){
      echo $_POST['desde'];
    }else{
      echo "";
    }
    ?>";
    document.getElementById('desde').value=desde;
    
    var hasta="<?php 
    if($_POST){
      echo $_POST['hasta'];
    }else{
      echo "";
    }
    ?>"
    document.getElementById('hasta').value=hasta;

		
		
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
	<h4 align="center" class="Century">CONSULTA DE CORRESPONDENCIA RECIBIDA</h4>
	<br>
	<form action="reportecr.php" method="post">
		<div class="grid columna-6" style="width: 800px" align="left">					
			<div class="span-1">
				Proyecto / Area:
			</div>
			<div class="span-2">
				<select name="IdArea" id="IdArea" class="campo-xs Arial12">
					<option value="">Seleccione</option>
					<?php
					do {  
						?>
						<option value="<?php echo $filaArea['IdArea']?>"><?php echo $filaArea['area'] ?></option>
						<?php
					} while ($filaArea = mysql_fetch_assoc($resultadoArea));
					$rows = mysql_num_rows($resultadoArea);
					if($rows > 0) {
						mysql_data_seek($resultadoArea, 0);
						$filaArea = mysql_fetch_assoc($resultadoArea);
					}
					?>
				</select>
			</div>	
			<div class="span-1">
				Remitente:
			</div>
			<div class="span-2">
				<input type="text" name="remitente" id="remitente" class="campo-xs Arial12">
			</div>			
			<div class="span-1">
				Destinatario:
			</div>
			<div class="span-2">
				<input type="text" name="destinatario" id="destinatario" class="campo-xs Arial12">
			</div>	
			<div class="span-1">
				Asunto:
			</div>
			<div class="span-2">
				<input type="text" name="asunto" id="asunto" class="campo-xs Arial12">
			</div>
		</div>
		<br>
		<div class="grid columna-6 Arial14" style="width: 800px">
      <div class="span-2"></div>    
			<div class="span-2 div-form borde-div-g" style="border-radius: 5px">
				<div class="grid columna-2" align="left" style="grid-row-gap: 3px">
					<div class="span-2">
						Fecha de recibo
					</div>
					<div class="span-1">
						Desde:
						<input type="date" name="desde" id="desde" class="campo-xs Arial12">
					</div>
					<div class="span-1">
						Hasta:
						<input type="date" name="hasta" id="hasta" class="campo-xs Arial12">
					</div>
				</div>
			</div>      
      <div class="span-2"></div>
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
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    ?> 
    <div class="contenedor" style="width: 1200px">
      <table class="tablita " align="center" border="1" width="100%">
				<col width="250px">
				<col width="250px">
				<col width="250px">
				<col width="250px">
        <tbody>
          <tr class="Arial14 titulos">
            <td>Proyecto / Area</td>
            <td>Remitente</td>
            <td>Destinatario</td>
            <td>Asunto</td>
            <td width="100px">FECHA</td>
            <td width="100px">VER</td>
          </tr>
          <?php 
					if($totalfilas_buscaCor>0){
						do{
							?>
							<tr class="Arial12" >
								<td valign="top"><?php echo $filaCor['area'] ?></td>
								<td valign="top"><?php echo $filaCor['remitente'] ?></td>
								<td valign="top"><?php echo $filaCor['destinatario'] ?></td>
								<td valign="top"><?php echo $filaCor['asunto'] ?></td>
								<td valign="top" align="center"><?php echo fechaactual3($filaCor['fecha']) ?></td>
								<td valign="top">
									<a href="<?php echo $filaCor['archivo'] ?>" class="btn btn-rosa btn-xs1 btn-block" target="_blanck" >Ver documento</a>
								</td>
							</tr>
							<?php
						} while ($filaCor = mysql_fetch_assoc($resultadoCor));
					}else{
						?>
						<tr>
							<td colspan="6" align="center">NO HAY REGISTROS QUE COINCIDAN CON LOS PARAMETRO DE BUSQUEDA</td>
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
	<br><br><br><br><br>
</div>
<?php 
include('footer.php');
?>
