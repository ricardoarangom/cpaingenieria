<?php 
require_once('../connections/datos.php');


include('encabezado.php');

$buscaArea = "SELECT 
									*
							FROM
									areas  ORDER BY area";
$resultadoArea = mysql_query($buscaArea, $datos) or die(mysql_error());
$filaArea = mysql_fetch_assoc($resultadoArea);
$totalfilas_buscaArea = mysql_num_rows($resultadoArea);
?>
<script>
  function bloquear(id){
    document.getElementById(id).style.display='none'
    $(".espera").html(`
        <center>
          <img src="../imagenes/status.gif" id="status" />
          <br>
        </center>
                `);
  }

  function validarArchivo(archivo,item){
          
    if((archivo[0]["size"] > 2000000) || (archivo[0]["type"]!="application/pdf") ){
          
      $("#"+item).val("");
      
      swal({
          title: "Error al subir el archivo",
          text: "¡El archivo no debe pesar más de 2MB y ser en formato PDF!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
    }
  }
</script>

<?php 
include('encabezado1.php')
?>
<br>
<div class="contenedor"  style="width:1000px">
  <h5 class="Century" align="center">REGISTRAR CORRESPONDENCIA RECIBIDA</h5>
  <br>
  <form action="graba.php" method="post" enctype="multipart/form-data" onSubmit="bloquear('boton')">
    <div class="grid columna-4">    
      <div class="span-1">
        Proyecto / Area:
        <select name="IdArea" id="IdArea" class="campo-sm" style="font-size:12px" required>
          <option value="">Seleccione</option>
          <?php 
          do{
            ?>
            <option value="<?php echo  $filaArea['IdArea'] ?>"><?php echo  $filaArea['area'] ?></option>
            <?php
          } while($filaArea = mysql_fetch_assoc($resultadoArea));
          ?>
          
        </select>
      </div>
      <div class="span-1">
        Remitente:
        <input type="text" name="remitente" id="remitente"   class="campo-sm" style="font-size:12px" required onBlur="aMayusculas(this.value,this.id)">
      </div>
      <div class="span-1">
        Fecha:
        <input type="date" name="fecha" id="fecha"   class="campo-sm" style="font-size:12px" required>
      </div>
      <div class="span-1">
        Destinatario:
        <input type="text" name="destinatario" id="destinatario"   class="campo-sm" style="font-size:12px" required onBlur="aMayusculas(this.value,this.id)">
      </div>
      <div class="span-2">
        Asunto:
        <textarea name="asunto" id="asunto" class="txtarea" style="font-size:12px"  required onBlur="aMayusculas(this.value,this.id)"></textarea>
      </div>
      <div class="span-2">
        Subir Documento:
        <input type="file" name="archivo" id="archivo"   class="campo-sm" style="font-size:12px" required onChange="validarArchivo(this.files,this.id)">
      </div>
    </div>
    <br>
    <div align="center">
      <button type="submit" class="btn btn-rosa btn-sm" name="boton3" id="boton">Grabar</button>
      <div id="espera"></div>
    </div> 
</form>
</div>
<?php 
include('footer.php')
?>