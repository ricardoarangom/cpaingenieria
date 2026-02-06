<?php 
require_once('../connections/datos.php');
$ano=date("Y");
$buscaCartas = "SELECT 
                    MAX(consAno) as ultimo
                FROM
                    cartas
                where ano=".$ano;
$resultadoCartas = mysql_query($buscaCartas, $datos) or die(mysql_error());
$filaCartas = mysql_fetch_assoc($resultadoCartas);
$totalfilas_buscaCartas = mysql_num_rows($resultadoCartas);

$buscaUsu = " SELECT 
                  nombre, apellido, IdUsuario
              FROM
                  usuarios 
                  WHERE
                  nivel <> 0
              ORDER BY nombre , apellido";
$resultadoUsu = mysql_query($buscaUsu, $datos) or die(mysql_error());
$filaUsu = mysql_fetch_assoc($resultadoUsu);
$totalfilas_buscaUsu = mysql_num_rows($resultadoUsu);
?>
<?php 
include('encabezado.php')
?>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    
    cargaFirmas();

  });

  function agregaParrafo(){
    var nparrafos = document.getElementById('nParrafos').innerHTML;
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

  function deleteRow(btn) { 
    var row = btn.parentNode.parentNode; 
    row.parentNode.removeChild(row);

    var a=parseFloat(document.getElementById('nParrafos').innerHTML);
    a=a-1;
    document.getElementById('nParrafos').innerHTML=a;

    recuento()
  }

  function recuento(){

    var nparrafos = document.getElementById('nParrafos').innerHTML;

    var tituloParrafo = document.querySelectorAll('.tituloParrafo');
    var parrafo = document.querySelectorAll('.parrafo');
    

    for(var i=0;i<nparrafos;i++){
      tituloParrafo[i].setAttribute("name", 'tituloParrafo['+(i+1)+"]");
      parrafo[i].setAttribute("name", 'parrafo['+(i+1)+"]");

      tituloParrafo[i].setAttribute("id", 'tituloParrafo-'+(i+1));
      parrafo[i].setAttribute("id", 'parrafo-'+(i+1));

      tituloParrafo[i].setAttribute("placeholder", 'Titulo del parrafo '+(i+1));
      parrafo[i].setAttribute("placeholder", 'ngrese el parrafo '+(i+1));
            
    }

  }

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

  function agregaCopiado(){
    // console.log('hola');
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

          
    if((archivo[0]["size"] > 8000000) || (!tiposPermitidos.includes(archivo[0]["type"]) && !esImagen) ){
          
      $("#"+item).val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1MB y ser en formato PDF, DOCX o XLSX!",
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
  <h5 class="Century" align="center">CREACION DE CARTAS</h5>
  <br>
  <form action="graba.php" method="post" enctype="multipart/form-data" onSubmit="bloquear('boton')">
    <div class="grid columna-2">
      <div class="span-1">
        Bogotá D.C., <?php echo fechaactual6(date("Y-m-d")) ?>
      </div>
      <div class="span-1" align="right">
        <strong>CPA-<?php  echo sprintf("%03d",$filaCartas['ultimo']+1)."-". date("Y") ?></strong>
      </div>
    </div>
    
    <br><br>
    Señor(es)
    <div style="width:350px">
      <input type="text" name="destinatario1" id="destinatario1" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese la empresa o persona" onBlur="aMayusculas(this.value,this.id)" required>
      <input type="text" name="destinatario2" id="destinatario2" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese la persona" onBlur="aMayusculas(this.value,this.id)">
      <input type="text" name="destinatario3" id="destinatario3" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el cargo" onBlur="aMayusculas(this.value,this.id)">
      <input type="text" name="destinatario4" id="destinatario4" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese la ciudad" onBlur="aMayusculas(this.value,this.id)" required>
      <input type="text" name="email" id="email" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="email de envio">
    </div>
    <br><br>
    <div class="grid columna-7">
      <div class="span-1">
        <strong>Referencia:</strong>
      </div>
      <div class="span-5">
        <textarea name="asunto" id="asunto" class="txtarea" onBlur="aMayusculas(this.value,this.id)" required></textarea>
      </div>
      <div class="span-1"></div>
    </div>  
    <br><br>
    Agradecemos su atención.
    <div style="max-width:300px">
      <!-- <button type="button" class="btn btn-verde btn-xs" onClick="muestraFirmas()">Seleccione la firma</button> -->
       Solicitar Autorización de firma a:
       <select name="IdAutorfirma" id="IdAutorfirma" class="campo-xs Arial12" required>
        <option value="">Seleccione</option>
        <?php 
        do{
          ?>
          <option value="<?php echo $filaUsu['IdUsuario'] ?>"><?php echo $filaUsu['nombre']." ".$filaUsu['apellido'] ?></option>
          <?php
        } while ($filaUsu = mysql_fetch_assoc($resultadoUsu));
        ?>

       </select>
    </div>
    <div id="firma" style="padding:5px"><br><br><br><br><br></div>    
    <input type="hidden" name="IdFirma" id="IdFirma">
    Atentamente,    
    <div style="width:350px">
      <input type="text" name="firmante" id="firmante" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el firmante" onBlur="aMayusculas(this.value,this.id)" required>
      <input type="text" name="cargo" id="cargo" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el cargo" onBlur="aMayusculas(this.value,this.id)" required>
    </div>
    
    CPA INGENIERIA S.A.S.<br>
    Con sello:
    <div class="grid columna-2" style="max-width:300px">
      <div class="span-1 div-radio">
        <input type="radio" name="consello" id="consello-si" value="1" >
        <label for="consello-si">Sí</label>
      </div>
      <div class="span-1 div-radio">
        <input type="radio" name="consello" id="consello-no" value="0" checked >
        <label for="consello-no">No</label>
      </div>
    </div>
    <div class="Arial12">
      <br>
      ANEXOS:(Formatos docx, xlsx o pdf max 1MB)<br> 
    </div>
    <span id="nAnexos" style="display: none" >1</span>
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
    <div class="Arial12">
      <br>
      Personas a quien copiar la carta<br> 
    </div>
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
    <div align="center">
      <button type="submit" class="btn btn-rosa btn-sm" name="boton1" id="boton" >Descarga Plantilla</button>
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