<?php require('../connections/datos.php');?>
 
<?php
include('encabezado.php')
?> 

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<div>
  <br><br>
  <h4 align="center" >PROCESO DE COMPRAS</h4>
  <div align="center" class="container">
    <br>
    <p><img src="../imagenes/logofa.png" class="img-fluid" alt="Responsive image" width="400" /></p>	
    </div>
</div>	 

</div>

<?php 
	mysql_close($datos);
?>
<?php 
include('footer.php')
?>
</body>
</html>