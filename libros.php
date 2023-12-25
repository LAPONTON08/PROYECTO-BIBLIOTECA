<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'");
?>
<?php header ('Content-Type: text/html; charset=utf-8');
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_libro = 10;
$pageNum_libro = 0;
if (isset($_GET['pageNum_libro'])) {
  $pageNum_libro = $_GET['pageNum_libro'];
}
$startRow_libro = $pageNum_libro * $maxRows_libro;

$colname_libro = "-1";
if (isset($_POST['textfield'])) {
  $colname_libro = $_POST['textfield'];
}
$maxRows_libro = 1;
$pageNum_libro = 0;
if (isset($_GET['pageNum_libro'])) {
  $pageNum_libro = $_GET['pageNum_libro'];
}
$startRow_libro = $pageNum_libro * $maxRows_libro;

mysql_select_db($database_conexionBD, $conexionBD);
$query_libro = "SELECT * FROM libro_detalle ORDER BY id_libro ASC";
$query_limit_libro = sprintf("%s LIMIT %d, %d", $query_libro, $startRow_libro, $maxRows_libro);
$libro = mysql_query($query_limit_libro, $conexionBD) or die(mysql_error());
$row_libro = mysql_fetch_assoc($libro);

if (isset($_GET['totalRows_libro'])) {
  $totalRows_libro = $_GET['totalRows_libro'];
} else {
  $all_libro = mysql_query($query_libro);
  $totalRows_libro = mysql_num_rows($all_libro);
}
$totalPages_libro = ceil($totalRows_libro/$maxRows_libro)-1;

$colname_Libro_detalle = "-1";
if (isset($_POST['textfield'])) {
  $colname_Libro_detalle = (get_magic_quotes_gpc()) ? $_POST['textfield'] : addslashes($_POST['textfield']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_Libro_detalle = ("SELECT * FROM libro_detalle WHERE nombre_libro like '%$colname_Libro_detalle%' OR nombre_autor1 like '%$colname_Libro_detalle%' OR nombre_editorial like '%$colname_Libro_detalle%' ORDER BY id_libro ASC");
$Libro_detalle = mysql_query($query_Libro_detalle, $conexionBD) or die(mysql_error());
$row_Libro_detalle = mysql_fetch_assoc($Libro_detalle);
$totalRows_Libro_detalle = mysql_num_rows($Libro_detalle);

$queryString_libro = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_libro") == false && 
        stristr($param, "totalRows_libro") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_libro = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_libro = sprintf("&totalRows_libro=%d%s", $totalRows_libro, $queryString_libro);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biblio-UTS</title>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />

<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding-top: 2px;
}
</style>
<!-- funcion para abrir ventana-->
<script> 
function abrir(url) { 
open(url,'','top=200,left=900,width=1000,height=550') ; 
} 
</script>
 <script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#f3f3f5" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }//Cambiar color de celda al pasar mouse
</script>



 </head>

<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">LIBROS</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td><form id="form1" name="form1" method="post" action="">
&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="textfield" type="text"  id="textfield" size="32" placeholder="Digite nombre del Libro, Autor, Editorial" />
      <input class="boton" type="submit" name="button" id="button" value="Buscar" />
    </form></td>
    <td width="3%"><div align="center"><span class="texto_tabla"><span class="Nuevo_registro"><a href="javascript:abrir('/biblioteca/libros_nuevo.php')"><img src="images/add2-.png" width="30" height="30" border="0" /></a></span></span></div></td>
  </tr>
</table>
<?php if ($totalRows_Libro_detalle!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH>&nbsp;C&Oacute;DIGO</tH>
    <tH>&nbsp;NOMBRE</tH>
    <tH>&nbsp;AUTOR</tH>
    <tH>&nbsp;RECURSO</tH>
    <tH>&nbsp;EDITORIAL</tH>
    <tH>&nbsp;AREA</tH>
    <tH>&nbsp;EDICI&Oacute;N</tH>
    <tH colspan="2"><div align="center"></div></tH>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF" class="texto_tabla" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"

 >
      <td class="texto_tabla">&nbsp;<?php echo $row_Libro_detalle['id_libro']; ?></td>
      <td>&nbsp;<?php echo $row_Libro_detalle['nombre_libro']; ?></td>
      <td>&nbsp;<?php echo $row_Libro_detalle['nombre_autor1']; ?></td>
      <td>&nbsp;<?php echo $row_Libro_detalle['nombre_recurso']; ?></td>
      <td>&nbsp;<?php echo $row_Libro_detalle['nombre_editorial']; ?></td>
      <td>&nbsp;<?php echo $row_Libro_detalle['nombre_area']; ?></td>
      <td>&nbsp;<?php echo $row_Libro_detalle['edicion']; ?></td>
      <td width="3%" align="right" valign="middle" class="texto_tabla"><div align="center"><a href="index.php?menu=10&amp;id_libro=<?php echo $row_Libro_detalle['id_libro']; ?>"><img src="images/mm_detalle.png" width="20" height="20" /></a></div></td>
      <td width="3%" align="right" valign="middle" class="texto_tabla"><div align="center"><a href="javascript:abrir('/biblioteca/libros_actualizar.php?id_libro=<?php echo $row_Libro_detalle['id_libro']; ?>')"><img src="images/edit.png" width="20" height="20" /></a></div></td>
    </tr>
    <?php } while ($row_Libro_detalle = mysql_fetch_assoc($Libro_detalle)); ?>
<tr bgcolor="#FFFFFF">
    <td colspan="9">&nbsp;
Registros <?php echo ($startRow_libro + 1) ?> a <?php echo min($startRow_libro + $maxRows_libro, $totalRows_libro) ?> de <?php echo $totalRows_libro ?> </td>
  </tr>
</table>
<?php }?>
<div align="right"><a href="javascript:document.location.reload();"><img src="images/refresh.png" width="40" height="40" border="0" /></a></div>
</body>
</html>
<?php
mysql_free_result($libro);

mysql_free_result($Libro_detalle);
?>
