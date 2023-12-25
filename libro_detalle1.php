<?php require_once('Connections/conexionBD.php');  mysql_query("SET NAMES 'UTF8'");?>
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
if (isset($_GET['id_libro'])) {
  $colname_libro = $_GET['id_libro'];
}
$colname_libro = "-1";
if (isset($_GET['id_libro'])) {
  $colname_libro = (get_magic_quotes_gpc()) ? $_GET['id_libro'] : addslashes($_GET['id_libro']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_libro = sprintf("SELECT * FROM libro_detalle WHERE id_libro = %s", $colname_libro);
$libro = mysql_query($query_libro, $conexionBD) or die(mysql_error());
$row_libro = mysql_fetch_assoc($libro);
$totalRows_libro = mysql_num_rows($libro);

$colname_Ejemplares = "-1";
if (isset($_GET['id_libro'])) {
  $colname_Ejemplares = $_GET['id_libro'];
}
$colname_Ejemplares = "-1";
if (isset($_GET['id_libro'])) {
  $colname_Ejemplares = (get_magic_quotes_gpc()) ? $_GET['id_libro'] : addslashes($_GET['id_libro']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_Ejemplares = sprintf("SELECT * FROM ejemplar_detalle WHERE id_libro = %s ORDER BY n_ejemplar ASC", $colname_Ejemplares);
$Ejemplares = mysql_query($query_Ejemplares, $conexionBD) or die(mysql_error());
$row_Ejemplares = mysql_fetch_assoc($Ejemplares);
$totalRows_Ejemplares = mysql_num_rows($Ejemplares);

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
}
</style>
<!-- funcion para abrir ventana-->
<script type="text/javascript"> 
function abrir(url) { 
open(url,'','top=200,left=900,width=420,height=450') ; 
} 
</script> 



</head>

<body>
<table width="90%" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">LIBROS</H1></td>
  </tr>
</table>

<table width="90%" border="1"  align="center" cellpadding="2" cellspacing="0" >
  <tr> 
    <th width="14%" >&nbsp;C&Oacute;DIGO:</th>
    <td width="22%" bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['id_libro']); ?></td>
    <th width="17%">&nbsp;AUTOR 1:</th>
    <td width="18%" bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_autor']); ?></td>
    <th width="10%">&nbsp;IDIOMA :</th>
    <td width="19%" bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['idioma']); ?></td>
  </tr>
  <tr>
    <th>&nbsp;ISBN:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['cod_isbn']); ?></td>
    <th>&nbsp;AUTOR 2:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_autor1']); ?></td>
    <th>&nbsp;EDICI&Oacute;N:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['edicion']); ?></td>
  </tr>
  <tr>
    <th>&nbsp;NOMBRE: </th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_libro']); ?></td>
    <th>&nbsp;AUTOR 3:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_autor2']); ?></td>
    <th>&nbsp;LUGAR :</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['lugar']); ?></td>
  </tr>
  <tr>
    <th>&nbsp;EDITORIAL:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_editorial']); ?></td>
    <th>&nbsp;AUTOR 4:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_autor3']); ?></td>
    <th>&nbsp;A&Ntilde;O:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['anio']); ?></td>
  </tr>
  <tr>
    <th>&nbsp;TEMA:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['tema']); ?></td>
    <th>&nbsp;AUTOR 5:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_autor4']); ?></td>
    <th>&nbsp;AREA:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_area']); ?></td>
  </tr>
  <tr>
    <th>&nbsp;N&deg; DE P&Aacute;GINAS:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_libro['n_paginas']); ?></td>
    <th>&nbsp;SIGNATURA TOPOGRÁFICA:</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['signatura_top']); ?></td>
    <th> &nbsp;RECURSO :</th>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_recurso']); ?></td>
  </tr>
  <tr>
    <th>&nbsp;COLECCI&Oacute;N: </th>
    <td colspan="5" bgcolor="#FFFFFF">&nbsp;<?php echo strtoupper ($row_libro['nombre_coleccion']); ?>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="90%" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><h1 class="titulos">EJEMPLARES</h1></td>
  </tr>
</table>
<table width="90%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <th >&nbsp;C&Oacute;DIGO </th>
    <th >N&deg; EJEMPLAR</th>
    <th >&nbsp;C&Oacute;DIGO UTS</th>
    <th >&nbsp;C&Oacute;DIGO RB</th>
    <th >&nbsp;UBICACI&Oacute;N</th>
    <th >&nbsp;ESTADO</th>
    <th >&nbsp;ADQUISICI&Oacute;N</th>
    <th >&nbsp;FECHA ADQUISICI&Oacute;N</th>
    <th colspan="2" >&nbsp;DISPONIBILIDAD</th>
    <th ><div align="center"><a href="javascript:abrir('/biblioteca/ejemplares_nuevo.php?id_libro=<?php echo $row_libro['id_libro']; ?>')"><img src="images/add2-.png" width="20" height="20" border="0" /></a></div>
    </div></th>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['id_ejemplar']); ?></td>
      <td>&nbsp;<?php echo $row_Ejemplares['n_ejemplar']; ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['cod_uts']); ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['cod_rb']); ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['descripcion']); ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['estado']); ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['nombre_adquisicion']); ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_Ejemplares['fecha_adquisicion']); ?></td>
      <td>&nbsp;<?php echo $row_Ejemplares['disponibilidad']; ?></td>
      <td><?php if ($row_Ejemplares['disponibilidad']=='0') {  ?>
	  <a href="index.php?id_ejemplar=<?php echo $row_Ejemplares['id_ejemplar']; ?>&amp;id_libro=<?php echo $row_libro['id_libro']; ?>&amp;menu=11;" >&nbsp;Prestar</a> <?php   } else {  echo "PRESTADO" ;}?></td>
      <td><div align="center"><a href="javascript:abrir('/biblioteca/ejemplares_actualizar.php?id_ejemplar=<?php echo $row_Ejemplares['id_ejemplar']; ?>')"><img src="images/edit.png" width="20" height="20" /></a></div></td>
    </tr>
    <?php } while ($row_Ejemplares = mysql_fetch_assoc($Ejemplares)); ?>
</table>
<p align="center"><a href="index.php?menu=9"><img src="images/Volver.png" width="40" height="40" /></a></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($libro);

mysql_free_result($Ejemplares);
?>
