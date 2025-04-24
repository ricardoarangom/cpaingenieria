<?php require_once('../connections/datos.php')?>
<?php 
include('encabezado.php')
?>

<?php 
include('encabezado1.php');	
?>
<div>
<br>
<?php 
	
$ordenc=$_GET['orden'];
	
	
if(isset($_GET['boton'])){
  //echo "hola";
  $graba1="UPDATE ordencompra SET fcierre='".date("Y-m-d")."', fautorizado='".date("Y-m-d")."', comprado='".date("Y-m-d")."', recibido='".date("Y-m-d")."', derogada=1, autorizada=0, observaciones='SOLICITUD ANULADA' WHERE IdOrdencompra=".$ordenc."";
//	echo $graba1;
  if ($results=@mysql_query($graba1)){
    $graba2="UPDATE itemoc SET cotizado='".date("Y-m-d")."', autorizado='".date("Y-m-d")."', comprado='".date("Y-m-d")."', entregado='".date("Y-m-d")."', observaciones='SOLICITUD ANULADA', derogada=1 WHERE IdOrdencompra=".$ordenc."";
    if ($results=@mysql_query($graba2)){

    }
    echo "<div class='container Arial14R'>";
    echo "<div><strong>SE ANULO LA SOLICITUD DE COMPRA No. ".$ordenc."</strong> </div>";
    echo "</div><br>";

  }else{
    echo "no grabo";
  }
   
}else{
?>  
<h4 align="center" class="Century">ESTA SEGURO DE ANULAR LA SOLICITUD?</h4>
<br>
<div class="contenedor" style="width: 200px">
  <div class="grid columna-3">
    <div class="span-1">
			<form action="anularsc.php" method="get">
        <input type="hidden" name="orden" value="<?php echo $ordenc ?>" />
        <button type="submit" name="boton" class="btn btn-inv-danger btn-block  Arial18"><strong>SI</strong></button>
      </form>
		</div>
    <div class="span-1">
		
		</div>
    <div class="span-1">
			<form action="cotizar2.php" method="get">
        <input type="hidden" name="orden" value="<?php echo $ordenc ?>" />
        <button type="submit" name="boton" class="btn btn-inv-primary btn-block  Arial18"><strong>NO</strong></button>
			</form>
		</div>
  </div>
</div>
<table width="300" border="0" align="center">
  <tr>
    <td align="center">
      
    <td align="center">
      
      </td>
    </tr>
</table>   
<?php
}
  
?>

</div>

<?php 
	mysql_close($datos);

include('footer.php')
?>



</body>
</html>