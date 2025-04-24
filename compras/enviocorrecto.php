<?php require('../connections/datos.php');?>
<?php
include('encabezado.php');
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div class="container" align="center">
  <script>
        swal({
						text:'¡LOS CORREOS FUERON ENVIADOS CORRECTAMENTE!',
//            title: "",
            type: "success",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
//              document.location.replace ('enviocorrecto.php')
            }
          });
  </script>
</div>
</div>
<?php 
	mysql_close($datos);

include('footer.php')
?>


</body>
</html>