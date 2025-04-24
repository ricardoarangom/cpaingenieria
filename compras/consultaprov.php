<?php require_once('../connections/datos.php'); ?>
<?php 
$IdProveedor=$_GET['id'];
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
$query_Recordset3 = "SELECT * FROM departamentos";
$Recordset3 = mysql_query($query_Recordset3, $datos) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_datos, $datos);
$query_Recordset4 = "SELECT * FROM bancos ORDER BY banco";
$Recordset4 = mysql_query($query_Recordset4, $datos) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$var1_Recordset1 = "0";
if (isset($IdProveedor)) {
  $var1_Recordset1 = $IdProveedor;
}
mysql_select_db($database_datos, $datos);
$query_Recordset1 = sprintf("SELECT IdProveedor, proveedor, documento, telefono, direccion, departamento, ciudad, contacto, email, email2, email3, finscrip, replegal, regimen, celular, fconstitucion, granc, autoret, declarante, rut, fotced, camcom, fotresfac, certbanc, docauto, resacr, fictecnica, cercalidad, cercalibra, licsegur, lislabora, regedu, ficdot, licamb, psev, licfunci, tarpropsi, IdBanco, clasecuenta, cuenta, IdSegmento FROM proveedores WHERE IdProveedor=%s ", GetSQLValueString($var1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $datos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_datos, $datos);
$query_Recordset2 = "select IdMunicipio, municipio from municipios";
$Recordset2 = mysql_query($query_Recordset2, $datos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$var1_Recordset5 = "0";
if (isset($IdProveedor)) {
  $var1_Recordset5 = $IdProveedor;
}
mysql_select_db($database_datos, $datos);
$query_Recordset5 = sprintf("SELECT year(comprado) as ano, AVG(evaluacion) as promedio FROM compras WHERE IdProveedor=%s and evaluacion<>0 GROUP BY year(comprado)", GetSQLValueString($var1_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $datos) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_datos, $datos);
$query_Recordset6 = "SELECT * FROM clasproveedores;";
$Recordset6 = mysql_query($query_Recordset6, $datos) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

do{
	$municipios[$row_Recordset2['IdMunicipio']]=$row_Recordset2['municipio'];
}while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));

do{
	$departamentos[$row_Recordset3['IdDepartamento']]=$row_Recordset3['departamentos'];
}while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));

do{
	$bancos[$row_Recordset4['IdBanco']]=$row_Recordset4['banco'];
}while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));

do{
	$clasificacion[$row_Recordset6['IdClasificacion']]=$row_Recordset6['clasificacion'];
} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));


if($row_Recordset1['declarante']==0){
  $declarante1='NO';
}else{
  $declarante1='SI';
}

if($row_Recordset1['granc']==0){
  $granc1='NO';
}else{
  $granc1='SI';
}

if($row_Recordset1['autoret']==0){
  $autoret1='NO';
}else{
  $autoret1='SI';
}
?>
<?php
include('encabezado.php')
?>
<script>

