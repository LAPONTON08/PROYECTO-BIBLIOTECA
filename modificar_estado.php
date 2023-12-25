<?php require_once('Connections/conexionBD.php'); ?>
<?php
mysql_select_db($database_conexionBD, $conexionBD);
$query_estado = "UPDATE  ejeemplar SET  disponibilidad = 'NO DISPONIBLE' WHERE  id_ejemplar =". $_GET['id_ejemplar'];
//echo $query_estado;
$estado = mysql_query($query_estado, $conexionBD) or die(mysql_error());

$updateGoTo = "index.php?menu=9&mensaje=PRESTAMO CON EXITO"; //index.php?menu=10&id_libro=1
  if (isset($_SERVER['QUERY_STRING'])) {
    //$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    //$updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
?>