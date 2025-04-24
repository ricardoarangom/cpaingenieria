<?php require_once('../connections/datos.php'); ?>
<?php
$buscaCalsificaciones="SELECT * FROM clasproveedores order by clasificacion";
$resultadoClas = mysql_query($buscaCalsificaciones, $datos) or die(mysql_error());
$row_resultadoClas = mysql_fetch_assoc($resultadoClas);

?>
<?php
include('encabezado.php');
?>
<style>

  .icono{
		cursor: pointer;
		font-size: 20px;
	}

	.icono:hover{
		color:#FF3F3F;
	}
</style>
<?php
include('encabezado1.php');
?>
<br>
<h4 class="Century" align="center">INGRESAR NUEVAS CLASIFICACIONES DE PROVEEDORES</h4>
<br>
<div class="contenedor" style="width: 600px">

  <table class="tablita Arial12" border="1">
    <col width="550px">
    <col width="50px">
    <col>
    <tr class="titulos Arial14">
      <td colspan="2">CLASIFICACION</td>
    </tr>
    <?php
    do{
      ?>
      <tr>
        <td colspan="2"><?php echo $row_resultadoClas['clasificacion'] ?></td>
      </tr>
      <?php
    } while ($row_resultadoClas = mysql_fetch_assoc($resultadoClas));
    ?>
    
    <tr>
      <td>
        <textarea id="clasificacion" class="txtarea" onBlur="aMayusculas(this.value,this.id)"></textarea>
      </td>
      <td align="center" valign="middle">
        <i class="icono icon-disc-floppy-font" onClick="creaClas()"></i>				
      </td>
    </tr>
  </table>

</div>
<script>
  function creaClas(){
    var clasificacion = document.getElementById('clasificacion').value;

    if(clasificacion){

      var datos = new FormData();
      datos.append("clasificacion",clasificacion);
      datos.append("proced",5);		
      
      $.ajax({
            url:"ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
              respuesta = respuesta.replace(/(\r\n|\n|\r)/gm, "");
              console.log(respuesta)
              if(respuesta=='ok'){
                swal({
                      html: '<div class="Arila14">LA CLASIFICACION HA SIDO CREADO CON EXITO</div><br>',
                      type: "success",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                      if (result.value) {
                        location.reload();
                      }
                    });
              }
              
            }
      });

    }else{
      document.getElementById('clasificacion').focus();
      swal({
				text: '¡DEBE ESCRIBIR EL NOMBRE LA NUEVA CLASIFICACION!',
				type: "error",
				confirmButtonText: "¡Cerrar!"                
			});
       
    }
  }
</script>
<?php
include('footer.php');
?>