</script>
<?php
include('encabezado1.php')
?>
<div class="contenedor" style="width: 1050px">
	<h4 align="center" class="Century">CONSULTA DE PROVEEDORES</h4>
		<strong>INFORMACION GENERAL</strong>
    <table border="1" class="tablita Arial14" align="center">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
			<col width="75">
      <col width="75">
      <col width="75">
      <col width="37">
      <col width="37">
      <col width="75">
      <tr>
        <td colspan="5">NOMBRE O RAZON SOCIAL DE LA ORGANIZACIÓN</td>
        <td colspan="6"><?php echo $row_Recordset1['proveedor'] ?></td>
        <td colspan="1">INSCRIP</td>
        <td colspan="3" align="center"><?php echo fechaactual3($row_Recordset1['finscrip']) ?></td>
      </tr>
      <tr>
        <td colspan="3">NIT/CEDULA</td>
        <td colspan="4"><?php echo $row_Recordset1['documento']?> </td>
				<td colspan="3">EMAIL-1</td>
        <td colspan="5"><input type="email" name="correo" id="correo" class="campo-sm" required="required" value="<?php echo $row_Recordset1['email'] ?>"></td>        
			</tr>
			<tr>
				<td colspan="3">EMAIL-2</td>
        <td colspan="4"><?php echo $row_Recordset1['email2'] ?></td>
				<td colspan="3">EMAIL-3</td>
        <td colspan="5"><?php echo $row_Recordset1['email3'] ?></td>			
			</tr>
			<tr>
				<td colspan="3">TELÉFONOS</td>
        <td colspan="4"><?php echo $row_Recordset1['telefono'] ?></td>
				<td colspan="3">DIRECCIÓN</td>
        <td colspan="5"><?php echo $row_Recordset1['direccion'] ?></td>			
			</tr>
      <tr>				
        <td colspan="3">DEPARTAMENTO</td>
        <td colspan="4">
					<?php echo $departamentos[$row_Recordset1['departamento']]?>
        </td>
        <td colspan="3">MUNICIPIO</td>
        <td colspan="5">
					<?php echo $municipios[$row_Recordset1['ciudad']]?>
        </td>
      </tr>
      <tr>
        <td colspan="3">REPRESENTANTE LEGAL</td>
        <td colspan="4"><?php echo $row_Recordset1['replegal'] ?></td>
        <td colspan="3">CONTACTO</td>
        <td colspan="5"><?php echo $row_Recordset1['contacto'] ?></td>
        </tr>
      <tr>
      	<td colspan="3">CELULAR</td>
        <td colspan="4"><?php echo $row_Recordset1['celular'] ?></td>
				<td colspan="3">F. DE CONSTITUCIÓN</td>
        <td colspan="5" align="center"><?php echo fechaactual3($row_Recordset1['fconstitucion']) ?></td>
      </tr>
      <tr>				
        <td colspan="3">REGIMEN AL CUAL PERTENECE</td>
        <td colspan="4">
					<?php
					if($row_Recordset1['regimen']==1){
						echo 'Responsable de IVA (Comun)';
					}else if($row_Recordset1['regimen']==2){
						echo 'NO Responsable de IVA (Simplificado)';
					}
					?>
				</td>
        <td colspan="3">DECLARANTE DE RENTA</td>
        <td colspan="5" align="center"><?php echo $declarante1?></td>
      </tr>
      <tr>
        <td colspan="3">GRAN CONTRIBUYENTE</td>
        <td colspan="4" align="center">
					<?php echo $granc1?>
				</td>
        <td colspan="3">AUTORETENEDOR</td>
        <td colspan="5" align="center">
					<?php echo $autoret1?>
				</td>
			</tr>
			<tr>
				<td colspan="3">CLASIFICACION PROVEEDOR</td>
				<td colspan="4">
					<?php echo $clasificacion[$row_Recordset1['IdSegmento']] ?>
				</td>
			</tr>
    </table>
    <br>
    <strong>INFORMACION BANCARIA</strong>
    <table border="1" class="tablita Arial14" align="center">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
			<col width="75">
      <col width="75">
      <col width="37">
      <col width="37">
      <col width="75">
      <tr>
        <td colspan="3">BANCO</td>
        <td colspan="4">
					<?php echo $bancos[$row_Recordset1['IdBanco']];?>
        </td>
        <td colspan="3">CLASE DE CUENTA</td>
        <td colspan="5">
					<?php 
					if($row_Recordset1['clasecuenta']==1){
						echo 'AHORROS';
					}else if($row_Recordset1['clasecuenta']==2){
						echo 'CORRIENTE';
					}else if($row_Recordset1['clasecuenta']==3){
						echo 'DEPOSITO ELECTRONICO';
					}
					?>
        </td>
      </tr>
      <tr>
        <td colspan="3">No de Cuenta</td>
        <td colspan="4"><?php echo $row_Recordset1['cuenta'] ?></td>
        <td colspan="8"></td>
      </tr>  
    </table>
		<br>
    <strong>DOCUMENTOS (Los documentos deben estar en formato PDF y con un tamaño máximo de 2500 Kb)</strong>
    <table cellspacing="0" cellpadding="0" class="tablita Arial14" border="1">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <col width="75">
      <tr>
        <td colspan="8" align="center"><strong>DOCUMENTOS MINIMOS REQUERIDOS</strong> </td>
        <td colspan="2" align="center"><strong></strong> </td>
      </tr>
      <tr>
        <td colspan="8">Fotocopia del RUT</td>
				<td colspan="2" align="center">
					<?php 
					if($row_Recordset1['rut']){
						?>
						<a href="<?php echo $row_Recordset1['rut'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documneto</a>
						<input type="hidden" name="rutA" value="<?php echo $row_Recordset1['rut'] ?>">
						<?php
					}else{
						?>
						Sin documento	
						<?php
					}
					?>			
				</td>
        
      </tr>
      <tr>
        <td colspan="8">Fotocopia de la Cédula de Ciudadanía de Personas Naturales/Representante Legal.</td>
				<td colspan="2" align="center">
					<?php 
					if($row_Recordset1['fotced']){
						?>
						<a href="<?php echo $row_Recordset1['fotced'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documneto</a>	
						<?php
					}else{
						?>
						Sin documento	
						<?php
					}
					?>
          <input type="hidden" name="fotcedA" value="<?php echo $row_Recordset1['fotced'] ?>">					
				</td>
        
      </tr>
      <tr>
        <td colspan="8">Certificado de Cámara de Comercio con Vigencia inferior a 30 días para Entes Jurídicos.</td>
				<td colspan="2" align="center">
					<?php 
					if($row_Recordset1['camcom']){
						?>
						<a href="<?php echo $row_Recordset1['camcom'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documneto</a>
						<input type="hidden" name="camcomA" value="<?php echo $row_Recordset1['camcom'] ?>">
						<?php
					}else{
						?>
						Sin documento	
						<?php
					}
					?>          					
				</td>
      </tr>
      <tr>
        <td colspan="8">Fotocopia de la Resolución de Facturación para quien este obligado</td>
				<td colspan="2" align="center">
					<?php 
					if($row_Recordset1['fotresfac']){
						?>
						<a href="<?php echo $row_Recordset1['fotresfac'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documneto</a>
            <input type="hidden" name="fotresfacA" value="<?php echo $row_Recordset1['fotresfac'] ?>">	
						<?php
					}else{
						?>
						Sin documento	
						<?php
					}
					?>          				
				</td>
      </tr>
      <tr>
        <td colspan="8">Certificación Bancaria </td>
				<td colspan="2" align="center">
					<?php 
					if($row_Recordset1['certbanc']){
						?>
						<a href="<?php echo $row_Recordset1['certbanc'] ?>" class="btn btn-rosa btn-xs1 " target="_blank">Ver documneto</a><input type="hidden" name="certbancA" value="<?php echo $row_Recordset1['certbanc'] ?>">	
						<?php
					}else{
						?>
						Sin documento	
						<?php
					}
					?>					
				</td>
      </tr>
			<tr id="docauto" style="display:">
        <td colspan="8">Documento de autoevaluación del SG SST emitido por la ARL</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['docauto']){
            ?>
            <a href="<?php echo $row_Recordset1['docauto'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="docautoA" value="<?php $row_Recordset1['docauto'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="resacr" style="display:">
        <td colspan="8">Resolución de acreditación NTC-ISO/IEC 17025 vigente.</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['resacr']){
            ?>
            <a href="<?php echo $row_Recordset1['resacr'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="resacrA" value="<?php $row_Recordset1['resacr'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="fictecnica" style="display:">
        <td colspan="8">Ficha tecnica o  de seguridad</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['fictecnica']){
            ?>
            <a href="<?php echo $row_Recordset1['fictecnica'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="fictecnicaA" value="<?php $row_Recordset1['fictecnica'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="cercalidad" style="display:">
        <td colspan="8">Certificado de calidad</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['cercalidad']){
            ?>
            <a href="<?php echo $row_Recordset1['cercalidad'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="cercalidadA" value="<?php $row_Recordset1['cercalidad'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="cercalibra" style="display:">
        <td colspan="8">Certificado de calibración</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['cercalibra']){
            ?>
            <a href="<?php echo $row_Recordset1['cercalibra'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="cercalibraA" value="<?php $row_Recordset1['cercalibra'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="licsegur" style="display:">
        <td colspan="8">Licencia de Seguridad y Salud en el Trabajo de la IPS</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['licsegur']){
            ?>
            <a href="<?php echo $row_Recordset1['licsegur'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="licsegurA" value="<?php $row_Recordset1['licsegur'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="lislabora" style="display:">
        <td colspan="8">Listado de Laboratorios Autorizados por el Instituto Nacional de Salud (INS).</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['lislabora']){
            ?>
            <a href="<?php echo $row_Recordset1['lislabora'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="lislaboraA" value="<?php $row_Recordset1['lislabora'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="regedu" style="display:">
        <td colspan="8">Registro educativo</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['regedu']){
            ?>
            <a href="<?php echo $row_Recordset1['regedu'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="regeduA" value="<?php $row_Recordset1['regedu'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="ficdot" style="display:">
        <td colspan="8">Fichas técnicas de las dotaciones y EPP.</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['ficdot']){
            ?>
            <a href="<?php echo $row_Recordset1['ficdot'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="ficdotA" value="<?php $row_Recordset1['ficdot'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="licamb" style="display:">
        <td colspan="8">Licencia ambiental de funcionamiento</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['licamb']){
            ?>
            <a href="<?php echo $row_Recordset1['licamb'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="licambA" value="<?php $row_Recordset1['licamb'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="psev" style="display:">
        <td colspan="8">Plan Estratégico de Seguridad Vial - PESV</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['psev']){
            ?>
            <a href="<?php echo $row_Recordset1['psev'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="psevA" value="<?php $row_Recordset1['psev'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="licfunci" style="display:">
        <td colspan="8">Licencia de funcionamiento vigente</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['licfunci']){
            ?>
            <a href="<?php echo $row_Recordset1['licfunci'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="licfunciA" value="<?php $row_Recordset1['licfunci'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
      <tr id="tarpropsi" style="display:">
        <td colspan="8">Tarjeta profesional en Psicología.</td>
        <td colspan="2" align="center">
          <?php
          if($row_Recordset1['tarpropsi']){
            ?>
            <a href="<?php echo $row_Recordset1['tarpropsi'] ?>" class="btn btn-rosa btn-xs1" target="_blank">Ver documento</a>
            <input type="hidden" name="tarpropsiA" value="<?php $row_Recordset1['tarpropsi'] ?>">
            <?php
          }else{
            ?>
            Sin Documento
            <?php
          }
          ?>
        </td>
      </tr>
    </table>
    <br>
	<br>
	<h5 align="center" class="Century">EVALUACIONES</h5>
	
	<?php 
	if($totalRows_Recordset5>0){
		?>
		<table border="1" class="tablita Arial14" align="center">
			<col width="100px">
			<col width="100px">
			<tr class="titulos">
				<td>AÑO</td>
				<td>EVALUCION</td>
			</tr>
			<?php 
			do{
				?>
				<tr>
					<td align="center">
						<?php echo $row_Recordset5['ano'] ?>	
					</td>
					<td align="right">
						<?php echo number_format($row_Recordset5['promedio'],2) ?>
					</td>			
				</tr>
				<?php				
			}while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
			?>			
		</table>	
		<?php
	}else{
		?>
		<h6 align="center" class="Century">NO HAY ORDENES DE COMPRAS</h6>
		<?php
	}
	?>		
			
	
</div>
<?php
include('footer.php')
?>
<script>
  	window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
	}, false);

	document.addEventListener('DOMContentLoaded', () => {
    
    var IdSegmento = <?php echo $row_Recordset1['IdSegmento'] ? $row_Recordset1['IdSegmento'] : 0 ?>;
    

    asignaDocs(IdSegmento)
		       		
	})

	function asignaDocs(id){
		
		document.getElementById('docauto').style.display='none';
    document.getElementById('resacr').style.display='none';
    document.getElementById('fictecnica').style.display='none';
    document.getElementById('cercalidad').style.display='none';
    document.getElementById('cercalibra').style.display='none';
    document.getElementById('licsegur').style.display='none';
    document.getElementById('lislabora').style.display='none';
    document.getElementById('regedu').style.display='none';
    document.getElementById('ficdot').style.display='none';
    document.getElementById('licamb').style.display='none';
    document.getElementById('psev').style.display='none';
    document.getElementById('licfunci').style.display='none';
    document.getElementById('tarpropsi').style.display='none';

    if(id==2 || id==16 || id==18){
      document.getElementById('docauto').style.display='';
    }
    if(id==3 || id==9){
      document.getElementById('resacr').style.display='';
    }
    if(id==5){
      document.getElementById('docauto').style.display='';
      document.getElementById('resacr').style.display='';
    }
    if(id==6){
      document.getElementById('fictecnica').style.display='';
      document.getElementById('cercalidad').style.display='';
    }
    if(id==7){
      document.getElementById('cercalidad').style.display='';
    }
    if(id==8){
      document.getElementById('fictecnica').style.display='';
      document.getElementById('cercalibra').style.display='';
    }
    
    if(id==10 || id==12){
      document.getElementById('docauto').style.display='';
      document.getElementById('licsegur').style.display='';
    }
    if(id==11){
      document.getElementById('lislabora').style.display='';
    }
    
    if(id==13){
      document.getElementById('docauto').style.display='';
      document.getElementById('regedu').style.display='';
    }
    if(id==14 || id==15){
      document.getElementById('docauto').style.display='';
      document.getElementById('licamb').style.display='';
      document.getElementById('psev').style.display='';
    }
    
    if(id==17){
      document.getElementById('docauto').style.display='';
      document.getElementById('psev').style.display='';
    }
    
    if(id==19){
      document.getElementById('licfunci').style.display='';
    }
    if(id==20){
      document.getElementById('tarpropsi').style.display='';
    }
    if(id==21){
      document.getElementById('fictecnica').style.display='';
    }
    if(id==22){
      document.getElementById('ficdot').style.display='';
    }
		
	}
  function selmun(){
    var municipio = <?php echo $row_Recordset1['ciudad'] ?>;
    // document.getElementById('municipio').value=id;
    $("#municipio option[value="+municipio+"]").attr("selected",true);
    document.getElementById('municipio').value=municipio;
  }

  function buscamun(IdDepartamento){
		var datos = new FormData();
		datos.append("IdDepartamento",IdDepartamento);
		datos.append("proced",33);
		
		$.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
					var res = respuesta.trim();
					var arregloTabla = JSON.parse(respuesta);
          var municipios = document.getElementById('municipio')
					$('#municipio').html('');
          var option = document.createElement("option");
          option.text = 'Seleccione Municipio';
          municipios.add(option);
					Object.keys(arregloTabla).forEach(key => {
            var option = document.createElement("option");
            option.value = key
            option.text = arregloTabla[key];
            municipios.add(option);
					});
				}
			});
	}

	function validaArchivo(archivo,id){
		if((archivo[0]["size"] > 3000000) || (archivo[0]["type"]!="application/pdf") ){
			document.getElementById(id).value='';
			document.getElementById(id).focus();
			swal({
					title: "Error al subir el archivo",
					text: "¡El archivo no debe pesar más de 2.500K y ser en formato PDF!",
					type: "error",
					confirmButtonText: "¡Cerrar!"
			});
			return;
		}
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
</script>
<?php
mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);
?>
