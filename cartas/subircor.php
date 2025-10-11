
<?php 
include('encabezado.php')
?>


<?php 
include('encabezado1.php')
?>
<br>
<div class="contenedor"  style="width:1000px">
  <h5 class="Century" align="center">REGISTRAR CORRESPONDENCIA RECIBIDA</h5>
  <form action="">
    <div class="grid columna-4">    
      <div class="span-1">
        Proyecto / Area:
        <select name="" id="" class="campo-sm" style="font-size:12px">
          <option value="">Seleccione</option>
          <option value=""></option>
        </select>
      </div>
      <div class="span-1">
        Remitente:
        <input type="text" class="campo-sm" style="font-size:12px">
      </div>
      <div class="span-1">
        Fecha:
        <input type="date" class="campo-sm" style="font-size:12px">
      </div>
      <div class="span-1">
        Destinatario:
        <input type="text" class="campo-sm" style="font-size:12px">
      </div>
      <div class="span-2">
        Asunto:
        <textarea name="" id="" class="txtarea" style="font-size:12px" ></textarea>
      </div>
      <div class="span-2">
        Subir Documento:
        <input type="file" class="campo-sm" style="font-size:12px">
      </div>
    </div>
    <br>
    <div align="center">
      <button class="btn btn-rosa btn-sm" >Grabar</button>
    </div> 
</form>
</div>
<?php 
include('footer.php')
?>