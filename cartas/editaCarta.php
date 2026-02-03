<?php 
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";
require_once('../connections/datos.php');
$buscaCarta =  "SELECT 
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
                  firma,
                  email,
                  cartas.IdFirma,
                  ano,
                  consAno,
                  consello
                FROM
                    (cartas
                    LEFT JOIN firmas ON cartas.Idfirma = firmas.Idfirma)
                WHERE IdCarta=".$_GET['carta'];
$resultadoCarta = mysql_query($buscaCarta, $datos) or die(mysql_error());
$filaCarta = mysql_fetch_assoc($resultadoCarta);
$totalfilas_buscaCarta = mysql_num_rows($resultadoCarta);

$buscaParrafos = "SELECT 
                      IdParrafo, IdCarta, parrafo, titulo
                  FROM
                      parrafoscartas
                  WHERE
                      IdCarta = ".$_GET['carta'];
$resultadoParrafos = mysql_query($buscaParrafos, $datos) or die(mysql_error());
$filaParrafos = mysql_fetch_assoc($resultadoParrafos);
$totalfilas_buscaParrafos = mysql_num_rows($resultadoParrafos);

$buscaAnexos = "SELECT 
                    IdAnexo,
                    nombre,
                    vinculo
                FROM
                    anexoscartas
                WHERE
                    IdCarta = ".$_GET['carta']."  ";
$resultadoAnexos = mysql_query($buscaAnexos, $datos) or die(mysql_error());
$filaAnexos = mysql_fetch_assoc($resultadoAnexos);
$totalfilas_buscaAnexos = mysql_num_rows($resultadoAnexos);

$buscaCop = " SELECT 
                  IdCopiado,
                  nombre
              FROM
                  copiados
              WHERE
                  IdCarta = ".$_GET['carta']."  ";
