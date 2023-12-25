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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_conexionBD, $conexionBD);
$query_alumno = "SELECT * FROM estudiantes";
$alumno = mysql_query($query_alumno, $conexionBD) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

$maxRows_alumno = 10;
$pageNum_alumno = 0;
if (isset($_GET['pageNum_alumno'])) {
  $pageNum_alumno = $_GET['pageNum_alumno'];
}
$startRow_alumno = $pageNum_alumno * $maxRows_alumno;

$colname_alumno = "-1";
if (isset($_POST['textfield'])) {
  $colname_alumno = $_POST['textfield'];
}
$maxRows_alumno = 10;
$pageNum_alumno = 0;
if (isset($_GET['pageNum_alumno'])) {
  $pageNum_alumno = $_GET['pageNum_alumno'];
}
$startRow_alumno = $pageNum_alumno * $maxRows_alumno;

mysql_select_db($database_conexionBD, $conexionBD);
$query_alumno = "SELECT * FROM estudiantes WHERE  doc like '%$colname_alumno%' OR nombre_comp like '%$colname_alumno%'  ORDER BY estudiantes.nombre_comp";

$alumno = mysql_query($query_alumno, $conexionBD) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

if (isset($_GET['totalRows_alumno'])) {
  $totalRows_alumno = $_GET['totalRows_alumno'];
} else {
  $all_alumno = mysql_query($query_alumno);
  $totalRows_alumno = mysql_num_rows($all_alumno);
}
$totalPages_alumno = ceil($totalRows_alumno/$maxRows_alumno)-1;

$queryString_alumno = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_alumno") == false && 
        stristr($param, "totalRows_alumno") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_alumno = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_alumno = sprintf("&totalRows_alumno=%d%s", $totalRows_alumno, $queryString_alumno);
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
open(url,'','top=200,left=700,width=600,height=450') ; 
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
</script>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#f3f3f5" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }//Cambiar color de celda al pasar mouse
</script>


</head>

<body>
<table width="90%" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">ESTUDIANTES</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td width="97%"><form id="form1" name="form1" method="post" action="">
      &nbsp;&nbsp;&nbsp;&nbsp;</h6>
      <input name="textfield" type="text"  id="textfield" size="32" placeholder="Digite documento o Nombre del estudiante "/>
      <input class= "boton" type="submit" name="button" id="button" value="Buscar" />
    </form></td>
  </tr>
</table>
<?php if ($totalRows_alumno!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH>&nbsp;IDENTIFICACI&Oacute;N</tH>
    <tH>&nbsp;NOMBRE</tH>
    <tH>&nbsp;PROGRAMA</tH>
    <tH>&nbsp;SEDE</tH>
    <tH>&nbsp;JORNADA</tH>
    <tH>&nbsp;CORREO</tH>
    <tH>&nbsp;&nbsp;DIRECCI&Oacute;N</tH>
    <tH>&nbsp;TEL&Eacute;FONO</tH>
    <tH>&nbsp;ESTADO</tH>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF" class="texto_tabla" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
      <td >&nbsp;<?php echo $row_alumno['tipo_doc']; ?>.&nbsp;<?php echo $row_alumno['doc']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['nombre_comp']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['programa']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['sede']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['jornada']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['correo']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['direccion']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['telefono']; ?></td>
      <td>&nbsp;<?php echo $row_alumno['estado']; ?></td>
    </tr>
    <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="9">&nbsp;
Registros <?php echo ($startRow_alumno + 1) ?> a <?php echo min($startRow_alumno + $maxRows_alumno, $totalRows_alumno) ?> de <?php echo $totalRows_alumno ?></td>
  </tr>
</table>
<?php }?>
<div align="right"><a href="javascript:document.location.reload();"><img src="images/refresh.png" width="30" height="30" border="0" /></a></div>
</body>
</html>
<?php
mysql_free_result($alumno);
?>
