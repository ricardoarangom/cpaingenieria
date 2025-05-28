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

    const br = document.createElement("br");
    const txtarea = document.createElement("textarea");
    txtarea.setAttribute("name", "parrafo["+nparrafos+"]");
    txtarea.setAttribute("style", "margin-bottom:3px");
    txtarea.classList.add("txtarea");
    txtarea.setAttribute("placeholder", "Ingrese el parrafo "+nparrafos+"");
    
    var padre = document.getElementById('parrafos');

    // padre.appendChild(br)
    padre.appendChild(txtarea)
    
    document.getElementById('nParrafos').innerHTML=nparrafos;
    
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

  function validarArchivo(archivo,item){
          
    if((archivo[0]["size"] > 1000000) || (archivo[0]["type"]!="application/pdf") ){
          
      $("#"+item).val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 1MB y ser en formato PDF!",
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
        <input type="text" name="asunto" id="asunto"  class="campo-xs Arial14" onBlur="aMayusculas(this.value,this.id)" required>
      </div>
      <div class="span-1"></div>
    </div>  
    <br><br>
    <div style="width:300px">
      <input type="text" name="destinatario5" id="destinatario5" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Respetados Señores" required> 
    </div>
    <span id="nParrafos" style="display:none" >1</span>
    <div id="parrafos">
      <textarea name="parrafo[1]" class="txtarea" placeholder="Ingrese el parrafo 1" style="margin-bottom:3px"></textarea>
    </div>
    <button type="button" class="btn btn-verde btn-xs" onClick="agregaParrafo()" >Agregar parrafo</button>
    <br><br>
    Agradecemos su atención.
    <div>
      <button type="button" class="btn btn-verde btn-xs" onClick="muestraFirmas()">Seleccione la firma</button>
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
      ANEXOS:(Formato PDF max 1MB)<br> 
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
    <br>
    <button type="button" class="btn btn-verde btn-xs" onClick="agregaAnexo()" >Agregar anexo</button>
    <div align="center">
      <button type="submit" class="btn btn-rosa btn-sm" name="boton1" id="boton" >Gabar</button>
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