$resultadoCop = mysql_query($buscaCop, $datos) or die(mysql_error());
$filaCop = mysql_fetch_assoc($resultadoCop);
$totalfilas_buscaCop = mysql_num_rows($resultadoCop);
?>
<?php 
include('encabezado.php')
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    cargaFirmas();
    consello();

  });

  function agregaParrafo(){
    var parrafosExistentes = parseInt(<?php echo $totalfilas_buscaParrafos ?>);
    var nparrafos = parseInt(document.getElementById('nParrafos').innerHTML);
    nparrafos++;

    var fila='<td><div class="grid columna-3"><div class="span-1"></div>'+
              '<div class="span-1">'+
                '<input type="text" class="campo-xs Arial14 tituloParrafo" name="tituloParrafo['+nparrafos+']" id="tituloParrafo-'+nparrafos+'" placeholder="Titulo del parrafo '+nparrafos+'" style="text-align:center;font-weight;bold;margin-bottom:2px" onBlur="aMayusculas(this.value,this.id)">'+
              '</div>'+
              '<div class="span-1"></div></div>'+     
              '<textarea name="parrafo['+nparrafos+']" class="txtarea parrafo" placeholder="Ingrese el parrafo '+nparrafos+'" style="margin-bottom:3px"></textarea></td>'+
              '<td align="center"><img src="../imagenes/borrar.png" width="15px" alt="" style="cursor: pointer" onclick="deleteRow(this)"></td>';
    
            
    document.getElementById('nParrafos').innerHTML=nparrafos;
    document.getElementById("parrafos").insertRow(-1).innerHTML = fila;
    
  }

  function deleteRow1(btn,Id) { 
    var row = btn.parentNode.parentNode; 
    row.parentNode.removeChild(row);

    var borrados = document.getElementById('borrados').value;

    if(borrados==""){
      borrados = Id;
    }else{
      borrados += ","+Id
    }

    document.getElementById('borrados').value=borrados;
    // recuento()
  }

  function deleteRow(btn) { 
    var row = btn.parentNode.parentNode; 
    row.parentNode.removeChild(row);

    var a=parseFloat(document.getElementById('nParrafos').innerHTML);
    a=a-1;
    document.getElementById('nParrafos').innerHTML=a;

    recuento()
  }

  function recuento(){

    var parrafosAnteriores = <?php echo $totalfilas_buscaParrafos ?>;
    var nparrafos = document.getElementById('nParrafos').innerHTML;

    var tituloParrafo = document.querySelectorAll('.tituloParrafo');
    var parrafo = document.querySelectorAll('.parrafo');

    for(var i=0;i<parrafo.length;i++){

      var y =i+parrafosAnteriores+1;

      tituloParrafo[i].setAttribute("name", 'tituloParrafo['+(y)+"]");
      parrafo[i].setAttribute("name", 'parrafo['+(y)+"]");

      tituloParrafo[i].setAttribute("id", 'tituloParrafo-'+(y));
      parrafo[i].setAttribute("id", 'parrafo-'+(y));

      tituloParrafo[i].setAttribute("placeholder", 'Titulo del parrafo '+(y));
      parrafo[i].setAttribute("placeholder", 'Ingrese el parrafo '+(y));
            
    }

  }

  <?php echo $totalfilas_buscaParrafos ?>

  function agregaAnexo(){
    var nanexos = document.getElementById('nAnexos').innerHTML;
    nanexos++;

    const div1 = document.createElement("div");
    div1.classList.add("span-1");
    const div2 = document.createElement("div");
    div1.classList.add("span-1");

    const input1 = document.createElement("input");
    input1.setAttribute("name", "anexo["+nanexos+"]");
    input1.setAttribute("id", "anexo-"+nanexos+"");
    input1.setAttribute("type", "file");
    input1.setAttribute("onChange", "validarArchivo(this.files,this.id)");
    input1.classList.add("campo-xs");
    input1.classList.add("Arial12");

    const input2 = document.createElement("input");
    input2.setAttribute("name", "nombre["+nanexos+"]");
    input2.setAttribute("id", "id-"+nanexos);
    input2.setAttribute("onBlur", "aMayusculas(this.value,this.id)");
    input2.classList.add("campo-xs");
    input2.classList.add("Arial12");
    input2.setAttribute("placeholder", "Ingrese el nombre de archivo");

    div1.appendChild(input1);
    div2.appendChild(input2);

    var padre = document.getElementById('anexos');

    padre.appendChild(div1);
    padre.appendChild(div2);
    
    document.getElementById('nAnexos').innerHTML=nanexos;
    
  }

  function validarArchivo(archivo,item){

    // 1. Definimos los tipos permitidos (PDF, Word y Excel)
    const tiposPermitidos = [
        "application/pdf", 
        "application/msword",                                                        // .doc
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",   // .docx
        "application/vnd.ms-excel",                                                  // .xls
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"          // .xlsx
    ];

    // 2. Verificamos si es una imagen (cualquier formato: jpg, png, gif, etc.)
    const esImagen = archivo[0]["type"].startsWith("image/");

          
    if((archivo[0]["size"] > 1000000) || (!tiposPermitidos.includes(archivo[0]["type"]) && !esImagen) ){
          
      $("#"+item).val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1MB y ser en formato PDF, DOCX o XLSX!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
    }
  }

  function validarArchivo2(archivo,item){
    console.log((archivo[0]["type"]))
          
    if((archivo[0]["size"] > 1000000) || (archivo[0]["type"]!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") ){
          
      $("#"+item).val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1MB y ser en formato docx!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
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

  function aMayusculas(obj,id){
    obj = obj.toUpperCase();
    document.getElementById(id).value = obj;
  }

  function muestraFirmas(){
    $('#mfirmas').modal({backdrop: 'static', keyboard: false});
  }

  function cargaFirmas(){
    var usuario = <?php echo $usuario ?>;
    var datos = new FormData();
    datos.append("usuario",usuario);
		datos.append("proced",1);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          var res = respuesta.trim();
          $('#galFirmas').html(res)
				}
			});
    
  }

  function subeFirma(){
    var firma = document.getElementById('m-firma').files[0];
    var usuario = <?php echo $usuario ?>;

    if(!firma){
			document.getElementById('m-firma').focus();
			swal({
				 html: '¡Debe seleccionar la firma!',
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
    datos.append("usuario",usuario);
    datos.append("firma",firma);
    datos.append("proced",2);

    $.ajax({
				url:"ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
          var res = respuesta.trim();
          if(res=='ok'){
            document.getElementById('m-firma').value='';
            cargaFirmas()
          }
				}
			});
  }

  function validarArchivo1(archivo){
          
    if((archivo[0]["size"] > 600000) || (archivo[0]["type"]!="image/png") ){
          
      $("#m-firma").val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 500B y ser en formato PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
    }
  }

  function seleccionaFirma(valor){
    console.log(valor);
    $('#mfirmas').modal('hide');
    $('#firma').html('<img src="../firmas/firma-'+valor+'.png" width="200px" >');
    $('#IdFirma').val(valor);

  }

  function consello(){
    var consello = <?php echo $filaCarta['consello'] ?>;

    if(consello==1){
      document.getElementById('consello-si').checked=1;
    }
    if(consello==0){
      document.getElementById('consello-no').checked=1;
    }
  }

  function eliminaAnexo(id){
    
    var anexosEliminados = document.getElementById('anexosEliminados').value;
    if(anexosEliminados){
      anexosEliminados=anexosEliminados+','+id
    }else{
      anexosEliminados=anexosEliminados+id
    }
    document.getElementById('anexosEliminados').value=anexosEliminados
    document.getElementById('filaAnexo-'+id).style.display='none';
    
  }

  function eliminaCopiado(id){

    var copiadosEliminados = document.getElementById('copiadosEliminados').value;

    if(copiadosEliminados){
      copiadosEliminados=copiadosEliminados+','+id
    }else{
      copiadosEliminados=copiadosEliminados+id
    }
    document.getElementById('copiadosEliminados').value=copiadosEliminados
    document.getElementById('filaCopiado-'+id).style.display='none';

  }

  function agregaCopiado(){
    var ncopiados = document.getElementById('nCopiados').innerHTML;
    ncopiados++;

    const div1 = document.createElement("div");
    div1.classList.add("span-1");
    const div2 = document.createElement("div");
    div1.classList.add("span-1");

    const input1 = document.createElement("input");
    input1.setAttribute("name", "copiado["+ncopiados+"]");
    input1.setAttribute("id", "copiado-"+ncopiados+"");
    input1.setAttribute("type", "text");
    input1.setAttribute("onBlur", "aMayusculas(this.value,this.id)");
    input1.classList.add("campo-xs");
    input1.classList.add("Arial12");
    input1.setAttribute("placeholder", "Ingrese el nombre");

    const input2 = document.createElement("input");
    input2.setAttribute("name", "ccopiado["+ncopiados+"]");
    input2.setAttribute("id", "ccopiado-"+ncopiados);
    // input2.setAttribute("onBlur", "aMayusculas(this.value,this.id)");
    input2.classList.add("campo-xs");
    input2.classList.add("Arial12");
    input2.setAttribute("placeholder", "Ingrese el correo");

    div1.appendChild(input1);
    div2.appendChild(input2);

    var padre = document.getElementById('copiados');

    padre.appendChild(div1);
    padre.appendChild(div2);
    
    document.getElementById('nCopiados').innerHTML=ncopiados;
    
  }
</script>
<style>
  .div-radio input[type="radio"]{
    display: none
  }

  .div-radio label {
    font-family: Arial;
    font-size: 14px;
    margin: 0;
    width: 100%;
    /* background: rgba(0,0,0,.1); */
    /* padding: 0 10px 0 24px;
    display: inline-block; */
    position: relative;
    border-radius: 3px;
    cursor: pointer;
		padding: 0 0; 
    display: flex;
    justify-content: center;
    -webkit-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
		
  }

	.div-radio label:before{
    /* content: "";
    width: 14px;
    height: 14px;
    display: inline-block;
    background: none;
    border: 1px solid #000;
    border-radius: 50%;
    position: absolute;
    left: 5px;
    top: 3px; */
  }
  
  .div-radio input[type="radio"]:checked + label{
    background: #FF9E7E;
    padding: 0 0; 
    display: flex;
    justify-content: center;
    
  }
  
  .div-radio input[type="radio"]:checked + label:before{
    /*background: #007bff;
    border: 1px solid #007bff;*/
    display: none;
  }
</style>
<?php 
include('encabezado1.php')
?>
<br>
<div class="contenedor" style="width:800px">
  <h5 class="Century" align="center">EDICION DE CARTAS</h5>
  <br>
  <form action="graba.php" method="post" enctype="multipart/form-data" onSubmit="bloquear('boton')">
    <div class="grid columna-2">
      <div class="span-1">
        Bogotá D.C., <?php echo fechaactual6(date("Y-m-d")) ?>
      </div>
      <div class="span-1" align="right">
        <strong>CPA-<?php  echo sprintf("%03d",$filaCarta['consAno'])."-". $filaCarta['ano'] ?></strong>
      </div>
    </div>
    
    <br><br>
    Señor(es)
    <div style="width:350px">
      <input type="text" name="destinatario1" id="destinatario1" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el destinatario" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaCarta['destinatario1'] ?>" required>
      <input type="text" name="destinatario2" id="destinatario2" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el destinatario" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaCarta['destinatario2'] ?>">
      <input type="text" name="destinatario3" id="destinatario3" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el destinatario" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaCarta['destinatario3'] ?>">
      <input type="text" name="destinatario4" id="destinatario4" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese la ciudad" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaCarta['destinatario4'] ?>" required>
      <input type="text" name="email" id="email" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="email de envio" value="<?php echo $filaCarta['email'] ?>">
    </div>
    <br><br>
    <div class="grid columna-7">
      <div class="span-1">
        <strong>Referencia:</strong>
      </div>
      <div class="span-5">
        <textarea name="asunto" id="asunto" class="txtarea" onBlur="aMayusculas(this.value,this.id)" required><?php echo $filaCarta['asunto'] ?></textarea>
      </div>
      <div class="span-1"></div>
    </div>  
    <br><br>
    Agradecemos su atención.
    <div>
      <!-- <button type="button" class="btn btn-verde btn-xs" onClick="muestraFirmas()">Seleccione la firma</button> -->
    </div>
    <div id="firma" style="padding:5px">
      <img src="<?php echo $filaCarta['firma'] ?>" width="220">
    </div>    
    <input type="hidden" name="IdFirma" id="IdFirma" value="<?php echo $filaCarta['IdFirma'] ?>">
    Atentamente,    
    <div style="width:350px">
      <input type="text" name="firmante" id="firmante" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el firmante" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaCarta['firmante'] ?>" required>
      <input type="text" name="cargo" id="cargo" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el cargo" onBlur="aMayusculas(this.value,this.id)" value="<?php echo $filaCarta['cargo'] ?>" required>
    </div>    
    CPA INGENIERIA S.A.S.<br>
    Con sello:
    <div class="grid columna-2" style="max-width:300px">
      <div class="span-1 div-radio">
        <input type="radio" name="consello" id="consello-si" value="1" >
        <label for="consello-si">Sí</label>
      </div>
      <div class="span-1 div-radio">
        <input type="radio" name="consello" id="consello-no" value="0" >
        <label for="consello-no">No</label>
      </div>
    </div>
    <?php 
    if($totalfilas_buscaAnexos>0){
      ?>
      ANEXOS:(Formatos docx, xlsx o pdf max 1MB)
      <table class="tablita Arial14" style="width:500px">
      <?php
      do{
        ?>
        <tr id="filaAnexo-<?php echo $filaAnexos['IdAnexo'] ?>">
          <td>
            <?php echo $filaAnexos['nombre'] ?>
          </td>
          <td>
            <a href="<?php echo $filaAnexos['vinculo'] ?>" class="btn btn-rosa btn-xs1 " target="_blanck" >Ver anexo</a>
          </td>
          <td>
            <button type="button" class="btn btn-rojo btn-xs1 " onClick="eliminaAnexo(<?php echo $filaAnexos['IdAnexo'] ?>)">Eliminar anexo</button>
          </td>
        </tr>
        <?php
      }while($filaAnexos = mysql_fetch_assoc($resultadoAnexos));
      ?>
      </table>
      <input type="hidden" id="anexosEliminados" name="anexosEliminados" >
      <?php
    }else{
      ?>
      <div class="Arial14">
        <br>
        ANEXOS:(Formatos docx, xlsx o pdf max 1MB)<br> 
      </div>
      <?php
    }
    ?>
    <span id="nAnexos" style="display:none" >1</span>
    <div style="width:700px" class="grid columna-2" id="anexos">
      <div class="span-1">
        <input type="file" name="anexo[1]" id="anexo-1"  class="campo-xs Arial12" onChange="validarArchivo(this.files,this.id)" >
      </div>
      <div class="span-1">
        <input type="text" name="nombre[1]" id="nombre-1" class="campo-xs Arial12" placeholder="Ingrese el nombre de archivo" onBlur="aMayusculas(this.value,this.id)">
      </div>      
    </div>
    <button type="button" class="btn btn-verde btn-xs" onClick="agregaAnexo()" >Agregar anexo</button>
    <br>
    <br>
    Personas a quien copiar la carta
    <?php 
    if($totalfilas_buscaCop>0){
      ?>
      <table class="tablita Arial14" style="width:500px">
        <?php 
        do{
          ?>
          <tr id="filaCopiado-<?php echo $filaCop['IdCopiado'] ?>">
            <td>
              <?php echo $filaCop['nombre'] ?>
            </td>
            <td>
              <button type="button" class="btn btn-rojo btn-xs1 " onClick="eliminaCopiado(<?php echo $filaCop['IdCopiado'] ?>)">Eliminar persona</button>
            </td>
          </tr>
          <?php
        }while ($filaCop = mysql_fetch_assoc($resultadoCop));
        ?>
      </table>
      <input type="hidden" id="copiadosEliminados" name="copiadosEliminados" >
      <?php
    }
    ?>
    <span id="nCopiados" style="display: none" >1</span>
    <div style="width:700px" class="grid columna-2" id="copiados">
      <div class="span-1">
        <input type="text" name="copiado[1]" id="copiado-1"  class="campo-xs Arial12" placeholder="Ingrese el nombre" onBlur="aMayusculas(this.value,this.id)" >
      </div>
      <div class="span-1">
        <input type="text" name="ccopiado[1]" id="ccopiado-1" class="campo-xs Arial12" placeholder="Ingrese el correo">
      </div>
    </div>
    <button type="button" class="btn btn-verde btn-xs" onClick="agregaCopiado()" >Agregar personas a copiar</button>
    <input type="hidden" name="IdCarta"  value="<?php echo $_GET['carta'] ?>">
    <br>
    <br>
    <div style="width:300px">
      Subir carta (En Word):
      <input type="file" name="carta"  id="carta" class="campo-xs Arial12" onChange="validarArchivo2(this.files,this.id)">
    </div>
    <div align="center">
      <button type="submit" class="btn btn-rosa btn-sm" name="boton2" id="boton" >Gabar</button>
      <div id="espera"></div>
    </div>
  </form>
</div>
<br><br><br><br>
<div id="mfirmas" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#d8d8d8; color:black">
          <h5 class="modal-title">Seleccione la firma</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
			<div class="modal-body" align="center">
				<div class="grid columna-4" id="galFirmas">
				</div>
        <div>
          Formato PNG max 500B
          <input type="file" name="m-firma" id="m-firma"  class="campo-xs Arial12" onChange="validarArchivo1(this.files)" >
          <br>
          <button type="button" class="btn btn-rosa btn-sm"  onClick="subeFirma()">Subir firma</button>
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
</body>
</html>