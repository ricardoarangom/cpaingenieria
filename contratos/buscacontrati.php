<?php
include('encabezado.php')
?>
<script>

  function buscar(valor,mod){
    console.log(valor,mod)

    var datos = new FormData();
		datos.append("valor",valor);
    datos.append("mod",mod);
		datos.append("proced",10);
    
    $.ajax({
      url:"ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        var res = respuesta.trim();
        console.log(res)
        var tabla = res.split(';')
        if(tabla[0]=='ok'){
          var fila = '<table class="tablita Arial14" align="center" border="1">'+
                     '<col width="500px"><col width="100px">'+
                     '<tr class="titulos"><td>CONTRATISTA</td><td></td></tr>';


          var arregloTabla = JSON.parse(tabla[1])
          Object.keys(arregloTabla).forEach(key => {
            console.log(key,arregloTabla[key])
            fila = fila + '<tr><td>'+arregloTabla[key]+'</td>'+
                          '<td><a href="editacontrati.php?id='+key+'" class="btn btn-rosa btn-xs1 btn-block">Consultar/Editar</a></td>'
          })

          fila = fila+'</table>';
          
          console.log(arregloTabla)
          $('#midiv').html(fila)        
        }else{
          $('#midiv').html('<h4 align="center" class="Century">NO HAY REGISTROS QUE CONICIDAN CON LA BUSQUEDA</h4>')
        }
      }
    });
  }

</script>
<?php
include('encabezado1.php')
?>
<div class="contenedor" style="width: 600px" align="center">
  <h4 align="center" class="Century">CONSULTAR O EDITAR PROVEEDORES</h4>
  <div class="grid columna-2" style="width: 500px">
    <div class="span-1">
      Buscar por documento:
      <input type="text" class="campo-sm" onkeyup="buscar(this.value,1)">
    </div>
    <div class="span-1">
      Buscar por nombre:
      <input type="text" class="campo-sm" onkeyup="buscar(this.value,2)">
    </div>
  </div>
  <br>
  <div id="midiv">

  </div>
</div>
<?php
include('footer.php')
?>