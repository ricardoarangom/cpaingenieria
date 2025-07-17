<?php 
require_once('../connections/datos.php');

  
if(isset($_POST['boton1'])){
  echo 'hola';

  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  $inserta="INSERT INTO borrclausulas (clausula) VALUES('".$_POST['texto']."')";
  if ($results=@mysql_query($graba)){

  }
}
?>