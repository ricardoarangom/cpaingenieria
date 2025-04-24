<?php 
require_once('../connections/datos.php');
$buscaCartas = "SELECT 
                    MAX(IdCarta) as ultimo
                FROM
                    cartas;";
$resultadoCartas = mysql_query($buscaCartas, $datos) or die(mysql_error());
$filaCartas = mysql_fetch_assoc($resultadoCartas);
$totalfilas_buscaCartas = mysql_num_rows($resultadoCartas);
?>
<?php 
include('encabezado.php')
?>
<script>

  function agregaParrafo(){
    var nparrafos = document.getElementById('nParrafos').innerHTML;
    nparrafos++;

    const br = document.createElement("br");
    const txtarea = document.createElement("textarea");
    txtarea.setAttribute("name", "parrafo["+nparrafos+"]");
    txtarea.classList.add("txtarea");
    txtarea.setAttribute("placeholder", "Ingrese el parrafo "+nparrafos+"");
    
    var padre = document.getElementById('parrafos');

    padre.appendChild(br)
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
</script>
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
    Señores
    <div style="width:350px">
      <input type="text" name="destinatario1" id="destinatario1" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el destinatario" onBlur="aMayusculas(this.value,this.id)">
      <input type="text" name="destinatario2" id="destinatario2" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el destinatario" onBlur="aMayusculas(this.value,this.id)">
      <input type="text" name="destinatario3" id="destinatario3" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el destinatario" onBlur="aMayusculas(this.value,this.id)">
    </div>
    <br><br>
    <div class="grid columna-7">
      <div class="span-1">
        <strong>Referencia:</strong>
      </div>
      <div class="span-5">
        <input type="text" name="asunto" id="asunto"  class="campo-xs Arial14" onBlur="aMayusculas(this.value,this.id)">
      </div>
      <div class="span-1"></div>
    </div>  
    <br><br>
    <strong>Respetados señores</strong>
    <br>
    <span id="nParrafos" style="display:none" >1</span>
    <div id="parrafos">
      <textarea name="parrafo[1]" class="txtarea" placeholder="Ingrese el parrafo 1"></textarea>
    </div>
    <button type="button" class="btn btn-verde btn-xs" onClick="agregaParrafo()" >Agregar parrafo</button>
    <br><br>
    Agradecemos su atención.
    <br><br>
    Atentamente,
    <br><br><br>
    <div style="width:350px">
      <input type="text" name="firmante" id="firmante" class="campo-xs Arial14" style="margin-bottom:3px" placeholder="Ingrese el firmante" onBlur="aMayusculas(this.value,this.id)">
    </div>
    CPA INGENIERIA S.A.S.<br>
    <div class="Arial12">
      Responder:<br>
      ANEXOS:(Formato PDF max 1MB)<br> 
    </div>
    <span id="nAnexos" style="display: none" >1</span>
    <div style="width:700px" class="grid columna-2" id="anexos">
      <div class="span-1">
        <input type="file" name="anexo[1]" id="anexo-1"  class="campo-xs Arial12" onChange="validarArchivo(this.files,this.id)" >
      </div>
      <div class="span-1">
        <input type="text" name="nombre[1]" class="campo-xs Arial12" placeholder="Ingrese el nombre de archivo" >
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

</body>
</html>