<?php require_once('Connections/conexionBD.php');  mysql_query("SET NAMES 'UTF8'");?>
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

$maxRows_autores = 10;
$pageNum_autores = 0;
if (isset($_GET['pageNum_autores'])) {
  $pageNum_autores = $_GET['pageNum_autores'];
}
$startRow_autores = $pageNum_autores * $maxRows_autores;

mysql_select_db($database_conexionBD, $conexionBD);
$query_autores = "SELECT * FROM autor ORDER BY nombre_autor ASC";
$query_limit_autores = sprintf("%s LIMIT %d, %d", $query_autores, $startRow_autores, $maxRows_autores);
$autores = mysql_query($query_limit_autores, $conexionBD) or die(mysql_error());
$row_autores = mysql_fetch_assoc($autores);

if (isset($_GET['totalRows_autores'])) {
  $totalRows_autores = $_GET['totalRows_autores'];
} else {
  $all_autores = mysql_query($query_autores);
  $totalRows_autores = mysql_num_rows($all_autores);

$totalPages_autores = ceil($totalRows_autores/$maxRows_autores) -10;
$pageNum_autores = 0;
}
if (isset($_GET['pageNum_autores'])) {
  $pageNum_autores = $_GET['pageNum_autores'];
}
$startRow_autores = $pageNum_autores * $maxRows_autores;

$maxRows_autores = 10;
$pageNum_autores = 0;
if (isset($_GET['pageNum_autores'])) {
  $pageNum_autores = $_GET['pageNum_autores'];
}
$startRow_autores = $pageNum_autores * $maxRows_autores;
$colname_autores = "-1";
if (isset($_POST['textfield'])) {
  $colname_autores = $_POST['textfield'];
  }

mysql_select_db($database_conexionBD, $conexionBD);
$query_autores = "SELECT * FROM autor, nacionalidad WHERE autor.nacionalidad=nacionalidad.id_nacionalidad  AND nombre_autor like '%$colname_autores%'  ORDER BY nombre_autor ASC";
$query_limit_autores = sprintf("%s LIMIT %d, %d", $query_autores, $startRow_autores, $maxRows_autores);
$autores = mysql_query($query_limit_autores, $conexionBD) or die(mysql_error());
$row_autores = mysql_fetch_assoc($autores);

if (isset($_GET['totalRows_autores'])) {
  $totalRows_autores = $_GET['totalRows_autores'];
} else {
  $all_autores = mysql_query($query_autores);
  $totalRows_autores = mysql_num_rows($all_autores);
}


$queryString_autores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_autores") == false && 
        stristr($param, "totalRows_autores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_autores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_autores = sprintf("&totalRows_autores=%d%s", $totalRows_autores, $queryString_autores);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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
open(url,'','top=200,left=900,width=450,height=220') ; 
} 
</script> 
<script>
function confirmacion(){
var answer=confirm("¿Desea eliminar el registro?")
if (answer) {
alert("Registro eliminado")
window.location="editoriales_eliminar.php"
}
else {
alert("Cancelado")}
}
</script>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#f3f3f5" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }//Cambiar color de celda al pasar mouse
</script>



</head>

<body>
<table width="90%" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos"> AUTORES</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td width="97%"><form id="form1" name="form1" method="post" action="">
&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="textfield" type="text"  id="textfield" size="32" placeholder="Digite nombre del Autor"/>
      <input class="boton" type="submit" name="button" id="button" value="Buscar" />
    </form></td>
    <td width="3%"><div align="center"><span class="texto_tabla"><span class="Nuevo_registro"><a href="javascript:abrir('/biblioteca/autores_nuevo.php')"><img src="images/add2-.png" width="30" height="30" /></a></span></span></div></td>
  </tr>
</table>
<?php if ($totalRows_autores!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH width="7%">&nbsp;CODIGO</tH>
    <tH width="22%">&nbsp;NOMBRE</tH>
    <tH>&nbsp;NACIONALIDAD</tH>
    <tH>&nbsp;</tH>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF" class="texto_tabla" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
      <td class="codigo"><?php echo $row_autores['id_autor']; ?></td>
      <td>&nbsp; <?php echo strtoupper($row_autores['nombre_autor']); ?></td>
      <td width="65%">&nbsp;<?php echo strtoupper ($row_autores['nombre_nacionalidad']); ?></td>
      <td width="3%" align="right" valign="middle" class="texto_tabla"><div align="center"><a href="javascript:abrir('/biblioteca/autores_actualizar.php?id_autor=<?php echo $row_autores['id_autor']; ?>')"><img src="images/edit.png" width="20" height="20" /></a></div></td>
    </tr>
    <?php } while ($row_autores = mysql_fetch_assoc($autores)); ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="4"> Registros <?php echo ($startRow_autores + 1) ?> a <?php echo min($startRow_autores + $maxRows_autores, $totalRows_autores) ?> de <?php echo $totalRows_autores ?></td>
  </tr>
</table>
<?php }?>
<div align="right"><a href="javascript:document.location.reload();"><img src="images/refresh.png" width="40" height="40" border="0" /></a></div>
</body>
</html>
<?php
mysql_free_result($autores);
?>
