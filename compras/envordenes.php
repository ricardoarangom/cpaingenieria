<?php 

$ordenes=$_GET['ordenes'];
$arregloOrdenes=explode(",",$ordenes);

foreach($arregloOrdenes as $key=>$j){
	echo 'orcompra-pdf.php?oc='.$j
	?>
	<script>
		var oc =<?php echo $j ?>;
		window.open('orcompra-pdf.php?oc='+oc, '_blank');
	</script>
	<?php
}
?>
<script>
	var oc =<?php echo $j ?>;
	// location.href = 'enviocorrecto.php'
</script>

<?php


